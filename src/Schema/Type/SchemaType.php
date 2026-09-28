<?php

namespace PlasticStudio\SEO\Schema\Type;

abstract class SchemaType implements \JsonSerializable
{
    public function jsonSerialize(): array
    {
        $data = get_object_vars($this);

        if (isset($data['atType'])) {
            $data['@type'] = $data['atType'];
            unset($data['atType']);
        }

        if (isset($data['atId'])) {
            $data['@id'] = $data['atId'];
            unset($data['atId']);
        }

        return $data;
    }
}