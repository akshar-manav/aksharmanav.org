# Phase 1 programmes register

Status: **Working public-programme register**  
Last updated: **2026-08-16**

This register separates departments, programmes and individual events. A programme may belong to a department, accept enrolments, publish articles and hold multiple events. An event remains its own dated record with its own gallery, report and testimonials.

| Public name | Type | Parent department / programme | Phase 1 website treatment |
|---|---|---|---|
| अक्षर मानव माणूस संमेलन | Recurring hallmark programme | Akshar Manav | Permanent programme page plus a page for every numbered edition; edition 17 is the first representative event |
| अक्षर मानव शिवकावणी वर्ग | Teaching and enrolment programme | To be confirmed | Programme page, available classes, teachers, schedule, language, mode, fee and enrolment status |
| अक्षर मानव वाचन अड्डा | Reading club / recurring programme | अभिवाचन विभाग | Programme page, reading calendar, selected book or text, facilitators, participation and session archive |
| अक्षर मानव मस्तीची पाठशाळा | Children’s learning programme | बाल विभाग | Programme page, age group, activities, schedule, safety/consent information and enrolment |

## Naming rule

Public Marathi names above reproduce the product owner's wording from 2026-08-16. Do not replace them with generic NGO terminology. The spelling `शिवकावणी` is retained exactly as supplied until the product owner or Marathi editor changes it.

## Required relationships

```text
Department
  → Programme
    → Event / session / edition
      → Article or report
      → Photo gallery
      → Testimonials
      → Registration records
```

Programmes may also publish evergreen information such as eligibility, curriculum, class mode, teacher names, fee, contact and enrolment status. Department-chief names remain optional and hidden when empty.

## Information still needed for enrolment programmes

- current classes or sessions;
- online/offline mode and platform;
- age or eligibility;
- teacher/facilitator names approved for publication;
- schedule and duration;
- fee and cancellation rules;
- maximum capacity;
- enrolment contact;
- photograph/media rights;
- whether the fee is collected by Akshar Manav or a separately operated entity.

