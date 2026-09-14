<?php

namespace PlasticStudio\SEO\Schema\Type;

class StaffListSchema extends SchemaType
{
    public string $atType = 'ItemList';
    public string $atId;
    public array $itemListElement = [];

    public function __construct(?string $id = null)
    {
        $this->atId = $id;
    }

    public function addStaffMember(array $personNode)
    {
        $this->itemListElement[] = $personNode;
    }
}