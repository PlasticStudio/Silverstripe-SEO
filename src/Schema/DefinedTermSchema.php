<?php

namespace PlasticStudio\SEO\Schema;

use DorsetDigital\SchemaManager\Model\Schema\Schema;

class DefinedTermSchema extends Schema
{
    public static function create(
        string $id,
        string $name,
        string $description
    ): static {
        return new static([
            '@type' => 'DefinedTerm',
            '@id' => $id,
            'name' => $name,
            'description' => $description,
        ]);
    }
}