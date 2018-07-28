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
    <p class="pagetext">{$fielddef->ModLang('size')}:</p>
    <p class="pageinput">
      <input type="text" name="{$actionid}custom_input[size]" value="{$fielddef->GetOptionValue('size', 5)}" />
    </p>
    <p class="pagetext"><div class="information">{$fielddef->ModLang('fielddef_size_help')}</div></p>
  </div>
</fieldset>