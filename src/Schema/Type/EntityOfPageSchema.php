<?php

namespace Plasticstudio\SEO\Schema\Type;

use Plasticstudio\SEO\Schema\Type\SchemaType;

class EntityOfPageSchema extends SchemaType
{
    public string $atId;

    public function __construct(string $id)
    {
        $this->atId = $id;
    }
}