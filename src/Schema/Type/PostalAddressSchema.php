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
    public function __construct($streetAddress, $addressLocality, $addressRegion, $postalCode, $addressCountry)
    {
        $this->{'@type'} = 'PostalAddress';
        $this->streetAddress = $streetAddress;
        $this->addressLocality = $addressLocality;
        $this->addressRegion = $addressRegion;
        $this->postalCode = $postalCode;
        $this->addressCountry = $addressCountry;
    }
}