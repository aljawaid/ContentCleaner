<!-- ContentCleaner: APPLICATION CLEANING JOB 01 -->
<div class="job-section-wrapper">
    <fieldset class="job-wrapper relative">
        <legend class="job-title">
            <span class="content-cleaner-icon"></span> <?= t('Purge User Sessions') ?>
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
            <button href="<?= $this->url->href('CleaningController', 'confirmSessionsPurge', array('table' => 'sessions', 'job' => '01', 'plugin' => 'ContentCleaner'), false, '', false) ?>" class="btn job-btn js-modal-confirm"><span class="content-cleaner-icon"></span> <?= t('Purge Sessions') ?></button>
        </div>
    </fieldset>
</div>

<!-- ContentCleaner: APPLICATION CLEANING JOB 02 -->
<div class="job-section-wrapper">
    <fieldset class="job-wrapper relative">
        <legend class="job-title">
            <span class="content-cleaner-icon"></span> <?= t('Restore Calendar Settings') ?>
            <!-- ContentCleaner: DO NOT CHANGE JOB NUMBERS -->
            <span class="job-number-wrapper" title="<?= t('Cleaning Job Number') ?>"><span class="job-number">02</span></span>
        </legend>
        <p class="job-desc">
            <?= t('Calendar plugins can alter the default settings project and user views affecting how tasks are displayed based on start and due dates.') ?>
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
                <li class="job-result-text"><?= e('The settings for %s and %s will be reset to the default value', '<code>calendar_project_tasks</code>', '<code>calendar_user_tasks</code>') ?>.</li>
            </ul>
        </div>
        <div class="form-actions">
            <button href="<?= $this->url->href('CleaningController', 'confirmResetCalendar', array('table' => 'settings', 'job' => '02', 'plugin' => 'ContentCleaner'), false, '', false) ?>" class="btn job-btn js-modal-confirm"><span class="content-cleaner-icon"></span> <?= t('Reset Calendar Settings') ?></button>
        </div>
    </fieldset>
</div>

<!-- ContentCleaner: APPLICATION CLEANING JOB 03 -->
<div class="job-section-wrapper">
    <fieldset class="job-wrapper relative">
        <legend class="job-title">
            <span class="content-cleaner-icon"></span> <?= t('Delete Remember Me Login Sessions') ?>
            <!-- ContentCleaner: DO NOT CHANGE JOB NUMBERS -->
            <span class="job-number-wrapper" title="<?= t('Cleaning Job Number') ?>"><span class="job-number">03</span></span>
        </legend>
        <p class="job-desc">
            <?= t('By default, login sessions are automatically deleted after 60 days. This job will delete all entries for all users.') ?>
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
                            <i style="font-weight: 400; color: var(--pp-green-dark);"><?= t('Empty') ?></i>
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
            <button href="<?= $this->url->href('CleaningController', 'confirmRememberMePurge', array('table' => 'remember_me', 'job' => '03', 'plugin' => 'ContentCleaner'), false, '', false) ?>" class="btn job-btn js-modal-confirm"><span class="content-cleaner-icon"></span> <?= t('Delete Login Sessions') ?></button>
        </div>
    </fieldset>
</div>

<!-- ContentCleaner: APPLICATION CLEANING JOB 04 -->
<div class="job-section-wrapper">
    <fieldset class="job-wrapper relative">
        <legend class="job-title">
            <span class="content-cleaner-icon"></span> <?= t('Delete Duplicate Remember Me Login Sessions') ?>
            <!-- ContentCleaner: DO NOT CHANGE JOB NUMBERS -->
            <span class="job-number-wrapper" title="<?= t('Cleaning Job Number') ?>"><span class="job-number">04</span></span>
        </legend>
        <p class="job-desc">
            <?= t('Duplicate login sessions can cause session conflicts for regular users who log in from different locations and devices.') ?>
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
                        <?php if ($this->helper->cleaningHelper->countRememberMeOld() == 0): ?>
                            <i style="font-weight: 400; color: var(--pp-green-dark);"><?= t('No duplicates found') ?></i>
                        <?php else: ?>
                            <?= $this->helper->cleaningHelper->countRememberMeOld() ?>
                        <?php endif ?>
                        <?php if ($this->helper->cleaningHelper->countRememberMeOld() != 0): ?>
                            <?= ($this->helper->cleaningHelper->countRememberMeOld() > 1) ? t('Duplicates') : t('Duplicate') ?>
                        <?php endif ?>
                    </span>
                </li>
            </ul>
            <ul class="job-result fa-ul">
                <li class="job-result-title"><i class="fa fa-check fa-li" aria-hidden="true"></i><?= t('Job Result') ?></li>
                <li class="job-result-text"><?= t('The table will be checked and any duplicate records found for a user will be deleted leaving the single latest entry for that user.') ?></li>
            </ul>
        </div>
        <div class="form-actions">
            <button href="<?= $this->url->href('CleaningController', 'confirmRememberMeDuplicatesPurge', array('table' => 'remember_me', 'job' => '04', 'plugin' => 'ContentCleaner'), false, '', false) ?>" class="btn job-btn js-modal-confirm"><span class="content-cleaner-icon"></span> <?= t('Delete Duplicate Sessions') ?></button>
        </div>
    </fieldset>
</div>
