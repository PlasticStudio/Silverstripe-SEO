<?php

namespace PlasticStudio\SEO\Schema\Builder;

use PlasticStudio\SEO\Schema\Schema;
use PlasticStudio\SEO\Schema\Type\GeoCoordinatesSchema;
use PlasticStudio\SEO\Schema\Type\LocalBusinessSchema;
use PlasticStudio\SEO\Schema\Type\PostalAddressSchema;
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
     * @return LocalBusinessSchema
     */
    public function getSchema($page)
    {
        $siteConfig = SiteConfig::current_site_config();

        $localBusiness = new LocalBusinessSchema(
            Director::absoluteBaseURL(),
            $siteConfig->Title,
            new PostalAddressSchema(
                $siteConfig->getField('Address'),
                $siteConfig->getField('Suburb'),
                $siteConfig->getField('State'),
                $siteConfig->getField('Postcode'),
                $siteConfig->getField('Country')
            ),
            Director::absoluteBaseURL()
        );

        $lat = $siteConfig->getField('Lat');
        $lng = $siteConfig->getField('Lng');
        if ($lat && $lng) {
            $localBusiness->geo = new GeoCoordinatesSchema(
                $lat,
                $lng
            );
        }

        if ($telephone = $siteConfig->getField('Phone')) {
            $localBusiness->telephone = $telephone;
        }


        /**
         * You can set the image in your config.yml
         * Schema:
         *  logo: 'path/to/logo.png'
         */
        $localBusiness->image = Director::absoluteBaseURL() . Config::inst()->get('Page', 'default_image');

        return $localBusiness;
    }
}
