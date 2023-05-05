<?php

namespace Kanboard\Plugin\ContentCleaner\Controller;

use Kanboard\Controller\BaseController;
use Kanboard\Core\Plugin\Directory;
use Kanboard\Core\Controller\PageNotFoundException;

/**
 * Plugin ContentCleaner
 * Class CleaningController
 * @author aljawaid
 */

class CleaningController extends BaseController
{
    public function confirm()
    {
        $this->response->html($this->template->render('contentCleaner:config/modals/remove', array(
            'table' => $this->request->getStringParam('table'),
        )));
    }

    public function confirmAutoPurgeAndClean()
    {
        $this->response->html($this->template->render('contentCleaner:config/modals/auto_purge_clean', array(
            'job' => $this->request->getStringParam('job'),
        )));
    }

    public function autoPurgeAndClean()
    {
        $check_tables = $this->helper->defaultTableHelper->checkTablesViaPlugin($this->helper->defaultTableHelper->checkTables());

        foreach ($this->helper->defaultTableHelper->checkTables() as $table) {
            if ($check_tables[$table] == 'Unknown') {
                $this->applicationCleaningModel->delete($table);
            }
        }

        foreach ($this->helper->defaultTableHelper->getDefaultTables() as $table) {
            if (count($this->helper->defaultTableHelper->checkTableColumns($table))) {
                $columns = $this->helper->defaultTableHelper->checkTableColumns($table);
                $check_columns = $this->helper->defaultTableHelper->checkColumnsViaPlugin($table, $columns);
                foreach ($columns as $column) {
                    if ($check_columns[$column] == 'Unknown') {
                        $this->applicationCleaningModel->deleteColumn($table, $column);
                    }
                }
            }
        }

        $this->applicationCleaningModel->purgeUninstalledPluginSchemas();

        $this->response->redirect($this->helper->url->to('ContentCleanerController', 'show', array('plugin' => 'ContentCleaner')));
    }

    public function removeTable()
    {
        $table = $this->request->getStringParam('table');
        $this->checkCSRFParam();

        if ($this->applicationCleaningModel->delete($table)) {
            $this->flash->success(t('Cleaning complete - Database table deleted successfully'));
        } else {
            $this->flash->failure(t('Cleaning failed'));
        }

        $this->response->redirect($this->helper->url->to('ContentCleanerController', 'show', array('plugin' => 'ContentCleaner')));
    }

    public function removeSelectedColumns()
    {
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

    public function confirmPluginSchemaPurge()
    {
        $this->response->html($this->template->render('contentCleaner:config/modals/purge_plugin_schemas', array(
            'job' => $this->request->getStringParam('job'),
        )));
    }

    public function pluginSchemaPurge()
    {
        if ($this->applicationCleaningModel->purgeUninstalledPluginSchemas()) {
            $this->flash->success(t('Purge complete - Plugin schema data successfully removed'));
        } else {
            $this->flash->failure(t('Purge failed - Might not be anything to purge'));
        }

        $this->response->redirect($this->helper->url->to('ContentCleanerController', 'show', array('plugin' => 'ContentCleaner')));
    }

    public function viewColumns()
    {
        $table = $this->request->getStringParam('table');
        $columns = $this->helper->defaultTableHelper->checkTableColumns($table);

        $this->response->html($this->template->render('contentCleaner:config/modals/extra_columns', array(
            'table' => $table,
            'columns' => $columns,
        )));
    }

    public function confirmResetCalendar()
    {
        $this->response->html($this->template->render('contentCleaner:config/modals/reset', array(
            'table' => $this->request->getStringParam('table'),
            'job' => $this->request->getStringParam('job'),
        )));
    }

    public function resetCalendarSettings()
    {
        // NOTE obsoleted, settings are always in table 'settings'
        // $table =  $this->request->getStringParam('table');
        $this->checkCSRFParam();

        if ($this->applicationCleaningModel->resetSettings(array(
                'calendar_project_tasks' => 'date_started',
                'calendar_user_tasks' => 'date_started',
            ))) {
            $this->flash->success(t('Cleaning complete - Reset successfully'));
        } else {
            $this->flash->failure(t('Cleaning failed'));
        }

        $this->response->redirect($this->helper->url->to('ContentCleanerController', 'show', array('plugin' => 'ContentCleaner')));
    }

    public function confirmSessionsPurge()
    {
        $this->response->html($this->template->render('contentCleaner:config/modals/reset', array(
            'table' => $this->request->getStringParam('table'),
            'job' => $this->request->getStringParam('job'),
        )));
    }

    public function purgeSessionsData()
    {
        $this->checkCSRFParam();

        if ($this->applicationCleaningModel->flushSessionsAll()) {
            $this->flash->success(t('Cleaning complete - Purged successfully'));
        } else {
            $this->flash->failure(t('Cleaning failed'));
        }

        $this->response->redirect($this->helper->url->to('ContentCleanerController', 'show', array('plugin' => 'ContentCleaner')));
    }

    public function confirmRememberMePurge()
    {
        $this->response->html($this->template->render('contentCleaner:config/modals/reset', array(
            'table' => $this->request->getStringParam('table'),
            'job' => $this->request->getStringParam('job'),
        )));
    }

    public function purgeRememberMeData()
    {
        $this->checkCSRFParam();

        if ($this->applicationCleaningModel->flushRememberMeAll()) {
            $this->flash->success(t('Cleaning complete - Purged successfully'));
        } else {
            $this->flash->failure(t('Cleaning failed'));
        }

        $this->response->redirect($this->helper->url->to('ContentCleanerController', 'show', array('plugin' => 'ContentCleaner')));
    }

    public function confirmRememberMeDuplicatesPurge()
    {
        $this->response->html($this->template->render('contentCleaner:config/modals/reset', array(
            'table' => $this->request->getStringParam('table'),
            'job' => $this->request->getStringParam('job'),
        )));
    }

    public function deleteRememberMeDuplicatesData()
    {
        $this->checkCSRFParam();

        if ($this->applicationCleaningModel->deleteRememberMeOld()) {
            $this->flash->success(t('Cleaning complete - Duplicates deleted successfully'));
        } else {
            $this->flash->failure(t('Cleaning failed'));
        }

        $this->response->redirect($this->helper->url->to('ContentCleanerController', 'show', array('plugin' => 'ContentCleaner')));
    }
}
