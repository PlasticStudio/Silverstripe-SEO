<?php

namespace PlasticStudio\SEO\Schema\Type;

use Plasticstudio\SEO\Schema\Type\EntityOfPageSchema;
use PlasticStudio\SEO\Schema\Type\ImageObjectSchema;
use PlasticStudio\SEO\Schema\Type\OrganizationSchema;
use PlasticStudio\SEO\Schema\Type\PersonSchema;

class NewsArticleSchema extends SchemaType
{

    public string $headline;
    public ?string $datePublished = null;
    public ?string $dateModified = null;
    public ?string $description = null;
    public ?EntityOfPageSchema $mainEntityOfPage = null;
    public ?ImageObjectSchema $image = null;
    public ?PersonSchema $author = null;
    public ?OrganizationSchema $publisher = null;
    
    public function __construct(
        string $headline,
        ?string $datePublished = null,
        ?string $dateModified = null,
        ?string $description = null,
        ?EntityOfPageSchema $mainEntityOfPage = null,
        ?PersonSchema $author = null,
        ?OrganizationSchema $publisher = null,
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

    public function jsonSerialize(): array
    {
        $data = [
            '@context' => 'http://schema.org',
            '@type' => 'NewsArticle',
            'headline' => $this->headline,
        ];

        if ($this->datePublished === null) {
            unset($data['datePublished']);
        }

        if ($this->dateModified === null) {
            unset($data['dateModified']);
        }

        if ($this->description === null) {
            unset($data['description']);
        }

        if ($this->mainEntityOfPage !== null) {
            $data['mainEntityOfPage'] = $this->mainEntityOfPage;
        }

        if ($this->image !== null) {
            $data['image'] = $this->image;
        }

        if ($this->author !== null) {
            $data['author'] = $this->author;
        }

        if ($this->publisher !== null) {
            $data['publisher'] = $this->publisher;
        }

        return $data;
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

    public function setPublisher(OrganizationSchema $publisher) {
        $this->publisher = $publisher;
    }
}
