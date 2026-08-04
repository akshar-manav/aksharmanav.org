# Provisional architecture v0.1

Status: **Proposed; decision not yet locked**

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

- **Application platform:** Railway, subject to a cost and operational proof.
- **Application:** supported Joomla 6 release, subject to hosting and extension compatibility.
- **Runtime:** supported PHP version.
- **Database:** supported MySQL 8 release.
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

## Decision still required

Before implementation, record an architecture decision covering:

1. Railway cost under a representative Joomla and MySQL workload;
2. volume persistence and backup export;
3. staging cost;
4. SMTP or transactional email route;
5. Joomla 6 compatibility;
6. comparison with one credible low-cost shared-hosting alternative;
7. recovery and migration procedure.

Railway is currently the leading option, not an irreversible commitment.
