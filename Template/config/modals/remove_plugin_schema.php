<style type="text/css">
    /* MODAL SIZE */
    #modal-box {
        width: auto !important;
        min-width: 500px;
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

<div id="RemovePluginSchemaModal" class="content-cleaner-modal">
    <div class="modal-page-header">
        <h2 class="relative">
            <span class="modal-title">
                <span class="content-cleaner-icon"></span> <?= $title ?>
            </span>
        </h2>
    </div>
    <div class="modal-contents">
        <div class="confirm warning-confirm">
            <?php if (file_exists('plugins/' . $folder_name . '')): ?>
                <section class="message error cleaner-warning">
                    <header></header>
                    <i class=""></i>
                    <h3 class="">
                        <span class="message-title"><?= t('Warning') ?></span>
                        <span class="message-text"><?= t('%s is detected as installed. You should uninstall %s before completing this action to avoid the automatic creation of the database entry.', $plugin_job_name, $plugin_job_name) ?></span>
                    </h3>
                </section>
            <?php endif ?>
            <p class="confirm-notice">
                <?= e('Do you really want to delete the entry for %s?', '<strong>' . $plugin_job_name . '</strong>') ?>
            </p>
            <span id="JobType">
                <span class="plugin-icon"></span> <?= t('Plugin Deep Cleaning') ?>
            </span>
        </div>
    </div>
    <div class="modal-actions">
        <?= $this->modal->confirmButtons('PluginCleaningController', 'deletePluginSchemaEntry', array('plugin_name' => $plugin_name, 'plugin' => 'ContentCleaner'), t('Deep Clean'), 1) ?>
    </div>
</div>
