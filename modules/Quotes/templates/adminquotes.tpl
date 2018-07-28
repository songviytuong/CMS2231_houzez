{if $itemcount > 0}
	<table class="pagetable">
		<thead>
			<tr>
				<th class="pageicon">#</th>
				<th>{$quotes}</th>
				<th>{$quoteauthor}</th>
				<th>{$quotegroups}</th>
				<th>{$quotetype}</th>
				<th>{$quoteexposures}</th>
				<th class="pageicon"></th>
				<th class="pageicon"></th>
				<th class="pageicon"></th>
			</tr>
		</thead>
		<tbody>
		{foreach from=$items item=entry}
			{cycle values="row1,row2" assign=rowclass}
			<tr class="{$rowclass}" onmouseover="this.className='{$rowclass}hover';" onmouseout="this.className='{$rowclass}';">
				<td>{$entry->id}</td>
				<td>{$entry->content}</td>
				<td>{$entry->quoteauthor}</td>
				<td>{$entry->quotegroups}</td>
				<td>{$entry->quotetype}</td>
				<td>{$entry->exposures}</td>
				<td>{$entry->editlink}</td>
				<td>{$entry->copylink}</td>
				<td>{$entry->deletelink}</td>
			</tr>
		{/foreach}
		</tbody>
	</table>
{else}
	<h4>{$noquotestext}</h4>
{/if}

<div class="pageoptions">
	<p class="pageoptions">{$addform}</p>
</div>