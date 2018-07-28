{* admin panel template *}
<div class="c_full cf">
  <input type="submit" name="{$actionid}submit" value="{$mod->Lang('submit')}"/>
</div>

<fieldset>
  <legend>{$mod->Lang('hdr_uploading')}</legend>
  <div class="information">{$mod->Lang('info_uploading')}</div>
  <div class="c_full cf">
    <label class="grid_2">{$mod->Lang('prompt_allowedtoupload')}:</label>
    <div class="grid_9">
      <input class="grid_12" name="{$actionid}alloweduploadfiles" value="{$alloweduploadfiles}" maxlength="255"/>
      <p>{$mod->Lang('info_allowed_upload_filetypes')}</p>
    </div>
  </div>
</fieldset>

<fieldset>
  <div class="information">{$mod->Lang('info_error_template')}</div>
  <div class="c_full cf">
    <label class="grid_2">{$mod->Lang('error_template')}:</label>
    <div class="grid_9">
      {cge_textarea prefix=$actionid name=error_template value=$error_template syntax=1 class="grid_12"}
      <p>
        <input type="submit" name="{$actionid}resettofactory" value="{$mod->Lang('resettofactory')}"/>
      </p>
    </div>
  </div>
</fieldset>

<fieldset class="c_full cf">
  <label class="grid_2">{$mod->Lang('prompt_memory_limit')}:</label>
  <div class="grid_9">
    <label class="grid_12"><input type="text" name="{$actionid}assume_memory_limit" value="{$assume_memory_limit}" maxlength="3"/>&nbsp;MB</label>
    <p>{$mod->Lang('info_memory_limit')}</p>
  </div>
</fieldset>
