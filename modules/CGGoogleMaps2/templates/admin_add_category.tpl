{* add or edit category *}
<script type="text/javascript">
{literal}
/*<![CDATA[*/
var iconsbyname = new Array();
{/literal}
{foreach from=$iconsbyname key='name' item='url'}
iconsbyname['{$name}'] = '../{$url}';
{/foreach}
{literal}
/*]]> */

jQuery(document).ready(function(){
  jQuery('#sel_icon').change(function(){
    var val = jQuery(this).val();
    val = iconsbyname[val];
    jQuery('#img_icon').attr('src',val);
  });
});

{/literal}
</script>

{if $category->get_name() != ''}
<h3>{$mod->Lang('edit_category')}: {$category->get_name()}</h3>
{else}
<h3>{$mod->Lang('add_category')}</h3>
{/if}

{$formstart}
<div><input type="hidden" name="{$actionid}catid" value="{$category->get_id()}"/></div>

<div class="pageoverflow">
  <p class="pagetext">{$mod->Lang('name')}:</p>
  <p class="pageinput">
    <input type="text" name="{$actionid}name" size="50" maxlength="100" value="{$category->get_name()}"/>
  </p>
</div>

<div class="pageoverflow">
  <p class="pagetext">{$mod->Lang('icon')}:</p>
  <p class="pageinput">
    <select name="{$actionid}icon" id="sel_icon">
    {html_options options=$icons selected=$category->get_icon()}
    </select>
    <br/>
    {assign var='sel_icon' value=$category->get_icon()}
    <img style="margin-top: 2px;" id="img_icon" src="../{$iconsbyname.$sel_icon}" alt=""/>
  </p>
</div>

<div class="pageoverflow">
  <p class="pagetext">{$mod->Lang('info')}:</p>
  <p class="pageinput">
    {$input_info}
  </p>
</div>

<div class="pageoverflow">
  <p class="pagetext"></p>
  <p class="pageinput">
    <input type="submit" name="{$actionid}submit" value="{$mod->Lang('submit')}"/>
    <input type="submit" name="{$actionid}cancel" value="{$mod->Lang('cancel')}"/>
  </p>
</div>
{$formend}