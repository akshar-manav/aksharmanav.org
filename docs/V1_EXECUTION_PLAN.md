# v1 execution plan

Status: **Working execution plan for the first accepted public website release**

Last reviewed: 2026-08-14

## Goal

Deliver a credible, beautiful, multilingual first public release of `aksharmanav.org` that makes Akshar Manav understandable, publishable and maintainable without turning Phase 1 into a full social network or organisational management system.

The website should feel like the digital home of a serious humanist, intellectual and social movement rather than a generic NGO template or an unstyled CMS.

## Current starting point

The engineering foundation exists:

- canonical public GitHub repository;
- Joomla 6.1.2 / PHP 8.4 / MySQL 8.4 local Docker environment;
- Windows runtime proof;
- local persistence proof;
- successful local database and uploaded-media backup/restore rehearsal;
- accepted product, publishing, rights and architecture foundations.

The major missing work is now product architecture, design, editorial setup, representative content, staging and production delivery.

## Phase A — close and stabilise the foundation

1. Merge the reviewed local backup/restore implementation after final repository verification.
2. Keep `PROJECT_HUB.md`, this execution plan and the backlog aligned with reality.
3. Preserve Joomla-first architecture; do not introduce a separate frontend framework without a specific accepted need.
4. Keep production hosting unselected until a real application slice can be measured.

**Exit condition:** foundation documentation matches the executable local state and there is no ambiguity about the immediate product work.

## Phase B — information architecture and content model

Define the smallest coherent Phase 1 structure, including at minimum:

- Home;
- Philosophy;
- About and history;
- How Akshar Manav works;
- Fields / initiatives;
- Essays / विचार and other publishing formats;
- Events and announcements;
- Participate / join;
- Contact.

Define Joomla structures for:

- essays and विचार;
- philosophy;
- literature / creative work where in scope;
- field and event reports;
- interviews;
- news / announcements;
- research / explainers;
- official statements and documents;
- authors and contributors;
- categories / fields / topics;
- language associations and translated editions.

Do not flatten all publication formats into a single generic blog stream.

**Exit condition:** page hierarchy, content types, metadata and representative journeys are reviewable before heavy frontend implementation.

## Phase C — editorial roles and multilingual workflow

Define practical, least-privilege roles for:

- contributor / writer;
- editor;
- translator;
- translation reviewer;
- publisher;
- Joomla administrator;
- developer / release maintainer.

Target editorial flow:

`Draft → Editorial Review → Approved → Published`

with separately reviewable translated editions rather than automatic equivalence.

Initial editorial languages are Marathi and English. The underlying model must allow additional Indian and international language editions later.

**Exit condition:** a writer can contribute without Git or dangerous administrator access, while editors and publishers have clear accountability.

## Phase D — visual foundation and design system

Create and review the actual Akshar Manav design language before multiplying pages.

Work includes:

- Marathi and Latin typography system;
- colour and tonal system;
- layout grid and spacing;
- navigation behaviour;
- photographic and archival treatment;
- iconography and original SVG language;
- motion principles;
- interaction states;
- accessibility states;
- responsive behaviour;
- article-reading experience;
- performance budgets.

The quality bar is internationally excellent contemporary web craft. Modern CSS, JavaScript, SVG, video, WebGL/3D or specialist animation libraries are allowed when they improve the experience and remain accessible, performant and maintainable. Joomla is the CMS and rendering platform; it does not constrain the visual ambition of the custom frontend.

Avoid motion merely for spectacle. Akshar Manav should feel thoughtful, contemporary, human and distinctive.

**Exit condition:** an accepted design direction exists for desktop and mobile with representative Marathi and English content.

## Phase E — build one real Joomla vertical slice

Before implementing every section, build a small end-to-end slice using representative real content:

1. global header/navigation and footer;
2. designed homepage;
3. one essay/article page;
4. one initiative or event page;
5. Marathi/English switching and associations;
6. authentic image/media treatment;
7. responsive states;
8. baseline accessibility, SEO and performance;
9. intentional animation/motion where approved.

The custom template and frontend code belong in Git. Editorial content belongs in Joomla.

**Exit condition:** the product owner can open the local site and evaluate an unmistakably real Akshar Manav website rather than an infrastructure demo.

## Phase F — expand Phase 1

Use the accepted vertical slice to implement the remaining Phase 1 templates and content journeys.

Complete:

- required public pages;
- publication listings and detail templates;
- author/contributor presentation where accepted;
- events/announcements;
- participation/contact journeys;
- search/indexing basics;
- metadata, structured data and AI/search discoverability;
- accessibility and responsive QA;
- privacy/security baseline;
- representative Marathi and English content.

**Exit condition:** Phase 1 is functionally complete locally and ready for shared staging.

## Phase G — staging and hosting proof

Only after a representative application exists:

1. run the separately approved Railway proof if still justified;
2. verify at least one credible Joomla-compatible hosting alternative;
3. compare persistent storage, database operations, email, backups, staging cost, performance and recovery;
4. select staging/production hosting from evidence;
5. deploy a protected/shared staging environment;
6. give appropriate Joomla accounts to CMS collaborators such as Arun Mapari;
7. conduct editorial, design, device and accessibility acceptance there.

A separate Vercel/Next.js frontend is not part of the default plan.

**Exit condition:** staging is accepted and the production architecture is supported by measured evidence.

## Phase H — production release

Before DNS cutover:

- production backup and off-site recovery policy accepted;
- rollback procedure verified;
- secrets and permissions reviewed;
- critical pages and language metadata accepted;
- accessibility and responsive checks passed;
- security baseline passed;
- production monitoring/error visibility available;
- legal/public claims checked against the truth register.

Then release through the documented production process and verify the live site after cutover.

## Parallel organisational dependencies

These are not website engineering tasks but can block public content:

- documentary verification of registration number and current legal details;
- approved Marathi and English organisational foundation text;
- authentic photography/archive inventory and rights decisions;
- current contact/participation information;
- decisions about which people, initiatives, fields and events are publicly represented.

The parent Akshar Manav project should own these decisions. The website project should consume their approved outputs.

## Explicitly out of v1 unless separately approved

- full social network;
- complex membership platform;
- donations/payment system;
- automatic mass translation and auto-publication;
- separate mobile applications;
- social-media management system;
- internal Akshar Manav organisational administration;
- headless frontend split merely for fashion or architectural novelty.
