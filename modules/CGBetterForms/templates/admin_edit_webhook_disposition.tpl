<h3>{$mod->Lang('edit_WebHookDisposition')}</h3>

{form_start form_guid=$form_guid disp_guid=$guid editor_name=$editor_name}
<div class="pageoverflow">
  <input type="submit" name="{$actionid}submit" value="{$mod->Lang('submit')}"/>
  <input type="submit" name="{$actionid}cancel" value="{$mod->Lang('cancel')}" formnovalidate/>
  <input type="submit" name="{$actionid}reset_tpl" value="{$mod->Lang('reset_tpls')}" formnovalidate/>
</div>

<div class="c_full cf">
  <label class="grid_2">{$mod->Lang('prompt_webhook_url')}:</label>
  <div class="grid_9">
     <input class="grid_12" type="text" name="{$actionid}url" value="{$handler->url}" required/>
     <p class="grid_12">{$mod->Lang('info_webhook_url')}</p>
  </div>
</div>
<div class="c_full cf">
  <label class="grid_2">{$mod->Lang('prompt_webhook_extravars')}:</label>
  <div class="grid_9">
     {cge_textarea prefix=$actionid name="extrapostvars" value=$handler->extrapostvars class="grid_12"}
     <p class="grid_12">{$mod->Lang('info_webhook_extravars')}</p>
  </div>
</div>
{form_end}