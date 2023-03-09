<?php

namespace Kanboard\Plugin\ContentCleaner\Helper;

use Kanboard\Core\Base;

class CleaningHelper extends Base
{
    public function countTablesDB()
    {
        $db_size = $this->applicationCleaningModel->countTables();

        return $db_size;
    }
}
