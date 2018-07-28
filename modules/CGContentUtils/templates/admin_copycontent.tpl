{* copy content template *}
<script type='text/javascript'>
// <![CDATA[ 
{literal}
jQuery(document).ready(function(){
  $('div.advanced').hide();
  $('#advanced').change(function(){
    $('div.advanced').toggle('slow');
  });

  jQuery('.extralink').click(function(){
    var tmp = jQuery(this).attr('rel');
    jQuery('#extra'+tmp).toggle();
    return false;
  });
  jQuery('.contentlink').click(function(){
    jQuery(this).parent().next().toggle();
    return false;
  });
});
{/literal}
// ]]>
</script>

<h3>{$mod->Lang('advanced_content_copy')}</h3>
<div class="row"><input type="checkbox" value="1" id="advanced"/>&nbsp;<label for="advanced">{$mod->Lang('morefields')}</label>
{$formstart}

{foreach from=$contents item='onecontent' key='content_id' name='contentloop'}
<fieldset>
  <legend>{$onecontent->Name()} ({$content_id}:&nbsp;{$onecontent->Alias()})
  </legend>
  <div class="row">
    <div class="half">
      <p class="pagetext">{$mod->Lang('new_name')}:</p>
      <p class="pageinput">
        <input type="text" name="{$actionid}new_name[{$content_id}]" size="50" maxlength="255" value="{$onecontent->Name()}"/>
      </p>
    </div>    
    <div class="half advanced">
      <p class="pagetext">{$mod->Lang('new_menutext')}:</p>
      <p class="pageinput">
        <input type="text" name="{$actionid}new_menutext[{$content_id}]" size="50" maxlength="255" value="{$onecontent->Menutext()}"/>
      </p>
    </div>
  </div>
  <div class="pageoverflow half">
    <p class="pagetext">{$mod->Lang('new_parent')}:</p>
    <p class="pageinput">
      {$parent_dropdowns.$content_id}
    </p>
  </div>

  <div class="advanced pageoverflow">
    <p class="pagetext">{$mod->Lang('new_alias')}:</p>
    <p class="pageinput">
      <input type="text" name="{$actionid}new_alias[{$content_id}]" size="50" maxlength="255" value=""/>
    </p>
  </div>
</fieldset>
{/foreach}

<div class="pageoverflow">
  <p class="pagetext">&nbsp;</p>
  <p class="pageinput">
    <input type="submit" name="{$actionid}submit" value="{$mod->Lang('submit')}"/>
    <input type="submit" name="{$actionid}cancel" value="{$mod->Lang('cancel')}"/>
  </p>
</div>
{$formend}