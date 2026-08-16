# Akshar Manav registration component

This directory is reserved for the standalone `com_aksharregistration` Joomla component described in `docs/DECISIONS/DR-0003-registration-fees-system-boundary.md`.

The first checkpoint records the boundary before payment-provider code is written. Do not put gateway secrets, bank details, production personal data or receipt records in this repository.

## Planned packages

- `com_aksharregistration`: applications, fee rules, verified payment state, receipts, numbering and integration outbox;
- `mod_aksharregistration_cta`: editable contextual link/summary block;
- `mod_aksharregistration_status`: privacy-preserving application status lookup;
- payment-provider adapters behind one internal interface;
- future ERP adapter behind one versioned integration interface.

## First executable increment

After the payment provider and minimum forms are approved:

1. create a no-payment test registration type;
2. persist an application with consent and audit metadata;
3. expose an administrator list with least-privilege access;
4. add a fake/test payment adapter;
5. prove idempotent payment confirmation and receipt allocation;
6. add the selected provider in test mode;
7. prove ERP-outbox retry behaviour against a local fake endpoint;
8. complete security, privacy, backup and restoration tests before real use.
