# Provisional architecture v0.1

Status: **Proposed; production host not selected**

## Product architecture

Phase 1 is planned as a Joomla-based multilingual website and editorial backend. Joomla is expected to provide content, users, roles, workflows, menus, media and language associations without a separate custom application backend.

```text
Visitor
  ↓
Cloudflare Free
  ↓
Joomla application
  ↓
MySQL database + persistent media
  ↓
Automated off-site backups
```

## Proposed deployment

- **Application platform:** no production host selected; Railway is the first proof candidate.
- **Application:** current supported Joomla 6 patch, pinned and updated through review.
- **Runtime:** PHP 8.4 foundation target.
- **Database:** MySQL 8.4 foundation target.
- **Edge:** Cloudflare Free for DNS, TLS, caching and baseline protection.
- **Source:** this GitHub repository.
- **Media:** persistent runtime storage initially, with a portable migration path.
- **Email:** HTTPS-based transactional email service if the hosting plan restricts SMTP.
- **Environments:** local development, staging and production.

## Repository boundary

Commit:

- custom template and code;
- controlled configuration examples;
- deployment definitions;
- tests and scripts;
- documentation;
- non-sensitive public assets with confirmed rights.

Do not commit:

- production secrets;
- runtime configuration containing credentials;
- database dumps with personal data;
- unreviewed member data;
- private media;
- backups;
- generated caches or dependencies.

## Local foundation

The Gate 2 local environment is defined in `compose.yaml` and remains independent of any hosting provider:

- Joomla `6.1.2` with PHP `8.4` and Apache from the official `joomla:6.1.2-php8.4-apache` image;
- MySQL `8.4.11` from the official `mysql:8.4.11` image;
- a loopback-only HTTP port, with no database port exposed to the host;
- separate named volumes for the Joomla runtime tree and MySQL data;
- neutral local auto-install values supplied only through a Git-ignored `.env` file;
- service-level database and HTTP health checks;
- local PHP settings that meet Joomla's recommended 256 MB memory limit.

The Joomla named volume contains core runtime files, uploads, caches, logs, temporary files and `configuration.php`. It is not source control. Future reviewed custom templates and extensions will be tracked separately so that custom code can be packaged without committing runtime state or secrets.

This layout preserves migration to ordinary compatible PHP/MySQL hosting: the portable application state remains the Joomla filesystem plus a database export. Backup/restore proof, production configuration and host-specific packaging are later checkpoints.

## Engineering principles

- minimal third-party extensions;
- no page-builder dependency at foundation stage;
- reproducible environment;
- least-privilege access;
- automated checks before release;
- backups tested through restoration;
- observable health and errors;
- portable data and media;
- documented rollback;
- low baseline resource use.

## Hosting proof decision

See [ADR-0001](DECISIONS/ADR-0001-hosting-proof-direction.md). It proposes a free local foundation followed by a separately approved Railway proof and a verified shared-host comparison. It does not authorise infrastructure creation or select a production host.

## Evidence still required

Before implementation, record an architecture decision covering:

1. Railway cost under a representative Joomla and MySQL workload;
2. volume persistence and backup export;
3. staging cost;
4. SMTP or transactional email route;
5. Joomla 6 compatibility;
6. comparison with one credible low-cost shared-hosting alternative;
7. recovery and migration procedure.

Railway remains a proof candidate, not an irreversible commitment or production selection.
