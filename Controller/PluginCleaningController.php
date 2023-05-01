<?php

namespace Kanboard\Plugin\ContentCleaner\Controller;

use Kanboard\Controller\BaseController;
use Kanboard\Core\Plugin\Directory;
use Kanboard\Core\Controller\PageNotFoundException;

/**
 * Plugin ContentCleaner
 * Class PluginCleaningController
 * @author aljawaid
 */

class PluginCleaningController extends BaseController
{
    public function getDeletablePlugins()
    {
        // GET THE JSON OF PLUGINS WHICH CAN BE DELETED
        // 'template/cleaning-jobs/plugin-cleaning.json'

        $file = PLUGINS_DIR . '/ContentCleaner/Template/cleaning-jobs/plugin-cleaning.json';
        $plugins = json_decode(file_get_contents($file), true);
        return $plugins;
    }
}
