<div class="pageoptions"><p class="pageoptions">
 <a href="{module_action_link action='addcategory' urlonly=1}">{cgimage image='icons/system/newobject.gif' alt=''} {$mod->Lang('addcategory')}</a>
</div>

{if count($categories)}
<table class="pagetable">
  <thead>
    <tr>
      <th width="5%">{$mod->Lang('category')}</th>
      <th>{$mod->Lang('name')}</th>
      <th>{$mod->Lang('description')}</th>
      <th class="pageicon">&nbsp;</th>
      <th class="pageicon">&nbsp;</th>
    </tr>
  </thead>
  <tbody>
    {foreach $categories as $entry}
      {module_action_link action=addcategory category_id=$entry.category_id urlonly=1 assign='edit_url'}
      <tr class="{cycle values="row1,row2"}">
        <td>{$entry.category_id}</td>
	<td><a href="{$edit_url}" title="{$mod->Lang('edit')}">{$entry.name}</a></td>
	<td>{$entry.description}</td>
	<td><a href="{$edit_url}">{cgimage image='icons/system/edit.gif' alt=$mod->Lang('edit')}</a></td>
	<td><a href="{module_action_link action=deletecategory category_id=$entry.category_id urlonly=1}">{cgimage image='icons/system/delete.gif' alt=$mod->Lang('delete')}</a></td>
      </tr>
    {/foreach}
  </tbody>
</table>
{/if}
