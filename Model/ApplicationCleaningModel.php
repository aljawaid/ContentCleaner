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
        //return $this->db->execute('SELECT COUNT(*) FROM information_schema.tables WHERE table_schema = `'. DB_NAME .'` AND TABLE_TYPE = `BASE TABLE`');

        return $this->db->table('information_schema.tables')
            ->eq('table_schema', 'myppworkspace')
            ->eq('TABLE_TYPE', 'BASE TABLE')
            ->count();
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
