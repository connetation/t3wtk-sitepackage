<?php

declare(strict_types=1);

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

namespace Connetation\T3wtkSitepackage\Upgrades;

use TYPO3\CMS\Core\Attribute\UpgradeWizard;
use TYPO3\CMS\Core\Database\ConnectionPool;
use TYPO3\CMS\Core\Upgrades\UpgradeWizardInterface;

/**
 * The extension key changed from "conn_sitepackage" to "conn_t3wtk_sitepackage". Unlike a
 * code path, a Form plugin content element ("Form" CType) stores the exact form file path
 * as DATA in tt_content.pi_flexform — e.g.
 * "EXT:conn_sitepackage/Resources/Private/Forms/Contact.form.yaml" — so renaming the
 * extension's own files does nothing for content that already points at the old path. Left
 * alone, every such content element fails to load its form ("could not be loaded... check
 * persistenceManager.allowedExtensionPaths") even though the file exists fine under its new
 * location.
 *
 * This does a plain string replace of the EXT: path prefix inside pi_flexform, which is safe
 * since it only ever appears as a text value inside the FlexForm XML, never as markup.
 */
#[UpgradeWizard('connT3wtkSitepackageRenameExtensionKeyInFlexForm')]
readonly class RenameExtensionKeyInFlexFormUpdate implements UpgradeWizardInterface
{
    private const TABLE = 'tt_content';
    private const OLD_PATH = 'EXT:conn_sitepackage/';
    private const NEW_PATH = 'EXT:conn_t3wtk_sitepackage/';

    public function __construct(
        private ConnectionPool $connectionPool,
    ) {}

    public function getTitle(): string
    {
        return 'EXT:conn_t3wtk_sitepackage: Fix "EXT:conn_sitepackage/" paths stored in tt_content.pi_flexform';
    }

    public function getDescription(): string
    {
        return sprintf(
            'The extension key changed from "conn_sitepackage" to "conn_t3wtk_sitepackage". Form '
            . 'plugin content elements (and anything else with a FlexForm field referencing a file '
            . 'in this extension) store the exact "%s" path as data, not code — this rewrites it to '
            . '"%s" in tt_content.pi_flexform wherever it still appears.',
            self::OLD_PATH,
            self::NEW_PATH
        );
    }

    public function getPrerequisites(): array
    {
        return [];
    }

    public function updateNecessary(): bool
    {
        return $this->countRecordsToUpdate() > 0;
    }

    public function executeUpdate(): bool
    {
        $connection = $this->connectionPool->getConnectionForTable(self::TABLE);

        $connection->executeStatement(sprintf(
            'UPDATE %s SET pi_flexform = REPLACE(pi_flexform, %s, %s) WHERE pi_flexform LIKE %s',
            $connection->getDatabasePlatform()->quoteIdentifier(self::TABLE),
            $connection->quote(self::OLD_PATH),
            $connection->quote(self::NEW_PATH),
            $connection->quote('%' . addcslashes(self::OLD_PATH, '%_') . '%')
        ));

        return true;
    }

    private function countRecordsToUpdate(): int
    {
        $queryBuilder = $this->connectionPool->getQueryBuilderForTable(self::TABLE);
        $queryBuilder->getRestrictions()->removeAll();

        return (int)$queryBuilder
            ->count('uid')
            ->from(self::TABLE)
            ->where(
                $queryBuilder->expr()->like(
                    'pi_flexform',
                    $queryBuilder->createNamedParameter('%' . $queryBuilder->escapeLikeWildcards(self::OLD_PATH) . '%')
                )
            )
            ->executeQuery()
            ->fetchOne();
    }
}
