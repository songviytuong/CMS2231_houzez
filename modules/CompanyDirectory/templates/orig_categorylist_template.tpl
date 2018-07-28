{function do_categories}
<ul>
  {foreach $list as $obj}
  <li>
    {* note... the count represents the sum of the companies matching the query in this category, and all children *}
    {if isset($obj->count) && $obj->count gt 0}
      <a href="{$obj->summary_url}">{$obj->name|escape}</a>  <em>({$obj->count})</em>
    {else}
      {$obj->name|escape} <em>(0)</em>
    {/if}
    {if isset($obj->children) && count($obj->children)}{do_categories list=$obj->children}{/if}
  </li>
  {/foreach}
</ul>
{/function}
{do_categories list=$categorylist}
