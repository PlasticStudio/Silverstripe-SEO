<?php

<?php

namespace PlasticStudio\SEO\Schema\Builder;

use PlasticStudio\SEO\Schema\Builder\SchemaBuilder;
use PlasticStudio\SEO\Schema\Type\DefinedTermSetSchema;
use PlasticStudio\SEO\Schema\Type\DefinedTermSchema;
use SilverStripe\Core\Config\Config;

/**
 * App\Pages\GlossaryPage:
 *   active_schema:
 *     - 'PlasticStudio\SEO\Schema\Builder\Glossary'
 *   glossary_config:
 *     Relation: 'GlossaryItems'
 *     TermField: 'Title'
 *     DefinitionField: 'Content'
 * @package 
 */

class Glossary extends SchemaBuilder
{
    /**
     * Build out the DefinedTermSet schema dynamically using custom site config setups
     *
     * @param \Page $page
     *
     * @return DefinedTermSetSchema|null
     */
    public function getSchema($page)
    {
        $class = get_class($page);
        $pageUrl = $page->AbsoluteLink();

        // 2. Extract settings using clean string assignments with sensible defaults
        $config = Config::inst()->get($class, 'glossary_config') ?: [];
        $relationName    = isset($config['Relation'])        ? $config['Relation']        : 'GlossaryItems';
        $termField       = isset($config['TermField'])       ? $config['TermField']       : 'Word';
        $definitionField = isset($config['DefinitionField']) ? $config['DefinitionField'] : 'Definition';

        // Verify the requested relation method actually exists on this page context record
        if (!$page->hasMethod($relationName)) {
            return null;
        }

        // Setup the main collection asset container
        $termSet = new DefinedTermSetSchema(
            $page->Title,
            $page->dbObject('Content')->FirstParagraph() ?: "Glossary collection",
            $pageUrl . '#glossaryset'
        );

        // Dynamically fetch the configured data collection relationship
        $items = $page->$relationName();
        if ($items && $items->exists()) {
            foreach ($items as $item) {
                
                // Dynamically fetch values using our configured field string rules
                $wordValue = $item->getField($termField);
                $definitionValue = $item->getField($definitionField);

                // Validation check: skip empty records to prevent schema generation failures
                if (empty($wordValue) || empty($definitionValue)) {
                    continue;
                }

                // Generate clean semantic anchor pointers safely (e.g., #term-aeo)
                $termSlug = urlencode(strtolower(str_replace(' ', '-', trim($wordValue))));
                $termId = $pageUrl . '#term-' . $termSlug;

                // 4. Map the vocabulary data node block
                $definedTerm = new DefinedTermSchema(
                    trim($wordValue),
                    trim($definitionValue),
                    $termId
                );

                $termSet->addTerm($definedTerm);
            }
        }

        return $termSet;
    }
}
