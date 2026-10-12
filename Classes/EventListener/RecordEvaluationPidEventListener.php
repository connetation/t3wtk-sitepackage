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

namespace Connetation\T3wtkSitepackage\EventListener;

use Clickstorm\CsSeo\Event\ModifyEvaluationPidEvent;
use Clickstorm\CsSeo\Utility\ConfigurationUtility;
use TYPO3\CMS\Core\Attribute\AsEventListener;

final class RecordEvaluationPidEventListener
{
    #[AsEventListener]
    public function __invoke(ModifyEvaluationPidEvent $event): void
    {
        // mapping is configured per table in Configuration/CsSeo/*.yaml, key detailPidByStoragePid
        $detailPidByStoragePid = ConfigurationUtility::getTableSettings($event->getTableName())['detailPidByStoragePid'] ?? [];
        $storagePid = (int)($event->getPageInfo()['pid'] ?? 0);
        if (isset($detailPidByStoragePid[$storagePid])) {
            $event->setPid((int)$detailPidByStoragePid[$storagePid]);
        }
    }
}
