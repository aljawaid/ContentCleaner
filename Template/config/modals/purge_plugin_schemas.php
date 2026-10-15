<!-- ContentCleaner: AUTOMATIC CLEANING JOB 01 -->
<div id="PurgePluginSchemasModal" class="content-cleaner-modal">
    <div class="modal-page-header">
        <h2 class="relative">
            <span class="modal-title">
                <span class="content-cleaner-icon"></span> <?= $title ?>
                <span class="job-number" title="<?= t('Cleaning Job Number') ?>"><?= $this->text->e($job) ?></span>
            </span>
            <span class="modal-subtitle">
                <span class="db-settings-icon"></span> <?= t('Plugin Registration Entries') ?>
            </span>
        </h2>
    </div>
    <div class="modal-contents">
        <div class="confirm">
            <p class="confirm-notice">
                <?= t('Select the reviewed plugin registration entries to remove.') ?>
            </p>
            <?php if ($candidates === array()): ?>
                <p class="alert alert-info"><?= t('No stale reviewed plugin registrations are available.') ?></p>
            <?php endif ?>
            <span id="JobType">
                <span class="automatic-icon"></span> <?= t('Automatic Cleaning Jobs') ?>
            </span>
        </div>
    </div>
    <div class="modal-actions">
        <form method="post" action="<?= $this->url->href('CleaningController', 'pluginSchemaPurge', array('plugin' => 'ContentCleaner')) ?>">
            <?= $this->form->csrf() ?>
            <?php foreach ($candidates as $candidate): ?>
                <label class="cleanup-preview-item">
                    <input type="checkbox" name="cleanup_items[]" value="<?= $this->text->e($candidate['token']) ?>">
                    <?= $this->text->e($candidate['plugin_title']) ?>
                    (<code><?= $this->text->e($candidate['plugin_name']) ?></code>)
                </label>
            <?php endforeach ?>
            <?php if ($candidates !== array()): ?>
                <?= $this->modal->submitButtons(array('submitLabel' => t('Purge Selected'))) ?>
            <?php endif ?>
        </form>
    </div>
</div>
