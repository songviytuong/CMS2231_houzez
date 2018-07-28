{* hierarchy report template *}
{if !isset($hdepth) && isset($hierarchy_item)}
<h3>Hierarchy Data for {$hierarchy_item.name} ({$hierarchy_item.id})</h3>
<p><a href="{$hierarchy_item.parent_url}">Up</a></p>
{/if}

{if !isset($hdepth)}{assign var='hdepth' value='0'}{/if}

{*
 // create a nested set of unordered lists
 // if the active_hierarchy smarty variable exists
 // and matches the current hierarchy id
 // the active class will be given
 // to the ul.  You may want to modify your summary template
 // to set this variable
*}
<ul {if $hdepth == 0}id="products_hierarchy"{/if} class="products_hierarchy_level{$hdepth}">
{foreach from=$hierdata key='key' item='item'}
{strip}
  {$class='product_hier'}
  {if isset($active_hierarchy) and $item.id == $active_hierarchy}{$class=$class|cat:' active'}{/if}
  {if isset($item.children)}{$class=$class|cat:' parent'}{/if}
  <li{if $class != ''} class="{$class}"{/if}>

  {if isset($item.children)}
    <a href="{$item.down_url}">{$item.name}</a>
  {else}
    {$item.name}
  {/if}
  &nbsp;&nbsp;
  {if $nochildren}
    {* not displaying child hierarchy products *}
    {if $item.direct_count gt 0}
      <a href="{$item.url}">View ({$item.direct_count}) items</a>
    {else}
      {$item.name} ({$item.count})
    {/if}
  {elseif $item.count gt 0}
    <a href="{$item.url}">View ({$item.count}) items</a>
  {else}
   {$item.name} ({$item.count})
  {/if}

  </li>
{/strip}
{/foreach}
</ul>