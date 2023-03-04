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
    public function countTables()
    {
        $table_schema = $this->db->table(self::TABLE);
        return $this->db->execute('SELECT COUNT(*) FROM information_schema.tables WHERE table_schema = `'. $table_schema .'`');
    }

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

    public function flushRememberMeAll()
    {
        // empty all
        return $this->db->execute('TRUNCATE TABLE `remember_me`; SHOW WARNINGS');
    }

    public function delete($table)
    {
        // delete table
        return $this->db->execute('DROP TABLE IF EXISTS `'. $table .'`; SHOW WARNINGS');
    }
}
