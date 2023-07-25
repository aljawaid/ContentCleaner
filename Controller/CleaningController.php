<?php

namespace Kanboard\Plugin\ContentCleaner\Controller;

use Kanboard\Controller\BaseController;
use Kanboard\Core\Plugin\Directory;
use Kanboard\Core\Controller\PageNotFoundException;

/**
 * Plugin ContentCleaner
 *
 * Class CleaningController
 * @package  Plugin\ContentCleaner\Controller
 * @author   aljawaid
 * @author   creecros Craig Crosby
 * @author   alfredbuehler Alfred Bühler
 */

class CleaningController extends BaseController
{
    /**
     * Confirm Automatic Purge & Clean Database (Modal)
     *
     * @param   $job                    string
     * @return  modal
     * @see     autoPurgeAndClean()     function
     * @author  creecros Craig Crosby
     */
    public function confirmAutoPurgeAndClean()
    {
        $this->response->html($this->template->render('contentCleaner:config/modals/auto_purge_clean', array(
            'title' => t('Confirm Cleaning Job'),
            'job' => $this->request->getStringParam('job'),
        )));
    }

    /**
     * Automatically Purge & Clean Database
     *
     * @uses    confirmAutoPurgeAndClean()  function
     * @author  creecros Craig Crosby
     */
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

    /**
     * Confirm Deletion of Table (Modal)
     *
     * @param   $table                  string
     * @return  modal
     * @see     removeTable()           function
     * @author  creecros Craig Crosby
     */
    public function confirm()
    {
        $this->response->html($this->template->render('contentCleaner:config/modals/remove_table', array(
            'title' => t('Confirm Cleaning'),
            'table' => $this->request->getStringParam('table'),
        )));
    }

    /**
     * Delete Table
     *
     * @param   $table                  string
     * @uses    confirm()               function
     * @author  creecros Craig Crosby
     */
    public function removeTable()
    {
        $table = $this->request->getStringParam('table');
        $this->checkCSRFParam();

        if ($this->applicationCleaningModel->delete($table)) {
            $this->flash->success(t('Cleaning Complete: Database table deleted successfully'));
        } else {
            $this->flash->failure(t('Cleaning Failed'));
        }

        $this->response->redirect($this->helper->url->to('ContentCleanerController', 'show', array('plugin' => 'ContentCleaner')));
    }

    /**
     * Automatically Purges Plugin Schemas (Modal)
     *
     * @param   $job                    string
     * @return  modal
     * @see     pluginSchemaPurge()     function
     * @author  creecros Craig Crosby
     */
    public function confirmPluginSchemaPurge()
    {
        $this->response->html($this->template->render('contentCleaner:config/modals/purge_plugin_schemas', array(
            'title' => t('Confirm Cleaning Job'),
            'job' => $this->request->getStringParam('job'),
        )));
    }

    /**
     * Automatically Purges Plugin Schemas
     *
     * @uses    confirmPluginSchemaPurge()      function
     * @author  creecros Craig Crosby
     */
    public function pluginSchemaPurge()
    {
        if ($this->applicationCleaningModel->purgeUninstalledPluginSchemas()) {
            $this->flash->success(t('Purge Complete: Plugin registration data successfully removed'));
        } else {
            $this->flash->failure(t('Purge Failed: There may not be anything to purge'));
        }

        $this->response->redirect($this->helper->url->to('ContentCleanerController', 'show', array('plugin' => 'ContentCleaner')));
    }

    /**
     * View & Delete Columns (Modal)
     *
     * @param   $table                      string
     * @var     $columns
     * @see     removeSelectedColumns()     function
     * @return  modal
     * @author  creecros Craig Crosby
     */
    public function viewColumns()
    {
        $table = $this->request->getStringParam('table');
        $columns = $this->helper->defaultTableHelper->checkTableColumns($table);

        $this->response->html($this->template->render('contentCleaner:config/modals/remove_extra_columns', array(
            'title' => t('Confirm Cleaning'),
            'table' => $table,
            'columns' => $columns,
        )));
    }

    /**
     * Delete Selected Columns
     *
     * @param   $table                  string
     * @param   $values
     * @uses    viewColumns()           function
     * @author  creecros Craig Crosby
     */
    public function removeSelectedColumns()
    {
        $table = $this->request->getStringParam('table');
        $values = $this->request->getRawFormValues();

        if (!empty($values)) {
            foreach ($values as $key => $val) {
                if ($this->applicationCleaningModel->deleteColumn($table, $key)) {
                    $this->flash->success(t('Cleaning Complete: Database column deleted successfully'));
                } else {
                    $this->flash->failure(t('Cleaning Failed'));
                }
            }
        } else {
            $this->flash->failure(t('No columns were selected'));
        }

        $this->response->redirect($this->helper->url->to('ContentCleanerController', 'show', array('plugin' => 'ContentCleaner')));
    }

