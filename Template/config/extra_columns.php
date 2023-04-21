<?php $check_columns = $this->helper->defaultTableHelper->checkColumnsViaPlugin($table, $columns); ?>
<div class="modal-page-header">
    <h2 class="relative">
        <span class="content-cleaner-icon"></span> <?= t('A deep look into your extra columns') ?> <span class="modal-template-id"></span>
        </span>
    </h2>
</div>
<form method="post" action="<?= $this->url->href('CleaningController', 'removeSelectedColumns', array('table' => $table, 'plugin' => 'ContentCleaner')) ?>" autocomplete="off">

<div id="ViewColumns" class="modal-contents">
    <div class="confirm">
        <p class="confirm-notice">
            <?= t('The below columns are not part of Kanboard Default Columns for the table: ') . $table ?>
            <div class="template-contents">
                <div class="template-title"></div>
            </div>
            <br>
            <div class="content-cleaner-columns-list">
                <?php foreach ($columns as $column): ?>
                        <?= $this->form->checkbox($column, $column . ' ' . t('created by') . ' ' .  $check_columns[$column] . ' ' . t('plugin'), 1, false) ?>
                <?php endforeach ?>
            </div>
        </p>

    <?= $this->modal->submitButtons(array('submitLabel' =>  t('Remove Selected?'))) ?>
    </div>
</div>
