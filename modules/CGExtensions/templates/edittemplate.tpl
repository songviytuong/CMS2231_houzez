<h3>{$modname} {if !empty($title)}- {$title}{/if}</h3>
{if !empty($info)}<div class="information">{$info}</div>{/if}

{$formstart}{$hidden|default:''}
<div class="pageoverflow">
  <p class="pagetext">*{$prompt_templatename}:</p>
  <p class="pageinput">
    <input type="text" name="{$actionid}template" value="{$templatename}" required/>
  </p>
</div>
<div class="pageoverflow">
  <p class="pagetext">{$prompt_template}:</p>
  <p class="pageinput">
    {cge_textarea syntax=1 prefix=$actionid name=templatecontent content=$templatecontent rows=20}
  </p>
</div>
<div class="pageoverflow">
  <p class="pageinput">
    <input type="submit" name="{$actionid}cge_submit" value="{$cge->Lang('submit')}"/>
    <input type="submit" name="{$actionid}cge_cancel" value="{$cge->Lang('cancel')}" formnovalidate/>
    {if $mode == 'edit'}
      <input type="submit" name="{$actionid}cge_apply" value="{$cge->Lang('apply')}"/>
    {/if}
    <input type="submit" name="{$actionid}cge_reset" value="{$cge->Lang('reset')}"/>
  </p>
</div>
{$formend}
