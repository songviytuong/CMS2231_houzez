{* this is a sample product detail template *}
<div class="ProductDirectoryItem">

{* set a canonical url *}
{if $entry->detail_url != ''}{assign var='canonical' scope=global value=$entry->detail_url}{/if}

{* note: {content} must be called before the hierarchy view is called *}
{if $entry->hierarchy_id > 0}{assign var='active_hierarchy' scope=global value=$entry->hierarchy_id}{/if}

{if $entry->breadcrumb}
<div class="row">
  <div class="col-sm-2">Breadcrumb:</div>
  <div class="col-sm-10">{$entry->breadcrumb}</div>
</div>
{/if}

<div class="row">
  <div class="col-sm-2">Name:</div>
  <div class="col-sm-10">
    <a name="product_name" style="text-decoration: none;">{$entry->product_name}</a>
  </div>
</div>

{if $entry->price gt 0}
<div class="row">
  <div class="col-sm-2">{$mod->Lang('price')}:</div>
  <div class="col-sm-10">
    {product_ops::get_currency_symbol()}{$entry->price|as_num:2}
  </div>
</div>

  {* uncomment the following line if the Promotions module is installed *}
  {* promo_get_prod_discount product_id=$entry->id assign='foo' *}
  {if isset($foo.promo_id)}
  <div class="row">
    <div class="col-sm-2">
      <span style="color: red;">Discount:</span>
    </div>
    <div class="col-sm-10">
      <span style="color: red;">{product_ops::get_currency_symbol()}{$foo.discount|as_num:2} ({$foo.percentage|as_num:2}%)</span>
    </div>
  </div>
  {/if}
{/if}

{if $entry->weight gt 0}
<div class="row">
  <div class="col-sm-2">{$mod->Lang('weight')}:</div>
  <div class="col-sm-10">
    {$entry->weight|as_num:2} {product_ops::get_weight_units()}
  </div>
</div>
{/if}

{if $entry->details ne ''}
<div class="row">
  <div class="col-sm-2">{$mod->Lang('details')}:</div>
  <div class="col-sm-10">
    {$entry->details}
  </div>
</div>
{/if}

{* accessing all of the fields in a list *}
{if isset($entry->fields) && count($entry->fields)}
  <fieldset>
    <legend>Custom Fields</legend>
    {foreach $entry->fields as $field}
       <div class="row product_detail_field">
          <div class="col-sm-2">{$field->name}:</div>
	  <div class="col-sm-10">
            {$Products->lang('type')}: {$field->type}<br/>
	    {if !is_array($field->value)}
              {$Products->lang('value')}: {$field->value}<br/>
	    {/if}
            {if $field->type == 'image' && isset($field->thumbnail)}
              <img src="{$entry->file_location}/{$field->thumbnail}" alt="{$field->value}"/>
            {/if}
	 </div>
      </div>
    {/foreach}
  </fieldset>
{/if}

{* print out attributes *}
{if isset($entry->attributes)}
  <fieldset>
    <legend>Attributes</legend>
    <table>
      <thead>
        <tr>
          <th>Text</th>
          <th>Sku</th>
          <th>Adjustment</th>
        </tr>
      </thead>
      <tbody>
      {foreach from=$entry->attributes key='name' item='attrib'}
        <tr>
          <td>{$attrib.text}</td>
          <td>{$attrib.sku}</td>
          <td>{$attrib.adjustment}</td>
         </tr>
      {/foreach}
      </tbody>
    </table>
  </fieldset>
{/if}

{* print out a link to a summary view of items in this hierarchy, if we have it *}
{if $entry->hierarchy_id}
  <p>Items in this hierarchy: <a href="{cms_action_url action=default hierarchyid=$entry->hierarchy_id}">Go</a></p>
{/if}

{* print out the categories *}
{if isset($entry->categories)}
  <fieldset>
    <legend>Categories:</legend>
    {foreach $entry->categories as $category}
    <div class="row product_detail_category"><p>
      {module_action_url categoryid=$category->id assign='category_view_url'}
      <div class="col-sm-2"><a href="{$category_view_url}">{$category->name} <em>(id={$category->id})</em></a>:</div>
      <div class="col-sm-10">
        {* if there are data fields associated with this category, display them too *}
        {if isset($category->data) && count($category->data)}
          <div class="product_detail_category_fields">
            <strong>{$Products->Lang('data')}</strong><br/>
            {foreach $category->data as $onedataitem}
              <div class="product_detail_category_onefield">
              {if $onedataitem.field_type == 'image'}
                <a href="{$category->file_location}/{$onedataitem.field_value}"><img src="{$category->file_location}/thumb_{$onedataitem.field_value}" alt="thumb" /></a><br/>
              {elseif $onedataitem.field_type == 'file'}
                <a href="{$category->file_location}/{$onedataitem.field_value}">{$onedataitem.field_value}</a><br/>
              {else}
                <strong>{$onedataitem.field_prompt}</strong>: {$onedataitem.field_value}<br/>
              {/if}
              </div>
            {/foreach}
          </div>
        {/if}
      </div>
    </div>
    {/foreach}
  </fieldset>
{/if}

</div>{* .ProductDirectoryItem *}

{* display the cart
{Cart2 sku=$entry->sku}
*}

{* album... if we have any *}
{if $entry->album}
  <div class="row">
    {* album images are always relative to the uploads url *}
    {foreach $entry->album as $img}
       <a href="{uploads_url}/{$img}"><img src="{uploads_url}/{$img}" class="img-thumbnail" width="100"/></a>
    {/foreach}
  </div>
{/if}


{* create a link back to the top of the page *}
{anchor anchor='product_name' text=$Products->Lang('return_to_top') title=$Products->Lang('return_to_top')}
