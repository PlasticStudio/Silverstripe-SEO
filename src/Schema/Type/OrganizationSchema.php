<?php

namespace PlasticStudio\SEO\Schema\Type;

class OrganizationSchema extends SchemaType
{
    public string $atContext = 'http://schema.org';
    public string $atType = 'Organization';
    public string $name;
    public string $url;
    public ImageObjectSchema $logo;
    public ?array $contactPoint = null;
    public ?array $sameAs = null;

    /**
     * OrganizationSchema constructor.
     *
     * @param                   $name
     * @param                   $url
     * @param ImageObjectSchema $logo
     */
    public function __construct($name, $url, ImageObjectSchema $logo)
    {
        $this->atContext = 'http://schema.org';
        $this->atType = 'Organization';
        $this->name = $name;
        $this->url = $url;
        $this->logo = $logo;
    }

    public function jsonSerialize(): array
    {
        $data = [
            '@context' => $this->atContext,
            '@type' => $this->atType,
            'name' => $this->name,
            'url' => $this->url,
            'logo' => $this->logo,
        ];

        if ($this->contactPoint !== null) {
            $data['contactPoint'] = $this->contactPoint;
        }

        if ($this->sameAs !== null) {
            $data['sameAs'] = $this->sameAs;
        }

        return $data;
    }

    /**
     * Add one or more contact points to the organization
     *
     * @param ContactPointSchema|array $contactPoint
     */
    public function addContactPoint($contactPoint)
    {
        if (!isset($this->contactPoint)) {
            $this->contactPoint = array();
        }
        array_push($this->contactPoint, $contactPoint);
    }

    /**
     * Add a same as social media reference
     *
     * @param $sameAs
     */
    public function addSameAs($sameAs)
    {
        if (!isset($this->sameAs)) {
            $this->sameAs = array();
        }
        array_push($this->sameAs, $sameAs);
    }
}
