<?php

namespace PlasticStudio\SEO\Schema\Type;

class NewsArticleSchema extends SchemaType
{
    /**
     * NewsArticleSchema constructor.
     *
     * @param string             $headline
     * @param string             $datePublished
     * @param string             $dateModified
     * @param string             $description
     * @param EntityOfPageSchema $mainEntityOfPage
     * @param ImageObjectSchema  $image
     * @param PersonSchema       $author
     * @param OrganizationSchema $publisher
     */
    public function __construct(
        $headline,
        $datePublished,
        $dateModified,
        $description,
        EntityOfPageSchema $mainEntityOfPage = null,
        PersonSchema $author = null,
        OrganizationSchema $publisher = null,
        ImageObjectSchema $image = null
    ) {
        $this->{'@context'} = 'http://schema.org';
        $this->{'@type'} = 'NewsArticle';
        $this->headline = $headline;
        $this->datePublished = $datePublished;
        $this->dateModified = $dateModified;
        $this->description = $description;
        $this->mainEntityOfPage = $mainEntityOfPage;
        $this->image = $image;
        $this->author = $author;
        $this->publisher = $publisher;
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
