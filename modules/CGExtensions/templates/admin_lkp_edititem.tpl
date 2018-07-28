<h3>{$title}</h3>
{if $subtitle}<h4>{$subtitle}</h4>{/if}

{$formstart}
<div class="pageoverflow">
  <p class="pageinput">
    <input type="submit" name="{$actionid}submit" value="{$mod->Lang('submit')}"/>
    <input type="submit" name="{$actionid}cancel" value="{$mod->Lang('cancel')}"/>
  </p>
</div>
<div class="pageoverflow">
  <p class="pagetext">*{cgex_lang('name')}:</p>
  <p class="pageinput">
    <input type="text" name="{$actionid}name" value="{$item->name}" size="80"/>
  </p>
</div>
<div class="pageoverflow">
  <p class="pagetext">{cgex_lang('description')}</p>
  <p class="pageinput">
    {cge_wysiwyg prefix=$actionid name=description value=$item->description rows=4}
  </p>
</div>
{$formend}