<?php

namespace PlasticStudio\SEO\Schema\Type;

use JsonSerializable;

class LocalBusinessSchema extends SchemaType implements JsonSerializable
{
    public string $id;
    public string $name;
    public PostalAddressSchema $address;
    public string $url;
    public ?GeoCoordinatesSchema $geo = null;
    public ?string $telephone = null;
    public ?string $image = null;

    public function __construct($id, $name, PostalAddressSchema $address, $url)
    {
        $this->id = $id;
        $this->name = $name;
        $this->address = $address;
        $this->url = $url;
    }

    public function jsonSerialize(): array
    {
        $data = [
            '@context' => 'http://schema.org',
            '@type' => 'LocalBusiness',
            '@id' => $this->id,
            'name' => $this->name,
            'address' => $this->address, // PostalAddressSchema implements JsonSerializable
            'url' => $this->url,
        ];

        if ($this->geo) {
            $data['geo'] = $this->geo; // GeoCoordinatesSchema implements JsonSerializable
        }

        if ($this->telephone) {
            $data['telephone'] = $this->telephone;
        }

        if ($this->image) {
            $data['image'] = $this->image;
        }

        return $data;
    }
}