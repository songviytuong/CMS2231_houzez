{if isset($files)}
<table id="file_list" class="pagetable" cellspacing="0">
  <thead>
   <tr>
     <th style="width: 90px;">{$mod->Lang('thumbnail')}</th>
     <th align="left">{$mod->Lang('name')}</th>
     <th class="pageicon"></th>
   </tr>
  </thead>
  <tbody>
  {foreach from=$files item='onefile' name='files'}
  <tr id="file_{$smarty.foreach.files.index}">
    <td valign="center" ><a style="bordeR: 1px solid black;" class="fancybox" href="{CGSmartImage src1=$base_dir src2=$onefile noembed=1 width=500 height=500 notag=1}">{CGSmartImage src1=$base_dir src2=$onefile width=80 height=80 noembed=1}</a></td>
    <td>{$onefile}</td>
    <td><a class="delete" href="{$onefile}"><img src="{$trashcan}" alt=""/></a></td>
  </tr>
  {/foreach}
  </tbody>
</table>
{else}
<p>No files found</p>
{/if}