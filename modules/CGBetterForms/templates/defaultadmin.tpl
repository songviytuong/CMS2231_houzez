<div class="pageoptions">
  <a href="{cms_action_url action=admin_edit_form}">{admin_icon icon='newobject.gif'} {$mod->Lang('add_new_form')}</a>
  <a href="{cms_action_url action=admin_import_form}">{admin_icon icon='import.gif'} {$mod->Lang('import_form')}</a>
</div>

{if !empty($forms) && count($forms)}
<table class="pagetable">
  <thead>
    <tr>
      <th>{$mod->Lang('id')}</th>
      <th>{$mod->Lang('name')}</th>
      <th>{$mod->Lang('tag')}</th>
      <th class="pageicon"></th>
      <th class="pageicon"></th>
      <th class="pageicon"></th>
    </tr>
  </thead>
  <tbody>
    {foreach $forms as $id => $name}
      {cms_action_url action=admin_edit_form form=$id assign='edit_url'}
      <tr class="{cycle values='row1,row2'}">
        <td><a href="{$edit_url}" title="{$mod->Lang('edit')}">{$id}</a></td>
	<td><a href="{$edit_url}" title="{$mod->Lang('edit')}">{$name}</a></td>
	<td>{ldelim}CGBetterForms form=&quot;{$name}&quot;{rdelim}</td>
	<td><a href="{cms_action_url action=admin_export_form form=$id}" title="{$mod->Lang('export_form')}">{admin_icon icon='export.gif'}</a></td>
	<td><a href="{$edit_url}" title="{$mod->Lang('edit')}">{admin_icon icon='edit.gif'}</a></td>
	<td><a href="{cms_action_url action=admin_delete_form form=$id}" title="{$mod->Lang('delete')}">{admin_icon icon='delete.gif'}</a></td>
      </tr>
    {/foreach}
  </tbody>
</table>

{/if}