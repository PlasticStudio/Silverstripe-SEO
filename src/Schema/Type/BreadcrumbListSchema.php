<?php

namespace Plasticstudio\SEO\Schema\Type;

use PlasticStudio\SEO\Schema\Type\SchemaType;
use PlasticStudio\SEO\Schema\Type\ListItemSchema;

class BreadcrumbListSchema extends SchemaType
{
    public string $atType = 'BreadcrumbList';
    public ?string $atId = null;
    
    /**
     * Explicitly declare the list element array property 
     * so your base class serializer can catch it without warnings
     */
    public array $itemListElement = [];

    /**
     * Add a structured list item to the collection array
     *
     * @param ListItemSchema $listItem
     */
    public function addListItem(ListItemSchema $listItem)
    {
        $this->itemListElement[] = $listItem;
    }
}