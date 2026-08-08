# Agent operating instructions

This repository contains the public foundation and, later, the custom software for Akshar Manav's official multilingual website. Keep changes small, reviewable and reversible.

## Read before consequential work

Read these files completely when the task touches their subject:

- `docs/OPERATING_GUIDE.md`
- `docs/PRODUCT_BRIEF.md`
- `docs/ORGANISATIONAL_TRUTH_REGISTER.md`
- `docs/PUBLISHING_AND_TRANSLATION_MODEL.md`
- `docs/ARCHITECTURE.md`
- `docs/RELEASE_PROCESS.md`
- `docs/BACKLOG.md`

The organisational truth register controls historical, legal, statistical and governance claims. Do not convert an unverified item into public fact. Preserve the distinction between the movement beginning in 1981 and formal registration in 1996.

## Authority and approval

Ajinkya Kinhikar is the product owner and final website release authority.

Without explicit approval for the particular action, do not:

- merge or push directly to `main`;
- deploy or alter a hosting environment;
- provision, purchase or delete external resources;
- change DNS, domains, email delivery or production access;
- publish organisational claims, personal data or media whose rights are unclear;
- install a page builder or an additional Joomla extension.

Use a scoped feature branch and draft pull request for substantive work. A merge never implies deployment.

## Current engineering boundary

Joomla and hosting have not been installed. Railway is a proof candidate, not the selected production host. Follow the accepted architecture records and do not represent research as executable proof.

Track custom code, templates, extensions, tests, scripts, safe examples and public assets with confirmed rights. Never commit credentials, `.env` files, Joomla `configuration.php`, database dumps, runtime uploads, private media, member data, backups, caches or generated dependencies.

Software and organisational content have different rights. Follow `RIGHTS_AND_LICENSING.md`; never assume the repository software licence covers writing, translations, photographs, archives, names or logos.

## Working method

1. Verify repository, branch, HEAD and working-tree state.
2. State the intended files and acceptance criteria.
3. Make one coherent checkpoint.
4. Run the smallest relevant checks and inspect the complete diff.
5. Record evidence, limitations and unresolved decisions.
6. Open a draft PR and wait for review before merge.

Security, privacy, accessibility, multilingual correctness and recoverability are release requirements. Prefer core Joomla capability, minimal dependencies and portable infrastructure. Stop and ask when authority, rights, secrets, cost or destructive impact is unclear.
