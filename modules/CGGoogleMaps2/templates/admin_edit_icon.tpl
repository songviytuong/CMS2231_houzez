<h3>
{if isset($icon_data.id)}
{$mod->Lang('edit_icon')}
{else}
{$mod->Lang('add_icon')}
{/if}
</h3>

{$formstart}
<div class="pageoverflow">
  {if isset($icon_data.id)}
  <p class="pagetext">{$mod->Lang('id')}:&nbsp;{$icon_data.id|default:''}
    {if !empty($icon_data.url)}<br/><img src="../{$icon_data.url}" alt="">{/if}
  </p>
  {/if}
</div>

<div class="pageoverflow">
  <p class="pagetext"><label for="iconname">{$mod->Lang('name')}</label>:</p>
  <p class="pageinput">
    <input id="iconname" type="text" name="{$actionid}name" value="{$icon_data.name}" size="20" maxlength="20"/>
  </p>
</div>

<div class="pageoverflow">
  <p class="pagetext"><label for="iconurl">{$mod->Lang('url')}</label>:</p>
  <p class="pageinput">
    <textarea id="iconurl" name="{$actionid}url" maxlength="255" rows="2" cols="50">{$icon_data.url}</textarea>
    <br/>
    {$mod->Lang('help_icon_url')}
  </p>
</div>

<br/>
<div class="information" style="display: inline-block;">{$mod->Lang('help_anchor_location')}</div>

<div class="pageoverflow">
  <p class="pagetext"><label for="iconanchorx">{$mod->Lang('anchor_x')}</label>:</p>
  <p class="pageinput">
    <input id="iconanchorx" type="text" name="{$actionid}anchor_x" value="{$icon_data.anchor_x}" size="3" maxlength="3"/>
  </p>
</div>

<div class="pageoverflow">
  <p class="pagetext"><label for="iconanchory">{$mod->Lang('anchor_y')}</label>:</p>
  <p class="pageinput">
    <input id="iconanchory" type="text" name="{$actionid}anchor_y" value="{$icon_data.anchor_y}" size="3" maxlength="3"/>
  </p>
</div>

<div class="pageoverflow">
  <p class="pagetext">&nbsp;</p>
  <p class="pageinput">
    <input type="submit" name="{$actionid}submit" value="{$mod->Lang('submit')}"/>
    <input type="submit" name="{$actionid}cancel" value="{$mod->Lang('cancel')}"/>
  </p>
</div>
{$formend}