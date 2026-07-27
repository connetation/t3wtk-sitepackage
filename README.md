# Connetation Sitepackage for TYPO3 LTS 14

Site-specific project layer built on top of `conn/base` (and optionally
`conn/elements`). This is where a single project's branding, theme
overrides, SEO wiring, and any project-only Fluid/TypoScript live — it does
not carry reusable design-system logic itself.

## Structure

```
conn/sitepackage/                   # TYPO3 extension (conn/sitepackage, ext key: conn_sitepackage)
├── Classes/
│   └── EventListener/              # PHP event listeners
├── Configuration/
│   ├── CsSeo/                      # clickstorm/cs-seo config (pages/news/events), optional
│   ├── Page/                       # Page TSconfig
│   ├── Sets/Sitepackage/           # TYPO3 v14 Site Set — depends on conn/base's Set
│   ├── TCA/Overrides/              # pages & tt_content TCA extensions
│   └── Services.yaml
├── Resources/
│   ├── Private/
│   │   ├── Layouts/                # Fluid layout overrides (empty by default — see below)
│   │   ├── Partials/               # Fluid partial overrides (empty by default — see below)
│   │   ├── Scss/                   # Theme override control panel (_theme.scss) + project styles
│   │   └── Templates/Page/         # Fluid page template overrides (empty by default)
│   └── Public/
│       ├── Css/main.css            # Compiled — committed to git
│       └── Icons/                  # Project-specific icons
├── composer.json
├── ext_emconf.php
└── package.json                    # Node build tooling (SCSS only)
```

## Two ways to theme a site

`conn/base` exposes every design token (`--conn-*`) as a CSS custom
property with a built-in default. This package doesn't own the tokens —
it overrides them, two ways, and it matters which one you reach for:

1. **`Resources/Private/Scss/_theme.scss`** — a fully-commented "control
   panel". Uncomment a section, edit the value, rebuild. Requires a deploy.
   Use it for tokens with no site-setting equivalent (`--conn-content-max`,
   `--conn-card-radius`, the `--conn-space-*`/`--conn-font-size-*` scale,
   badge colors), per-environment defaults, or overrides that should hold
   regardless of who edits site settings later.
2. **TYPO3 Site Settings** (`config/sites/<site>/settings.yaml`, editable
   in the backend) — driven by `conn/base`'s `settings.definitions.yaml`
   and rendered into an inline `<style>` block by
   `EXT:conn_base/.../Partials/Page/ThemeVars.html`. Use this for
   day-to-day editorial brand-color tweaks that shouldn't need a deploy.

**Load order or "who wins":**

```
1. EXT:conn_base/Resources/Public/Css/main.css       (Bootstrap + base tokens)
2. EXT:conn_elements/.../<component>.css             (per-element, self-contained)
3. EXT:conn_sitepackage/Resources/Public/Css/main.css ← _theme.scss compiles here
4. Page/ThemeVars.html inline <style>                ← site settings win over all of the above
```

ThemeVars renders in the page body, after every `<head>`-loaded
stylesheet, so a site setting beats a same-specificity rule anywhere
above it — including an uncommented line in `_theme.scss`. If an override
"isn't taking effect", check the site setting for that token first.

See `_theme.scss`'s own header comment for the full breakdown and the
`--bs-primary` vs `--conn-accent` decoupling notes.

## Fluid overrides (use sparingly)

`Resources/Private/Layouts`, `Partials`, and `Templates/Page` are empty
scaffolding by default. Any file placed at the **same relative path** as
one in `conn/base` (or `conn/elements`) silently shadows it — TYPO3
resolves templates from the site's own Set/extension before falling back
to the dependency. There's no warning when this happens, so a forked
Layout/Partial can quietly go stale if `conn/base` later fixes or extends
the original. Prefer the Scss/settings-based overrides above; only fork a
Fluid file when the change genuinely can't be expressed through tokens or
TypoScript.

## Installation

```json
"repositories": [
    { "type": "composer", "url": "https://composer-v2.connetation.at/" }
],
"require": {
    "conn/sitepackage": "^1.0"
}
```

In your TYPO3 site config (`config/sites/<site>/config.yaml`):

```yaml
dependencies:
  - conn/sitepackage
  - conn/elements   # optional component library
```

`conn/sitepackage`'s Set (`Configuration/Sets/Sitepackage`) declares
`conn/base`'s Set as a dependency — TYPO3 loads them in order.

## Build Assets

Build output (`Resources/Public/Css/main.css`) is committed to git and
deployed as-is — no build step needed on the server.

To rebuild locally:

```bash
cd vendor/conn/sitepackage  # or your local development copy
npm install
npm run build    # production build (SCSS only, no JS in this package)
npm run dev      # watch mode
```

## Features

- **TYPO3 LTS 14** — Site Set depending on `conn/base`'s Set
- **Theme override control panel** — `_theme.scss`, see above
- **SEO** — optional `clickstorm/cs-seo` config for pages/news/events (`Configuration/CsSeo`)
- **PHP namespace**: `Connetation\Sitepackage`

## Extension hierarchy

```
TYPO3 site
├── conn/sitepackage  (this package — project layer, extends conn/base)
│   └── depends on: conn/base
├── conn/base         (reusable foundation — Bootstrap, layouts, design tokens)
└── conn/elements     (optional component library — added per project)
```
