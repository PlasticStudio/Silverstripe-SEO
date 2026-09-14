<?php

namespace PlasticStudio\SEO\Schema\Builder;

use PlasticStudio\SEO\Schema\Type\EntityOfPageSchema;
use PlasticStudio\SEO\Schema\Type\ImageObjectSchema;
use PlasticStudio\SEO\Schema\Type\NewsArticleSchema;
use PlasticStudio\SEO\Schema\Type\PersonSchema;
use SilverStripe\Control\Director;
use SilverStripe\Core\Config\Config;
use SilverStripe\SiteConfig\SiteConfig;

class NewsArticle extends SchemaBuilder
{
    /**
     * Create the NewsArticle schema object interconnected with the graph
     *
     * @param \Page|\BlogPost $page
     *
     * @return NewsArticleSchema
     */
    public function getSchema($page)
    {
        $baseUrl = Director::absoluteBaseURL();
        $pageUrl = $page->AbsoluteLink();

        // 1. Resolve Author Name
        if (($credits = $page->getCredits()) && $credits->exists()) {
            $author = $credits->first()->Name;
        } else {
            $author = SiteConfig::current_site_config()->Title;
        }

        // 2. Format Dates explicitly to ISO 8601 string standards for search engines
        $datePublished = $page->dbObject('PublishDate')->exists() 
            ? $page->dbObject('PublishDate')->Format('c') 
            : $page->dbObject('Created')->Format('c');

        $dateModified = $page->dbObject('LastEdited')->Format('c');

        $newsArticle = new NewsArticleSchema(
            $page->Title,
            $datePublished,
            $dateModified,
            $page->dbObject('Content')->FirstParagraph(),
            new EntityOfPageSchema($pageUrl),
            // AUTHOR: Creates a Person object with an ID anchor or fallback
            new PersonSchema($author, $baseUrl . '#author-' . urlencode(strtolower($author))),
            
            // PUBLISHER: Pass a simple pointer map targeting the root organisation item
            ['@id' => $baseUrl . '#organisation'],
            // pass null for the fallback image argument initially
            null
        );

        // 4. Assign the distinct ID anchor for this specific article node
        $newsArticle->atId = $pageUrl . '#article';

        // 5. Explicitly link this article to its physical WebPage container node
        $newsArticle->isPartOf = ['@id' => $pageUrl . '#webpage'];

        // 6. Handle Featured Image processing safely
        $featuredImage = $page->FeaturedImage();
        if ($featuredImage && $featuredImage->exists()) {
            $newsArticle->setImageObject(new ImageObjectSchema(
                $featuredImage->Fill(800, 800)->AbsoluteLink(),
                800,
                800
            ));
        } else {
            // Fallback to the configured default system image if no featured image exists
            $defaultImagePath = Config::inst()->get('Page', 'default_image');
            if ($defaultImagePath) {
                $newsArticle->setImageObject(new ImageObjectSchema(
                    Director::absoluteURL($defaultImagePath)
                ));
            }
        }

        return $newsArticle;
    }
}