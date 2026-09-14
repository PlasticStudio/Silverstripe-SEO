<?php

namespace PlasticStudio\SEO\Model\Extension;

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

        // 1. First, check for manual overrides from content managers
        if ($this->owner->ManualSchema) {
            // If it's a raw string, decode it into a clean array first
            $manualData = is_string($this->owner->ManualSchema) 
                ? json_decode($this->owner->ManualSchema, true) 
                : $this->owner->ManualSchema;
                
            if ($manualData) {
                // If the override already has a graph structure, merge it right in
                if (isset($manualData['@graph'])) {
                    $graph = array_merge($graph, $manualData['@graph']);
                } else {
                    $graph[] = $manualData;
                }
            }
        }

        // 2. Automatically loop through your configured schema builders
        $schemas = array_filter((array)$this->owner->config()->get('active_schema'));
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

        // 3. Inject the single merged graph dataset into the header background
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