<?php
    $incomingController = $this->app->getRouterController();
    $outgoingAction = $this->app->getRouterAction();
?>

<div id="ResetModalSettingsHeader" class="modal-page-header">
    <h2 class="relative">
        <span class="content-cleaner-icon"></span> <?= t('Confirm Cleaning Job') ?>
        <span class="job-number" title="<?= t('Cleaning Job Number') ?>"><?= $job ?></span>
        <span class="modal-title">

            <?php if (($incomingController == 'CleaningController') && ($outgoingAction =='confirmResetCalendar')): ?>
                <span class="db-settings-icon"></span> <?= t('Reset Settings') ?> <span class="modal-reset-settings"></span>
            <?php elseif (($incomingController == 'CleaningController') && ($outgoingAction =='confirmSessionsPurge')): ?>
                <span class="db-settings-icon"></span> <?= t('Reset Sessions') ?> <span class="modal-reset-settings"></span>
            <?php endif ?>

        </span>
    </h2>
</div>
<div id="ResetModalSettingsContent" class="modal-contents">
    <div class="confirm">

        <?php if (($incomingController == 'CleaningController') && ($outgoingAction =='confirmResetCalendar')): ?>
            <p class="confirm-notice">
                <?= t('Click the button to restore the calendar settings to the default values') ?>
                <ul class="job-tables fa-ul">
                    <li class="job-tables-title">
                        <i class="fa fa-table fa-li" aria-hidden="true"></i><?= t('Table Affected') ?>
                    </li>
                    <li class="job-tables-table"><?= $table ?></li>
                </ul>
            </p>
            <?= $this->modal->confirmButtons('CleaningController', 'resetCalendarSettings', array('plugin' => 'ContentCleaner'), t('Process Job')) ?>
        <?php endif ?>

        <?php if (($incomingController == 'CleaningController') && ($outgoingAction =='confirmSessionsPurge')): ?>
            <p class="confirm-notice">
                <?= t('Click the button to empty the sessions table') ?>
                <ul class="job-tables fa-ul">
                    <li class="job-tables-title">
                        <i class="fa fa-table fa-li" aria-hidden="true"></i><?= t('Table Affected') ?>
                    </li>
                    <li class="job-tables-table"><?= $table ?></li>
                </ul>
            </p>
            <?= $this->modal->confirmButtons('CleaningController', 'purgeSessionsData', array('plugin' => 'ContentCleaner'), t('Process Job')) ?>
        <?php endif ?>

    </div>
</div>
