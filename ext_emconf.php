<?php

/*
 * This file is part of the Connetation TYPO3 Web Toolkit - T3WTK.
 *
 * Copyright (c) Connetation Web Engineering GmbH
 *
 * This program is free software: you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation, either version 2 of the License, or
 * (at your option) any later version.
 *
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License
 * along with this program.  If not, see <http://www.gnu.org/licenses/>.
 */

$EM_CONF[$_EXTKEY] = [
    'title' => 'Connetation TYPO3 Web Toolkit: Sitepackage',
    'description' => 'Sitepackage template for projects built with the Connetation TYPO3 Web Toolkit (T3WTK). Holds theme overrides, forms, branded email templates and SEO configuration. All project-specific customization lives here, so base and elements stay updatable.',
    'category' => 'templates',
    'author' => 'Connetation Web Engineering GmbH',
    'author_email' => 'office@connetation.at',
    'state' => 'stable',
    'version' => '3.1.3',
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
