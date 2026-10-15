<?php

namespace Kanboard\Plugin\ContentCleaner\Controller;

use Kanboard\Controller\BaseController;
use Kanboard\Core\Controller\AccessForbiddenException;

/**
 * Plugin ContentCleaner
 *
 * Class PluginCleaningController
 * @package     Plugin\ContentCleaner\Controller
 * @author      aljawaid
 * @author      alfredbuehler Alfred Bühler
 *
 * Security contracts are covered by tests/security_contract.php.
 */

class PluginCleaningController extends BaseController
{
    /**
     * Confirm Deletion of Plugin (Modal)
     *
     * @param   $plugin_job_name    string
     * @param   $plugin_name        string
     * @param   $job_number         string
     * @see     deletePlugin()      function
     * @return  modal
     * @author  aljawaid
     */
    public function confirmDeletePlugin()
    {
        $this->assertAdmin();
        $cleanup = $this->getPluginCleanupFromRequest();

        $this->response->html($this->template->render('contentCleaner:config/modals/plugin_delete', array(
            'title' => t('Confirm Cleaning Job'),
            'plugin_job_name' => $cleanup['plugin_title'],
            'plugin_name' => $cleanup['plugin_name'],
            'job' => $cleanup['job_number'],
            'cleanup' => $cleanup,
        )));
    }

    /**
     * Delete Plugin
     *
     * @uses    confirmDeletePlugin()   function
     * @author  aljawaid
     */
    public function deletePlugin()
    {
        $this->assertAdmin();
        $this->requirePostRequest();
        $this->checkCSRFForm();

        $this->processPluginCleanup(array('entry', 'column', 'table', 'schema'));
    }

    /**
     * Confirm Deletion of Plugin Tables (Modal)
     *
     * @param   $plugin_job_name        string
     * @see     deletePluginTables()    function
     * @return  modal
     * @author  aljawaid
     */
    public function confirmDeletePluginTables()
    {
        $this->assertAdmin();
        $cleanup = $this->getPluginCleanupFromRequest();
        $cleanup['candidates'] = $this->cleanupPlanModel->filterByType($cleanup['candidates'], 'table');

        $this->response->html($this->template->render('contentCleaner:config/modals/remove_plugin_tables', array(
            'title' => t('Delete Plugin Database Tables'),
            'plugin_job_name' => $cleanup['plugin_title'],
            'plugin_name' => $cleanup['plugin_name'],
            'cleanup' => $cleanup,
        )));
    }

    /**
     * Delete Plugin Tables
     *
     * @param   $plugin_job_name                string
     * @param   $plugin_tables                  array
     * @uses    confirmDeletePluginTables()     function
     * @author  alfredbuehler Alfred Bühler
     */
    public function deletePluginTables()
    {
        $this->assertAdmin();
        $this->requirePostRequest();
        $this->checkCSRFForm();

        $this->processPluginCleanup(array('table'));
    }

    /**
     * Confirm Deletion of Core Table Columns (Modal)
     *
     * @param   $plugin_job_name            string
     * @see     deleteCoreTablesColumns()   function
     * @return  modal
     * @author  aljawaid
     */
    public function confirmDeleteCoreTableColumns()
    {
        $this->assertAdmin();
        $cleanup = $this->getPluginCleanupFromRequest();
        $cleanup['candidates'] = $this->cleanupPlanModel->filterByType($cleanup['candidates'], 'column');

        $this->response->html($this->template->render('contentCleaner:config/modals/remove_plugin_core_table_columns', array(
            'title' => t('Delete Core Table Columns'),
            'plugin_job_name' => $cleanup['plugin_title'],
            'plugin_name' => $cleanup['plugin_name'],
            'cleanup' => $cleanup,
        )));
    }

    /**
     * Delete Core Table Columns (created by a plugin)
     *
     * @param   $table                              string
     * @uses    confirmDeleteCoreTableColumns()     function
     * @author  aljawaid
     */
    public function deleteCoreTableColumns()
    {
        $this->assertAdmin();
        $this->requirePostRequest();
        $this->checkCSRFForm();
        $this->processPluginCleanup(array('column'));
    }

