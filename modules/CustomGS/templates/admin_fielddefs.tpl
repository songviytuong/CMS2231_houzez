{if $items|@count > 0}
<script type=text/javascript>
	var settingschanged = false;
	var ajax_load = '<img src="../modules/CustomGS/images/loading.gif" alt="loading..." />';
	var trueimg = '{$trueimage}';
	var falseimg = '{$falseimage}';
	jQuery(document).ready(function($) {  {$tabselectjs}{literal}
		$('.sort_table').tableDnD({
			onDragClass: "row1hover",
			onDrop: function(table, row) {
				var totalrows = jQuery(".sort_table").find("tbody tr").size();

				jQuery(".sort_table").find("tbody tr").removeClass();
				jQuery(".sort_table").find("tbody tr:nth-child(2n+1)").addClass("row1");
				jQuery(".sort_table").find("tbody tr:nth-child(2n)").addClass("row2");

				var rows = table.tBodies[0].rows;
				var sortstr = rows[0].id;
				for (var i=1; i<rows.length; i++) {
					sortstr += ","+rows[i].id;
				}
				$('#loader').html(ajax_load).load('{/literal}{$ajax_url}&showtemplate=false&{$mod_id}{literal}sortseq='+sortstr);
				settingschanged = true;
			}
		});
		$('.updown').hide();
		$('a.assigntab').click(function(event){
			event.preventDefault(); 
			var self = $(this);
			$.ajax({url: self.attr('href'), success: function(result){
				//alert(result);
				settingschanged = true;
				if(result == 1)
					self.html(trueimg);
				else
					self.html(falseimg);
			}});
			return false;
		});
		$('#page_tabs div').click(function(){
			if(settingschanged) location.href = '{/literal}{$refresh_url}&{$mod_id}{literal}active_tab=' + $(this).attr('id');
			return false;
		});
	});
</script>
{/literal}
<div class="pageoverflow">
  <p class="pageoptions">{$newfielddeflink}&nbsp;&nbsp;&nbsp;<span id="loader"> </span></p>
</div>
<div class="pageoverflow">
{$formstart}
<table class="pagetable sort_table">
  <thead>
    <tr>
      <th class="pagew25">{$name}</th>
      <th class="pagew25">{$type}</th>
      <th class="pagew25">{$smartyvar}</th>
      <th class="pageicon updown">&nbsp;</th>
      <th class="pageicon updown">&nbsp;</th>
      <th class="pageicon" colspan="4">{$tabselect}</th>
    </tr>
  </thead>
{$groupindent = ''}
{foreach from=$items item=entry}
	{cycle values="row1,row2" assign=rowclass}
	{if $entry->type == 'Fieldgroup start'}{$groupindent = '&nbsp;&nbsp;&nbsp;'}{/if}
    <tr id="i{$entry->fieldid}" class="{$rowclass}">
      <td>{if empty($entry->smartyvar)}<strong>{$entry->name}</strong>{else}{$groupindent}{$entry->name}{/if}</td>
      <td>{$entry->type}</td>
      <td><span class="smartyvar">{$entry->smartyvar}</span></td>
      <td class="updown">{$entry->moveup}</td>
      <td class="updown">{$entry->movedown}</td>
      <td style="text-align: center">{$entry->assigntab}</td>
      <td>{$entry->editlink}</td>
      <td>{$entry->copylink}</td>
      <td>{$entry->deletelink}</td>
    </tr>
	{if $entry->type == 'Fieldgroup end'}{$groupindent = ''}{/if}
{/foreach}
</table>

{$formend}
</div>
{/if}

<div class="pageoverflow">
  <p class="pageoptions">{$newfielddeflink}</p>
</div>