{* banner category template *}
{strip}
{if isset($banner.clickthrough)}
<a rel="nofollow" href="{$banner.clickthrough}" title="{$banner.name}">
<img src="uploads/{$banner.image}" width="450" height="68" alt="{$banner.text|default:''}"/>
</a>
{else}
{* no url found, just displaying an image *}
<img src="uploads/{$banner.image}" width="450" height="68" alt="{$banner.text|default:''}"/>
{/if}
{/strip}
