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
    <p class="pagetext">{$fielddef->ModLang('format_type')}:</p>
    <p class="pageinput">
      {html_options name="{$actionid}custom_input[format_type]" options=$fielddef->FormatTypes() selected=$fielddef->GetOptionValue('format_type', 0)}
    </p>
    <p class="pagetext"><div class="information">{$fielddef->ModLang('fielddef_format_type_help')}</div></p>
  </div>
  <hr>   
  <div class="pageoverflow">
    <p class="pagetext">{$fielddef->ModLang('date_format')}:</p>
    <p class="pageinput">
      <input type="text" name="{$actionid}custom_input[date_format]" value="{$fielddef->GetOptionValue('date_format', 'dd-mm-yy')}" />
    </p>
    <p class="pagetext"><div class="information">{$fielddef->ModLang('fielddef_date_format_help')}</div></p>
  </div>
  <hr>   
  <div class="pageoverflow">
    <p class="pagetext">{$fielddef->ModLang('time_format')}:</p>
    <p class="pageinput">
      <input type="text" name="{$actionid}custom_input[time_format]" value="{$fielddef->GetOptionValue('time_format', 'HH:mm')}" />
    </p>
    <p class="pagetext"><div class="information">{$fielddef->ModLang('fielddef_time_format_help')}</div></p>
  </div>
  {*
  <hr>   
  <div class="pageoverflow">
    <p class="pagetext">{$fielddef->ModLang('fielddef_php_datetime_format')}:</p>
    <p class="pageinput">
      <input type="text" name="{$actionid}custom_input[php_datetime_format]" value="{$fielddef->GetOptionValue('php_datetime_format', 'HH:mm')}" />
    </p>
    <p class="pagetext"><div class="information">{$fielddef->ModLang('fielddef_php_datetime_format_help')}</div></p>
  </div>
  *}
  <hr>   
  <div class="pageoverflow">
    <p class="pagetext">{$fielddef->ModLang('fielddef_dt_backwards_compatibility')}:</p>
    <p class="pageinput">
	    <input type="hidden" name="{$actionid}custom_input[backwards_compatibility]" value="0" />
	    <input type="checkbox" name="{$actionid}custom_input[backwards_compatibility]" value="1"{if $fielddef->GetOptionValue('backwards_compatibility', 0)}checked="checked"{/if} />
    </p>
    <p class="pagetext"><div class="information">{$fielddef->ModLang('fielddef_dt_fielddef_backwards_compatibility_help')}</div></p>
  </div>
  <hr>   
  <div class="pageoverflow">
    <p class="pagetext">{$fielddef->ModLang('show_seconds')}:</p>
    <p class="pageinput">
      <input type="hidden" name="{$actionid}custom_input[show_seconds]" value="0" />
      <input type="checkbox" name="{$actionid}custom_input[show_seconds]" value="1"{if $fielddef->GetOptionValue('show_seconds', 0)}checked="checked"{/if} />
    </p>
    <p class="pagetext"><div class="information">{$fielddef->ModLang('fielddef_show_seconds_help')}</div></p>
  </div>
</fieldset>