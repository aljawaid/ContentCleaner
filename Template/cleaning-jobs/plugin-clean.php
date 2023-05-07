<!-- ContentCleaner: PLUGIN CLEANING -->
<?php foreach ($deletable_plugins as $plugin): ?>
    <div class="job-section-wrapper">
        <fieldset class="job-wrapper plugin-job-wrapper">
            <legend class="job-title">
                <span class="content-cleaner-icon"></span> <?= t('%s Plugin', $plugin['plugin_title']) ?>
                <span class="job-number-wrapper" title="<?= t('Cleaning Job Number') ?>">
                    <span class="job-number"><?= $plugin['job_number'] ?></span>
                </span>
            </legend>
            <p class="job-desc">
                <?= t('Remove all traces, content and plugin registration data for %s.', $plugin['plugin_title']) ?>
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
                        <?php if (isset($plugin['plugin_tables'])): ?>
                            <span class="tooltip content-cleaner-tooltip">
                                <i class="fa fa-info-circle" aria-hidden="true"></i>
                                <script type="text/template">
                                    <div class="markdown"><?= $this->render('contentCleaner:cleaning-jobs/tooltips/plugin-tables', array('plugin' => $plugin)) ?></div>
                                </script>
                            </span>
                        <?php endif ?>
                    </li>
                    <?php if (isset($plugin['plugin_tables'])): ?>
                        <?php foreach ($plugin['plugin_tables'] as $value): ?>
                            <li class="job-tables-table job-plugin-table"><?= $value ?></li>
                        <?php endforeach ?>
                    <?php else: ?>
                        <li class="job-tables-table job-plugin-table no-tables">
                            <i><?= t('This plugin creates no tables of its own') ?></i>
                        </li>
                    <?php endif ?>
                </ul>
                <ul class="job-table-size fa-ul">
                    <li class="job-tables-title">
                        <i class="fa fa-table fa-li" aria-hidden="true"></i><?= t('Core Tables') ?>
                        <?php if (isset($plugin['core_tables'])): ?>
                            <span class="tooltip content-cleaner-tooltip">
                                <i class="fa fa-info-circle" aria-hidden="true"></i>
                                <script type="text/template">
                                    <div class="markdown"><?= $this->render('contentCleaner:cleaning-jobs/tooltips/core-tables', array('plugin' => $plugin)) ?></div>
                                </script>
                            </span>
                        <?php endif ?>
                    </li>
                    <?php if (isset($plugin['core_tables'])): ?>
                        <?php foreach ($plugin['core_tables'] as $value): ?>
                            <li class="job-tables-table job-plugin-table"><?= $value ?></li>
                        <?php endforeach ?>
                    <?php else: ?>
                        <li class="job-tables-table job-plugin-table no-tables">
                            <i><?= t('This plugin alters no core tables') ?></i>
                        </li>
                    <?php endif ?>
                </ul>
                <ul class="job-table-size fa-ul">
                    <li class="job-tables-title">
                        <i class="fa fa-columns fa-li" aria-hidden="true"></i><?= t('Core Columns') ?>
                        <?php if (isset($plugin['core_table_columns'])): ?>
                            <span class="tooltip content-cleaner-tooltip">
                                <i class="fa fa-info-circle" aria-hidden="true"></i>
                                <script type="text/template">
                                    <div class="markdown"><?= $this->render('contentCleaner:cleaning-jobs/tooltips/core-columns', array('plugin' => $plugin)) ?></div>
                                </script>
                            </span>
                        <?php endif ?>
                    </li>
                    <?php if (isset($plugin['core_table_columns'])): ?>
                        <?php foreach ($plugin['core_table_columns'] as $tables): ?>
                            <?php foreach ($tables as $tablename => $tablecolumns): ?>
                                <span class="job-tables-table"><?= $tablename ?></span>
                                <?php foreach ($tablecolumns as $column): ?>
                                    <li class="job-tables-table job-plugin-table column-names"><?= $column ?></li>
                                <?php endforeach ?>
                            <?php endforeach ?>
                        <?php endforeach ?>
                    <?php else: ?>
                        <?php if (isset($plugin['core_table_entries'])): ?>
                            <li class="job-tables-table job-plugin-table no-tables">
                                <i><?= t('This plugin alters no core table columns but adds or edits entries to the core table') ?></i>
                            </li>
                        <?php else: ?>
                            <li class="job-tables-table job-plugin-table no-tables">
                                <i><?= t('This plugin alters no core table columns') ?></i>
                            </li>
                        <?php endif ?>
                    <?php endif ?>
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
                        <?= t('%s will not exist on your system in any form after running this job', $plugin['plugin_title']) ?>
                    </li>
                </ul>
            </div>
            <div class="form-actions plugin-job-form-actions">
                <a href="<?= $this->url->href('PluginCleaningController', 'confirmRemoval', array('plugin_job_name' => $plugin['plugin_title'], 'job_number' => $plugin['job_number'], 'plugin' => 'ContentCleaner'), false, '', false) ?>" class="btn job-btn js-modal-confirm"><span class="content-cleaner-icon"></span> <?= t('Deep Clean Plugin') ?></a>
            </div>
        </fieldset>
    </div>
<?php endforeach ?>
