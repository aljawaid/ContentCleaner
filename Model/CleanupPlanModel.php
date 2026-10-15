<?php

namespace Kanboard\Plugin\ContentCleaner\Model;

use Kanboard\Core\Base;

/**
 * Build and execute cleanup plans from the reviewed plugin artefact catalogue.
 *
 * The browser selects opaque candidate tokens; database identifiers are always
 * resolved again from trusted server-side configuration before execution.
 *
 * Related controllers: Controller/CleaningController.php and
 * Controller/PluginCleaningController.php.
 * Related test: tests/cleanup_plan_integration.php.
 *
 * @package Plugin\ContentCleaner\Model
 */
class CleanupPlanModel extends Base
{
    /**
     * Build the current allowlisted plan for uninstalled plugins only.
     *
     * @return array
     */
    public function buildPlan()
    {
        $plan = array();
        $currentTables = $this->applicationCleaningModel->getTables();
        $coreTables = $this->helper->defaultTableHelper->getDefaultTables();
        $installedPlugins = $this->getInstalledPluginNames();

        foreach ($this->getValidatedDefinitions() as $definition) {
            if ($this->isInstalled($definition, $installedPlugins)) {
                continue;
            }

            foreach ($definition['plugin_tables'] as $table) {
                if (
                    in_array($table, $currentTables, true)
                    && !in_array($table, $coreTables, true)
                ) {
                    $this->addCandidate($plan, array(
                        'type' => 'table',
                        'plugin_name' => $definition['plugin_name'],
                        'plugin_title' => $definition['plugin_title'],
                        'table' => $table,
                    ));
                }
            }

            foreach ($definition['core_table_columns'] as $table => $columns) {
                if (!in_array($table, $currentTables, true)) {
                    continue;
                }

                $currentColumns = $this->applicationCleaningModel->getColumns($table);
                foreach ($columns as $column) {
                    if (in_array($column, $currentColumns, true)) {
                        $this->addCandidate($plan, array(
                            'type' => 'column',
                            'plugin_name' => $definition['plugin_name'],
                            'plugin_title' => $definition['plugin_title'],
                            'table' => $table,
                            'column' => $column,
                        ));
                    }
                }
            }

            foreach ($definition['core_table_entries'] as $entry) {
                if (
                    in_array($entry['table'], $currentTables, true)
                    && $this->db->table($entry['table'])->eq($entry['column'], $entry['value'])->exists()
                ) {
                    $this->addCandidate($plan, array(
                        'type' => 'entry',
                        'plugin_name' => $definition['plugin_name'],
                        'plugin_title' => $definition['plugin_title'],
                        'table' => $entry['table'],
                        'column' => $entry['column'],
                        'value' => $entry['value'],
                    ));
                }
            }

            if ($this->db->table('plugin_schema_versions')->eq('plugin', $definition['plugin_name'])->exists()) {
                $this->addCandidate($plan, array(
                    'type' => 'schema',
                    'plugin_name' => $definition['plugin_name'],
                    'plugin_title' => $definition['plugin_title'],
                ));
            }
        }

        return $plan;
    }

    /**
     * Resolve one candidate from a freshly generated plan.
     *
     * @return array
     */
    public function getCandidate($token, $requiredType = '')
    {
        $plan = $this->buildPlan();
        if (!is_string($token) || !isset($plan[$token])) {
            throw new \InvalidArgumentException('The cleanup selection is no longer available');
        }

        if ($requiredType !== '' && $plan[$token]['type'] !== $requiredType) {
            throw new \InvalidArgumentException('The cleanup selection has the wrong operation type');
        }

        return $plan[$token];
    }

    /**
     * Execute selected candidates after resolving them against the current plan.
     *
     * DDL cannot be made atomic on every supported database, so execution stops
     * after the first failure and returns an explicit partial-result summary.
     *
     * @return array
     */
    public function executeSelection(array $tokens, array $allowedTypes)
    {
        $plan = $this->buildPlan();
        $selected = array();

        foreach (array_values(array_unique($tokens)) as $token) {
            if (!is_string($token) || !isset($plan[$token])) {
                throw new \InvalidArgumentException('The cleanup selection is no longer available');
            }

            if (!in_array($plan[$token]['type'], $allowedTypes, true)) {
                throw new \InvalidArgumentException('The cleanup selection has the wrong operation type');
            }

            $selected[] = $plan[$token];
        }

        $priority = array('entry' => 10, 'column' => 20, 'table' => 30, 'schema' => 40);
        usort($selected, function (array $left, array $right) use ($priority) {
            return $priority[$left['type']] <=> $priority[$right['type']];
        });

        $result = array(
            'requested' => count($selected),
            'completed' => 0,
            'failed' => null,
        );

        foreach ($selected as $candidate) {
            try {
                if (!$this->executeCandidate($candidate)) {
                    $result['failed'] = $candidate;
                    break;
                }
                ++$result['completed'];
            } catch (\Throwable $exception) {
                $result['failed'] = $candidate;
                break;
            }
        }

        return $result;
    }

    /**
     * Return only candidates matching one artefact type.
     */
    public function filterByType(array $plan, $type)
    {
        return array_filter($plan, function (array $candidate) use ($type) {
            return $candidate['type'] === $type;
        });
    }

    /**
     * Return column candidates for one validated core table.
     */
    public function getColumnCandidates($table)
    {
        $this->assertIdentifier($table);

        return array_filter($this->buildPlan(), function (array $candidate) use ($table) {
            return $candidate['type'] === 'column' && $candidate['table'] === $table;
        });
    }

