<?php

namespace Kanboard\Plugin\ContentCleaner\Helper;

use Kanboard\Plugin\ContentCleaner\Model\ApplicationCleaningModel;
use Kanboard\Core\Base;

/**
 * Plugin ContentCleaner
 * Class DefaultTableHelper
 *
 * @package  Plugin\ContentCleaner\Helper
 * @author   creecros Craig Crosby
 */
class DefaultTableHelper extends Base
{
    /**
     * Get Default Tables
     *
     * @see     getSchema()
     * @author  creecros Craig Crosby
     */
    public function getDefaultTables()
    {
        $file = $this->getSchema();
        $tables = array();
        $sql = file_get_contents($file);

        // Extract table names
        preg_match_all("/CREATE\s+TABLE\s+`?(\w+)`?/i", $sql, $matches);
        $tables = $matches[1];

        // Extract renamed table names
        switch (DB_DRIVER) { // For now, I am switching everything to reading the Mysql.php file.
            /*Case 'sqlite':
                preg_match_all("/ALTER\s+TABLE\s+`?(\w+)`?\s+RENAME\s+TO\s+`?(\w+)`?/i", $sql, $matches);
                break;*/
            case 'mysql':
                preg_match_all("/RENAME\s+TABLE\s+(\w+)\s+TO\s+(\w+)/i", $sql, $matches);
                break;
            default:
                preg_match_all("/RENAME\s+TABLE\s+(\w+)\s+TO\s+(\w+)/i", $sql, $matches);
                break;
        }

        foreach ($matches[1] as $i => $old_table) {
            $new_table = $matches[2][$i];
            // Update the table name in the $tables array
            $key = array_search($old_table, $tables);
            if ($key !== false) {
                $tables[$key] = $new_table;
            }
        }

        // Extract Dropped Table Names
        preg_match_all("/DROP\s+TABLE\s+`?(\w+)`?/i", $sql, $matches);
        foreach ($matches[1] as $table) {
            // Remove table names from the $tables array
            $key = array_search($table, $tables);
            if ($key !== false) {
                unset($tables[$key]);
            }
        }

        $current_tables = $this->applicationCleaningModel->getTables();

        foreach ($tables as $key => $table) {
            if (!in_array($table, $current_tables)) {
                // Update the table name to a new value
                $new_table_name = ($this->wasRenamedTo($table) !== false) ? $this->wasRenamedTo($table) : $table;
                $tables[$key] = $new_table_name;
            }
        }

        if (DB_DRIVER == 'mysql' || DB_DRIVER == 'postgres') {
            array_push($tables, 'schema_version');
        }

        sort($tables);

        return $tables;
    }

    public function getDefaultColumnsForTable($table_name)
    {
        $check_back = false;
        $old_table_name = $table_name;
        $file = $this->getSchema();
        $sql = file_get_contents($file);

        if ($this->wasRenamedFrom($table_name) !== false && $this->wasRenamedTo($table_name) == false) {
            $table_name = $this->wasRenamedFrom($table_name);
        } elseif ($this->wasRenamedTo($table_name) !== false && $this->wasRenamedFrom($this->wasRenamedTo($table_name)) !== false) {
            $old_table_name = $this->wasRenamedTo($table_name);
            $check_back = true;
        }

        $columns = array();

        // Extract the table names and column names
        preg_match("/CREATE\s+TABLE\s+`?{$table_name}`?.*?\((.*?)\)[\s]*;/is", $sql, $match);
        $column_str = (!isset($match[1])) ?: $match[1];
        preg_match_all('/`?(\w+)`?\s+\w+\s*(?:\(\d+\))?(?:\s+UNSIGNED)?(?:\s+NOT\s+NULL)?(?:\s+AUTO_INCREMENT)?(?:\s+DEFAULT\s+\w*)?(?:\s+,\s*)?/i', $column_str, $matches);

        foreach ($matches[1] as $match) {
            if (!preg_match('/^(PRIMARY|FOREIGN|INDEX|NOT|REFERENCES|InnoDB|ON|DEFAULT|UNIQUE)$/i', $match)) {
                $columns[] = $match;
            }
        }

        // Change columns
        preg_match_all("/ALTER\s+TABLE\s+`?$table_name`?\s+CHANGE\s+COLUMN\s+`?(\w+)`?\s+`?(\w+)`?/i", $sql, $change_matches);
        foreach ($change_matches[1] as $key => $old_col_name) {
            $new_col_name = $change_matches[2][$key];
            $index = array_search($old_col_name, $columns);
            if ($index !== false) {
                $columns[$index] = $new_col_name;
            }
        }

        // Drop columns
        preg_match_all("/ALTER\s+TABLE\s+`?$table_name`?\s+DROP\s+COLUMN\s+`?(\w+)`?/i", $sql, $drop_matches);
        foreach ($drop_matches[1] as $match) {
            $index = array_search($match, $columns);
            if ($index !== false) {
                unset($columns[$index]);
            }
        }

        // Add columns
        preg_match_all("/ALTER\s+TABLE\s+`?$table_name`?\s+ADD\s+COLUMN\s+`?(\w+)`?/i", $sql, $add_matches);
        foreach ($add_matches[1] as $match) {
            $columns[] = $match;
        }

        $table_to_check = (!$check_back) ? $old_table_name : $table_name;
        $current_columns = $this->applicationCleaningModel->getColumns($table_to_check);

        if (count(array_diff($current_columns, $columns)) != 0) {
            foreach (array_diff($current_columns, $columns) as $missing) {
                if (preg_match("/$old_table_name.*$missing/i", $sql) || preg_match("/$table_name.*$missing/i", $sql)) {
                    $columns[] = $missing;
                }
            }
        }

        if (DB_DRIVER == 'mysql' && $table_name == 'schema_version' || DB_DRIVER == 'postgres' && $table_name == 'schema_version') {
            array_push($columns, 'version');
        }

        return $columns;
    }

