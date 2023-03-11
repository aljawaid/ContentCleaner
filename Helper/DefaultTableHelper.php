<?php

namespace Kanboard\Plugin\ContentCleaner\Helper;

use Kanboard\Core\Base;

/**
 * Plugin ContentCleaner
 * Class DefaultTableHelper
 * @author creecros
 */

class DefaultTableHelper extends Base
{
    public function getDefaultTables()
    {
        if (DB_DRIVER === 'sqlite') {
            $file = $_SERVER['DOCUMENT_ROOT'].'/app/Schema/Sqlite.php';
        } elseif (DB_DRIVER === 'postgres') {
            $file = $_SERVER['DOCUMENT_ROOT'].'/app/Schema/Postgres.php';
        } elseif (DB_DRIVER === 'mssql') {
            $file = $_SERVER['DOCUMENT_ROOT'].'/app/Schema/Mssql.php';
        } elseif (DB_DRIVER === 'mysql') {
            $file = $_SERVER['DOCUMENT_ROOT'].'/app/Schema/Mysql.php';
        }

        $tables = array();
        $columns = array();

        $sql = file_get_contents($file);

        // EXTRACT TABLE NAMES
        preg_match_all("/CREATE\s+TABLE\s+`?(\w+)`?/i", $sql, $matches);
        $tables = $matches[1];

        // EXTRACT COLUMN NAMES
        preg_match_all("/ALTER\s+TABLE\s+`?(\w+)`?.*ADD\s+`?(\w+)`?/i", $sql, $matches);
        foreach ($matches[1] as $i => $table) {
            $column = $matches[2][$i];
            $columns[$table][] = $column;
        }

        // EXTRACT RENAMED TABLE NAMES
        preg_match_all("/ALTER\s+TABLE\s+`?(\w+)`?\s+RENAME\s+TO\s+`?(\w+)`?/i", $sql, $matches);
        foreach ($matches[1] as $i => $old_table) {
            $new_table = $matches[2][$i];
            // update table name in $tables array
            $key = array_search($old_table, $tables);
            if ($key !== false) {
                $tables[$key] = $new_table;
            }
            // update table name in $columns array
            if (isset($columns[$old_table])) {
                $columns[$new_table] = $columns[$old_table];
                unset($columns[$old_table]);
            }
        }

        // EXTRACT DROPPED TABLE NAMES
        preg_match_all("/DROP\s+TABLE\s+`?(\w+)`?/i", $sql, $matches);
        foreach ($matches[1] as $table) {
            // remove table name from $tables array
            $key = array_search($table, $tables);
            if ($key !== false) {
                unset($tables[$key]);
            }
            // remove table name from $columns array
            if (isset($columns[$table])) {
                unset($columns[$table]);
            }
        }

        // PRINT THE RESULTS
        print_r(count($tables).'<br>');
        foreach ($tables as $table) {
            print_r($table.'<br>');
        }
    }
}