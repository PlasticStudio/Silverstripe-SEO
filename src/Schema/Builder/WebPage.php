<?php

namespace PlasticStudio\SEO\Schema\Builder;

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

        $webPage->description = $page->MetaDescription;

        if ($page->getBreadCrumbItems()->Count() > 1) {
            $webPage->breadcrumb = [
                '@id' => $url . '#breadcrumbs',
            ];
        }

        if ($page->DatePublished) {
            $webPage->datePublished = date(
                DATE_ATOM,
                strtotime($page->DatePublished)
            );
        }

        if ($page->LastEdited) {
            $webPage->dateModified = date(
                DATE_ATOM,
                strtotime($page->LastEdited)
            );
        }

        return $webPage;
    }
}