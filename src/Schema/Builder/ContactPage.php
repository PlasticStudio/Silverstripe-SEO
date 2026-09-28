<?php

namespace PlasticStudio\SEO\Schema\Builder;

use SilverStripe\Control\Director;
use PlasticStudio\SEO\Schema\Type\ContactPageSchema;

class ContactPage extends SchemaBuilder
{
    public function getSchema($page)
    {
        $baseUrl = Director::absoluteBaseURL();
        $url = $page->AbsoluteLink();

        $contactPage = new ContactPageSchema(
            $page->Title,
            $url,
            $url . '#webpage'
        );

        $contactPage->isPartOf = [
            '@id' => $baseUrl . '#website',
        ];

        $contactPage->publisher = [
            '@id' => $baseUrl . '#organisation',
        ];

        $contactPage->mainEntity = [
            '@id' => $baseUrl . '#organisation',
        ];

        return $contactPage;
    }
}