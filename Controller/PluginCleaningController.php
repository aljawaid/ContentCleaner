<?php

namespace Kanboard\Plugin\ContentCleaner\Controller;

use Kanboard\Controller\BaseController;
use Kanboard\Core\Plugin\Directory;
use Kanboard\Core\Controller\PageNotFoundException;

/**
 * Plugin ContentCleaner
 *
 * Class PluginCleaningController
 * @author aljawaid
 * @author alfredbuehler Alfred Bühler
 */

class PluginCleaningController extends BaseController
{
    public function confirmDeletePlugin()
    {
        $this->response->html($this->template->render('contentCleaner:config/modals/plugin_delete', array(
            'plugin_job_name' => $this->request->getStringParam('plugin_job_name'),
            'job_number' => $this->request->getStringParam('job_number'),
            'plugin_name' => $this->request->getStringParam('plugin_name'),
        )));
    }

    public function deletePlugin($plugin_name)
    {
        $this->checkCSRFParam();

        $plugin_name = $this->request->getStringParam('plugin_name');

        if ($this->pluginCleaningModel->deletePlugin($plugin_name)) {
            $this->flash->success(t('Deep cleaning complete - plugin removed successfully'));
        } else {
            $this->flash->failure(t('Cleaning failed'));
        }

        $this->response->redirect($this->helper->url->to('ContentCleanerController', 'show', array('plugin' => 'ContentCleaner')));
    }

    /**
     * Confirm Deletion of Plugin Tables (Modal)
     *
     * @author aljawaid
     */
    public function confirmDeletePluginTables()
    {
        $this->response->html($this->template->render('contentCleaner:config/modals/plugin_deep_clean', array(
            'plugin_job_name' => $this->request->getStringParam('plugin_job_name'),
        )));
    }

    /**
     * Delete Plugin Tables
     *
     * @author alfredbuehler Alfred Bühler
     */
    public function deletePluginTables()
    {
        $this->checkCSRFParam();

        // Pull variable from button
        $plugin_job_name = $this->request->getStringParam('plugin_job_name');
        $plugin_tables = [];

        // Match variable to json content if the plugin name matches
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
            $this->flash->success(t('DEEP CLEANING COMPLETE: Plugin tables were deleted successfully'));
        } else {
            $this->flash->failure(t('DEEP CLEANING FAILED: Plugin tables could not be deleted'));
        }

        $this->response->redirect($this->helper->url->to('ContentCleanerController', 'show', array('plugin' => 'ContentCleaner')));
    }

    public function confirmDeleteCoreTableColumns()
    {
        $this->response->html($this->template->render('contentCleaner:config/modals/plugin_deep_clean', array(
            'plugin_job_name' => $this->request->getStringParam('plugin_job_name'),
        )));
    }

    public function deleteCoreTableColumns()
    {
        // DELETE CORE COLUMNS CREATED BY THE PLUGIN

        $table = $this->request->getStringParam('table');
        $values = $this->request->getRawFormValues();

        if (!empty($values)) {
            foreach ($values as $key => $val) {
                if ($this->applicationCleaningModel->deleteColumn($table, $key)) {
                    $this->flash->success(t('DEEP CLEANING COMPLETE: Core table columns deleted successfully'));
                } else {
                    $this->flash->failure(t('DEEP CLEANING FAILED: Core table columns were not deleted'));
                }
            }
        } else {
            $this->flash->failure(t('No columns were selected'));
        }

        $this->response->redirect($this->helper->url->to('ContentCleanerController', 'show', array('plugin' => 'ContentCleaner')));
    }

    public function confirmDeleteCoreTableEntries()
    {
        $this->response->html($this->template->render('contentCleaner:config/modals/plugin_deep_clean', array(
            'plugin_job_name' => $this->request->getStringParam('plugin_job_name'),
        )));
    }

    public function deleteCoreTableEntries()
    {
        // DELETE THE PLUGIN SCHEMA ENTRY FOR THE PLUGIN

        if ($this->applicationCleaningModel->purgeUninstalledPluginSchemas()) {
            $this->flash->success(t('DEEP CLEANING COMPLETE: Core table entries were deleted successfully'));
        } else {
            $this->flash->failure(t('DEEP CLEANING FAILED: Core table entries were not deleted'));
        }

        $this->response->redirect($this->helper->url->to('ContentCleanerController', 'show', array('plugin' => 'ContentCleaner')));
    }

    public function confirmDeletePluginSchemaEntry()
    {
        $this->response->html($this->template->render('contentCleaner:config/modals/plugin_deep_clean', array(
            'plugin_job_name' => $this->request->getStringParam('plugin_job_name'),
        )));
    }

    public function deletePluginSchemaEntry()
    {
        // DELETE THE PLUGIN SCHEMA ENTRY FOR THE PLUGIN

        if ($this->applicationCleaningModel->purgeUninstalledPluginSchemas()) {
            $this->flash->success(t('DEEP CLEANING COMPLETE: Plugin registration entry deleted successfully'));
        } else {
            $this->flash->failure(t('DEEP CLEANING FAILED: Plugin registration entry was not deleted'));
        }

        $this->response->redirect($this->helper->url->to('ContentCleanerController', 'show', array('plugin' => 'ContentCleaner')));
    }
}
