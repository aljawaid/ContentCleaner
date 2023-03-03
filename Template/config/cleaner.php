<div class="page-margin">
    <div class="page-header">
        <h2 class="">Content Cleaner</h2>
    </div>
    <p class="cleaner-intro">
        
    </p>
    <div class="cleaner-warning">
        <h4 class="">Warning</h4>
        <p class="">Using this tool deletes data from the database permanently</p>
    </div>
    <fieldset class="">
        <legend>Application Cleaning</legend>
        <a id="" href="<?= $this->url->href('CleaningController', 'confirm', array('table' => 'test', 'plugin' => 'ContentCleaner'), false, '', false) ?>" class="btn  js-modal-confirm" title="<?=t('Delete') ?>">
            <svg width="20px" height="20px" class="delete-icon" fill="currentColor" version="1.1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" viewBox="0 0 512 512" enable-background="new 0 0 512 512" xml:space="preserve">
                <g stroke-width="0"/>
                <g stroke-linecap="round" stroke-linejoin="round"/>
                <g>
                    <polygon fill="#055D20" points="335.188,154.188 256,233.375 176.812,154.188 154.188,176.812 233.375,256 154.188,335.188 176.812,357.812 256,278.625 335.188,357.812 357.812,335.188 278.625,256 357.812,176.812 "/>
                    <path d="M256,0C114.609,0,0,114.609,0,256s114.609,256,256,256s256-114.609,256-256S397.391,0,256,0z M256,472 c-119.297,0-216-96.703-216-216S136.703,40,256,40s216,96.703,216,216S375.297,472,256,472z"/>
                </g>
            </svg> <?= t('Delete Table') ?>
        </a>
    </fieldset>
    <fieldset class="">
        <legend>Plugin Cleaner</legend>
    </fieldset>
</div>
