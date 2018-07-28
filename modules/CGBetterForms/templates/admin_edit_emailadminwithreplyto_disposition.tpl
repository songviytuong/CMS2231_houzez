<h3>{$mod->Lang('name_EmailAdminWithReplyTo')}</h3>

{form_start form_guid=$form_guid disp_guid=$guid editor_name=$editor_name}
<div class="pageoverflow">
  <input type="submit" name="{$actionid}submit" value="{$mod->Lang('submit')}"/>
  <input type="submit" name="{$actionid}cancel" value="{$mod->Lang('cancel')}" formnovalidate/>
  <input type="submit" name="{$actionid}reset_tpl" value="{$mod->Lang('reset_tpls')}" formnovalidate/>
</div>

<div class="c_full cf">
  <label class="grid_2">{$mod->Lang('prompt_email_field')}:</label>
  <div class="grid_9">
    <select name="{$actionid}fieldname" class="grid_12">
       {html_options options=$field_list selected=$handler->fieldname}
    </select>
    <p class="grid_12">{$mod->Lang('info_emailuseraddress')}</p>
  </div>
</div>
<div class="pageoverflow">
  <p class="pagetext">{$mod->Lang('prompt_csv_email_addresses')}:</p>
  <p class="pageinput">
     {cge_textarea prefix=$actionid name=addresses value=$handler->addresses rows=3}
  </p>
</div>
<div class="pageoverflow">
  <p class="pagetext">{$mod->Lang('prompt_email_subject_template')}:</p>
  <p class="pageinput">
     <input type="text" name="{$actionid}subjecttemplate" value="{$handler->subjecttemplate}" style="width: 97%;"/>
  </p>
</div>
<div class="pageoverflow">
  <p class="pagetext">{$mod->Lang('prompt_email_body_template')}:</p>
  <p class="pageinput">
     {cge_textarea prefix=$actionid name="bodytemplate" value=$handler->bodytemplate}
  </p>
</div>
{form_end}
{$tpl_help}
