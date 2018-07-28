{literal}
<script type="text/javascript">
$(document).ready(function(){
  $('#blocktype').change(function(){
    $('.blocktypes').hide();
    $('#'+$(this).val()).show();
  });
  $('#blocktype').trigger('change');
});
</script>
{/literal}

<style type="text/css" scoped>
textarea.prompt {
   max-height: 3em;
   max-width:  50em;
}
</style>

{if isset($one.id) && $one.id > 0}
<h3>{$mod->Lang('title_edit_block')}</h3>
{else}
<h3>{$mod->Lang('title_add_block')}</h3>
{/if}

{$formstart}
<div class="pageoverflow">
  <div class="pagetext">*{$mod->Lang('name')}:</div>
  <div class="pageinput">
    <input type="text" name="{$actionid}name" value="{$one.name}" size="40" placeholder="{$mod->Lang('ph_name')}"/>
    <br/>{$mod->Lang('info_blockname')}
  </div>
</div>

<div class="pageoverflow">
  <div class="pagetext">{$mod->Lang('prompt')}:</div>
  <div class="pageinput">
    <textarea class="prompt" rows="3" cols="60" name="{$actionid}prompt" placeholder="{$mod->Lang('ph_prompt')}">{$one.prompt}</textarea>
    <br/>{$mod->Lang('info_blockprompt')}
  </div>
</div>

<div class="pageoverflow">
  <div class="pagetext">*{$mod->Lang('type')}:</div>
  <div class="pageinput">
    <select id="blocktype" name="{$actionid}type">
      {html_options options=$blocktypes selected=$one.type}
    </select>
  </div>
</div>

<div id="default_value" class="pageoverflow">
  <div class="pagetext">{$mod->Lang('default_value')}:</div>
  <div class="pageinput">
    <input type="text" name="{$actionid}dfltvalue" value="{$one.value}"/>
  </div>
</div>

<div class="blocktypes" id="textinput">
  <div class="pageoverflow">
    <div class="pagetext">*{$mod->Lang('prompt_length')}:</div>
    <div class="pageinput">
      <input type="text" name="{$actionid}length" size="3" maxlength="3" value="{$one.attribs.length}" />
    </div>
  </div>

  <div class="pageoverflow">
    <div class="pagetext">*{$mod->Lang('prompt_maxlength')}:</div>
    <div class="pageinput">
      <input type="text" name="{$actionid}maxlength" size="3" maxlength="3" value="{$one.attribs.maxlength}" />
    </div>
  </div>
</div>

<div class="blocktypes" id="advpageselector">
  <div class="pageoverflow">
    <div class="pagetext">*{$mod->Lang('prompt_adv_start')}:</div>
    <div class="pageinput">
      <select name="{$actionid}adv_start">
        {cge_pageoptions none=true selected=$one.attribs.adv_start}
      </select>
    </div>
  </div>

  <div class="pageoverflow">
    <div class="pagetext">*{$mod->Lang('prompt_adv_navhidden')}:</div>
    <div class="pageinput">
      <select name="{$actionid}adv_navhidden">
        {cge_yesno_options selected=$one.attribs.adv_navhidden}
      </select>
    </div>
  </div>
</div>

<div class="blocktypes" id="textarea">
  <div class="pageoverflow">
    <div class="pagetext">*{$mod->Lang('prompt_rows')}:</div>
    <div class="pageinput">
      <input type="text" name="{$actionid}rows" size="3" maxlength="3" value="{$one.attribs.rows}" />
    </div>
  </div>

  <div class="pageoverflow">
    <div class="pagetext">*{$mod->Lang('prompt_cols')}:</div>
    <div class="pageinput">
      <input type="text" name="{$actionid}cols" size="3" maxlength="3" value="{$one.attribs.cols}" />
    </div>
  </div>

  <div class="pageoverflow">
    <div class="pagetext">*{$mod->Lang('prompt_wysiwyg')}:</div>
    <div class="pageinput">
      {cge_yesno_options prefix=$actionid name=wysiwyg selected=$one.attribs.wysiwyg|default:0}
    </div>
  </div>
</div>

<div class="blocktypes" id="statictext">
  <div class="pageoverflow">
    <div class="pagetext">*{$mod->Lang('prompt_text')}:</div>
    <div class="pageinput">
      <textarea name="{$actionid}fieldtext">{$one.attribs.fieldtext|default:''}</textarea>
      <br/>
      {$mod->Lang('info_statictext')}
    </div>
  </div>
</div>

<div class="blocktypes" id="dropdown">
  <div class="pageoverflow">
    <div class="pagetext">*{$mod->Lang('prompt_options')}:</div>
    <div class="pageinput">
      <textarea name="{$actionid}options" cols="50" rows="5">{$one.attribs.options}</textarea>
      <br/>
      {$mod->Lang('info_dropdown_options')}
    </div>
  </div>
</div>

