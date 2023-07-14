
<div id="RemovePluginHeader" class="modal-page-header">
    <h2 class="relative">
        <span class="content-cleaner-icon"></span> <?= t('Confirm Deep Clean') ?>
        <span class="modal-title">
            <span class="plugin-icon"></span> <?= t('Deep Clean Plugin') ?> <span class="modal-reset-settings"></span>
        </span>
    </h2>
</div>
<div class="modal-contents">
    <div class="confirm">
        <p class="confirm-notice">
            <?= t('Process this job to complete the actions listed below for %s.', $plugin_job_name) ?>
        </p>
        <ul class="plugin-job-delete fa-ul">
            <div class="plugin-job-delete-title"><?= t('Job Actions') ?></div>
            <?php $deletable_plugins = $this->helper->pluginCleaningHelper->getDeletablePlugins(); ?>
            <?php foreach ($deletable_plugins as $plugin): ?>
                <?php if ($plugin['plugin_title'] == $plugin_job_name): ?>
                        <?php if (isset($plugin['core_table_entries'])): ?>
                            <!-- ContentCleaner: PLUGIN DEEP CLEAN CORE TABLE ENTRIES -->
                            <li class="plugin-job-delete-item">
                                <i class="fa fa-check fa-li pp-green" aria-hidden="true"></i>
                                <i class="fa fa-tasks" aria-hidden="true"></i> <?= t('Core Table Entries') ?>
                            </li>
                        <?php endif ?>
                <?php endif ?>
            <?php endforeach ?>
        </ul>
        <span id="JobType">
            <span class="plugin-icon"></span> <?= t('Plugin Deep Cleaning') ?>
        </span>
            <!-- ContentCleaner: PLUGIN DEEP CLEAN CORE TABLE ENTRIES -->
            <?= $this->modal->confirmButtons('PluginCleaningController', 'deleteCoreTableEntries', array('plugin_job_name' => $plugin_job_name, 'plugin' => 'ContentCleaner'), t('Deep Clean')) ?>
    </div>
</div>
