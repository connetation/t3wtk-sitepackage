> **🚀 Quickstart:** the fastest way to start a new TYPO3 14 project with `connetation/t3wtk-base`, `connetation/t3wtk-elements` and `connetation/t3wtk-sitepackage` is **[t3wtk-quickstart-shell](https://github.com/connetation/t3wtk-quickstart-shell)** — a ready-to-use DDEV project template. Clone it and run `ddev setup-project`.

# T3WTK – Connetation TYPO3 Web Toolkit

From an empty TYPO3 installation to a complete, themeable website in hours instead of weeks.

T3WTK is a modular set of TYPO3 extensions for TYPO3 14 LTS. It replaces the groundwork
that has to be redone on almost every project: sitepackage, page templates, navigation,
footer, content elements, dark mode, forms and SEO setup. Once installed via Composer,
your team can start with configuration, design and content right away.

## Packages

| Package | Purpose |
|---|---|
| `connetation/t3wtk-base` | Design system & foundation: page templates, navigation, footer, design tokens, light/dark theme, site settings, default theme |
| `connetation/t3wtk-elements` | 30+ content elements in eight categories |
| `connetation/t3wtk-sitepackage` | Project layer: theme overrides, forms, email templates, SEO configuration |
| `connetation/t3wtk-demosite` | Creates a complete demo page tree with sample content |
| `connetation/t3wtk-themes` | Theme library (in development) |

Project-specific code lives only in the sitepackage, so base and elements can be updated
via Composer like any other dependency without overwriting your customizations.

## Highlights

- **Design once, theme everywhere:** colors, logo, navbar, footer, buttons and border radius
  as TYPO3 site settings. 250+ options, editable in the Sites module.
- **Full dark mode** with its own color palette and theme toggle, per site, no extra CSS
- **30+ content elements:** hero and card sliders, video hero, before/after comparison,
  mosaic and lightbox galleries, accordion, tabs, flip cards, timeline, pricing tables,
  stats/counter, testimonials, team, map & location and more
- **Five container layouts** (2/3/4 columns, narrow/wide, wide/narrow), nestable
- **Shared design options for every element:** spacing, content width up to full-bleed,
  backgrounds (color, image, parallax), scroll and text animations
- **Built on TYPO3 standards:** Site Sets, Fluid, Composer, core "Text & Media" as a base,
  regular TYPO3 content records with no proprietary structures
- **Performance:** responsive images, lazy loading, CSS/JS loaded only for elements actually
  used on a page
- **Accessibility-minded markup:** Bootstrap 5, semantic HTML, clean heading hierarchy,
  keyboard-operable widgets
- **Included:** contact form (Form Framework) with branded email templates, SEO setup via
  cs_seo (Open Graph, Twitter Cards, structured data), favicon/branding set, three icon
  libraries (Bootstrap Icons, Font Awesome, Ionicons)

## Requirements

- TYPO3 14 LTS (tested on 14.3), Composer mode
- Uses `b13/container` and `clickstorm/cs_seo`

## Quick start

1. `composer require connetation/t3wtk-base connetation/t3wtk-elements`
2. Add the T3WTK site set to your site configuration
3. Configure colors, logo, navigation and footer in the site settings
4. Build pages with the ready-made content elements

Want to explore first? Install `connetation/t3wtk-demosite` or visit https://demosite.connetation.at

## Feedback & contributing

T3WTK is a young open-source project. Bug reports, ideas and pull requests are welcome via
GitHub Issues and Discussions.

---

## This package: `connetation/t3wtk-sitepackage`

Sitepackage template for projects built with the Connetation TYPO3 Web Toolkit (T3WTK). Holds theme overrides, forms, branded email templates and SEO configuration. All project-specific customization lives here, so base and elements stay updatable.

Site-specific project layer built on top of `connetation/t3wtk-base` and
`connetation/t3wtk-elements`. This is where a single project's branding, theme
overrides, SEO wiring, and any project-only Fluid/TypoScript live — it does
not carry reusable design-system logic itself.

### Structure

```
connetation/t3wtk-sitepackage/                   # TYPO3 extension (connetation/t3wtk-sitepackage, ext key: conn_t3wtk_sitepackage)
├── Classes/
│   ├── EventListener/              # PHP event listeners (cs_seo record PIDs, email sender name)
│   └── Upgrades/                   # Upgrade wizards (extension key rename)
├── Configuration/
│   ├── CsSeo/                      # clickstorm/cs-seo config (pages/news/events)
│   ├── Form/Sitepackage/           # EXT:form set config (allowed form storage path)
│   ├── Page/                       # Page TSconfig
│   ├── Sets/Sitepackage/           # TYPO3 v14 Site Set — depends on connetation/t3wtk-base's Set
│   ├── TCA/Overrides/              # pages & tt_content TCA extensions
│   └── Services.yaml
├── Resources/
│   ├── Private/
│   │   ├── Forms/                  # EXT:form definitions (Contact.form.yaml) — see Forms/README.md
│   │   ├── Language/               # locallang_forms.xlf (+ de.)
│   │   ├── Layouts/                # Fluid layout overrides; Email/SystemEmail = branded email layout
│   │   ├── Partials/               # Fluid partial overrides (empty by default — see below)
│   │   ├── Scss/                   # Theme override control panel (_theme.scss) + project styles
│   │   └── Templates/
│   │       ├── Email/              # Email templates (ContactForm.fluid.html/.txt)
│   │       └── Page/               # Fluid page template overrides (empty by default)
│   └── Public/
│       ├── Css/main.css            # Compiled — committed to git
│       └── Icons/                  # Extension icon + project logos
├── composer.json
├── ext_emconf.php
└── package.json                    # Node build tooling (SCSS only)
```

### Two ways to theme a site

`connetation/t3wtk-base` exposes every design token (`--conn-*`) as a CSS custom
property with a built-in default. This package doesn't own the tokens —
it overrides them, two ways, and it matters which one you reach for:

1. **`Resources/Private/Scss/_theme.scss`** — a fully-commented "control
   panel". Uncomment a section, edit the value, rebuild. Requires a deploy.
   Use it for tokens with no site-setting equivalent (`--conn-content-max`,
   `--conn-card-radius`, the `--conn-space-*`/`--conn-font-size-*` scale,
   badge colors), per-environment defaults, or overrides that should hold
   regardless of who edits site settings later.
2. **TYPO3 Site Settings** (`config/sites/<site>/settings.yaml`, editable
   in the backend) — driven by `connetation/t3wtk-base`'s `settings.definitions.yaml`
   and rendered into an inline `<style>` block by
   `EXT:conn_t3wtk_base/.../Partials/Page/ThemeVars.html`. Use this for
   day-to-day editorial brand-color tweaks that shouldn't need a deploy.

**Load order or "who wins":**

```
1. EXT:conn_t3wtk_base/Resources/Public/Css/main.css       (Bootstrap + base tokens)
2. EXT:conn_t3wtk_elements/.../<component>.css             (per-element, self-contained)
3. EXT:conn_t3wtk_sitepackage/Resources/Public/Css/main.css ← _theme.scss compiles here
4. Page/ThemeVars.html inline <style>                ← site settings win over all of the above
```

ThemeVars renders in the page body, after every `<head>`-loaded
stylesheet, so a site setting beats a same-specificity rule anywhere
above it — including an uncommented line in `_theme.scss`. If an override
"isn't taking effect", check the site setting for that token first.

See `_theme.scss`'s own header comment for the full breakdown and the
`--bs-primary` vs `--conn-accent` decoupling notes.

### Fluid overrides (use sparingly)

`Resources/Private/Partials` and `Templates/Page` are empty scaffolding by
default (`Layouts` only ships the email layout under `Layouts/Email`). Any
file placed at the **same relative path** as one in `connetation/t3wtk-base` (or `connetation/t3wtk-elements`) silently shadows it — TYPO3
resolves templates from the site's own Set/extension before falling back
to the dependency. There's no warning when this happens, so a forked
Layout/Partial can quietly go stale if `connetation/t3wtk-base` later fixes or extends
the original. Prefer the Scss/settings-based overrides above; only fork a
Fluid file when the change genuinely can't be expressed through tokens or
TypoScript.

### Installation

```bash
composer require connetation/t3wtk-sitepackage
```

Classic (non-Composer) installations can install the extension `conn_t3wtk_sitepackage` from the [TYPO3 Extension Repository](https://extensions.typo3.org/extension/conn_t3wtk_sitepackage).

For new projects, the sitepackage is meant to be used as a starter template (clone it and make it your own) — see the [Installation documentation](Documentation/Installation/Index.rst).

In your TYPO3 site config (`config/sites/<site>/config.yaml`):

```yaml
dependencies:
  - connetation/t3wtk-sitepackage
```

`connetation/t3wtk-sitepackage`'s Set (`Configuration/Sets/Sitepackage`) declares
the Sets of `connetation/t3wtk-base`, `connetation/t3wtk-elements`,
`clickstorm/cs-seo`, `baschte/content-animations` and `typo3/email` as
dependencies — TYPO3 loads them in order, so they don't need to be listed
in the site config.

#### Upgrading from 1.x / 2.x

3.0 renamed the Composer package (`conn/t3kit-sitepackage` →
`connetation/t3wtk-sitepackage`) and the extension key (`conn_sitepackage`
in 1.x, `conn_t3kit_sitepackage` in 2.x → `conn_t3wtk_sitepackage`).
Update the `require` entry and the site `dependencies`, then run the upgrade wizards (Admin Tools → Upgrade) so
existing Form content elements point at the new `EXT:conn_t3wtk_sitepackage/`
form path.

### Build Assets

Build output (`Resources/Public/Css/main.css`) is committed to git and
deployed as-is — no build step needed on the server.

To rebuild locally:

```bash
cd vendor/connetation/t3wtk-sitepackage  # or your local development copy
npm install
npm run build    # production build (SCSS only, no JS in this package)
npm run dev      # watch mode
```

### Features

- **TYPO3 LTS 14** — Site Set depending on `connetation/t3wtk-base`'s Set
- **Theme override control panel** — `_theme.scss`, see above
- **SEO** — `clickstorm/cs-seo` config for pages, plus news/events when `georgringer/news` / `derhansen/sf_event_mgt` are installed (`Configuration/CsSeo`)
- **Forms** — example contact form, client-side validation, branded email templates (see [`Resources/Private/Forms/README.md`](Resources/Private/Forms/README.md))
- **PHP namespace**: `Connetation\T3wtkSitepackage`

### Extension hierarchy

```
TYPO3 site
└── connetation/t3wtk-sitepackage  (this package — project layer)
    ├── depends on: connetation/t3wtk-base      (reusable foundation — Bootstrap, layouts, design tokens)
    └── depends on: connetation/t3wtk-elements  (component library)
```

## License

GPL-2.0-or-later · Developed by Connetation Web Engineering GmbH, Salzburg, Austria
