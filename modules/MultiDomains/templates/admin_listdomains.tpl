<div class="pageoverflow">
    <table cellspacing="0" class="pagetable">
        <thead>
            <tr>
                <th>{$id}</th>
				<th>{$domain}</th>
				{if $devdomain_active=='1'}<th>{$devdomain}</th>{/if}
				<th>{$page}</th>
                <th>{$active}</th>
				<th>{$root}</th>
				{*<th>{$standard}</th>*}
                <th class="pageicon">&nbsp;</th>
                <th class="pageicon">&nbsp;</th>
            </tr>
        </thead>
        {foreach from=$items item=entry}
            {cycle values="row1,row2" assign='rowclass'}
            <tr class="{$rowclass}">
                <td>{$entry->id}</td>
				<td>{$entry->name}&nbsp;<a href="{$entry->vurl}" title="{$view}" target="_blank">{$viewicon}</a></td>
				{if $devdomain_active=='1'}<td>{$entry->devdomain}&nbsp;<a href="{$entry->vdevurl}" title="{$view}" target="_blank">{$viewicon}</a></td>{/if}
				<td>{$entry->page}</td>
				<td>{$entry->active}</td>
				<td>{$entry->root}</td>
                {*<td>{$entry->default}</td>*}
                <td>{$entry->editlink}</td>
                <td>{$entry->deletelink}</td>
            </tr>
			<tr class="{$rowclass}"><td>&nbsp;</td><td colspan="{if $devdomain_active=='1'}5{else}4{/if}" style="color:#999999;">{$entry->help}<strong>{$entry->pages}</strong></td><td colspan="2">&nbsp;</td></tr>
        {/foreach}
    </table>
</div>
<div class="pageoverflow">
    <p class="pageoptions">{$newdomainlink}</p>
</div>