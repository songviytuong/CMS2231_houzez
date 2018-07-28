<h3>{$mod->Lang('edit_WebHookDisposition')}</h3>

{form_start form_guid=$form_guid disp_guid=$guid editor_name=$editor_name}
<div class="pageoverflow">
  <input type="submit" name="{$actionid}submit" value="{$mod->Lang('submit')}"/>
  <input type="submit" name="{$actionid}cancel" value="{$mod->Lang('cancel')}" formnovalidate/>
</div>

<div class="c_full cf">
  <label class="grid_2">{$mod->Lang('prompt_redirecturl_template')}:</label>
  <div class="grid_9">
     {cge_textarea prefix=$actionid name="tpl" value=$handler->tpl class="grid_12" rows=5}
     <p class="grid_12">{$mod->Lang('info_redirecturl_template')}</p>
  </div>
</div>
{form_end}
{$tpl_help}
