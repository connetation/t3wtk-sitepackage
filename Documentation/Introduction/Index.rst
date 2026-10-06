.. include:: /Includes.rst.txt

.. _introduction:

============
Introduction
============

.. _what-it-does:

What does it do?
=================

``connetation/t3wtk-sitepackage`` provides:

- A TYPO3 v14 Site Set depending on ``connetation/t3wtk-base``'s Set
- A theme override "control panel" (:file:`_theme.scss`) — see
  :ref:`theming`
- Optional `clickstorm/cs-seo` configuration for pages/news/events
  (:file:`Configuration/CsSeo`)
- PHP namespace: ``Connetation\T3wtkSitepackage``

.. _extension-hierarchy:

Extension hierarchy
====================

::

   TYPO3 site
   ├── connetation/t3wtk-sitepackage  (this package, project layer, extends connetation/t3wtk-base)
   │   └── depends on: connetation/t3wtk-base
   ├── connetation/t3wtk-base         (reusable foundation, Bootstrap, layouts, design tokens)
   └── connetation/t3wtk-elements     (optional component library, added per project)

.. _structure:

Structure
=========

::

   connetation/t3wtk-sitepackage/                   # TYPO3 extension (connetation/t3wtk-sitepackage, ext key: conn_t3wtk_sitepackage)
   ├── Classes/
   │   └── EventListener/              # PHP event listeners
   ├── Configuration/
   │   ├── CsSeo/                      # clickstorm/cs-seo config (pages/news/events), optional
   │   ├── Page/                       # Page TSconfig
   │   ├── Sets/Sitepackage/           # TYPO3 v14 Site Set, depends on connetation/t3wtk-base's Set
   │   ├── TCA/Overrides/              # pages & tt_content TCA extensions
   │   └── Services.yaml
   ├── Resources/
   │   ├── Private/
   │   │   ├── Layouts/                # Fluid layout overrides (empty by default)
   │   │   ├── Partials/               # Fluid partial overrides (empty by default)
   │   │   ├── Scss/                   # Theme override control panel (_theme.scss) + project styles
   │   │   └── Templates/Page/         # Fluid page template overrides (empty by default)
   │   └── Public/
   │       ├── Css/main.css            # Compiled, committed to git
   │       └── Icons/                  # Project-specific icons
   ├── composer.json
   ├── ext_emconf.php
   └── package.json                    # Node build tooling (SCSS only)
