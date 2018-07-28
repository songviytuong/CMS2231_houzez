<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">
{function name=Nav_sitemap}
{foreach $data as $node}
{page_attr key=searchable page=$node->id assign=isSearchable}
{if $node->type=='content' && !empty($isSearchable)}
<url>
  <loc>{$node->url}</loc>
  <lastmod>{$node->modified|date_format:'%Y-%m-%d'}</lastmod>
  <changefreq>{math now=$smarty.now modified=$node->modified equation='(now-modified)/86400' assign='days'}{if $days < 2}hourly{elseif $days < 14}daily{elseif $days < 61}weekly{elseif $days < 365}monthly{else}yearly{/if}</changefreq>
  <priority>{$level=$node->hierarchy|substr_count:'.'}{if $node->url|substr:0:-1 == {root_url}}1{elseif $level == '0'}0.8{elseif $level == '1'}0.6{elseif $level == '2'}0.4{else}0.2{/if}</priority>
</url>
{/if}
{if isset($node->children)}{Nav_sitemap data=$node->children}{/if}
{/foreach}
{/function}
{if isset($nodes)}{Nav_sitemap data=$nodes}{/if}
</urlset>