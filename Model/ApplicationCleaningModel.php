<?php

namespace Kanboard\Plugin\ContentCleaner\Model;

use Kanboard\Core\Base;

/**
 * Class Kanboard\Plugin\ContentCleaner\Model;
 *
 * @author aljawaid
 */

class ApplicationCleaningModel extends Base
{
    
    public function countTables()
    {
        //return $this->db->execute('SELECT COUNT(*) FROM information_schema.tables WHERE table_schema = ''. DB_NAME .'' AND TABLE_TYPE = 'BASE TABLE';');
        
        Switch (DB_DRIVER) {
            Case 'sqlite':
                return $this->db->table($this->getTable())
                ->eq('TYPE', 'table')
                ->count();
                break;
            Case 'mysql':
                return $this->db->table($this->getTable())
                ->eq('table_schema', DB_NAME)
                ->eq('TABLE_TYPE', 'BASE TABLE')
                ->count();
                break;
            Case 'postgres':
                return $this->db->table($this->getTable())
                ->eq('table_schema', DB_NAME)
                ->eq('TABLE_TYPE', 'BASE TABLE')
                ->count();
                break;
            Case 'mssql':
                return $this->db->table($this->getTable())
                ->eq('table_schema', DB_NAME)
                ->eq('TABLE_TYPE', 'BASE TABLE')
                ->count();
                break;
            Default:
                return $this->db->table($this->getTable())
                ->eq('table_schema', DB_NAME)
                ->eq('TABLE_TYPE', 'BASE TABLE')
                ->count();
              }

    }
    
    public function getTables()
    {
        // Find all Tables
        
        Switch (DB_DRIVER) {
            Case 'sqlite':
                return $this->db->table($this->getTable())
                ->eq('TYPE', 'table')
                ->findAllByColumn('name');
                break;
            Case 'mysql':
                return $this->db->table($this->getTable())
                ->eq('table_schema', DB_NAME)
                ->eq('TABLE_TYPE', 'BASE TABLE')
                ->findAllByColumn('name');
                break;
            Case 'postgres':
                return $this->db->table($this->getTable())
                ->eq('table_schema', DB_NAME)
                ->eq('TABLE_TYPE', 'BASE TABLE')
                ->findAllByColumn('name');
                break;
            Case 'mssql':
                return $this->db->table($this->getTable())
                ->eq('table_schema', DB_NAME)
                ->eq('TABLE_TYPE', 'BASE TABLE')
                ->findAllByColumn('name');
                break;
            Default:
                return $this->db->table($this->getTable())
                ->eq('table_schema', DB_NAME)
                ->eq('TABLE_TYPE', 'BASE TABLE')
                ->findAllByColumn('name');
              }

    }

    public function getSize($column)
    {
        // FOR DATABASE SIZE
        // SELECT table_schema "myppworkspace", ROUND(SUM(data_length + index_length) / 1024 / 1024, 1) "DB Size in MB" FROM information_schema.tables WHERE table_schema = 'myppworkspace' GROUP BY table_schema;

        return $this->db->table($this->getTable())
            ->eq('tables.table_schema', DB_NAME)
            ->sum($column);
    }

    public function deleteRememberMeOld()
    {
        // delete duplicate records but keep latest
        return $this->db->execute('
            DELETE FROM `remember_me`
            WHERE `id` NOT IN (
                SELECT * FROM (
                    SELECT MAX(`id`) FROM `remember_me`
                    GROUP BY `user_id`
                    ) AS x
            )'
        );
    }

    public function flushRememberMeAll()
    {
        // empty all
        return $this->db->execute('TRUNCATE TABLE `remember_me`; SHOW WARNINGS');
    }

    public function delete($table)
    {
        // delete table
        return $this->db->execute('DROP TABLE IF EXISTS `'. $table .'`; SHOW WARNINGS');
    }
    
    public function deleteColumn($table, $column)
    {
        // delete table
        Switch (DB_DRIVER) {
            Case 'sqlite':
                return $this->db->execute('ALTER TABLE ' . $table . ' DROP COLUMN '. $column . ';');
                break;
            Case 'mysql':
                return $this->db->execute('ALTER TABLE ' . $table . ' DROP '. $column . ';');
                break;
            Default :
                return $this->db->execute('ALTER TABLE ' . $table . ' DROP '. $column . ';');
        }
        
        
    }

    public function resetSettings($fields = array())
    {
        // RESET VALUES
        $table = 'settings';

        foreach ($fields as $key => $value) {
            if ($this->db->table($table)->eq('option', $key)->exists()) {
                $this->db->table($table)->eq('option', $key)->update(['value' => $value]);
            }
        }
    }
    
    public function getColumns($table)
    {
        // find all columns
        Switch (DB_DRIVER) {
            Case 'sqlite':
                $columns = $this->db->execute("PRAGMA table_info($table)");
                break;
            Case 'mysql':
                $columns = $this->db->execute("SHOW COLUMNS FROM $table");
                break;
            Default :
                $columns = $this->db->execute("SHOW COLUMNS FROM $table");
        }
        
        // Loop through the results and retrieve the column names
        $columnNames = array();
        foreach ($columns as $column) {
            $columnNames[] = $column['name'];
        }
        
        return $columnNames;
    }
    
    private function getTable()
    {
        if (DB_DRIVER === 'sqlite') {
            $table = 'sqlite_master';
        } elseif (DB_DRIVER === 'postgres') {
            $table = 'information_schema.tables';
        } elseif (DB_DRIVER === 'mssql') {
            $table = 'information_schema.tables';
        } elseif (DB_DRIVER === 'mysql') {
            $table = 'information_schema.tables';
        }
        
        return $table;
    }
}
