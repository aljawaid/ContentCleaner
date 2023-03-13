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
        $file = $this->getSchema();
        $tables = array();
        $sql = file_get_contents($file);
    
        // EXTRACT TABLE NAMES
        preg_match_all("/CREATE\s+TABLE\s+`?(\w+)`?/i", $sql, $matches);
        $tables = $matches[1];
    
        // EXTRACT RENAMED TABLE NAMES
        preg_match_all("/ALTER\s+TABLE\s+`?(\w+)`?\s+RENAME\s+TO\s+`?(\w+)`?/i", $sql, $matches);
        foreach ($matches[1] as $i => $old_table) {
            $new_table = $matches[2][$i];
            // UPDATE TABLE NAME IN $tables ARRAY
            $key = array_search($old_table, $tables);
            if ($key !== false) {
                $tables[$key] = $new_table;
            }
        }
    
        // EXTRACT DROPPED TABLE NAMES
        preg_match_all("/DROP\s+TABLE\s+`?(\w+)`?/i", $sql, $matches);
        foreach ($matches[1] as $table) {
            // REMOVE TABLE NAME FROM $tables ARRAY
            $key = array_search($table, $tables);
            if ($key !== false) {
                unset($tables[$key]);
            }
        }
    
        sort($tables);
    
        return $tables;
    }

    public function getDefaultColumnsForTable($table_name)
    {
        $file = $this->getSchema();
        $sql = file_get_contents($file);
        
        $columns = array();
        
        // EXTRACT TABLE NAMES AND COLUMN NAMES
        preg_match("/CREATE\s+TABLE\s+`?{$table_name}`?.*?\((.*?)\)[\s]*;/is", $sql, $match);
        $column_str = $match[1];
        preg_match_all('/`?(\w+)`?\s+\w+\s*(?:\(\d+\))?(?:\s+UNSIGNED)?(?:\s+NOT\s+NULL)?(?:\s+AUTO_INCREMENT)?(?:\s+DEFAULT\s+\w*)?(?:\s+,\s*)?/i', $column_str, $matches);
        
        foreach ($matches[1] as $match) {
            if (!preg_match('/^(PRIMARY|FOREIGN|INDEX|NOT|REFERENCES|InnoDB|ON|DEFAULT|UNIQUE)/i', $match)) {
                $columns[] = $match;
            }
        }
        
        // CHANGE COLUMNS
        preg_match_all("/ALTER\s+TABLE\s+`?$table_name`?\s+CHANGE\s+COLUMN\s+`?(\w+)`?\s+`?(\w+)`?/i", $sql, $change_matches);
        foreach ($change_matches[1] as $key => $old_col_name) {
            $new_col_name = $change_matches[2][$key];
            $index = array_search($old_col_name, $columns);
            if ($index !== false) {
                $columns[$index] = $new_col_name;
            }
        }
        
        // DROP COLUMNS
        preg_match_all("/ALTER\s+TABLE\s+`?$table_name`?\s+DROP\s+COLUMN\s+`?(\w+)`?/i", $sql, $drop_matches);
        foreach ($drop_matches[1] as $match) {
            $index = array_search($match, $columns);
            if ($index !== false) {
                unset($columns[$index]);
            }
        }
        
        // ADD COLUMNS
        preg_match_all("/ALTER\s+TABLE\s+`?$table_name`?\s+ADD\s+COLUMN\s+`?(\w+)`?/i", $sql, $add_matches);
        foreach ($add_matches[1] as $match) {
            $columns[] = $match;
        }


        return $columns;

    }
    
    private function getSchema() 
    {
        Switch (DB_DRIVER) { // For now, I am switching everything to reading the Mysql.php file.
            Case 'sqlite':
                return $_SERVER['DOCUMENT_ROOT'].'/app/Schema/Mysql.php';
            Case 'postgres':
                return $_SERVER['DOCUMENT_ROOT'].'/app/Schema/Mysql.php';
            Case 'mssql':
                return $_SERVER['DOCUMENT_ROOT'].'/app/Schema/Mysql.php'; 
            Case 'mysql':
                return $_SERVER['DOCUMENT_ROOT'].'/app/Schema/Mysql.php';
            Default:
                return $_SERVER['DOCUMENT_ROOT'].'/app/Schema/Mysql.php';
        }

    }
}
