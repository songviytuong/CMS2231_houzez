<h3>{$title_attribsets_for}:&nbsp;{$product_name}</h3>

{if $itemcount > 0}
<table cellspacing="0" class="pagetable">
	<thead>
		<tr>
			<th>{$idtext}</th>
                        <th>{$nametext}</th>
			<th>{$counttext}</th>
			<th class="pageicon">&nbsp;</th>
			<th class="pageicon">&nbsp;</th>
		</tr>
	</thead>
	<tbody>
{foreach from=$items item=entry}
	{cycle values="row1,row2" assign='rowclass'}
		<tr class="{$rowclass}" onmouseover="this.className='{$rowclass}hover';" onmouseout="this.className='{$rowclass}';">
			<td>{$entry->attrib_set_id}</td>
			<td>{$entry->attrib_set_name}</td>
			<td>{$entry->count}</td>
			<td>{$entry->editlink}</td>
			<td>{$entry->deletelink}</td>
		</tr>
{/foreach}
	</tbody>
</table>
{/if}

<div class="pageoptions">
  {$add_link}&nbsp;{$copy_link}&nbsp;{$return_link}
</div>