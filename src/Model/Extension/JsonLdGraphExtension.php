<?php

namespace PlasticStudio\SEO\Models\Extensions;

use SilverStripe\View\Requirements;
use SilverStripe\Core\Extension;

class JsonLdGraphExtension extends Extension 
{
    /**
     * Generate a unified JSON-LD graph for the current page, combining manual overrides and automatically configured schema builders.
     */
    public function ApplyUnifiedSchema()
    {
        $graph = [];

        // Check for manual overrides from content managers
        if ($this->owner->ManualSchema) {
            $manualData = is_string($this->owner->ManualSchema) ? json_decode($this->owner->ManualSchema, true) : $this->owner->ManualSchema;
            
            if ($manualData) {
                $graph = array_merge($graph, isset($manualData['@graph']) ? $manualData['@graph'] : [$manualData]);
            }
        }

        // Fetch the static active schemas from your site's YAML file config blocks
        $schemas = (array)$this->owner->config()->get('active_schema');
        
        // if cms selected schema, inject it into the array 
        if ($this->owner->SelectedSchemaBuilder) {
            $schemas[] = $this->owner->SelectedSchemaBuilder;
        }

        // Clean out empty values and duplicates safely
        $schemas = array_unique(array_filter($schemas));

        foreach ($schemas as $schemaClass) {
            if (class_exists($schemaClass)) {
                $builder = new $schemaClass();
                
                // Pass the current page context to the builder method
                $schemaObject = $builder->getSchema($this->owner);
                
                if ($schemaObject) {
                    // Convert your schema object properties into a standard array format
                    $graph[] = $schemaObject;
                }
            }
        }

        // Inject the single merged graph dataset into the header background
        if (!empty($graph)) {
            $output = [
                '@context' => 'https://schema.org',
                '@graph' => $graph
            ];

            Requirements::insertHeadTags(sprintf(
                '<script type="application/ld+json" class="unified-schema-graph">%s</script>',
                json_encode($output, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT)
            ), 'UnifiedJsonLdGraph');
        }
    }
}