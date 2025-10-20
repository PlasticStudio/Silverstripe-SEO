<?php

namespace PlasticStudio\SEO\Schema\Type;

use JsonSerializable;

class PostalAddressSchema extends SchemaType implements JsonSerializable
{
    public string $streetAddress;
    public string $addressLocality;
    public string $addressRegion;
    public string $postalCode;
    public string $addressCountry;

    public function __construct($streetAddress, $addressLocality, $addressRegion, $postalCode, $addressCountry)
    {
        $this->streetAddress = $streetAddress;
        $this->addressLocality = $addressLocality;
        $this->addressRegion = $addressRegion;
        $this->postalCode = $postalCode;
        $this->addressCountry = $addressCountry;
    }

    public function jsonSerialize(): array
    {
        return [
            '@type' => 'PostalAddress',
            'streetAddress' => $this->streetAddress,
            'addressLocality' => $this->addressLocality,
            'addressRegion' => $this->addressRegion,
            'postalCode' => $this->postalCode,
            'addressCountry' => $this->addressCountry,
        ];
    }
}