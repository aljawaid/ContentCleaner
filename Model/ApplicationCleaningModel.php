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
        // return $this->db->execute('SELECT COUNT(*) FROM information_schema.tables WHERE table_schema = ''. DB_NAME .'' AND TABLE_TYPE = 'BASE TABLE';');

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
        // FIND ALL TABLES

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
        // SELECT table_schema "dbname", ROUND(SUM(data_length + index_length) / 1024 / 1024, 1) "DB Size in MB" FROM information_schema.tables WHERE table_schema = 'dbname' GROUP BY table_schema;

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

    public function getRememberMeOld()
    {
        // FIND ALL DUPLICATE RECORDS IN `REMEMBER_ME` TABLE

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

    public function deleteRememberMeOld()
    {
        // DELETE ALL DUPLICATES BUT KEEP THE LATEST RECORD

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

    public function flushRememberMeAll()
    {
        // EMPTY ALL 'REMEMBER ME' SESSION ENTRIES FROM THE 'REMEMBER_ME' TABLE
        // EMPTY ALL SESSION ENTRIES FROM THE `SESSIONS` TABLE

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

    public function getRememberMeCount()
    {
        // COUNT ALL ENTRIES

        return $this->db->table('remember_me')->count();
    }

    public function flushSessionsAll()
    {
        // EMPTY ALL SESSION ENTRIES FROM THE `SESSIONS` TABLE

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

    public function delete($table)
    {
        // DELETE TABLE

        switch (DB_DRIVER) {
            case 'sqlite':
                return $this->db->execute('DROP TABLE IF EXISTS `' . $table . '`; SHOW WARNINGS');
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

    public function deleteColumn($table, $column)
    {
        // DELETE COLUMN FROM TABLE

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

    public function purgeUninstalledPluginSchemas()
    {
        // PURGE PLUGIN SCHEMAS

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
            // IF OPTION EXISTS
            if ($this->db->table($table)->eq('option', $key)->exists()) {
                // UPDATE VALUE
                $this->db->table($table)->eq('option', $key)->update(['value' => $value]);
            } else {
                // INSERT OPTION AND VALUE
                $this->db->table($table)->eq('option', $key)->insert(['option' => $key, 'value' => $value]);
            }
        }
        return true;
    }

    public function getColumns($table)
    {
        // FIND ALL COLUMNS

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

    public function getSessionCount()
    {
        return $this->db->table('sessions')->count();
    }
}
