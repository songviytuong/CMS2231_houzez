{* frontend csv import template *}
{if isset($message)}
<p><strong>{$message}</strong></p>
<hr/>
{/if}
{if isset($errors)}
<div class="error">
<ul>
  {foreach from=$errors item='error'}
    <li>{$error}</li>
  {/foreach}
</ul>
</div>
{/if}

{$formstart}
<p>{$mod->Lang('info_csvfile')}</p>
{if $maxrecords > 0}<p>{$mod->Lang('msg_slotsused',$numrecords,$maxrecords)}</p>{/if}
<div class="pagerow">
  <p class="formprompt">{$mod->Lang('delimiter')}</p>
  <p class="forminput">
    <input type="text" name="{$actionid}cd_delimiter" size="3" maxlength="3" value=","/>
  </p>
</div>
<div class="pagerow">
  <p class="formprompt">{$mod->Lang('import_filename')}</p>
  <p class="forminput">
    <input type="file" name="{$actionid}cd_csvfile" size="50"/>
  </p>
</div>
<div class="pagerow">
  <p class="formprompt"></p>
  <p class="forminput">
    <input type="submit" name="{$actionid}cd_submit" value="{$mod->Lang('submit')}"/>
  </p>
</div>

{$formend}