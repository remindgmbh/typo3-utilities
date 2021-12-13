<?php

declare(strict_types=1);

namespace Remind\RmndUtil\Sitemap;

use TYPO3\CMS\Seo\XmlSitemap\PagesXmlSitemapDataProvider;

use function stristr;

/**
 * Extenstion of the TYPO3 PagesXmlSitemapDataProvider that provides fully
 * qualified urls instead of relative paths.
 */
class Pages extends PagesXmlSitemapDataProvider
{
    /**
     * Processes the generated items and turn the 'loc' into a fully
     * qualified domain url.
     *
     * @return array Processed items
     */
    public function getItems(): array
    {
        /* Let the parent do the work */
        $items = parent::getItems();

        /* Get current scheme and host */
        $scheme = $this->request->getUri()->getScheme();
        $host = $this->request->getUri()->getHost();

        /* Re-Build the uri */
        $uri = $scheme . '://' . $host;

        /* In case there is no host set return the parent data */
        if ($host === '') {
            return $items;
        }

        /* Processed items storage */
        $processed = [];

        /* Iterate parent items */
        foreach ($items as $item) {
            /* Make sure the item doesn't contain the scheme and host already */
            $containsUri = stristr($item['loc'], $uri) === false ? false : true;

            /* When the uri is absent the item is processed */
            if (!$containsUri) {
                $item['loc'] = $uri . $item['loc'];
            }

            /* Add processed item */
            $processed[] = $item;
        }

        return $processed;
    }
}
