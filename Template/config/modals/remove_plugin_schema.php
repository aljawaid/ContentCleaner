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

<div class="delete-schema-modal">
    <div class="cc-page-header">
        <h2 class=""><?= $title ?></h2>
    </div>
    <div class="confirm">
        <p class="confirm-delete">
            <?= e('Do you really want to remove the entry for %s?', '<strong>' . $plugin_job_name . '</strong>') ?>
        </p>
        <div class="form-actions">
            <?= $this->url->link(t('Deep Clean'), 'PluginCleaningController', 'deletePluginSchemaEntry', array('plugin_name' => $plugin_name, 'plugin' => 'ContentCleaner'), true, 'btn btn-ab-delete') ?>
            <button class="btn cancel-btn js-modal-close" href="#"><?= t('Cancel') ?></button>
        </div>
    </div>
</div>
