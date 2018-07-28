<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">
{foreach from=$items item=entry}
<url>
	<loc>{$entry->detailurl}</loc>
</url>
{/foreach}
</urlset>