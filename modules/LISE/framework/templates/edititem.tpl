{if $activelang}{$langList}<br/>{/if}
{$backlink}
<h3>{$header}</h3>
{$startform}
<div class="pageoverflow">
    <p class="pageinput">
      <input name="{$actionid}submit" id="lise_submit" value="{lang('submit')}" type="submit" />
      <input name="{$actionid}cancel" id="lise_cancel" value="{lang('cancel')}" type="submit" />
      <input name="{$actionid}apply" id="lise_apply" value="{lang('apply')}" type="submit" />
      <input name="{$actionid}save_create" id="lise_save_create" value="{$mod->ModLang('save_create')}" type="submit" />
    </p>
</div>
<!-- start tab -->
<div id="page_tabs">
	<div id="edititem">
		{$title}
	</div>
    {if count($itemObject)}
      {foreach from=$itemObject->fielddefs item='fielddef'}
        {if $fielddef->type === 'Tabs'}
          {$fielddef->displayTabHeader()}
        {/if}
      {/foreach}
    {/if}
</div>
<!-- end tab //-->
<!-- start content -->
<div id="page_content"> 
  <div id="edititem_result"></div>
  <div id="edititem_c">

    {if isset($input_active)}
      <div class="pageoverflow">
        <p class="pagetext">{$mod->ModLang('active')}:</p>
        <p class="pageinput">{$input_active}</p>
      </div>
    {/if}

    {if $mod->GetPreference('display_create_date', 0) == 1}
      <div class="pageoverflow">
        <p class='pagetext'>{$mod->ModLang('create_time', '')}: <em style='font-weight: normal;'>{$itemObject->create_time}</em></p>
      </div>
    {/if}
    
    <div class="pageoverflow">
      <p class="pagetext">{if ($mod->prefix == "liseseo")}
        SKU
        {else}
        {$mod->GetPreference('item_title', '')}
        {/if}*:</p>
      <p class="pageinput">{$input_title}</p>
    </div>
    {if !($mod->prefix == "liseseo")}
    <div class="pageoverflow">
      <p class="pagetext">{$mod->ModLang('desc', '')}:</p>
      <p class="pageinput">{$input_desc}</p>
    </div>
    
    
    <div class="pageoverflow">
      <p class="pagetext">{$mod->ModLang('alias')}:</p>{$alias|default:''}
      <p class="pageinput">{$input_alias}</p>
    </div>
    
    {if $mod->GetPreference('display_create_date', 0) == 1}
    <div class="pageoverflow">
      <p class="pagetext">{$mod->ModLang('url')}:</p>{$url|default:''}
      <p class="pageinput">{$input_url}</p>
    </div>
    {/if}

    
      
{/if}
    
    {if $time_control_turn == 1}
    <div class="pageoverflow">
      <p class="pagetext">{$mod->ModLang('time_control')}:</p>
      <p class="pageinput">{$input_time_control}</p>
    </div>
    {/if}
    
    
    <div id="expiryinfo"{if $use_time_control != true} style="display:none;"{/if}>
      <div class="pageoverflow">
        <p class="pagetext">{$mod->ModLang('start_time')}:</p>
        <p class="pageinput">{$input_start_time}</p>
      </div>

      <div class="pageoverflow">
        <p class="pagetext">{$mod->ModLang('end_time')}:</p>
        <p class="pageinput">{$input_end_time}</p>
      </div>
    </div>

    {if count($itemObject)}
      {foreach from=$itemObject->fielddefs item='fielddef'}
        {$fielddef->RenderInput($actionid, $returnid)}
      {/foreach}
    {/if} 
 
{*
    <!--added by peterson for separation of jm file picker field-->
    {if count($itemObject)}
      {foreach from=$itemObject->fielddefs item='fielddef'}
        {if $fielddef->type != 'JMFilePicker'}
          {$fielddef->RenderInput($actionid, $returnid)}
        {else}
           {$fielddef->RenderJMFInput($actionid, $returnid, $itemObject)}
           {break}
        {/if}
      {/foreach}
    {/if}
     
*}

