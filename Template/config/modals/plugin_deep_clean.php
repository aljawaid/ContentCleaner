<?php
    $incomingController = $this->app->getRouterController();
    $outgoingAction = $this->app->getRouterAction();
?>

<div id="RemovePluginHeader" class="modal-page-header">
    <h2 class="relative">
        <span class="content-cleaner-icon"></span> <?= t('Confirm Deep Clean') ?>
        <span class="modal-title">
            <span class="plugin-icon"></span> <?= t('Deep Clean Plugin') ?> <span class="modal-reset-settings"></span>
        </span>
    </h2>
</div>
<div id="RemovePluginContent" class="modal-contents">
    <div class="confirm">
        <p class="confirm-notice">
            <?= t('Process this job to complete the actions listed below for %s.', $plugin_job_name) ?>
        </p>
        <ul class="plugin-job-delete fa-ul">
            <div class="plugin-job-delete-title"><?= t('Job Actions') ?></div>
            <?php $deletable_plugins = $this->helper->pluginCleaningHelper->getDeletablePlugins(); ?>
            <?php foreach ($deletable_plugins as $plugin): ?>
                <?php if ($plugin['plugin_title'] == $plugin_job_name): ?>
                    <?php if (($incomingController == 'PluginCleaningController') && ($outgoingAction == 'confirmDeletePluginTables')): ?>
                        <?php if (isset($plugin['plugin_tables'])): ?>
                            <!-- ContentCleaner: PLUGIN DEEP CLEAN PLUGIN TABLES -->
                            <li class="plugin-job-delete-item">
                                <i class="fa fa-check fa-li pp-green" aria-hidden="true"></i>
                                <i class="fa fa-table" aria-hidden="true"></i> <?= t('Plugin Tables') ?>
                            </li>
                            <p class="">
                                <?= t('For the plugin to recreate the tables automatically after this deep clean, you need to run Plugin Registration deep clean.') ?>
                            </p>
                        <?php endif ?>
                    <?php endif ?>
                    <?php if (($incomingController == 'PluginCleaningController') && ($outgoingAction == 'confirmDeleteCoreTableColumns')): ?>
                        <?php if (isset($plugin['core_table_columns'])): ?>
                            <!-- ContentCleaner: PLUGIN DEEP CLEAN CORE TABLE COLUMNS -->
                            <li class="plugin-job-delete-item">
                                <i class="fa fa-check fa-li pp-green" aria-hidden="true"></i>
                                <i class="fa fa-columns" aria-hidden="true"></i> <?= t('Core Table Columns') ?>
                            </li>
                        <?php endif ?>
                    <?php endif ?>
                    <?php if (($incomingController == 'PluginCleaningController') && ($outgoingAction == 'confirmDeleteCoreTableEntries')): ?>
                        <?php if (isset($plugin['core_table_entries'])): ?>
                            <!-- ContentCleaner: PLUGIN DEEP CLEAN CORE TABLE ENTRIES -->
                            <li class="plugin-job-delete-item">
                                <i class="fa fa-check fa-li pp-green" aria-hidden="true"></i>
                                <i class="fa fa-tasks" aria-hidden="true"></i> <?= t('Core Table Entries') ?>
                            </li>
                        <?php endif ?>
                    <?php endif ?>
                    <?php if (($incomingController == 'PluginCleaningController') && ($outgoingAction == 'confirmDeletePluginSchemaEntry')): ?>
                        <?php if (isset($plugin['plugin_schema_version'])): ?>
                            <!-- ContentCleaner: PLUGIN DEEP CLEAN PLUGIN SCHEMA ENTRY -->
                            <li class="plugin-job-delete-item">
                                <i class="fa fa-check fa-li pp-green" aria-hidden="true"></i>
                                <span class="db-database-icon"></span> <?= t('Plugin Schema Registration Entry') ?>
                            </li>
                        <?php endif ?>
                    <?php endif ?>
                <?php endif ?>
            <?php endforeach ?>
        </ul>
        <span id="JobType">
            <span class="plugin-icon"></span> <?= t('Plugin Deep Cleaning') ?>
        </span>
        <?php if (($incomingController == 'PluginCleaningController') && ($outgoingAction == 'confirmDeletePluginTables')): ?>
            <!-- ContentCleaner: PLUGIN DEEP CLEAN PLUGIN TABLES -->
            <?= $this->modal->confirmButtons('PluginCleaningController', 'deletePluginTables', array('plugin_job_name' => $plugin_job_name, 'plugin' => 'ContentCleaner'), t('Deep Clean')) ?>
        <?php endif ?>
        <?php if (($incomingController == 'PluginCleaningController') && ($outgoingAction == 'confirmDeleteCoreTableColumns')): ?>
            <!-- ContentCleaner: PLUGIN DEEP CLEAN CORE TABLE COLUMNS -->
            <?= $this->modal->confirmButtons('PluginCleaningController', 'deleteCoreTableColumns', array('plugin_job_name' => $plugin_job_name, 'plugin' => 'ContentCleaner'), t('Deep Clean')) ?>
        <?php endif ?>
        <?php if (($incomingController == 'PluginCleaningController') && ($outgoingAction == 'confirmDeleteCoreTableEntries')): ?>
            <!-- ContentCleaner: PLUGIN DEEP CLEAN CORE TABLE ENTRIES -->
            <?= $this->modal->confirmButtons('PluginCleaningController', 'deleteCoreTableEntries', array('plugin_job_name' => $plugin_job_name, 'plugin' => 'ContentCleaner'), t('Deep Clean')) ?>
        <?php endif ?>
        <?php if (($incomingController == 'PluginCleaningController') && ($outgoingAction == 'confirmDeletePluginSchemaEntry')): ?>
            <!-- ContentCleaner: PLUGIN DEEP CLEAN PLUGIN SCHEMA ENTRY -->
            <?= $this->modal->confirmButtons('PluginCleaningController', 'deletePluginSchemaEntry', array('plugin_name' => $plugin_name, 'plugin' => 'ContentCleaner'), t('Deep Clean')) ?>
        <?php endif ?>
    </div>
</div>
