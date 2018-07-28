{$formstart}
<div class="information">{$mod->Lang('info_autoprocessing')}</div>
<div>

<div class="c_full">
  <div class="grid_2">&nbsp;</div>
  <div class="grid_10">
    <input type="submit" name="{$actionid}submit" value="{$mod->Lang('submit')}"/>
    {if $prefs->enabled}
    <input type="submit" name="{$actionid}begin_autoprocess" value="{$mod->Lang('begin_autoprocess')}"/>
    {/if}
  </div>
</div>
<div class="c_full">
  <div class="grid_2 text-right">{$mod->Lang('autoprocess_enabled')}:</div>
  <div class="grid_10">
    {cge_yesno_options prefix=$actionid name=ap_enabled selected=$prefs->enabled}
  </div>
</div>
<div class="c_full">
  <div class="grid_2 text-right">{$mod->Lang('autoprocess_ignore_extensions')}:</div>
  <div class="grid_10">
    <input type="text" name="{$actionid}ap_ignore_extensions" value="{$prefs->ignore_extensions}"/>
  </div>
</div>
<div class="c_full">
  <div class="grid_2 text-right">{$mod->Lang('autoprocess_ignore_dirs')}:</div>
  <div class="grid_10">
    <textarea name="{$actionid}ap_ignore_dirs" rows="5" cols="50"/>{$prefs->ignore_dirs}</textarea>
    <br/>{$mod->Lang('help_ap_ignore_dirs')}
  </div>
</div>
<div class="c_full">
  <div class="grid_2 text-right">{$mod->Lang('autoprocess_include_dirs')}:</div>
  <div class="grid_10">
    <textarea name="{$actionid}ap_include_dirs" rows="5" cols="50"/>{$prefs->include_dirs}</textarea>
    <br/>{$mod->Lang('help_ap_include_dirs')}
  </div>
</div>
<div class="c_full">
  <div class="grid_2 text-right">{$mod->Lang('autoprocess_max_size')}:</div>
  <div class="grid_10">
    <input type="text" name="{$actionid}ap_max_size" size="5" maxlength="5" value="{$prefs->max_size}"/>
    <br/>{$mod->Lang('help_ap_max_size')}
  </div>
</div>
<div class="c_full">
  <div class="grid_2 text-right">{$mod->Lang('autoprocess_autorotate')}:</div>
  <div class="grid_10">
    {cge_yesno_options prefix=$actionid name=ap_autorotate selected=$prefs->autorotate}
    <br/>{$mod->Lang('help_ap_autorotate')}
  </div>
</div>
<div class="c_full">
  <div class="grid_2 text-right">{$mod->Lang('autoprocess_watermark')}:</div>
  <div class="grid_10">
    {cge_yesno_options prefix=$actionid name=ap_watermark selected=$prefs->watermark}
  </div>
</div>

<div class="clearb"></div>
</div>
{$formend}