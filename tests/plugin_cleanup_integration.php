<?php

/**
 * Whole-plugin and targeted cleanup integration tests for ContentCleaner.
 *
 * Related files: Model/CleanupPlanModel.php, Model/PluginCleaningModel.php,
 * Controller/PluginCleaningController.php and
 * Template/cleaning-jobs/plugin-clean.php.
 */

$kanboardRoot = getenv('KANBOARD_ROOT');
if ($kanboardRoot === false || !is_file($kanboardRoot . '/app/common.php')) {
    fwrite(STDERR, 'Set KANBOARD_ROOT to a Kanboard 1.2.54 checkout.' . PHP_EOL);
    exit(1);
}

define('PLUGINS_DIR', $kanboardRoot . '/plugins');
define('DB_FILENAME', $kanboardRoot . '/data/content-cleaner-plugin-integration.sqlite');

require $kanboardRoot . '/app/common.php';

$failures = array();
$db = $container['db'];
$applicationModel = $container['applicationCleaningModel'];
$planModel = $container['cleanupPlanModel'];

foreach (array('hourly_rates', 'budget_lines') as $table) {
    $db->execute('CREATE TABLE IF NOT EXISTS "' . $table . '" ("id" INTEGER PRIMARY KEY)');
}

$currencyColumns = $applicationModel->getColumns('currencies');
foreach (array('last_modified' => 'INTEGER', 'comment' => 'TEXT', 'live_rate' => 'REAL', 'live_rate_updated' => 'INTEGER') as $column => $type) {
    if (!in_array($column, $currencyColumns, true)) {
        $db->execute('ALTER TABLE "currencies" ADD COLUMN "' . $column . '" ' . $type);
    }
}

if (!$db->table('plugin_schema_versions')->eq('plugin', 'costcontrol')->exists()) {
    $db->table('plugin_schema_versions')->insert(array('plugin' => 'costcontrol', 'version' => 1));
}

$costControl = $planModel->getPluginCleanup('costcontrol');
if ($costControl['installed']) {
    $failures[] = 'The test fixture unexpectedly detected CostControl as installed.';
}

$result = $planModel->executePluginCleanup('costcontrol', array('entry', 'column', 'table', 'schema'));
if ($result['requested'] !== 7 || $result['completed'] !== 7 || $result['failed'] !== null) {
    $failures[] = 'Whole-plugin cleanup did not complete every reviewed CostControl artefact.';
}

foreach (array('hourly_rates', 'budget_lines') as $table) {
    if (in_array($table, $applicationModel->getTables(), true)) {
        $failures[] = 'Whole-plugin cleanup left a plugin table behind: ' . $table;
    }
}

$currencyColumns = $applicationModel->getColumns('currencies');
foreach (array('last_modified', 'comment', 'live_rate', 'live_rate_updated') as $column) {
    if (in_array($column, $currencyColumns, true)) {
        $failures[] = 'Whole-plugin cleanup left a core column behind: ' . $column;
    }
}

if ($db->table('plugin_schema_versions')->eq('plugin', 'costcontrol')->exists()) {
    $failures[] = 'Whole-plugin cleanup left the plugin registration behind.';
}

$db->table('settings')->insert(array('option' => 'persistEditions', 'value' => '1'));
$entryResult = $planModel->executePluginCleanup('wiki', array('entry'));
if ($entryResult['completed'] !== 1 || $db->table('settings')->eq('option', 'persistEditions')->exists()) {
    $failures[] = 'Targeted core-entry cleanup did not remove the reviewed Wiki setting.';
}

try {
    $planModel->executePluginCleanup('not_in_catalogue', array('table'));
    $failures[] = 'An unknown plugin cleanup job was accepted.';
} catch (InvalidArgumentException $exception) {
    // Only exact server-side catalogue entries can become cleanup jobs.
}

$unloadablePluginPath = PLUGINS_DIR . '/DefinitionOfDone';
$createdUnloadablePluginFixture = false;
if (is_dir($unloadablePluginPath)) {
    $failures[] = 'The unloadable installed-plugin fixture path already exists.';
} elseif (!mkdir($unloadablePluginPath)) {
    $failures[] = 'The unloadable installed-plugin fixture could not be created.';
} else {
    $createdUnloadablePluginFixture = true;
    try {
        $unloadableCleanup = $planModel->getPluginCleanup('definitionofdone');
        if (!$unloadableCleanup['installed']) {
            $failures[] = 'A present but unloadable plugin folder was treated as uninstalled.';
        }

        try {
            $planModel->executePluginCleanup('definitionofdone', array('table'));
            $failures[] = 'A present but unloadable plugin was accepted for cleanup.';
        } catch (DomainException $exception) {
            // A physical plugin directory must block cleanup even when its class cannot load.
        }
    } finally {
        if ($createdUnloadablePluginFixture) {
            rmdir($unloadablePluginPath);
        }
    }
}

if ($failures !== array()) {
    fwrite(STDERR, implode(PHP_EOL, $failures) . PHP_EOL);
    exit(1);
}

echo 'Plugin cleanup integration tests passed.' . PHP_EOL;
