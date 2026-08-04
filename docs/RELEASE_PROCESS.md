# Release process v0.1

## Roles

- **Final website release authority:** Ajinkya Kinhikar.
- Contributors and reviewers provide specialised review.
- Deployment access is limited to authorised maintainers.

## Gates

| Gate | Outcome |
|---|---|
| 0. Truth and authority | Claims, sources, ownership and approval boundaries recorded |
| 1. Product and content architecture | Phase 1 scope, information architecture, publishing and translation model accepted |
| 2. Reproducible Joomla foundation | Local environment, repository boundary and baseline checks established |
| 3. Brand, design and implementation | Accepted identity and accessible responsive implementation |
| 4. Content and multilingual setup | Approved content migrated and language relationships verified |
| 5. Staging acceptance | Functional, content, accessibility, security, backup and rollback checks passed |
| 6. Production release | Tagged release deployed and verified |

## Version sequence

- `v0.1.0`: project foundation;
- `v0.2.0`: reproducible Joomla and infrastructure foundation;
- `v0.3.0`: Phase 1 content structure and visual-system implementation;
- release candidates as needed;
- `v1.0.0`: accepted Phase 1 production release.

Versions may be adjusted through a recorded decision.

## Pull requests

Every substantive change should identify:

- what changed and why;
- user or contributor impact;
- truth or source implications;
- security and privacy implications;
- checks performed;
- screenshots for visual changes;
- known limitations and follow-up work.

Draft pull requests are working checkpoints. Merging requires explicit acceptance appropriate to the change.

## Production checklist

Before production:

- accepted staging build;
- content and source review;
- accessibility and responsive review;
- supported dependency versions;
- security checks;
- privacy review;
- database and media backup;
- successful restoration rehearsal;
- rollback target identified;
- DNS and TLS plan;
- release-authority approval.

After production:

- verify key pages, languages, forms and metadata;
- record deployed version and time;
- monitor errors;
- retain rollback capability;
- create a release run record.

The domain must not be redirected from the current holding page until staging acceptance and rollback readiness are confirmed.
