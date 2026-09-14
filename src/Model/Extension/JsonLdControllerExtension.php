<?php

namespace PlasticStudio\SEO\Models\Extensions;

use SilverStripe\Core\Extension;

class JsonLdControllerExtension extends Extension
{
    public function onAfterInit()
    {
        $controller = $this->owner;
        $page = $controller->data();

        // Ensure we have a valid page or data object record context
        if ($page && $page->hasMethod('ApplyUnifiedSchema')) {
            $page->ApplyUnifiedSchema();
        }
    }
}
