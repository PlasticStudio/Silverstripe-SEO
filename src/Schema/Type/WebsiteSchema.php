<?php

namespace PlasticStudio\SEO\Schema\Type;

use PlasticStudio\SEO\Schema\Type\SchemaType;

class WebSiteSchema extends SchemaType
{
    /**
     * WebSiteSchema constructor.
     *
     * @param string $name
     * @param string $url
     */
    public function __construct($name, $url)
    {
        $this->{'@context'} = 'http://schema.org';
        $this->{'@type'} = 'WebSite';
        $this->name = $name;
        $this->url = $url;
    }
}