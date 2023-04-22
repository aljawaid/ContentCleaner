<div id="RemoveTableHeader" class="modal-page-header">
    <h2 class="relative">
        <span class="content-cleaner-icon"></span> <?= t('Content Cleaner') ?>
        <span class="modal-title">
            <span class="db-settings-icon"></span> <?= t('Delete Table') ?> <span class="modal-reset-settings"></span>
        </span>
    </h2>
</div>
<div id="RemoveTableContent" class="modal-contents">
    <div class="confirm">
        <p class="confirm-notice">
            <?= t('Click the button to remove this table from the database') ?>
        </p>
        <ul class="job-tables fa-ul">
            <li class="job-tables-title">
                <i class="fa fa-table fa-li" aria-hidden="true"></i><?= t('Table Affected') ?>
            </li>
            <li class="job-tables-table"><?= $table ?></li>
        </ul>
        <span id="JobType"><?= t('Deep Cleaning') ?></span>
        <?= $this->modal->confirmButtons('CleaningController', 'removeTable', array('table' => $table, 'plugin' => 'ContentCleaner'), t('Delete Table')) ?>
    </div>
</div>
