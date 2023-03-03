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
    public function deleteRememberMeOld()
    {
        // delete duplicate records but keep latest
        return $this->db->execute('
            DELETE FROM `remember_me`
            WHERE `id` NOT IN (
                SELECT * FROM (
                    SELECT MAX(`id`) FROM `remember_me`
                    GROUP BY `user_id`
                    ) AS x
            )'
        );
    }

    public function deleteRememberMeAll()
    {
        // delete all
        return $this->db->execute('DROP TABLE IF EXISTS `test`; SHOW WARNINGS');
    }

    public function delete($table)
    {
        // delete all

        return $this->db->execute('DROP TABLE IF EXISTS `'.$table.'`; SHOW WARNINGS');
    }
}
