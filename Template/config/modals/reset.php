<?php
    $incomingController = $this->app->getRouterController();
    $outgoingAction = $this->app->getRouterAction();
?>

<div class="modal-page-header">
    <h2 class="relative">
        <span class="content-cleaner-icon"></span> <?= t('Confirm Cleaning Job N° ') . $job ?>
        <span class="modal-title">
            <?php if (($incomingController == 'CleaningController') && ($outgoingAction =='confirmReset')): ?>
                <span class="db-settings-icon"></span> <?= t('Reset Settings') ?> <span class="modal-template-id"></span>
            <?php endif ?>
        </span>
    </h2>
</div>
<div id="DeleteModal" class="modal-contents">
    <div class="confirm">
        <?php if (($incomingController == 'CleaningController') && ($outgoingAction =='confirmReset')): ?>
            <p class="confirm-notice">
                <?= t('Click the button to restore the calendar settings to the default values in the \'%s\' table', $table) ?>
            </p>
            <?= $this->modal->confirmButtons('CleaningController', 'resetCalendarSettings', array('plugin' => 'ContentCleaner'), t('Reset')) ?>
        <?php endif ?>
    </div>
</div>
