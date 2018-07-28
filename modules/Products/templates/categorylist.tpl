<script>
$(function(){
    $('a.deletecat').click(function(ev){
        return confirm('{$mod->Lang('areyousure')}');
    });
})
</script>

<div class="pageoptions">
   <a href="{cms_action_url action='editcategory'}">{admin_icon icon='newfolder.gif'} {$mod->Lang('addcategory')}</a>
</div>

{if !empty($items)}
<table class="pagetable">
	<thead>
		<tr>
			<th>{$mod->Lang('category')}</th>
			<th class="pageicon">&nbsp;</th>
			<th class="pageicon">&nbsp;</th>
			<th class="pageicon">&nbsp;</th>
			<th class="pageicon">&nbsp;</th>
		</tr>
	</thead>
   <tbody>
     {foreach from=$items item=entry}
     <tr class="{cycle values='row1,row2'}">
        {cms_action_url action='editcategory' catid=$entry->id assign='edit_url'}
	<td><a href="{$edit_url}" title="{$mod->Lang('edit')}">{$entry->name}</a></td>
	<td><a href="{cms_action_url action=editcategoryfields catid=$entry->id}" title="{$mod->Lang('edit_category_fields',$entry->name)}">{admin_icon icon='attachment.gif'}</a></td>
	<td><a href="{cms_action_url action=copycategory catid=$entry->id}" title="{$mod->Lang('copy')}">{admin_icon icon='copy.gif'}</a></td>
	<td><a href="{$edit_url}" title="{$mod->Lang('edit')}">{admin_icon icon='edit.gif'}</a></td>
	<td><a class="deletecat" href="{cms_action_url action=deletecategory catid=$entry->id}" title="{$mod->Lang('delete')}">{admin_icon icon='delete.gif'}</a></td>
    </tr>
    {/foreach}
  </tbody>
</table>
{/if}
