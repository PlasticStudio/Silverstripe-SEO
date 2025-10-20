<?php

namespace Plasticstudio\SEO\Schema\Type;

class EntityOfPageSchema extends SchemaType
{

    private string $id;

    public function __construct($id)
    {
        $this->id = $id;
    }

    public function jsonSerialize(): array
    {
        return [
            '@type' => 'EntityOfPage',
            'id' => $this->id,
        ];
    }
}