# Schema

Silverstripe's Schema Manager module is included: https://github.com/DorsetDigital/silverstripe-schema-manager. This module creates structure data to produce a linked JSON-LD @graph and inserts it into the page's head automatically.

## Helpers
This PlasticStudio SEO module includes a couple of helpers to define how to use the schema manager module.

SchemaProvider: is an interface for pages, data objects or elements that provide custom schema to SS-Schema-Manager.
SchemaExtension: uses the SS-Schema-Manager updateSchemaManagerEntities hook to add custom schema entities to the JSON-LD output.

## Usage

Determine which website pages and sections require a specific schema

Implement SchemaProvider to class eg:
- class ProductElement extends BaseElement implements SchemaProvider
- class GlossaryPage extends Page implements SchemaProvider

Add getSchemaEntities() to assign the correct values to the schema map
See SS-Schema-Manager for docs: https://github.com/DorsetDigital/silverstripe-schema-manager/tree/main/docs


## Examples

Create a specific organisation type schema, eg BankOrCreditUnion
```
schema-manager.yml
# disable automatic organisation schema - using custom bank schema
DorsetDigital\SchemaManager\Service\SchemaManager:
  automatic_organisation_schema: false
SilverStripe\SiteConfig\SiteConfig:
  extensions:
    - Skeletor\Extension\SiteConfigBankSchemaExtension
```

```
use DorsetDigital\SchemaManager\Model\Schema\Schema;

class BankOrCreditUnionSchema extends Schema
{
  public static function create(
    string $id,
    string $name,
    ?string $url = null
  ): static {
    return new static([
      '@type' => 'BankOrCreditUnion',
      '@id' => $id,
      'name' => $name,
      'url' => $url,
    ]);
  }

  public function setLogo(?string $url): static
  {
    return $this->setOptional('logo', $url === null ? null : [
      '@type' => 'ImageObject',
      'url' => $url,
    ]);
  }

  public function setTelephone(?string $phone): static
  {
    return $this->setOptional('contactPoint', $phone === null ? null : [
      '@type' => 'ContactPoint',
      'telephone' => $phone,
      'contactType' => 'customer service',
    ]);
  }

  public function setSameAs(array $urls): static
  {
    return $this->setOptional('sameAs', array_values(array_filter($urls)));
  }

  private function setOptional(string $key, mixed $value): static
  {
    if ($value === null) {
      unset($this->data[$key]);
    } else {
      $this->data[$key] = $value;
    }

    return $this;
  }
}
```

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

```
use DorsetDigital\SchemaManager\Model\Schema\PersonSchema;
use PlasticStudio\SEO\Schema\SchemaProvider;
use SilverStripe\Assets\Image;
use SilverStripe\ORM\DataObject;
use Skeletor\DataObjects\SocialMediaPlatform;

class Person extends DataObject implements SchemaProvider {
    
  private static string $table_name = 'Person';

  private static array $db = [
    'FirstName' => 'Varchar',
    'LastName' => 'Varchar',
    'Summary' => 'Text',
    'Content' => 'HTMLText',
  ];

  private static array $has_one = [
    'ProfileImage' => Image::class,
  ];

  private static array $has_many = [
    'SocialMediaProfiles' => SocialMediaPlatform::class,
  ];

  public function getName(): string
  {
    return trim("{$this->FirstName} {$this->LastName}"); 
  }
  
  public function getSchemaEntities(): array {
    $person = PersonSchema::create(
      'person-' . $this->ID,
      $this->getName()
    )
      ->setDescription($this->Summary ?: null)
      ->setImage($this->ProfileImage()?->getAbsoluteURL());

    $socialURLs = [];

    foreach ($this->SocialMediaProfiles() as $socialProfile) {
      $url = trim((string) $socialProfile->ProfileURL);

      if (filter_var($url, FILTER_VALIDATE_URL)
        && in_array(parse_url($url, PHP_URL_SCHEME), ['http', 'https'], true)
      ) {
        $socialURLs[] = $url;
      }
    }

    $person->setSameAs(array_values(array_unique($socialURLs)));

    return [$person];
  }
}
```

```
use SilverStripe\Assets\Image;
use SilverStripe\Security\Member;
use PlasticStudio\SEO\Schema\SchemaProvider;
use DorsetDigital\SchemaManager\Control\SchemaIDs;
use DorsetDigital\SchemaManager\Model\Schema\BlogPostingSchema;
use DorsetDigital\SchemaManager\Control\SchemaRegistry;
use DorsetDigital\SchemaManager\Model\Schema\PersonSchema;

class ArticlePage extends Page implements SchemaProvider {

  private static string $table_name = 'ArticlePage';
  private static string $cms_icon_class = 'font-icon-block-numbers';

  private static array $db = [
    'PublishDate' => 'Datetime',
    'ArticleSummary' => 'Text',
  ];

  private static array $has_one = [
    'Image' => Image::class,
  ];

  private static array $many_many = [
    'Authors' => Person::class,
  ];

  public function getSchemaEntities(): array
  {
    $url = $this->AbsoluteLink();

    $description = $this->ArticleSummary;

    $schema = BlogPostingSchema::create(
      'article-' . $this->ID,
      $this->Title,
      $description ?: null
    )
      ->setURL($url)
      ->setMainEntityOfPage($url)
      ->setPublisher(SchemaIDs::organisation());

    $authors = [];

    // Register each author as a PersonSchema entity to the article by its @id
    foreach ($this->Authors() as $author) {
      $name = trim($author->getName());

      if ($name === '') {
        continue;
      }

      $person = PersonSchema::create(
        'author-' . $author->ID,
        $name
      );

      SchemaRegistry::add($person);

      $authors[] = [
        '@id' => $person->getEntityID(),
      ];
    }

    if ($authors) {
      $schema->setAuthors($authors);
    }

    if ($this->PublishDate != '') {
      $schema->setDatePublished(
        date('c', strtotime($this->PublishDate))
      );
    }

    if ($this->LastEdited) {
      $schema->setDateModified(
        date('c', strtotime($this->LastEdited))
      );
    }

    $image = $this->Image();

    if ($image && $image->exists()) {
      $schema->setImage($image->AbsoluteLink());
    }

    return [$schema];
  }
    
}
```

```
FAQ page:
public function getSchemaEntities(): array
{
  $url = $this->AbsoluteLink();

  $schema = FAQPageSchema::create('faq-page-' . $this->ID)
    ->setMainEntityOfPage($url);

  foreach ($this->FAQs() as $faq) {
    $question = trim((string) $faq->Question);
    $answer = trim(strip_tags((string) $faq->Answer));

    if ($question === '' || $answer === '') {
      continue;
    }

    $schema->addQuestion($question, $answer);
  }

  return [$schema];
}
```