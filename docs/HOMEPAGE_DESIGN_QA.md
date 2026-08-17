# Homepage design QA

## Target

The selected direction combines the organic restraint and editorial motion preferred from visual options 2 and 3, then removes the mixed AI-image language. The final implementation is grounded in:

- the supplied eight-form-and-flame Akshar Manav mark;
- the supplied Sitakhandi Wakad photograph;
- the current Joomla module-position architecture;
- the approved Marathi event and publication corrections.

## Visual comparison

The previous local homepage was structurally complete but visually provisional: text-only wordmark, generic cards, no authentic imagery, limited hierarchy and no identity-led motion.

The new checkpoint establishes:

- a source-traced full-colour symbol and type lockup;
- a Devanagari-first editorial hierarchy;
- a warm neutral field with one logo colour at a time;
- an asymmetric identity hero with deliberate white space;
- one documentary event image used once;
- separate colour atmospheres for work, initiatives, thought, publication and participation;
- restrained one-time reveal motion with a reduced-motion fallback.

## Verification

| Check | Result |
|---|---|
| Desktop viewport | Passed at 1348px; no horizontal overflow |
| Mobile viewport | Passed at 375px; no horizontal overflow |
| Hero composition | Passed; hierarchy, symbol scale and CTAs remain clear |
| Event composition | Passed on desktop and mobile; authentic photo and critical facts remain legible |
| Mobile navigation | Passed; opens, closes after selection and updates `aria-expanded` |
| Section navigation | Passed for event, work and thought anchors |
| Images | Passed; no missing or zero-width assets |
| Console | Passed; no page-origin errors |
| Motion | Passed; single reveal and reduced-motion fallback present |
| Content corrections | Passed; monthly e-magazine is “अक्षर मानव”, not a newspaper |
| Registration facts | Passed; WhatsApp-only number and ₹1,500 / ₹2,000 tiers present |
| Map status | Passed; link is explicitly provisional/editable |

## Remaining local-runtime gate

The static, responsive design checkpoint passed. The canonical Windows Docker Joomla instance still needs the existing container PHP lint and one final browser refresh after the branch is pulled; that is an environment acceptance step, not a visual defect.

**final result: passed**

