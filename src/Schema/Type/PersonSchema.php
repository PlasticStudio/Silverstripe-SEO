<?php

namespace PlasticStudio\SEO\Schema\Type;

class PersonSchema extends SchemaType
{
    /**
     * PersonSchema constructor.
     *
     * @param $name
     */
    public function __construct($name)
    {
        $this->{'@type'} = 'Person';
        $this->name = $name;
    }
}