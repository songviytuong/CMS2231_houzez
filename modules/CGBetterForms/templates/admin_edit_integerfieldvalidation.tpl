<h3>{$mod->Lang('edit_integer_fieldvalidation')}</h3>

{form_start form_guid=$form_guid guid=$guid editor_name=$editor_name}
<div class="pageoverflow">
  <input type="submit" name="{$actionid}submit" value="{$mod->Lang('submit')}"/>
  <input type="submit" name="{$actionid}cancel" value="{$mod->Lang('cancel')}" formnovalidate/>
</div>

<div class="c_full cf">
  <label class="grid_2">{$mod->Lang('prompt_field')}:</label>
  <select name="{$actionid}fieldname" class="grid_8" required>
    {html_options options=$fields selected=$validation->fieldName}
  </select>
</div>
<div class="c_full cf">
  <label class="grid_2">{$mod->Lang('prompt_minvalue')}:</label>
  <input type="text" name="{$actionid}minValue" class="grid_9" maxlength="10" value="{$validation->minVal}"/>
</div>
<div class="c_full cf">
  <label class="grid_2">{$mod->Lang('prompt_maxvalue')}:</label>
  <input type="text" name="{$actionid}maxValue" class="grid_9" maxlength="10" value="{$validation->maxVal}"/>
</div>
{form_end}