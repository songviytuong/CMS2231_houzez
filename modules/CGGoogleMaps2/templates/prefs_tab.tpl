{$formstart}
<div class="c_full cf">
  <label class="grid_2">*{$mod->Lang('google_api_key')}:</label>
  <input class="grid_9" name="{$actionid}apikey" value="{$apikey}"/>
</div>
<div class="c_full cf">
  <label class="grid_2">{$mod->Lang('prompt_lookup_service')}:</label>
  <select class="grid_9" name="{$actionid}lookup_service">
    {html_options options=$lookup_services selected=$lookup_service}
  </select>
</div>
<div class="c_full cf">
  <label class="grid_2">{$mod->Lang('prompt_lookup_policy')}:</label>
  <select class="grid_9" name="{$actionid}lookup_policy">
    {html_options options=$lookup_policies selected=$lookup_policy}
  </select>
</div>

<div class="pageoverflow">
  <p class="pageinput">{$submit}
    <input type="submit" name="{$actionid}submit" value="{$mod->Lang('submit')}"/>
    <input type="submit" name="{$actionid}clearcache" value="{$mod->Lang('clearcache')}"/>
  </p>
</div>
{$formend}