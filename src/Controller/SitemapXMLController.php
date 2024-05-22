<?php

namespace PlasticStudio\SEO\Controller;

use Page;
use SilverStripe\ORM\ArrayList;
use SilverStripe\Control\Director;
use SilverStripe\Control\Controller;
use SilverStripe\Core\Config\Config;
use SilverStripe\Control\HTTPRequest;
use SilverStripe\ErrorPage\ErrorPage;
use SilverStripe\CMS\Model\RedirectorPage;
use PlasticStudio\SEO\Generators\SitemapGenerator;

/**
 * SitemapXML_Controller
 *
 * sitemap.xml controller
 *
 * @package silverstripe-seo
 **/
class SitemapXMLController extends Controller
{
    /**
     * Set the required content type header
     *
     * @since version 1.0.0
     *
     * @return void
     **/
    public function init()
    {
        parent::init();

        $this->response->addHeader("Content-Type", "application/xml");
    }

    /**
     * Route request to default index method
     *
     * @param SS_HTTPRequest $request
     *
     * @since version 1.0.0
     *
     * @return ViewableData
     **/
    public function index(HTTPRequest $request)
    {
        return $this->renderWith('SitemapXML');
    }

    /**
     * Get the current site URL
     *
     * @since version 2.0.0
     *
     * @return string
     **/
    public function getSitemapHost()
    {
        // remove trailing slash, if exists (ss4/ss5 compatibility)
        return rtrim(Director::absoluteBaseUrl(), '/');
    }

    /**
     * Return an encoded string compliant with XML sitemap standards
     *
     * @since version 1.0.0
     *
     * @param string $value A sitemap value to encode
     *
     * @return string
     **/
    public function EncodedValue($value)
    {
        return trim(urlencode($value));
    }

    /**
     * Route request to default index method
     *
     * @param SS_HTTPRequest $request
     *
     * @since version 1.0.0
     *
     * @return ViewableData
     **/
    public function getSitemapPages()
    {
        $pages = ArrayList::create();
        
        $objects = (array) Config::inst()->get(SitemapGenerator::class, 'objects');

        if (!empty($objects)) {
            foreach ($objects as $name => $values) {
                // exclude error pages, so google doesn't error
                $list = $name::get()->filter('ClassName:not', ErrorPage::class);

                foreach ($list as $page) {
                    // Exclude redirector pages that redirect to external URLs, so google doesn't error
                    if ($page instanceof RedirectorPage && $page->RedirectionType == 'External') {
                        continue;
                    }

                    if (!$page->XMLSitemapHide) {
                        $pages->push($page);
                    }
                }
            }
        }
        return $pages;
    }
}
