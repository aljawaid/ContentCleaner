<?php

namespace Kanboard\Plugin\ContentCleaner\Helper;

use Kanboard\Core\Base;

class PluginCleaningHelper extends Base
{
    public function getDeletablePlugins()
    {
        // GET THE JSON OF PLUGINS WHICH CAN BE DELETED
        // 'template/cleaning-jobs/plugin-cleaning.json'

        $file = PLUGINS_DIR . '/ContentCleaner/Template/cleaning-jobs/plugin-cleaning.json';
        $plugins = json_decode(file_get_contents($file), true);
        return $plugins;
    }

    /**
     * Get the folder name of the Plugin
     *
     * @param   $plugin_name        string
     * @return  $folder_name        array
     * @author  aljawaid
     */
    public function getFolderName()
    {
        // Pull variable from modal
        $plugin_name = $this->request->getStringParam('plugin_name');
        $folder_name = [];

        // Match variable to json content if the plugin name matches
        foreach ($this->helper->pluginCleaningHelper->getDeletablePlugins() as $plugin) {
            if ($plugin['plugin_name'] === $plugin_name && isset($plugin['plugin_folder_name'])) {
                $folder_name = $plugin['plugin_folder_name'];
                break;
            }
        }

        return $folder_name;
    }

    /**
     * Check if the Plugin Database Tables Exist
     *
     * @var     $plugin_title
     * @return  bool
     * @author  aljawaid
     */
    public function checkPluginTablesExist($plugin_title)
    {
        $current_tables = $this->applicationCleaningModel->getTables();

        // Pull the variable from the button
        //$plugin_job_name = $plugin_title;
        $plugin_tables = [];

        // Match the variable to the JSON content if the plugin name matches
        foreach ($this->helper->pluginCleaningHelper->getDeletablePlugins() as $plugin) {
            if ($plugin['plugin_title'] === $plugin_title) {
                $plugin_tables[] = $plugin['plugin_tables'];
                break;
            }
        }

        $single_table = '';

        foreach ($plugin_tables as $single_table => $value) {
            foreach ($value as $single_table_value) {
                $single_table = $single_table_value;
            }
        }

        if (in_array($single_table, $current_tables)) {
            //return t('Tables Exist');
            return true;
        } else {
            //return t('Tables Don\'t Exist');
            return false;
        }
    }
}
