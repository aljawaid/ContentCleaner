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
        $contents = file_get_contents($file);

        if ($contents === false) {
            throw new \UnexpectedValueException('The cleanup catalogue could not be loaded');
        }

        $plugins = json_decode($contents, true);
        if (!is_array($plugins)) {
            throw new \UnexpectedValueException('The cleanup catalogue is invalid');
        }

        return $plugins;
    }
}
