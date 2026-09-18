<?php

$EM_CONF[$_EXTKEY] = [
    'title' => 'Conn: Sitepackage',
    'description' => 'Site-specific TYPO3 LTS 14 extension built on conn/t3kit-base',
    'category' => 'templates',
    'author' => 'Connetation',
    'author_email' => 'i.sapina@connetation.at',
    'state' => 'stable',
    'version' => '1.5.1',
    'constraints' => [
        'depends' => [
            'typo3'    => '14.0.0-14.99.99',
            'conn_t3kit_base' => '1.0.0-0.0.0',
            'conn_t3kit_elements' => '1.0.0-0.0.0',
            'cs_seo' => '10.2.0-0.0.0',
        ],
    ],
];
