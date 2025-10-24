<?php

namespace PlasticStudio\SEO\Model\Extension;

use SilverStripe\Core\Extension;

/**
 * SeoBlogPostExtension
 *
 * Adds SEO options to the Blog Post Page class
 *
 * @package silverstripe-seo
 **/
class SeoBlogPostExtension extends Extension
{	
    /**
     * Returns the summary description for use in schema description
     *
     * @return string
     */
    public function getSchemaSummary()
	{
		return strip_tags($this->owner->Summary);
	}
    
    /**
     * Returns the PublishDate in ISO 8601 format for use in schema datePublished
     *
     * @return string
     */
	public function getSchemaPublishDate()
	{
		return date('c', strtotime($this->owner->PublishDate));
	}
    
    /**
     * Returns the PublishDate in ISO 8601 format for use in schema dateModified
     *
     * @return string
     */
	public function getSchemaLastEditedDate()
	{
		return date('c', strtotime($this->owner->LastEdited));
	}
}