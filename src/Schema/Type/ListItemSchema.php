<?php

namespace PlasticStudio\SEO\Schema\Type;

/**
 * Class ListItemSchema
 * @package Broarm\Schema\Type
 * @property string position
 * @property string item
 */
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