<fieldset>
  <legend>{$fielddef->ModLang('options')}</legend>
  <div class="pageoverflow">
	  <p class="pagetext">{$fielddef->ModLang('fielddef_feu_options')}:</p>
	  <p class="pageinput">
		  {html_options name="`$actionid`custom_input[feu_options]" options=$fielddef->GetFEUGroups() selected=$fielddef->GetOptionValue('feu_options')}
	  </p>
    <p class="pagetext"><div class="information">{$fielddef->ModLang('fielddef_feu_dropdown_help')}</div></p>
  </div>
</fieldset>