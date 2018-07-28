{$opts = $fielddef->GetOptions()}
<fieldset>
  <legend>{$fielddef->ModLang('options')}</legend>
  <div class="pageoverflow">
    <p class="pagetext">{$fielddef->ModLang('fielddef_BT_container_div')}:</p>
    <p class="pageinput">
      {html_options name="`$actionid`custom_input[container_div_sel]" options=$opts.container_div selected=$fielddef->GetOptionValue('container_div_sel', 'none')}
    </p>
    <p class="pagetext"><div class="information">{$fielddef->ModLang('fielddef_BT_container_div_help')}</div></p>
  </div>
  <hr>   
  <div class="pageoverflow">
    <p class="pagetext">{$fielddef->ModLang('fielddef_BT_container_text')}:</p>
    <p class="pageinput">
       <textarea name="{$actionid}custom_input[txt]">{$opts.txt}</textarea> 
    </p>
    <p class="pagetext"><div class="information">{$fielddef->ModLang('fielddef_BT_container_text_help')}</div></p>
  </div> 
</fieldset>