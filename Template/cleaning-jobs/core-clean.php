<!-- ContentCleaner: APPLICATION CLEANING JOB 01 -->
<div class="job-section-wrapper">
    <fieldset class="job-wrapper relative">
        <legend class="job-title">
            <span class="content-cleaner-icon"></span> <?= t('Purge Sessions') ?>
            <!-- ContentCleaner: DO NOT CHANGE JOB NUMBERS -->
            <span class="job-number-wrapper" title="<?= t('Cleaning Job Number') ?>"><span class="job-number">01</span></span>
        </legend>
        <p class="job-desc">
            <?= t('User sessions can build up needlessly over time. It is safe to clear this table from time to time for expired entries.') ?>
        </p>
        <div class="job-content">
            <ul class="job-tables fa-ul">
                <li class="job-tables-title">
                    <i class="fa fa-table fa-li" aria-hidden="true"></i><?= t('Table Affected') ?>
                </li>
                <li class="job-tables-table">sessions</li>
            </ul>
            <ul class="job-table-size fa-ul">
                <li class="job-tables-title">
                    <i class="fa fa-table fa-li" aria-hidden="true"></i><?= t('Table Contents') ?>
                </li>
                <li class="job-tables-data">
                    <span class="table-data-info">
                        <?= $this->helper->cleaningHelper->countSessions() ?> <?= ($this->helper->cleaningHelper->countSessions() > 1) ? t('Entries') : t('Entry') ?>
                    </span>
                </li>
            </ul>
            <ul class="job-result fa-ul">
                <li class="job-result-title"><i class="fa fa-check fa-li" aria-hidden="true"></i><?= t('Job Result') ?></li>
                <li class="job-result-text"><?= t('The table will be emptied leaving the current single session entry in the table.') ?></li>
            </ul>
        </div>
        <div class="form-actions">
            <a href="<?= $this->url->href('CleaningController', 'confirmSessionsPurge', array('table' => 'sessions', 'job' => '01', 'plugin' => 'ContentCleaner'), false, '', false) ?>" class="btn job-btn js-modal-confirm"><span class="content-cleaner-icon"></span> <?= t('Purge Sessions') ?></a>
        </div>
    </fieldset>
</div>

<!-- ContentCleaner: APPLICATION CLEANING JOB 02 -->
<div class="job-section-wrapper">
    <fieldset class="job-wrapper relative">
        <legend class="job-title">
            <span class="content-cleaner-icon"></span> <?= t('Reset Calendar Settings') ?>
            <!-- ContentCleaner: DO NOT CHANGE JOB NUMBERS -->
            <span class="job-number-wrapper" title="<?= t('Cleaning Job Number') ?>"><span class="job-number">02</span></span>
        </legend>
        <p class="job-desc">
            <?= t('Some calendar plugins alter default settings which affect the project and user views.') ?>
        </p>
        <div class="job-content">
            <ul class="job-tables fa-ul">
                <li class="job-tables-title">
                    <i class="fa fa-table fa-li" aria-hidden="true"></i><?= t('Table Affected') ?>
                </li>
                <li class="job-tables-table">settings</li>
            </ul>
            <ul class="job-result fa-ul">
                <li class="job-result-title"><i class="fa fa-check fa-li" aria-hidden="true"></i><?= t('Job Result') ?></li>
                <li class="job-result-text"><?= t('The settings for') ?> <code>calendar_project_tasks</code> <?= t('and') ?> <code>calendar_user_tasks</code> <?= t('will be reset to the value') ?> <code>date_started</code>.</li>
            </ul>
        </div>
        <div class="form-actions">
            <a href="<?= $this->url->href('CleaningController', 'confirmResetCalendar', array('table' => 'settings', 'job' => '02', 'plugin' => 'ContentCleaner'), false, '', false) ?>" class="btn job-btn js-modal-confirm"><span class="content-cleaner-icon"></span> <?= t('Reset Settings') ?></a>
        </div>
    </fieldset>
</div>

<!-- ContentCleaner: APPLICATION CLEANING JOB 03 -->
<div class="job-section-wrapper">
    <fieldset class="job-wrapper relative">
        <legend class="job-title">
            <span class="content-cleaner-icon"></span> <?= t('Remember Me Login Sessions') ?>
            <!-- ContentCleaner: DO NOT CHANGE JOB NUMBERS -->
            <span class="job-number-wrapper" title="<?= t('Cleaning Job Number') ?>"><span class="job-number">03</span></span>
        </legend>
        <p class="job-desc">
            <?= t('By default, entries are automatically deleted after 60 days. Delete all entries for all users.') ?>
        </p>
        <div class="job-content">
            <ul class="job-tables fa-ul">
                <li class="job-tables-title">
                    <i class="fa fa-table fa-li" aria-hidden="true"></i><?= t('Table Affected') ?>
                </li>
                <li class="job-tables-table">remember_me</li>
            </ul>
            <ul class="job-table-size fa-ul">
                <li class="job-tables-title">
                    <i class="fa fa-table fa-li" aria-hidden="true"></i><?= t('Table Contents') ?>
                </li>
                <li class="job-tables-data">
                    <span class="table-data-info">
                        <?php if ($this->helper->cleaningHelper->countRememberMe() == 0): ?>
                            <i style="font-weight: 400;"><?= t('Empty') ?></i>
                        <?php else: ?>
                            <?= $this->helper->cleaningHelper->countRememberMe() ?>
                        <?php endif ?>
                        <?php if ($this->helper->cleaningHelper->countRememberMe() != 0): ?>
                            <?= ($this->helper->cleaningHelper->countRememberMe() > 1) ? t('Entries') : t('Entry') ?>
                        <?php endif ?>
                    </span>
                </li>
            </ul>
            <ul class="job-result fa-ul">
                <li class="job-result-title"><i class="fa fa-check fa-li" aria-hidden="true"></i><?= t('Job Result') ?></li>
                <li class="job-result-text"><?= t('The table will be completely emptied.') ?></li>
            </ul>
        </div>
        <div class="form-actions">
            <a href="<?= $this->url->href('CleaningController', 'confirmRememberMePurge', array('table' => 'remember_me', 'job' => '03', 'plugin' => 'ContentCleaner'), false, '', false) ?>" class="btn job-btn js-modal-confirm"><span class="content-cleaner-icon"></span> <?= t('Purge Login Sessions') ?></a>
        </div>
    </fieldset>
</div>
