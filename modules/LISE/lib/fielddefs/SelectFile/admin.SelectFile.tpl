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
    <p class="pagetext">{$fielddef->ModLang('exclude_prefix')}:</p>
    <p class="pageinput">
	    <input type="text" name="{$actionid}custom_input[exclude_prefix]" value="{$fielddef->GetOptionValue('exclude_prefix')}" />
    </p>
    <p class="pagetext"><div class="information">{$fielddef->ModLang('fielddef_exclude_prefix_help')}</div></p>
  </div>
</fieldset>
