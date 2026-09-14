<?php

namespace PlasticStudio\SEO\Schema\Type;

use PlasticStudio\SEO\Schema\Type\SchemaType;

class FAQPageSchema extends SchemaType
{
    public string $atType = 'FAQPage';
    public string $atId;
    public array $mainEntity = [];

    public function __construct(?string $id = null)
    {
        $this->atId = $id;
    }

    public function addQuestion(array $questionNode)
    {
        $this->mainEntity[] = $questionNode;
    }
}
