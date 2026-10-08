.. include:: /Includes.rst.txt

.. _start:

=======================
Connetation Sitepackage
=======================

:Extension key:
   conn_t3wtk_sitepackage

:Package name:
   connetation/t3wtk-sitepackage

:Version:
   |release|

:Language:
   en

:License:
   This document is published under the
   `GPL-2.0-or-later <https://www.gnu.org/licenses/old-licenses/gpl-2.0.html>`__
   license.

:Rendered:
   |today|

----

.. note::

   Unlike ``connetation/t3wtk-base`` and ``connetation/t3wtk-elements``,
   ``connetation/t3wtk-sitepackage`` is not a versioned package meant to be installed
   from the Composer registry and kept up to date — it's a **starter template**.
   The intended workflow is to clone it into a new project's
   :file:`packages/` directory, wire it into the Site configuration, and
   then customize it freely from there (branding, theme overrides,
   project-specific forms, SEO wiring). See :ref:`installation` for the
   exact steps.

Connetation Sitepackage is the site-specific project layer built on top
of ``connetation/t3wtk-base`` and ``connetation/t3wtk-elements``. This is where a single
project's branding, theme overrides, SEO wiring, and any project-only
Fluid/TypoScript live — it does not carry reusable design-system logic
itself.

----

**Table of Contents:**

.. toctree::
   :maxdepth: 2

   Introduction/Index
   Installation/Index
   Theming/Index
