<?php

namespace PlasticStudio\SEO\Controller;

use PageController;
use SilverStripe\View\Requirements;

class HTMLSitemap_Controller extends PageController {
	
	public function init() {
		parent::init();
		Requirements::css('plasticstudio/silverstripe-seo:assets/css/sitemap.css');
	}

}