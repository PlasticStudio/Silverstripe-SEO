<?php

namespace Plasticstudio\SEO\Schema\Builder;

use Plasticstudio\SEO\Schema\Type\SearchActionSchema;
use Plasticstudio\SEO\Schema\Type\WebSiteSchema;
use SilverStripe\Control\Director;
use SilverStripe\ORM\Search\FulltextSearchable;
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

        $website = new WebSiteSchema(
            $siteConfig->getField('Title'),
            Director::absoluteBaseURL()
        );

        // add a search box if Fulltext search is enabled
        if (is_array(FulltextSearchable::get_searchable_classes())) {
            $website->potentialAction = new SearchActionSchema(
                Director::absoluteBaseURL() . 'SearchForm?Search={search_term_string}',
                'required name=search_term_string'
            );
        }

        return $website;
    }
}