<?php

namespace PlasticStudio\SEO\Schema\Type;

class ThingSchema extends SchemaType implements \JsonSerializable
{
    public string $id;
    public string $name;

    public function __construct(string $id, string $name)
    {
        $this->id = $id;
        $this->name = $name;
    }

    public function jsonSerialize(): array
    {
        return [
            '@id' => $this->id,
            'name' => $this->name,
        ];
    }
}