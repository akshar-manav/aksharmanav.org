# ADR-0001: Hosting proof direction

- **Status:** Accepted
- **Date:** 2026-08-08
- **Decision owner:** Ajinkya Kinhikar
- **Scope:** Gate 2 engineering and infrastructure proof; no production-host approval

## Context

Akshar Manav needs an inexpensive, maintainable and portable Joomla platform with a database, persistent media, scheduled work, backups, recovery, HTTPS and a later staging path. The organisation has not authorised expenditure, external-resource creation, staging, production deployment or DNS changes.

The current Joomla release and infrastructure offers were rechecked on 2026-08-08 because versions, features and prices change.

## Current Joomla baseline

The current release is **Joomla 6.1.2**. Joomla 6.x supports PHP 8.3 or newer and recommends PHP 8.4. It requires MySQL 8.0.13 or newer and recommends MySQL 8.4; MariaDB 10.4 is the minimum, with newer releases recommended.

For the reproducible local foundation, target:

- Joomla `6.1.2` initially, updated only through a reviewed dependency change;
- PHP `8.4`;
- MySQL `8.4` from the official image;
- at least 256 MB PHP memory;
- container definitions that run locally and do not depend on Railway.

The exact images and checks belong in the next implementation PR. This record does not claim that they have been run.

## Options considered

### A. Railway

Railway can deploy Docker/GitHub services, provide private networking, public HTTPS and custom domains, run scheduled services, apply health checks, retain deployment history and attach persistent volumes. Its MySQL template uses the official MySQL image and is described by Railway as unmanaged.

Current costs:

- Free: $0 subscription with $1 monthly usage credit; maximum 0.5 GB RAM and 0.5 GB volume per service.
- Hobby: $5/month including $5 of resource usage.
- usage rates: $10/GB-month RAM, $20/vCPU-month CPU, $0.15/GB-month volume and $0.05/GB network egress.

A small always-on Joomla service plus MySQL is unlikely to remain within the Free credit. Until measured, use **$5–10/month** as the low-traffic planning range for one production environment; actual cost can be higher. An always-on duplicate staging environment adds usage, so staging should initially be temporary or activated only for acceptance work.

Important constraints:

- ordinary SMTP is blocked on Free and Hobby; email must use an HTTPS transactional-email API or a higher plan;
- volume backups can be scheduled daily, weekly and monthly, but restores are limited to the same project and environment;
- wiping a volume also deletes its Railway backups, so independent database and media exports remain mandatory;
- trial/free stateful data has limited retention after expiry;
- the nearest listed region for the initial Indian audience is Singapore, so data location and privacy implications require review before collecting personal data.

### B. Low-cost shared Joomla hosting

ResellerClub India's official Joomla plan is a credible procurement comparison. On 2026-08-08 it advertised ₹295/month with a three-year purchase and renewal at ₹480/month. This reduces container and database administration and includes conventional PHP/MySQL hosting, while giving weaker infrastructure-as-code, isolated staging and deployment rollback than Railway.

The public sales page does not prove every Joomla 6 requirement. Before purchase, obtain written confirmation of:

- PHP 8.4 and required modules;
- MySQL 8.0.13+ or MariaDB 10.4+;
- PHP `memory_limit` of at least 256 MB;
- SSH/SFTP, Git deployment and cron access;
- database-size, inode and connection limits;
- backup frequency, retention, export and customer-performed restore;
- staging/subdomain support, TLS, renewal price and data-centre location.

Other shared hosts may be substituted through the same checklist. Introductory prices requiring long prepayment must not be compared with Railway as though they were month-to-month commitments.

## Decision

1. **Select no production host yet.**
2. Build and verify the portable local Joomla foundation first at zero infrastructure cost.
3. Use Railway as the first, time-boxed infrastructure proof only after a separate explicit approval. Start with disposable data and a hard cost limit; do not attach the real domain.
4. In parallel, obtain a written compatibility and renewal-cost response from one shared Joomla host using the checklist above.
5. Choose staging and production only after comparing measured Railway cost and restore/rollback evidence against the verified shared-host offer.

This keeps Railway's engineering advantages available without turning a provisional preference into a financial commitment.

## Proof acceptance criteria

The later infrastructure proof must demonstrate:

- a pinned Joomla/PHP/database build from the canonical repository;
- persistent media across redeploys;
- private application-to-database traffic;
- a passing health check and failed-release rollback;
- scheduled database and media export;
- restore into a clean environment, not only an in-place platform snapshot;
- measured idle and representative cost;
- documented migration to ordinary PHP/MySQL hosting;
- no production data, domain cutover or paid resource without approval.

## Consequences

- Gate 2 begins locally and remains free.
- Railway-specific files must not become the only way to run the application.
- A second off-platform backup path is mandatory for production.
- Email delivery, privacy/data location and staging cost remain open decisions.
- Hosting prices and platform limits must be rechecked at procurement.

## Sources accessed 2026-08-08

Primary and provider sources:

- [Joomla latest release](https://downloads.joomla.org/us/latest)
- [Joomla 6 technical requirements](https://manual.joomla.org/docs/next/get-started/technical-requirements/)
- [Joomla hosting setup and shared-host checklist](https://guide.joomla.org/user-manual/getting-started/getting-started-hosting-setup)
- [Railway plans and resource pricing](https://docs.railway.com/pricing/plans)
- [Railway MySQL](https://docs.railway.com/databases/mysql)
- [Railway volumes](https://docs.railway.com/volumes)
- [Railway volume backups](https://docs.railway.com/volumes/backups)
- [Railway cron jobs](https://docs.railway.com/cron-jobs)
- [Railway deployment reference](https://docs.railway.com/deployments/reference)
- [Railway public networking](https://docs.railway.com/networking/public-networking)
- [Railway private networking](https://docs.railway.com/networking/private-networking)
- [Railway outbound networking and SMTP limits](https://docs.railway.com/networking/outbound-networking)
- [Railway regions](https://docs.railway.com/deployments/regions)
- [ResellerClub India Joomla hosting](https://india.resellerclub.com/joomla-hosting)
