{$formstart}
<div class="pageoverflow">
  <p class="pagetext">{$mod->Lang('start_page')}:</p>
  <p class="pageinput">{$input_parent}</p>
</div>

<div class="pageoverflow">
  <p class="pagetext">{$mod->Lang('export_children')}:</p>
  <p class="pageinput">
     <input type="checkbox" name="{$actionid}children" value="1" checked="checked"/>
  </p>
</div>

<div class="pageoverflow">
  <p class="pagetext">&nbsp;</p>
  <p class="pageinput">
     <input type="submit" name="{$actionid}submit" value="{$mod->Lang('submit')}"/>
  </p>
</div>
{$formend}