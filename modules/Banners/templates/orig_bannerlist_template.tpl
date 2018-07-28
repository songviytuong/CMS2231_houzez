{* banner list template *}
{if !empty($banners)}
<h3>{$category->name}</h3>
{foreach from=$banners item='banner'}

<div class="banner">
{strip}
  <a rel="nofollow" href="{$banner.clickthrough}" title="{$banner.name}">
     <img src="uploads/{$banner.image}" width="450" height="68" alt="{$banner.text}"/>
</a>
{/strip}
</div>

{/foreach}
{/if}