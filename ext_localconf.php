<?php

declare(strict_types=1);

defined('TYPO3') or die();

// Extend cs_seo to cover non-page records (news, events). No-op if cs_seo
// isn't installed. Projects override evaluation.detailPid per their own
// page tree by forking this file (see Configuration/CsSeo/*.yaml).
$GLOBALS['TYPO3_CONF_VARS']['EXTCONF']['cs_seo']['yamlConfigFile'] = 'EXT:conn_t3wtk_sitepackage/Configuration/CsSeo/config.yaml';

// Content element wizard entries are registered by EXT:conn_t3wtk_elements (optional package, required per project).
