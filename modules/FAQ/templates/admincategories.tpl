<div class="pageoverflow">
  <p class="pageoptions">{$addlink}</p>
</div>

<table id="gtree" cellspacing="0" class="pagetable">
	<thead>
		<tr>
			<th>{$category}</th>
			<th>{$tag}</th>
			<th class="pageicon">{$entries}</th>
			<th class="pageicon">{$active}</th>
			<th class="pageicon">&nbsp;</th>
			<th class="pageicon">&nbsp;</th>
			<th class="pageicon">&nbsp;</th>
			<th class="pageicon">&nbsp;</th>
		</tr>
	</thead>
	<tbody>
{foreach from=$categories item=item}
	{cycle values="row1,row2" assign=rowclass}
		<tr class="{$rowclass}">
			<td class="tfile"><a href="{$editurl|replace:'QQ':$item.category_id}">{$item.category}</a></td>
			<td class="tfile">&#123;FAQ category='{$item.alias}'&#125;</td>
			<td class="pagepos" style="text-align:right">{$item.entries}</td>
			<td class="pagepos" style="text-align:center">{if $item.active}{$activetruelink|replace:'QQ':$item.category_id}{else}{$activefalselink|replace:'QQ':$item.category_id}{/if}</td>
      <td class="pagepos">{$item.moveup}</td>
      <td class="pagepos">{$item.movedown}</td>
			<td class="pagepos" style="text-align:center"><a href="{$editurl|replace:'QQ':$item.category_id}">{$editicon}</a></td>
			<td class="pagepos" style="text-align:center">{$deletelink|replace:'QQ':$item.category_id}</td>
		</tr>

{/foreach}
	</tbody>
</table>

<div class="pageoverflow">
  <p class="pageoptions">{$addlink}</p>
</div>
