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

<div id="DeletePluginModal" class="content-cleaner-modal">
    <div class="modal-page-header">
        <h2 class="relative">
            <span class="modal-title">
                <span class="content-cleaner-icon"></span> <?= $title ?>
                <span class="job-number" title="<?= t('Cleaning Job Number') ?>"><?= $job ?></span>
            </span>
            <span class="modal-subtitle">
                <span class="plugin-icon"></span> <?= t('Delete Plugin') ?>
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
                        <span class="message-text"><?= t('%s is detected as installed. You should uninstall %s before completing this action to avoid the automatic creation of any database table entries related to the plugin.', $plugin_job_name, $plugin_job_name) ?></span>
                    </h3>
                </section>
            <?php endif ?>
            <p class="confirm-notice">
                <?= t('This job will completely remove %s from the database based on the actions below:', $plugin_job_name) ?>
            </p>
            <ul class="plugin-job-delete fa-ul">
                <?php $deletable_plugins = $this->helper->pluginCleaningHelper->getDeletablePlugins(); ?>
                <?php foreach ($deletable_plugins as $plugin): ?>
                    <?php if ($plugin['plugin_title'] == $plugin_job_name): ?>
                        <?php if (isset($plugin['plugin_tables'])): ?>
                            <li class="plugin-job-delete-item">
                                <i class="fa fa-check fa-li pp-green" aria-hidden="true"></i>
                                <i class="fa fa-table" aria-hidden="true"></i> <?= t('Plugin Tables') ?>
                            </li>
                        <?php endif ?>
                        <?php if (isset($plugin['core_table_columns'])): ?>
                            <li class="plugin-job-delete-item">
                                <i class="fa fa-check fa-li pp-green" aria-hidden="true"></i>
                                <i class="fa fa-columns" aria-hidden="true"></i> <?= t('Core Table Columns') ?>
                            </li>
                        <?php endif ?>
                        <?php if (isset($plugin['core_table_entries'])): ?>
                            <li class="plugin-job-delete-item">
                                <i class="fa fa-check fa-li pp-green" aria-hidden="true"></i>
                                <i class="fa fa-tasks" aria-hidden="true"></i> <?= t('Core Table Entries') ?>
                            </li>
                        <?php endif ?>
                        <?php if (isset($plugin['plugin_schema_version'])): ?>
                            <li class="plugin-job-delete-item">
                                <i class="fa fa-check fa-li pp-green" aria-hidden="true"></i>
                                <span class="db-database-icon"></span> <?= t('Plugin Schema Registration Entry') ?>
                            </li>
                        <?php endif ?>
                    <?php endif ?>
                <?php endforeach ?>
            </ul>
            <span id="JobType">
                <span class="plugin-icon"></span> <?= t('Plugin Cleaning Jobs') ?>
            </span>
        </div>
    </div>
    <div class="modal-actions">
        <?= $this->modal->confirmButtons('PluginCleaningController', 'deletePlugin', array('plugin_job_name' => $plugin_job_name, 'plugin' => 'ContentCleaner'), t('Delete Plugin')) ?>
    </div>
</div>
