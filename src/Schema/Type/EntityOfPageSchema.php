<?php

namespace Plasticstudio\SEO\Schema\Type;

class EntityOfPageSchema extends SchemaType
{
    /**
     * EntityOfPageSchema constructor.
     *
     * @param $id
     */
    public function __construct($id)
    {
        $this->{'@type'} = 'WebPage';
        $this->{'@id'} = $id;
    }
}