{if $extra1_enabled_turn == 1}
    <div class="pageoverflow">
      <p class="pagetext">{$mod->ModLang('extra1_enabled')}:</p>
      <p class="pageinput">{$input_extra1_enabled}</p>
      <p class="pageinput">{$input_extra1_enabled_wysiwyg}</p>
    </div>
    {/if}
    
    {if $extra2_enabled_turn == 1}
    <div class="pageoverflow">
      <p class="pagetext">{$mod->ModLang('extra2_enabled')}:</p>
      <p class="pageinput">{$input_extra2_enabled}</p>
      <p class="pageinput">{$input_extra2_enabled_wysiwyg}</p>
    </div>
    {/if}
    
    {if $extra3_enabled_turn == 1}
    <div class="pageoverflow">
      <p class="pagetext">{$mod->ModLang('extra3_enabled')}:</p>
      <p class="pageinput">{$input_extra3_enabled}</p>
      <p class="pageinput">{$input_extra3_enabled_wysiwyg}</p>
    </div>
    {/if}
    {if $itemObject->owner_name}
    <div class="pageoverflow">
        <p class="pagetext">{admin_icon icon="groupassign.gif" alt="SEO"} <font style="font-weight:normal; font-size:11px;">Edited: {$itemObject->owner_name} | Modified: {$itemObject->modified_time}</font></p>
      </div>
      {/if}
  </div>
  <div class="pageoverflow">
    <p class="pagetext">&nbsp;</p>
    <p class="pageinput">
      <input name="{$actionid}submit" id="lise_submit" value="{lang('submit')}" type="submit" />
      <input name="{$actionid}cancel" id="lise_cancel" value="{lang('cancel')}" type="submit" />
      <input name="{$actionid}apply" id="lise_apply" value="{lang('apply')}" type="submit" />
      <input name="{$actionid}save_create" id="lise_save_create" value="{$mod->ModLang('save_create')}" type="submit" />          
    </p>
  </div>
</div>
{$endform}
<!-- end content //-->
<script type="text/javascript">
var action_id = '{$actionid}';
var item_id = '{$itemObject->item_id|default:-1}';
var ajax_url1 = '{$ajax_get_url}';
var ajax_url2 = '{$ajax_get_alias}';
var manually_changed1 = item_id;
var manually_changed2 = item_id;
var finished_setup = 0;
var ajax_xhr1 = 0;
var ajax_xhr2 = 0;
var ajax_timeout1;
var ajax_timeout2;
ajax_url1 = ajax_url1.replace(/amp;/g,'') + '&suppressoutput=1';
ajax_url2 = ajax_url2.replace(/amp;/g,'') + '&suppressoutput=1';

function ajax_geturl() { 
  var form = $('#lise_edititem form');
  var vtitle = $('#{$actionid}title').val();
  ajax_xhr = $.post(ajax_url1, { title: vtitle, itemid: item_id }, function(retdata){
    $('#{$actionid}url').val(retdata);
    ajax_xhr1 = 0;
});
}

function ajax_get_alias() { 
  var form = $('#lise_edititem form');
  var vtitle = $('#{$actionid}title').val();
  ajax_xhr = $.post(ajax_url2, { title: vtitle }, function(retdata){
    $('#{$actionid}alias').val(retdata);
    ajax_xhr2 = 0;
});
}

function on_change() {
  if( manually_changed1 < 1 && finished_setup == 1) {
    // ajax function to get a unique url given a title.
    if( ajax_timeout1 != undefined ) clearTimeout(ajax_timeout1);
    if( ajax_xhr1 = 0 ) xhr.abort();
    ajax_timeout1 = setTimeout(ajax_geturl,500);
}
  if( manually_changed2 < 1 && finished_setup == 1) {
    // ajax function to get a unique alias given a title.
    if( ajax_timeout2 != undefined ) clearTimeout(ajax_timeout2);
    if( ajax_xhr2 = 0 ) xhr.abort();
    ajax_timeout1 = setTimeout(ajax_get_alias,500);
}
}

jQuery(document).ready(function() {
  
  $('{$actionid}url').keyup(function() {
    var val = $(this).val();
    manually_changed1 = 0
    if( val != '' ) manually_changed1 = 1;
});
  
  $('{$actionid}alias').keyup(function() {
    var val = $(this).val();
    manually_changed1 = 0
    if( val != '' ) manually_changed2 = 1;
});

  $('form').ajaxStart(function() {
    $('*').css('cursor','progress');
});

  $('form').ajaxStop(function() {
    $('*').css('cursor','auto');
});

  $('#{$actionid}title').keyup(function() {
    on_change();
});

  finished_setup = 1;
  
  
  jQuery('[name=m1_apply]').live('click', function() {
    if (typeof tinyMCE != 'undefined') {
      tinyMCE.triggerSave();
  }
  
  var data = jQuery('form').find('input:not([type=submit]), select, textarea').serializeArray();
  
  data.push({
      'name': 'm1_ajax',
      'value': 1
  });
  data.push({
      'name': 'm1_apply',
      'value': 1
  });
  data.push({
      'name': 'showtemplate',
      'value': 'false'
  });
  
  var url = jQuery('form').attr('action');
  
  jQuery.post(url, data, function(resultdata, text) {
      var resp = jQuery(resultdata).find('Response').text();
      var details = jQuery(resultdata).find('Details').text();
      var htmlShow = '';
      if (resp === 'Success' && details !== '') {
        htmlShow = '<div class="pagemcontainer"><p class="pagemessage">' + details + '<\/p><\/div>';
    }
    else {
        htmlShow = '<div class="pageerrorcontainer"><ul class="pageerror">';
        htmlShow += details;
        htmlShow += '<\/ul><\/div>';
    }
    jQuery('#edititem_result').html(htmlShow);
    window.setTimeout(function(){ 
     $('.pagemcontainer').hide(); 
 }, 9000)
}, 'xml');
  return false;
});
});
</script>