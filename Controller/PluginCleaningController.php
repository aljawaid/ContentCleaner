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
    public function confirmRemoval()
    {
        $this->response->html($this->template->render('contentCleaner:config/modals/plugin_remove', array(
            'table' => $this->request->getStringParam('table'),
        )));
    }
}