    /**
     * Return current candidates and installation state for one catalogue entry.
     */
    public function getPluginCleanup($pluginName)
    {
        foreach ($this->getValidatedDefinitions() as $definition) {
            if ($definition['plugin_name'] === $pluginName) {
                $definition['installed'] = $this->isInstalled($definition, $this->getInstalledPluginNames());
                $definition['candidates'] = array_filter($this->buildPlan(), function (array $candidate) use ($pluginName) {
                    return $candidate['plugin_name'] === $pluginName;
                });
                $definition['available_types'] = array_values(array_unique(array_map(function (array $candidate) {
                    return $candidate['type'];
                }, $definition['candidates'])));
                return $definition;
            }
        }

        throw new \InvalidArgumentException('Unknown cleanup catalogue entry');
    }

    /**
     * Execute every current candidate of selected types for one uninstalled plugin.
     */
    public function executePluginCleanup($pluginName, array $allowedTypes)
    {
        $cleanup = $this->getPluginCleanup($pluginName);
        if ($cleanup['installed']) {
            throw new \DomainException('Installed plugins cannot be cleaned');
        }

        $tokens = array();
        foreach ($cleanup['candidates'] as $token => $candidate) {
            if (in_array($candidate['type'], $allowedTypes, true)) {
                $tokens[] = $token;
            }
        }

        return $this->executeSelection($tokens, $allowedTypes);
    }

    private function executeCandidate(array $candidate)
    {
        switch ($candidate['type']) {
            case 'table':
                return (bool) $this->applicationCleaningModel->delete($candidate['table']);
            case 'column':
                return (bool) $this->applicationCleaningModel->deleteColumn($candidate['table'], $candidate['column']);
            case 'entry':
                return (bool) $this->applicationCleaningModel->deleteCoreTableEntries(
                    $candidate['table'],
                    $candidate['column'],
                    $candidate['value']
                );
            case 'schema':
                return (bool) $this->pluginCleaningModel->deletePluginSchemaEntry($candidate['plugin_name']);
            default:
                return false;
        }
    }

    private function addCandidate(array &$plan, array $candidate)
    {
        $token = hash('sha256', json_encode($candidate));
        $candidate['token'] = $token;
        $plan[$token] = $candidate;
    }

    private function getValidatedDefinitions()
    {
        $definitions = array();

        foreach ($this->helper->pluginCleaningHelper->getDeletablePlugins() as $definition) {
            if (!is_array($definition)) {
                continue;
            }

            foreach (array('job_number', 'plugin_name', 'plugin_title', 'plugin_folder_name') as $requiredKey) {
                if (!isset($definition[$requiredKey]) || !is_string($definition[$requiredKey])) {
                    throw new \UnexpectedValueException('Invalid cleanup catalogue entry');
                }
            }

            $this->assertIdentifier($definition['plugin_name']);
            $this->assertIdentifier($definition['plugin_folder_name']);
            if (preg_match('/\A[0-9]{2}\z/D', $definition['job_number']) !== 1) {
                throw new \UnexpectedValueException('Invalid cleanup catalogue job number');
            }

            $validated = $definition;
            $validated['plugin_tables'] = array();
            foreach (isset($definition['plugin_tables']) ? $definition['plugin_tables'] : array() as $table) {
                $this->assertIdentifier($table);
                $validated['plugin_tables'][] = $table;
            }

            $validated['core_table_columns'] = array();
            foreach (isset($definition['core_table_columns']) ? $definition['core_table_columns'] : array() as $tableGroup) {
                foreach ($tableGroup as $table => $columns) {
                    $this->assertIdentifier($table);
                    $validated['core_table_columns'][$table] = array();
                    foreach ($columns as $column) {
                        $this->assertIdentifier($column);
                        $validated['core_table_columns'][$table][] = $column;
                    }
                }
            }

            $validated['core_table_entries'] = array();
            foreach (isset($definition['core_table_entries']) ? $definition['core_table_entries'] : array() as $tableGroup) {
                foreach ($tableGroup as $table => $entry) {
                    $this->assertIdentifier($table);
                    foreach ($entry as $column => $value) {
                        $this->assertIdentifier($column);
                        if (!is_scalar($value) && $value !== null) {
                            throw new \UnexpectedValueException('Invalid cleanup catalogue entry value');
                        }
                        $validated['core_table_entries'][] = array(
                            'table' => $table,
                            'column' => $column,
                            'value' => $value,
                        );
                    }
                }
            }

            $definitions[] = $validated;
        }

        return $definitions;
    }

    private function getInstalledPluginNames()
    {
        $installed = array();

        foreach ($this->pluginLoader->getPlugins() as $folder => $plugin) {
            $installed[] = strtolower($folder);
            $installed[] = strtolower($plugin->getPluginName());
        }

        foreach ($this->pluginLoader->getIncompatiblePlugins() as $folder => $plugin) {
            $installed[] = strtolower($folder);
            $installed[] = strtolower($plugin->getPluginName());
        }

        if (is_dir(PLUGINS_DIR)) {
            foreach (new \DirectoryIterator(PLUGINS_DIR) as $fileInfo) {
                if ($fileInfo->isDir() && !$fileInfo->isDot() && substr($fileInfo->getFilename(), 0, 1) !== '.') {
                    $installed[] = strtolower($fileInfo->getFilename());
                }
            }
        }

        return array_unique($installed);
    }

    private function isInstalled(array $definition, array $installedPlugins)
    {
        return in_array(strtolower($definition['plugin_name']), $installedPlugins, true)
            || in_array(strtolower($definition['plugin_folder_name']), $installedPlugins, true);
    }

    private function assertIdentifier($identifier)
    {
        if (!is_string($identifier) || preg_match('/\A[A-Za-z_][A-Za-z0-9_]*\z/D', $identifier) !== 1) {
            throw new \UnexpectedValueException('Invalid identifier in cleanup catalogue');
        }
    }
}
