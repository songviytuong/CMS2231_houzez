<!-- start tab -->
<div id="page_tabs">
	<div id="editfielddef">
		{$title}
	</div>
	{if isset($input_extra)}
	<div id="fielddefextra">
		{$mod->ModLang('extra')}
	</div>	
	{/if}
</div>
<!-- end tab //-->
<!-- start content -->
{$startform}
<div id="page_content"> 
  {$backlink}
	<div id="editfielddef_c"> 
    <fieldset>
      <legend>{$mod->ModLang('main_settings')}</legend>
		  <div class="pageoverflow">
    		  <p class="pagetext">{$mod->ModLang('fielddef_type')}:</p>
    		  <p class="pageinput">{$inputtype}</p>
		  </div>
		  <div class="pageoverflow">
			  <p class="pagetext">*{$mod->ModLang('fielddef_name')}:</p>
			  <p class="pageinput">{$inputname}</p>
		  </div>
		  <div class="pageoverflow">
			  <p class="pagetext">{$mod->ModLang('alias')}:</p>
			  <p class="pageinput">{$input_alias}</p>
		  </div>
		  
		  <div class="pageoverflow">
			  <p class="pagetext">{$mod->ModLang('fielddef_help')}:</p>
			  <p class="pageinput">{$inputhelp}</p>
		  </div>
      <div class="pageoverflow">
        <p class="pagetext">{$mod->ModLang('fielddef_required')}:</p>
        <p class="pageinput">{$input_required}</p>
      </div>
    </fieldset>  
		<div class="lise_typeoptions">
      {if isset($fielddef) && $fielddef->HasTemplate()}
        <fieldset>    
          <div class="pageoverflow">
            <p class="pagetext">{$mod->ModLang('fielddef_template')}:</p>
            <p class="pageinput template_input">{$input_template}</p>
          </div>
        </fieldset>
      {/if}
      
		  {if isset($fielddef)}
        {*if $fielddef->HasTemplate()}
          <fieldset>    
            <div class="pageoverflow">
              <p class="pagetext">{$mod->ModLang('fielddef_template')}:</p>
              <p class="pageinput template_input">{$input_template}</p>
            </div>
          </fieldset>
        {/if*}
			  {$fielddef->RenderForEdit($actionid, $returnid)}
		  {/if}
		</div>       
	</div> 
  {if isset($input_extra)}
	  <div id="fielddefextra_c"> 
		  <div class="pageoverflow">
    	  <p class="pagetext">{$mod->ModLang('extra')}:</p>
    	  <p class="pageinput">{$input_extra}</p>
		  </div>
	  </div>
  {/if}	
	<div class="pageoverflow">
		<p class="pagetext">&nbsp;</p>
		<p class="pageinput">
			<input name="{$actionid}submit" id="lise_submit" value="{lang('submit')}" type="submit" />
			<input name="{$actionid}cancel" id="lise_cancel" value="{lang('cancel')}" type="submit" />
			<input name="{$actionid}apply" id="lise_apply" value="{lang('apply')}" type="submit" />
			<input name="{$actionid}save_create" id="lise_save_create" value="{$mod->ModLang('save_create')}" type="submit" />				
		</p>
	</div>		
</div>
{$endform}