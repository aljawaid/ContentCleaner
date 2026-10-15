<div id="RemovePluginTablesModal" class="content-cleaner-modal">
    <div class="modal-page-header">
        <h2 class="relative">
            <span class="modal-title">
                <span class="content-cleaner-icon"></span> <?= $title ?>
            </span>
        </h2>
    </div>
    <div class="modal-contents">
        <div class="confirm warning-confirm">
            <?php if ($cleanup['installed']): ?>
                <section class="content-cleaner-message error cleaner-warning">
                    <header></header>
                    <i class=""></i>
                    <h3 class="">
                        <span class="message-title"><?= t('Warning') ?></span>
                        <span class="message-text"><?= t('%s is detected as installed. You should uninstall %s before completing this action to avoid the automatic creation of any database tables related to the plugin.', $this->text->e($plugin_job_name), $this->text->e($plugin_job_name)) ?></span>
                    </h3>
                </section>
            <?php endif ?>
            <p class="confirm-notice">
                <?= e('Do you really want to delete any database tables which were created by %s?', '<strong>' . $this->text->e($plugin_job_name) . '</strong>') ?>
            </p>
            <p class="alert deep-clean-tip">
                <?= e('For %s to recreate the tables automatically after this deep clean, you will need to run the "Plugin Registration" deep clean.', $this->text->e($plugin_job_name)) ?>
            </p>
            <span id="JobType">
                <span class="plugin-icon"></span> <?= t('Plugin Deep Cleaning') ?>
            </span>
        </div>
    </div>
    <div class="modal-actions">
        <form method="post" action="<?= $this->url->href('PluginCleaningController', 'deletePluginTables', array('plugin' => 'ContentCleaner')) ?>">
            <?= $this->form->hidden('plugin_name', array('plugin_name' => $plugin_name)) ?>
            <?= $this->form->csrf() ?>
            <?php if (!$cleanup['installed'] && $cleanup['candidates'] !== array()): ?>
                <label class="backup-confirmation">
                    <input type="checkbox" name="backup_confirmed" value="1" required>
                    <?= t('I confirm that a current database backup is available.') ?>
                </label>
                <?= $this->modal->submitButtons(array('submitLabel' => t('Deep Clean'))) ?>
            <?php endif ?>
        </form>
    </div>
</div>
