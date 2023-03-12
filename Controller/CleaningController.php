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

    public function confirmReset()
    {
        $this->response->html($this->template->render('contentCleaner:config/reset', array(
            'table' => $this->request->getStringParam('table'),
        )));
    }

    public function resetSettings()
    {
        $table =  $this->request->getStringParam('table');
        $this->checkCSRFParam();

        if ($this->applicationCleaningModel->resetSettings($table)) {
            $this->flash->success(t('Cleaning complete - Reset successfully'));
        } else {
            $this->flash->failure(t('Cleaning failed'));
        }

        $this->response->redirect($this->helper->url->to('ContentCleanerController', 'show', array('plugin' => 'ContentCleaner')), true);
    }
}
