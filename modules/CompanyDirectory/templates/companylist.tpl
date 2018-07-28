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

<script type="text/javascript">{literal}
$(document).ready(function(){
  $('#sel_all').click(function(){
    var v = $(this).attr('checked');
    if( v == undefined ) {
      $('.bulk').removeAttr('checked');
    } else {
      $('.bulk').attr('checked',v);
    }
  });
  $('.bulk').click(function(){
    $('#sel_all').removeAttr('checked');
  });
  $('#toggle_filter').click(function(){
    $('#companyfilters').dialog({
       width:  'auto',
       height: 'auto',
       modal: true
    });
  });
});
{/literal}</script>

<div id="companyfilters" style="display: none;" title="{$mod->Lang('filter')}">
{$filter_formstart}
<table class="pagetable" cellspacing="0" border="0" style="border: none;">
<tr>
  <td>
  <div class="pageoverflow">
    <p class="pagetext">{$mod->Lang('name')}:</p>
    <p class="pageinput">
      <input type="text" name="{$actionid}filter_name" size="40" value="{$filter.name}"/>
      <br/>
      {$mod->Lang('info_filter_name')}
    </p>
  </div>
  </td>

  <td>
  <div class="pageoverflow">
    <p class="pagetext">{$mod->Lang('status')}:</p>
    <p class="pageinput">
      <select name="{$actionid}filter_status">
        {html_options options=$statuses selected=$filter.status}
      <select>
    </p>
  </div>
  <td>
</tr>
<tr>
  <td>
  <div class="pageoverflow">
    <p class="pagetext">{$mod->Lang('address')}:</p>
    <p class="pageinput">
      <input type="text" name="{$actionid}filter_address" size="40" value="{$filter.address}"/>
      <br/>
      {$mod->Lang('info_filter_address')}
    </p>
  </div>
  </td>

  <td>
  <div class="pageoverflow">
    <p class="pagetext">{$mod->Lang('pagelimit')}:</p>
    <p class="pageinput">
      <select name="{$actionid}filter_pagelimit">
        {html_options options=$pagelimits selected=$filter.pagelimit}
      <select>
    </p>
  </div>
  <td>
</tr>

<tr>
  {if isset($categories)}
  <td>
  <div class="pageoverflow">
    <p class="pagetext">{$mod->Lang('category')}:</p>
    <p class="pageinput">
      <select name="{$actionid}filter_categoryid">
        {html_options options=$categories selected=$filter.categoryid}
      </select>
    </p>
  </div>
  </td>
  {/if}

  <td>
  <div class="pageoverflow">
    <p class="pagetext">{$mod->Lang('sortby')}:</p>
    <p class="pageinput">
      <select name="{$actionid}filter_sortby">
        {html_options options=$sortings selected=$filter.sortby}
      </select>
    </p>
  </div>
  </td>

  <td>
  <div class="pageoverflow">
    <p class="pagetext">{$mod->Lang('sortorder')}:</p>
    <p class="pageinput">
      <select name="{$actionid}filter_sortorder">
        {html_options options=$sortorders selected=$filter.sortorder}
      </select>
    </p>
  </div>
  </td>
</tr>

<tr>
  <td>
  <div class="pageoverflow">
    <p class="pagetext">{$mod->Lang('hierarchy')}:</p>
    <p class="pageinput">
      <input type="text" name="{$actionid}filter_hierarchy" size="40" value="{$filter.hier}"/>
      <br/>
      {$mod->Lang('info_filter_hierarchy')}
    </p>
  </div>
  </td>

  <td>
  </td>
</tr>

<tr>
  <td colspan="2">
  <div class="pageoverflow">
    <p class="pagetext"></p>
    <p class="pageinput">
      <input type="submit" name="{$actionid}filter_submit" value="{$mod->Lang('submit')}"/>
      <input type="submit" name="{$actionid}filter_reset" value="{$mod->Lang('reset')}"/>
    </p>
  </div>
  </td>
</tr>

</table>
{$filter_formend}
</div>

