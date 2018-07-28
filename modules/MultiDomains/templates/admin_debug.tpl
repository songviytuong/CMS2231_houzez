{$formstart}
{$tabto}
<div class="pageoverflow">
    <p class="pageoptions"><strong>{$debug_log}</strong></p>
</div>
<div class="pageoverflow">
    <table cellspacing="0" class="pagetable">
        <thead>
            <tr>
                <th>{$id}</th>
				<th>{$ip}</th>
				<th>{$fromurl}</th>
				<th>{$tourl}</th>
				<th>{$status}</th>
				<th>{$time}</th>
				<th class="pageicon">&nbsp;</th>
            </tr>
        </thead>
        {foreach from=$debugs item=entry}
            {cycle values="row1,row2" assign='rowclass'}
            <tr class="{$rowclass}" onmouseover="this.className='{$rowclass}hover';" onmouseout="this.className='{$rowclass}';">
                <td>{$entry->id}</td>
				<td>{$entry->ip}</td>
				<td>{$entry->fromurl}</td>
				<td>{$entry->tourl}</td>
				<td>{$entry->status}</td>
				<td>{$entry->created}</td>
				<td>{$entry->deletelink}</td>
            </tr>
        {/foreach}
    </table>
</div>
<div class="pageoverflow">
    <p class="pageoptions">{$deletealllink}</p>
	<p class="pageoptions">&nbsp;</p>
</div>
{$formend}