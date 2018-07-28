<fieldset>
  <legend>{$fielddef->ModLang('options')}</legend>
  <div class="pageoverflow">
    <p class="pagetext">{$fielddef->ModLang('width')}:</p>
    <p class="pageinput">
      <input type="text" name="{$actionid}custom_input[width]" value="{$fielddef->GetOptionValue('width', '20%')}" />
    </p>
    <p class="pagetext"><div class="information">{$fielddef->ModLang('fielddef_width_help')}</div></p>
  </div>

  <div class="pageoverflow">
    <p class="pagetext">{$fielddef->ModLang('min_value')}:</p>
    <p class="pageinput">
      <input type="text" name="{$actionid}custom_input[min]" value="{$fielddef->GetOptionValue('min', 0)}" />
    </p>
    <p class="pagetext"><div class="information">{$fielddef->ModLang('fielddef_min_value_help')}</div></p>
  </div>

  <div class="pageoverflow">
    <p class="pagetext">{$fielddef->ModLang('max_value')}:</p>
    <p class="pageinput">
      <input type="text" name="{$actionid}custom_input[max]" value="{$fielddef->GetOptionValue('max', 100)}" />
    </p>
    <p class="pagetext"><div class="information">{$fielddef->ModLang('fielddef_max_value_help')}</div></p>
  </div>

  <div class="pageoverflow">
    <p class="pagetext">{$fielddef->ModLang('increment_by')}:</p>
    <p class="pageinput">
      <input type="text" name="{$actionid}custom_input[increment]" value="{$fielddef->GetOptionValue('increment', 1)}" />
    </p>
    <p class="pagetext"><div class="information">{$fielddef->ModLang('fielddef_increment_by_help')}</div></p>
  </div>
</fieldset>