<div class="information">{$mod->Lang('info_countries_tab')}</div>
<textarea cols="40" rows="25" name="{$actionid}country_list">{foreach $country_list as $rec}
{$rec.code}={$rec.name}
{/foreach}</textarea>
<div class="pageoverflow">
  <p class="pageinput">
    <input type="submit" name="{$actionid}submit_countries" value="{$mod->Lang('submit')}"/>
    <input type="submit" name="{$actionid}reset_countries" value="{$mod->Lang('reset')}"/>
  </p>
</div>