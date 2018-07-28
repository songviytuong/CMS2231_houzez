<fieldset>
  <legend>{$fielddef->ModLang('options')}</legend>  
  <div class="pageoverflow">
    <p class="pagetext">{$fielddef->ModLang('allowed')}:</p>
    <p class="pageinput">
      <input type="text" name="{$actionid}custom_input[allowed]" value="{$fielddef->GetOptionValue('allowed', 'pdf,gif,jpeg,jpg')}" />
    </p>
    <p class="pagetext"><div class="information">{$fielddef->ModLang('fielddef_JMFP_allow_help')}</div></p>
  </div>
  <hr>
  <div class="pageoverflow">
    <p class="pagetext">{$fielddef->ModLang('dir')}:</p>
    <p class="pageinput">
      <input type="text" name="{$actionid}custom_input[dir]" value="{$fielddef->GetOptionValue('dir','images')}" />
    </p>
    <p class="pagetext"><div class="information">{$fielddef->ModLang('fielddef_JMFP_dir_help')}</div></p>
  </div>
  <hr>
  <div class="pageoverflow">
    <p class="pagetext">{$fielddef->ModLang('exclude_prefix')}:</p>
    <p class="pageinput">
      <input type="text" name="{$actionid}custom_input[exclude_prefix]" value="{$fielddef->GetOptionValue('exclude_prefix')}" />
  </p>
  <p class="pagetext"><div class="information">{$fielddef->ModLang('fielddef_JMFP_exclude_prefix_help')}</div></p>
  </div>
  <hr>
  <div class="pageoverflow">
    <p class="pagetext">{$fielddef->ModLang('fielddef_JMFilePicker_filebrowser')}:</p>
    <p class="pageinput">
      <input type="hidden" name="{$actionid}custom_input[filebrowser]" value="0" />
      <input type="checkbox" name="{$actionid}custom_input[filebrowser]" value="1"{if $fielddef->GetOptionValue('filebrowser')}checked="checked"{/if} />
  </p>
  <p class="pagetext"><div class="information">{$fielddef->ModLang('fielddef_JMFP_filebrowser_help')}</div></p>
  </div>
  <hr>
  <div class="pageoverflow">
    <p class="pagetext">{$fielddef->ModLang('fielddef_JMFilePicker_image')}:</p>
    <p class="pageinput">
      <input type="hidden" name="{$actionid}custom_input[image]" value="0" />
      <input type="checkbox" name="{$actionid}custom_input[image]" value="1"{if $fielddef->GetOptionValue('image')}checked="checked"{/if} />
    </p>
    <p class="pagetext"><div class="information">{$fielddef->ModLang('fielddef_JMFP_media_type_help')}</div></p>
  </div>
  <hr>
  <div class="pageoverflow">
    <p class="pagetext">{$fielddef->ModLang('fielddef_JMFilePicker_create_dirs')}:</p>
    <p class="pageinput">
      <input type="hidden" name="{$actionid}custom_input[create_dirs]" value="0" />
      <input type="checkbox" name="{$actionid}custom_input[create_dirs]" value="1"{if $fielddef->GetOptionValue('create_dirs')}checked="checked"{/if} />
    </p>
    <p class="pagetext"><div class="information">{$fielddef->ModLang('fielddef_JMFP_create_dirs_help')}</div></p>
  </div>
  <hr>
  <div class="pageoverflow">
    <p class="pagetext">{$fielddef->ModLang('fielddef_JMFilePicker_delete')}:</p>
    <p class="pageinput">
      <input type="hidden" name="{$actionid}custom_input[delete]" value="0" />
      <input type="checkbox" name="{$actionid}custom_input[delete]" value="1"{if $fielddef->GetOptionValue('delete')}checked="checked"{/if} />
    </p>
    <p class="pagetext"><div class="information">{$fielddef->ModLang('fielddef_JMFP_delete_help')}</div></p>
  </div>
  <hr>
  <div class="pageoverflow">
    <p class="pagetext">{$fielddef->ModLang('fielddef_JMFilePicker_show_subdirs')}:</p>
    <p class="pageinput">
      <input type="hidden" name="{$actionid}custom_input[show_subdirs]" value="0" />
      <input type="checkbox" name="{$actionid}custom_input[show_subdirs]" value="1"{if $fielddef->GetOptionValue('show_subdirs')}checked="checked"{/if} />
    </p>
    <p class="pagetext"><div class="information">{$fielddef->ModLang('fielddef_JMFP_show_subdirs_help')}</div></p>
  </div>
</fieldset>