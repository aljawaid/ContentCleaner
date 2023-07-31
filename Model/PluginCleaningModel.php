<?php

namespace Kanboard\Plugin\ContentCleaner\Model;

use Kanboard\Core\Base;

/**
 * Plugin Cleaning Model
 * Class PluginCleaningModel
 *
 * @package  Plugin\ContentCleaner\Model
 * @author   aljawaid
 */
class PluginCleaningModel extends Base
{
    /**
     * Delete Plugin
     *
     * Delete each step to totally remove the plugin
     *
     * @var     $plugin_name        string
     * @author  aljawaid
     */
    public function deletePlugin($plugin_name)
    {
        // $get_deletable_plugins = $this->helper->pluginCleaningHelper->getDeletablePlugins();

        // $plugin_tables
        $this->applicationCleaningModel->delete($table);

        // $core_table_columns
        $this->applicationCleaningModel->deleteColumn($table, $column);

        // $core_table_entries
        $this->applicationCleaningModel->deleteCoreTableEntries($tablename, $column, $row);

        // $plugin_schema_entry
        $this->deletePluginSchemaEntry($plugin_name);
    }

    /**
     * Delete Plugin Entry from the Schema Table
     *
     * Table: plugin_schema_versions (plugin VARCHAR(80) NOT NULL, version INT NOT NULL DEFAULT 0, PRIMARY KEY(plugin)) ENGINE=InnoDB CHARSET=utf8
     *
     * @var     string      $plugin_name        - must be lowercase
     * @return  true
     * @author  aljawaid
     */
    public function deletePluginSchemaEntry($plugin_name)
    {
        return $this->db->table('plugin_schema_versions')->eq('plugin', $plugin_name)->remove();
    }
}
