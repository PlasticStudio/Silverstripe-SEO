<% with $SeoPageObject %>

    <% if $PageMetaTitle %>
        <title>$PageMetaTitle</title>
    <% else_if $Title %>
        <title>$Title | $SiteConfig.Title</title>
    <% end_if %>

    <% if $PageMetaDescription %>
        <meta name="description" content="$PageMetaDescription">
    <% else_if $Content %>
        <meta name="description" content="$Content.LimitWordCount(12)">
    <% end_if %>

    <% if $PageCanonical %>
        <link rel="canonical" href="$PageCanonical">
    <% end_if %>

    <% if $PageRobots %>
        <meta name="robots" content="$PageRobots">
    <% end_if %>

    <% if not $HideSocial %>

        <% if $PageMetaTitle %>
            <meta property="og:title" content="$PageMetaTitle">
            <meta name="twitter:title" content="$PageMetaTitle">
        <% else_if $Title %>
            <meta property="og:title" content="$Title">
            <meta name="twitter:title" content="$Title">
        <% end_if %>

        <% if $PageMetaDescription %>
            <meta property="og:description" content="$PageMetaDescription">
            <meta name="twitter:description" content="$PageMetaDescription">
        <% else_if $Content %>
            <meta property="og:description" content="$Content.LimitWordCount(12)">
            <meta name="twitter:description" content="$Content.LimitWordCount(12)">
        <% end_if %>

        <% if $PageURL %>
            <meta property="og:url" content="$PageURL">
        <% end_if %>

        <% if $PageOgType %>
            <meta property="og:type" content="$PageOgType">
        <% end_if %>

        <% if $PageOgLocale %>
            <meta property="og:locale" content="$PageOgLocale">
        <% end_if %>

        <% if $PageTwitterCard %>
            <meta name="twitter:card" content="$PageTwitterCard">
        <% end_if %>

        <% if $PageSocialImage %>
            <meta property="og:image" content="$PageSocialImage.AbsoluteURL">
            <meta name="twitter:image" content="$PageSocialImage.AbsoluteURL">
        <% else_if $DefaultSocialImage %>
            <meta property="og:image" content="$DefaultSocialImage.AbsoluteURL">
        <% end_if %>

        <% if $SiteFacebookAppID %>
            <meta property="fb:app_id" content="$SiteFacebookAppID">
        <% end_if %>

        <% if $SiteOgSiteName %>
            <meta property="og:site_name" content="$SiteOgSiteName">
        <% end_if %>

        <% if $SiteTwitterHandle %>
            <meta name="twitter:site" content="$SiteTwitterHandle">
        <% end_if %>

        <% if $SiteCreatorTwitterHandle %>
            <meta name="twitter:creator" content="$SiteCreatorTwitterHandle">
        <% end_if %>

    <% end_if %>

    <% loop $HeadTags.Filter('Type', 'name') %>
        <meta name="$Title" content="$Value">
    <% end_loop %>

    <% loop $HeadTags.Filter('Type', 'link') %>
        <link rel="$Title" href="$value">
    <% end_loop %>

    <% loop $HeadTags.Filter('Type', 'property') %>
        <meta property="$Title" content="$Value">
    <% end_loop %>

    <% if $PageGenerator %>
        <meta name="generator" content="$PageGenerator">
    <% end_if %>

    <% if $PageCharset %>
        <meta http-equiv="Content-type" content="text/html; charset=$PageCharset">
    <% end_if %>

    <% if $isCMSPreviewPage %>
        <meta name="x-page-id" content="$CMSPageID">
        <meta name="x-cms-edit-link" content="$CMSPageEditLink">
    <% end_if %>

    <% if $PaginationPrevTag %>
        <link rel="prev" href="$PaginationPrevTag">
    <% end_if %>
    <% if $PaginationNextTag %>
        <link rel="next" href="$PaginationNextTag">
    <% end_if %>

<% end_with %>
