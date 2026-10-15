<div id="ExtraColumnsModal" class="content-cleaner-modal">
    <div class="modal-page-header">
        <h2 class="relative">
            <span class="modal-title">
                <span class="content-cleaner-icon"></span> <?= $title ?>
            </span>
            <span class="modal-subtitle">
                <span class="db-settings-icon"></span> <?= t('Delete Columns') ?>
            </span>
        </h2>
    </div>
    <form method="post" action="<?= $this->url->href('CleaningController', 'removeSelectedColumns', array('plugin' => 'ContentCleaner')) ?>" autocomplete="off">
        <?= $this->form->csrf() ?>
        <div class="modal-contents">
            <div class="confirm">
                <p class="confirm-notice">
                    <?= t('The columns listed below are not part of the default structure for the table.') ?>
                </p>
                <ul class="job-tables fa-ul">
                    <li class="job-tables-title">
                        <i class="fa fa-table fa-li" aria-hidden="true"></i><?= t('Table Affected') ?>
                    </li>
                    <li class="job-tables-table"><?= $this->text->e($table) ?></li>
                </ul>
                <ul class="job-tables fa-ul">
                    <li class="job-tables-title extra-columns-title">
                        <i class="fa fa-columns fa-li" aria-hidden="true"></i><?= t('Extra Columns') ?>
                    </li>
                    <li class="job-columns-list">
                        <ol class="column-list">
                            <?php foreach ($candidates as $candidate): ?>
                                <li class="job-columns-name" title="<?= t('Created by %s plugin', $candidate['plugin_title']) ?>">
                                    <label>
                                        <input type="checkbox" name="cleanup_items[]" value="<?= $this->text->e($candidate['token']) ?>">
                                        <?= $this->text->e($candidate['column']) ?>
                                    </label>
                                    <span class="job-columns-plugin">
                                        <span class="plugin-icon"></span> <?= $this->text->e($candidate['plugin_title']) ?>
                                    </span>
                                </li>
                            <?php endforeach ?>
                        </ol>
                    </li>
                </ul>
            </div>
        </div>
        <div class="modal-actions">
            <?= $this->modal->submitButtons(array('submitLabel' => t('Delete Selected'))) ?>
        </div>
    </form>
</div>
