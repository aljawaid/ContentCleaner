<!-- ContentCleaner: AUTOMATIC CLEANING JOB 01 -->
<div class="job-section-wrapper">
    <fieldset class="job-wrapper relative">
        <legend class="job-title">
            <span class="content-cleaner-icon"></span> <?= t('Purge Unused Plugin Registration Entries') ?>
            <!-- ContentCleaner: DO NOT CHANGE JOB NUMBERS -->
            <span class="job-number-wrapper" title="<?= t('Cleaning Job Number') ?>"><span class="job-number">01</span></span>
        </legend>
        <p class="job-desc">
            <?= t('Plugins which have altered the database also register themselves in the database. Use this job if you are having issues reinstalling a plugin.') ?>
        </p>
        <div class="job-content">
            <ul class="job-tables fa-ul">
                <li class="job-tables-title">
                    <i class="fa fa-table fa-li" aria-hidden="true"></i><?= t('Table Affected') ?>
                </li>
                <li class="job-tables-table">plugin_schema_versions</li>
            </ul>
            <ul class="job-result fa-ul">
                <li class="job-result-title"><i class="fa fa-check fa-li" aria-hidden="true"></i><?= t('Job Result') ?></li>
                <li class="job-result-text"><?= t('The table is checked for all unknown entries compared to your installed plugins.') ?></li>
            </ul>
        </div>
        <div class="form-actions">
            <button href="<?= $this->url->href('CleaningController', 'confirmPluginSchemaPurge', array('job' => '01', 'plugin' => 'ContentCleaner'), false, '', false) ?>" class="btn job-btn js-modal-confirm">
                <span class="db-delete-icon"></span> <?= t('Purge Unused Entries') ?>
            </button>
        </div>
    </fieldset>
</div>

<!-- ContentCleaner: AUTOMATIC CLEANING JOB 02 -->
<div class="job-section-wrapper">
    <fieldset class="job-wrapper relative">
        <legend class="job-title">
            <span class="content-cleaner-icon"></span> <?= t('Clean All Unknown Tables and Columns') ?>
            <!-- ContentCleaner: DO NOT CHANGE JOB NUMBERS -->
            <span class="job-number-wrapper" title="<?= t('Cleaning Job Number') ?>"><span class="job-number">02</span></span>
        </legend>
        <p class="job-desc">
            <?= t('This job is an all-in-one process to deep clean your database. Any data inside unknown tables and columns will also be deleted.') ?>
        </p>
        <div class="job-content">
            <ul class="job-tables fa-ul">
                <li class="job-tables-title">
                    <i class="fa fa-table fa-li" aria-hidden="true"></i><?= t('Table Affected') ?>
                </li>
                <li class="job-tables-table">plugin_schema_versions</li>
                <li class="more"><?= t('+ more') ?></li>
            </ul>
            <ul class="job-result fa-ul">
                <li class="job-result-title"><i class="fa fa-check fa-li" aria-hidden="true"></i><?= t('Job Result') ?></li>
                <li class="job-result-text"><?= t('First all unknown tables are identified and deleted followed by all unknown columns in each table. Finally the plugin registration entries are purged.') ?></li>
            </ul>
        </div>
        <div class="form-actions">
            <button href="<?= $this->url->href('CleaningController', 'confirmAutoPurgeAndClean', array('job' => '02', 'plugin' => 'ContentCleaner'), false, '', false) ?>" class="btn job-btn js-modal-confirm">
                <span class="db-delete-icon"></span> <?= t('Deep Clean Database') ?>
            </button>
        </div>
    </fieldset>
</div>
