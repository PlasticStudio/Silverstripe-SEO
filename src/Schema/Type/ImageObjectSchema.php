<?php

namespace PlasticStudio\SEO\Schema\Type;

class ImageObjectSchema extends SchemaType
{
    /**
     * ImageObjectSchema constructor.
     *
     * @param string $url
     * @param int    $width
     * @param int    $height
     */
    public function __construct($url, $width = null, $height = null)
    {
        $this->{'@type'} = 'ImageObject';
        $this->url = $url;
        $this->width = $width;
        $this->height = $height;
    }
}