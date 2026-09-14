<?php

namespace PlasticStudio\SEO\Schema\Type;

use Plasticstudio\SEO\Schema\Type\SchemaType;
class PersonSchema extends SchemaType
{
    public string $atType = 'Person';
    public ?string $atId = null;
    public string $name;

    /**
     * PersonSchema constructor.
     *
     * @param $name
     */
    public function __construct(string $name, ?string $id = null)
    {
        $this->name = $name;
        $this->atId = $id;  // Sets up the '#author-name' anchor pointer
    }
}