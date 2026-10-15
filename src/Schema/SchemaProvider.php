<?php

namespace PlasticStudio\SEO\Schema;

/**
 * 
 * @package PlasticStudio\SEO\Schema
 */

interface SchemaProvider
{
    public function getSchemaEntities(): array;
}