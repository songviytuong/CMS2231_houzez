<h3>{$mod->Lang('edit_ddfile_disposition')}</h3>

{form_start form_guid=$form_guid guid=$guid editor_name=$editor_name}
<div class="pageoverflow">
  <input type="submit" name="{$actionid}submit" value="{$mod->Lang('submit')}"/>
  <input type="submit" name="{$actionid}cancel" value="{$mod->Lang('cancel')}" formnovalidate/>
  <input type="submit" name="{$actionid}reset_tpl" value="{$mod->Lang('reset_tpls')}" formnovalidate/>
</div>

<div class="c_full cf">
  <label class="grid_2">{$mod->Lang('prompt_field')}:</label>
  <div class="grid_9">
    <select name="{$actionid}field" class="grid_12" required>
      {html_options values=$select_fields output=$select_fields selected=$handler->field}
    </select>
    <br/>{$mod->Lang('info_ddfile_field')}
  </div>
</div>
<div class="c_full cf">
  <label class="grid_2">{$mod->Lang('prompt_ddfile_folder')}:</label>
  <div class="grid_9">
     <input class="grid_12" name="{$actionid}folder" value="{$handler->folder}">
     <br/>{$mod->Lang('info_ddfile_folder')}
  </div>
</div>
<div class="pageoverflow">
  <p class="pagetext">{$mod->Lang('prompt_hdrtemplate')}:</p>
  <p class="pageinput">
     {cge_textarea prefix=$actionid name=headertemplate value=$handler->headertemplate}
  </p>
</div>
<div class="pageoverflow">
  <p class="pagetext">{$mod->Lang('prompt_entrytemplate')}:</p>
  <p class="pageinput">
     {cge_textarea prefix=$actionid name=entrytemplate value=$handler->entrytemplate}
  </p>
</div>
{form_end}
{$tpl_help}
