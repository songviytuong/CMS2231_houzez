<p class="pageoverflow">
  <a href="{cms_action_url action=admin_edit_hierarchy_item}">{admin_icon icon='newobject.gif'} {$mod->Lang('add_hierarchy_item')}</a>
  {$reorder_link|default:''}
</p>

{if count($entries)}
<div class="pageoverflow">
  <table class="pagetable" cellspacing="0">
    <thead>
      <tr>
        <th width="2%">{$mod->Lang('id')}</th>
        <th>{$mod->Lang('hierarchy')}</th>
        <th class="pageicon">&nbsp;</th>
        <th class="pageicon">&nbsp;</th>
        <th class="pageicon">&nbsp;</th>
      </tr>
    </thead>
    <tbody>
    {foreach from=$entries item='oneentry'}
      {cycle values="row1,row2" assign='rowclass'}
      <tr class="{$rowclass}" onmouseover="this.className='{$rowclass}hover';" onmouseout="this.className='{$rowclass}';">
	<td>{$oneentry.id}</td>
        <td>{cgrepeat text='&nbsp;&gt;&nbsp;' count=$oneentry.depth}<a href="{$oneentry.edit_url}" title="{$mod->Lang('edit_hierarchy_item')}">{$oneentry.name}</a></td>
        <td {if $oneentry.ajax == true}class="init-ajax-toggle"{/if}>{$oneentry.importseo}</td>
        <td>{$oneentry.edit_link}</td>
        <td>{$oneentry.delete_link}</td>
      </tr>
    {/foreach}
    </tbody>
  </table>
</div>
{/if}
