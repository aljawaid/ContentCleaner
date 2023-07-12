<?php

namespace Kanboard\Plugin\ContentCleaner\Helper;

use Kanboard\Core\Base;

/**
 * Plugin ContentCleaner
 * Class CleaningHelper
 *
 * @package  Plugin\ContentCleaner\Helper
 * @author   creecros Craig Crosby
 * @author   aljawaid
 */
class CleaningHelper extends Base
{
    public function countTablesDB()
    {
        $db_count = $this->applicationCleaningModel->countTables();

        return $db_count;
    }

    public function dbSize()
    {
        switch (DB_DRIVER) {
            case 'mysql':
                $db_size = ($this->applicationCleaningModel->getSize('tables.data_length')
                + $this->applicationCleaningModel->getSize('tables.index_length'))
                / 1024 / 1024;
                break;
            case 'postgres':
                $db_size = $this->applicationCleaningModel->getSize()
                / 1024 / 1024;
                break;
            default:
                $db_size = ($this->applicationCleaningModel->getSize('tables.data_length')
                + $this->applicationCleaningModel->getSize('tables.index_length'))
                / 1024 / 1024;
        }

        return $db_size;
    }

    public function getTableDifference()
    {
        $db_count = $this->applicationCleaningModel->countTables();

        $default_tables = count($this->helper->defaultTableHelper->getDefaultTables());

        $difference = ($db_count - $default_tables);

        return $difference;
    }

    public function countSessions()
    {
        return $this->applicationCleaningModel->getSessionCount();
    }

    public function countRememberMe()
    {
        return $this->applicationCleaningModel->getRememberMeCount();
    }

    public function countRememberMeOld()
    {
        return $this->applicationCleaningModel->getRememberMeOld();
    }
}