<div class="pageoptions"><p class="pageoptions">
  <a id="toggle_filter">{cgimage image='icons/system/edit.gif' class='systemicon' alt=$mod->Lang('edit_filter')} {$mod->Lang('edit_filter')} {if isset($filter.applied)}&nbsp;<span style="color: green;">({$mod->Lang('inuse')})</span>{/if}</applied>&nbsp;
  {$addlink}{if isset($exportcsv)}&nbsp;&nbsp;{$exportcsv}{/if}&nbsp;&nbsp;{$importcsv}&nbsp;&nbsp;{$importkml}
  {if isset($nav)}
  <span style="float: right;">
    {if $nav->get_current_page() > 1}
    <a href="{$nav->get_firstpage_url()}">{$mod->Lang('firstpage')}</a>&nbsp;
    <a href="{$nav->get_prevpage_url()}">{$mod->Lang('prevpage')}</a>&nbsp;
    {/if}
    <span style="color: green;">{$mod->Lang('page')} {$nav->get_current_page()} {$mod->Lang('of')} {$nav->get_page_count()}<span>
    {if $nav->get_current_page() < $nav->get_page_count()}
    <a href="{$nav->get_nextpage_url()}">{$mod->Lang('nextpage')}</a>&nbsp;
    <a href="{$nav->get_lastpage_url()}">{$mod->Lang('lastpage')}</a>&nbsp;
    {/if}
  </span>
  {/if}
</p></div>

{if $itemcount > 0}
{$bulk_formstart}
<table cellspacing="0" class="pagetable cms_sortable tablesorter">
	<thead>
		<tr>
			<th>{$idtext}</th>
			<th>{$companytext}</th>
                        <th>{$mod->Lang('owner')}</th>
			<th>{$websitetext}</th>
			<th>{$mod->Lang('url')}</th>
			<th>{$mod->Lang('status')}</th>
			<th class="pageicon">&nbsp;</th>
			<th class="pageicon">&nbsp;</th>
			<th class="pageicon">&nbsp;</th>
			<th class="pageicon"><input type="checkbox" id="sel_all" value="-1" title="{$mod->Lang('select_all')}"/></th>
		</tr>
	</thead>
	<tbody>
{foreach from=$items item=entry}
	{cycle values="row1,row2" assign='rowclass'}
		<tr class="{$rowclass}" onmouseover="this.className='{$rowclass}hover';" onmouseout="this.className='{$rowclass}';">
			<td>{$entry->id}</td>
			<td>{$entry->company_name}</td>
	                <td>{if isset($entry->owner)}{$entry->owner}{/if}</td>
			<td>{$entry->website}</td>
			<td>{$entry->url}</td>
                        <td>{$mod->Lang($entry->status)}</td>
			<td>{$entry->copylink}</td>
			<td>{$entry->editlink}</td>
			<td>{$entry->deletelink}</td>
                        <td><input type="checkbox" name="{$actionid}bulk[]" value="{$entry->id}" class="bulk"/></td>
		</tr>
{/foreach}
	</tbody>
</table>
<div class="pagecontainer" style="text-align: right;">
{$mod->Lang('with_selected')}:
<select name="{$actionid}bulkaction">
  <option value="delete">{$mod->Lang('delete')}</option>
  <option value="disable">{$mod->Lang('disable')}</option>
  <option value="publish">{$mod->Lang('publish')}</option>
</select>
<input type="submit" name="{$actionid}bulk_submit" value="{$mod->Lang('submit')}"/>
</div>
{$bulk_formend}
{else}
<div class="pageerrorcontainer">
{$mod->Lang('error_nofiltermatches')}
</div>
{/if}

{if $itemcount > 10 or isset($nav)}
<div class="pageoptions"><p class="pageoptions">
  {$addlink}{if isset($exportcsv)}&nbsp;&nbsp;{$exportcsv}{/if}&nbsp;&nbsp;{$importcsv}&nbsp;&nbsp;{$importkml}
</p></div>
{/if}
