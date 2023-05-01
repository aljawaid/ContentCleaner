<?php

namespace Kanboard\Plugin\ContentCleaner\Controller;

use Kanboard\Controller\BaseController;
use Kanboard\Core\Plugin\Directory;
use Kanboard\Core\Controller\PageNotFoundException;
use Kanboard\Core\Http\Client;

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

        $url = PLUGINS_DIR . '/ContentCleaner/Template/cleaning-jobs/plugin-cleaning.json';
        $plugins = $this->httpClient->getJson($url);
        return $plugins;
    }
}
