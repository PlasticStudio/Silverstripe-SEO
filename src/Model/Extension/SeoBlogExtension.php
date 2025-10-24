<?php

namespace PlasticStudio\SEO\Model\Extension;

use SilverStripe\Forms\FieldList;
use SilverStripe\Forms\HeaderField;
use SilverStripe\Forms\CheckboxField;
use SilverStripe\Core\Extension;

/**
 * SeoBlogExtension
 *
 * Adds SEO options to the Blog Page class
 *
 * @package silverstripe-seo
 **/
class SeoBlogExtension extends Extension
{
    /**
     * Our page fields
     *
     * @since version 1.0.0
     *
     * @config array $db 
     **/
    private static array $db = [
        'DefaultPostMetaTitle'       => 'Boolean',
        'DefaultPostMetaDescription' => 'Boolean',
        'UseFeaturedAsSocialImage'   => 'Boolean'
    ];

    /**
     * Add Blog and Blog Post configuration fields to the page
     *
     * @since version 1.0.0
     *
     * @param FieldList $fields The fields object
     *
     * @return FieldList
     **/
    public function updateCMSFields(FieldList $fields) 
    {
        $fields->addFieldToTab('Root.PostSEO', HeaderField::create(false, 'Blog Post SEO', 2));
        $fields->addFieldToTab('Root.PostSEO', CheckboxField::create('DefaultPostMetaTitle', 'Default Meta title')
            ->setDescription('Use page Title when no Meta title set for Blog Post'));
        $fields->addFieldToTab('Root.PostSEO', CheckboxField::create('DefaultPostMetaDescription', 'Default Meta description')
            ->setDescription('Use page summary when no Meta description set for Blog Post'));
        $fields->addFieldToTab('Root.PostSEO', CheckboxField::create('UseFeaturedAsSocialImage', 'Use featured image as social image')
            ->setDescription('Use page featured image as social image'));

        return $fields;
    }
}