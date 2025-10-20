<?php

namespace PlasticStudio\SEO\Schema\Type;

class ThingSchema extends SchemaType
{
    /**
     * ItemSchema constructor.
     *
     * @param $id
     * @param $name
     */

    public string $atType = 'Thing';
    public string $id;
    public string $name;

    public function __construct($id, $name)
    {
        $this->id = $id;
        $this->name = $name;
    }

    public function jsonSerialize(): array
    {
        return [
            '@type' => $this->atType,
            '@id' => $this->id,
            'name' => $this->name,
        ];
    }
}