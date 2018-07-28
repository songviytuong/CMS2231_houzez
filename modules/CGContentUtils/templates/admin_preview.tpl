<h3>{$mod->Lang('preview')}:</h3>
{$formstart}
<div class="pageoverflow">
  <p class="pagetext">{$mod->Lang('type')}:&nbsp;{$data.type}</p>
</div>
<div class="pageoverflow">
  <p class="pagetext">{$mod->Lang('module')}:&nbsp;{$data.module|default:'n/a'}</p>
</div>
<div class="pageoverflow">
  <p class="pagetext">{$mod->Lang('name')}:&nbsp;{$data.name}</p>
</div>
<div class="pageoverflow">
  <p class="pagetext">{$mod->Lang('content')}:</p>
  <p class="pageinput">
    <textarea name="foo" readonly="readonly">{$data.code}</textarea>
  </p>
</div>
<div class="pageoverflow">
  <p class="pagetext"></p>
  <p class="pageinput">
   <input type="submit" name="{$actionid}submit" value="{$mod->Lang('submit')}"/>
  </p>
</div>
{$formend}