<!-- ContentCleaner: AUTOMATIC CLEANING JOB 02 -->
<div id="AutoPurgeCleanModal" class="content-cleaner-modal">
    <div class="modal-page-header">
        <h2 class="relative">
            <span class="modal-title">
                <span class="content-cleaner-icon"></span> <?= $title ?>
                <span class="job-number" title="<?= t('Cleaning Job Number') ?>"><?= $this->text->e($job) ?></span>
            </span>
            <span class="modal-subtitle">
                <span class="db-settings-icon"></span> <?= t('All Unknown Tables and Columns') ?>
            </span>
        </h2>
    </div>
    <div class="modal-contents">
        <div class="confirm">
            <p class="confirm-notice">
                <?= t('Review and select only the allowlisted database artefacts which belong to uninstalled plugins.') ?>
            </p>
            <?php if ($candidates === array()): ?>
                <p class="alert alert-info"><?= t('No reviewed cleanup candidates are currently available.') ?></p>
            <?php else: ?>
                <p class="alert alert-info">
                    <i class="fa fa-info-circle" aria-hidden="true"></i>
                    <?= t('Unknown items are never deleted automatically. Each selection is checked again immediately before execution.') ?>
                </p>
            <?php endif ?>
            <span id="JobType">
                <span class="automatic-icon"></span> <?= t('Automatic Cleaning Jobs') ?>
            </span>
        </div>
    </div>
    <div class="modal-actions">
        <form method="post" action="<?= $this->url->href('CleaningController', 'autoPurgeAndClean', array('plugin' => 'ContentCleaner')) ?>">
            <?= $this->form->csrf() ?>
            <?php if ($candidates !== array()): ?>
                <ul class="cleanup-preview-list">
                    <?php foreach ($candidates as $candidate): ?>
                        <li>
                            <label>
                                <input type="checkbox" name="cleanup_items[]" value="<?= $this->text->e($candidate['token']) ?>">
                                <strong><?= $this->text->e($candidate['plugin_title']) ?>:</strong>
                                <?php if ($candidate['type'] === 'table'): ?>
                                    <?= t('table') ?> <code><?= $this->text->e($candidate['table']) ?></code>
                                <?php elseif ($candidate['type'] === 'column'): ?>
                                    <?= t('column') ?> <code><?= $this->text->e($candidate['table'] . '.' . $candidate['column']) ?></code>
                                <?php else: ?>
                                    <?= t('plugin registration') ?> <code><?= $this->text->e($candidate['plugin_name']) ?></code>
                                <?php endif ?>
                            </label>
                        </li>
                    <?php endforeach ?>
                </ul>
                <label class="backup-confirmation">
                    <input type="checkbox" name="backup_confirmed" value="1" required>
                    <?= t('I confirm that a current database backup is available.') ?>
                </label>
                <?= $this->modal->submitButtons(array('submitLabel' => t('Clean Selected Items'))) ?>
            <?php endif ?>
        </form>
    </div>
</div>
