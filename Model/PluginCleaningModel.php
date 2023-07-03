<?php

namespace Kanboard\Plugin\ContentCleaner\Model;

use Kanboard\Core\Base;

/**
 * Class Kanboard\Plugin\ContentCleaner\Model;
 *
 * @author aljawaid
 */

class PluginCleaningModel extends Base
{

    /**
     * Delete Plugin Entry from the Schema Table
     * Table: plugin_schema_versions (plugin VARCHAR(80) NOT NULL, version INT NOT NULL DEFAULT 0, PRIMARY KEY(plugin)) ENGINE=InnoDB CHARSET=utf8
     *
     * @var     string      $plugin_name        - must be lowercase
     * @return  true
     * @author  aljawaid
     */
    public function deletePluginSchemaEntry($plugin_name)
    {
        return $this->db->table('plugin_schema_versions')->eq('plugin', $plugin_name)->remove();
    }
}
