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
- ``clickstorm/cs-seo`` configuration for pages, plus news/events when
  ``georgringer/news`` / ``derhansen/sf_event_mgt`` are installed
  (:file:`Configuration/CsSeo`)
- An example contact form with client-side validation and branded email
  templates (:file:`Resources/Private/Forms`)
- PHP namespace: ``Connetation\T3wtkSitepackage``

.. _extension-hierarchy:

Extension hierarchy
====================

::

   TYPO3 site
   └── connetation/t3wtk-sitepackage  (this package, project layer)
       ├── depends on: connetation/t3wtk-base      (reusable foundation, Bootstrap, layouts, design tokens)
       └── depends on: connetation/t3wtk-elements  (component library)

.. _structure:

Structure
=========

::

   connetation/t3wtk-sitepackage/                   # TYPO3 extension (connetation/t3wtk-sitepackage, ext key: conn_t3wtk_sitepackage)
   ├── Classes/
   │   ├── EventListener/              # PHP event listeners (cs_seo record PIDs, email sender name)
   │   └── Upgrades/                   # Upgrade wizards (extension key rename)
   ├── Configuration/
   │   ├── CsSeo/                      # clickstorm/cs-seo config (pages/news/events)
   │   ├── Form/Sitepackage/           # EXT:form set config (allowed form storage path)
   │   ├── Page/                       # Page TSconfig
   │   ├── Sets/Sitepackage/           # TYPO3 v14 Site Set, depends on connetation/t3wtk-base's Set
   │   ├── TCA/Overrides/              # pages & tt_content TCA extensions
   │   └── Services.yaml
   ├── Resources/
   │   ├── Private/
   │   │   ├── Forms/                  # EXT:form definitions (Contact.form.yaml), see Forms/README.md
   │   │   ├── Language/               # locallang_forms.xlf (+ de.)
   │   │   ├── Layouts/                # Fluid layout overrides; Email/SystemEmail = branded email layout
   │   │   ├── Partials/               # Fluid partial overrides (empty by default)
   │   │   ├── Scss/                   # Theme override control panel (_theme.scss) + project styles
   │   │   └── Templates/
   │   │       ├── Email/              # Email templates (ContactForm.fluid.html/.txt)
   │   │       └── Page/               # Fluid page template overrides (empty by default)
   │   └── Public/
   │       ├── Css/main.css            # Compiled, committed to git
   │       └── Icons/                  # Extension icon + project logos
   ├── composer.json
   ├── ext_emconf.php
   └── package.json                    # Node build tooling (SCSS only)
