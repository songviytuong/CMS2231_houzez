
<h2>Domains</h2>
<table cellspacing="1" cellpadding="3" border="0" bgcolor="#aaaaaa">
	<thead>
		<tr>
			<th bgcolor="#cccccc">{$month}</th>
			<th bgcolor="#cccccc">{$url}</th>
			<th bgcolor="#cccccc">{$page}</th>
			<th bgcolor="#cccccc">{$visits}</th>
			<th bgcolor="#cccccc">{$searchengine}</th>
			<th bgcolor="#cccccc">{$keyword}</th>
			<th bgcolor="#cccccc">{$referer}</th>
		</tr>
	</thead>
	{foreach from=$domains item=entry}
		{cycle values="eeeeee,dddddd" assign='rowclass'}
		<tr>
			<td bgcolor="#{$rowclass}">{$entry.value}</td>
			<td bgcolor="#{$rowclass}">{$entry.url}</td>
			<td bgcolor="#{$rowclass}">{$entry.page}</td>
			<td bgcolor="#{$rowclass}">{$entry.visits}</td>
			<td bgcolor="#{$rowclass}">{$entry.searchengine}</td>
			<td bgcolor="#{$rowclass}">{$entry.keyword}</td>
			<td bgcolor="#{$rowclass}">{$entry.referer}</td>
		</tr>
	{/foreach}
</table>
