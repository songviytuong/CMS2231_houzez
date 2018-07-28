<fieldset>
  <legend>{$fielddef->ModLang('options')}</legend>
  <div class="pageoverflow">
    <p class="pagetext">{$fielddef->ModLang('allowed')}:</p>
    <p class="pageinput">
	  <input type="text" name="{$actionid}custom_input[allowed]" value="{$fielddef->GetOptionValue('allowed', 'pdf,gif,jpeg,jpg')}" />
  </p>
  <p class="pagetext"><div class="information">{$fielddef->ModLang('fielddef_allow_help')}</div></p>
  </div>
  <hr> 
  <div class="pageoverflow">
    <p class="pagetext">{$fielddef->ModLang('dir')}:</p>
    <p class="pageinput">
	  <input type="text" name="{$actionid}custom_input[dir]" value="{$fielddef->GetOptionValue('dir','images')}" />
  </p>
  <p class="pagetext"><div class="information">{$fielddef->ModLang('fielddef_dir_help')}</div></p>
  </div>
  <hr> 
  <div class="pageoverflow">
    <p class="pagetext">{$fielddef->ModLang('fielddef_image')}:</p>
    <p class="pageinput">
	  <input type="hidden" name="{$actionid}custom_input[image]" value="0" />
	  <input type="checkbox" name="{$actionid}custom_input[image]" value="1"{if $fielddef->GetOptionValue('image')}checked="checked"{/if} />
  </p>
  <p class="pagetext"><div class="information">{$fielddef->ModLang('fielddef_media_type_help')}</div></p>
  </div>
  <hr> 
  <div class="pageoverflow">
    <p class="pagetext">{$fielddef->ModLang('size')}:</p>
    <p class="pageinput">
      <input type="text" name="{$actionid}custom_input[size]" value="{$fielddef->GetOptionValue('size', 20)}" />
    </p>
    <p class="pagetext"><div class="information">{$fielddef->ModLang('fielddef_size_help')}</div></p>
  </div>
</fieldset>