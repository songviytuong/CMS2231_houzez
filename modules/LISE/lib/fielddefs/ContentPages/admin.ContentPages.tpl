<fieldset>
  <legend>{$fielddef->ModLang('options')}</legend>
  <div class="pageoverflow">
    <p class="pagetext">{$fielddef->ModLang('subtype')}:</p>
    <p class="pageinput">
	    {html_options name="`$actionid`custom_input[subtype]" options=$fielddef->SubTypes() selected=$fielddef->GetOptionValue('subtype', 'Dropdown')}
    </p>
    <p class="pagetext"><div class="information">{$fielddef->ModLang('fielddef_subtype_help')}</div></p>
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
    <p class="pagetext">{$fielddef->ModLang('showall')}:</p>
    <p class="pageinput">
	    <input type="hidden" name="{$actionid}custom_input[showall]" value="0" />
	    <input type="checkbox" name="{$actionid}custom_input[showall]" value="1"{if $fielddef->GetOptionValue('showall')}checked="checked"{/if} />
    </p>
    <p class="pagetext"><div class="information">{$fielddef->ModLang('fielddef_showall_help')}</div></p>
  </div>
</fieldset>