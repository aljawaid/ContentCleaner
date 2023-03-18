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
    public const TABLE_SCHEMA = 'plugin_schema_versions';

    public function countTables()
    {
        //return $this->db->execute('SELECT COUNT(*) FROM information_schema.tables WHERE table_schema = ''. DB_NAME .'' AND TABLE_TYPE = 'BASE TABLE';');

        switch (DB_DRIVER) {
            case 'sqlite':
                return $this->db->table($this->getTable())
                ->eq('TYPE', 'table')
                ->count();
                break;
            case 'mysql':
                return $this->db->table($this->getTable())
                ->eq('table_schema', DB_NAME)
                ->eq('TABLE_TYPE', 'BASE TABLE')
                ->count();
                break;
            case 'postgres':
                return $this->db->table($this->getTable())
                ->eq('table_schema', 'public')
                ->count();
                break;
            case 'mssql':
                return $this->db->table($this->getTable())
                ->eq('table_schema', DB_NAME)
                ->eq('TABLE_TYPE', 'BASE TABLE')
                ->count();
                break;
            default:
                return $this->db->table($this->getTable())
                ->eq('table_schema', DB_NAME)
                ->eq('TABLE_TYPE', 'BASE TABLE')
                ->count();
        }
    }

    public function getTables()
    {
        // Find all Tables

        switch (DB_DRIVER) {
            case 'sqlite':
                return $this->db->table($this->getTable())
                ->eq('TYPE', 'table')
                ->findAllByColumn('name');
                break;
            case 'mysql':
                $table_names = array();
                $data = $this->db->table($this->getTable())
                ->eq('table_schema', DB_NAME)
                ->findAll();
                
                foreach ($data as $tables) { 
                    if ($tables['TABLE_NAME'] != 'schema_version') {
                        $table_names[] = $tables['TABLE_NAME']; 
                    }
                }
                return $table_names;
                break;
            case 'postgres':
                $table_names = array();
                $data = $this->db->table($this->getTable())
                ->eq('table_schema', 'public')
                ->findAll();
                
                foreach ($data as $tables) { 
                    if ($tables['table_name'] != 'schema_version') {
                        $table_names[] = $tables['table_name']; 
                    }
                }
                return $table_names;
                break;
            case 'mssql':
                return $this->db->table($this->getTable())
                ->eq('table_schema', DB_NAME)
                ->eq('TABLE_TYPE', 'BASE TABLE')
                ->findAllByColumn('name');
                break;
            default:
                return $this->db->table($this->getTable())
                ->eq('table_schema', DB_NAME)
                ->eq('TABLE_TYPE', 'BASE TABLE')
                ->findAllByColumn('name');
        }
    }

    public function getSize($column = '')
    {
        // FOR DATABASE SIZE
        // SELECT table_schema "myppworkspace", ROUND(SUM(data_length + index_length) / 1024 / 1024, 1) "DB Size in MB" FROM information_schema.tables WHERE table_schema = 'myppworkspace' GROUP BY table_schema;
        switch (DB_DRIVER) {
            case 'mysql':
                return $this->db->table($this->getTable())
                    ->eq('tables.table_schema', DB_NAME)
                    ->sum($column);
                    break;
            case 'postgres':
                $info = $this->db->execute("SELECT pg_database_size('kanboard');");
                foreach ($info as $more_info) { 
                    foreach ($more_info as $somehow_more_info) { 
                        $size = $somehow_more_info;
                        break;
                    }
                }
                return $size;
                    break;
            default:
                return $this->db->table($this->getTable())
                    ->eq('tables.table_schema', DB_NAME)
                    ->sum($column);
        }
    }

    public function deleteRememberMeOld()
    {
        // delete duplicate records but keep latest
        return $this->db->execute(
            '
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
        switch (DB_DRIVER) {
            case 'sqlite':
                return $this->db->execute('ALTER TABLE ' . $table . ' DROP COLUMN '. $column . ';');
                break;
            case 'mysql':
                return $this->db->execute('ALTER TABLE ' . $table . ' DROP '. $column . ';');
                break;
            default:
                return $this->db->execute('ALTER TABLE ' . $table . ' DROP '. $column . ';');
        }
    }

    public function purgeUninstalledPluginSchemas()
    {
        // purge plugin schemas
        $installed_plugins = array();
        $plugins = $this->pluginLoader->getPlugins();

        foreach ($plugins as $pluginFolder => $plugin) {
            $installed_plugins[] = strtolower($plugin->getPluginName());
        }

        $plugins_in_schema = $this->db->table(self::TABLE_SCHEMA)->findAllByColumn('plugin');

        $extra_schemas = array_diff($plugins_in_schema, $installed_plugins);

        if (!empty($extra_schemas)) {
            foreach ($extra_schemas as $plugin_to_remove) {
                $this->db->table(self::TABLE_SCHEMA)->eq('plugin', strtolower($plugin_to_remove))->remove();
            }
            return true;
        }

        return false;
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
        $columnNames = array();
        // find all columns
        switch (DB_DRIVER) {
            case 'sqlite':
                $columns = $this->db->execute("PRAGMA table_info($table)");
                foreach ($columns as $column) {
                    $columnNames[] = $column['name'];
                }
                break;
            case 'mysql':
                $columns = $this->db->execute("SHOW COLUMNS FROM `".$table."`");
                foreach ($columns as $column) {
                    $columnNames[] = $column['Field'];
                }
                break;
            case 'postgres':
                $columns = $this->db->execute("select * from information_schema.columns where table_name = '" . $table . "' AND table_schema = 'public'");
                foreach ($columns as $column) {
                    $columnNames[] = $column['column_name'];
                }
                break;
            default:
                $columns = $this->db->execute("SHOW COLUMNS FROM `".$table."`");
                foreach ($columns as $column) {
                    $columnNames[] = $column['Field'];
                }
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
