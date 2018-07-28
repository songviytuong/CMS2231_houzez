<sitemapindex xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">
{foreach $items as $item}
<sitemap>
  <loc>{root_url}/assets/sitemaps/sitemap-{$item.sitemap_name|lower}.xml</loc>
</sitemap>
{/foreach}
</sitemapindex>