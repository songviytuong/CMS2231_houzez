<fieldset>
  <legend>{$fielddef->ModLang('options')}</legend>
  <div class="pageoverflow">
    <p class="pagetext">{$fielddef->ModLang('subtype')}:</p>
    <p class="pageinput">
		  {html_options name="`$actionid`custom_input[subtype]" options=$fielddef->SubTypes() selected=$fielddef->GetOptionValue('subtype', 'Dropdown')}
      <p class="pagetext"><div class="information">{$fielddef->ModLang('fielddef_subtype_help')}</div></p>
    </p>
  </div>
  <hr> 
  <div class="pageoverflow">	
	  <p class="pagetext">{$fielddef->ModLang('separator')}:</p>
	  <p class="pageinput">
		  <input type="text" name="{$actionid}custom_input[separator]" value="{$fielddef->GetOptionValue('separator')}" />
      <p class="pagetext"><div class="information">{$fielddef->ModLang('fielddef_separator_help')}</div></p>
	  </p>	
  </div>
  <hr> 
  <div class="pageoverflow">	
    <p class="pagetext">{$fielddef->ModLang('columns')}:</p>
    <p class="pageinput">
	    <input type="text" name="{$actionid}custom_input[columns]" value="{$fielddef->GetOptionValue('columns', 1)}" />
      <p class="pagetext"><div class="information">{$fielddef->ModLang('fielddef_columns_help')}</div></p>
    </p>	
  </div>
  <hr> 
  <div class="pageoverflow">
    <p class="pagetext">{$fielddef->ModLang('size')}:</p>
    <p class="pageinput">
      <input type="text" name="{$actionid}custom_input[size]" value="{$fielddef->GetOptionValue('size', 5)}" />
      <p class="pagetext"><div class="information">{$fielddef->ModLang('fielddef_size_help')}</div></p>
    </p>
  </div>
</fieldset>