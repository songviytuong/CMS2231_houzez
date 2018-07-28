{* CompanyDirectory Summary Template *}
{if isset($messages)}
<div class="row CompanyDirectoryMessage">
 <ul>
   {foreach from=$messages item='one'}
     <li>{$one}</li>
   {/foreach}
 </ul>
</div>
{/if}

{if isset($errors)}
<div class="row CompanyDirectoryError">
 <ul>
   {foreach from=$errors item='one'}
     <li>{$one}</li>
   {/foreach}
 </ul>
</div>
{/if}

{if isset($items)}
  {if isset($firstlink) || isset($nextlink)}
    <div class="row">
      <div class="col-md-offset-8"></div>
      <div class="col-md-4">
        {if isset($firstlink)}{$firstlink}&nbsp;{$prevlink}&nbsp;&nbsp;{/if}
        {$pagetext} {$curpage} {$oftext} {$pagecount}
        {if isset($nextlink)}&nbsp;&nbsp;{$nextlink}&nbsp;{$lastlink}{/if}
      </div>
    </div>
  {/if}

  {foreach from=$items item=entry}
  <article class="CompanyDirectoryItem" style="padding-bottom: 2em;">
    <div class="row">
      <div class="col-md-2">
      {if $entry->picture_location ne ''}
        {CGSmartImage src=$entry->picture_path height=150 width=150}
      {/if}
      </div>
      <div class="col-md-10">
        <div class="row">
          {$CompanyDirectory->Lang('name')}:&nbsp;<a href="{$entry->detail_url}">{$entry->company_name}</a>
        </div>
        <div class="row">
          {module_action_link module='CGSocialApp' action='addcheckin' location=$entry->id text='Checkin Here'}
        </div>
        {if $entry->address ne ''}
          <div class="row">{$CompanyDirectory->Lang('address')}:&nbsp;{$entry->address}</div>
        {/if}
        {if $entry->website ne ''}
          <div class="row">{$CompanyDirectory->Lang('website')}:&nbsp;<a href="http://{$entry->website}">{$entry->website}</a></div>
        {/if}
      </div>
    </div>

    {* sample of addressing a custom field directly *}
{strip}
    {if isset($entry->fields)}
      {if isset($entry->fields.foo) && $entry->fields.foo->value != ''}
        Foo: {$entry->fields.foo->value}<br/>
      {/if}

      {* sample of addressing a field with spaces or other chars in the name
      Special Field: {assign var='tmp' value='The Field Name'}{$entry->fields.$tmp->value}<br/>
    *}
  
    {* sample of addressing the value of a dropdown field: *}
    {if isset($entry->fields.mydropdown) && $entry->fields.mydropdown->dropdown_value != ''}
      Sample Dropdown: {$entry->fields.mydropdown->dropdown_value}<br/>
    {/if}

    {* sample of looping through the fields associative array
    {foreach from=$entry->fields key='fieldname' item='field'}
      {if isset($field->value) && $field->value != ''}
        {$field->name} <em>({$field->type})</em>: {$field->value}<br/>
      {/if}
    {/foreach}
    *}
  {/if}
{/strip}

  </article>
  {foreachelse}
    <div class="alert alert-error">{$CompanyDirectory->Lang('error_nocompaniesmatch')}</div>
  {/foreach}
{/if}
