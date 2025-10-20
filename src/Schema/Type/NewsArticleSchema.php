<?php

namespace PlasticStudio\SEO\Schema\Type;

class NewsArticleSchema extends SchemaType
{

    public string $atContext = 'http://schema.org';
    public string $atType = 'NewsArticle';
    public string $headline;
    public string $datePublished;
    public string $dateModified;
    public string $description;
    public ?EntityOfPageSchema $mainEntityOfPage = null;
    public ?ImageObjectSchema $image = null;
    public ?PersonSchema $author = null;
    public ?OrganizationSchema $publisher = null;
    
    public function __construct(
        $headline,
        $datePublished,
        $dateModified,
        $description,
        EntityOfPageSchema $mainEntityOfPage,
        PersonSchema $author,
        OrganizationSchema $publisher,
        ImageObjectSchema $image
    ) {
        $this->atContext = 'http://schema.org';
        $this->atType = 'NewsArticle';
        $this->headline = $headline;
        $this->datePublished = $datePublished;
        $this->dateModified = $dateModified;
        $this->description = $description;
        $this->mainEntityOfPage = $mainEntityOfPage;
        $this->image = $image;
        $this->author = $author;
        $this->publisher = $publisher;
    }

    public function jsonSerialize(): array
    {
        $data = [
            '@context' => $this->atContext,
            '@type' => $this->atType,
            'headline' => $this->headline,
            'datePublished' => $this->datePublished,
            'dateModified' => $this->dateModified,
            'description' => $this->description,
        ];

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
