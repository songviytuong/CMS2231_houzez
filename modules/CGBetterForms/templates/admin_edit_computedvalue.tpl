<h3>{$mod->Lang('edit_computed_value')}</h3>

{form_start form_guid=$form_guid guid=$guid editor_name=$editor_name}
<div class="pageoverflow">
  <input type="submit" name="{$actionid}submit" value="{$mod->Lang('submit')}"/>
  <input type="submit" name="{$actionid}cancel" value="{$mod->Lang('cancel')}" formnovalidate/>
</div>

<div class="c_full cf">
  <label class="grid_2">{$mod->Lang('prompt_field')}:</label>
  <div class="grid_9">
    <select name="{$actionid}fieldname" class="grid_12" required>
      {html_options options=$fields selected=$validation->fieldName}
    </select>
    <p class="grid_12">{$mod->Lang('info_computed_value_field')}</p>
  </div>
</div>

<div class="c_full cf">
  <label class="grid_2">{$mod->Lang('prompt_template')}:</label>
  <div class="grid_9">
    <textarea class="grid_12" rows="5" name="{$actionid}template">{$validation->template}</textarea>
  </div>
</div>
{form_end}
{$tpl_help}
