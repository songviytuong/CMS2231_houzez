<h3>{$mod->Lang('import_form')}</h3>
{form_start}
  <div class="c_full cf">
     <label class="grid_2">*{$mod->Lang('prompt_file')}:</label>
     <input type="file" name="cgbf_file" value="" required class="grid_9"/>
  </div>
  <div class="c_full cf">
     <input type="submit" name="{$actionid}submit" value="{$mod->Lang('submit')}"/>
  </div>
{form_end}