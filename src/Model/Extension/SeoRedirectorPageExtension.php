<?php

namespace PlasticStudio\SEO\Model\Extension;

use SilverStripe\Core\Extension;

/**
 * SeoRedirectorPageExtension
 *
 * Sets the XMLSitemapHide field to true by default
 *
 * @package silverstripe-seo
 **/
class SeoRedirectorPageExtension extends Extension
{
    /**
     * Set the default value for the XMLSitemapHide field
     *
     * @since version 1.0.0
     *
     * @config array $defaults
     **/
    private static $defaults = [
        'XMLSitemapHide' => 1
    ];    
}