<fieldset>
  <legend>{$fielddef->ModLang('options')}</legend>
  <div class="pageoverflow">
    <p class="pagetext">{$fielddef->ModLang('fielddef_core_fp_profiles')}:</p>
    <p class="pageinput">
      {html_options name="`$actionid`custom_input[profiles]" options=$fielddef->GetProfilesList() selected=$fielddef->GetOptionValue('profiles', '')}
    <p class="pagetext"><div class="information">{$fielddef->ModLang('fielddef_core_fp_profiles_help')}</div></p>
    </p>
  </div>
</fieldset>