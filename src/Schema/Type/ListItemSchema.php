<?php

namespace PlasticStudio\SEO\Schema\Type;

class ListItemSchema extends SchemaType implements \JsonSerializable
{
    public int $position;
    public ThingSchema $item;

    public function __construct(int $position, ThingSchema $item)
    {
        $this->position = $position;
        $this->item = $item;
    }

    public function jsonSerialize(): array
    {
        return [
            '@type' => 'ListItem',
            'position' => $this->position,
            'item' => $this->item, // ThingSchema implements JsonSerializable
        ];
    }
}