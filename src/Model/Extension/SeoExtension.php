<?php

namespace PlasticStudio\SEO\Model\Extension;

use SilverStripe\Forms\FieldList;
use SilverStripe\Forms\TextField;

/**
 * SeoExtension
 *
 * Core extension to convert a DataObject into a page with detailed SEO configuration.
 * The user should add a URLSegment & Title field to their DataObject as well as a Link() method.
 * 
 * @package silverstripe-seo
 **/
class SeoExtension extends SeoPageExtension
{
    /**
     * Page Meta fields to add to DataObjects with this extension. 
     *
     * @since version 4.0.0
     *
     * @config array $db 
     **/
    private static $db = [
        'Title'           => 'Varchar(512)',
        'URLSegment'      => 'Varchar(512)',
        'MetaDescription' => 'Varchar(512)'
    ];

    /**
     * Add title and URL segment fields to a DataObject
     *
     * @since version 1.0.0
     *
     * @param FieldList $fields The fields object
     *
     * @return FieldList
     **/
    public function updateCMSFields(FieldList $fields) 
    {
        $fields = parent::updateCMSFields($fields);

        $fields->addFieldToTab('Root.Main', TextField::create('Title'));
        $fields->addFieldToTab('Root.Main', TextField::create('URLSegment'));

        return $fields;
    }
}