<?php

namespace Kanboard\Plugin\ContentCleaner\Helper;

use Kanboard\Core\Base;

class CleaningHelper extends Base
{
    public function countTablesDB()
    {
        $db_count = $this->applicationCleaningModel->countTables();

        return $db_count;
    }

    public function dbSize()
    {
        $db_size = ($this->applicationCleaningModel->getSize('tables.data_length')
            + $this->applicationCleaningModel->getSize('tables.index_length'))
            / 1024 / 1024;

        return $db_size;
    }
}
