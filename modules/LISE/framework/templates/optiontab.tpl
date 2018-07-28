{$startform}
<fieldset>
	<legend>{$mod->ModLang('module_options')}</legend>
	<div class="pagewarning">
		<h3>{$mod->ModLang('notice')}</h3>
		<p>{$mod->ModLang('options_notice')}</p>
	</div>	
    <div class="pageoverflow">
        <p class="pagetext">{$mod->ModLang('prompt_friendlyname')}:</p>
        <p class="pageinput">{$input_friendlyname}</p>
    </div>
    <div class="pageoverflow">
        <p class="pagetext">{$mod->ModLang('prompt_moddescription')}:</p>
        <p class="pageinput">{$input_moddescription}</p>
    </div>      
    <div class="pageoverflow">
        <p class="pagetext">{$mod->ModLang('prompt_adminsection')}:</p>
        <p class="pageinput">{$input_adminsection}</p>
    </div>     
</fieldset> 
<fieldset>
	<legend>{$mod->ModLang('default_options')}</legend>
	<div class="pageoverflow">
        <p class="pagetext">{$mod->ModLang('prompt_detailpage')}:</p>
        <p class="pageinput">{$input_detailpage}</p>
    </div> 
	<div class="pageoverflow">
        <p class="pagetext">{$mod->ModLang('prompt_summarypage')}:</p>
        <p class="pageinput">{$input_summarypage}</p>
    </div> 	
</fieldset>
<fieldset>
    <legend>{$mod->ModLang('items_options')}</legend>           
    <div class="pageoverflow">
        <p class="pagetext">{$mod->ModLang('prompt_item_title')}:</p>
        <p class="pageinput">{$input_item_title}</p>
    </div>
    <div class="pageoverflow">
        <p class="pagetext">{$mod->ModLang('prompt_item_singular')}:</p>
        <p class="pageinput">{$input_item_singular}</p>
    </div>
    <div class="pageoverflow">
        <p class="pagetext">{$mod->ModLang('prompt_item_plural')}:</p>
        <p class="pageinput">{$input_item_plural}</p>
    </div>
	<div class="pageoverflow">
        <p class="pagetext">{$mod->ModLang('prompt_create_date')}</p>
        <p class="pageinput">{$input_create_date}</p>
    </div>    
	<div class="pageoverflow">
        <p class="pagetext">{$mod->ModLang('prompt_item_cols')}:</p>
        <p class="pageinput">{$input_item_cols}</p>
    </div>
    <div class="pageoverflow">
        <p class="pagetext">{$mod->ModLang('prompt_items_per_page')}:</p>
        <p class="pageinput">{$input_items_per_page}</p>
    </div>
	<div class="pageoverflow">
        <p class="pagetext">{$mod->ModLang('text_sortorder')}:</p>
        <p class="pageinput">{$input_sortorder}</p>
    </div>     
</fieldset>
<fieldset>
	<legend>{$mod->ModLang('url_options')}</legend>
	<div class="pageoverflow">
        <p class="pagetext">{$mod->ModLang('prompt_url_prefix')}:</p>
        <p class="pageinput">{$input_url_prefix}</p>
    </div> 
  <div class="pageoverflow">
        <p class="pagetext">{$mod->ModLang('prompt_url_template')}:</p>
        <p class="pageinput">{$input_url_template}</p>
    </div> 
	<div class="pageoverflow">
        <p class="pagetext">{$mod->ModLang('prompt_subcategory')}:</p>
        <p class="pageinput">{$input_subcategory}</p>
    </div>	
	<div class="pageoverflow">
        <p class="pagetext">{$mod->ModLang('prompt_display_inline')}:</p>
        <p class="pageinput">{$input_display_inline}</p>
    </div>
</fieldset>
<fieldset>
  <legend>{$mod->ModLang('xmodule_options')}</legend>
  <div class="pageoverflow">
    <div class="warning">
      <p>{$mod->ModLang('warning_reindex_search')}</p>
    </div>          
  </div>   
  <div class="pageoverflow">
    <p class="pagetext">{$mod->ModLang('prompt_reindex_search')}:</p>
    <p class="pageinput">{$input_reindex_search}</p>
  </div>  
  <div class="pageoverflow">
      <p class="pagetext">{$mod->ModLang('prompt_reindex_do_search')}:</p>
      <p class="pageinput">
        <input type="hidden" name="{$actionid}_do_reindex" value="0" />
        <input type="checkbox" name="{$actionid}_do_reindex" value="1"/>
      </p>
  </div>
  <div class="pageoverflow">
    <div class="warning">
      <p>{$mod->ModLang('warning_reindex_search_now')}</p>
    </div>          
  </div> 
</fieldset>
<fieldset>
	<legend>{$mod->ModLang('misc_options')}</legend>
	<div class="pageoverflow">
        <p class="pagetext">{$mod->ModLang('prompt_auto_upgrade')}:</p>
        <p class="pageinput">{$input_auto_upgrade}</p>
    </div> 	
</fieldset>
    
<fieldset>
	<legend>{$mod->ModLang('sent_email')}</legend>
	<div class="pageoverflow">
        <p class="pagetext">{$mod->ModLang('prompt_sent_email')}:</p>
        <p class="pageinput">{$input_sent_email}</p>
    </div> 	
</fieldset>
    
<fieldset>
	<legend>{$mod->ModLang('time_control')}</legend>
	<div class="pageoverflow">
        <p class="pagetext">{$mod->ModLang('prompt_time_control')}:</p>
        <p class="pageinput">{$input_time_control}</p>
    </div> 	
</fieldset>
    
<fieldset>
	<legend>{$mod->ModLang('extra1_enabled')}</legend>
	<div class="pageoverflow">
        <p class="pagetext">{$mod->ModLang('prompt_extra1_enabled')}:</p>
        <p class="pageinput">{$input_extra1_enabled}</p>
        <p class="pagetext">{$mod->ModLang('prompt_extra1_enabled_wysiwyg')}</p>
        <p class="pageinput">{$input_extra1_enabled_wysiwyg}</p>
    </div> 	
</fieldset>
    
    <fieldset>
	<legend>{$mod->ModLang('extra2_enabled')}</legend>
	<div class="pageoverflow">
        <p class="pagetext">{$mod->ModLang('prompt_extra2_enabled')}:</p>
        <p class="pageinput">{$input_extra2_enabled}</p>
        <p class="pagetext">{$mod->ModLang('prompt_extra2_enabled_wysiwyg')}</p>
        <p class="pageinput">{$input_extra2_enabled_wysiwyg}</p>
    </div> 	
</fieldset>
    
    <fieldset>
	<legend>{$mod->ModLang('extra3_enabled')}</legend>
	<div class="pageoverflow">
        <p class="pagetext">{$mod->ModLang('prompt_extra3_enabled')}:</p>
        <p class="pageinput">{$input_extra3_enabled}</p>
        <p class="pagetext">{$mod->ModLang('prompt_extra3_enabled_wysiwyg')}</p>
        <p class="pageinput">{$input_extra3_enabled_wysiwyg}</p>
    </div> 	
</fieldset>
    
    <div class="pageoverflow">
        <p class="pagetext">&nbsp;</p>
        <p class="pageinput">
			{$submit}
		</p>
    </div>

{$endform}
