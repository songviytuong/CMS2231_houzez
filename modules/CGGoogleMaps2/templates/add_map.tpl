<script type="text/javascript">
$(document).ready(function(){
  $('#edit_map_points').on('click',function(){
    return confirm('{$mod->Lang('confirm_edit_map_points')}');
  });
});
</script>

{function do_field allow_extra=1}
  {if isset($field.name)}{$name=$field.name}{/if}
  {if $field.type == 'TEXTAREA'}
    {cge_textarea prefix=$actionid name=$name wysiwyg=$field.wysiwyg syntax=1 content=$field.value}
  {elseif $field.type == 'ICON'}
    <select class="icon_sel" name="{$actionid}{$name}">
    {html_options options=$iconsbyname selected=$field.value|default:$field.dflt}
    </select>
    <img src=""/>
  {elseif $field.type == 'BOOL'}
    <select name="{$actionid}{$name}">
    {cge_yesno_options selected=$field.value}
    </select>
  {elseif $field.type == 'SELECT'}
    <select name="{$actionid}{$name}">
    {cge_str_to_assoc input=$field.options delim1=',' delim2='=>' assign='sel_options'}
    {html_options options=$sel_options selected=$field.value}
    </select>
  {elseif $field.type == 'BUTTON'}
    <input type="submit" name="{$actionid}{$name}" value="{$field.value}"/>
  {else}
    {* handles FLOAT and INT fields too *}
    <input type="text" name="{$actionid}{$name}" size="{$field.size|default:40}" maxlength="{$field.maxlength|default:255}" value="{$field.value}"/>
  {/if}

  {if isset($field.extrafields)}
    <div class="pageinput">
    {foreach $field.extrafields as $ekey => $efld}
      {do_field name=$ekey field=$efld allow_extra=0}&nbsp;
    {/foreach}
    </div>
  {/if}
{/function}

{function base_field}
<div class="pageoverflow">
  <p class="pagetext">{if isset($field.prompt_key)}{$mod->Lang($field.prompt_key)}{else}{$name}{/if}:</p>
  <p class="pageinput">
    {do_field name=$name field=$field}
    {if isset($field.info_key)}
    <br/>
    {$mod->Lang($field.info_key)}
    {/if}
  </p>
</div>
{/function}

{$formstart}{$hidden|default:''}
<h3>
{$mod->Lang('add_map')}
</h3>

<div class="pageoptions">
<input type="submit" name="{$actionid}submit" value="{$mod->Lang('submit')}"/>
{if $map->get_id() != '' }
<input type="submit" name="{$actionid}apply" value="{$mod->Lang('apply')}"/>
<input type="submit" id="edit_map_points" name="{$actionid}edit_map_points" value="{$mod->Lang('edit_map_points')}"/>
{/if}
<input type="submit" name="{$actionid}cancel" value="{$mod->Lang('cancel')}"/>
</div>

{$mod->StartTabHeaders()}
{foreach $field_tabs as $tab}
{$mod->SetTabHeader($tab,ucwords($tab))}
{/foreach}
{$mod->EndTabHeaders()}

{$mod->StartTabContent()}
{foreach $field_tabs as $tab}
  {$mod->StartTab($tab)}
  {foreach from=$fields[$tab] key='name' item='field'}
   {base_field field=$field}
  {/foreach}
  {$mod->EndTab()}
{/foreach}
{$mod->EndTabContent()}
{$formend}