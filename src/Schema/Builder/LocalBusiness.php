<?php

namespace PlasticStudio\SEO\Schema\Builder;

use SilverStripe\Control\Director;
use SilverStripe\Core\Config\Config;
use SilverStripe\SiteConfig\SiteConfig;

/**
 * Class LocalBusiness
 */
class LocalBusiness extends SchemaBuilder
{
    /**
     * Create the local business schema object
     *
     * @param Page $page
     *
     */
    public function getSchema($page)
    {
        $siteConfig = SiteConfig::current_site_config();
        $baseUrl = Director::absoluteBaseURL();

        $localBusiness = new \stdClass();
        $localBusiness->{"@type"} = "LocalBusiness";

        // Set local anchor tag
        $localBusiness->{"@id"} = $baseUrl . "#localBusiness"; // Core anchor point
        $localBusiness->name = $siteConfig->Title;
        $localBusiness->url = $baseUrl;

        // Connect back to your master organization entity anchor link!
        $localBusiness->isPartOf = ["@id" => $baseUrl . "#organisation"];

        // Add postal mappings
        $localBusiness->address = [
            "@type" => "PostalAddress",
            "streetAddress" => $siteConfig->getField('Address'),
            "addressLocality" => $siteConfig->getField('Suburb'),
            "addressRegion" => $siteConfig->getField('State'),
            "postalCode" => $siteConfig->getField('Postcode'),
            "addressCountry" => $siteConfig->getField('Country')
        ];

        // Maps and coordinates logic
        $lat = $siteConfig->getField('Lat');
        $lng = $siteConfig->getField('Lng');
        if ($lat && $lng) {
            $localBusiness->geo = [
                "@type" => "GeoCoordinates",
                "latitude" => $lat,
                "longitude" => $lng
            ];
        }
        
        if ($telephone = $siteConfig->getField('Phone')) {
            $localBusiness->telephone = $telephone;
        }

        $defaultImage = Config::inst()->get('Page', 'default_image');
        if ($defaultImage) {
            $localBusiness->image = Director::absoluteURL($defaultImage);
        }

        return $localBusiness;

    }
}
