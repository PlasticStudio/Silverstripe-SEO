<?xml version="1.0" encoding="UTF-8"?>
<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9" xmlns:image="http://www.google.com/schemas/sitemap-image/1.1">

<% loop $SitemapPages %>

<url>
    
    <loc>{$Top.SitemapHost}$Link</loc>
    <lastmod>$SitemapDate</lastmod>
    <changefreq><% if $ChangeFrequency %>$ChangeFrequency<% else %>monthly<% end_if %></changefreq>
    <priority><% if HasValue($Priority) %>$Priority<% else %>0.5<% end_if %></priority>

    <% loop $SitemapImages %>
    
    <image:image>
        <image:loc>{$Top.SitemapHost}/{$Filename}</image:loc>
        <image:title>$Top.EncodedValue($Title)</image:title>
    </image:image>

    <% end_loop %>

</url>

<% end_loop %>

</urlset>