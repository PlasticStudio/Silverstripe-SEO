<?php

namespace PlasticStudio\SEO\Schema\Type;

class GeoCoordinatesSchema extends SchemaType
{
    public string $atType = 'GeoCoordinates';
    public float $latitude;
    public float $longitude;

    public function __construct(float $latitude, float $longitude)
    {
        $this->latitude = $latitude;
        $this->longitude = $longitude;
    }

    public function jsonSerialize(): array
    {
        return [
            '@type' => $this->atType,
            'latitude' => $this->latitude,
            'longitude' => $this->longitude,
        ];
    }
}