.. include:: /Includes.rst.txt

.. _theming:

=======
Theming
=======

``connetation/t3wtk-base`` exposes every design token (``--conn-*``) as a CSS custom
property with a built-in default. ``connetation/t3wtk-sitepackage`` doesn't own the
tokens — it overrides them, two ways, and it matters which one you reach
for.

.. _theming-two-ways:

Two ways to theme a site
==========================

1. :file:`Resources/Private/Scss/_theme.scss` — a fully-commented
   "control panel". Uncomment a section, edit the value, rebuild.
   Requires a deploy. Use it for tokens with no site-setting equivalent
   (``--conn-content-max``, ``--conn-card-radius``, the
   ``--conn-space-*``/``--conn-font-size-*`` scale, badge colors),
   per-environment defaults, or overrides that should hold regardless of
   who edits site settings later.
2. **TYPO3 Site Settings** (:file:`config/sites/<site>/settings.yaml`,
   editable in the backend) — driven by ``connetation/t3wtk-base``'s
   :file:`settings.definitions.yaml` and rendered into an inline
   ``<style>`` block by
   :file:`EXT:conn_t3wtk_base/.../Partials/Page/ThemeVars.html`. Use this for
   day-to-day editorial brand-color tweaks that shouldn't need a deploy.

.. _theming-load-order:

Load order — who wins
=======================

::

   1. EXT:conn_t3wtk_base/Resources/Public/Css/main.css       (Bootstrap + base tokens)
   2. EXT:conn_t3wtk_elements/.../<component>.css             (per-element, self-contained)
   3. EXT:conn_t3wtk_sitepackage/Resources/Public/Css/main.css  ← _theme.scss compiles here
   4. Page/ThemeVars.html inline <style>                 ← site settings win over all of the above

``ThemeVars`` renders in the page body, after every ``<head>``-loaded
stylesheet, so a site setting beats a same-specificity rule anywhere
above it — including an uncommented line in :file:`_theme.scss`.

.. tip::

   If an override "isn't taking effect", check the site setting for that
   token first — it silently wins over an uncommented line in
   :file:`_theme.scss` due to the load order above.

See :file:`_theme.scss`'s own header comment for the full breakdown and
the ``--bs-primary`` vs ``--conn-accent`` decoupling notes.

.. _theming-fluid-overrides:

Fluid overrides (use sparingly)
==================================

:file:`Resources/Private/Partials` and :file:`Templates/Page` are empty
scaffolding by default (:file:`Layouts` only ships the email layout under
:file:`Layouts/Email`).

.. warning::

   Any file placed at the **same relative path** as one in ``connetation/t3wtk-base``
   (or ``connetation/t3wtk-elements``) silently shadows it — TYPO3 resolves templates
   from the site's own Set/extension before falling back to the
   dependency. There is no warning when this happens, so a forked
   Layout/Partial can quietly go stale if ``connetation/t3wtk-base`` later fixes or
   extends the original.

Prefer the SCSS/settings-based overrides described above; only fork a
Fluid file when the change genuinely can't be expressed through tokens or
TypoScript.
