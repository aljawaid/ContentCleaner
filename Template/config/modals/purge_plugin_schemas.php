<div id="PurgePluginSchemasHeader" class="modal-page-header">
    <h2 class="relative">
        <span class="content-cleaner-icon"></span> <?= t('Confirm Cleaning Job') ?>
        <span class="job-number" title="<?= t('Cleaning Job Number') ?>"><?= $job ?></span>
        <span class="modal-title">
            <span class="db-settings-icon"></span> <?= t('Plugin Registration Entries') ?> <span class="modal-reset-settings"></span>
        </span>
    </h2>
</div>
<div id="PurgePluginSchemasContent" class="modal-contents">
    <div class="confirm">
        <p class="confirm-notice">
            <?= t('Click the button to purge the database of unused plugin registration data') ?>
        </p>
        <span id="JobType"><?= t('Automatic Cleaning Jobs') ?></span>
        <?= $this->modal->confirmButtons('CleaningController', 'pluginSchemaPurge', array('plugin' => 'ContentCleaner'), t('Purge')) ?>
    </div>
</div>
