<?php

namespace PlasticStudio\SEO\Pages;

use Page;
use SilverStripe\ORM\DB;
use SilverStripe\ORM\ArrayList;
use SilverStripe\CMS\Model\SiteTree;
use SilverStripe\ErrorPage\ErrorPage;
use PlasticStudio\SEO\Pages\HTMLSitemap;

class HTMLSitemap extends Page {

	private static $allowed_children = 'none';
	private static $description = 'Adds an html sitemap generated from the site tree';
	private static $icon_class = 'font-icon-sitemap';
	private static $table_name = 'HTMLSitemap';
	
	private static $db = [];

	private static $has_one = [];
	
	private static $defaults = [
		'ShowInMenus' => 0,
		'Sort' => 10000
	];

	public function getCMSFields()
	{
		$fields = parent::getCMSFields();
		$fields->removeByName('Content');
		return $fields;
	}

    public function Sitemap()
	{
		// exclude error pages and self
		$sitetree = SiteTree::get()->Filter(['ParentID' => 0, 'ClassName:not' => [ErrorPage::class, HTMLSitemap::class]])->sort('Sort ASC');

		$pages = ArrayList::create();
		
		// exclude pages that are hidden from the sitemap
		foreach ($sitetree as $item) {
			$page = Page::get()->byID($item->ID);

			if ($page && !$page->SitemapHide) {
				$pages->push($page);
			}
		}

		return $pages;
	}
	
	/**
	 * Add default record to database
	 *
	 */
	public function requireDefaultRecords()
	{
		parent::requireDefaultRecords();
		
		// if html sitemap page does not exist
		if (static::class == self::class && $this->config()->create_default_pages) {
			if (!SiteTree::get_by_link('html-sitemap')) {
				$HTMLSitemap = new HTMLSitemap();
				$HTMLSitemap->Title = 'HTML Sitemap';
				$HTMLSitemap->Content = '';
				$HTMLSitemap->write();
				$HTMLSitemap->publishRecursive();
				$HTMLSitemap->flushCache();
				DB::alteration_message('Sitemap HTML page created', 'created');
			}
		}

		/*
		// schema migration
		// @todo Move to migration task once infrastructure is implemented
		if($this->class == 'SiteTree') {
			$conn = DB::getConn();
			// only execute command if fields haven't been renamed to _obsolete_<fieldname> already by the task
			if(array_key_exists('Viewers', $conn->fieldList('SiteTree'))) {
				$task = new UpgradeSiteTreePermissionSchemaTask();
				$task->run(new SS_HTTPRequest('GET','/'));
			}
		}*/
	}

}