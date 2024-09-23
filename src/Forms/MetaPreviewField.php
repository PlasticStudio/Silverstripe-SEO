<?php

namespace PlasticStudio\SEO\Forms;

use SilverStripe\Blog\Model\BlogPost;
use SilverStripe\Control\Controller;
use SilverStripe\Control\Director;
use SilverStripe\Core\Config\Config;
use SilverStripe\Forms\LiteralField;
use SilverStripe\ORM\DataObject;
use SilverStripe\View\Requirements;

/**
 * MetaPreviewField
 *
 * Gogole SERP preview field
 *
 * @package silverstripe-seo
 **/
class MetaPreviewField extends LiteralField
{
    /**
     * Object instance used to populate Meta from
     *
     * @since version 2.0.0
     **/
    private $page;

    /**
     * Requires a DataObject to be passed
     *
     * @since version 1.0.0
     *
     * @param DataObject $page
     *
     * @return void
     **/
    public function __construct(DataObject $page)
    {
        $this->page = $page;
        
        Requirements::javascript('plasticstudio/silverstripe-seo:assets/js/serp.js');

        parent::__construct('MetaPreviewField', $this->getMetaContent());
    }

    /**
     * Get the required values to show in the SERP preview
     *
     * @since version 2.0.0
     *
     * @return ViewableData
     **/
    private function getMetaContent()
    {
        return Controller::curr()->customise([
            'SerpMetaTitle'       => $this->getPageMetaTitle(),
            'SerpMetaLink'        => $this->getPageMetaLink(),
            'SerpMetaDescription' => $this->getPageMetaDescription(),
            // 'SerpMetaDescriptionClass' => $this->getPageMetaDescriptionClass(),
        ])->renderWith('MetaPreview');
    }

    /**
     * Get the Meta title to show in the SERP preview
     *
     * @since version 2.0.0
     *
     * @return string
     **/
    private function getPageMetaTitle()
    {
        if($this->page->MetaTitle) {
            return $this->page->MetaTitle;
        }
        if(class_exists(BlogPost::class)) {
            if($this->page instanceof BlogPost) {
                if($this->page->Parent()->DefaultPostMetaTitle == 1) {
                    return $this->page->Title;
                }
            }
        }
        if ($this->page->Title) {
            return $this->page->Title;
        }
        return Config::inst()->get(MetaPreviewField::class, 'meta_title');
    }

    /**
     * Get the page URL to show in the SERP preview
     *
     * @since version 2.0.0
     *
     * @throws Exception
     *
     * @return string
     **/
    private function getPageMetaLink()
    {
        if($this->page->Link()) {            
            return rtrim(Director::absoluteBaseURL(), '/') . $this->page->Link();
        } else {
            return rtrim(Director::absoluteBaseURL(), '/');
        }
    }

    /**
     * Get the Meta description to show in the SERP preview
     *
     * @since version 2.0.0
     *
     * @return string
     **/
    private function getPageMetaDescription()
    {
        if($this->page->MetaDescripion) {
            return $this->page->MetaDescripion;
        }
        if(class_exists(BlogPost::class)) {
            if($this->page instanceof BlogPost) {
                if($this->page->Parent()->DefaultPostMetaDescription == 1) {
                    if ($this->page->Summary) {
                        return strip_tags($this->page->Summary);
                    }
                }
            }
        }
        // no description
        return false;
        // default description in preview.yml
        // return Config::inst()->get(MetaPreviewField::class, 'meta_description');
    }

    /**
     * Get the Meta description class to show in the SERP preview
     *
     * @since version 2.0.0
     *
     * @return string
     **/
    // private function getPageMetaDescriptionClass()
    // {
    //     // if description is the one from config, class is 'notice'
    //     // else class is 'has-content'
    //     $description = $this->getPageMetaDescription();
    //     if($description == Config::inst()->get(MetaPreviewField::class, 'meta_description')) {
    //         return 'notice';
    //     } else {
    //         return 'has-content';
    //     }    
    // }
}
