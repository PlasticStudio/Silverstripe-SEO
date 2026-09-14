<?php

namespace PlasticStudio\SEO\Schema\Builder;

use PlasticStudio\SEO\Schema\Builder\SchemaBuilder;
use PlasticStudio\SEO\Schema\Type\PersonSchema;
use PlasticStudio\SEO\Schema\Type\StaffListSchema;
use SilverStripe\Control\Director;
use SilverStripe\Core\Config\Config;

/**
 * 
 * CONFIG.YML:
 * 
 * TYPE A - individual staff bio page
 * 
 * App\Pages\StaffBioDetailPage:
 *   active_schema:
 *     - 'PlasticStudio\SEO\Schema\Builder\StaffDirectory'
 *   staff_config:
 *     NameField: 'FullName'
 *     JobTitleField: 'Role'
 *     ImageRelation: 'Avatar'
 *     BioField: 'Bio'
 *     SocialField: 'LinkedInProfile'
 * 
 * TYPE B - staff grid page
 * 
 * App\Pages\AboutPage:
 *   active_schema:
 *     - 'PlasticStudio\SEO\Schema\Builder\StaffDirectory'
 *   staff_config:
 *     Relation: 'TeamMembers'
 *     NameField: 'FullName'
 *     JobTitleField: 'Role'
 *     ImageRelation: 'Avatar'
 *     SocialField: 'LinkedInProfile'
 */

class StaffDirectory extends SchemaBuilder
{
    public function getSchema($page)
    {
        $class = get_class($page);
        $config = Config::inst()->get($class, 'staff_config');

         // Extract mappings with your standard fallbacks
        $relationName = isset($config['Relation'])     ? $config['Relation']     : 'StaffMembers';
        $nameField     = isset($config['NameField'])     ? $config['NameField']     : 'Name';
        $jobField      = isset($config['JobTitleField'])? $config['JobTitleField']: 'JobTitle';
        $imageRelation = isset($config['ImageRelation'])? $config['ImageRelation']: 'Photo';
        $bioField      = isset($config['BioField'])      ? $config['BioField']      : 'Bio';
        $socialField   = isset($config['SocialField'])   ? $config['SocialField']   : 'LinkedInURL';

        $pageUrl = $page->AbsoluteLink();
        $orgId = Director::absoluteBaseURL() . '#organisation';

        // Type A: Individual Staff Bio Page / Record Context
        if (!$page->hasMethod($relationName)) {
            $nameVal = $page->getField($nameField);
            if (empty($nameVal)) {
                return null;
            }

            $memberSlug = urlencode(strtolower(str_replace(' ', '-', trim($nameVal))));
            
            // Create a single Person node extending your clean PersonSchema type
            $person = new PersonSchema($nameVal, $pageUrl . '#staff-' . $memberSlug);
            $person->jobTitle = $page->getField($jobField);
            $person->worksFor = ['@id' => $orgId];
            
            // On a bio page, we can extract the deep text summary field for AI bots
            if ($bioVal = $page->getField($bioField)) {
                $person->description = trim(strip_tags($bioVal));
            }

            if ($page->hasMethod($imageRelation) && $photo = $page->$imageRelation()) {
                if ($photo && $photo->exists()) {
                    $person->image = $photo->AbsoluteLink();
                }
            }

            // Check if the record has a single URL text field or a relationship loop method
            if ($socialVal = $page->getField($socialField)) {
                $person->sameAs = [trim($socialVal)];
            } elseif ($page->hasMethod($socialField) && $platforms = $page->$socialField()) {
                // If it's a legacy relationship (like our Organization setup), loop through it
                if ($platforms->exists()) {
                    $person->sameAs = [];
                    foreach ($platforms as $platform) {
                        if ($platform->URL) {
                            $person->sameAs[] = $platform->URL;
                        }
                    }
                }
            }

            return $person;
        }


        // Type B: staff grid page
        $staffList = new StaffListSchema($pageUrl . '#stafflist');
        $position = 1;

        $members = $page->$relationName();
        if ($members && $members->exists()) {
            foreach ($members as $member) {
                $nameVal = $member->getField($nameField);
                $jobVal  = $member->getField($jobField);

                if (empty($nameVal)) {
                    continue;
                }

                $memberSlug = urlencode(strtolower(str_replace(' ', '-', trim($nameVal))));
                
                // If your site architecture uses deep detail links for bio pages, use that URL path
                $targetUrl = $member->hasMethod('AbsoluteLink') ? $member->AbsoluteLink() : $pageUrl;

                $personNode = [
                    '@type' => 'ListItem',
                    'position' => $position,
                    'item' => [
                        '@type' => 'Person',
                        '@id' => $targetUrl . '#staff-' . $memberSlug,
                        'url' => $targetUrl,
                        'name' => trim($nameVal),
                        'worksFor' => ['@id' => $orgId]
                    ]
                ];

                if (!empty($jobVal)) {
                    $personNode['item']['jobTitle'] = trim($jobVal);
                }

                if ($member->hasMethod($imageRelation) && $photo = $member->$imageRelation()) {
                    if ($photo && $photo->exists()) {
                        $personNode['item']['image'] = $photo->AbsoluteLink();
                    }
                }

                // DYNAMIC SOCIAL MAPPING (For individual items in the grid)
                if ($socialVal = $member->getField($socialField)) {
                    $personNode['item']['sameAs'] = [trim($socialVal)];
                }

                $staffList->addStaffMember($personNode);
                $position++;
            }
        }

        return $staffList;
    }
}