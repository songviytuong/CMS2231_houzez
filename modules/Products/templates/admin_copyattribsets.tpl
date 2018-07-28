<h3>{$mod->Lang('copy_attrib_sets')}</h3>
<p>{$mod->Lang('info_copy_attribsets')}</p>
{$formstart}
<div class="pageoverflow">
  <p class="pagetext">{$mod->Lang('source')}:</p>
  <p class="pageinput">
    <select name="{$actionid}src_compid">
    {html_options options=$product_list}
    </select>
  </p>
</div>

<div class="pageoverflow">
  <p class="pagetext">{$mod->Lang('destination')}:</p>
  <p class="pageinput">
    {$dest_product_name}
  </p>
</div>

<div class="pageoverflow">
  <p class="pagetext"></p>
  <p class="pageinput">
    <input type="submit" name="{$actionid}submit" value="{$mod->Lang('submit')}" onclick="return confirm('{$mod->Lang('confirm_copyattributes')}');"/>
    <input type="submit" name="{$actionid}cancel" value="{$mod->Lang('cancel')}"/>
  </p>
</div>
{$formend}
