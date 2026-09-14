<?php

namespace PlasticStudio\SEO\Schema\Type;

use Plasticstudio\SEO\Schema\Type\SchemaType;
class PersonSchema extends SchemaType
{
    public string $atType = 'Person';
    public ?string $atId = null;
    public string $name;

    // Explicitly declare sameAs array variable properties
    public ?array $sameAs = null;
    public ?string $jobTitle = null;
    public ?string $description = null;
    public ?string $image = null;
    public ?array $worksFor = null;

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