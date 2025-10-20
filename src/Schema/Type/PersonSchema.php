<?php

namespace PlasticStudio\SEO\Schema\Type;

class PersonSchema extends SchemaType
{
    public string $atContext = 'http://schema.org';
    public string $atType = 'Person';
    public string $name;

    /**
     * PersonSchema constructor.
     *
     * @param $name
     */
    public function __construct($name)
    {
        $this->atType = 'Person';
        $this->name = $name;
    }

    public function jsonSerialize(): array
    {
        return [
            '@context' => $this->atContext,
            '@type' => $this->atType,
            'name' => $this->name,
        ];
    }
}