.. include:: /Includes.rst.txt

.. _installation:

============
Installation
============

``connetation/t3wtk-sitepackage`` is distributed as a **starter template**, not a
versioned package you keep upgrading. Every project is expected to
diverge from it immediately (branding, theme overrides, project-specific
forms and SEO wiring), so the intended workflow is *clone it once into
your new project, then make it your own* — not *require a fixed version
and pull updates forever*.

.. _installation-starter:

Use it as a starter template (recommended for new projects)
================================================================

#. Clone the sitepackage repository into your new project's
   :file:`packages/` directory (the conventional location for
   project-local, path-based TYPO3 extensions, as opposed to
   :file:`vendor/`, which holds Composer-registry packages)::

      git clone <sitepackage-repository-url> packages/<your-site-key>

   Then detach it from the template's git history so your project tracks
   its own history from here on, not the template's::

      rm -rf packages/<your-site-key>/.git

#. Register it as a Composer path repository in your project's root
   :file:`composer.json`, and require it by name::

      {
          "repositories": [
              { "type": "path", "url": "packages/*" }
          ],
          "require": {
              "connetation/t3wtk-sitepackage": "*"
          }
      }

   Composer symlinks (or copies, depending on ``"symlink"`` setting)
   path repositories into :file:`vendor/`, so the extension still loads
   normally — you're just no longer pulling it from a registry.

#. **(Optional, recommended once you start customizing)** Rename it so
   it's unambiguously *this project's* sitepackage rather than a generic
   ``connetation/t3wtk-sitepackage``. This avoids confusion if the same developer ever
   works on two projects side by side. Update:

   - :file:`composer.json` — ``name`` and ``extra.typo3/cms.extension-key``
   - :file:`ext_emconf.php` — the extension key it's registered under
   - PHP namespace ``Connetation\T3wtkSitepackage`` in
     :file:`Classes/EventListener/RecordEvaluationPidEventListener.php`
     and the ``autoload.psr-4`` entry in :file:`composer.json`
   - The extension key ``conn_t3wtk_sitepackage`` referenced in:
     :file:`ext_localconf.php`,
     :file:`Configuration/Sets/Sitepackage/setup.typoscript`,
     :file:`Configuration/Sets/Sitepackage/settings.definitions.yaml`,
     :file:`Configuration/Form/Sitepackage/config.yaml`,
     :file:`Configuration/CsSeo/config.yaml`, and
     :file:`Resources/Private/Forms/Contact.form.yaml`

   If you'd rather keep the shared name for now and rename later, that's
   fine too — nothing breaks by leaving it as ``connetation/t3wtk-sitepackage`` for a
   single project.

#. Activate the Site Set in your TYPO3 site configuration
   (:file:`config/sites/<site>/config.yaml`)::

      dependencies:
        - connetation/t3wtk-sitepackage
        - connetation/t3wtk-elements   # optional, but recommended: content elements library

   ``connetation/t3wtk-base`` is a **hard requirement** of ``connetation/t3wtk-sitepackage`` — it's
   already declared in ``connetation/t3wtk-sitepackage``'s own ``composer.json``
   (Composer installs it automatically) and its Set
   (:file:`Configuration/Sets/Sitepackage`) declares ``connetation/t3wtk-base``'s Set
   as a dependency, so you never need to list ``connetation/t3wtk-base`` yourself; it
   loads automatically whenever ``connetation/t3wtk-sitepackage`` does.

   ``connetation/t3wtk-elements`` is genuinely optional — the sitepackage works
   without it — but recommended for any project that needs ready-made
   content elements (cards, sliders, teasers, etc.) rather than building
   them from scratch. Add it to ``dependencies`` above only if you want
   it.

#. Build the assets and you're set to go::

      cd packages/<your-site-key>
      npm install
      npm run build

.. _installation-registry:

Alternative: install a fixed version from a Composer registry
==================================================================

If you specifically want a project to stay centrally updated from a
shared upstream sitepackage (uncommon — most projects should fork via the
template workflow above), it can also be installed like a normal Composer
package::

   {
       "repositories": [
           { "type": "composer", "url": "<your-composer-repository-url>" }
       ],
       "require": {
           "connetation/t3wtk-sitepackage": "^1.0"
       }
   }

Be aware this couples your project to upstream releases of a package
whose entire purpose is to hold project-specific customizations — the two
tend to conflict as soon as you start editing theme/form/SEO config
locally.

.. _installation-first-steps:

First steps on a new project
==============================

Whichever install path you used, before going live replace the
placeholder values shipped in the reference contact form:

- :file:`Resources/Private/Forms/Contact.form.yaml` — the sender and
  recipient addresses default to ``noreply@example.com`` /
  ``contact@example.com``, and the confirmation page ``pageUid`` defaults
  to ``1``. Both are explicitly marked with a ``TODO (per project)``
  comment in the file — update them for the real project before the form
  goes live.
