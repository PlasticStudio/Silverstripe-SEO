<?php

namespace PlasticStudio\SEO\Schema\Builder;

use PlasticStudio\SEO\Schema\Builder\WebPage;
use PlasticStudio\SEO\Schema\Type\CollectionPageSchema;
use SilverStripe\Control\Director;

class CollectionPage extends WebPage
{
    public function getSchema($page)
    {
        $baseUrl = Director::absoluteBaseURL();
        $url = $page->AbsoluteLink();

        $collectionPage = new CollectionPageSchema(
            $page->Title,
            $url,
            $url . '#webpage'
        );

        $collectionPage->isPartOf = [
            '@id' => $baseUrl . '#website',
        ];

        $collectionPage->publisher = [
            '@id' => $baseUrl . '#organisation',
        ];

        $collectionPage->mainEntity = [
            '@id' => $baseUrl . '#organisation',
        ];
        
        $collectionPage->hasPart = [];

        foreach ($page->Children() as $child) {
            $collectionPage->hasPart[] = [
                '@id' => $child->AbsoluteLink() . '#webpage',
            ];
        }

        return $collectionPage;
    }
}