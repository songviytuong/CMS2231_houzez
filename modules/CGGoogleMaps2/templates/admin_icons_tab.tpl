{if isset($icons)}
<table class="pagetable cms_sortable tablesorter">
  <thead>
    <tr>
      <th width="3%">{$mod->Lang('id')}</th>
      <th width="3%" class="{literal}{sorter: false}{/literal}">&nbsp;</th>
      <th>{$mod->Lang('name')}</th>
      <th width="5%" class="{literal}{sorter: false}{/literal}" style="margin-left: -20px;">{$mod->Lang('default')}</th>
      <th width="2%" class="pageicon {literal}{sorter: false}{/literal}" style="margin: 0; padding-right: 2px;">&nbsp;</th>
      <th width="2%" class="pageicon {literal}{sorter: false}{/literal}" style="margin: 0; padding-right: 2px;">&nbsp;</th>
    </tr>
  </thead>
  <tbody>
  {foreach from=$icons item='one'}
    <tr>
      <td><a href="{$one.edit_url}" title="{$mod->Lang('edit_icon')}">{$one.id}</td>
      <td halign="right"><img src="../{$one.url}" width="16" height="16" alt=""/></td>
      <td><a href="{$one.edit_url}" title="{$mod->Lang('edit_icon')}">{$one.name}</td>
      <td align="center">
       {if !isset($one.default_url)}
         {cgimage image='icons/system/true.gif' alt=$mod->Lang('default')}
       {else}
         <a href="{$one.default_url}" title="{$mod->Lang('make_default')}">{cgimage image='icons/system/false.gif' alt=$mod->Lang('make_default')}</a>
       {/if}
      </td>
      <td><a href="{$one.edit_url}" title="{$mod->Lang('edit_icon')}">{cgimage image='icons/system/edit.gif' alt=$mod->Lang('edit')}</a></td>
      <td>{if isset($one.default_url)}<a href="{$one.delete_url}" onclick="return confirm('{$mod->Lang('ask_delete_icon')}');" title="{$mod->Lang('delete_icon')}">{cgimage image='icons/system/delete.gif' alt=$mod->Lang('delete')}</a>{/if}</td>
    </tr>
  {/foreach}
  </tbody>
</table>

<div class="pageoverflow">
  <p class="pageoptions">
    {module_action_link module='CGGoogleMaps' action='admin_edit_icon' image='icons/system/newobject.gif' text=$mod->Lang('add_icon')}
    {module_action_link module='CGGoogleMaps' action='admin_reset_icons' image='icons/system/newfolder.gif' text=$mod->Lang('reset_icons') confmessage=$mod->Lang('ask_reset_icons')}
  </p>
</div>

{/if}