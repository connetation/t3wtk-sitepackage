<?php

$EM_CONF[$_EXTKEY] = [
    'title' => 'Conn: Sitepackage',
    'description' => 'Site-specific TYPO3 LTS 14 extension built on conn/base',
    'category' => 'templates',
    'author' => 'Connetation',
    'author_email' => 'i.sapina@connetation.at',
    'state' => 'stable',
    'version' => '1.0.0',
    'constraints' => [
        'depends' => [
            'typo3'    => '14.0.0-14.99.99',
            'conn_base' => '1.0.0-0.0.0',
        ],
    ],
];
