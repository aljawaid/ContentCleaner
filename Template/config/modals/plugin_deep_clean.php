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
                    <!-- ContentCleaner: PLUGIN DEEP CLEAN PLUGIN TABLES -->
                    <?php if (($incomingController == 'PluginCleaningController') && ($outgoingAction == 'confirmDeletePluginTables')): ?>
                        <?php if (isset($plugin['plugin_tables'])): ?>
                            <li class="plugin-job-delete-item">
                                <i class="fa fa-check fa-li pp-green" aria-hidden="true"></i>
                                <i class="fa fa-table" aria-hidden="true"></i> <?= t('Plugin Tables') ?>
                            </li>
                        <?php endif ?>
                    <?php endif ?>
                    <!-- ContentCleaner: PLUGIN DEEP CLEAN CORE TABLE COLUMNS -->
                    <?php if (($incomingController == 'PluginCleaningController') && ($outgoingAction == 'confirmDeleteCoreTableColumns')): ?>
                        <?php if (isset($plugin['core_table_columns'])): ?>
                            <li class="plugin-job-delete-item">
                                <i class="fa fa-check fa-li pp-green" aria-hidden="true"></i>
                                <i class="fa fa-columns" aria-hidden="true"></i> <?= t('Core Table Columns') ?>
                            </li>
                        <?php endif ?>
                    <?php endif ?>
                <?php endif ?>
            <?php endforeach ?>
        </ul>
        <span id="JobType">
            <span class="plugin-icon"></span> <?= t('Plugin Deep Cleaning') ?>
        </span>
        <!-- ContentCleaner: PLUGIN DEEP CLEAN PLUGIN TABLES -->
        <?php if (($incomingController == 'PluginCleaningController') && ($outgoingAction == 'confirmDeletePluginTables')): ?>
            <?= $this->modal->confirmButtons('PluginCleaningController', 'deletePluginTables', array('plugin_name' => $plugin_name, 'plugin' => 'ContentCleaner'), t('Deep Clean Plugin')) ?>
        <?php endif ?>
        <!-- ContentCleaner: PLUGIN DEEP CLEAN CORE TABLE COLUMNS -->
        <?php if (($incomingController == 'PluginCleaningController') && ($outgoingAction == 'confirmDeleteCoreTableColumns')): ?>
            <?= $this->modal->confirmButtons('PluginCleaningController', 'deleteCoreTableColumns', array('plugin_name' => $plugin_name, 'plugin' => 'ContentCleaner'), t('Deep Clean Plugin')) ?>
        <?php endif ?>
    </div>
</div>
