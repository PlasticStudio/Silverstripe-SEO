<?php

namespace PlasticStudio\SEO\Schema\Builder;

use PlasticStudio\SEO\Schema\Type\ContactPointSchema;
use PlasticStudio\SEO\Schema\Type\ImageObjectSchema;
use PlasticStudio\SEO\Schema\Type\OrganizationSchema;
use SilverStripe\Control\Director;
use SilverStripe\Core\Config\Config;
use SilverStripe\SiteConfig\SiteConfig;

/**
 * Class Organization
 */
class Organization extends SchemaBuilder
{
    /**
     * Create the organization schema object
     *
     * @param \Page $page
     *
     * @return OrganizationSchema
     */
    public function getSchema($page)
    {
        $siteConfig = SiteConfig::current_site_config();

        $organization = new OrganizationSchema(
            SiteConfig::current_site_config()->Title,
            Director::absoluteBaseURL(),
            new ImageObjectSchema(
                Director::absoluteBaseURL() . Config::inst()->get('Page', 'default_image')
            )
        );

        // TODO: make more generic
        $organization->addContactPoint($point = new ContactPointSchema(
            $siteConfig->getField('Phone'),
            'customer service'
        ));

        // TODO make this more generic
        if (class_exists('SocialMediaPlatform') && $siteConfig->SocialMediaPlatforms() && $siteConfig->SocialMediaPlatforms()->Count()) {
            foreach ($siteConfig->SocialMediaPlatforms() as $platform) {
                $organization->addSameAs($platform->URL);
            }
        }

        return $organization;
    }
}
