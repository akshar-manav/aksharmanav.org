# Policy foundation run — 2026-08-08

## Objective

Prepare the first reviewable part of the `v0.2.0` engineering foundation without installing Joomla or provisioning infrastructure.

## Canonical state before the run

- public repository `akshar-manav/aksharmanav.org`;
- `main` at `007a14a0112b084749455ce555b8c5d76a8c60c6`;
- PR #1 merged;
- documentation foundation present;
- no software licence, Joomla application, hosting environment, database or deployment.

## Work performed

- re-read the canonical foundation and corrected stale backlog state;
- rechecked current official Joomla release and technical requirements;
- rechecked Railway plans, resource pricing, persistence, backup, networking, SMTP, scheduling, rollback and regional constraints;
- compared Railway with an advertised low-cost Indian Joomla-hosting route;
- selected `GPL-2.0-or-later` for original software;
- separated software rights from organisational content, translations, media, archives, brand and personal data;
- added concise agent instructions and conservative project-level automation permissions;
- adopted local-first development and a later, separately approved hosting proof.

## Validation

- `opencode.jsonc` parsed successfully;
- configuration fields were checked against the official schema, rules and permission documentation current on 2026-08-08;
- destructive shell commands, Git pushes, external-directory access, subagents, external MCP tools and deployment CLIs are denied by project policy;
- licence text and policy boundary were reviewed together;
- the complete branch diff was inspected;
- current Joomla, Railway and shared-host claims were rechecked against their cited primary/provider sources;
- no secrets, personal data, production configuration or source PDF were added.

## Explicitly not performed

- no Joomla/PHP/database image built or run;
- no Railway or shared-host account or resource created;
- no cost incurred;
- no DNS, domain, email or Cloudflare change;
- no content or media relicensed;
- no deployment.

## Decision outcome

- `GPL-2.0-or-later` accepted for original repository software;
- non-software rights remain outside the software licence unless explicitly licensed;
- ADR-0001 accepted;
- no production host selected or authorised.

## Remaining decisions

- legal confirmation if specified organisational material will receive an open-content licence;
- exact local container and backup/restore implementation in the next PR;
- hosting selection only after executable proof and a verified offer.

## Research sources

The dated source list is recorded in `docs/DECISIONS/ADR-0001-hosting-proof-direction.md`. Licensing was checked against the [Joomla licence FAQ](https://tm.joomla.org/joomla-license-faq.html), [Joomla extension GPL requirements](https://extensions.joomla.org/support/knowledgebase/submission-requirements/the-gpl-the-jed/), [GNU GPL v2](https://www.gnu.org/licenses/old-licenses/gpl-2.0.html), and [Creative Commons licence guidance](https://creativecommons.org/cc-licenses/) on 2026-08-08.
