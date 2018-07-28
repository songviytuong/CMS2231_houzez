{$formstart}
<div class="pageoverflow">
  <p class="pagetext">{$mod->Lang('embedding_mode')}:</p>
  <p class="pageinput">
    <select name="{$actionid}embed_mode">
    {html_options options=$embed_modes selected=$embed_mode}
    </select>
    <br/>
    {$mod->Lang('info_embed_mode')}
  </p>
</div>
<div class="pageoverflow">
  <p class="pagetext">{$mod->Lang('embed_sizelimit')}:</p>
  <p class="pageinput">
    <input type="text" name="{$actionid}embed_sizelimit" size="4" maxlength="4" value="{$embed_sizelimit}"/>
    <br/>
    {$mod->Lang('info_embed_sizelimit')}
  </p>
</div>
<div class="pageoverflow">
  <p class="pagetext">{$mod->Lang('embed_types')}:</p>
  <p class="pageinput">
    <input type="text" name="{$actionid}embed_types" size="20" maxlength="20" value="{$embed_types}"/>
    <br/>
    {$mod->Lang('info_embed_types')}
  </p>
</div>
<div class="pageoverflow">
  <p class="pagetext"></p>
  <p class="pageinput">
    <input type="submit" name="{$actionid}submit" value="{$mod->Lang('submit')}"/>
  </p>
</div>
{$formend}