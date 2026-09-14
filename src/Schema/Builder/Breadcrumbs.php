<?php

namespace Plasticstudio\SEO\Schema\Builder;

use Plasticstudio\SEO\Schema\Type\BreadcrumbListSchema;
use PlasticStudio\SEO\Schema\Type\ListItemSchema;

/**
 * Class Breadcrumbs
 */
class Breadcrumbs extends SchemaBuilder
{

    /**
     * Create the breadcrumb schema object
     *
     * @param Page $page
     *
     * @return BreadcrumbListSchema
     */
    public function getSchema($page)
    {
        $breadcrumbItems = $page->getBreadcrumbItems();
        
        // Google requires at least 2 items to form a valid trail
        if ($breadcrumbItems && $breadcrumbItems->count() > 1) {

            $listSchema = new BreadcrumbListSchema();
            $listSchema->atId = $page->AbsoluteLink() . '#breadcrumbs';
            
            $position = 1;
            foreach ($breadcrumbItems as $item) {
                // Ensure URLs are output as absolute paths
                $itemUrl = $item->AbsoluteLink();
                
                $listItem = new ListItemSchema(
                    $position,
                    $item->Title,
                    $itemUrl
                );
                
                // Add a unique nested identifier string for the item
                $listItem->item = [
                    '@id' => $itemUrl
                ];
                
                $listSchema->addListItem($listItem);
                $position++;
            }
            
            return $listSchema;
        }
        
        return null;
    }
}
