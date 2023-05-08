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
}
