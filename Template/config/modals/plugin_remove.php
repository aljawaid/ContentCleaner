<div id="RemovePluginHeader" class="modal-page-header">
    <h2 class="relative">
        <span class="content-cleaner-icon"></span> <?= t('Content Cleaner') ?>
        <span class="modal-title">
            <span class="plugin-icon"></span> <?= t('Deep Clean Plugin') ?> <span class="modal-reset-settings"></span>
        </span>
    </h2>
</div>
<div id="RemovePluginContent" class="modal-contents">
    <div class="confirm">
        <p class="confirm-notice">
            <?= t('Click the button to completely remove this plugin from the database') ?>
        </p>
        <span id="JobType"><?= t('Deep Cleaning') ?></span>
        <?= $this->modal->confirmButtons('PluginCleaningController', 'removePlugin', array('table' => $table, 'plugin' => 'ContentCleaner'), t('Delete Table')) ?>
    </div>
</div>