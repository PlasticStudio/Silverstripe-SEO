<?php

namespace PlasticStudio\SEO\Schema\Builder;

use SilverStripe\Control\Director;
use PlasticStudio\SEO\Schema\Type\AboutPageSchema;

class AboutPage extends SchemaBuilder
{
    public function getSchema($page)
    {
        $baseUrl = Director::absoluteBaseURL();
        $url = $page->AbsoluteLink();

        $aboutPage = new AboutPageSchema(
            $page->Title,
            $url,
            $url . '#webpage'
        );

        $aboutPage->isPartOf = [
            '@id' => $baseUrl . '#website',
        ];

        $aboutPage->publisher = [
            '@id' => $baseUrl . '#organisation',
        ];

        $aboutPage->mainEntity = [
            '@id' => $baseUrl . '#organisation',
        ];

        return $aboutPage;
    }
}