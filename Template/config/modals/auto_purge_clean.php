<!-- ContentCleaner: AUTOMATIC CLEANING JOB 02 -->
<div id="AutoPurgeCleanHeader" class="modal-page-header">
    <h2 class="relative">
        <span class="content-cleaner-icon"></span> <?= t('Confirm Cleaning Job') ?>
        <span class="job-number" title="<?= t('Cleaning Job Number') ?>"><?= $job ?></span>
        <span class="modal-title">
            <span class="db-settings-icon"></span> <?= t('All Unknown Tables and Columns') ?> <span class="modal-reset-settings"></span>
        </span>
    </h2>
</div>
<div id="AutoPurgeCleanContent" class="modal-contents">
    <div class="confirm">
        <p class="confirm-notice">
            <?= t('Automatically remove all unknown tables and columns left over from uninstalled plugins, followed by purging the respective plugin registration entries.') ?>
        </p>
        <span id="JobType">
            <span class="automatic-icon"></span> <?= t('Automatic Cleaning Jobs') ?>
        </span>
        <?= $this->modal->confirmButtons('CleaningController', 'autoPurgeAndClean', array('plugin' => 'ContentCleaner'), t('Deep Clean')) ?>
    </div>
</div>
