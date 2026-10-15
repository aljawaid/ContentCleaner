<div id="RemovePluginCoreTableEntriesModal" class="content-cleaner-modal">
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
                        <span class="message-text"><?= t('%s is detected as installed. You should uninstall %s before completing this action to avoid the automatic creation of any database table entries related to the plugin.', $this->text->e($plugin_job_name), $this->text->e($plugin_job_name)) ?></span>
                    </h3>
                </section>
            <?php endif ?>
            <p class="confirm-notice">
                <?= e('Do you really want to delete the core database table entries created by %s?', '<strong>' . $this->text->e($plugin_job_name) . '</strong>') ?>
            </p>
            <span id="JobType">
                <span class="plugin-icon"></span> <?= t('Plugin Deep Cleaning') ?>
            </span>
        </div>
        <div class="modal-actions">
            <form method="post" action="<?= $this->url->href('PluginCleaningController', 'deleteCoreTableEntries', array('plugin' => 'ContentCleaner')) ?>">
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
</div>
