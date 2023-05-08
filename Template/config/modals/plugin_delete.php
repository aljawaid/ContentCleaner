<div id="RemovePluginHeader" class="modal-page-header">
    <h2 class="relative">
        <span class="content-cleaner-icon"></span> <?= t('Confirm Cleaning Job') ?>
        <span class="job-number" title="<?= t('Cleaning Job Number') ?>"><?= $job_number ?></span>
        <span class="modal-title">
            <span class="plugin-icon"></span> <?= t('Deep Clean Plugin') ?> <span class="modal-reset-settings"></span>
        </span>
    </h2>
</div>
<div id="RemovePluginContent" class="modal-contents">
    <div class="confirm">
        <p class="confirm-notice">
            <?= t('Process this job to completely remove %s from the database.', $plugin_job_name) ?>
        </p>
        <span id="JobType">
            <span class="plugin-icon"></span> <?= t('Plugin Cleaning') ?>
        </span>
        <?= $this->modal->confirmButtons('PluginCleaningController', 'deletePlugin', array('plugin_name' => $plugin_name, 'plugin' => 'ContentCleaner'), t('Delete Plugin')) ?>
    </div>
</div>
