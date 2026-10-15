<?php
$incomingController = $this->app->getRouterController();
$outgoingAction = $this->app->getRouterAction();
$targetActions = array(
    'confirmSessionsPurge' => 'purgeSessionsData',
    'confirmResetCalendar' => 'resetCalendarSettings',
    'confirmRememberMePurge' => 'purgeRememberMeData',
    'confirmRememberMeDuplicatesPurge' => 'deleteRememberMeDuplicatesData',
);
$targetAction = isset($targetActions[$outgoingAction]) ? $targetActions[$outgoingAction] : '';
?>

<div id="ResetDefaultsModal" class="content-cleaner-modal">
    <div class="modal-page-header">
        <h2 class="relative">
            <span class="modal-title">
                <span class="content-cleaner-icon"></span> <?= $title ?>
                <span class="job-number" title="<?= t('Cleaning Job Number') ?>"><?= $this->text->e($job) ?></span>
            </span>
            <span class="modal-subtitle">

                <!-- ContentCleaner: APPLICATION CLEANING JOB 01 -->
                <?php if (($incomingController == 'CleaningController') && ($outgoingAction == 'confirmSessionsPurge')): ?>
                    <span class="db-settings-icon"></span> <?= t('Purge Sessions') ?>

                <!-- ContentCleaner: APPLICATION CLEANING JOB 02 -->
                <?php elseif (($incomingController == 'CleaningController') && ($outgoingAction == 'confirmResetCalendar')): ?>
                    <span class="db-settings-icon"></span> <?= t('Reset Settings') ?>

                <!-- ContentCleaner: APPLICATION CLEANING JOB 03 -->
                <?php elseif (($incomingController == 'CleaningController') && ($outgoingAction == 'confirmRememberMePurge')): ?>
                    <span class="db-settings-icon"></span> <?= t('Purge Login Sessions') ?>

                <!-- ContentCleaner: APPLICATION CLEANING JOB 04 -->
                <?php elseif (($incomingController == 'CleaningController') && ($outgoingAction == 'confirmRememberMeDuplicatesPurge')): ?>
                    <span class="db-settings-icon"></span> <?= t('Delete Duplicate Login Sessions') ?>
                <?php endif ?>

            </span>
        </h2>
    </div>
    <div class="modal-contents">
        <div class="confirm">

            <!-- ContentCleaner: APPLICATION CLEANING JOB 01 -->
            <?php if (($incomingController == 'CleaningController') && ($outgoingAction == 'confirmSessionsPurge')): ?>
                <p class="confirm-notice">
                    <?= t('Run this job to empty the sessions table.') ?>
                    <ul class="job-tables fa-ul">
                        <li class="job-tables-title">
                            <i class="fa fa-table fa-li" aria-hidden="true"></i><?= t('Table Affected') ?>
                        </li>
                        <li class="job-tables-table"><?= $this->text->e($table) ?></li>
                    </ul>
                </p>
            <?php endif ?>

            <!-- ContentCleaner: APPLICATION CLEANING JOB 02 -->
            <?php if (($incomingController == 'CleaningController') && ($outgoingAction == 'confirmResetCalendar')): ?>
                <p class="confirm-notice">
                    <?= t('Run this job to restore the calendar settings to the default values.') ?>
                    <ul class="job-tables fa-ul">
                        <li class="job-tables-title">
                            <i class="fa fa-table fa-li" aria-hidden="true"></i><?= t('Table Affected') ?>
                        </li>
                        <li class="job-tables-table"><?= $this->text->e($table) ?></li>
                    </ul>
                </p>
            <?php endif ?>

            <!-- ContentCleaner: APPLICATION CLEANING JOB 03 -->
            <?php if (($incomingController == 'CleaningController') && ($outgoingAction == 'confirmRememberMePurge')): ?>
                <p class="confirm-notice">
                    <?= t('Run this job to empty the login sessions table.') ?>
                    <ul class="job-tables fa-ul">
                        <li class="job-tables-title">
                            <i class="fa fa-table fa-li" aria-hidden="true"></i><?= t('Table Affected') ?>
                        </li>
                        <li class="job-tables-table"><?= $this->text->e($table) ?></li>
                    </ul>
                </p>
            <?php endif ?>

            <!-- ContentCleaner: APPLICATION CLEANING JOB 04 -->
            <?php if (($incomingController == 'CleaningController') && ($outgoingAction == 'confirmRememberMeDuplicatesPurge')): ?>
                <p class="confirm-notice">
                    <?= t('Run this job to delete all duplicate sessions leaving the latest record for each user.') ?>
                    <ul class="job-tables fa-ul">
                        <li class="job-tables-title">
                            <i class="fa fa-table fa-li" aria-hidden="true"></i><?= t('Table Affected') ?>
                        </li>
                        <li class="job-tables-table"><?= $this->text->e($table) ?></li>
                    </ul>
                </p>
            <?php endif ?>

            <span id="JobType">
                <span class="application-icon"></span> <?= t('Application Cleaning Jobs') ?>
            </span>
        </div>
    </div>
    <?php if ($incomingController == 'CleaningController' && $targetAction !== ''): ?>
        <div class="modal-actions">
            <form method="post" action="<?= $this->url->href('CleaningController', $targetAction, array('plugin' => 'ContentCleaner')) ?>">
                <?= $this->form->csrf() ?>
                <?= $this->modal->submitButtons(array('submitLabel' => t('Process Job'))) ?>
            </form>
        </div>
    <?php endif ?>
</div>
