<?php

namespace Kanboard\Plugin\ContentCleaner\Model;

use Kanboard\Core\Base;

/**
 * Application Cleaning Model
 * Class ApplicationCleaningModel
 *
 * @package  Plugin\ContentCleaner\Model
 * @author   creecros Craig Crosby
 * @author   alfredbuehler Alfred Bühler
 * @author   aljawaid
 */
class ApplicationCleaningModel extends Base
{
    public const TABLE_SCHEMA = 'plugin_schema_versions';

    /**
     * Count The Database Tables
     *
     * return $this->db->execute('SELECT COUNT(*) FROM information_schema.tables WHERE table_schema = ''. DB_NAME .'' AND TABLE_TYPE = 'BASE TABLE';');
     * @author creecros
     */
    public function countTables()
    {
        switch (DB_DRIVER) {
            case 'sqlite':
                return $this->db->table($this->getTable())
                ->eq('TYPE', 'table')
                ->count();
                break;
            case 'mysql':
                return $this->db->table($this->getTable())
                ->eq('table_schema', DB_NAME)
                ->eq('table_type', 'BASE TABLE')
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
                ->eq('table_type', 'BASE TABLE')
                ->count();
        }
    }

    /**
     * Find All Database Tables
     *
     * @return array
     * @author creecros
     */
    public function getTables()
    {
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

    /**
     * Get Database Size
     *
     * SELECT table_schema "dbname", ROUND(SUM(data_length + index_length) / 1024 / 1024, 1) "DB Size in MB" FROM information_schema.tables WHERE table_schema = 'dbname' GROUP BY table_schema;
     *
     * @author creecros
     */
    public function getSize($column = '')
    {
        switch (DB_DRIVER) {
            case 'mysql':
                return $this->db->table($this->getTable())
                    ->eq('tables.table_schema', DB_NAME)
                    ->sum($column);
                    break;
            case 'postgres':
                $info = $this->db->execute("SELECT pg_database_size('" . DB_NAME . "');");
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

    /**
     * Find All Duplicate Records in the `remember_me` Table
     *
     * @author aljawaid
     */
    public function getRememberMeOld()
    {
        switch (DB_DRIVER) {
            case 'sqlite':
                $result = $this->db->execute('
                    SELECT * FROM "remember_me"
                    WHERE "id" NOT IN (
                        SELECT MAX("id") FROM "remember_me"
                        GROUP BY "user_id"
                    )');
                $count = $result->rowCount();
                return $count;
                break;
            case 'mysql':
                $result = $this->db->execute('
                    SELECT * FROM `remember_me`
                    WHERE `id` NOT IN (
                        SELECT * FROM (
                            SELECT MAX(`id`) FROM `remember_me`
                            GROUP BY `user_id`
                            ) AS x
                    )');
                $count = $result->rowCount();
                return $count;
                break;
            case 'postgres':
                $result = $this->db->execute('
                    SELECT * FROM "remember_me"
                    WHERE "id" NOT IN (
                        SELECT MAX("id") FROM "remember_me"
                        GROUP BY "user_id"
                    )');
                $count = $result->rowCount();
                return $count;
                break;
            default:
                return t('This cleaning job is not compatible with your database type');
        }
    }

    /**
     * Delete All Duplicates But Keep The Latest Record
     *
     * @return void
     * @author
     */
    public function deleteRememberMeOld()
    {
        switch (DB_DRIVER) {
            case 'sqlite':
                return $this->db->execute('
                    DELETE FROM "remember_me"
                    WHERE "id" NOT IN (
                        SELECT MAX("id") FROM "remember_me"
                        GROUP BY "user_id"
                    )');
                break;
            case 'mysql':
                return $this->db->execute('
                    DELETE FROM `remember_me`
                    WHERE `id` NOT IN (
                        SELECT * FROM (
                            SELECT MAX(`id`) FROM `remember_me`
                            GROUP BY `user_id`
                            ) AS x
                    )');
                break;
            case 'postgres':
                return $this->db->execute('
                    DELETE FROM "remember_me"
                    WHERE "id" NOT IN (
                        SELECT MAX("id") FROM "remember_me"
                        GROUP BY "user_id"
                    )');
                break;
            default:
                return t('This cleaning job is not compatible with your database type');
        }
    }

    /**
     * Empty All 'Remember Me' Session Entries From The `remember_me` Table
     *
     * @author aljawaid
     */
    public function flushRememberMeAll()
    {
        switch (DB_DRIVER) {
            case 'sqlite':
                return $this->db->execute('DELETE FROM TABLE remember_me');
                break;
            case 'mysql':
                return $this->db->execute('TRUNCATE TABLE `remember_me`; SHOW WARNINGS');
                break;
            case 'postgres':
                return $this->db->execute('TRUNCATE remember_me;');
                break;
            default:
                return $this->db->execute('TRUNCATE TABLE `remember_me`; SHOW WARNINGS');
        }
    }

    /**
     * Count All Entries in the `remember_me` Table
     *
     * @return int
     * @author aljawaid
     */
    public function getRememberMeCount()
    {
        return $this->db->table('remember_me')->count();
    }

    /**
     * Empty All Entries From The `sessions` Table
     *
     * @author aljawaid
     */
    public function flushSessionsAll()
    {
        switch (DB_DRIVER) {
            case 'sqlite':
                return $this->db->execute('DELETE FROM TABLE sessions');
                break;
            case 'mysql':
                return $this->db->execute('TRUNCATE TABLE `sessions`; SHOW WARNINGS');
                break;
            case 'postgres':
                return $this->db->execute('TRUNCATE sessions;');
                break;
            default:
                return $this->db->execute('TRUNCATE TABLE `sessions`; SHOW WARNINGS');
        }
    }

    /**
     * Delete Table From The Database
     *
     * @var     $table      string
     * @author  aljawaid
     */
    public function delete($table)
    {
        switch (DB_DRIVER) {
            case 'sqlite':
                return $this->db->execute('DROP TABLE IF EXISTS ' . $table . ';');
                break;
            case 'mysql':
                return $this->db->execute('DROP TABLE IF EXISTS `' . $table . '`; SHOW WARNINGS');
                break;
            case 'postgres':
                return $this->db->execute('DROP TABLE IF EXISTS ' . $table . ' CASCADE;');
                break;
            default:
                return $this->db->execute('DROP TABLE IF EXISTS `' . $table . '`; SHOW WARNINGS');
        }
    }

    /**
     * Delete Column From Database Table
     *
     * @var     $table      string
     * @var     $column     string
     * @author  aljawaid
     */
    public function deleteColumn($table, $column)
    {
        switch (DB_DRIVER) {
            case 'sqlite':
                return $this->db->execute('ALTER TABLE ' . $table . ' DROP COLUMN ' . $column . ';');
                break;
            case 'mysql':
                return $this->db->execute('ALTER TABLE ' . $table . ' DROP ' . $column . ';');
                break;
            case 'postgres':
                return $this->db->execute('ALTER TABLE ' . $table . ' DROP ' . $column . ' CASCADE;');
                break;
            default:
                return $this->db->execute('ALTER TABLE ' . $table . ' DROP ' . $column . ';');
        }
    }

    /**
     * Purge Plugin Schemas
     *
     * @author creecros
     */
    public function purgeUninstalledPluginSchemas()
    {
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

    /**
     * Reset Database Values in `settings` Table
     *
     * @author  alfredbuehler Alfred Bühler
     */
    public function resetSettings($fields = array())
    {
        $table = 'settings';

        foreach ($fields as $key => $value) {
            // If option exists
            if ($this->db->table($table)->eq('option', $key)->exists()) {
                // Update value
                $this->db->table($table)->eq('option', $key)->update(['value' => $value]);
            } else {
                // Insert option and value
                $this->db->table($table)->eq('option', $key)->insert(['option' => $key, 'value' => $value]);
            }
        }
        return true;
    }

    /**
     * Reset Database Values
     *
     * @var     $table      string
     * @var     $column     string
     * @var     $row      string
     * @return  bool
     * @author  aljawaid
     */
    public function deleteCoreTableEntries($table, $column, $row)
    {
        if ($this->db->table($table)->eq($column, $row)->exists()) {
            $this->db->table($table)->eq($column, $row)->remove();
        } else {
            return false;
        }

        return true;
    }

    /**
     * Find All Table Columns
     *
     * @var     $table      string
     * @return  array
     * @author  creecros
     */
    public function getColumns($table)
    {
        $columnNames = array();

        switch (DB_DRIVER) {
            case 'sqlite':
                $columns = $this->db->execute("PRAGMA table_info($table)");
                foreach ($columns as $column) {
                    $columnNames[] = $column['name'];
                }
                break;
            case 'mysql':
                $columns = $this->db->execute("SHOW COLUMNS FROM `" . $table . "`");
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
                $columns = $this->db->execute("SHOW COLUMNS FROM `" . $table . "`");
                foreach ($columns as $column) {
                    $columnNames[] = $column['Field'];
                }
        }

        return $columnNames;
    }

    /**
     * Get Table Based on Database Type
     *
     * @author creecros
     */
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

    /**
     * Get Total Number of Sessions
     *
     * @return  int
     * @author  aljawaid
     */
    public function getSessionCount()
    {
        return $this->db->table('sessions')->count();
    }
}
