<?php

namespace PlasticStudio\SEO\Schema\Type;

use PlasticStudio\SEO\Schema\Type\SchemaType;

class WebSiteSchema extends SchemaType implements \JsonSerializable
{
    public string $atContext = 'http://schema.org';
    public string $atType = 'WebSite';
    public string $name;
    public string $url;

    /**
     * WebSiteSchema constructor.
     *
     * @param string $name
     * @param string $url
     */
    public function __construct(string $name, string $url)
    {
        $this->name = $name;
        $this->url = $url;
    }

    public function jsonSerialize(): array
    {
        return [
            '@context' => $this->atContext,
            '@type' => $this->atType,
            'name' => $this->name,
            'url' => $this->url,
        ];
    }
}