    /**
     * Confirm Deletion of Core Table Entries (Modal)
     *
     * @param   $plugin_job_name            string
     * @return  modal
     * @see     deleteCoreTableEntries()    function
     * @author  aljawaid
     */
    public function confirmDeleteCoreTableEntries()
    {
        $this->assertAdmin();
        $cleanup = $this->getPluginCleanupFromRequest();
        $cleanup['candidates'] = $this->cleanupPlanModel->filterByType($cleanup['candidates'], 'entry');

        $this->response->html($this->template->render('contentCleaner:config/modals/remove_plugin_core_table_entries', array(
            'title' => t('Delete Core Table Entries'),
            'plugin_job_name' => $cleanup['plugin_title'],
            'plugin_name' => $cleanup['plugin_name'],
            'cleanup' => $cleanup,
        )));
    }

    /**
     * Delete Core Table Entries (created by a plugin)
     *
     * @uses    confirmDeleteCoreTableEntries()     function
     * @author  aljawaid
     */
    public function deleteCoreTableEntries()
    {
        $this->assertAdmin();
        $this->requirePostRequest();
        $this->checkCSRFForm();

        $this->processPluginCleanup(array('entry'));
    }

    /**
     * Confirm Deletion of Plugin Schema Entry (Modal)
     *
     * @param   $plugin_job_name            string
     * @param   $plugin_name                string
     * @return  modal
     * @see     deletePluginSchemaEntry()   function
     * @author  aljawaid
     */
    public function confirmDeletePluginSchemaEntry()
    {
        $this->assertAdmin();
        $cleanup = $this->getPluginCleanupFromRequest();
        $cleanup['candidates'] = $this->cleanupPlanModel->filterByType($cleanup['candidates'], 'schema');

        $this->response->html($this->template->render('contentCleaner:config/modals/remove_plugin_schema', array(
            'title' => t('Delete Plugin Registration Entry'),
            'plugin_job_name' => $cleanup['plugin_title'],
            'plugin_name' => $cleanup['plugin_name'],
            'cleanup' => $cleanup,
        )));
    }

    /**
     * Delete the Plugin Schema Entry for the Plugin
     *
     * @param   $plugin_name                        string  - lowercase
     * @uses    confirmDeletePluginSchemaEntry()    function
     * @author  aljawaid
     */
    public function deletePluginSchemaEntry()
    {
        $this->assertAdmin();
        $this->requirePostRequest();
        $this->checkCSRFForm();

        $this->processPluginCleanup(array('schema'));
    }

    private function assertAdmin()
    {
        if (!$this->userSession->isAdmin()) {
            throw new AccessForbiddenException();
        }
    }

    private function requirePostRequest()
    {
        if (!$this->request->isPost()) {
            throw new AccessForbiddenException();
        }
    }

    private function getPluginCleanupFromRequest()
    {
        try {
            return $this->cleanupPlanModel->getPluginCleanup($this->request->getStringParam('plugin_name'));
        } catch (\InvalidArgumentException $exception) {
            throw new AccessForbiddenException();
        }
    }

    private function processPluginCleanup(array $allowedTypes)
    {
        $values = $this->request->getValues();
        $pluginName = isset($values['plugin_name']) ? $values['plugin_name'] : '';

        if (!isset($values['backup_confirmed']) || $values['backup_confirmed'] !== '1') {
            $this->flash->failure(t('Confirm that a current database backup is available before cleaning'));
            return $this->redirectToSettings();
        }

        try {
            $cleanup = $this->cleanupPlanModel->getPluginCleanup($pluginName);
            $result = $this->cleanupPlanModel->executePluginCleanup($pluginName, $allowedTypes);
        } catch (\InvalidArgumentException $exception) {
            $this->flash->failure(t('This plugin cleanup job is invalid or no longer available'));
            return $this->redirectToSettings();
        } catch (\DomainException $exception) {
            $this->flash->failure(t('Uninstall the plugin before removing its database artefacts'));
            return $this->redirectToSettings();
        }

        if ($result['requested'] === 0) {
            $this->flash->failure(t('No matching database artefacts were found for %s', $cleanup['plugin_title']));
        } elseif ($result['failed'] !== null) {
            $this->flash->failure(t('Cleaning stopped after %d of %d selected items for %s', $result['completed'], $result['requested'], $cleanup['plugin_title']));
        } else {
            $this->flash->success(t('Cleaning Complete: %d reviewed items were removed for %s', $result['completed'], $cleanup['plugin_title']));
        }

        $this->redirectToSettings();
    }

    private function redirectToSettings()
    {
        $this->response->redirect($this->helper->url->to('ContentCleanerController', 'show', array('plugin' => 'ContentCleaner')));
    }
}
