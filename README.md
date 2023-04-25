# ContentCleaner

#### _Plugin for [Kanboard](https://github.com/fguillot/kanboard "Kanboard - Kanban Project Management Software")_

This tool allows admins to cleanup their Kanboard database by selectively deleting useless data saved by Kanboard and leftover data after uninstalling plugins. Keep your database clean and free from cluttered and expired data using cleaning jobs to solve specific application issues.


Features
-------------
- Show a detailed database summary
  - Display extra tables which are created by plugins
  - Delete extra tables directly from the database
  - Easily identify plugin ownership of each extra table
- Show default database information
  - Highlight extra columns within tables and delete columns directly from the database
- Numbered cleaning jobs for easy reference
  - Each cleaning job is specific to a plugin or a default application setting
- Deep clean the database from all plugins and plugin related data
- **Automatic Cleaning Jobs:**
  - Purge Unused Plugin Registration Entries 
  - Clean All Unknown Tables and Columns 
- **Application Cleaning Jobs:**
  - Purge User Sessions
  - Restore Calendar Settings
  - Delete `Remember Me` Login Sessions
  - Delete Duplicate `Remember Me` Login Sessions
- **Plugin Cleaning Jobs:**
  - Remove [TemplateManager](https://github.com/aljawaid/TemplateManager "A Kanboard plugin") data


Screenshots
----------

**Database Summary**  

![Summary](../master/Screenshots/screenshot-summary.png "Database Summary")

**Default Tables**  

![Summary](../master/Screenshots/screenshot-default-tables.png "Default Tables")

**Automatic Cleaning Jobs**  

![Summary](../master/Screenshots/screenshot-auto-cleaning-jobs.png "Automatic Cleaning Jobs")


Usage
-------------

Go to `Settings` &#10562; Content Cleaner


Compatibility
-------------

- Requires [Kanboard](https://github.com/fguillot/kanboard "Kanboard - Kanban Project Management Software") ≥`1.2.20`

#### Other Plugins & Action Plugins
- _No known issues_
- Compatible with [PluginManager](https://github.com/aljawaid/PluginManager)
#### Core Files & Templates
- _No template overrides_
- _No database changes are made by this plugin other than the deletion of database content_
- MS SQL databases are not supported


Changelog
---------

Read the full [**Changelog**](../master/changelog.md "See changes")
 

Installation
------------

- **Install via the [Kanboard](https://github.com/fguillot/kanboard "Kanboard - Kanban Project Management Software") Plugin Directory**
  - _Go to:_
    - Kanboard: `Plugins` &#10562; `Plugin Directory`
  - _or with [PluginManager](https://github.com/aljawaid/PluginManager) installed:_
    - Kanboard: `Settings` &#10562; `Plugins` &#10562; `Plugin Directory`

**_or_**

- **Install via the [Releases](../master/Releases/ "A copy of each release is saved in the folder") folder**
  - A copy of each release is saved in the `/Releases` folder of the repository
  - Simply extract the `.zip` file into the `/plugins` directory

**_or_**

- **Install via [GitHub](https://github.com/aljawaid "Find the correct plugin from the list of repositories")**
  - Download the `.zip` file and decompress everything under the directory `/plugins`
  - The folder inside the `.zip` must not contain any branch names and must be exact case (matching the plugin name)

_Note: The `/plugins` folder is case-sensitive._

**_or_**

- **Install using Git CLI**
  - `git clone` (_or ftp upload_) and extract the `.zip` file into this folder: `.\plugins\` (must be exact case)


Translations
------------

- _Contributors welcome_
- _Starter template available_

Authors & Contributors
----------------------

- [@aljawaid](https://github.com/aljawaid) - Author
- [Craig Crosby](https://github.com/creecros) - Contributor
- [Alfred Bühler](https://github.com/alfredbuehler) - Contributor
- _Contributors welcome_


License
-------
- This project is distributed under the [MIT License](../master/LICENSE "Read The MIT license")
