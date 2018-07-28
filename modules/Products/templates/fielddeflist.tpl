<script>
$(function(){
  $('#fieldlist').css('cursor','move');
  $('#fieldlist').sortable({
      cursor: 'move',
      stop: function(event,ui) {
         $('#save_order,#revert_order').show();
      }
  });
  $('#revert_order').click(function(){
      window.location.href = window.location.href+'&m1_cg_activetab=fielddefs';
  });
  $('#save_order').click(function(){
    var id_order = [];
    $('#fieldlist > tr').each(function(){
       var id = $(this).data('id');
       if( id < 1 ) return;
       id_order.push( id );
    });
    $.ajax({
       url: '{cms_action_url action=admin_ajax_orderfields forjs=1}&showtemplate=false',
       method: 'POST',
       data: {
           '{$actionid}idlist' : id_order,
       }
    }).done(function(){
       window.location.href = window.location.href+'&m1_cg_activetab=fielddefs';
    }).fail(function(){
       alert('fail');
    })
  })
})
</script>

<div class="information" style="display: block;">{$mod->Lang('info_fielddefs_tab')}</div>
<div class="pageoptions">
  <a href="{cms_action_url action=editfielddef}">{admin_icon icon='newobject.gif'} {$mod->Lang('addfielddef')}</a>
  {if $itemcount}
      <button id="save_order" style="display: none;"/>{$mod->Lang('save')}</button>
      <button id="revert_order" style="display: none;"/>{$mod->Lang('revert')}</button>
  {/if}
</div>

{if $itemcount > 0}
<table cellspacing="0" class="pagetable">
	<thead>
		<tr>
			<th>{$mod->Lang('id')}</th>
			<th>{$fielddeftext}</th>
			<th>{$typetext}</th>
			<th class="pageicon">&nbsp;</th>
			<th class="pageicon">&nbsp;</th>
		</tr>
	</thead>
	<tbody id="fieldlist">
{foreach from=$items item=entry}
	{cycle values="row1,row2" assign='rowclass'}
		<tr data-id="{$entry->id}" class="{$rowclass}" onmouseover="this.className='{$rowclass}hover';" onmouseout="this.className='{$rowclass}';">
		        <td>{$entry->id}</td>
			<td><a href="{$entry->edit_url}" title="{$mod->Lang('edit')}">{$entry->name}</a></td>
			<td>{assign var='tmp' value=$entry->type}{$fieldtypes.$tmp}</td>
			<td><a href="{$entry->edit_url}">{cgimage image='icons/system/edit.gif' alt=$mod->Lang('edit')}</a></td>
			<td>{$entry->deletelink}</td>
		</tr>
{/foreach}
	</tbody>
</table>
{/if}
