<?php foreach ($deletable_plugins as $plugin): ?>
    <!-- ContentCleaner: PLUGIN CLEANING JOB 01 -->
    <?php $plugin_job_name = $plugin['plugin_title']; ?>
    <div class="job-section-wrapper">
        <fieldset class="job-wrapper plugin-job-wrapper">
            <legend class="job-title">
                <span class="content-cleaner-icon"></span> <?= t('%s Plugin', $plugin_job_name) ?>
                <!-- ContentCleaner: DO NOT CHANGE JOB NUMBERS -->
                <span class="job-number-wrapper" title="<?= t('Cleaning Job Number') ?>">
                    <span class="job-number">01</span>
                </span>
            </legend>
            <p class="job-desc">
                <?= t('Remove all traces, content and plugin registration data for %s.', $plugin_job_name) ?>
                <span class="tooltip content-cleaner-tooltip">
                    <i class="fa fa-info-circle" aria-hidden="true"></i>
                    <script type="text/template">
                        <div class="markdown"><?= $this->render('contentCleaner:cleaning-jobs/tooltips/plugin-details', array('plugin' => $plugin)) ?></div>
                    </script>
                </span>
            </p>
            <div class="job-content">
                <ul class="job-tables fa-ul">
                    <li class="job-tables-title">
                        <i class="fa fa-table fa-li" aria-hidden="true"></i><?= t('Plugin Tables') ?>
                        <span class="tooltip content-cleaner-tooltip">
                            <i class="fa fa-info-circle" aria-hidden="true"></i>
                            <script type="text/template">
                                <div class="markdown"><?= $this->render('contentCleaner:cleaning-jobs/tooltips/plugin-tables', array('plugin' => $plugin)) ?></div>
                            </script>
                        </span>
                    </li>
                    <li class="job-tables-table job-plugin-table">metadata_has_type</li>
                    <li class="job-tables-table job-plugin-table">metadata_types</li>
                </ul>
                <ul class="job-table-size fa-ul">
                    <li class="job-tables-title">
                        <i class="fa fa-table fa-li" aria-hidden="true"></i><?= t('Core Tables') ?>
                        <span class="tooltip content-cleaner-tooltip">
                            <i class="fa fa-info-circle" aria-hidden="true"></i>
                            <script type="text/template">
                                <div class="markdown"><?= $this->render('contentCleaner:cleaning-jobs/tooltips/core-tables', array('plugin' => $plugin)) ?></div>
                            </script>
                        </span>
                    </li>
                    <li class="job-tables-table job-plugin-table">table_1</li>
                    <li class="job-tables-table job-plugin-table">table_2</li>
                    <li class="job-tables-table job-plugin-table">table_3</li>
                </ul>
                <ul class="job-table-size fa-ul">
                    <li class="job-tables-title">
                        <i class="fa fa-columns fa-li" aria-hidden="true"></i><?= t('Core Columns') ?> (5)
                        <span class="tooltip content-cleaner-tooltip">
                            <i class="fa fa-info-circle" aria-hidden="true"></i>
                            <script type="text/template">
                                <div class="markdown"><?= $this->render('contentCleaner:cleaning-jobs/tooltips/core-columns', array('plugin' => $plugin)) ?></div>
                            </script>
                        </span>
                    </li>
                    <li class="job-tables-table job-plugin-table">tasks: column_1 column_2 column_3</li>
                    <li class="job-tables-table job-plugin-table">projects: column_4 column_5</li>
                </ul>
                <ul class="job-table-size fa-ul">
                    <li class="job-tables-title">
                        <i class="fa fa-file fa-li" aria-hidden="true"></i><?= t('Plugin Version') ?>
                        <span class="tooltip content-cleaner-tooltip">
                            <i class="fa fa-info-circle" aria-hidden="true"></i>
                            <script type="text/template">
                                <div class="markdown"><?= $this->render('contentCleaner:cleaning-jobs/tooltips/plugin-version', array('plugin' => $plugin)) ?></div>
                            </script>
                        </span>
                    </li>
                    <li class="job-tables-table job-plugin-table job-plugin-version">v<?= $plugin['checked_upto_plugin_version'] ?></li>
                </ul>
                <ul class="job-result fa-ul">
                    <li class="job-result-title">
                        <i class="fa fa-check fa-li" aria-hidden="true"></i><?= t('Job Result') ?>
                    </li>
                    <li class="job-result-text">
                        <?= t('%s will not exist on your system in any form.', $plugin_job_name) ?>
                    </li>
                </ul>
            </div>
            <div class="form-actions">
                <a href="<?= $this->url->href('PluginCleaningController', 'confirmRemoval', array('plugin_job_name' => $plugin_job_name, 'job' => '01', 'plugin' => 'ContentCleaner', 'plugin' => $plugin), false, '', false) ?>" class="btn job-btn js-modal-confirm"><span class="content-cleaner-icon"></span> <?= t('Deep Clean Plugin') ?></a>
            </div>
        </fieldset>
    </div>

<?php endforeach ?>
