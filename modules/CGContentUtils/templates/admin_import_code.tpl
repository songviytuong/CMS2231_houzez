<h3>{$mod->Lang('import_code')}</h3>
<fieldset class="pageoverflow" style="color:black;padding:5px;background-color:white;border:2px dotted orange">
{$mod->Lang('info_final_import_code')}
</fieldset>

{$formstart}
<input type="hidden" name="{$actionid}import_data" value="{$import_data}"/>
<table class="pagetable" cellspacing="0">
  <thead>
    <tr>
      <th>{$mod->Lang('type')}</th>
      <th>{$mod->Lang('module')}</th>
      <th>{$mod->Lang('name')}</th>
      <th>{$mod->Lang('import_name')}</th>
    </tr>
  </thead>
  <tbody>
  {foreach from=$import_items item='row'}
    {assign var='overwrite' value=0}
    {if $row.name == $row.new_name|default:''}{assign var='overwrite' value=1}{/if}
    <tr{if $overwrite == 1} style="background-color: yellow;"{/if}>
      <td>{$mod->Lang($row.type)}</td>
      <td>{if !empty($row.module)}{$row.module}{/if}</td>
      <td>{$row.name}</td>
      <td>{$row.new_name|default:''}</td>
    </tr>
  {/foreach}
  </tbody>
</table>
<div class="pageoverflow">
  <p class="pagetext">{$mod->Lang('ask_really_import')}</p>
  <p class="pageinput">
    <input type="checkbox" name="{$actionid}confirm_import" value="1"/>
  </p>
</div>
<div class="pageoverflow">
  <p class="pagetext"></p>
  <p class="pageinput">
    <input type="submit" name="{$actionid}do_import" value="{$mod->Lang('import')}"/>
    <input type="submit" name="{$actionid}cancel" value="{$mod->Lang('cancel')}"/>
  </p>
</div>
{$formend}