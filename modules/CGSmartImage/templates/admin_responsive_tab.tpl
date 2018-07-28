{$formstart}
<div class="pageoverflow">
  <p class="pagetext">{$mod->Lang('enable_responsive')}:</p>
  <p class="pageinput">
    <select name="{$actionid}responsive">
      {cge_yesno_options selected=$responsive}
    </select>
    <br/>
    {$mod->Lang('info_responsive')}
  </p>
</div>
<div class="pageoverflow">
  <p class="pagetext">{$mod->Lang('assume_responsive')}:</p>
  <p class="pageinput">
    <select name="{$actionid}assume_responsive">
      {cge_yesno_options selected=$assume_responsive}
    </select>
    <br/>
    {$mod->Lang('info_assume_responsive')}
  </p>
</div>
<div class="pageoverflow">
  <p class="pagetext">{$mod->Lang('responsive_breakpoints')}:</p>
  <p class="pageinput">
    <input type="text" name="{$actionid}responsive_breakpoints" value="{$responsive_breakpoints}" size="50" maxlength="255"/>
    <br/>
    {$mod->Lang('info_responsive_breakpoints')}
  </p>
</div>
<div class="pageoverflow">
  <p class="pagetext"></p>
  <p class="pageinput">
    <input type="submit" name="{$actionid}submit" value="{$mod->Lang('submit')}"/>
  </p>
</div>
{$formend}