<?php

namespace PlasticStudio\SEO\Schema;

use SilverStripe\Core\Extension;
use PlasticStudio\SEO\Schema\SchemaProvider;

class SchemaExtension extends Extension
{
    public function updateSchemaManagerEntities(array &$entities): void
    {
        $page = $this->owner;

        // Page level schemas defined on an individual site
        if ($this->owner instanceof SchemaProvider) {
            foreach ($this->owner->getSchemaEntities() as $schema) {
                $entities[] = $schema;
            }
        }

        // Elemental schemas

        if (!$page->ElementalArea()->exists()) {
            return;
        }

        foreach ($page->ElementalArea()->Elements() as $element) {
            if (!$element instanceof SchemaProvider) {
                continue;
            }

            foreach ($element->getSchemaEntities() as $schema) {
                $entities[] = $schema;
            }
        }

    }
}