    /**
     * Reset Calendar Settings (Modal)
     *
     * @param   $table                          string
     * @param   $job                            string
     * @return  modal
     * @see     resetCalendarSettings()         function
     * @author  alfredbuehler Alfred Bühler
     */
    public function confirmResetCalendar()
    {
        $this->response->html($this->template->render('contentCleaner:config/modals/reset', array(
            'title' => t('Confirm Cleaning Job'),
            'table' => $this->request->getStringParam('table'),
            'job' => $this->request->getStringParam('job'),
        )));
    }

    /**
     * Reset Calendar Settings
     *
     * @uses    confirmResetCalendar()         function
     * @author  alfredbuehler Alfred Bühler
     */
    public function resetCalendarSettings()
    {
        // NOTE: obsoleted, settings are always in table 'settings'
        // $table =  $this->request->getStringParam('table');
        $this->checkCSRFParam();

        if ($this->applicationCleaningModel->resetSettings(array(
                'calendar_project_tasks' => 'date_started',
                'calendar_user_tasks' => 'date_started',
            ))) {
            $this->flash->success(t('Cleaning Complete: Reset successfully'));
        } else {
            $this->flash->failure(t('Cleaning Failed'));
        }

        $this->response->redirect($this->helper->url->to('ContentCleanerController', 'show', array('plugin' => 'ContentCleaner')));
    }

    /**
     * Confirmation to Empty Sessions Table (Modal)
     *
     * @param   $table                  string
     * @param   $job                            string
     * @return  modal
     * @see     purgeSessionsData()     function
     * @author  aljawaid
     */
    public function confirmSessionsPurge()
    {
        $this->response->html($this->template->render('contentCleaner:config/modals/reset', array(
            'title' => t('Confirm Cleaning Job'),
            'table' => $this->request->getStringParam('table'),
            'job' => $this->request->getStringParam('job'),
        )));
    }

    /**
     * Confirmation to Empty Sessions Table
     *
     * @uses    confirmSessionsPurge()      function
     * @author  aljawaid
     */
    public function purgeSessionsData()
    {
        $this->checkCSRFParam();

        if ($this->applicationCleaningModel->flushSessionsAll()) {
            $this->flash->success(t('Cleaning Complete: Purged successfully'));
        } else {
            $this->flash->failure(t('Cleaning Failed'));
        }

        $this->response->redirect($this->helper->url->to('ContentCleanerController', 'show', array('plugin' => 'ContentCleaner')));
    }

    /**
     * Confirmation to Empty `Remember Me` Table (Modal)
     *
     * @param   $table                  string
     * @param   $job                    string
     * @return  modal
     * @see     purgeRememberMeData()   function
     * @author  aljawaid
     */
    public function confirmRememberMePurge()
    {
        $this->response->html($this->template->render('contentCleaner:config/modals/reset', array(
            'title' => t('Confirm Cleaning Job'),
            'table' => $this->request->getStringParam('table'),
            'job' => $this->request->getStringParam('job'),
        )));
    }

    /**
     * Confirmation to Empty `Remember Me` Table
     *
     * @uses    confirmRememberMePurge()        function
     * @author  aljawaid
     */
    public function purgeRememberMeData()
    {
        $this->checkCSRFParam();

        if ($this->applicationCleaningModel->flushRememberMeAll()) {
            $this->flash->success(t('Cleaning Complete: Purged successfully'));
        } else {
            $this->flash->failure(t('Cleaning Failed'));
        }

        $this->response->redirect($this->helper->url->to('ContentCleanerController', 'show', array('plugin' => 'ContentCleaner')));
    }

    /**
     * Confirmation to Remove Duplicate `Remember Me` Entries (Modal)
     *
     * @param   $table                                  string
     * @param   $job                                    string
     * @return  modal
     * @see     deleteRememberMeDuplicatesData()        function
     * @author  aljawaid
     */
    public function confirmRememberMeDuplicatesPurge()
    {
        $this->response->html($this->template->render('contentCleaner:config/modals/reset', array(
            'title' => t('Confirm Cleaning Job'),
            'table' => $this->request->getStringParam('table'),
            'job' => $this->request->getStringParam('job'),
        )));
    }

    /**
     * Remove Duplicate `Remember Me` Entries
     *
     * @uses    confirmRememberMeDuplicatesPurge()      function
     * @author  aljawaid
     */
    public function deleteRememberMeDuplicatesData()
    {
        $this->checkCSRFParam();

        if ($this->applicationCleaningModel->deleteRememberMeOld()) {
            $this->flash->success(t('Cleaning Complete: Duplicates deleted successfully'));
        } else {
            $this->flash->failure(t('Cleaning Failed'));
        }

        $this->response->redirect($this->helper->url->to('ContentCleanerController', 'show', array('plugin' => 'ContentCleaner')));
    }
}
