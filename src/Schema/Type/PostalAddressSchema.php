<?php

namespace PlasticStudio\SEO\Schema\Type;

class PostalAddressSchema extends SchemaType
{
    /**
     * PostalAddressSchema constructor.
     *
     * @param $streetAddress String
     * @param $addressLocality String
     * @param $addressRegion String
     * @param $postalCode String
     * @param $addressCountry String
     */

    public string $atType = 'PostalAddress';
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
            '@type' => $this->atType,
            'streetAddress' => $this->streetAddress,
            'addressLocality' => $this->addressLocality,
            'addressRegion' => $this->addressRegion,
            'postalCode' => $this->postalCode,
            'addressCountry' => $this->addressCountry,
        ];
    }
}