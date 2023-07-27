<!-- REMOVE THIS SECTION -->
<!-- ------------------- -->
<!-- TEMPLATE FILE FOR LOCAL TRANSLATIONS - KEEP FILENAME IN LOWERCASE AS translations.php UNDER LANGUAGE CODE -->
<!-- EXAMPLE FILE: /Locale/en_GB/translations.php -->
<!-- EXAMPLE FILE: /Locale/en_US/translations.php -->
<!-- EXAMPLE FILE: /Locale/fr_FR/translations.php -->
<!-- EXAMPLE FILE: /Locale/de_DE/translations.php -->
<!-- ------------------- -->
<!-- REMOVE THIS SECTION -->
<?php

return array(
    //
    // GENERAL
    //
    'Content Cleaner' => '',
    'This tool allows admins to cleanup their Kanboard database by selectively deleting useless data saved by Kanboard and leftover data after uninstalling plugins. Keep your database clean and free from cluttered and expired data using cleaning jobs to solve specific application issues.' => '',
    //
    // CORE OVERRIDES OR 3RD PARTY PLUGIN TRANSLATIONS AFFECTING THIS PLUGIN
    //
    'Settings' => '',
    //
    // Controller/CleaningController.php
    //
    'Confirm Cleaning Job' => '',
    'Confirm Cleaning' => '',
    'Cleaning Complete: Database table deleted successfully' => '',
    'Cleaning Failed' => '',
    'Purge Complete - Plugin registration data successfully removed' => '',
    'Purge Failed: There may not be anything to purge' => '',
    'Cleaning Complete: Database column deleted successfully' => '',
    'No columns were selected' => '',
    'Cleaning Complete: Reset successfully' => '',
    'Cleaning Complete: Purged successfully' => '',
    'Cleaning Complete: Duplicates deleted successfully' => '',
    //
    // Controller/PluginCleaningController.php
    //
    'Deep Cleaning Complete: %s deleted successfully' => '',
    'Deep Cleaning Failed: Unable to delete %s' => '',
    'Delete Plugin Database Tables' => '',
    'Deep Cleaning Complete: Database tables created by %s were deleted successfully' => '',
    'Deep Cleaning Failed: Database tables created by %s could not be deleted' => '',
    'Delete Core Table Columns' => '',
    'Deep Cleaning Complete: Core table columns created by %s were deleted' => '',
    'Deep Cleaning Failed: Core table columns created by %s were not deleted' => '',
    'Delete Core Table Entries' => '',
    'Deep Cleaning Complete: Core table entries created by %s were deleted' => '',
    'Deep Cleaning Failed: Core table entries created by %s were not deleted' => '',
    'Delete Plugin Registration Entry' => '',
    'Deep Cleaning Complete: Plugin registration entry for %s was deleted successfully' => '',
    'Deep Cleaning Failed: Plugin registration entry was not deleted for %s' => '',
    //
    // Model/ApplicationCleaningModel.php
    //
    'This cleaning job is not compatible with your database type' => '',
    //
    // Template/cleaning-jobs/tooltips/core-columns.php
    //
    'These columns are located inside core tables and will be deleted if created by a plugin' => '',
    //
    // Template/cleaning-jobs/tooltips/core-tables.php
    //
    'Core tables are created by only the application. Plugins can only alter these types of tables but not delete them.' => '',
    //
    // Template/cleaning-jobs/tooltips/plugin-tables.php
    //
    'The tables listed here are created by the plugin itself' => '',
    //
    // Template/cleaning-jobs/tooltips/plugin-version.php
    //
    'This cleaning job is compatible with all versions of this plugin up to v%s' => '',
    //
    // Template/cleaning-jobs/automatic-clean.php
    //
    'Purge Unused Plugin Registration Entries' => '',
    'Cleaning Job Number' => '',
    'Plugins which have altered the database also register themselves in the database. Use this job if you are having issues reinstalling a plugin.' => '',
    'Table Affected' => '',
    'Job Result' => '',
    'The table is checked for all unknown entries compared to your installed plugins.' => '',
    'Purge Unused Entries' => '',
    'Clean All Unknown Tables and Columns' => '',
    'This job is an all-in-one process to deep clean your database. Any data inside unknown tables and columns will also be deleted.' => '',
    '+ more' => '',
    'First all unknown tables are identified and deleted followed by all unknown columns in each table. Finally the plugin registration entries are purged.' => '',
    'Deep Clean Database' => '',
    //
    // Template/cleaning-jobs/core-clean.php
    //
    'Purge User Sessions' => '',
    'User sessions can build up needlessly over time. It is safe to clear this table from time to time for expired entries.' => '',
    'Table Contents' => '',
    'Entries' => '',
    'Entry' => '',
    'The table will be emptied leaving the current single session entry in the table.' => '',
    'Purge Sessions' => '',
    'Restore Calendar Settings' => '',
    'Calendar plugins can alter the default settings project and user views affecting how tasks are displayed based on start and due dates.' => '',
    'The settings for %s and %s will be reset to the default value' => '',
    'Reset Calendar Settings' => '',
    'Delete Remember Me Login Sessions' => '',
    'By default, login sessions are automatically deleted after 60 days. This job will delete all entries for all users.' => '',
    'Empty' => '',
    'The table will be completely emptied.' => '',
    'Delete Login Sessions' => '',
    'Delete Duplicate Remember Me Login Sessions' => '',
    'Duplicate login sessions can cause session conflicts for regular users who log in from different locations and devices.' => '',
    'No duplicates found' => '',
    'Duplicates' => '',
    'Duplicate' => '',
    'The table will be checked and any duplicate records found for a user will be deleted leaving the single latest entry for that user.' => '',
    'Delete Duplicate Sessions    ' => '',
    //
    // Template/cleaning-jobs/plugin-clean.php
    //
    'Plugin Author' => '',
    'Plugin Homepage - opens in a new window' => '',
    'This plugin is detected as being installed' => '',
    'Installed' => '',
    'This plugin creates no tables of its own' => '',
    'Core Tables' => '',
    'This plugin alters no core tables' => '',
    'Core Columns' => '',
    'This plugin alters no core table columns but adds or edits entries to the core table' => '',
    'This plugin alters no core table columns' => '',
    'Plugin Version' => '',
    'Deep Cleaning' => '',
    'No database tables were found' => '',
    'Plugin Tables' => '',
    'This function is unavailable while the plugin is installed' => '',
    'No database core columns were found' => '',
    'Core Table Columns' => '',
    'No entries were found' => '',
    'Core Table Entries' => '',
    'Plugin Registration' => '',
    'Delete Plugin' => '',
    //
    // Template/config/modals/auto_purge_clean.php
    //
    'All Unknown Tables and Columns' => '',
    'Automatically remove all unknown tables and columns left over from uninstalled plugins, followed by purging the respective plugin registration entries.' => '',
    'Automatic Cleaning Jobs' => '',
    'Deep Clean' => '',
    //
    // Template/config/modals/plugin_delete.php
    //
    'Warning' => '',
    '%s is detected as installed. You should uninstall %s before completing this action to avoid the automatic creation of any database table entries related to the plugin.' => '',
    'Plugin Schema Registration Entry' => '',
    'Plugin Cleaning Jobs' => '',
    //
    // Template/config/modals/purge_plugin_schemas.php
    //
    'Plugin Registration Entries' => '',
    'Run this job to purge the database of any unused plugin registration data.' => '',
    'Purge' => '',
    //
    // Template/config/modals/remove_extra_columns.php
    //
    'Delete Columns' => '',
    'The columns listed below are not part of the default structure for the table.' => '',
    'Extra Columns' => '',
    'Created by %s plugin' => '',
    'Delete Selected' => '',
    //
    // Template/config/modals/remove_plugin_core_table__columns.php
    //
    '%s is detected as installed. You should uninstall %s before completing this action to avoid the automatic creation of any database columns related to the plugin.' => '',
    'Do you really want to delete the core database columns created by %s?' => '',
    'Plugin Deep Cleaning' => '',
    //
    // Template/config/modals/remove_plugin_core_table__entries.php
    //
    'Do you really want to delete the core database table entries created by %s?' => '',
    //
    // Template/config/modals/remove_plugin_schema.php
    //
    '%s is detected as installed. You should uninstall %s before completing this action to avoid the automatic creation of the database entry.' => '',
    'Do you really want to delete the entry for %s?' => '',
    //
    // Template/config/modals/remove_plugin_tables.php
    //
    '%s is detected as installed. You should uninstall %s before completing this action to avoid the automatic creation of any database tables related to the plugin.' => '',
    'Do you really want to delete any database tables which were created by %s?' => '',
    'For %s to recreate the tables automatically after this deep clean, you will need to run the "Plugin Registration" deep clean.' => '',
    '' => '',
    '' => '',
    '' => '',
    '' => '',
    '' => '',
    '' => '',
    '' => '',
    '' => '',
    '' => '',
    '' => '',
    '' => '',
    '' => '',
    '' => '',
    '' => '',
);
