{*
#CMS - CMS Made Simple
#(c)2004-6 by Ted Kulp (ted@cmsmadesimple.org)
#This project's homepage is: http://cmsmadesimple.org
#
#This program is free software; you can redistribute it and/or modify
#it under the terms of the GNU General Public License as published by
#the Free Software Foundation; either version 2 of the License, or
#(at your option) any later version.
#
#This program is distributed in the hope that it will be useful,
#but WITHOUT ANY WARRANTY; without even the implied warranty of
#MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
#GNU General Public License for more details.
#You should have received a copy of the GNU General Public License
#along with this program; if not, write to the Free Software
#Foundation, Inc., 59 Temple Place, Suite 330, Boston, MA  02111-1307  USA
#
#$Id$
*}

<div id="filterform" class="c_full cf">
{$formstart}
<fieldset class="grid_6">
  <legend>{$mod->Lang('filters')}:&nbsp;</legend>
  <div class="c_full cf">
    <label class="grid_3">{$mod->Lang('productname')}:</label>
    <div class="grid_8">
       <input type="text" class="grid_12" name="{$actionid}input_productname" value="{$filter.productname}" maxlength="255"/>
       <br/>{$mod->Lang('info_filter_productname')}
    </div>
  </div>
  <div class="c_full cf">
    <label class="grid_3">{$mod->Lang('sku')}:</label>
    <div class="grid_8">
       <input type="text" class="grid_12" name="{$actionid}input_sku" value="{$filter.sku}" maxlength="10"/>
       <br/>{$mod->Lang('info_filter_sku')}
    </div>
  </div>
  <div class="c_full cf">
    <label class="grid_3">{$mod->Lang('hierarchy')}:</label>
    <div class="grid_8">
        {$input_hierarchy}&nbsp;{$mod->Lang('include_children')} {$input_children}
    </div>
  </div>
  {if isset($category_list)}
  <div class="c_full cf">
    <label class="grid_3">{$mod->Lang('category')}:</label>
    <select class="grid_8" name="{$actionid}categories[]" multiple="multiple" size="5">
        {html_options options=$category_list selected=$filter.categories}
    </select>
  </div>
  <div class="c_full cf">
    <label class="grid_3">{$mod->Lang('exclude_categories')}:</label>
    <div class="grid_8">{$input_excludecats}</div>
  </div>
  {/if}
</fieldset>
<fieldset class="grid_6">
  <legend>{$mod->Lang('view')}:&nbsp;</legend>
  {if isset($fields_viewable)}
  <div class="c_full cf">
    <label class="grid_3">{$mod->Lang('viewable_fields')}:</label>
    <select name="{$actionid}custom_fields[]" size="5" multiple="multiple" class="grid_8">
      {html_options options=$fields_viewable selected=$filter.custom_fields}
    </select>
  </div>
  {/if}

  <div class="c_full cf">
    <label class="grid_3">{$mod->Lang('sort_by')}:</label>
    <div class="grid_8">{$input_sortby}</div>
  </div>
  <div class="c_full cf">
    <label class="grid_3">{$mod->Lang('sort_order')}:</label>
    <div class="grid_8">{$input_sortorder}</div>
  </div>
  <div class="c_full cf">
    <label class="grid_3">{$mod->Lang('page_limit')}:</label>
    <div class="grid_8">{$input_pagelimit}</div>
  </div>
</fieldset>
<div class="clearb"></div>
<div class="c_full cf" style="text-align: center;">
  <input type="submit" name="{$mod->GetActionId()}submit" value="{$mod->Lang('submit')}">
  <input type="submit" name="{$mod->GetActionId()}reset" value="{$mod->Lang('reset')}">
</div>
{$formend}
<hr/>
</div><!-- filterform -->


<div id="productlist">
<script type="text/javascript">{literal}
$(document).ready(function(){
  $('#filterform').hide();
  $('#filterbox').click(function(){
    $('#filterform').toggle();
  });
  $('#select_all_products').click(function(){
    var checked = $(this).attr('checked');
    if( checked == 'checked' ) {
      $('.multiselect').attr('checked',checked);
    } else {
      $('.multiselect').removeAttr('checked');
    }
  });
  $('.multiselect').click(function(){
    $('#select_all_products').removeAttr('checked');
  });
  $('#bulkaction_submit').click(function(){
    var len = $('#productlist tbody input:checkbox:checked').length;
    if( len == 0 )
    {
      alert('{/literal}{$mod->Lang('nothing_selected')}{literal}');
      return false;
    }
    return true;
  });
    initAjax();
    initAjaxEvents();
});
{/literal}</script>

