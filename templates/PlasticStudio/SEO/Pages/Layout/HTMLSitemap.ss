<section class="page cf">

	<main class="typography sitemap">

		<div class="inner">

			<% if $Sitemap %>
					
				$Sitemap.RAW

			<% else %>
			
				<p>There are no pages in this site yet.</p>
			
			<% end_if %>
			
			<div class="clear"></div>

		</div>
	</main>

</section>

$ElementalArea