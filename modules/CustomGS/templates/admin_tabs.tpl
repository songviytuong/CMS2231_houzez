{if $items|@count > 0}
{literal}
<script type=text/javascript>
	jQuery(document).ready(function($) {
		$(".sort_table_tab").tableDnD({
			onDragClass: "row1hover",
			onDrop: function(table, row) {
				var totalrows = jQuery(".sort_table_tab").find("tbody tr").size();

				jQuery(".sort_table_tab").find("tbody tr").removeClass();
				jQuery(".sort_table_tab").find("tbody tr:nth-child(2n+1)").addClass("row1");
				jQuery(".sort_table_tab").find("tbody tr:nth-child(2n)").addClass("row2");

				var rows = table.tBodies[0].rows;
				var sortstr = rows[0].id;
				for (var i=1; i<rows.length; i++) {
					sortstr += ","+rows[i].id;
				}
				var ajax_load = '<img src="../modules/CustomGS/images/loading.gif" alt="loading..." />';
				$('#loader').html(ajax_load).load('{/literal}{$ajax_url}&showtemplate=false&{$mod_id}{literal}sortseq='+sortstr);
				settingschanged = true;
			}
		});
		//$(".updown").hide();
	});
</script>
{/literal}
<div class="pageoverflow">
  <p class="pageoptions">{$newtablink}&nbsp;&nbsp;&nbsp;<span id="loader"> </span></p>
</div>
<div class="pageoverflow">
{$formstart}
<table class="pagetable sort_table_tab">
  <thead>
    <tr>
      <th class="pagew25">{$name}</th>
      <th class="pageicon updown">&nbsp;</th>
      <th class="pageicon updown">&nbsp;</th>
      <th class="pageicon">&nbsp;</th>
      <th class="pageicon">&nbsp;</th>
    </tr>
  </thead>
{foreach from=$items item=entry}
		{cycle values="row1,row2" assign=rowclass}
    <tr id="i{$entry->tabid}" class="{$rowclass}">
      <td>{$entry->name}</td>
      <td class="updown">{$entry->moveup}</td>
      <td class="updown">{$entry->movedown}</td>
      <td>{$entry->editlink}</td>
      <td>{$entry->deletelink}</td>
    </tr>
{/foreach}
</table>

{$formend}
</div>
{/if}

<div class="pageoverflow">
  <p class="pageoptions">{$newtablink}</p>
</div>