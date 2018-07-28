<fieldset>
  <legend>{$fielddef->ModLang('options')}</legend>  
  <div class="pageoverflow">
    <p class="pagetext">{$fielddef->ModLang('instance')}:</p>
    <p class="pageinput">
	    {html_options name="`$actionid`custom_input[instance]" options=$fielddef->Instances() selected=$fielddef->GetOptionValue('instance')}
    </p>
    <p class="pagetext"><div class="information">{$fielddef->ModLang('fielddef_instance_help')}</div></p>
  </div>
  <hr>
  <div class="pageoverflow">
    <p class="pagetext">{$fielddef->ModLang('identifier')}:</p>
    <p class="pageinput">
	    {html_options name="`$actionid`custom_input[identifier]" options=$fielddef->Identifiers() selected=$fielddef->GetOptionValue('identifier')}
    </p>
    <p class="pagetext"><div class="information">{$fielddef->ModLang('fielddef_identifier_help')}</div></p>
  </div>
  <hr>
  <div class="pageoverflow">
    <p class="pagetext">{$fielddef->ModLang('subtype')}:</p>
    <p class="pageinput">
	    {html_options name="`$actionid`custom_input[subtype]" options=$fielddef->SubTypes() selected=$fielddef->GetOptionValue('subtype', 'Dropdown')}
    </p>
    <p class="pagetext"><div class="information">{$fielddef->ModLang('fielddef_subtype_help')}</div></p>
  </div>
  <hr>
  <div class="pageoverflow">	
    <p class="pagetext">{$fielddef->GetModuleInstance(true)->ModLang('separator')}:</p>
    <p class="pageinput">
      <input type="text" name="{$actionid}custom_input[separator]" value="{$fielddef->GetOptionValue('separator')}" />
    </p>
    <p class="pagetext"><div class="information">{$fielddef->ModLang('fielddef_separator_help')}</div></p>	
  </div>
  <hr>
  <div class="pageoverflow">	
    <p class="pagetext">{$fielddef->GetModuleInstance(true)->ModLang('columns')}:</p>
    <p class="pageinput">
      <input type="text" name="{$actionid}custom_input[columns]" value="{$fielddef->GetOptionValue('columns', 1)}" />
    </p>
    <p class="pagetext"><div class="information">{$fielddef->ModLang('fielddef_columns_help')}</div></p>	
  </div>
  <hr>
  <div class="pageoverflow">
    <p class="pagetext">{$fielddef->GetModuleInstance(true)->ModLang('size')}:</p>
    <p class="pageinput">
      <input type="text" name="{$actionid}custom_input[size]" value="{$fielddef->GetOptionValue('size', 5)}" />
    </p>
    <p class="pagetext"><div class="information">{$fielddef->ModLang('fielddef_size_help')}</div></p>
  </div>
</fieldset>  