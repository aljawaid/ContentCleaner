<div id="RemovePluginHeader" class="modal-page-header">
    <h2 class="relative">
        <span class="content-cleaner-icon"></span> <?= t('Confirm Cleaning Job') ?>
        <span class="job-number" title="<?= t('Cleaning Job Number') ?>"><?= $job_number ?></span>
        <span class="modal-title">
            <span class="plugin-icon"></span> <?= t('Delete Plugin') ?> <span class="modal-reset-settings"></span>
        </span>
    </h2>
</div>
<div id="RemovePluginContent" class="modal-contents">
    <div class="confirm">
        <p class="confirm-notice">
            <?= t('Process this job to completely remove %s from the database.', $plugin_job_name) ?>
        </p>
        <ul class="plugin-job-delete fa-ul">
            <div class="plugin-job-delete-title"><?= t('Job Actions') ?></div>
            <?php $deletable_plugins = $this->helper->pluginCleaningHelper->getDeletablePlugins(); ?>
            <?php foreach ($deletable_plugins as $plugin): ?>
                <?php if ($plugin['plugin_title'] == $plugin_job_name): ?>
                    <?php if (isset($plugin['plugin_tables'])): ?>
                        <li class="plugin-job-delete-item">
                            <i class="fa fa-check fa-li pp-green" aria-hidden="true"></i>
                            <i class="fa fa-table" aria-hidden="true"></i> <?= t('Plugin Tables') ?>
                        </li>
                    <?php endif ?>
                    <?php if (isset($plugin['core_table_columns'])): ?>
                        <li class="plugin-job-delete-item">
                            <i class="fa fa-check fa-li pp-green" aria-hidden="true"></i>
                            <i class="fa fa-columns" aria-hidden="true"></i> <?= t('Core Table Columns') ?>
                        </li>
                    <?php endif ?>
                    <?php if (isset($plugin['core_table_entries'])): ?>
                        <li class="plugin-job-delete-item">
                            <i class="fa fa-check fa-li pp-green" aria-hidden="true"></i>
                            <i class="fa fa-tasks" aria-hidden="true"></i> <?= t('Core Table Entries') ?>
                        </li>
                    <?php endif ?>
                    <?php if (isset($plugin['plugin_schema_version'])): ?>
                        <li class="plugin-job-delete-item">
                            <i class="fa fa-check fa-li pp-green" aria-hidden="true"></i>
                            <span class="db-database-icon"></span> <?= t('Plugin Schema Registration Entry') ?>
                        </li>
                    <?php endif ?>
                <?php endif ?>
            <?php endforeach ?>
        </ul>
        <span id="JobType">
            <span class="plugin-icon"></span> <?= t('Plugin Cleaning') ?>
        </span>
        <?= $this->modal->confirmButtons('PluginCleaningController', 'deletePlugin', array('plugin_name' => $plugin_name, 'plugin' => 'ContentCleaner'), t('Delete Plugin')) ?>
    </div>
</div>
