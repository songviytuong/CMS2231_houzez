<h3>{$mod->Lang('edit_category_fields',$category.name)}</h3>

<p class="pageoverflow">
  <a href="{cms_action_url action='addcategoryfield' catid=$catid}">{admin_icon icon='newobject.gif'} {$mod->Lang('add_category_field2')}</a>
  <a href="{cms_action_url action='editcategory' catid=$catid}">{admin_icon icon='back.gif'} {$mod->Lang('return')}</a>
</p>

{if isset($fields) && count($fields)}
<div class="pageoverflow">
<table cellspacing="0" class="pagetable">
  <thead>
    <tr>
      <th>{$mod->Lang('name')}</th>
      <th>{$mod->Lang('type')}</th>
      <th>{$mod->Lang('value')}</th>
      <th class="pageicon">&nbsp;</th>
      <th class="pageicon">&nbsp;</th>
      <th class="pageicon">&nbsp;</th>
      <th class="pageicon">&nbsp;</th>
    </tr>
  </thead>
  <tbody>
  {foreach $fields as $onefield }
     {cycle values="row1,row2" assign='rowclass'}
     <tr class="{$rowclass}">
       {module_action_link action=addcategoryfield catid=$category.id fldname=$onefield.field_name urlonly=1 assign='edit_url'}
       {module_action_link action=deletecategoryfield catid=$category.id fldname=$onefield.field_name urlonly=1 assign='del_url'}
       <td><a href="{$edit_url}" title="{$mod->Lang('edit')}">{$onefield.field_name}</a></td>
       <td>{$onefield.field_type}</td>
       <td>{$onefield.field_value|strip_tags|summarize:10}</td>
       <td>
         {if $onefield.field_order > 1}
	   <a href="{module_action_link action=movecategoryfield dir=up catid=$category.id fldname=$onefield.field_name urlonly=1}">{cgimage image='icons/system/sort_up.gif' alt=$mod->Lang('move_up')}</a>
	 {/if}
       </td>
       <td>
         {if !$onefield@last}
	   <a href="{module_action_link action=movecategoryfield dir=down catid=$category.id fldname=$onefield.field_name urlonly=1}">{cgimage image='icons/system/sort_down.gif' alt=$mod->Lang('move_down')}</a>
	 {/if}
       </td>
       <td><a href="{$edit_url}" title="{$mod->Lang('edit')}">{cgimage image='icons/system/edit.gif' alt=''}</a></td>
       <td><a href="{$del_url}" title="{$mod->Lang('delete')}">{cgimage image='icons/system/delete.gif' alt=''}</a></td>
     </tr>
  {/foreach}
  </tbody>
</table>
</div>
{/if}
