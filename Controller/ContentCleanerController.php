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
        $cleanupPlan = $this->cleanupPlanModel->buildPlan();
        $deletablePlugins = $this->helper->pluginCleaningHelper->getDeletablePlugins();
        $pluginCleanups = array();
        foreach ($deletablePlugins as $plugin) {
            $pluginCleanups[$plugin['plugin_name']] = $this->cleanupPlanModel->getPluginCleanup($plugin['plugin_name']);
        }

        $displayMode = $this->configModel->get('content_cleaner_display_mode', 'normal');
        if (!in_array($displayMode, array('normal', 'advanced'), true)) {
            $displayMode = 'normal';
        }

        $this->response->html($this->helper->layout->config('contentCleaner:config/cleaner', array(
            'title' => t('Settings') . ' &#10562; ' . t('Content Cleaner'),
            'db_size' => $this->configModel->getDatabaseSize(),
            'db_version' => $this->db->getDriver()->getDatabaseVersion(),
            'deletable_plugins' => $deletablePlugins,
            'cleanup_plan' => $cleanupPlan,
            'plugin_cleanups' => $pluginCleanups,
            'display_mode' => $displayMode,
        )));
    }

    /**
     * Save the plugin-cleaning control level.
     */
    public function saveDisplayMode()
    {
        $this->assertAdmin();
        if (!$this->request->isPost()) {
            throw new AccessForbiddenException();
        }
        $this->checkCSRFForm();

        $values = $this->request->getValues();
        $displayMode = isset($values['content_cleaner_display_mode'])
            ? $values['content_cleaner_display_mode']
            : '';

        if (!in_array($displayMode, array('normal', 'advanced'), true)) {
            $this->flash->failure(t('Choose a valid ContentCleaner display mode'));
        } elseif ($this->configModel->save(array('content_cleaner_display_mode' => $displayMode))) {
            $this->flash->success(t('ContentCleaner display mode saved'));
        } else {
            $this->flash->failure(t('Unable to save the ContentCleaner display mode'));
        }

        $this->response->redirect($this->helper->url->to(
            'ContentCleanerController',
            'show',
            array('plugin' => 'ContentCleaner')
        ));
    }

    private function assertAdmin()
    {
        if (!$this->userSession->isAdmin()) {
            throw new AccessForbiddenException();
        }
    }
}
