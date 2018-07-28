<fieldset>
  <legend>{$fielddef->ModLang('options')}</legend>  
  <div class="pageoverflow">
    <p class="pagetext">{$fielddef->ModLang('options')}:</p>
    <p class="pageinput">
      <textarea name="{$actionid}custom_input[options]">{$fielddef->GetOptionValue('options')}</textarea>
    </p>
    <p class="pagetext"><div class="information">{$fielddef->ModLang('fielddef_multioptions_help')}</div></p>
  </div>
  <hr>
  <div class="pageoverflow">	
    <p class="pagetext">{$fielddef->ModLang('separator')}:</p>
    <p class="pageinput">
      <input type="text" name="{$actionid}custom_input[separator]" value="{$fielddef->GetOptionValue('separator')}" />
    </p>
    <p class="pagetext"><div class="information">{$fielddef->ModLang('fielddef_separator_help')}</div></p>	
  </div>
  <hr>
  <div class="pageoverflow">	
    <p class="pagetext">{$fielddef->ModLang('columns')}:</p>
    <p class="pageinput">
      <input type="text" name="{$actionid}custom_input[columns]" value="{$fielddef->GetOptionValue('columns', 1)}" />
    </p>
    <p class="pagetext"><div class="information">{$fielddef->ModLang('fielddef_columns_help')}</div></p>	
  </div>
  <hr>
  <div class="pageoverflow">	
    <p class="pagetext">{$fielddef->ModLang('enable_jqui')}:</p>
    <p class="pageinput">
      <input type="hidden" name="{$actionid}custom_input[jqui_buttons]" value="0" />
      <input type="checkbox" name="{$actionid}custom_input[jqui_buttons]" value="1"{if $fielddef->GetOptionValue('jqui_buttons') == 1} checked="checked"{/if} />
    </p>
    <p class="pagetext"><div class="information">{$fielddef->ModLang('fielddef_enable_jqui_help')}</div></p>	
  </div>
</fieldset>