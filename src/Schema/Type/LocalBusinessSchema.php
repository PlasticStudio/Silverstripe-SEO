<?php

namespace PlasticStudio\SEO\Schema\Type;

class LocalBusinessSchema extends SchemaType
{

    public string $atContext = 'http://schema.org';
    public string $atType = 'LocalBusiness';
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
            '@context' => $this->atContext,
            '@type' => $this->atType,
            '@id' => $this->id,
            'name' => $this->name,
            'address' => $this->address,
            'url' => $this->url,
        ];

        if ($this->geo) {
            $data['geo'] = $this->geo;
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