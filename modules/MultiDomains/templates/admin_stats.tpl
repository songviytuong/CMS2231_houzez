<div class="pageoverflow">

	{if $stats_daily == 1}
	<h2>{$last_day}</h2>
	<table cellspacing="0" class="pagetable">
        <thead>
            <tr>
				<th>{$domain}</th>
				<th>{$page}</th>
				<th>{$visits}</th>
                <th>{$searchengine}</th>
                <th>{$keyword}</th>
                <th>{$referer}</th>
            </tr>
        </thead>
        {foreach from=$days_domains item=entry}
            {cycle values="row1,row2" assign='rowclass'}
            <tr class="{$rowclass}" onmouseover="this.className='{$rowclass}hover';" onmouseout="this.className='{$rowclass}';">
				<td>{$entry->url}</td>
				<td>{$entry->page}</td>
				<td>{$entry->visits}</td>
				<td>{$entry->searchengine}</td>
                <td>{$entry->keyword}</td>
                <td>{$entry->referer}</td>
            </tr>
        {/foreach}
    </table>
	{/if}

	<h2>{$last_month}</h2>
	<table cellspacing="0" class="pagetable">
        <thead>
            <tr>
				<th>{$domain}</th>
				<th>{$page}</th>
				<th>{$visits}</th>
                <th>{$searchengine}</th>
                <th>{$keyword}</th>
                <th>{$referer}</th>
            </tr>
        </thead>
        {foreach from=$months_domains item=entry}
            {cycle values="row1,row2" assign='rowclass'}
            <tr class="{$rowclass}" onmouseover="this.className='{$rowclass}hover';" onmouseout="this.className='{$rowclass}';">
				<td>{$entry->url}</td>
				<td>{$entry->page}</td>
				<td>{$entry->visits}</td>
				<td>{$entry->searchengine}</td>
                <td>{$entry->keyword}</td>
                <td>{$entry->referer}</td>
            </tr>
        {/foreach}
    </table>

	<h2>{$last_year}</h2>
	<table cellspacing="0" class="pagetable">
        <thead>
            <tr>
				<th>{$domain}</th>
				<th>{$page}</th>
				<th>{$visits}</th>
                <th>{$searchengine}</th>
                <th>{$keyword}</th>
                <th>{$referer}</th>
            </tr>
        </thead>
        {foreach from=$years_domains item=entry}
            {cycle values="row1,row2" assign='rowclass'}
            <tr class="{$rowclass}" onmouseover="this.className='{$rowclass}hover';" onmouseout="this.className='{$rowclass}';">
				<td>{$entry->url}</td>
				<td>{$entry->page}</td>
				<td>{$entry->visits}</td>
				<td>{$entry->searchengine}</td>
                <td>{$entry->keyword}</td>
                <td>{$entry->referer}</td>
            </tr>
        {/foreach}
    </table>

</div>