<?php

namespace Kanboard\Plugin\ContentCleaner\Model;

use Kanboard\Core\Base;

/**
 * Class Kanboard\Plugin\ContentCleaner\Model;
 *
 * @author aljawaid
 */

class ApplicationCleaningModel extends Base
{
    /**
     * SQL table name for comment templates
     *
     * @var string
     */

    const TABLE = '';

    public function deleteRememberMeAll()
    {
        // delete all
        return $this->db->execute('DROP TABLE IF EXISTS `test`; SHOW WARNINGS');
    }
}
