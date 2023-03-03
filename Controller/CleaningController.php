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
            'table' => $table,
        )));
    }

    public function removeTable()
    {
        $this->checkCSRFParam();

        if ($this->applicationCleaningModel->delete()) {
            $this->flash->success(t('Cleaning complete - Database table deleted successfully'));
        } else {
            $this->flash->failure(t('Cleaning failed'));
        }

        $this->response->redirect($this->helper->url->to('ContentCleanerController', 'show', array('plugin' => 'ContentCleaner')), true);
    }
}
