<?php

namespace Kanboard\Plugin\ContentCleaner\Helper;

use Kanboard\Core\Base;

/**
 * Plugin ContentCleaner
 * Class PluginCleaningHelper
 *
 * @package  Plugin\ContentCleaner\Helper
 * @author   aljawaid
 * @author   creecros Craig Crosby
 */
class PluginCleaningHelper extends Base
{
    /**
     * Get The List of Deletable Plugins via JSON
     *
     * @return  $plugins                    array
     * @author  creecros Craig Crosby
     * @author  aljawaid
     */
    public function getDeletablePlugins()
    {
        $file = PLUGINS_DIR . '/ContentCleaner/Template/cleaning-jobs/plugin-cleaning.json';
        $plugins = json_decode(file_get_contents($file), true);

        return $plugins;
    }

    /**
     * Get The Folder Name of The Plugin
     *
     * @param   $plugin_name        string
     * @return  $folder_name        array
     * @author  aljawaid
     */
    public function getFolderName()
    {
        // Pull variable from the modal
        $plugin_name = $this->request->getStringParam('plugin_name');
        $folder_name = [];

        // Match the variable to the JSON content if the plugin name matches
        foreach ($this->helper->pluginCleaningHelper->getDeletablePlugins() as $plugin) {
            if ($plugin['plugin_name'] === $plugin_name && isset($plugin['plugin_folder_name'])) {
                $folder_name = $plugin['plugin_folder_name'];
                break;
            }
        }

        return $folder_name;
    }

    /**
     * Check if The Plugin Database Tables Exist
     *
     * @var     $plugin_title
     * @return  bool
     * @author  aljawaid
     */
    public function checkPluginTablesExist($plugin_title)
    {
        // Check against the database
        $current_tables = $this->applicationCleaningModel->getTables();

        // Pull the variable from the button, set as array
        $plugin_tables = [];

        // Match the variable to the JSON content if the plugin name matches
        foreach ($this->helper->pluginCleaningHelper->getDeletablePlugins() as $plugin) {
            if ($plugin['plugin_title'] === $plugin_title) {
                $plugin_tables[] = $plugin['plugin_tables'];
                break;
            }
        }

        // Set as string
        $single_table = '';

        foreach ($plugin_tables as $single_table => $value) {
            foreach ($value as $single_table_value) {
                $single_table = $single_table_value;
            }
        }

        // Search against the database
        if (in_array($single_table, $current_tables)) {
            //return t('Tables Exist');
            return true;
        } else {
            //return t('Tables Don\'t Exist');
            return false;
        }
    }

    /**
     * Check if The Plugin Core Database Columns Exist
     *
     * @var     $plugin_title
     * @return  bool
     * @author  aljawaid
     */
    public function checkPluginCoreColumnsExist($plugin_title)
    {
        // Set as array
        $db_result = [];

        // Set as string
        $search_column = '';

        foreach ($this->helper->pluginCleaningHelper->getDeletablePlugins() as $plugin) {
            if (($plugin['plugin_title'] == $plugin_title) && isset($plugin['core_table_columns'])) {
                foreach ($plugin['core_table_columns'] as $tables) {
                    foreach ($tables as $tablename => $tablecolumns) {
                            $db_result = $this->applicationCleaningModel->getColumns($tablename);
                        foreach ($tablecolumns as $column) {
                            $search_column = $column;
                        }
                    }
                    // Search against the database
                    if (in_array($search_column, $db_result)) {
                        //return t('Columns Exist');
                        return true;
                    } else {
                        //return t('Columns Don\'t Exist');
                        return false;
                    }
                }
            }
        }
    }

    /**
     * Check if The Plugin Core Database Entries Exist
     *
     * @var     $plugin_title
     * @return  bool
     * @author  aljawaid
     */
    public function checkPluginCoreEntriesExist($plugin_title)
    {
        foreach ($this->helper->pluginCleaningHelper->getDeletablePlugins() as $plugin) {
            if (($plugin['plugin_title'] == $plugin_title) && isset($plugin['core_table_entries'])) {
                foreach ($plugin['core_table_entries'] as $tables) {
                    foreach ($tables as $tablename => $tablecolumns) {
                        foreach ($tablecolumns as $column => $row) {
                            if ($this->db->table($tablename)->eq($column, $row)->exists()) {
                                //return t('Entries Exist');
                                return true;
                            } else {
                                //return t('Entries Don\'t Exist');
                                return false;
                            }
                        }
                    }
                }
            }
        }
    }
}
