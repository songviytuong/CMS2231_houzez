<fieldset>
  <legend>{$fielddef->ModLang('options')}</legend>
  <div class="pageoverflow">
    <p class="pagetext">{$fielddef->ModLang('options')}:</p>
    <p class="pageinput">
      <textarea name="{$actionid}custom_input[options]">{$fielddef->GetOptionValue('options')}</textarea>
    </p>
    <p class="pagetext"><div class="information">{$fielddef->ModLang('fielddef_multioptions_help')}</div></p>
  </div>
</fieldset>

