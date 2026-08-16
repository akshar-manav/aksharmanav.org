# Akshar Manav Joomla template development

The first template checkpoint is an installable Cassiopeia child template. It uses Joomla module positions so navigation and homepage content remain editable in the administrator interface.

## Build the installable package

From the repository root:

```powershell
python scripts/build-template-package.py
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
