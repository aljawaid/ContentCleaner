<div class="modal-page-header">
    <h2 class="relative">
        <span class="content-cleaner-icon"></span> <?= t('Automatic Cleaning') ?> <span class="modal-template-id"></span>
        </span>
    </h2>
</div>
<div id="DeleteModal" class="modal-contents">
    <div class="confirm">
        <p class="confirm-notice">
            <?= t('Click the button to automatically remove all unknown tables & columns left left over from uninstalled plugins, and then purge the plugin_schema_versions table of their presence.') ?>
            <div class="template-contents">
                <div class="template-title"></div>
            </div>
        </p>

    <?= $this->modal->confirmButtons(
    'CleaningController',
    'autoPurgeAndClean',
    array('plugin' => 'ContentCleaner'),
    t('Clean')
) ?>
    </div>
</div>
