# Schema

Silverstripe's Schema Manager module is included: https://github.com/DorsetDigital/silverstripe-schema-manager

This module creates structure data to produce a linked JSON-LD @graph and inserts it into the page's head automatically.

This PlasticStudio SEO module includes a couple of helpers to define how to use the schema manager module.

## src/Schema/SchemaProvider

Is an interface for data objects or elements that provide custom schema to SS-Schema-Manager.

## src/Schema/SchemaExtension

Uses the SS-Schema-Manager updateSchemaManagerEntities hook to add custom schema entities to the JSON-LD output.

For elemental, implement the SchemaProvider and include a getSchemaEntities() function which registers and maps the element to a provided schema from SS-Schema-Manager. For example:

```
class ProductElement extends BaseElement implements SchemaProvider
{

  public function getSchemaEntities(): array
  {
    $page = $this->parent()->getOwnerPage();

    if (!$page) {
      return [];
    }

    $schema = ProductSchema::create(
      'product-' . $this->ID,
      $this->Title,
      $this->MetaDescription ?: null
    )
      ->setURL($page->AbsoluteLink())
      ->setMainEntityOfPage($page->AbsoluteLink())
      ->setImage($this->Image()->exists() ? $this->Image()->AbsoluteLink() : null)
      ->setSKU($this->SKU ?: null)
      ->setBrand($this->Brand ?: null)
      ->setOffer($this->Price, 'NZD', $this->InStock ?: null);

    return [$schema];
  }
}
```

