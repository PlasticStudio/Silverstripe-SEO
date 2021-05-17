# Robots

## Default Robots.txt

By default the module contains a Robots.txt template that will render a robots file when you visit /robots.txt

```html
User-agent: \*

Sitemap: {YOUR_DOMAIN}/sitemap.xml
```

## Creating a Robots.txt File

If you would like to override the file create a template called RobotsTxt.ss and place it within your /themes/{YOUR_THEME}/templates/ folder.

## Exclude entire site from indexing robots

You can configure the site to be excluded from indexing engines like Google based on domain. This is useful for ensuring that development or UAT instances of your site do not get indexed. For example, you may have a UAT instance of a site at `mysite.myhost-uat.co`. To exclude this site from being indexed you would add `.myhost-uat.co` to the configuration settings. Add the following to your `config.yml`:

```PlasticStudio\SEO:
  noindex_domains:
    - .myhost-uat.co
```






