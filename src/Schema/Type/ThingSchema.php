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
    public function __construct($id, $name)
    {
        $this->{'@id'} = $id;
        $this->name = $name;
    }
}