<?php

declare(strict_types=1);

namespace Connetation\T3kitSitepackage\EventListener;

use TYPO3\CMS\Core\Attribute\AsEventListener;
use TYPO3\CMS\Core\Site\Entity\Site;
use TYPO3\CMS\Core\Site\Entity\SiteLanguage;
use TYPO3\CMS\Form\Event\BeforeEmailFinisherInitializedEvent;

/**
 * EXT:form email finishers: a senderName set in the form definition wins; when it is empty,
 * fall back to the site's websiteTitle (language → site), then $GLOBALS sitename.
 */
final class EmailFinisherSenderNameEventListener
{
    #[AsEventListener]
    public function __invoke(BeforeEmailFinisherInitializedEvent $event): void
    {
        $options = $event->getOptions();
        if (trim((string)($options['senderName'] ?? '')) !== '') {
            return;
        }

        $request = $event->getFinisherContext()->getRequest();
        $language = $request->getAttribute('language');
        $site = $request->getAttribute('site');
        $senderName = $language instanceof SiteLanguage ? trim($language->getWebsiteTitle()) : '';
        if ($senderName === '' && $site instanceof Site) {
            $senderName = trim((string)($site->getConfiguration()['websiteTitle'] ?? ''));
        }
        if ($senderName === '') {
            $senderName = trim((string)($GLOBALS['TYPO3_CONF_VARS']['SYS']['sitename'] ?? ''));
        }
        if ($senderName !== '') {
            $options['senderName'] = $senderName;
            $event->setOptions($options);
        }
    }
}
