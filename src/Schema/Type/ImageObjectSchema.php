<?php

namespace PlasticStudio\SEO\Schema\Type;

class ImageObjectSchema extends SchemaType
{

    private static $atType = 'ImageObject';
    public string $url;
    public ?int $width = null;
    public ?int $height = null;

    public function __construct($url, $width = null, $height = null)
    {
        $this->url = $url;
        $this->width = $width;
        $this->height = $height;
    }

    public function jsonSerialize(): array
    {
        $data = [
            '@type' => self::$atType,
            'url' => $this->url,
        ];

        if ($this->width !== null) {
            $data['width'] = $this->width;
        }

        if ($this->height !== null) {
            $data['height'] = $this->height;
        }

        return $data;
    }
}