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

        $this->response->html($this->template->render('contentCleaner:config/modals/plugin_delete', array(
            'title' => t('Confirm Cleaning Job'),
            'plugin_job_name' => $this->request->getStringParam('plugin_job_name'),
            'job' => $this->request->getStringParam('job'),
            'folder_name' => $this->helper->pluginCleaningHelper->getFolderName(),
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

        $plugin_job_name = $this->request->getStringParam('plugin_job_name');

        if ($this->pluginCleaningModel->deletePlugin($plugin_job_name)) {
            $this->flash->success(t('Cleaning Complete: %s deleted successfully', $plugin_job_name));
        } else {
            $this->flash->failure(t('Cleaning Failed: Unable to delete %s', $plugin_job_name));
        }

        $this->response->redirect($this->helper->url->to('ContentCleanerController', 'show', array('plugin' => 'ContentCleaner')));
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

        $plugin_job_name = $this->request->getStringParam('plugin_job_name');
        $plugin_name = $this->request->getStringParam('plugin_name');

        $this->response->html($this->template->render('contentCleaner:config/modals/remove_plugin_tables', array(
            'title' => t('Delete Plugin Database Tables'),
            'plugin_job_name' => $plugin_job_name,
            'folder_name' => $this->helper->pluginCleaningHelper->getFolderName(),
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

        // Pull the variable from the button
        $plugin_job_name = $this->request->getStringParam('plugin_job_name');
        $plugin_tables = [];

        // Match the variable to the JSON content if the plugin name matches
        foreach ($this->helper->pluginCleaningHelper->getDeletablePlugins() as $plugin) {
            if ($plugin['plugin_title'] === $plugin_job_name && isset($plugin['plugin_tables'])) {
                $plugin_tables = $plugin['plugin_tables'];
                break;
            }
        }

        // Delete the plugin tables
        $success = true;
        foreach ($plugin_tables as $table) {
            if (!$this->applicationCleaningModel->delete($table)) {
                $success = false;
                break;
            }
        }

        if ($success) {
            $this->flash->success(t('Deep Cleaning Complete: Database tables created by %s were deleted successfully', $plugin_job_name));
        } else {
            $this->flash->failure(t('Deep Cleaning Failed: Database tables created by %s could not be deleted', $plugin_job_name));
        }

        $this->response->redirect($this->helper->url->to('ContentCleanerController', 'show', array('plugin' => 'ContentCleaner')));
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

        $this->response->html($this->template->render('contentCleaner:config/modals/remove_plugin_core_table_columns', array(
            'title' => t('Delete Core Table Columns'),
            'plugin_job_name' => $this->request->getStringParam('plugin_job_name'),
            'folder_name' => $this->helper->pluginCleaningHelper->getFolderName(),
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
        $plugin_job_name = $this->request->getStringParam('plugin_job_name');

        foreach ($this->helper->pluginCleaningHelper->getDeletablePlugins() as $plugin) {
            if (($plugin['plugin_title'] == $plugin_job_name) && isset($plugin['core_table_columns'])) {
                foreach ($plugin['core_table_columns'] as $tables) {
                    foreach ($tables as $tablename => $tablecolumns) {
                        foreach ($tablecolumns as $column) {
                            if ($this->applicationCleaningModel->deleteColumn($tablename, $column)) {
                                $this->flash->success(t('Deep Cleaning Complete: Core table columns created by %s were deleted successfully', $plugin_job_name));
                            } else {
                                $this->flash->failure(t('Deep Cleaning Failed: Core table columns created by %s were not deleted', $plugin_job_name));
                            }
                        }
                    }
                }
            }
        }

        $this->response->redirect($this->helper->url->to('ContentCleanerController', 'show', array('plugin' => 'ContentCleaner')));
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

        $this->response->html($this->template->render('contentCleaner:config/modals/remove_plugin_core_table_entries', array(
            'title' => t('Delete Core Table Entries'),
            'plugin_job_name' => $this->request->getStringParam('plugin_job_name'),
            'folder_name' => $this->helper->pluginCleaningHelper->getFolderName(),
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

        $plugin_job_name = $this->request->getStringParam('plugin_job_name');

        foreach ($this->helper->pluginCleaningHelper->getDeletablePlugins() as $plugin) {
            if (($plugin['plugin_title'] == $plugin_job_name) && isset($plugin['core_table_entries'])) {
                foreach ($plugin['core_table_entries'] as $tables) {
                    foreach ($tables as $tablename => $tablecolumns) {
                        foreach ($tablecolumns as $column => $row) {
                            if ($this->applicationCleaningModel->deleteCoreTableEntries($tablename, $column, $row)) {
                                $this->flash->success(t('Deep Cleaning Complete: Core table entries created by %s were deleted successfully', $plugin_job_name));
                            } else {
                                $this->flash->failure(t('Deep Cleaning Failed: Core table entries created by %s were not deleted', $plugin_job_name));
                            }
                        }
                    }
                }
            }
        }

        $this->response->redirect($this->helper->url->to('ContentCleanerController', 'show', array('plugin' => 'ContentCleaner')));
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

        $plugin_job_name = $this->request->getStringParam('plugin_job_name');
        $plugin_name = $this->request->getStringParam('plugin_name');

        $this->response->html($this->template->render('contentCleaner:config/modals/remove_plugin_schema', array(
            'title' => t('Delete Plugin Registration Entry'),
            'plugin_job_name' => $plugin_job_name,
            'plugin_name' => $plugin_name,
            'folder_name' => $this->helper->pluginCleaningHelper->getFolderName(),
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

        $plugin_name = $this->request->getStringParam('plugin_name');

        if ($this->pluginCleaningModel->deletePluginSchemaEntry($plugin_name)) {
            $this->flash->success(t('Deep Cleaning Complete: Plugin registration entry for %s was deleted successfully', ucfirst($plugin_name)));
        } else {
            $this->flash->failure(t('Deep Cleaning Failed: Plugin registration entry was not deleted for %s', ucfirst($plugin_name)));
        }

        $this->response->redirect($this->helper->url->to('ContentCleanerController', 'show', array('plugin' => 'ContentCleaner')));
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
}
