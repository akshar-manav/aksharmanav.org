# DR-0003: Registration and fees system boundary

Status: **Accepted implementation direction; payment provider and ERP are unselected**

Date: **2026-08-17**

Decision authority: **Ajinkya Kinhikar**

## Context

Phase 1 now includes lifetime-membership registration and may include event or class enrolment. Fees, payment verification, receipts and member numbering must not be embedded into the homepage template or scattered across independent forms. A future Akshar Manav ERP may need to receive or become the system of record for accepted applications.

## Decision

Create a standalone Joomla registration component, working name `com_aksharregistration`, with small presentation modules that may be placed on relevant pages.

The component owns the transactional workflow. The website template only provides placement and visual integration.

```text
Joomla page/module
  -> registration component
      -> application record
      -> payment-provider adapter
      -> verified payment event
      -> receipt + public reference
      -> integration outbox
          -> future ERP API/webhook
```

## Supported registration contexts

- lifetime membership;
- dated event registration;
- continuing class or programme enrolment.

They share a secure engine but retain separate forms, fee rules, capacity rules, reference formats and confirmation messages.

## Data ownership

The component stores:

- application identity and registration type;
- applicant fields required for that type;
- consent and privacy acknowledgements;
- fee rule applied at the time of application;
- payment-provider references and verified status;
- receipt number and immutable receipt facts;
- membership or event reference allocated after success;
- ERP synchronisation state and error history.

Bank secrets, gateway secrets and ERP credentials remain outside Git and outside editable article content.

## Numbering

The current known lifetime-member register contains 348 members. The provisional website sequence therefore begins at integer `349`.

Working display format: `AM-LM-000349`.

The integer sequence is stored separately from the display prefix. This permits later reconciliation or a nomenclature change without changing the underlying identity. A number is allocated only after the payment provider confirms a successful transaction. Manual or migrated records require an authorised reconciliation route and audit note.

Event and programme registrations use their own sequences and never consume lifetime-member numbers.

## Payment rule

- Never trust a browser redirect or user screenshot as proof of payment.
- Record the provider order/payment identifiers.
- Verify a signed server-to-server webhook or provider API result.
- Make webhook handling idempotent so retries cannot create duplicate receipts or numbers.
- Generate the receipt only after verified success.
- Preserve failed, expired, refunded or disputed states without reusing identifiers.

The payment-provider adapter remains replaceable. Selecting Razorpay or another provider requires a separate implementation decision after account, pricing, webhook and settlement checks.

## ERP integration

Use an outbox record for each accepted or materially updated registration. The future ERP connector reads unsynchronised records, sends a versioned payload and stores the ERP acknowledgement. Registration must still complete when the ERP is temporarily unavailable; synchronisation retries safely.

The initial contract exposes no public bulk member data. ERP access requires authenticated, least-privilege server credentials and an explicit privacy review.

## Phase 1 exclusions

- online donations;
- GST or tax-benefit claims not supported by verified records;
- complex internal member management;
- treating the payment gateway as the membership database;
- storing card, UPI PIN or other sensitive payment credentials;
- silently syncing personal data to an unapproved ERP.

## Consequences

- Website copy and design can change without changing financial records.
- Membership, events and classes can reuse verified infrastructure.
- A future ERP can be connected through an adapter rather than a migration-driven rewrite.
- The component requires security, privacy, payment reconciliation and recovery testing beyond ordinary content pages.
