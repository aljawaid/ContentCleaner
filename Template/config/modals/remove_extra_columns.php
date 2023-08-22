<?php $check_columns = $this->helper->defaultTableHelper->checkColumnsViaPlugin($table, $columns); ?>

<style type="text/css">
    /* MODAL SIZE */
    #modal-box {
        width: auto !important;
        overflow: hidden;
    }

    #modal-content {
        padding: 10px 15px;
    }

    /* MODAL CLOSE BUTTON */
    #modal-close-button {
        transform: scale(1.5);
        display: inline-block;
        position: absolute;
        right: 5px;
        top: 6px;
        background: var(--pp-red-alt-2);
        padding: 3px 3px 5px 6px;
        border-bottom-left-radius: 3px;
        box-shadow: -1px -1px 0 3px var(--pp-white);
        z-index: 1;
    }

    #modal-close-button i {
        color: var(--pp-white);
        transition: var(--transition-c-cleaner);
    }

    #modal-close-button:hover i {
        color: var(--pp-grey);
        text-shadow: 0 0 1px var(--pp-white);
    }
</style>

<div id="ExtraColumnsModal" class="content-cleaner-modal">
    <div class="modal-page-header">
        <h2 class="relative">
            <span class="modal-title">
                <span class="content-cleaner-icon"></span> <?= $title ?>
            </span>
            <span class="modal-subtitle">
                <span class="db-settings-icon"></span> <?= t('Delete Columns') ?>
            </span>
        </h2>
    </div>
    <form method="post" action="<?= $this->url->href('CleaningController', 'removeSelectedColumns', array('table' => $table, 'plugin' => 'ContentCleaner')) ?>" autocomplete="off">
        <div class="modal-contents">
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
                                <li class="job-columns-name" title="<?= t('Created by %s plugin', $check_columns[$column]) ?>">
                                    <?= $this->form->checkbox($column, $column, 1, false) ?>
                                    <span class="job-columns-plugin">
                                        <span class="plugin-icon"></span> <?= $check_columns[$column] ?>
                                    </span>
                                </li>
                            <?php endforeach ?>
                        </ol>
                    </li>
                </ul>
            </div>
        </div>
        <div class="modal-actions">
            <?= $this->modal->submitButtons(array('submitLabel' => t('Delete Selected'))) ?>
        </div>
    </form>
</div>
