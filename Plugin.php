<?php

namespace Kanboard\Plugin\ContentCleaner;

use Kanboard\Core\Plugin\Base;
use Kanboard\Core\Translator;

class Plugin extends Base
{
    public function initialize()
    {
        // CSS - Asset Hook
        //  - Keep filename lowercase
        $this->hook->on('template:layout:css', array('template' => 'plugins/ContentCleaner/Assets/css/content-cleaner.css'));
        $this->hook->on('template:layout:css', array('template' => 'plugins/ContentCleaner/Assets/css/content-cleaner-icons.css'));
        $this->hook->on('template:layout:css', array('template' => 'plugins/ContentCleaner/Assets/css/messages.css'));

        // Views - Add Menu Item - Template Hook
        //  - Override name should start lowercase e.g. pluginNameExampleCamelCase
        $this->template->hook->attach('template:config:sidebar', 'contentCleaner:config/sidebar');

        // Extra Page - Routes
        //  - Example: $this->route->addRoute('/my/custom/route', 'MyController', 'show', 'PluginNameExampleStudlyCaps');
        //  - Must have the corresponding action in the matching controller
        $this->route->addRoute('/settings/cleaner', 'ContentCleanerController', 'show', 'ContentCleaner');

        // Helper
        //  - Example: $this->helper->register('helperClassNameCamelCase', '\Kanboard\Plugin\PluginNameExampleStudlyCaps\Helper\HelperNameExampleStudlyCaps');
        //  - Add each Helper in the 'use' section at the top of this file
        $this->helper->register('cleaningHelper', '\Kanboard\Plugin\ContentCleaner\Helper\CleaningHelper');
        $this->helper->register('defaultTableHelper', '\Kanboard\Plugin\ContentCleaner\Helper\DefaultTableHelper');
        $this->helper->register('pluginCleaningHelper', '\Kanboard\Plugin\ContentCleaner\Helper\PluginCleaningHelper');
    }

    public function onStartup()
    {
        Translator::load($this->languageModel->getCurrentLanguage(), __DIR__ . '/Locale');
    }

    public function getClasses()
    {
        return [
            'Plugin\ContentCleaner\Model' => [
                'ApplicationCleaningModel', 'PluginCleaningModel'
            ],
        ];
    }

    public function getPluginName()
    {
        // Plugin Name MUST be identical to namespace for Plugin Directory to detect updated versions - do not translate the plugin name here
        return 'ContentCleaner';
    }

    public function getPluginDescription()
    {
        return t('This tool allows admins to cleanup their Kanboard database by selectively deleting useless data saved by Kanboard and leftover data after uninstalling plugins. Keep your database clean and free from cluttered and expired data using cleaning jobs to solve specific application issues.');
    }

    public function getPluginAuthor()
    {
        return 'aljawaid';
    }

    public function getPluginVersion()
    {
        return '1.0.0';
    }

    public function getCompatibleVersion()
    {
        // Examples: '>=1.0.37' '<1.0.37' '<=1.0.37'
        // Tested on KB v1.2.32+ from plugin v1.0.0
        return '>=1.2.20';
    }

    public function getPluginHomepage()
    {
        return 'https://github.com/aljawaid/ContentCleaner';
    }
}
