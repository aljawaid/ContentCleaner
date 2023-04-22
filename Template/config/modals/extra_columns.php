<?php $check_columns = $this->helper->defaultTableHelper->checkColumnsViaPlugin($table, $columns); ?>
<div id="ExtraColumnsHeader" class="modal-page-header">
    <h2 class="relative">
        <span class="content-cleaner-icon"></span> <?= t('Content Cleaner') ?>
        <span class="modal-title">
            <span class="db-settings-icon"></span> <?= t('Delete Columns') ?> <span class="modal-reset-settings"></span>
        </span>
    </h2>
</div>
<form method="post" action="<?= $this->url->href('CleaningController', 'removeSelectedColumns', array('table' => $table, 'plugin' => 'ContentCleaner')) ?>" autocomplete="off">
    <div id="ExtraColumnsContent" class="modal-contents">
        <div class="confirm">
            <p class="confirm-notice">
                <?= t('The columns listed below are not part of the default structure for the table.') ?>
            </p>
            <ul class="job-tables fa-ul">
                <li class="job-tables-title">
                    <i class="fa fa-table fa-li" aria-hidden="true"></i><?= t('Table Affected') ?>
                </li>
                <li class="job-tables-table"><?= $table ?></li>
            </ul>
            <ul class="job-tables fa-ul">
                <li class="job-tables-title extra-columns-title">
                    <i class="fa fa-columns fa-li" aria-hidden="true"></i><?= t('Extra Columns') ?>
                </li>
                <li class="job-columns-list">
                    <ol class="column-list">
                        <?php foreach ($columns as $column): ?>
                            <li class="job-columns-name" title="<?= t('Created by') . ' ' .  $check_columns[$column] . ' ' . t('plugin') ?>">
                                <?= $this->form->checkbox($column, $column, 1, false) ?>
                                <span class="job-columns-plugin">
                                    <span class="plugin-icon"></span> <?= $check_columns[$column] ?>
                                </span>
                            </li>
                        <?php endforeach ?>
                    </ol>
                </li>
            </ul>
            <span id="JobType"><?= t('Deep Cleaning') ?></span>
            <?= $this->modal->submitButtons(array('submitLabel' =>  t('Delete Selected'))) ?>
        </div>
    </div>
</form>
