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
}
