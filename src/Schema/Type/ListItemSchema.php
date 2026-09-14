<?php

namespace PlasticStudio\SEO\Schema\Type;

use PlasticStudio\SEO\Schema\Type\SchemaType;

class ListItemSchema extends SchemaType
{
    public string $atType = 'ListItem';
    public ?string $atId = null;
    public int $position;
    public string $name;
    
    /**
     * Declaring item as mixed/array so it can accept our 
     * nested target pointer identifier block cleanly
     */
    public array $item = [];

    /**
     * ListItemSchema constructor.
     *
     * @param int $position
     * @param string $name
     * @param string|null $id
     */
    public function __construct(int $position, string $name, ?string $id = null)
    {
        $this->position = $position;
        $this->name = $name;
        $this->atId = $id ? $id . '#breadcrumb-item' : null;
    }
}