<!-- ContentCleaner: PLUGIN CLEANING -->
<?php // phpcs:disable Generic.Files.LineLength.TooLong ?>
<?php foreach ($deletable_plugins as $plugin): ?>
    <div class="job-section-wrapper">
        <fieldset id="PluginJobWrapper<?= $plugin['job_number'] ?>" class="job-wrapper plugin-job-wrapper">
            <legend class="job-title">
                <span class="content-cleaner-icon"></span> <?= t('%s Plugin', $plugin['plugin_title']) ?>
                <span class="job-number-wrapper" title="<?= t('Cleaning Job Number') ?>">
                    <span class="job-number"><?= $plugin['job_number'] ?></span>
                </span>
            </legend>
            <ul id="JobPluginDetails<?= $plugin['job_number'] ?>" class="job-plugin-details">
                <li class="details-item" title="<?= t('Plugin Author') ?>">
                    <span class="plugin-icon"></span> <?= $plugin['plugin_author'] ?>
                </li>
                <li class="details-item" title="<?= t('Plugin Homepage - opens in a new window') ?> &#8663;">
                    <span class="website-globe-icon"></span>
                    <a href="<?= $plugin['plugin_url'] ?>" class="details-url" rel="noopener noreferrer" target="_blank">
                        <?= $plugin['plugin_url'] ?>
                    </a>
                </li>
            </ul>
            <?php if (isset($plugin['plugin_folder_name']) && (file_exists('plugins/' . $plugin['plugin_folder_name'] . ''))): ?>
                <div id="InstallDetected<?= $plugin['job_number'] ?>" class="install-detected" title="<?= t('This plugin is detected as being installed') ?>">
                    <span class="plugin-icon"></span>
                    <p class="installed-text"><?= t('Installed') ?></p>
                </div>
            <?php endif ?>
            <p class="alert alert-info job-desc plugin-desc">
                <?= t('Remove all traces of %s using the "Delete Plugin" button or target the structure of the plugin and delete specific elements through the "Deep Cleaning" bar.', $plugin['plugin_title']) ?>
            </p>
            <div class="plugin-job-content">
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
                                    <li class="job-tables-table job-plugin-table column-names" title="<?= t('This column is located in the "%s" table', $tablename) ?>">
                                        <?= $column ?>
                                    </li>
                                <?php endforeach ?>
                            <?php endforeach ?>
                        <?php endforeach ?>
                    <?php else: ?>
                        <?php if (isset($plugin['core_table_entries'])): ?>
                            <li class="job-tables-table job-plugin-table no-tables">
                                <i class="fa fa-tasks" aria-hidden="true"></i> <i><?= t('This plugin alters no core table columns but adds or edits entries to the core table') ?></i>
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
                    <li class="job-tables-table job-plugin-table job-plugin-version">v<?= $plugin['checked_up_to_plugin_version'] ?></li>
                </ul>
                <ul class="job-result fa-ul">
                    <li class="job-result-title">
                        <i class="fa fa-check fa-li" aria-hidden="true"></i><?= t('Job Result') ?>
                    </li>
                    <li class="job-result-text">
                        <?= t('%s will not exist on your system in any form after completing this job', $plugin['plugin_title']) ?>
                    </li>
                </ul>
            </div>
            <div id="DeepCleanFormActions<?= $plugin['job_number'] ?>" class="form-actions plugin-job-form-actions">
                <div class="deep-clean-panel">
                    <ul class="plugin-btn-list">
                        <li class="deep-clean-panel-title"><?= t('Deep Cleaning') ?></li>
                        <?php if (isset($plugin['plugin_tables'])): ?>
                            <li class="plugin-btn-item">
                                <button href="<?= $this->url->href('PluginCleaningController', 'confirmDeletePluginTables', array(
                                    'plugin_job_name' => $plugin['plugin_title'],
                                    'plugin_name' => $plugin['plugin_name'],
                                    'plugin' => 'ContentCleaner'), false, '', false) ?>" class="btn job-btn js-modal-confirm"
                                    <?= ($this->helper->pluginCleaningHelper->checkPluginTablesExist($plugin['plugin_title']) ? '' : 'disabled title="' . t('No database tables were found') . '"') ?>>
                                    <span class="plugin-icon"></span> <?= t('Plugin Tables') ?>
                                </button>
                            </li>
                        <?php endif ?>
                        <?php if (isset($plugin['core_table_columns'])): ?>
                            <li class="plugin-btn-item">
                                <button href="<?= $this->url->href('PluginCleaningController', 'confirmDeleteCoreTableColumns', array(
                                    'plugin_job_name' => $plugin['plugin_title'],
                                    'plugin_name' => $plugin['plugin_name'],
                                    'plugin' => 'ContentCleaner'), false, '', false) ?>" class="btn job-btn js-modal-confirm"
                                    <?php if (isset($plugin['plugin_folder_name']) && (file_exists('plugins/' . $plugin['plugin_folder_name'] . ''))): ?>
                                        disabled title="<?= t('This function is unavailable while the plugin is installed') ?>"
                                    <?php elseif ($this->helper->pluginCleaningHelper->checkPluginCoreColumnsExist($plugin['plugin_title'])): ?>
                                        disabled title="<?= t('No database core columns were found') ?>"
                                    <?php endif ?>
                                    >
                                    <span class="plugin-icon"></span> <?= t('Core Table Columns') ?>
                                </button>
                            </li>
                        <?php endif ?>
                        <?php if (isset($plugin['core_table_entries'])): ?>
                            <li class="plugin-btn-item">
                                <button href="<?= $this->url->href('PluginCleaningController', 'confirmDeleteCoreTableEntries', array(
                                    'plugin_job_name' => $plugin['plugin_title'],
                                    'plugin_name' => $plugin['plugin_name'],
                                    'plugin' => 'ContentCleaner'), false, '', false) ?>" class="btn job-btn js-modal-confirm"
                                    <?= ($this->helper->pluginCleaningHelper->checkPluginCoreEntriesExist($plugin['plugin_title']) ? '' : 'disabled title="' . t('No entries were found') . '"') ?>>
                                    <span class="plugin-icon"></span> <?= t('Core Table Entries') ?>
                                </button>
                            </li>
                        <?php endif ?>
                        <?php if (isset($plugin['plugin_schema_version'])): ?>
                            <li class="plugin-btn-item">
                                <button href="<?= $this->url->href('PluginCleaningController', 'confirmDeletePluginSchemaEntry', array(
                                    'plugin_job_name' => $plugin['plugin_title'],
                                    'plugin_name' => $plugin['plugin_name'],
                                    'plugin' => 'ContentCleaner'), false, '', false) ?>" class="btn job-btn js-modal-confirm">
                                    <span class="plugin-icon"></span> <?= t('Plugin Registration') ?>
                                </button>
                            </li>
                        <?php endif ?>
                    </ul>
                </div>
                <button id="DeletePluginButton<?= $plugin['job_number'] ?>" href="<?= $this->url->href('PluginCleaningController', 'confirmDeletePlugin', array(
                    'plugin_job_name' => $plugin['plugin_title'],
                    'job' => $plugin['job_number'],
                    'plugin_name' => $plugin['plugin_name'],
                    'plugin' => 'ContentCleaner'), false, '', false) ?>" class="btn job-btn js-modal-confirm feature-disabled" disabled title="<?= t('This feature is currently unavailable') ?>">
                    <span class="content-cleaner-icon"></span> <?= t('Delete Plugin') ?>
                </button>
            </div>
        </fieldset>
    </div>
<?php endforeach ?>
<?php // phpcs:enable ?>
