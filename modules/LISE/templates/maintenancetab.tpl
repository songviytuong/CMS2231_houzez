{$startform}
<fieldset>
  <legend>{$mod->ModLang('fielddefs')}</legend>

  <div class="pageoverflow">
    <p class="pagetext">{$mod->ModLang('prompt_fix_fielddefs')}:</p>
    <p class="pageinput">{$button_fix_fielddefs}</p>
  </div>  
  
</fieldset>
{if LISESmarty::LI2_present()}
<fieldset>
  <legend>{$mod->ModLang('import_from_LI2_title')}</legend>
   <div class="red">{$mod->ModLang('clone_instances_warning')}</div>

	<div class="pageoverflow">
		<p class="pagetext">{$mod->ModLang('prompt_import_from_LI2')}:</p>
		<p class="pageinput">{$button_import_from_LI2}</p>
	</div>	
</fieldset>
{/if}

<fieldset>
  <legend>{$mod->ModLang('fix_import_from_LI2_title')}</legend>
   <div class="red">{$mod->ModLang('fix_LI2_instances_warning')}</div>

  <div class="pageoverflow">
    <p class="pagetext">{$mod->ModLang('prompt_fix_import_from_LI2')}:</p>
    <p class="pageinput">{$button_fix_import_from_LI2}</p>
  </div>  
</fieldset>  
{$endform}