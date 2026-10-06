<?php

$EM_CONF[$_EXTKEY] = [
    'title' => 'Connetation TYPO3 Web Toolkit: Sitepackage',
    'description' => 'Site-specific TYPO3 LTS 14 extension built on connetation/t3wtk-base',
    'category' => 'templates',
    'author' => 'Connetation Web Engineering GmbH',
    'author_email' => 'office@connetation.at',
    'state' => 'stable',
    'version' => '3.0.0',
    'constraints' => [
        'depends' => [
            'typo3'               => '14.0.0-14.99.99',
            'content_animations'  => '2.7.0-2.99.99',
            'conn_t3wtk_base'     => '3.0.0-3.99.99',
            'conn_t3wtk_elements' => '3.0.0-3.99.99',
            'cs_seo'              => '10.2.0-10.99.99',
        ],
    ],
];
