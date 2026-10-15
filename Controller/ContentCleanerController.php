<?php

namespace Kanboard\Plugin\ContentCleaner\Controller;

use Kanboard\Controller\BaseController;
use Kanboard\Core\Controller\AccessForbiddenException;

/**
 * Plugin ContentCleaner
 *
 * Class ContentCleanerController
 * @package  Plugin\ContentCleaner\Controller
 * @author   aljawaid
 *
 * Security contracts are covered by tests/security_contract.php.
 */
class ContentCleanerController extends BaseController
{
    /**
     * Display the Settings Page
     *
     * @access public
     */
    public function show()
    {
        $this->assertAdmin();

        $this->response->html($this->helper->layout->config('contentCleaner:config/cleaner', array(
            'title' => t('Settings') . ' &#10562; ' . t('Content Cleaner'),
            'db_size' => $this->configModel->getDatabaseSize(),
            'db_version' => $this->db->getDriver()->getDatabaseVersion(),
            'deletable_plugins' => $this->helper->pluginCleaningHelper->getDeletablePlugins(),
        )));
    }

    private function assertAdmin()
    {
        if (!$this->userSession->isAdmin()) {
            throw new AccessForbiddenException();
        }
    }
}
