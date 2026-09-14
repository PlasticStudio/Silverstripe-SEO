<?php

namespace PlasticStudio\SEO\Schema\Type;

use PlasticStudio\SEO\Schema\Type\DefinedTermSchema;
use PlasticStudio\SEO\Schema\Type\SchemaType;

class DefinedTermSetSchema extends SchemaType
{
    public string $atType = 'DefinedTermSet';
    public string $atId;
    public string $name;
    public string $description;
    public array $hasDefinedTerm = [];

    /**
     * DefinedTermSetSchema constructor.
     *
     * @param string $name
     * @param string $description
     * @param string|null $id
     */
    public function __construct(string $name, string $description, ?string $id = null)
    {
        $this->name = $name;
        $this->description = $description;
        $this->atId = $id;
    }

    /**
     * Add a single vocabulary term definition to the collection group
     *
     * @param DefinedTermSchema $term
     */
    public function addTerm(DefinedTermSchema $term)
    {
        $this->hasDefinedTerm[] = $term;
    }
}