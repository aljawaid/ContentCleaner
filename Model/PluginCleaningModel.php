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
     * @return true
     * @author aljawaid
     */
    public function deletePluginSchemaEntry($plugin_name, $plugin_schema_version)
    {
        //$plugin_name = $this->request->getStringParam('plugin_name');

        if ($this->db->table('plugin_schema_versions')->eq('plugin', $plugin_name)->exists()) {
            $this->db->table('plugin_schema_versions')->eq('plugin', $plugin_name)->remove();
        }

        return true;
    }
}
