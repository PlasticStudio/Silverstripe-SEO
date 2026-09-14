<?php

namespace PlasticStudio\SEO\Schema\Builder;

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
        $baseUrl = Director::absoluteBaseURL();

        $organisation = new \stdClass();
        $organisation->{"@type"} = "Organization";
        $organisation->{"@id"} = $baseUrl . "#organisation"; // Core anchor point
        $organisation->name = $siteConfig->Title;
        $organisation->url = $baseUrl;

        // logo handing using absolute assets
        $defaultImage = Config::inst()->get('Page', 'default_image');
        if ($defaultImage) {
            $organisation->logo = [
                "@type" => "ImageObject",
                "url" => Director::absoluteURL($defaultImage)
            ];
        }

        // Add phone configurations
        if ($phone = $siteConfig->getField('Phone')) {
            $organisation->contactPoint = [
                "@type" => "ContactPoint",
                "telephone" => $phone,
                "contactType" => "customer service"
            ];
        }

        // 2. Loop through social properties dynamically without strict class coupling
        $organisation->sameAs = [];
        if ($siteConfig->hasMethod('SocialMediaPlatforms')) {
            foreach ($siteConfig->SocialMediaPlatforms() as $platform) {
                if ($platform->URL) {
                    $organisation->sameAs[] = $platform->URL;
                }
            }
        }

        return $organisation;
    }
}
