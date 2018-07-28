<div class="information">{$mod->Lang('info_states_tab')}</div>
<textarea cols="40" rows="25" name="{$actionid}state_list">{foreach $state_list as $rec}
{$rec.code}={$rec.name}
{/foreach}</textarea>
<div class="pageoverflow">
  <p class="pageinput">
    <input type="submit" name="{$actionid}submit_states" value="{$mod->Lang('submit')}"/>
    <input type="submit" name="{$actionid}reset_states" value="{$mod->Lang('reset')}"/>
  </p>
</div>