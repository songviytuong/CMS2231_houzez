{*
#CMS - CMS Made Simple
#(c)2004-6 by Ted Kulp (ted@cmsmadesimple.org)
#This project's homepage is: http://cmsmadesimple.org
#
#This program is free software; you can redistribute it and/or modify
#it under the terms of the GNU General Public License as published by
#the Free Software Foundation; either version 2 of the License, or
#(at your option) any later version.
#
#This program is distributed in the hope that it will be useful,
#but WITHOUT ANY WARRANTY; without even the implied warranty of
#MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
#GNU General Public License for more details.
#You should have received a copy of the GNU General Public License
#along with this program; if not, write to the Free Software
#Foundation, Inc., 59 Temple Place, Suite 330, Boston, MA  02111-1307  USA
#
#$Id$
*}

<script type="text/javascript">
//var compid = '{$compid|default:''}';
var actionid = '{$actionid}';
var geocodeurl  = '{module_action_link module='CompanyDirectory' action='geolocate' urlonly=1 jsfriendly=1}' + '&suppressoutput=false';
var checkurl = '{module_action_link module='CompanyDirectory' action='checkurl' urlonly=1 jsfriendly=1}' + '&showtemplate=false';

$(document).ready(function(){
  $('.expandit').click(function(){
    $(this).parent().next('.expandable').slideToggle(1000);
  });
  $('#btn_lookup').live('click',function(){
    var tmp = document.getElementsByName(actionid+'address');
    var address = tmp[0].value;

    var lat = 0;
    var long = 0;
    jQuery.post(geocodeurl, '{$actionid}address='+address,
  	function(data) {
            if( data.status == 'success' ) {
              lat = data.lat; long=data.lon;

              var latfield = document.getElementsByName(actionid+'latitude')[0];
              var longfield = document.getElementsByName(actionid+'longitude')[0];
  	      latfield.value = lat;
	      longfield.value = long;
              return false;
            }
	},'json');
    return false;
  });

  $('[name=btn_geturl]').live('click',function(){
    var name = encodeURIComponent($('#nametext').val());
    var turl = encodeURIComponent($('#urltext').val());
    if( turl != '' ) {
      alert('{$mod->Lang('error_urlnotempty')}');
      return false;
    }

    var url = checkurl.replace(/amp;/g,'');
    jQuery.post(url,'m1_cd_name='+name,
    	  function(data) {
	    if( data.status == 'OK' ) {
              $('#urltext').val(data.url);
	      return false;
            }
          }, 'json' );
    return false;
  });

  $('[name=btn_checkurl]').live('click',function(){
    var name = encodeURIComponent(jQuery('#nametext').val());
    var turl = encodeURIComponent(jQuery('#urltext').val());
    if( turl == '' ) return;

    var url = checkurl.replace(/amp;/g,'');
    jQuery.post(url,'m1_cd_name='+name+'&m1_cd_url='+turl,
	function(data) {
	  if( data.status == 'OK' ) {
	    alert('url is okay');
	  } else {
	    alert('problems with the URL')
	  }
          return false;
        }, 'json' );
    return false;
  });

  $('input.cat_sel').change(function(){
    if( $(this).is(':checked') ) {
      $(this).parent().next('a.cat_extrainfo').show();
    } else {
      $(this).parent().next('a.cat_extrainfo').hide();
    }
  })
  $('input.cat_sel').trigger('change');

  $('a.cat_extrainfo').click(function(){
    var catid = $(this).data('catid')
    var catname = $(this).data('catname')
    var e1 = "input[name='{$actionid}category_extra1[id-"+catid+"]']";
    var e2 = "input[name='{$actionid}category_extra2[id-"+catid+"]']";
    var e3 = "input[name='{$actionid}category_extra3[id-"+catid+"]']";
    $('#cat_extra1').val($(e1).val());
    $('#cat_extra2').val($(e2).val());
    $('#cat_extra3').val($(e3).val());
    $('#cat_extrainfo_dlg').attr('title','{$mod->Lang('cat_extrainfo')}: '+catname).dialog({
      modal: true,
      height: 'auto',
      buttons: [
        {
          text: '{$mod->Lang('submit')}',
	  click: function() {
	    $(e1).val($('#cat_extra1').val());
	    $(e2).val($('#cat_extra2').val());
	    $(e3).val($('#cat_extra3').val());
	    $(this).dialog('close');
	  }
	}
      ]
    });
  })
  /* jQuery('a.fancybox').fancybox(); */
});
</script>

