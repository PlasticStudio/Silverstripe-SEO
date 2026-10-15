<?php

namespace PlasticStudio\SEO\Schema;

use DorsetDigital\SchemaManager\Model\Schema\Schema;
use PlasticStudio\SEO\Schema\DefinedTermSchema;

class DefinedTermSetSchema extends Schema
{
    public static function create(
        string $id,
        string $name,
        ?string $description = null
    ): static {
        $data = [
            '@type' => 'DefinedTermSet',
            '@id' => $id,
            'name' => $name,
            'hasDefinedTerm' => [],
        ];

        if ($description) {
            $data['description'] = $description;
        }

        return new static($data);
    }

    public function addTerm(DefinedTermSchema $term): static
    {
        $this->data['hasDefinedTerm'][] = $term->toArray();

        return $this;
    }
}