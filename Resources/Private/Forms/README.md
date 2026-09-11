# Forms (EXT:form)

This package ships one example form (`Contact.form.yaml`) plus the plumbing
that makes new forms "just work": persistence path, client-side validation,
email templates, and localization. This file documents how to extend all
four for a new project or a new form.

The generic validation engine itself lives in `conn/base`
(`Resources/Private/JavaScript/main.js`, `initFormValidation`) since it has
no project-specific content — everything below only touches `conn/sitepackage`
(or your project's own fork of it).

> **This all assumes the extension key stays `conn_sitepackage`.** Every
> path below is a hardcoded `EXT:conn_sitepackage/...` reference (the Form
> Set, the `email.*RootPaths` defaults in
> `Configuration/Sets/Sitepackage/settings.definitions.yaml`, the
> `persistenceIdentifier` a "Form" content element stores). The
> `conn-project-template` bootstrap (`setup-project`) only renames the
> *root project's* own `composer.json` "name" — it deliberately leaves
> `packages/sitepackage/composer.json`'s own `name`/`extension-key`
> untouched, so these references keep resolving after project setup. If a
> project ever renames that extension key by hand, every `EXT:conn_sitepackage/...`
> reference in this folder needs updating to match.

## How to add a new form

1. Create `Resources/Private/Forms/<Name>.form.yaml`. Easiest: duplicate
   `Contact.form.yaml` and edit it in the TYPO3 backend's Form module — it
   already appears under the "Sitepackage" form set (`Configuration/Form/Sitepackage/config.yaml`
   sets `persistenceManager.allowedExtensionPaths` to this folder).
2. Add a "Form" content element to a page and pick the new form.
3. If the form emails someone, set `finishers[].options.templateName` (see
   "Email templates" below) — every EXT:form form needs a template even if it
   reuses an existing one.

No TypoScript/PHP changes are needed for a new plain form — the Form Set
config is shared by all forms in this folder.

## Validation

Client-side validation ([just-validate](https://github.com/justvalidate/just-validate),
bundled into `conn/base`'s `main.js`) is entirely **data-attribute driven** —
it is not aware of any specific form or field, so adding one needs zero JS
changes. It picks up any field with `[required]` and/or `[data-validate-type]`
inside *any* `<form id="...">` on the page, using ONLY that field's own
attributes for the error text:

```yaml
properties:
  fluidAdditionalAttributes:
    required: required
    data-validate-required-message: 'LLL:EXT:conn_sitepackage/Resources/Private/Language/locallang_forms.xlf:contact.firstName.required'
```

```yaml
properties:
  fluidAdditionalAttributes:
    data-validate-type: email
    data-validate-type-message: 'LLL:EXT:conn_sitepackage/Resources/Private/Language/locallang_forms.xlf:contact.email.invalid'
```

Supported checks today: `required` and `data-validate-type: email`. To add a
new check (e.g. a phone/number format), extend `initFormValidation()` in
`conn/base`'s `main.js` with another `if (el.dataset.validateX === ...)`
branch — that change is generic and benefits every project on `conn/base`,
so it belongs there, not in a per-project form.

Server-side, keep the matching EXT:form `validators` (`NotEmpty`,
`EmailAddress`, ...) — the JS is a UX layer only; TYPO3 always re-validates
on submit regardless of JS.

Styling: errors/success reuse `.is-invalid`/`.invalid-feedback` and
`.is-valid`/`.valid-feedback`, already styled in conn/base's
`Resources/Private/Scss/components/_forms.scss` — nothing to add per form.

## Localization

**Do NOT put a literal `LLL:...` string directly as a `label`/property
value** — EXT:form does not resolve that on its own (it's silently rendered
verbatim). Element/rendering-option properties are only translated through
a specific lookup: a `renderingOptions.translation.translationFiles` list
(set once, at the top of the form — every element inherits it) plus a
strict key-naming convention. The literal value you write in the yaml is
just the fallback used when no matching key exists — write it in the
source language (English here), and let the xlf's `<target>` override it
per language:

```yaml
renderingOptions:
  translation:
    translationFiles:
      - 'EXT:conn_sitepackage/Resources/Private/Language/locallang_forms.xlf'
```

Key conventions (see TYPO3\CMS\Form\Service\TranslationService::translateFormElementValue()/translateFinisherOption() for the authoritative logic):

| What                                                    | Key                                                  |
|----------------------------------------------------------|-------------------------------------------------------|
| A field's `label`                                         | `element.<identifier>.properties.label`                |
| A `fluidAdditionalAttributes` entry (e.g. a validation message) | `element.<identifier>.properties.<attribute-name>` — **not** nested under `.fluidAdditionalAttributes.` |
| A `SingleSelect`/`MultiSelect` option label                | `element.<identifier>.properties.options.<value>`      |
| Any other property (e.g. `prependOptionLabel`)             | `element.<identifier>.properties.<property>`           |
| `renderingOptions.submitButtonLabel` (on the form itself)  | `element.<formIdentifier>.renderingOptions.submitButtonLabel` |
| A Page's `renderingOptions.nextButtonLabel`                | `element.<pageIdentifier>.renderingOptions.nextButtonLabel` |
| A finisher option (e.g. `subject`)                         | `finisher.<finisherIdentifier>.<optionKey>`            |

A finisher's OWN `options.translation.translationFiles` (set per-finisher,
next to its other `options`) is separate from the form-wide one above and
only covers that finisher's options. By default (no `language` key set)
`Contact.form.yaml`'s `EmailToReceiver` finisher sends its admin-facing
notification email in whatever language the visitor was using when they
submitted. Add `translation.language: default` (or a fixed locale like
`de`) instead if staff should always receive it in one consistent language
regardless of visitor language.

To add a new language:

1. Add the keys (source language, English) to
   `Resources/Private/Language/locallang_forms.xlf`, following the table
   above for the `id`.
2. Add the same key `id`s with `<target>` translations to
   `Resources/Private/Language/<iso>.locallang_forms.xlf` (e.g.
   `de.locallang_forms.xlf` — already provided). Copy an existing
   `<trans-unit>`, keep the `id`, translate `<source>`'s text into `<target>`.
3. Make sure the project's site (`config/sites/<site>/config.yaml`) actually
   has that language configured under `languages:` — the override file above
   only supplies the STRINGS; the site config decides which languages exist
   and what value maps to which `languageId`.

`{first_name}`, `{last_name}`, etc. placeholders inside a translated string
(e.g. the email subject) are substituted by EXT:form *after* translation —
keep them in both the source and target `<trans-unit>`.

## Email templates

Every finisher that sends an email needs `options.templateName` set, and a
matching template pair at
`Resources/Private/Templates/Email/<TemplateName>.fluid.html` /
`.fluid.txt` (HTML + plaintext part — both are required for `addHtmlPart: true`).
`ContactForm.fluid.html`/`.txt` are the reference — for a new form, copy them
and adjust only what's actually form-specific (they're almost entirely
generic: `formvh:renderAllFormValues` just lists whatever fields the form
has).

Both extend the shared `<f:layout name="SystemEmail" />` —
`Resources/Private/Layouts/Email/SystemEmail.fluid.html`/`.txt`, this
package's own header/body/footer chrome (adapted from, and replacing,
TYPO3 core's built-in `EXT:core/Resources/Private/Layouts/SystemEmail.fluid.html`,
which otherwise shows the TYPO3 logo/orange and CMS copyright text). It's
picked up automatically, no wiring needed, because `email.templateRootPaths`
/ `layoutRootPaths` / `partialRootPaths` already point here by default (see
`Configuration/Sets/Sitepackage/settings.definitions.yaml`). That's also why
a NEW project built on `conn/sitepackage` gets working (and branded) email
templates for free — unlike a plain per-project sitepackage, no manual
`config/sites/*/settings.yaml` entry is required (compare to how the
`sk-verband.at` project had to add `email.templateRootPaths` etc. by hand;
here it's a Set default instead).

By default the layout shows the site name as a text wordmark on a neutral
dark header. To use a real logo/brand color for one finisher without
touching the layout file, pass them as `variables` on that finisher:

```yaml
options:
  variables:
    logoUrl: 'https://example.com/fileadmin/logo.svg'
    brandColor: '#c31924'
```

For something that should apply site-wide (every email, not just one
finisher), edit `Resources/Private/Layouts/Email/SystemEmail.fluid.html`
directly instead — e.g. reference `{site.settings.branding.logo}` if you
also assign a `site` variable via `options.variables`, since FluidEmail
does not expose it automatically.

## Reference: the fields this pattern was extracted from

`Contact.form.yaml`'s fields (salutation, first name, last name, company,
email, message) and its validation/localization setup mirror what was
originally built ad-hoc for the `sk-verband.at` project — this package is the
generalized, documented version of that, meant to be the shared starting
point for every future project instead of being reinvented per client.
