<?php

namespace Kanboard\Plugin\ContentCleaner\Controller;

use Kanboard\Controller\BaseController;
use Kanboard\Core\Controller\AccessForbiddenException;

/**
 * Plugin ContentCleaner
 *
 * Class CleaningController
 * @package  Plugin\ContentCleaner\Controller
 * @author   aljawaid
 * @author   creecros Craig Crosby
 * @author   alfredbuehler Alfred Bühler
 *
 * Security contracts are covered by tests/security_contract.php.
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
        $this->assertAdmin();

        $this->response->html($this->template->render('contentCleaner:config/modals/auto_purge_clean', array(
            'title' => t('Confirm Cleaning Job'),
            'job' => '02',
            'candidates' => $this->cleanupPlanModel->buildPlan(),
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
        $this->assertAdmin();
        $this->requirePostRequest();
        $this->checkCSRFForm();

        $values = $this->request->getValues();
        if (!isset($values['backup_confirmed']) || $values['backup_confirmed'] !== '1') {
            $this->flash->failure(t('Confirm that a current database backup is available before cleaning'));
            return $this->redirectToSettings();
        }

        $result = $this->executeCleanupSelection(
            $this->getSelectedTokens($values),
            array('table', 'column', 'schema')
        );
        if ($result === null) {
            return $this->redirectToSettings();
        }
        $this->flashCleanupResult($result);
        $this->redirectToSettings();
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
        $this->assertAdmin();

        try {
            $candidate = $this->cleanupPlanModel->getCandidate(
                $this->request->getStringParam('candidate'),
                'table'
            );
        } catch (\InvalidArgumentException $exception) {
            $this->flash->failure(t('This cleanup selection is no longer available'));
            return $this->redirectToSettings();
        }

        $this->response->html($this->template->render('contentCleaner:config/modals/remove_table', array(
            'title' => t('Confirm Cleaning'),
            'candidate' => $candidate,
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
        $this->assertAdmin();
        $this->requirePostRequest();
        $this->checkCSRFForm();

        $values = $this->request->getValues();
        $result = $this->executeCleanupSelection(
            array(isset($values['candidate']) ? $values['candidate'] : ''),
            array('table')
        );
        if ($result === null) {
            return $this->redirectToSettings();
        }
        $this->flashCleanupResult($result);

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
        $this->assertAdmin();

        $this->response->html($this->template->render('contentCleaner:config/modals/purge_plugin_schemas', array(
            'title' => t('Confirm Cleaning Job'),
            'job' => '01',
            'candidates' => $this->cleanupPlanModel->filterByType($this->cleanupPlanModel->buildPlan(), 'schema'),
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
        $this->assertAdmin();
        $this->requirePostRequest();
        $this->checkCSRFForm();

        $values = $this->request->getValues();
        $result = $this->executeCleanupSelection($this->getSelectedTokens($values), array('schema'));
        if ($result === null) {
            return $this->redirectToSettings();
        }
        $this->flashCleanupResult($result);

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
        $this->assertAdmin();

        $table = $this->request->getStringParam('table');
        if (!in_array($table, $this->helper->defaultTableHelper->getDefaultTables(), true)) {
            throw new AccessForbiddenException();
        }
        $candidates = $this->cleanupPlanModel->getColumnCandidates($table);

        $this->response->html($this->template->render('contentCleaner:config/modals/remove_extra_columns', array(
            'title' => t('Confirm Cleaning'),
            'table' => $table,
            'candidates' => $candidates,
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
        $this->assertAdmin();
        $this->requirePostRequest();
        $this->checkCSRFForm();

        $values = $this->request->getValues();
        $result = $this->executeCleanupSelection($this->getSelectedTokens($values), array('column'));
        if ($result === null) {
            return $this->redirectToSettings();
        }
        $this->flashCleanupResult($result);

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
        $this->assertAdmin();

        $this->response->html($this->template->render('contentCleaner:config/modals/reset', array(
            'title' => t('Confirm Cleaning Job'),
            'table' => 'settings',
            'job' => '02',
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
        $this->assertAdmin();
        $this->requirePostRequest();
        $this->checkCSRFForm();

        if (
            $this->applicationCleaningModel->resetSettings(array(
                'calendar_project_tasks' => 'date_started',
                'calendar_user_tasks' => 'date_started',
            ))
        ) {
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
        $this->assertAdmin();

        $this->response->html($this->template->render('contentCleaner:config/modals/reset', array(
            'title' => t('Confirm Cleaning Job'),
            'table' => 'sessions',
            'job' => '01',
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
        $this->assertAdmin();
        $this->requirePostRequest();
        $this->checkCSRFForm();

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
        $this->assertAdmin();

        $this->response->html($this->template->render('contentCleaner:config/modals/reset', array(
            'title' => t('Confirm Cleaning Job'),
            'table' => 'remember_me',
            'job' => '03',
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
        $this->assertAdmin();
        $this->requirePostRequest();
        $this->checkCSRFForm();

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
        $this->assertAdmin();

        $this->response->html($this->template->render('contentCleaner:config/modals/reset', array(
            'title' => t('Confirm Cleaning Job'),
            'table' => 'remember_me',
            'job' => '04',
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
        $this->assertAdmin();
        $this->requirePostRequest();
        $this->checkCSRFForm();

        if ($this->applicationCleaningModel->deleteRememberMeOld()) {
            $this->flash->success(t('Cleaning Complete: Duplicates deleted successfully'));
        } else {
            $this->flash->failure(t('Cleaning Failed'));
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

    private function getSelectedTokens(array $values)
    {
        if (!isset($values['cleanup_items']) || !is_array($values['cleanup_items'])) {
            return array();
        }

        return $values['cleanup_items'];
    }

    private function flashCleanupResult(array $result)
    {
        if ($result['requested'] === 0) {
            $this->flash->failure(t('Cleaning Failed: Select at least one reviewed item'));
        } elseif ($result['failed'] !== null) {
            $this->flash->failure(t('Cleaning stopped after %d of %d selected items', $result['completed'], $result['requested']));
        } else {
            $this->flash->success(t('Cleaning Complete: %d reviewed items were removed', $result['completed']));
        }
    }

    private function executeCleanupSelection(array $tokens, array $allowedTypes)
    {
        try {
            return $this->cleanupPlanModel->executeSelection($tokens, $allowedTypes);
        } catch (\InvalidArgumentException $exception) {
            $this->flash->failure(t('This cleanup selection is invalid or no longer available'));
            return null;
        }
    }

    private function redirectToSettings()
    {
        $this->response->redirect($this->helper->url->to('ContentCleanerController', 'show', array('plugin' => 'ContentCleaner')));
    }
}