<div class="c_full">
  <div class="grid_6" style="padding-bottom: 0.25em;">
    <ul class="option-menu-horiz">
      <li>
        <a href="{module_action_url action=addproduct}">{cgimage image='icons/system/newobject.gif' alt=''} {$mod->Lang('addproduct')}</a>
      </li>
      <li>
        <a href="{module_action_url action=importproducts}">{cgimage image='icons/system/import.gif' alt=''} {$mod->Lang('import_from_csv')}</a>
      </li>
      {if $itemcount gt 0}
        <li>
        <a href="{module_action_url action=exportcsv}">{cgimage image='icons/system/export.gif' alt=''} {$mod->Lang('export_to_csv')}</a>
        </li>
      {/if}
      <li><a id="filterbox">{cgimage image='icons/system/view.gif' alt=''} {$mod->Lang('filter')} {if $filterinuse}<em style="color: blue;">({$mod->Lang('filterinuse')})</em>{/if}</a></li>
    </ul>
  </div>

  <div class="grid_6">
    {if $itemcount gt 0}
      <span style="float: right; text-align: right;">
      {if isset($firstpage_url)}
        <a href="{$firstpage_url}" title="{$mod->Lang('firstpage')}">{$mod->Lang('firstpage')}</a>
        <a href="{$prevpage_url}" title="{$mod->Lang('prevpage')}">{$mod->Lang('prevpage')}</a>
      {/if}
      {if isset($firstpage_url) || isset($lastpage_url)}
        {$mod->Lang('page_of',$pagenumber,$pagecount)}
      {/if}
      {if isset($lastpage_url)}
        <a href="{$nextpage_url}" title="{$mod->Lang('nextpage')}">{$mod->Lang('nextpage')}</a>
        <a href="{$lastpage_url}" title="{$mod->Lang('lastpage')}">{$mod->Lang('lastpage')}</a>
      {/if}
      </span>
    {/if}
  </div>
  <div class="clearb"></div>
</div>

{if $itemcount gt 0}
  {$formstart2}
  <table cellspacing="0" class="pagetable">
    <thead>
      <tr>
	<th>{$idtext}</th>
	<th>{$producttext}</th>
	<th>{$sku}</th>
	<th>{$pricetext}</th>
	<th>{$mod->Lang('status')}</th>
        {if !empty($filter.custom_fields)}
          {foreach $filter.custom_fields as $fid}
            <th>{$fields_viewable[$fid]}</th>
          {/foreach}
        {/if}
        <th class="pageicon {literal}{sorter: false}{/literal}">&nbsp;</th>
	<th class="pageicon {literal}{sorter: false}{/literal}">&nbsp;</th>
        {if $allowtravel eq 1}
	<th class="pageicon {literal}{sorter: false}{/literal}">&nbsp;</th>
        {/if}
	<th class="pageicon {literal}{sorter: false}{/literal}">&nbsp;</th>
	<th class="pageicon {literal}{sorter: false}{/literal}">&nbsp;</th>
	<th class="pageicon {literal}{sorter: false}{/literal}">&nbsp;</th>
        <th class="pageicon {literal}{sorter: false}{/literal}"><input type="checkbox" title="{$mod->Lang('select_all')}" value="1" name="select_all" id="select_all_products"></th>
      </tr>
    </thead>
    <tbody>
      {foreach from=$items item=entry}
	<tr class="{cycle values='row1,row2'}">
	<td>{$entry.id}</td>
	<td><a href="{$entry.edit_url}" title="{$mod->Lang('edit')}">{$entry.product_name}</a></td>
	<td>{$entry.sku}</td>
	<td>{$entry.price|as_num:2}</td>
	<td>{if $entry.status != 'published'}
              <span style="color: red;">{$mod->Lang($entry.status)}</span>
            {else}
               {$mod->Lang($entry.status)}
            {/if}
        </td>
        {if !empty($filter.custom_fields)}
          {foreach $filter.custom_fields as $fid}
            <td>
	      {$subfld=substr($fid,2)}
	      {if startswith($fid,'P:')}
	        {$entry[$subfld]}
	      {else}
	        {$tmp=$field_names[$subfld]}
	        {$entry[$tmp]}
	      {/if}
	    </td>
          {/foreach}
        {/if}
        <td {if $entry.ajax == true}class="init-ajax-toggle"{/if}>{$entry.importseo}</td>
	<td>{module_action_link module='Products' action='admin_edit_attribs' prodid=$entry.id image='table_relationship.png' text=$mod->Lang('edit_options') imageonly=1}</td>
	{if $allowtravel eq 1}
        <td>{module_action_link module='Products' action='admin_edit_timelines' prodid=$entry.id image='timelines.png' text=$mod->Lang('edit_timelines') imageonly=1}</td>
	{/if}
        <td>{$entry.editlink}</td>
	<td>{$entry.copylink}</td>
	<td>{$entry.deletelink}</td>
        <td><input type="checkbox" class="multiselect" name="{$actionid}multiselect[]" value="{$entry.id}"></td>
        </tr>
      {/foreach}
    </tbody>
  </table>

  <div class="pageoptions" style="height: 2em;">
    <div style="width: 40%; float: left; margin-top: 0.5em;">
      {$addlink}&nbsp;{$importlink}
    </div>
    {if $itemcount gt 0}
      <div style="text-align: right; width: 40%; float: right; margin-top: 0.5em; margin-bottom: 0.5em;">
        {$mod->Lang('with_selected')}:
        <select name="{$actionid}bulkaction">{html_options options=$bulkactions}</select>
        <input type="submit" id="bulkaction_submit" name="{$actionid}submit" value="{$mod->Lang('go')}"/>
      </div>
    {/if}
  </div>
{$formend2}
{/if}
</div><!-- productlist -->
