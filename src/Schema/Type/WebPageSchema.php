<?php

namespace PlasticStudio\SEO\Schema\Type;

class WebPageSchema extends SchemaType
{
    public string $atType = 'WebPage';
    public ?string $atId = null;

    public string $name;
    public string $url;

    public $isPartOf = null;
    public $publisher = null;
    public $breadcrumb = null;

    public ?string $description = null;
    public ?string $datePublished = null;
    public ?string $dateModified = null;

    /**
     * WebPageSchema constructor.
     *
     * @param string $name
     * @param string $url
     */
    public function __construct(string $name, string $url, ?string $id = null)
    {
        $this->name = $name;
        $this->url = $url;
        $this->atId = $id;
    }
}