{$formstart}
<div class="pageoverflow">
  <p class="pagetext">{$mod->Lang('url_required')}<p>
  <p class="pageinput">
    {cge_yesno_options prefix=$actionid name='url_required' selected=$url_required}
    <br/>
    {$mod->Lang('info_url_required')}
  </p>
</div>
<div class="pageoverflow">
  <p class="pagetext">{$mod->Lang('url_autocreate')}<p>
  <p class="pageinput">
    {cge_yesno_options prefix=$actionid name='url_autocreate' selected=$url_autocreate}
    <br/>
    {$mod->Lang('info_url_autocreate')}
  </p>
</div>
<div class="pageoverflow">
  <p class="pagetext">{$mod->Lang('url_createoncopy')}<p>
  <p class="pageinput">
    {cge_yesno_options prefix=$actionid name='url_createoncopy' selected=$url_createoncopy}
    <br/>
    {$mod->Lang('info_url_createoncopy')}
  </p>
</div>
<div class="pageoverflow">
  <p class="pagetext">{$mod->Lang('url_redirectold')}<p>
  <p class="pageinput">
    {cge_yesno_options prefix=$actionid name='url_redirectold' selected=$url_redirectold}
    <br/>
    {$mod->Lang('info_url_redirectold')}
  </p>
</div>
<div class="pageoverflow">
  <p class="pagetext"></p>
  <p class="pageinput">
    <input type="submit" name="{$actionid}submit" value="{$mod->Lang('submit')}"/>
    <input type="submit" name="{$actionid}createurls" value="{$mod->Lang('createurls')}" onclick="return confirm('{$mod->Lang('confirm_autocreate_url')}');"/>
  </p>
</div>
{$formend}