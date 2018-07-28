{$formstart}
<div class="pageoverflow">
  <p class="pagetext">{$mod->Lang('parent')}</p>
  <p class="pageinput">
    {$input_parent}
  </p>
</div>

<div class="pageoverflow">
  <p class="pagetext">{$mod->Lang('file')}</p>
  <p class="pageinput">
    <input type="file" name="{$actionid}file" size="80"/>
  </p>
</div>

<div class="pageoverflow">
  <p class="pagetext">&nbsp;</p>
  <p class="pageinput">
    <input type="submit" name="{$actionid}submit" value="{$mod->Lang('submit')}"/>
  </p>
</div>
{$formend}