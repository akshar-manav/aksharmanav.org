# Local Joomla foundation run — 2026-08-08

## Objective

Create the smallest reviewable, provider-independent local Joomla foundation for Gate 2 without deployment, external infrastructure or organisational content.

## Canonical state before the run

- public repository `akshar-manav/aksharmanav.org`;
- `main` at `45620192bff1b1792df4043501de04c4f58b3fc4`;
- PRs #1 and #2 merged;
- ADR-0001 accepted;
- no Joomla runtime, database, host, staging environment or production deployment.

## Versions verified

Official sources accessed on 2026-08-08 confirmed:

- Joomla `6.1.2` remains the current Joomla 6 release;
- Joomla 6 recommends PHP `8.4`, MySQL `8.4` and at least 256 MB PHP memory;
- the official Joomla image publishes `joomla:6.1.2-php8.4-apache` for multiple architectures;
- the official MySQL image publishes the exact 8.4 LTS patch tag `mysql:8.4.11` for AMD64 and ARM64.

The accepted Joomla/PHP/MySQL baseline therefore required no architecture-record adjustment.

## Work performed

- added a Docker Compose environment with exact Joomla/PHP/MySQL release tags;
- kept the web port on host loopback and left MySQL unexposed;
- placed Joomla runtime state and MySQL data in separate named volumes;
- added neutral unattended local installation variables through `.env.example`;
- ignored real local variables, Joomla secrets, runtime state, caches, generated dependencies and database exports;
- added database and HTTP health checks;
- set the recommended local PHP memory limit;
- documented Windows PowerShell startup, shutdown, reset, version proof and troubleshooting;
- documented the tracked-code/runtime and hosting-portability boundaries;
- added a small static configuration-safety checker.

No Joomla extension, page builder, organisational content, personal data, media, source PDF or production configuration was added.

## Validation

### Initial static validation — 2026-08-08

The initial validation environment did not provide Docker, Docker Compose, Podman, PHP or MySQL executables. No container image was pulled and no runtime was started there.

Validation performed:

- static configuration-safety checker;
- YAML parsing of `compose.yaml`;
- Git ignore checks for `.env`, `configuration.php` and representative runtime paths;
- complete branch diff inspection and whitespace/error checking;
- scan for ambiguous image tags, accidental secrets, personal data, deployment configuration and out-of-scope tooling language.

### Windows executable proof — 2026-08-09

A clean checkout of commit `eaed8118b3ee3bb288a6b97285b1ca479ad5658f` was verified with Docker Desktop 4.85.0, Docker Engine 29.6.2 and Docker Compose v5.3.1 using the WSL2 backend.

Executable results:

| Check | Result |
|---|---|
| Static safety checker and Compose parsing | Passed |
| Joomla image | `joomla:6.1.2-php8.4-apache` |
| Joomla resolved digest | `sha256:fcb334140a3c1ae9b93660a645d46c13bb6b46ba809a49768472115211710e9b` |
| MySQL image | `mysql:8.4.11` |
| MySQL resolved digest | `sha256:b3b90af2a6552ae30c266fdb7d5dd55f3afb72404bb78d37fe8a23eb857fd3fb` |
| Joomla runtime | `Joomla! 6.1.2 (debug: No)` |
| PHP runtime | `PHP 8.4.24 (cli)` |
| PHP memory limit | `256M` |
| MySQL runtime | `8.4.11` Community Server GPL |
| Database health | Healthy |
| Joomla health | Healthy |
| Public local endpoint | HTTP 200 at `http://127.0.0.1:8080` |
| Administrator endpoint | HTTP 200 at `http://127.0.0.1:8080/administrator` |
| MySQL host exposure | No host port published |
| Restart persistence | Joomla and administrator endpoints returned HTTP 200 after `docker compose down` and recreation |
| Final state | Containers stopped; Joomla and MySQL named volumes retained |
| Repository state | Clean; local `.env` remained ignored |

No tracked file required correction during the independent executable review. The runtime foundation passed the defined local checks and remains awaiting product-owner acceptance and merge.

## Explicitly not performed

- no deployment or external resource creation;
- no Railway, shared-host, staging or production configuration;
- no DNS, domain, Cloudflare or email change;
- no expenditure;
- no backup or restore proof;
- no production hardening claim.

## Sources

- [Joomla 6.1.2 downloads](https://downloads.joomla.org/us/cms/joomla6/6-1-2)
- [Joomla 6 technical requirements](https://manual.joomla.org/docs/next/get-started/technical-requirements/)
- [Joomla Docker Official Image](https://hub.docker.com/_/joomla)
- [Joomla official image tags](https://hub.docker.com/_/joomla/tags)
- [MySQL Docker Official Image](https://hub.docker.com/_/mysql)
- [MySQL official image tags](https://hub.docker.com/_/mysql/tags)
