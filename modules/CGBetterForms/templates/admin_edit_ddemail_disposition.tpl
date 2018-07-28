<h3>{$mod->Lang('edit_ddemail_disposition')}</h3>

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
      {html_options options=$select_fields selected=$handler->field}
    </select>
    <p class="grid_11">{$mod->Lang('info_ddemail_field')}</p>
  </div>
</div>
<div class="c_full cf">
  <label class="grid_2">{$mod->Lang('prompt_dflt_email_address')}:</label>
  <div class="grid_9">
     <input type="email" value="{$handler->dflt_address}" name="{$actionid}dflt_address" maxlength="255" class="grid_12"/>
     <p class="grid_11">{$mod->Lang('info_dflt_email_address')}</p>
  </p>
</div>
<div class="c_full cf">
  <label class="grid_2">{$mod->Lang('prompt_ddemail_value_map')}:</label>
  <div class="grid_9">
     {cge_textarea prefix=$actionid name=value_map value=$handler->value_map rows=5 class="grid_12"}
     <p class="grid_11">{$mod->Lang('info_ddemail_value_map')}</p>
  </div>
</div>
<div class="c_full cf">
  <label class="grid_2">{$mod->Lang('prompt_email_subject_template')}:</label>
  <div class="grid_9">
    {cge_textarea prefix=$actionid name=subjecttemplate value=$handler->subjecttemplate rows=2 class=grid_12}
  </div>
</div>
<div class="pageoverflow">
  <p class="pagetext">{$mod->Lang('prompt_email_body_template')}:</p>
  <p class="pageinput">
     {cge_textarea prefix=$actionid name=bodytemplate value=$handler->bodytemplate}
  </p>
</div>
{form_end}
{$tpl_help}
