<?php

namespace PlasticStudio\SEO\Schema\Builder;

/**
 * SchemaBuilder
 */
abstract class SchemaBuilder
{
    /**
     * Get the schema from the given data
     *
     * @param $page
     */
    abstract public function getSchema($page);
}