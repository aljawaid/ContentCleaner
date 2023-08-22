<?php
    $incomingController = $this->app->getRouterController();
    $outgoingAction = $this->app->getRouterAction();
?>

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

<div id="ResetDefaultsModal" class="content-cleaner-modal">
    <div class="modal-page-header">
        <h2 class="relative">
            <span class="modal-title">
                <span class="content-cleaner-icon"></span> <?= $title ?>
                <span class="job-number" title="<?= t('Cleaning Job Number') ?>"><?= $job ?></span>
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
                        <li class="job-tables-table"><?= $table ?></li>
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
                        <li class="job-tables-table"><?= $table ?></li>
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
                        <li class="job-tables-table"><?= $table ?></li>
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
                        <li class="job-tables-table"><?= $table ?></li>
                    </ul>
                </p>
            <?php endif ?>

            <span id="JobType">
                <span class="application-icon"></span> <?= t('Application Cleaning Jobs') ?>
            </span>
        </div>
    </div>
    <div class="modal-actions">

        <!-- ContentCleaner: APPLICATION CLEANING JOB 01 -->
        <?php if (($incomingController == 'CleaningController') && ($outgoingAction == 'confirmSessionsPurge')): ?>
            <?= $this->modal->confirmButtons('CleaningController', 'purgeSessionsData', array('plugin' => 'ContentCleaner'), t('Process Job')) ?>

        <!-- ContentCleaner: APPLICATION CLEANING JOB 02 -->
        <?php elseif (($incomingController == 'CleaningController') && ($outgoingAction == 'confirmResetCalendar')): ?>
            <?= $this->modal->confirmButtons('CleaningController', 'resetCalendarSettings', array('plugin' => 'ContentCleaner'), t('Process Job')) ?>

        <!-- ContentCleaner: APPLICATION CLEANING JOB 03 -->
        <?php elseif (($incomingController == 'CleaningController') && ($outgoingAction == 'confirmRememberMePurge')): ?>
            <?= $this->modal->confirmButtons('CleaningController', 'purgeRememberMeData', array('plugin' => 'ContentCleaner'), t('Process Job')) ?>

        <!-- ContentCleaner: APPLICATION CLEANING JOB 04 -->
        <?php elseif (($incomingController == 'CleaningController') && ($outgoingAction == 'confirmRememberMeDuplicatesPurge')): ?>
            <?= $this->modal->confirmButtons('CleaningController', 'deleteRememberMeDuplicatesData', array('plugin' => 'ContentCleaner'), t('Process Job')) ?>
        <?php endif ?>

    </div>
</div>
