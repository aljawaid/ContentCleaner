<div id="RemoveTableModal" class="content-cleaner-modal">
    <div class="modal-page-header">
        <h2 class="relative">
            <span class="modal-title">
                <span class="content-cleaner-icon"></span> <?= $title ?>
            </span>
            <span class="modal-subtitle">
                <span class="db-settings-icon"></span> <?= t('Delete Table') ?>
            </span>
        </h2>
    </div>
    <div class="modal-contents">
        <div class="confirm">
            <p class="confirm-notice">
                <?= t('Proceed to remove this table from the database.') ?>
            </p>
            <ul class="job-tables fa-ul">
                <li class="job-tables-title">
                    <i class="fa fa-table fa-li" aria-hidden="true"></i><?= t('Table Affected') ?>
                </li>
                <li class="job-tables-table"><?= $this->text->e($candidate['table']) ?></li>
            </ul>
        </div>
    </div>
    <div class="modal-actions">
        <form method="post" action="<?= $this->url->href('CleaningController', 'removeTable', array('plugin' => 'ContentCleaner')) ?>">
            <?= $this->form->hidden('candidate', array('candidate' => $candidate['token'])) ?>
            <?= $this->form->csrf() ?>
            <?= $this->modal->submitButtons(array('submitLabel' => t('Delete Table'))) ?>
        </form>
    </div>
</div>
