# Schema

This module allows you to add schema.org JSON to your webpage and auto generates schema for Blog Posts, Local Business, Organisation, Breadcrumbs

## Manual schemas

Every page apart from Blog Posts have a Settings -> Schema tab with a textarea field where you can add custom schema to that page.

## Displaying dynamic schema on Your Page

### Installation / set up

1. Add a yml to specify which schema to include where
2. In Site Settings, SEO tab, complete site name, address, phone and lat/lng details
3. Add $ApplySchema template variable to your page (preferably before the closing body tag)

### Example YAML

```
# Google SEO schema settings

Page:
  default_image: "public/path_to_logo_file.png"
  active_schema:
    - 'PlasticStudio\SEO\Schema\Builder\Breadcrumbs'

Skeletor\Pages\HomePage:
  active_schema:
    - 'PlasticStudio\SEO\Schema\Builder\LocalBusiness'

Skeletor\Pages\NewsArticle:
  active_schema:
    - 'PlasticStudio\SEO\Schema\Builder\NewsArticle'
```

### Example of custom schema

1. Create new schema type in app/src/Schema/Types
2. Extend PlasticStudio\SEO\Schema\Type\SchemaType
3. Write a construct method with required fields from Google Schema
4. In yaml, specify your custom schema builder

eg: https://gist.github.com/ebakernz/1dbcb7cd229ebccf2e861dbb47729991

```
Skeletor\Artena\Models\CustomDataObjectOrPage:
  active_schema:
    - 'Skeletor\Schema\Builder\CustomBuilder'
```

### BlogPost Schema

NewsArticle schema is set up for Blog module's Blog Posts.

If you're using a custom post page, you'll need to write a custom schema, OR use the same field names (see fields pulled from blog post below).

The below snippet is auto generated form your BlogPost data and some site config settings.

```javascript
<script type="application/ld+json">
{
    "@context": "http://schema.org",
    "@type": "NewsArticle",
    "mainEntityOfPage": {
        "@type": "WebPage",
        "@id": "https://google.com/article"
    },
    "headline": "Article headline",
    "datePublished": "2015-02-05T08:00:00+08:00",
    "dateModified": "2015-02-05T09:20:00+08:00",
    "description": "A most wonderful article",
    "author": {
        "@type": "Person",
        "name": "John Doe"
    },
    "publisher": {
        "@type": "Organization",
        "name": "Google",
        "logo": {
            "@type": "ImageObject",
            "url": "https://google.com/logo.jpg",
            "width": 100,
            "height": 100
        }
    },
    "image": [
        "https://example.com/photos/1x1/photo.jpg"
    ]
}
</script>
```

In your CMS Site Settings add your organisation name and image to populate the data:

- publisher.name
- publisher.logo.url
- publisher.logo.width
- publisher.logo.height

The following data is pulled from the actual BlogPost:

- headline - Title
- datePublished - PublishDate
- dateModified - LastEdited
- description - Summary
- author.name - First Author FirstName and Surname
- image - FeaturedImage.URL
