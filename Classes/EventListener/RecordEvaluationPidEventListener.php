<?php

declare(strict_types=1);

namespace Connetation\Sitepackage\EventListener;

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
