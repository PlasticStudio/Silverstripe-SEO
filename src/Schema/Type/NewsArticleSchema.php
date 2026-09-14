<?php

namespace PlasticStudio\SEO\Schema\Type;

use PlasticStudio\SEO\Schema\Type\EntityOfPageSchema;
use PlasticStudio\SEO\Schema\Type\ImageObjectSchema;
use PlasticStudio\SEO\Schema\Type\PersonSchema;
class NewsArticleSchema extends SchemaType
{
    // Overriding the type so our base class serializer picks it up automatically
    public string $atType = 'NewsArticle';
    public string $atId = '';
    public string $headline;
    public ?string $datePublished = null;
    public ?string $dateModified = null;
    public string $description;
    public ?EntityOfPageSchema $mainEntityOfPage = null;
    public ?ImageObjectSchema $image = null;
    public ?PersonSchema $author = null;
    public $publisher = null;

    // Explicitly declaring these properties for graph nesting connections
    public ?array $isPartOf = null;
    
    public function __construct(
        $headline,
        ?string $datePublished,
        ?string $dateModified,
        $description,
        ?EntityOfPageSchema $mainEntityOfPage = null,
        ?PersonSchema $author = null,
        $publisher = null,
        ?ImageObjectSchema $image = null
    ) {
        $this->headline = $headline;
        $this->datePublished = $datePublished;
        $this->dateModified = $dateModified;
        $this->description = $description;
        $this->mainEntityOfPage = $mainEntityOfPage;
        $this->author = $author;
        $this->publisher = $publisher;
        $this->image = $image;
    }

    public function setImageObject(ImageObjectSchema $image) {
        $this->image = $image;
    }

    public function setPerson(PersonSchema $author) {
        $this->author = $author;
    }

    public function setEntityOfPage(EntityOfPageSchema $mainEntityOfPage) {
        $this->mainEntityOfPage = $mainEntityOfPage;
    }

    public function setPublisher($publisher) {
        $this->publisher = $publisher;
    }
}
