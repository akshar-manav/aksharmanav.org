# Akshar Manav Website Project Hub

Status: **Canonical orientation and current-state page for the website/publishing-platform project**

Last reviewed: 2026-08-14

## Purpose of this repository

This repository is only for the **Akshar Manav official website and multilingual publishing platform** at `aksharmanav.org`.

It is not the operating repository for Akshar Manav as an organisation. Organisational management, social-media operations, events, departments, campaigns, internal administration and unrelated initiatives should not be managed here except where an approved decision or factual source is required by the website.

The website consumes approved organisational truth and publishes approved public material; it does not define the organisation by itself.

## Source-of-truth order

When sources conflict, use this order unless the product owner explicitly changes it:

1. accepted files on canonical `main`;
2. explicit current decisions from the product owner;
3. authoritative organisational records and approved source documents;
4. historical Akshar Manav source material;
5. existing or temporary public website material;
6. earlier exploratory chats and exports;
7. AI-generated proposals.

Do not promote an older chat suggestion into an accepted decision merely because it is detailed.

## Current state

### Completed

- Product and organisational website foundation accepted.
- Public GitHub repository established under the Akshar Manav organisation.
- Software/non-software rights boundary established.
- Joomla selected as the Phase 1 CMS/editorial platform.
- Reproducible local Joomla foundation established with Docker.
- Local foundation proven on Windows with Joomla 6.1.2, PHP 8.4 and MySQL 8.4.
- Local database and uploaded-media backup/restore rehearsal completed successfully.
- Backup/restore implementation and dated recovery evidence merged through PR #4.
- Marathi and English are the initial editorial languages; architecture must allow additional languages later.

### In progress

- Bring project-status documentation up to date through the project-boundary/status checkpoint.
- Define the Phase 1 information architecture and Joomla content model.
- Define contributor/editor/translator/publisher roles and permissions.
- Begin the actual UX, visual-design and brand-foundation work.
- Prepare representative approved Marathi/English content and authentic media for the first design slice.

### Not yet done

- No production host has been selected.
- No staging or production Joomla environment has been accepted.
- No production DNS cutover is authorised.
- No final visual identity or custom Joomla frontend has been accepted.
- No Phase 1 public content set has been accepted.
- No production analytics implementation has been accepted.

## Immediate product milestone

The next meaningful milestone is **a real, designed Akshar Manav vertical slice in Joomla**, not additional infrastructure for its own sake.

That vertical slice should include:

- primary navigation;
- a designed homepage;
- one representative essay/article page;
- one representative initiative/event page;
- Marathi and English behaviour;
- responsive typography and layout;
- authentic media treatment;
- accessibility and performance basics;
- restrained, intentional motion.

This is the point at which the project should visibly become the Akshar Manav website rather than only a Joomla engineering foundation.

## Workstreams

### 1. Product and information architecture

Owns navigation, page hierarchy, content types, taxonomies, language relationships, participation journeys and publishing formats.

### 2. Editorial system

Owns Joomla roles, draft/review/publish workflow, translation workflow, contributor profiles, revision responsibility and publishing governance.

### 3. Design and frontend

Owns visual identity, typography, layout, responsive behaviour, custom Joomla template, CSS/JavaScript/SVG/motion/3D where appropriate, accessibility and frontend performance.

### 4. Platform engineering

Owns Joomla/PHP/MySQL runtime, local development, security, backups, staging, production deployment, observability and rollback.

### 5. Content and evidence

Owns approved Marathi/English content, organisational truth, archival material, photography rights, source references and factual verification.

## Collaboration model

### Developers

Developers work through GitHub branches and pull requests and use the reproducible local environment. Reviewed custom template/code belongs in Git.

### Joomla/CMS collaborators

Joomla collaborators may work in a shared staging administrator environment with least-privilege accounts. Configuration or code that must be reproducible should still be represented through documented/reviewed project changes where practical.

### Writers, editors and translators

They should work through Joomla editorial accounts and workflows, not GitHub. Ordinary essays and editorial content belong in the CMS rather than requiring code commits.

### Release authority

Production website releases remain subject to the accepted release process and current product-owner authority recorded elsewhere in the repository.

## Boundary with the main Akshar Manav project

The following belong primarily to the **main Akshar Manav organisational project**, not this repository:

- organisational strategy and governance;
- social-media channel strategy and day-to-day publishing;
- Facebook/Instagram/YouTube/other platform operations;
- language-specific social accounts such as Akshar Manav English, Hindi, Kannada or Bangla;
- event and programme management unless being represented on the website;
- department management, including AI-department work;
- magazine production operations;
- outreach, partnerships and community administration;
- internal people/role management;
- broad communications planning.

Approved outputs from those areas may later become website content or requirements.

## Hosting position

The application architecture remains Joomla-first. A separate Vercel/Next.js frontend is not part of the accepted Phase 1 architecture. Railway is a proof candidate, not a production commitment. Hosting selection should follow measured staging/proof evidence and a comparison with a credible Joomla-compatible alternative.

## Operating rule for future chats and agents

At the beginning of consequential website work:

1. inspect current `main` and open PRs;
2. read this hub plus the relevant canonical docs;
3. distinguish accepted decisions from proposals and older chat exports;
4. update this hub when a major website milestone, boundary or next action materially changes.

The goal is that a future collaborator can answer **where are we, what is decided, what is next, and what does not belong here** without reconstructing multiple ChatGPT conversations.
