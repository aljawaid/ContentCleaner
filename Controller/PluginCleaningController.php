<?php

namespace Kanboard\Plugin\ContentCleaner\Controller;

use Kanboard\Controller\BaseController;
use Kanboard\Core\Plugin\Directory;
use Kanboard\Core\Controller\PageNotFoundException;

/**
 * Plugin ContentCleaner
 * Class PluginCleaningController
 * @author aljawaid
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

    public function confirmDeletePluginTables()
    {
        $this->response->html($this->template->render('contentCleaner:config/modals/plugin_deep_clean', array(
            'plugin_job_name' => $this->request->getStringParam('plugin_job_name'),
            'job_number' => $this->request->getStringParam('job_number'),
        )));
    }

    public function deletePluginTables()
    {
        // DELETE PLUGIN TABLES

        $plugin_table = $this->request->getStringParam('plugin_table');
        $this->checkCSRFParam();

        if ($this->applicationCleaningModel->delete($table)) {
            $this->flash->success(t('Plugin tables were deleted successfully'));
        } else {
            $this->flash->failure(t('Cleaning failed'));
        }

        $this->response->redirect($this->helper->url->to('ContentCleanerController', 'show', array('plugin' => 'ContentCleaner')));
    }

    public function confirmDeleteCoreTableColumns()
    {
        $this->response->html($this->template->render('contentCleaner:config/modals/plugin_deep_clean', array(
            'plugin_job_name' => $this->request->getStringParam('plugin_job_name'),
            'job_number' => $this->request->getStringParam('job_number'),
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
                    $this->flash->success(t('Cleaning complete - Database column deleted successfully'));
                } else {
                    $this->flash->failure(t('Cleaning failed'));
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
            'job_number' => $this->request->getStringParam('job_number'),
        )));
    }

    public function deleteCoreTableEntries()
    {
        // DELETE THE PLUGIN SCHEMA ENTRY FOR THE PLUGIN

        if ($this->applicationCleaningModel->purgeUninstalledPluginSchemas()) {
            $this->flash->success(t('Purge complete - Plugin schema data successfully removed'));
        } else {
            $this->flash->failure(t('Purge failed - Might not be anything to purge'));
        }

        $this->response->redirect($this->helper->url->to('ContentCleanerController', 'show', array('plugin' => 'ContentCleaner')));
    }

    public function confirmDeletePluginSchemaEntry()
    {
        $this->response->html($this->template->render('contentCleaner:config/modals/plugin_deep_clean', array(
            'plugin_job_name' => $this->request->getStringParam('plugin_job_name'),
            'job_number' => $this->request->getStringParam('job_number'),
        )));
    }

    public function deletePluginSchemaEntry()
    {
        // DELETE THE PLUGIN SCHEMA ENTRY FOR THE PLUGIN

        if ($this->applicationCleaningModel->purgeUninstalledPluginSchemas()) {
            $this->flash->success(t('Purge complete - Plugin schema data successfully removed'));
        } else {
            $this->flash->failure(t('Purge failed - Might not be anything to purge'));
        }

        $this->response->redirect($this->helper->url->to('ContentCleanerController', 'show', array('plugin' => 'ContentCleaner')));
    }
}
