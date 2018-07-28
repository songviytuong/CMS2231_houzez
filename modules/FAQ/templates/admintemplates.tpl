<div class="pageoverflow">
  <p class="pageoptions">{$newtemplatelink}</p>
</div>
<div class="pageoverflow">
<table cellspacing="0" class="pagetable">
  <thead>
    <tr>
      <th class="pagew50">{$nameprompt}</th>
      <th class="pagew25">{$typeprompt}</th>
      <th class="pagew10">{$defaultprompt}</th>
      <th class="pageicon">&nbsp;</th>
      <th class="pageicon">&nbsp;</th>
      <th class="pageicon">&nbsp;</th>
    </tr>
  </thead>
{foreach from=$items item=entry}
   <tr class="{$entry->rowclass}">
     <td>{$entry->name}</td>
     <td>{$entry->type}</td>
     <td>{$entry->default}</td>
     <td>{$entry->editlink}</td>
     <td>{$entry->copylink}</td>
     <td>{$entry->deletelink}</td>
   </tr>
{/foreach}
</table>
</div>
<div class="pageoverflow">
  <p class="pageoptions">{$newtemplatelink}</p>
</div>

