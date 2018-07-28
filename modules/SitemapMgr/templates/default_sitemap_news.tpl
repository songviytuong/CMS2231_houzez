<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">
{foreach from=$items item=entry}
<url>
  <loc>{$entry->moreurl}</loc>
  <lastmod>{$entry->modified_date|date_format:'%Y-%m-%d'}</lastmod>
  <changefreq>{math now=$smarty.now modified=strtotime($entry->modified_date) equation='(now-modified)/86400' assign='days'}{if $days < 2}hourly{elseif $days < 14}daily{elseif $days < 61}weekly{elseif $days < 365}monthly{else}yearly{/if}</changefreq>
  <priority>0.6</priority>
</url>
{/foreach}
</urlset>