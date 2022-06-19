<section class="page cf">

	<main class="typography sitemap">

		<div class="inner">

				<% if Sitemap %>
					<%-- level 1 --%>
					<ul>
					<% loop Sitemap %>
						<% if not ExcludeFromSitemap %>
							<li>
								<a href="$Link" title="<% if MetaKeywords %>$MetaKeywords <% else %> Webdesign Wellington <% end_if %> - {$SiteConfig.Title} - <% if MetaTitle %>$MetaTitle.XML <% else %> $Title.XML <% end_if %>">$MenuTitle.XML</a>
								<% if AllChildren %>
									<% include SitemapNextLevel %>
								<% end_if %>
							</li>
						<% end_if %>
					<% end_loop %>
					</ul>
				<% else %>
				
					<p>There are no pages in this site yet.</p>
					$Content
					$Form
				
				<% end_if %>
			
			<div class="clear"></div>

		</div>
	</main>

</section>