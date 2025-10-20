<?php

namespace PlasticStudio\SEO\Schema\Type;

use JsonSerializable;

class GeoCoordinatesSchema extends SchemaType implements JsonSerializable
{
    public float $latitude;
    public float $longitude;

    public function __construct($latitude, $longitude)
    {
        $this->latitude = $latitude;
        $this->longitude = $longitude;
    }

    public function jsonSerialize(): array
    {
        return [
            '@type' => 'GeoCoordinates',
            'latitude' => $this->latitude,
            'longitude' => $this->longitude,
        ];
    }
}