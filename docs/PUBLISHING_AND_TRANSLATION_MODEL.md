# Publishing and translation model v0.1

## Purpose

Akshar Manav needs a multilingual publishing system rather than a generic blog. It should support public thought, literature, organisational communication, field learning and archival material while maintaining editorial trust.

## Initial content types

- विचार and essays;
- philosophy and foundational texts;
- literature and creative work;
- field and initiative reports;
- interviews and conversations;
- news and announcements;
- event pages and reports;
- research and explainers;
- official statements;
- documents and publications.

Joomla implementation may use shared article infrastructure where practical, but the editorial model and presentation must preserve these distinctions.

## Required metadata

Each publication should support:

- stable content identity and URL;
- title, summary and body;
- format and topic;
- primary language;
- author, contributors, translator and reviewer;
- original publication date and revision date;
- translation relationship;
- translation status;
- sources and related organisational entities;
- featured media with rights, caption and alt text;
- canonical URL, social metadata and appropriate structured data.

## Editorial states

```text
idea → draft → editorial review → factual review → translation → language review → scheduled/published → revised/archived
```

Simple announcements may use a reduced workflow. Foundational, historical, legal or official content requires factual and authorised review.

## Language approach

Phase 1 establishes Marathi and English editions while keeping the architecture open to additional languages.

- Marathi may be the original language for historically rooted or locally authored material.
- English should be carefully authored for international understanding.
- Other languages should be added according to real audience and contributor capacity.
- Machine translation may assist a draft.
- Unreviewed machine translation must not be automatically published.
- Each language edition has its own editorial status.
- Missing translations use a clear fallback, without pretending that a translation exists.
- Right-to-left scripts, locale-specific typography and date conventions must be supported by the design system.

## Translation governance

Maintain:

- an Akshar Manav terminology glossary;
- translation memory where tooling permits;
- named language reviewers;
- revision history;
- visible original-language and translated-edition relationships;
- a mechanism to report translation errors.

## Search and AI discoverability

The platform should provide clean server-rendered HTML, canonical URLs, language-specific sitemaps, `hreflang`, semantic headings, strong internal linking, authorship, update dates, accessible media text and relevant structured data. Authority comes from clear, sourced and stable content rather than repetitive keyword writing.

## Contributor access

Approved contributors should receive the minimum permissions needed for their role. Writing, translating, reviewing and production administration should be separable. Public contribution does not imply direct publishing or infrastructure access.
