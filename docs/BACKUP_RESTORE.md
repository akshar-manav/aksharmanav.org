# Local backup and restore rehearsal

This procedure proves that the Gate 2 local Joomla foundation can preserve and recover its database and uploaded media. It is deliberately local-only. It does not create cloud infrastructure, change DNS, or define the eventual production backup system.

Backups may contain organisational content or personal data. The `backups/` path is Git-ignored. Never commit, paste, or upload a real backup without a separate rights, privacy and security decision.

## Scope

The current proof captures:

- the complete Joomla MySQL database;
- Joomla's `images/` directory, which is the initial user-uploaded media location;
- a small manifest containing component versions and backup scope.

Custom reviewed templates/extensions belong in source control rather than runtime backups. Production backup design must later cover the final persistent-media layout and off-site retention.

## Create a backup

Start the local environment and confirm it is healthy:

```powershell
docker compose up --detach --wait
docker compose ps
```

Create a backup:

```powershell
.\scripts\backup-local.ps1
```

A timestamped directory is created below `backups/` containing:

```text
database.sql
media.tar.gz
manifest.txt
```

The script fails if either portable backup artifact is empty.

Before the first restore rehearsal, create an unmistakable disposable proof item in the local Joomla site and upload a disposable proof image. Record their names locally; do not add private or rights-unclear material merely for testing.

## Clean restore rehearsal

The restore rehearsal is intentionally destructive to the current Compose project's **local** Joomla and MySQL named volumes. It does not affect Git, GitHub, DNS, hosting or any external service.

Choose the timestamped backup directory, then run:

```powershell
.\scripts\restore-local.ps1 -BackupDirectory '.\backups\YYYYMMDD-HHMMSS' -ConfirmDestructiveRestore
```

The script:

1. verifies that the backup files exist and are non-empty;
2. removes this Compose project's local Joomla and MySQL volumes;
3. creates a fresh Joomla/MySQL foundation from the pinned images;
4. imports the database backup;
5. restores the `images/` archive;
6. restarts Joomla;
7. requires an HTTP 200 response from the restored local site.

## Manual acceptance

HTTP health alone does not prove useful recovery. After the script succeeds, manually verify:

- the disposable proof content item exists with the expected content;
- the disposable proof image loads correctly;
- administrator login still works using the restored site's expected local account;
- `docker compose ps` reports healthy services;
- Joomla and MySQL versions remain within the pinned Gate 2 foundation.

Record the rehearsal date, source backup directory, result and any limitations in a dated run record. Do **not** commit the backup artifacts themselves.

## Current limitation

This is a development recoverability proof, not the final production backup policy. Production still requires an off-site destination, retention rules, encryption/access controls, monitoring, restore frequency, recovery objectives and a procedure appropriate to the selected host.