{$startform}
<h3>
{if isset($compid) && $compid}
  {$mod->Lang('prompt_editcompany')}: {$company_name} ({$compid})
{else}
  {$mod->Lang('prompt_addcompany')}
{/if}
</h3>

<div class="pageoverflow">
  <p class="pageinput">{$hidden}{$submit}{if isset($cancel)}{$cancel}{/if}</p>
</div>

{$mod->StartTabHeaders()}
{$mod->SetTabHeader('company',$mod->Lang('company'))}
{$mod->SetTabHeader('fields',$mod->Lang('fields'))}
{if isset($album_field_exists) && isset($compid) && $compid}
{$mod->SetTabHeader('album',$mod->Lang('album'))}
{/if}
{$mod->EndTabHeaders()}

{$mod->StartTabContent()}
{$mod->StartTab('company')}
<div class="c_full">
  <div class="grid_6">
	<div class="pageoverflow">
		<p class="pagetext">*{$nametext}:</p>
		<p class="pageinput">
                  <input type="text" id="nametext" name="{$actionid}ex_company_name" value="{$company_name}" size="30" maxlength="255"/>
                </p>
	</div>
	<div class="pageoverflow">
		<p class="pagetext">{$addresstext}:</p>
		<p class="pageinput">
		  <input type="text" name="{$actionid}address" value="{$address}" size="50"/>
                  {if isset($can_geocode)}
		  <br/><input type="submit" name="btn_lookup" id="btn_lookup" value="{$mod->Lang('lookup')}"/>
                  {/if}
                </p>
	</div>
	<div class="pageoverflow coords">
		<p class="pagetext">{$mod->Lang('latitude')}:</p>
		<p class="pageinput">{$inputlatitude}</p>
	</div>
	<div class="pageoverflow coords">
		<p class="pagetext">{$mod->Lang('longitude')}:</p>
		<p class="pageinput">{$inputlongitude}</p>
	</div>
	<div class="pageoverflow">
		<p class="pagetext">{$telephonetext}:</p>
		<p class="pageinput">{$inputtelephone}</p>
	</div>
	<div class="pageoverflow">
		<p class="pagetext">{$faxtext}:</p>
		<p class="pageinput">{$inputfax}</p>
	</div>
	<div class="pageoverflow">
		<p class="pagetext">{$emailtext}:</p>
		<p class="pageinput">{$inputemail}</p>
	</div>
	<div class="pageoverflow">
		<p class="pagetext">{$websitetext}:</p>
		<p class="pageinput">{$inputwebsite}</p>
	</div>
  </div>{* .grid_6 *}
  <div class="grid_6">
	<div class="pageoverflow">
		<p class="pagetext">{$statustext}:</p>
		<p class="pageinput">{$inputstatus}</p>
	</div>
	<div class="pageoverflow">
		<p class="pagetext">{if $url_required}*{/if}{$mod->Lang('url')}:</p>
		<p class="pageinput">
                  <input type="text" id="urltext" name="{$actionid}url" value="{$url}" size="30" maxlength="255">&nbsp;
                  <input type="submit" name="btn_geturl" id="btn_geturl" value="{$mod->Lang('geturl')}"/>
                  <input type="submit" name="btn_checkurl" id="btn_checkurl" value="{$mod->Lang('check')}"/>
                </p>
	</div>

	{if $categoriescount gt 0}
        <fieldset>
          <legend>{$mod->Lang('categories')}:</legend>
	  <div style="max-height: 30em; overflow-y: auto; padding-top: 5px; padding-bottom: 5px;">
	  {foreach $categories as $category}
	    <label>
	      {repeat string='&nbsp;&nbsp;' times=$category->depth}
	      <input class="cat_sel" type="checkbox" name="{$actionid}category[id-{$category->id}]" value="true" {if $category->value|default:0 == 1}checked="checked"{/if}/> {$category->name}
	    </label>
	    <a class="cat_extrainfo" data-catname="{$category->name}" data-catid="{$category->id}">{cgimage class="systemicon" image='icons/system/expand.gif' alt="foo"}</a>
	    <input type="hidden" name="{$actionid}category_extra1[id-{$category->id}]" value="{$category->extra1_val|default:''}"/>
	    <input type="hidden" name="{$actionid}category_extra2[id-{$category->id}]" value="{$category->extra2_val|default:''}"/>
	    <input type="hidden" name="{$actionid}category_extra3[id-{$category->id}]" value="{$category->extra3_val|default:''}"/>
	    {if !$category@last}<br/>{/if}
	  {/foreach}
	  </div>
        </fieldset>
	{/if}

        <div class="pageoverflow">
          <p class="pagetext">{$mod->Lang('hierarchy')}:</p>
          <p class="pageinput">{$inputhierpos}</p>
        </div>
{if isset($feu_users)}
	<div class="pageoverflow">
		<p class="pagetext">{$mod->Lang('owner')}:</p>
		<p class="pageinput">
                  <select name="{$actionid}owner_id">
                  {html_options options=$feu_users selected=$owner_id}
                  </select>
                </p>
	</div>
{/if}

  </div>