<div class="blocktypes" id="sortable_list">
  <div class="pageoverflow">
    <div class="pagetext">*{$mod->Lang('prompt_options')}:</div>
    <div class="pageinput">
      <textarea name="{$actionid}sortable_list" cols="50" rows="5">{$one.attribs.options}</textarea>
      <br/>
      {$mod->Lang('info_dropdown_options')}
    </div>
  </div>
  <div class="pageoverflow">
    <div class="pagetext">*{$mod->Lang('prompt_sortable_maxitems')}:</div>
    <div class="pageinput">
      <input type="text" name="{$actionid}sortable_maxitems" size="3" value="{$one.attribs.sortable_maxitems|default:''}"/>
      <br/>
      {$mod->Lang('info_sortable_maxitems')}
    </div>
  </div>

</div>

<div class="blocktypes" id="dropdown_udt">
  <div class="pageoverflow">
    <div class="pagetext">*{$mod->Lang('prompt_udt')}:</div>
    <div class="pageinput">
      <select name="{$actionid}dropdown_udt">
        {html_options options=$usertags selected=$one.attribs.udt}
      </select>
      <br/>{$mod->Lang('info_seludt')}
    </div>
  </div>
</div>

<div class="blocktypes" id="multiselect">
  <div class="pageoverflow">
    <div class="pagetext">*{$mod->Lang('prompt_options')}:</div>
    <div class="pageinput">
      <textarea name="{$actionid}multiselect" cols="50" rows="5">{$one.attribs.options}</textarea>
      <br/>{$mod->Lang('info_dropdown_options')}
    </div>
  </div>
  <div class="pageoverflow">
    <div class="pagetext">*{$mod->Lang('prompt_storagedelimiter')}:</div>
    <div class="pageinput">
      <input type="text" name="{$actionid}storagedelimiter" size="5" value="{$one.attribs.storagedelimiter|default:''}"/>
      <br/>{$mod->Lang('info_storagedelimiter')}
    </div>
  </div>
</div>

<div class="blocktypes" id="checkbox">
  <div class="pageoverflow">
    <div class="pagetext">*{$mod->Lang('prompt_value')}:</div>
    <div class="pageinput">
      <input type="text" name="{$actionid}value" size="80" maxlength="255" value="{$one.attribs.value}" />
    </div>
  </div>
</div>

<div class="blocktypes" id="radiobuttons">
  <div class="pageoverflow">
    <div class="pagetext">*{$mod->Lang('prompt_options')}:</div>
    <div class="pageinput">
      <textarea name="{$actionid}radiooptions">{$one.attribs.options}</textarea>
      <br/>{$mod->Lang('info_dropdown_options')}
    </div>
  </div>
</div>

<div class="blocktypes" id="gcb_selector">
  <div class="pageoverflow">
    <div class="pagetext">{$mod->Lang('prompt_gcb_prefix')}:</div>
    <div class="pageinput">
      <input name="{$actionid}gcb_prefix" size="20" maxlength="20" value="{$one.attribs.gcb_prefix|default:''}"/>
      <br/>{$mod->Lang('info_gcb_prefix')}
    </div>
  </div>
</div>

<div class="blocktypes" id="file_selector">
  <div class="pageoverflow">
    <div class="pagetext">{$mod->Lang('prompt_dir')}:</div>
    <div class="pageinput">
      <select name="{$actionid}directory">
      {html_options options=$directories selected=$one.attribs.dir|default:''}
      </select>
    </div>
  </div>

  <div class="pageoverflow">
    <div class="pagetext">{$mod->Lang('prompt_filetypes')}:</div>
    <div class="pageinput">
      <input name="{$actionid}filetypes" size="20" maxlength="255" value="{$one.attribs.filetypes|default:''}"/>
      <br/>{$mod->Lang('info_filetypes')}
    </div>
  </div>

  <div class="pageoverflow">
    <div class="pagetext">{$mod->Lang('prompt_excludeprefix')}:</div>
    <div class="pageinput">
      <input type="text" name="{$actionid}excludeprefix" size="20" maxlength="255" value="{$one.attribs.excludeprefix|default:''}"/>
      <br/>{$mod->Lang('info_excludeprefix')}
    </div>
  </div>

  <div class="pageoverflow">
    <div class="pagetext">{$mod->Lang('prompt_recurse')}:</div>
    <div class="pageinput">
      <select name="{$actionid}recurse">
      {cge_yesno_options selected=$one.attribs.recurse}
      </select>
    </div>
  </div>

  <div class="pageoverflow">
    <div class="pagetext">{$mod->Lang('prompt_sortfiles')}:</div>
    <div class="pageinput">
      <select name="{$actionid}sortfiles">
      {cge_yesno_options selected=$one.attribs.sortfiles}
      </select>
    </div>
  </div>
</div>

<div class="pageoverflow">
  <div class="pagetext"></div>
  <div class="pageinput">
    <input type="submit" name="{$actionid}submit" value="{$mod->Lang('submit')}"/>
    <input type="submit" name="{$actionid}cancel" value="{$mod->Lang('cancel')}"/>
  </div>
</div>
{$formend}