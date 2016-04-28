<?xml version="1.0" encoding="UTF-8"?>
<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9" xmlns:image="http://www.google.com/schemas/sitemap-image/1.1">

<% loop $Pages %>

<% if $Robots != 'noindex,nofollow' %>
<url>
    
    <loc>$Top.URL{$Link}</loc>
    <lastmod>$LastEdited.Format('c')</lastmod>
    <changefreq>$ChangeFrequency</changefreq>
    <priority>$Priority</priority>

    <% loop $SitemapImages %>
    
    <image:image>
        <image:loc>$Top.URL/{$Filename}</image:loc>
        <image:title>$Top.Encode($Title)</image:title>
    </image:image>

    <% end_loop %>

</url>
<% end_if %>

<% end_loop %>

</urlset>