<?php

namespace PlasticStudio\SEO\Schema\Builder;

use PlasticStudio\SEO\Schema\Builder\SchemaBuilder;
use PlasticStudio\SEO\Schema\Type\FAQPageSchema;
use SilverStripe\Core\Config\Config;

class FAQ extends SchemaBuilder
{
    public function getSchema($page)
    {
        $class = get_class($page);
        $config = Config::inst()->get($class, 'faq_config');

        $relationName  = isset($config['Relation'])      ? $config['Relation']      : 'FAQItems';
        $questionField = isset($config['QuestionField']) ? $config['QuestionField'] : 'Question';
        $answerField   = isset($config['AnswerField'])   ? $config['AnswerField']   : 'Answer';

        if (!$page->hasMethod($relationName)) {
            return null;
        }

        $faqPage = new FAQPageSchema($page->AbsoluteLink() . '#faqpage');

        $items = $page->$relationName();
        if ($items && $items->exists()) {
            foreach ($items as $item) {
                $qVal = $item->getField($questionField);
                $aVal = $item->getField($answerField);

                if (empty($qVal) || empty($aVal)) {
                    continue;
                }

                // AI engines require questions and answers to be tightly grouped nested entities
                $faqPage->addQuestion([
                    '@type' => 'Question',
                    'name' => trim($qVal),
                    'acceptedAnswer' => [
                        '@type' => 'Answer',
                        'text' => trim($aVal)
                    ]
                ]);
            }
        }

        return $faqPage;
    }
}
