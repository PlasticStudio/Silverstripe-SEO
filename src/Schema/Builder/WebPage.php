<?php

use PlasticStudio\SEO\Schema\Builder\SchemaBuilder;
use PlasticStudio\SEO\Schema\Type\WebPageSchema;
use SilverStripe\Control\Director;

class WebPage extends SchemaBuilder
{
    /**
     * Create the web page schema object
     *
     * @param \Page $page
     *
     * @return WebPageSchema
     */
    public function getSchema($page)
    {
        $baseUrl = Director::absoluteBaseURL();
        $url = $page->AbsoluteLink();

        $webPage = new WebPageSchema(
            $page->Title,
            $url,
            $url . '#webpage'
        );

        $webPage->isPartOf = [
            '@id' => $baseUrl . '#website',
        ];

        $webPage->publisher = [
            '@id' => $baseUrl . '#organisation',
        ];

        return $webPage;
    }
}