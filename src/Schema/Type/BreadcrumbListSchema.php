<?php

namespace Plasticstudio\SEO\Schema\Type;

use JsonSerializable;
use SilverStripe\Model\List\ArrayList;
use PlasticStudio\SEO\Schema\Type\ThingSchema;
use PlasticStudio\SEO\Schema\Type\ListItemSchema;

class BreadcrumbListSchema extends SchemaType implements JsonSerializable
{
    public string $atContext = 'http://schema.org';
    public string $atType = 'BreadcrumbList';
    public array $itemListElement = [];

    public function __construct(?ArrayList $breadcrumbs = null)
    {
        if ($breadcrumbs) {
            $this->makeItemListElement($breadcrumbs);
        }
    }

    private function makeItemListElement(ArrayList $breadcrumbs): void
    {
        foreach ($breadcrumbs as $crumb) {
            $listItem = new ListItemSchema(
                $crumb->getPageLevel(),
                new ThingSchema(
                    $crumb->AbsoluteLink(),
                    $crumb->Title
                )
            );
            $this->itemListElement[] = $listItem;
        }
    }

    public function jsonSerialize(): array
    {
        return [
            '@context' => $this->atContext,
            '@type' => $this->atType,
            'itemListElement' => $this->itemListElement,
        ];
    }
}