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
    public function __construct($position, ThingSchema $item)
    {
        $this->{'@type'} = 'ListItem';
        $this->position = $position;
        $this->item = $item;
    }
}