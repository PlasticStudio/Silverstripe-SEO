<?php

namespace PlasticStudio\SEO\Schema\Type;

use PlasticStudio\SEO\Schema\Type\SchemaType;

class WebSiteSchema extends SchemaType
{
    public string $atType = 'WebSite';
    public string $name;
    public string $url;
    public $publisher = null; //leave it untyped so it can accept both full schema objects or raw reference pointer arrays

    /**
     * WebSiteSchema constructor.
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