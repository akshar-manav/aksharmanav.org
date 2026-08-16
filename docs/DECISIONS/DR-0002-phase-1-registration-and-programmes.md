# DR-0002: Phase 1 registration, fees and programme representation

Status: **Proposed from explicit product-owner direction; requires PR acceptance**  
Date: **2026-08-16**

## Context

The earlier Phase 1 documents parked payment and complex membership functionality. The product owner has since explicitly directed that Phase 1 include:

- ₹500 lifetime-membership registration with a working backend and automated receipt;
- new membership numbers beginning after the 348 existing registered members;
- registration and fee handling for public events;
- representation of enrolment-based Akshar Manav programmes;
- no online donation facility;
- no GST, 80G or unverified registration claims on receipts.

The seventeenth `माणूस संमेलन`, scheduled for 21–23 August 2026, is the first representative event.

## Decision

1. Phase 1 includes simple, purpose-specific registration and payment records for lifetime membership, events and approved enrolment programmes.
2. Donations remain excluded.
3. Membership, event registration and class enrolment are separate journeys and datasets.
4. A payment gateway confirmation may mark a payment as captured; settlement status is reconciled separately.
5. A membership number is assigned only after successful payment. Numbers 1–348 are reserved for the existing member register; the first new confirmed member receives `AM-000349`.
6. Application IDs, receipt IDs and membership numbers remain separate.
7. Failed or abandoned payments do not consume membership numbers.
8. Receipt language describes the payment's real purpose, such as `आजीव सभासद शुल्क`, `संमेलन प्रवेशमूल्य` or `वर्ग शुल्क`.
9. The site must not describe these payments as donations or tax-deductible contributions.
10. Until a gateway is selected and tested, event pages may publish approved bank/WhatsApp instructions. Production payment details require a test transaction and account-holder verification.
11. Public content never exposes applicant/member personal data, payment evidence or transaction references.

## Consequences

- The Joomla content model needs departments, programmes, programme editions/events and related editorial content.
- Secure registration/payment processing will require a separately reviewed backend implementation, gateway selection, privacy notice, retention rules and reconciliation view.
- An ordinary Joomla article can present the first event, but it must not pretend that a backend registration has completed.
- The Phase 1 backlog and execution plan must be updated before implementation begins.

