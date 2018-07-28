{if isset($categories)}
<table class="pagetable" cellspacing="0">
  <thead>
   <tr>
    <th>{$mod->Lang('id')}:</th>
    <th>{$mod->Lang('name')}:</th>
    <th>{$mod->Lang('icon')}:</th>
    <th class="pageicon"></th>
    <th class="pageicon"></th>
   </tr>
  </thead>
  <tbody>
  {foreach from=$categories item='cat'}
    <tr>
     <td>{$cat->get_id()}</td>
     <td><a href="{$cat->edit_url}">{$cat->get_name()}</a></td>
     <td align="center">{assign var='tmp' value=$cat->get_icon()}<img class="sytemicon" alt="{$tmp}" src="../{$iconsbyname.$tmp.url}"/></td>
     <td>{$cat->edit_link}</td>
     <td>{$cat->delete_link}</td>
    </tr>
  {/foreach}
  </tbody>
</table>
{/if}

<div class="pageoverflow">
  <p class="pageoptions">
    {$add_link}
  </p>
</div>