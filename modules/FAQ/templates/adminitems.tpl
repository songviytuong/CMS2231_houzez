<div class="pageoverflow">
  <p class="pageoptions">{$categorylabel} {$categoryselect}</p>
{$categoryselectjs}
</div>

{$formstart}
<div class="pageoverflow">
  <p class="pageoptions">{$addlink} {$submit}</p>
</div>

{assign var=pages value=$pagelinks|@count}
{assign var=offset value=$currentpage-8}
{if $offset < 0}{assign var=offset value=0}{/if}
{if $offset > $pages-15}{assign var=offset value=$pages-15}{/if}
{capture assign=pagination}
{if $pages > 1}
<div class="pageoverflow">| 
{foreach from=$pagelinks|@array_slice:$offset:15:true key='pagenumber' item='pagelink'}
  <a href="{$pagelink}" title="{$pagenumber}"{if $pagenumber == $currentpage} style="font-weight:bold;"{/if}>{$pagenumber}</a> | 
{/foreach}
</div>
{/if}
{/capture}
{$pagination}

{$sortseq}

<table cellspacing="0" class="pagetable sort_table">
	<thead>
		<tr>
			<th>{$id}</th>
			<th>{$question}</th>
			<th>{$answer}</th>
			<th class="pageicon">{$active}</th>
			<th class="pageicon updown">&nbsp;</th>
			<th class="pageicon updown">&nbsp;</th>
			<th class="pageicon">&nbsp;</th>
			<th class="pageicon">&nbsp;</th>
			{*<th class="pageicon"><input id="selectall" type="checkbox" /></th>*}
		</tr>
	</thead>
	<tbody>
{foreach from=$items item=entry}
	{cycle values="row1,row2" assign=rowclass}
		<tr id="i{$entry->entry_id}" class="{$rowclass}">
			<td><a href="{$editurl|replace:'QQ':$entry->entry_id}">{$entry->entry_id}</a></td>
			<td>{$entry->question}</td>
			<td>{$entry->answer|strip_tags|truncate:40}</td>
			<td class="pagepos">{if $entry->active}{$activefalselink|replace:'QQ':$entry->entry_id}{else}{$activetruelink|replace:'QQ':$entry->entry_id}{/if}</td>
      <td class="pagepos updown">{$entry->moveup}</td>
      <td class="pagepos updown">{$entry->movedown}</td>
			<td class="pagepos"><a href="{$editurl|replace:'QQ':$entry->entry_id}">{$editicon}</a></td>
			<td class="pagepos">{$deletelink|replace:'QQ':$entry->entry_id}</td>
			{*<td class="checkbox">$multiselect|replace:'QQ':$entry->entry_id</td>*}
		</tr>

{/foreach}
	</tbody>
</table>

{$pagination}
{*
<div style="margin-top: 0; float: right; text-align: right">
	$prompt_multiaction}: {$multiaction}
</div>
*}

<div class="pageoverflow">
  <p class="pageoptions">{$addlink} {$submit}</p>
</div>

{$formend}
