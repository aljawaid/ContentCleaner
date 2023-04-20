<div class="modal-page-header">
    <h2 class="relative">
        <span class="content-cleaner-icon"></span> <?= t('Content Cleaner') ?>
        <span class="modal-title">
            <span class="db-settings-icon"></span> <?= t('Reset Settings') ?> <span class="modal-template-id"></span>
        </span>
    </h2>
</div>
<div id="DeleteModal" class="modal-contents">
    <div class="confirm">
        <p class="confirm-notice">
            <?= t('Click the button to deep clean the database') ?>
            <div class="template-contents">
                <div class="template-title"></div>
            </div>
        </p>

    <?= $this->modal->confirmButtons(
    'CleaningController',
    'resetCalendarSettings',
    array('plugin' => 'ContentCleaner'),
    t('Reset')
) ?>
    </div>
</div>
