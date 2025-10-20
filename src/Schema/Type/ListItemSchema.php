<?php

namespace PlasticStudio\SEO\Schema\Type;

class ListItemSchema extends SchemaType
{
    /**
     * ListItemSchema constructor.
     *
     * @param $position
     * @param ThingSchema $item
     */

    public string $atType = 'ListItem';
    public int $position;
    public ThingSchema $item;

    public function __construct($position, ThingSchema $item)
    {
        $this->atType = 'ListItem';
        $this->position = $position;
        $this->item = $item;
    }

    public function jsonSerialize(): array
    {
        return [
            '@type' => $this->atType,
            'position' => $this->position,
            'item' => $this->item,
        ];
    }
}