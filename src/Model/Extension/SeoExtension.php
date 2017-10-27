<?php

namespace CyberDuck\SEO\Model\Extension;

use SilverStripe\Forms\FieldList;
use SilverStripe\Forms\TextField;

/**
 * @package silverstripe-seo
 * @license MIT License https://github.com/cyber-duck/silverstripe-seo/blob/master/LICENSE
 * @author  <andrewm@cyber-duck.co.uk>
 *
 * SeoExtension
 *
 * Core extension to convert a DataObject into a page with detailed SEO configuration.
 * The user should add a URLSegment & Title field to their DataObject as well as a Link() method.
 * @todo add URLSegment
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
        'MetaDescription' => 'Varchar(512)'
    ];

    public function updateCMSFields(FieldList $fields) 
    {
        $fields->addFieldToTab('Root.Main', TextField::create('Title'));

        return $fields;
    }
}