<?php

namespace PlasticStudio\SEO\Schema\Type;

class DefinedTermSchema extends SchemaType
{
    public string $atType = 'DefinedTerm';
    public string $termCode;
    public string $name;
    public string $description;

    /**
     * DefinedTermSchema constructor.
     *
     * @param string $word
     * @param string $definition
     * @param string|null $id
     */
    public function __construct(string $word, string $definition, ?string $id = null)
    {
        $this->termCode = $word;
        $this->name = $word;
        $this->description = $definition;
        $this->atId = $id;
    }
}