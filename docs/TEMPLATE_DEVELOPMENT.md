# Akshar Manav Joomla template development

The first template checkpoint is an installable Cassiopeia child template. It uses Joomla module positions so navigation and homepage content remain editable in the administrator interface.

## Build the installable package

From the repository root:

```powershell
python scripts/build-template-package.py
```

On Windows systems where Python is exposed through the launcher, use:

```powershell
py scripts/build-template-package.py
```

This validates the manifest, required files, module positions and a small set of secret/configuration markers, then creates the Git-ignored package:

```text
build/tpl_aksharmanav.zip
```

## Install locally

1. Start the existing local Joomla environment.
2. Sign in at `http://127.0.0.1:8080/administrator`.
3. Open **System → Extensions → Install Extensions**.
4. Upload `build/tpl_aksharmanav.zip`.
5. Open **System → Site Template Styles**.
6. Set **Akshar Manav** as the default site template.

This changes only the local Joomla instance. It does not deploy or change production.

## Populate the representative editable homepage

After the template is installed and the local stack is running, use the idempotent local bootstrap:

```powershell
powershell -ExecutionPolicy Bypass -File scripts/bootstrap-local-homepage.ps1
```

The wrapper:

1. verifies that local Joomla is ready;
2. creates a timestamped database backup under the Git-ignored `backups/` directory;
3. synchronizes the current tracked template source into the installed local template;
4. runs PHP lint against the installed template before changing the database;
5. moves the existing Joomla menu module to `primary-menu`;
6. creates or updates representative Custom modules in the homepage positions;
7. assigns homepage modules only to the current Home menu item;
8. leaves all seeded wording editable under **Content → Site Modules**.

The bootstrap uses stable markers and may be rerun without creating duplicate modules. Its template synchronization is for the existing local development installation; the installable ZIP remains the release artifact. The seeded modules are local preview data, not a production content migration. Time-sensitive event details still require editorial review before release.

## Make content editable

Use **Content → Site Modules** to place core Joomla modules in the positions recorded in `EDITABLE_JOOMLA_CONTENT_MODEL.md`.

Recommended core module types for the first slice:

- Menu for `primary-menu`;
- Language Switcher for `language-switcher`;
- Custom or Articles modules for the homepage section positions;
- Breadcrumbs for `breadcrumbs`;
- Custom modules for footer contact/social information.

Assign homepage modules only to the Home menu item. Ordinary page and article content belongs in Joomla articles rather than template files.

## Update after source changes

Re-run the package command and upload the resulting ZIP again. The template manifest uses `method="upgrade"`, so reviewed source updates replace the installed template files while Joomla module content and menu assignments remain in the database.

## Current limitation

This environment cannot execute the canonical Windows Docker/Joomla runtime. The package receives static manifest, source and archive checks here; local Joomla installation, PHP linting in the container and visual browser acceptance remain required before merge.
