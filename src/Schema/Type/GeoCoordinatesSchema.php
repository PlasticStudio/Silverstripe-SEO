<?php

namespace PlasticStudio\SEO\Schema\Type;

class GeoCoordinatesSchema extends SchemaType
{
    /**
     * GeoCoordinatesSchema constructor.
     *
     * @param $latitude Float
     * @param $longitude Float
     */
    public function __construct($latitude, $longitude)
    {
        $this->{'@type'} = 'GeoCoordinates';
        $this->latitude = $latitude;
        $this->longitude = $longitude;
    }
}