# Changelog


## v2.0.1

_(most recent changes are listed on top):_
- FIX: Meet WCAG AA text contrast for warnings, action buttons, badges, process guidance and allowlist locks in Light and Dark themes
- FIX: Separate theme-aware panel surfaces from literal white foregrounds so Dark theme controls remain readable


## v2.0.0

_(most recent changes are listed on top):_
- SECURITY FIX: Restrict every ContentCleaner screen and operation to administrators
- SECURITY FIX: Require CSRF-protected POST requests and server-side allowlists for destructive operations
- SECURITY FIX: Refuse cleanup while a plugin is loaded, incompatible or physically present on disk
- SECURITY FIX: Derive confirmation labels server-side and escape displayed cleanup values
- FIX: Replace automatic unknown-object deletion with an explicit preview-and-confirm workflow - closes #26
- FIX: Complete whole-plugin data cleanup with safe installed-plugin refusal and partial-failure reporting - closes #18
- FIX: Add Normal and Advanced controls for whole-plugin or individual artefact cleanup - closes #12
- FIX: Correct SQLite session and persistent-login purges while retaining the underlying tables
- FIX: Validate and quote database identifiers without PostgreSQL `CASCADE` or MySQL multi-statements
- FIX: Add Kanboard 1.2.54 coverage for PHP 8.2–8.5, SQLite, MySQL 8.4 and PostgreSQL 17
- FIX: Preserve the existing SVG icons, colours and desktop layout while adding scoped, theme-aware responsive styling
- DOCS: Document backup requirements, allowlisted behaviour and supported database engines while preserving all contributor credits


## v1.0

### What's Changed

_(most recent changes are listed on top):_
- Initial release
- Delete Plugin Cleaning Jobs feature disabled
- Translations starter template included
- Major Contributors: @alfredbuehler @creecros

---

Read the full [**Changelog**](../master/changelog.md "See changes") or view the [**README**](../master/README.md "View README")
