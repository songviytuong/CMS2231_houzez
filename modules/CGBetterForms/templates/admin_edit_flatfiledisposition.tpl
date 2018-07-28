<h3>{$mod->Lang('edit_csv_disposition')}</h3>

{form_start form_guid=$form_guid disp_guid=$guid editor_name=$editor_name}
<div class="pageoverflow">
  <input type="submit" name="{$actionid}submit" value="{$mod->Lang('submit')}"/>
  <input type="submit" name="{$actionid}cancel" value="{$mod->Lang('cancel')}" formnovalidate/>
  <input type="submit" name="{$actionid}reset_tpl" value="{$mod->Lang('reset_tpls')}" formnovalidate/>
</div>

<div class="c_full cf">
  <label class="grid_2">{$mod->Lang('prompt_filename')}:</label>
  <input class="grid_9" name="{$actionid}filename" value="{$handler->filename}" required/>
  <br/><br/><span class="grid_2">&nbsp;</span><span>{$mod->Lang('info_flatfile_filename')}</span>
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
