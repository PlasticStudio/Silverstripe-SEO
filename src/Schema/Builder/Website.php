<?php

namespace Plasticstudio\SEO\Schema\Builder;

use Plasticstudio\SEO\Schema\Type\WebSiteSchema;
use SilverStripe\Control\Director;
use SilverStripe\SiteConfig\SiteConfig;

/**
 * Class Website
 */
class Website extends SchemaBuilder
{
    /**
     * Create the website schema object
     *
     * @param \Page $page
     *
     * @return WebSiteSchema
     */
    public function getSchema($page)
    {
        $siteConfig = SiteConfig::current_site_config();
        $baseUrl = Director::absoluteBaseURL();

        // Instantiate the schema type with its unique ID anchor point
        $webSite = new WebSiteSchema(
            $siteConfig->Title,
            $baseUrl,
            $baseUrl . '#website'
        );

        // Stitch this website node directly back to your root organization publisher item
        $webSite->publisher = ['@id' => $baseUrl . '#organisation'];

        return $webSite;
    }
}