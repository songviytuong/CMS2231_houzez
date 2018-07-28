<div class="products_category_list">
{if isset($categorylist) && count($categorylist)}
  {foreach from=$categorylist item='obj'}
  <div class="products_category">
    {* category fields are available as an array in $obj->fields *}
    {* i.e: $obj->fields.fieldname.field_value *}
    {if isset($obj->fields)}
    {foreach from=$obj->fields key='field_name' item='fielddata'}
      <div class="products_category_field">
        {$fielddata.field_prompt} = {$fielddata.field_value}
      </div>
    {/foreach}
    {/if}
    {if isset($obj->detail_url)}
      <a href="{$obj->detail_url}">Details For {$obj->name}</a>&nbsp;&nbsp;
    {/if}
    <a href="{$obj->summary_url}">Products Matching {$obj->name}</a>({$obj->count})
  </div>
  {/foreach}
{else}
  {cgerror}No data to display{/cgerror}
{/if}
</div>
