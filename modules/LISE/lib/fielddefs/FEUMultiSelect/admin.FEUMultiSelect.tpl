{$opts = $fielddef->GetOptions()} 
{$sel_groups = explode(',', $fielddef->GetOptionValue('feu_options'))}
{$groups_opts = $fielddef->GetFEUGroups()}
{$defs = $fielddef->GetFeuProperties()}
{$sel_def = $fielddef->GetOptionValue('feu_field')}
{$sel_def2 = $fielddef->GetOptionValue('feu_field2')}
 
<fieldset>
  <legend>{$fielddef->ModLang('options')}</legend>
  <div class="pageoverflow">
    <p class="pagetext">{$fielddef->ModLang('fielddef_feu_options')}:</p>
    <p class="pageinput">
        <select name="{$actionid}custom_input[feu_options][]}" size="{$groups_opts|count}" multiple>        
          {html_options options=$groups_opts selected=$sel_groups}
        </select>  
    </p>
    <p class="pagetext"><div class="information">{$fielddef->ModLang('fielddef_feu_multiselect_help')}</div></p>
  </div>
  <hr> 
  <div class="pageoverflow">
    <p class="pagetext">{$fielddef->ModLang('fielddef_use_uid')}:</p>
    <p class="pageinput">
    <input type="hidden" name="{$actionid}custom_input[use_uid]" value="0" />
    <input type="checkbox" name="{$actionid}custom_input[use_uid]" value="1"{if $fielddef->GetOptionValue('use_uid')}checked="checked"{/if} />
  </p>
  <p class="pagetext"><div class="information">{$fielddef->ModLang('fielddef_use_uid_help')}</div></p>
  </div>
  <hr>
  <div class="pageoverflow">
    <p class="pagetext">{$fielddef->ModLang('fielddef_use_username')}:</p>
    <p class="pageinput">
    <input type="hidden" name="{$actionid}custom_input[use_username]" value="0" />
    <input type="checkbox" name="{$actionid}custom_input[use_username]" value="1"{if $fielddef->GetOptionValue('use_username')}checked="checked"{/if} />
  </p>
  <p class="pagetext"><div class="information">{$fielddef->ModLang('fielddef_use_username_help')}</div></p>
  </div>
  <hr> 
  <div class="pageoverflow">
    <p class="pagetext">{$fielddef->ModLang('fielddef_feu_fields')}:</p>
    <p class="pageinput">
      {html_options name="{$actionid}custom_input[feu_field]}" options=$defs selected=$sel_def}
    </p>
    <p class="pagetext"><div class="information">{$fielddef->ModLang('fielddef_feu_fields_help')}</div></p>
  </div>
  <hr> 
  <div class="pageoverflow">
    <p class="pagetext">{$fielddef->ModLang('fielddef_feu_fields2')}:</p>
    <p class="pageinput">
      {html_options name="{$actionid}custom_input[feu_field2]}" options=$defs selected=$sel_def2}
    </p>
    <p class="pagetext"><div class="information">{$fielddef->ModLang('fielddef_feu_fields_help')}</div></p>
  </div>
  <hr> 
  <div class="pageoverflow">
	  <p class="pagetext">{$fielddef->ModLang('fielddef_separator_chr')}:</p>
	  <p class="pageinput">
      <input type="text" name="{$actionid}custom_input[separator]" value="{$fielddef->GetOptionValue('separator', ' ')}" />
	  </p>
    <p class="pagetext"><div class="information">{$fielddef->ModLang('fielddef_separator_chr_help')}</div></p>
  </div>
  <hr>
  <div class="pageoverflow">
      <p class="pagetext">{$fielddef->ModLang('fielddef_type')}:</p>
      <p class="pageinput">
        <select name="{$actionid}custom_input[type]" style="max-width: 98%;">
          {html_options options=$opts.types selected=$fielddef->GetOptionValue('type', 'MultiSelect')}
        </select>
      </p>
      <p class="pagetext"><div class="information">{$fielddef->ModLang('fielddef_type_help')}</div></p>
  </div> 
  
</fieldset>