<?php

namespace Kanboard\Plugin\ContentCleaner\Controller;

use Kanboard\Controller\BaseController;
use Kanboard\Core\Plugin\Directory;

/**
 * Plugin ContentCleaner
 * Class ContentCleanerController
 * @author aljawaid
 */

class ContentCleanerController extends \Kanboard\Controller\PluginController
{
    /**
     * Display the Settings Page
     * Use this function to create a page showing your template content.
     * This function must be checked with 'Views - Add Menu Item - Template Hook' in Plugin.php
     * This function must be checked with 'Extra Page - Routes' in Plugin.php
     * Use: $this->helper->layout->config for config settings menu sidebar
     * Use: $this->helper->layout->plugin for plugin menu sidebar
     * @access public
     */

    public function show()
    {
        $this->response->html($this->helper->layout->config('contentCleaner:config/cleaner', array(
            'title' => t('Settings') .' &#10562; '.t('Content Cleaner'),
            'db_size' => $this->configModel->getDatabaseSize(),
            'db_version' => $this->db->getDriver()->getDatabaseVersion(),
        )));
    }
}
