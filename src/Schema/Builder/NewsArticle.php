<?php

namespace PlasticStudio\SEO\Schema\Builder;

use PlasticStudio\SEO\Schema\Type\EntityOfPageSchema;
use PlasticStudio\SEO\Schema\Type\ImageObjectSchema;
use PlasticStudio\SEO\Schema\Type\NewsArticleSchema;
use PlasticStudio\SEO\Schema\Type\OrganizationSchema;
use PlasticStudio\SEO\Schema\Type\PersonSchema;
use SilverStripe\Control\Director;
use SilverStripe\Core\Config\Config;
use SilverStripe\SiteConfig\SiteConfig;

class NewsArticle extends SchemaBuilder
{
    /**
     * Create the website schema object
     *
     * @param \Page|\BlogPost $page
     *
     * @return NewsArticleSchema
     */
    public function getSchema($page)
    {
        if (($credits = $page->getCredits()) && $credits->exists()) {
            $author = $credits->first()->Name;
        } else {
            $author = SiteConfig::current_site_config()->Title;
        }

        $newsArticle = new NewsArticleSchema(
            $page->Title,
            $page->PublishDate,
            $page->LastEdited,
            $page->dbObject('Content')->FirstParagraph(),
            new EntityOfPageSchema($page->AbsoluteLink()),
            new PersonSchema($author),
            new OrganizationSchema(
                SiteConfig::current_site_config()->Title,
                Director::absoluteBaseURL(),
                new ImageObjectSchema(
                    Director::absoluteBaseURL() . Config::inst()->get('Page', 'default_image')
                )
            )
        );

        /** @var \Image $featuredImage */
        $featuredImage = $page->FeaturedImage();
        if ($featuredImage->exists()) {
            $newsArticle->setImageObject(new ImageObjectSchema(
                $featuredImage->Fill(800, 800)->AbsoluteLink(),
                800,
                800
            ));
        }

        return $newsArticle;
    }
}