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
        $this->response->html($this->template->render('contentCleaner:config/remove', array(
            'table' => $this->request->getStringParam('table'),
        )));
    }

    public function removeTable()
    {
        $table =  $this->request->getStringParam('table');
        $this->checkCSRFParam();

        if ($this->applicationCleaningModel->delete($table)) {
            $this->flash->success(t('Cleaning complete - Database table deleted successfully'));
        } else {
            $this->flash->failure(t('Cleaning failed'));
        }

        $this->response->redirect($this->helper->url->to('ContentCleanerController', 'show', array('plugin' => 'ContentCleaner')), true);
    }
    
    public function removeSelectedColumns()
    {
        $table =  $this->request->getStringParam('table');
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

        $this->response->redirect($this->helper->url->to('ContentCleanerController', 'show', array('plugin' => 'ContentCleaner')), true);
    }

    public function confirmReset()
    {
        $this->response->html($this->template->render('contentCleaner:config/reset', array(
            'table' => $this->request->getStringParam('table'),
        )));
    }
    
    public function viewColumns()
    {
        $table =  $this->request->getStringParam('table');
        $columns = $this->helper->defaultTableHelper->checkTableColumns($table);
        
        $this->response->html($this->template->render('contentCleaner:config/extra_columns', array(
            'table' => $table,
            'columns' => $columns,
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

        $this->response->redirect($this->helper->url->to('ContentCleanerController', 'show', array('plugin' => 'ContentCleaner')), true);
    }
}
