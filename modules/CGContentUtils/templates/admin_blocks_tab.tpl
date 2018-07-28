<div class="pageoptions">
{$addlink}
</div>

{if isset($data)}
<table class="pagetable" cellspacing="0">
  <thead>
    <tr>
      <th>{$mod->Lang('name')}</th>
      <th>{$mod->Lang('type')}</th>
      <th>{$mod->Lang('usage')}</th>
      <th class="pageicon"></th>
      <th class="pageicon"></th>
    </tr>
  </thead>
  <tbody>
  {foreach from=$data item='one'}
  <tr>
    <td><a href="{$one.edit_url}" title="{$mod->Lang('edit')}">{$one.name}</a></td>
    <td>{capture assign='tmp'}blocktype_{$one.type}{/capture}{$mod->Lang($tmp)}</td>
    <td>{$one.sampletag}</td>
    <td>{$one.editlink}</td>
    <td>{$one.deletelink}</td>
  </tr>
  {/foreach}
  </tbody>
</table>

{if count($data) > 5}<div class="pageoptions">{$addlink}</div>{/if}

{/if}
