# Run record — local Joomla backup and restore

Date: **2026-08-14 IST**

Result: **PASS**

## Purpose

Demonstrate that the Gate 2 local Joomla foundation can recover its database and uploaded media after destructive recreation of the Compose project's local Joomla and MySQL volumes.

This is a local development recovery proof only. It does not define the production backup policy.

## Environment

- Joomla `6.1.2`
- PHP `8.4.24`
- MySQL `8.4.11`
- Docker Desktop `4.85.0`
- Docker Engine `29.6.2`
- Docker Compose `v5.3.1`
- local HTTP `127.0.0.1:8080`

## Proof objects

Before backup:

- created a disposable Joomla proof article named `AKSHAR MANAV RESTORE PROOF — 13 AUG 2026`;
- uploaded independent disposable proof media through Joomla Media.

## Defect discovered and corrected

The first `mysqldump` attempt failed because the Joomla database user did not have the global `PROCESS` privilege used while inspecting tablespaces.

The backup implementation was corrected to use `--no-tablespaces` rather than broadening the application's database privileges. Dump acceptance was also strengthened to require mysqldump's completion marker.

## Verified backup

Local Git-ignored backup directory used for the successful rehearsal:

`backups/20260814-002934`

Artifacts:

- `database.sql`: 534,863 bytes;
- `media.tar.gz`: 4,891,976 bytes;
- `manifest.txt`: 382 bytes;
- SQL completion marker confirmed: `-- Dump completed on 2026-08-13 18:59:35`.

The backup artifacts themselves are intentionally not committed.

## Restore execution

The restore script:

1. validated the backup files;
2. deleted only this Compose project's local Joomla and MySQL volumes;
3. recreated clean volumes from the pinned foundation;
4. restored the database;
5. restored the Joomla `images/` archive;
6. restarted Joomla;
7. returned HTTP `200`.

The same verified backup was inadvertently restored a second time. The second run also completed and returned HTTP `200`, providing an additional repeatability signal.

## Manual verification

After restoration, the product owner confirmed:

- the proof article survived;
- the proof media survived;
- Joomla responded successfully with HTTP `200`.

## Acceptance

**PASS — local Joomla database and uploaded-media recoverability demonstrated.**

## Remaining limitation

Production and staging still require a host-specific backup policy covering at least:

- off-site storage;
- retention;
- encryption and access controls;
- monitoring/failure visibility;
- recovery objectives;
- restore cadence/rehearsal;
- final persistent-media layout.
