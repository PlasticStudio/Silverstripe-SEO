# Schema

Silverstripe's Schema Manager module is included: https://github.com/DorsetDigital/silverstripe-schema-manager

This module creates structure data to produce a linked JSON-LD @graph and inserts it into the page's head automatically.

This PlasticStudio SEO module includes a couple of helpers to define how to use the schema manager module.

## src/Schema/SchemaProvider

Is an interface for pages, data objects or elements that provide custom schema to SS-Schema-Manager.

## src/Schema/SchemaExtension

Uses the SS-Schema-Manager updateSchemaManagerEntities hook to add custom schema entities to the JSON-LD output.

## Examples

```
use PlasticStudio\SEO\Schema\SchemaProvider;
use PlasticStudio\SEO\Schema\DefinedTermSchema;
use PlasticStudio\SEO\Schema\DefinedTermSetSchema;

class GlossaryPage extends Page implements SchemaProvider {

public function getSchemaEntities(): array
  {
    $pageUrl = rtrim($this->AbsoluteLink(), '/') . '/';

    $description = $this->GlossaryDescription
      ?: ($this->dbObject('Content')->FirstParagraph()
        ?: 'Glossary collection');

    $termSet = DefinedTermSetSchema::create(
      $pageUrl . '#glossaryset',
      $this->Title,
      $description
    );

    foreach ($this->GlossaryItems()->sort('Term ASC') as $item) {
      $term = trim((string) $item->Term);
      $definition = trim(
        html_entity_decode(
          strip_tags((string) $item->Definition),
          ENT_QUOTES | ENT_HTML5,
          'UTF-8'
        )
      );

      if ($term === '' || $definition === '') {
        continue;
      }

      $termSchema = DefinedTermSchema::create(
        $pageUrl . '#term-' . $item->ID,
        $term,
        $definition
      );

      $termSet->addTerm($termSchema);
    }

    return [$termSet];
  }
}
```

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

