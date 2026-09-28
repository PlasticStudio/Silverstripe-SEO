<?php

namespace PlasticStudio\SEO\Schema\Builder;

use PlasticStudio\SEO\Schema\Type\CollectionPageSchema;

class CollectionPage extends WebPage
{
    public function getSchema($page)
    {
        /** @var CollectionPageSchema $schema */
        $schema = parent::getSchema($page);

        $schema->atType = 'CollectionPage';

        $schema->hasPart = [];

        foreach ($page->Children() as $child) {
            $schema->hasPart[] = [
                '@id' => $child->AbsoluteLink() . '#webpage',
            ];
        }

        return $schema;
    }
}