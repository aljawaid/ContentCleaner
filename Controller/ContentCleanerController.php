<?php

namespace Kanboard\Plugin\ContentCleaner\Controller;

use Kanboard\Controller\BaseController;
use Kanboard\Core\Plugin\Directory;

/**
 * Plugin ContentCleaner
 *
 * Class ContentCleanerController
 * @package  Plugin\ContentCleaner\Controller
 * @author   aljawaid
 */

class ContentCleanerController extends \Kanboard\Controller\PluginController
{
    /**
     * Display the Settings Page
     *
     * @access public
     */
    public function show()
    {
        $this->response->html($this->helper->layout->config('contentCleaner:config/cleaner', array(
            'title' => t('Settings') . ' &#10562; ' . t('Content Cleaner'),
            'db_size' => $this->configModel->getDatabaseSize(),
            'db_version' => $this->db->getDriver()->getDatabaseVersion(),
            'deletable_plugins' => $this->helper->pluginCleaningHelper->getDeletablePlugins(),
        )));
    }
}
