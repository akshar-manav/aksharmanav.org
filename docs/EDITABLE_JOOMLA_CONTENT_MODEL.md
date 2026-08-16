# Editable Joomla content model

Status: implementation boundary for the first Joomla vertical slice

Last reviewed: 2026-08-17

## Principle

Public wording, images, navigation, featured items, people, events, programmes and publications must remain editable in Joomla. The custom template controls structure, responsive behaviour and presentation. It must not become a second content database.

## What editors change in Joomla

- site navigation and menu order;
- Marathi and English page titles and text;
- organisation history and approved philosophy copy;
- selected work areas and the complete 90-area framework;
- programmes, events, fee information and registration links;
- essays, विचार, announcements and publications;
- the featured magazine issue and archive links;
- authentic photographs, captions, alt text and rights metadata;
- the currently displayed office bearers or department chiefs;
- contact information and social links;
- which modules appear on which menu pages.

## What remains in code

- semantic page structure and module positions;
- responsive layout and navigation behaviour;
- accessibility and reduced-motion behaviour;
- reusable typography, spacing and colour tokens;
- component and module layout overrides;
- form security, payment verification and receipt rules;
- integration contracts and automated checks.

## Core content relationships

Use Joomla core categories, articles, tags, custom fields, menus, modules and multilingual associations wherever they are sufficient.

```text
कार्यविभाग
  -> कार्यक्षेत्र
      -> उपक्रम
          -> कार्यक्रम
              -> लेख / छायाचित्र संच / अनुभव / प्रकाशन
```

The 90-area framework belongs on a complete detail/index page. The homepage shows only a deliberately selected subset and links to the complete framework.

## Initial categories

| Category | Purpose |
|---|---|
| `about` | organisation, philosophy and history |
| `work-areas` | authorised fields and the 90-area framework |
| `initiatives` | continuing programmes such as classes and clubs |
| `events` | dated editions such as `माणूस संमेलन १७` |
| `thought` | essays, विचार, interviews and explainers |
| `publications` | magazine issues and documents |
| `people` | the small approved public leadership selection |

These machine names are implementation identifiers. Public Marathi/English category titles remain editable.

## Homepage module positions

The template provides the following positions. Editors assign Joomla modules to them and can change, unpublish or reorder the content without a code release.

| Position | Intended editable content |
|---|---|
| `brand` | approved logo and organisation name |
| `primary-menu` | main Joomla menu |
| `language-switcher` | Joomla language switcher |
| `home-identity` | approved short explanation of Akshar Manav |
| `home-featured-event` | one current, approved event |
| `home-work-areas` | selected public work areas and full-framework link |
| `home-initiatives` | selected active programmes |
| `home-thought` | one or more approved विचार/editorial items |
| `home-publication` | current magazine issue and archive route |
| `home-participate` | membership or participation route |
| `footer-primary` | short description and primary contact |
| `footer-secondary` | language, social and policy links |

## Multilingual rule

Marathi and English items are separate Joomla records linked through language associations. Translation is editable and reviewable independently. Missing translations must not be represented as completed translations.

## Media rule

Media is editable through Joomla Media, but each publicly used item still requires a rights holder or source, permission status, caption, alt text and review date. AI-generated or stock human imagery is excluded.
