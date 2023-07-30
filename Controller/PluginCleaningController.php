<?php

namespace Kanboard\Plugin\ContentCleaner\Controller;

use Kanboard\Controller\BaseController;
use Kanboard\Core\Plugin\Directory;
use Kanboard\Core\Controller\PageNotFoundException;

/**
 * Plugin ContentCleaner
 *
 * Class PluginCleaningController
 * @package     Plugin\ContentCleaner\Controller
 * @author      aljawaid
 * @author      alfredbuehler Alfred Bühler
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
     * @param   $plugin_name            string
     * @uses    confirmDeletePlugin()   function
     * @author  aljawaid
     */
    public function deletePlugin($plugin_name)
    {
        $this->checkCSRFParam();

        $plugin_name = $this->request->getStringParam('plugin_name');

        if ($this->pluginCleaningModel->deletePlugin($plugin_name)) {
            $this->flash->success(t('Cleaning Complete: %s deleted successfully', $plugin_name));
        } else {
            $this->flash->failure(t('Cleaning Failed: Unable to delete %s', $plugin_name));
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
        $this->checkCSRFParam();

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
        $this->checkCSRFParam();
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
        $plugin_job_name = $this->request->getStringParam('plugin_job_name');
        $this->checkCSRFParam();

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
        $this->checkCSRFParam();

        $plugin_name = $this->request->getStringParam('plugin_name');

        if ($this->pluginCleaningModel->deletePluginSchemaEntry($plugin_name)) {
            $this->flash->success(t('Deep Cleaning Complete: Plugin registration entry for %s was deleted successfully', ucfirst($plugin_name)));
        } else {
            $this->flash->failure(t('Deep Cleaning Failed: Plugin registration entry was not deleted for %s', ucfirst($plugin_name)));
        }

        $this->response->redirect($this->helper->url->to('ContentCleanerController', 'show', array('plugin' => 'ContentCleaner')));
    }
}
