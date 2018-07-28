<fieldset>
  <legend>{$fielddef->ModLang('options')}</legend>
  <div class="pageoverflow">
    <p class="pagetext">{$fielddef->ModLang('size')}:</p>
    <p class="pageinput">
      <input type="text" name="{$actionid}custom_input[size]" value="{$fielddef->GetOptionValue('size', 20)}" />
    </p>
    <p class="pagetext"><div class="information">{$fielddef->ModLang('fielddef_size_help')}</div></p>
  </div>
  <hr>
  <div class="pageoverflow">
    <p class="pagetext">{$fielddef->ModLang('max_length')}:</p>
    <p class="pageinput">
      <input type="text" name="{$actionid}custom_input[max_length]" value="{$fielddef->GetOptionValue('max_length', 255)}" />
    </p>
    <p class="pagetext"><div class="information">{$fielddef->ModLang('fielddef_max_length_help')}</div></p>
  </div>
</fieldset>