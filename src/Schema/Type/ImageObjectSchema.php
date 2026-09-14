<?php

namespace PlasticStudio\SEO\Schema\Type;

use Plasticstudio\SEO\Schema\Type\SchemaType;

class ImageObjectSchema extends SchemaType
{

    public string $atType = 'ImageObject';
    public string $url;
    public ?int $width = null;
    public ?int $height = null;

    public function __construct(string $url, ?int $width = null, ?int $height = null)
    {
        $this->url = $url;
        $this->width = $width;
        $this->height = $height;
    }
}