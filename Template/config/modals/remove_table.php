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
                <li class="job-tables-table"><?= $table ?></li>
            </ul>
        </div>
    </div>
    <div class="modal-actions">
        <?= $this->modal->confirmButtons('CleaningController', 'removeTable', array('table' => $table, 'plugin' => 'ContentCleaner'), t('Delete Table')) ?>
    </div>
</div>
