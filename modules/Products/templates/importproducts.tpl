{* import products form *}
<h3>{$mod->Lang('import_from_csv')}</h3>

{$formstart}
{if isset($messages)}
  <div class="pageoverflow">
    <div style="overflow: auto; height: 10em; width: 75%; margin-left: 5em; border: 1px dashed #ccc;"/>
    {strip}
    {foreach from=$messages item='one'}
      {$one}<br/>
    {/foreach}
    {/strip}
    </div>
  </div>
{elseif isset($errors)}
  <div class="pageoverflow">
    <div style="overflow: auto; height: 10em; width: 75%; margin-left: 5em; border: 1px dashed #ccc;"/>
    {strip}
    {foreach from=$errors item='one'}
      {$one}<br/>
    {/foreach}
    {/strip}
    </div>
  </div>
{/if}

{if !isset($csvfile)}
  {* display the form *}
  <div class="c_full cf">
  <label class="grid_2">{$mod->Lang('prompt_delimiter')}:</label>>
  <div class="grid_9">
    <input type="text" name="{$actionid}delimiter" value="{$delimiter}" size="5" maxlength="10"/>
    <p>{$mod->Lang('info_delimiter')}</p>
  </div>
</div>

<div class="c_full cf">
  <label class="grid_2">{$mod->Lang('prompt_createfields')}:</label>
  <div class="grid_9">
    <select name="{$actionid}createfields">
      {html_options options=$yesno selected=$flag_createfields}
    </select>
    <p>{$mod->Lang('info_createfields')}</p>
  </div>
</div>

<div class="c_full cf">
  <label class="grid_2">{$mod->Lang('prompt_handleimages')}:</label>
  <div class="grid_9">
    <select name="{$actionid}handleimages">
      {html_options options=$yesno selected=$flag_handleimages}
    </select>
    <p>{$mod->Lang('info_handleimages')}</p>
  </div>
</div>

<div class="c_full cf">
  <label class="grid_2">{$mod->Lang('prompt_imagepath')}:</label>
  <div class="grid_9">
    <input type="text" name="{$actionid}imagepath" value="{$imagepath}" size="60"/>
    <p>{$mod->Lang('info_imagepath')}</p>
  </div>
</div>

<div class="c_full cf">
  <label class="grid_2">{$mod->Lang('prompt_createhierarchy')}:</label>
  <div class="grid_9">
    <select name="{$actionid}createhierarchy">
      {html_options options=$yesno selected=$flag_createhierarchy}
    </select>
    <p>{$mod->Lang('info_createhierarchy')}</p>
  </div>
</div>

<div class="c_full cf">
  <label class="grid_2">{$mod->Lang('prompt_createcategories')}</label>
  <div class="grid_9">
    <select name="{$actionid}createcategories">
      {html_options options=$yesno selected=$flag_createcategories}
    </select>
    <p>{$mod->Lang('info_createcategories')}</p>
  </div>
</div>

<div class="c_full cf">
  <label class="grid_2">{$mod->Lang('prompt_duplicateproducts')}:</label>
  <div class="grid_9">
    <select name="{$actionid}duplicateproducts">
       <option label="{$mod->Lang('label_skip')}" value="skip" {if $flag_duplicateproducts eq "skip"}selected="selected"{/if}>{$mod->Lang('label_skip')}</option>
       <option label="{$mod->Lang('label_update')}" value="update" {if $flag_duplicateproducts eq "update"}selected="selected"{/if}>{$mod->Lang('label_update')}</option>
       <option label="{$mod->Lang('label_overwrite')}" value="overwrite" {if $flag_duplicateproducts eq "overwrite"}selected="selected"{/if}>{$mod->Lang('label_overwrite')}</option>
    </select>
    <p>{$mod->Lang('info_duplicateproducts')}</p>
  </div>
</div>

<div class="c_full cf">
  <label class="grid_2">{$mod->Lang('prompt_batchsize')}:</label>
  <div class="grid_9">
    <input type="text" name="{$actionid}batchsize" value="{$batchsize}" size="3" maxlength="3"/>
    <p>{$mod->Lang('info_batchsize')}</p>
  </div>
</div>

<div class="c_full cf">
  <label class="grid_2">{$mod->Lang('prompt_clearfields')}:</label>
  <div class="grid_9">
    {cge_yesno_options prefix=$actionid name=clearfields selected=$clearfields}
    <p>{$mod->Lang('info_clearfields')}</p>
  </div>
</div>

<div class="c_full cf">
  <label class="grid_2">{$mod->Lang('prompt_clearattribs')}:</label>
  <div class="grid_9">
    {cge_yesno_options prefix=$actionid name=clearattribs selected=$clearattribs}
    <p>{$mod->Lang('info_clearattribs')}</p>
  </div>
</div>

<div class="c_full cf">
  <label class="grid_2">{$mod->Lang('prompt_clearcategories')}:</label>
  <div class="grid_9">
    {cge_yesno_options prefix=$actionid name=clearcategories selected=$clearcategories}
    <p>{$mod->Lang('info_clearcategories')}</p>
  </div>
</div>

{/if}

<div class="c_full cf">
  <label class="grid_2">{$mod->Lang('prompt_csvfile')}:</label>
  <div class="grid_9">
    {if isset($csvfile)}
    <input type="text" name="{$actionid}csvfile" value="{$csvfile}" readonly=readonly/>
    {else}
    <input type="file" name="{$actionid}csvfile" value="" size="60"/>
    {/if}
  </div>
</div>

<div class="c_full cf">
  <div class="grid_9">
    {if isset($csvfile)}
    <input type="submit" name="{$actionid}go" value="{$mod->Lang('go')}" onclick="return confirm('{$mod->Lang('confirm_import')}');"/>
    {else}
    <input type="submit" name="{$actionid}test" value="{$mod->Lang('test')}"/>
    {/if}
    <input type="submit" name="{$actionid}cancel" value="{$mod->Lang('cancel')}"/>
  </div>
</div>
{$formend}