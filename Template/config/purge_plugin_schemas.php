<div class="modal-page-header">
    <h2 class="relative">
        <span class="content-cleaner-icon"></span> <?= t('Automatic Cleaning') ?> <span class="modal-template-id"></span>
        </span>
    </h2>
</div>
<div id="DeleteModal" class="modal-contents">
    <div class="confirm">
        <p class="confirm-notice">
            <?= t('Click the button to purge the database of unused plugin schema data') ?>
            <div class="template-contents">
                <div class="template-title"></div>
            </div>
        </p>

    <?= $this->modal->confirmButtons(
    'CleaningController',
    'pluginSchemaPurge',
    array('plugin' => 'ContentCleaner'),
    t('Purge')
) ?>
    </div>
</div>