    public function checkTableColumns($table_name)
    {
        $current_columns = $this->applicationCleaningModel->getColumns($table_name);
        $default_columns = $this->getDefaultColumnsForTable($table_name);

        return array_diff($current_columns, $default_columns);
    }

    public function checkColumnsViaPlugin($table_name, $columns)
    {
        $columns_checks = array();
        $plugins = $this->pluginLoader->getPlugins();

        foreach ($plugins as $pluginFolder => $plugin) {
            if (file_exists(PLUGINS_DIR . '/' . $pluginFolder . '/Schema/Mysql.php')) {
                $file = PLUGINS_DIR . '/' . $pluginFolder . '/Schema/Mysql.php';
                $sql = file_get_contents($file);

                foreach ($columns as $column) {
                    if (preg_match("/$table_name.*$column/i", $sql)) {
                        $columns_checks[$column] = $plugin->getPluginName();
                    }
                }
            }
        }

        foreach ($columns as $column) {
            if (!isset($columns_checks[$column])) {
                $columns_checks[$column] = 'Unknown';
            }
        }

        return $columns_checks;
    }

    public function checkTablesViaPlugin($table_names)
    {
        $table_checks = array();
        $plugins = $this->pluginLoader->getPlugins();

        foreach ($plugins as $pluginFolder => $plugin) {
            if (file_exists(PLUGINS_DIR . '/' . $pluginFolder . '/Schema/Mysql.php')) {
                $file = PLUGINS_DIR . '/' . $pluginFolder . '/Schema/Mysql.php';
                $sql = file_get_contents($file);

                foreach ($table_names as $table_name) {
                    if (preg_match("/$table_name/i", $sql)) {
                        $table_checks[$table_name] = $plugin->getPluginName();
                    }
                }
            }
        }

        foreach ($table_names as $table_name) {
            if (!isset($table_checks[$table_name])) {
                $table_checks[$table_name] = 'Unknown';
            }
        }

        return $table_checks;
    }

    public function checkTables()
    {
        $current_tables = $this->applicationCleaningModel->getTables();
        $default_tables = $this->getDefaultTables();

        return array_diff($current_tables, $default_tables);
    }

    private function wasRenamedFrom($table_name)
    {
        $file = $this->getSchema();
        $sql = file_get_contents($file);

        if (preg_match("/RENAME\s+TABLE\s+(\w+)\s+TO\s+$table_name/i", $sql, $matches)) {
            $original_table = $matches[1];
            return $original_table;
        } else {
            return false;
        }
    }

    private function wasRenamedTo($table_name)
    {
        $file = $this->getSchema();
        $sql = file_get_contents($file);

        if (preg_match("/RENAME\s+TABLE\s+(\Q$table_name\E)\s+TO\s+(\w+)/i", $sql, $matches)) {
            $new_table_name = $matches[2];
            return $new_table_name;
        } else {
            return false;
        }
    }

    private function getSchema()
    {
        // All default checks are based on the `mysql.php` file - DO NOT CHANGE
        switch (DB_DRIVER) {
            case 'sqlite':
                return $_SERVER['DOCUMENT_ROOT'] . '/app/Schema/Mysql.php';
            case 'postgres':
                return $_SERVER['DOCUMENT_ROOT'] . '/app/Schema/Mysql.php';
            case 'mssql':
                return $_SERVER['DOCUMENT_ROOT'] . '/app/Schema/Mysql.php';
            case 'mysql':
                return $_SERVER['DOCUMENT_ROOT'] . '/app/Schema/Mysql.php';
            default:
                return $_SERVER['DOCUMENT_ROOT'] . '/app/Schema/Mysql.php';
        }
    }
}