</div>
<div class="cf"></div>

<div class="c_full cf">
  <div class="grid_12">
	<div class="pageoverflow">
		<p class="pagetext">{$detailstext}:</p>
		<p class="pageinput">{$inputdetails}</p>
	</div>
	<div class="pageoverflow">
		<p class="pagetext">{$imagetext}:</p>
		<p class="pageinput">
		  <input type="file" name="{$actionid}imageupload"/>
		  {if $imagecurrent ne ''}{$mod->Lang('current_value')}: {$imagecurrent}{$imagecurrenthidden}{/if}
		</p>
	</div>
	<div class="pageoverflow">
		<p class="pagetext">{$logotext}:</p>
		<p class="pageinput">
		  <input type="file" name="{$actionid}logoupload"/>
		  {if $logocurrent ne ''}{$mod->Lang('current_value')}: {$logocurrent}{$logocurrenthidden}{/if}
		</p>
	</div>
  </div>
</div>
{$mod->EndTab()}{* company *}

{$mod->StartTab('fields')}
	{if $customfieldscount gt 0}
		{foreach from=$customfields item=customfield}
                {if $customfield->type != 'album'}
			<div class="pageoverflow">
				<p class="pagetext">{$customfield->name} ({$customfield->type}):</p>
				<p class="pageinput">{$customfield->input_box}
                                {if isset($customfield->thumb_url)}
                                <br/><a class="fancybox" href="{$customfield->image_url}"><img src="{$customfield->thumb_url}"></a>
                                {/if}
                                </p>
			</div>
                {/if}
		{/foreach}
        {else}
            <p style="color: red;">{$mod->Lang('info_nofields')}</p>
	{/if}
{$mod->EndTab()}{* fields *}

{* begin album tab *}
{if isset($album_field_exists) && isset($compid) && $compid}
{$mod->StartTab('album')}
{include file='module_file_tpl:CompanyDirectory;editcompany_album.tpl'}
{$mod->EndTab()}
{/if}
{* end album tab *}

{$mod->EndTabContent()}
{$endform}

<div id="cat_extrainfo_dlg" style="display: none;">
  <div class="information">{$mod->Lang('info_category_extrainfo')}</div>
  <div class="pageoverflow">
    <p class="pagetext">{$mod->Lang('extra1')}:</p>
    <p class="pageinfo">
      <input type="text" id="cat_extra1" size="80" maxlength="255"/>
    </p>
  </div>
  <div class="pageoverflow">
    <p class="pagetext">{$mod->Lang('extra2')}:</p>
    <p class="pageinfo">
      <input type="text" id="cat_extra2" size="80" maxlength="255"/>
    </p>
  </div>
  <div class="pageoverflow">
    <p class="pagetext">{$mod->Lang('extra3')}:</p>
    <p class="pageinfo">
      <input type="text" id="cat_extra3" size="80" maxlength="255"/>
    </p>
  </div>
</div>
