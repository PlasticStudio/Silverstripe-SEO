<?php

namespace PlasticStudio\SEO\Schema\Type;

use PlasticStudio\SEO\Schema\Type\WebPageSchema;

class CollectionPageSchema extends WebPageSchema
{
    public string $atType = 'CollectionPage';

    public array $hasPart = [];

    public $mainEntity = null;

    public function __construct(string $name, string $url, ?string $id = null)
    {
        parent::__construct($name, $url, $id);
        $this->hasPart = [];
    }
}