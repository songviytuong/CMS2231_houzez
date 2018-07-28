{cge_have_module m='CGGoogleMaps2' assign='have_maps'}
{cge_have_module m='CGClientTickets' assign='have_tickets'}
<script type="text/javascript">{jsmin}
if( typeof jQuery == 'undefined' ) alert('jQuery is requried for this template');
{if $have_maps}
var geocodeurl  = '{module_action_link module='CGGoogleMaps2' action='getgeocode' urlonly=1}' + '&showtemplate=false';
$(document).ready(function(){
 $('#lookupgoeshere').html('<input type="submit" id="lookup" name="lookup" value="{$CompanyDirectory->Lang('lookup')}"/>');
 $('#lookup').on('click',function(e){
  var address = $('#address').val();
  if( address != '' ) {
    var url = geocodeurl.replace(/amp;/g,'');
    var lat = 0;
    var long = 0;
    $.post(url, 'cntnt01address='+address,
      function(data) {
        if( data.status == 'success' ) {
          lat = data.lat; long=data.lon;
          $('#latitude').val(lat);
          $('#longitude').val(long);
        }
      }
      , "json" );
  }
  return false;
 });
{/if}

$(document).ready(function(){
 $('#cancel').on('click',function(){
   var url = '{cms_selflink href=$page_alias}';
   location.replace(url);
   return false;
 });
 $('#edit_album').on('click',function(e){
   return confirm('{$CompanyDirectory->Lang('confirm_edit_album')}');
 });
});
{/jsmin}</script>

<div class="row">
{if $the_company->id > 1}
<h4>{$CompanyDirectory->Lang('editcompany')}</h4>
{else}
<h4>{$CompanyDirectory->Lang('addcompany')}</h4>
{/if}
</div>

{if isset($message)}
<div class="alert alert-danger">{$message}</div>
{/if}

{if $have_tickets}
  {module_action_link module=CGClientTickets action=newticket key1=CompanyDirectory key2=$the_company->id page='my-tickets' urlonly=1 assign='newticket'}
{/if}

{* this template uses bootstrap3 styles *}
{$startform}
<div class="navbar navbar-default" role="navigation">
  <button class="btn btn-default" type="submit" name="{$actionid}cd_submit"><span class="glyphicon glyphicon-ok"></span> {$CompanyDirectory->Lang('submit')}</button>
  <button class="btn btn-default" id="cancel"><span class="glyphicon glyphicon-remove"></span> {$CompanyDirectory->Lang('cancel')}</button>
  {if isset($album_id) &&  $album_id}
    <a id="edit_abum" href="{module_action_link module=CompanyDirectory action=fe_edit_album companyid=$the_company->id cd_fldid=$album_id urlonly=1}">{$CompanyDirectory->Lang('edit_album')}</a>
  {/if}
  {if $have_tickets}
    <a href="{$newticket}" type="button" class="btn btn-default navbar-btn"><span class="glyphicon glyphicon-bell"></span> Create a Ticket about this Company</a>
  {/if}
</div>

<div class="row">
  <p class="col-md-3 text-right">{$CompanyDirectory->Lang('companyname')}:</p>
  <p class="col-md-9">
    <input type="text" name="{$actionid}cd_company_name" value="{$the_company->company_name}" size="50" maxlength="255"/>
  </p>
</div>

{if isset($statuses)}
<div class="row">
  <p class="col-md-3 text-right">{$CompanyDirectory->Lang('status')}:</p>
  <p class="col-md-9">
    <select name="{$actionid}cd_status">
      {html_options options=$statuses selected=$the_company->status}
    </select>
  </p>
</div>
{/if}
<div class="row">
  <p class="col-md-3 text-right">{$CompanyDirectory->Lang('address')}:</p>
  <p class="col-md-9">
    <input type="text" id="address" name="{$actionid}cd_address" value="{$the_company->address}" size="30"/>
    &nbsp;<span id="lookupgoeshere"></span>
  </p>
</div>
<div class="row">
  <p class="col-md-3 text-right">{$CompanyDirectory->Lang('latitude')}:</p>
  <p class="col-md-9">
    <input type="text" name="{$actionid}cd_latitude" id="latitude" value="{$the_company->latitude}" size="10" maxlength="10"/>
  </p>
</div>
<div class="row">
  <p class="col-md-3 text-right">{$CompanyDirectory->Lang('longitude')}:</p>
  <p class="col-md-9">
    <input type="text" name="{$actionid}cd_longitude" id="longitude" value="{$the_company->longitude}" size="10" maxlength="10"/>
  </p>
</div>
<div class="row">
  <p class="col-md-3 text-right">{$CompanyDirectory->Lang('telephone')}:</p>
  <p class="col-md-9">
    <input type="text" name="{$actionid}cd_telephone" value="{$the_company->telephone}" size="20" maxlength="20"/>
  </p>
</div>
<div class="row">
  <p class="col-md-3 text-right">{$CompanyDirectory->Lang('fax')}:</p>
  <p class="col-md-9">
    <input type="text" name="{$actionid}cd_telephone" value="{$the_company->telephone}" size="20" maxlength="20"/>
  </p>
</div>
<div class="row">
  <p class="col-md-3 text-right">{$CompanyDirectory->Lang('contactemail')}:</p>
  <p class="col-md-9">
    <input type="text" name="{$actionid}cd_contact_email" value="{$the_company->contact_email}" size="20" maxlength="20"/>
  </p>
</div>
<div class="row">
  <p class="col-md-3 text-right">{$CompanyDirectory->Lang('website')}:</p>
  <p class="col-md-9">
    <input type="text" name="{$actionid}cd_website" value="{$the_company->website}" size="20" maxlength="20"/>
  </p>
</div>
<div class="row">
  <p class="col-md-3 text-right">{$CompanyDirectory->Lang('details')}:</p>
  <p class="col-md-9">
    {cge_textarea prefix=$actionid name=cd_details wysiwyg=true content=$the_company->details}
  </p>
</div>

{* image, and logo are deprecated *}

<div class="row">
  <p class="col-md-3 text-right">{$CompanyDirectory->Lang('imagetext')}:</p>
  <p class="col-md-9">
    <input type="file" name="{$actionid}cd_image" size="50" accept="image/*"/>
    {if $the_company->image_location}
    <br/>
    {$CompanyDirectory->Lang('current_value')}:&nbsp;{$the_company->image_location}<br/>
    <label for="cd_deleteimage">{$CompanyDirectory->Lang('delete')}&nbsp;</label><input type="checkbox" name="{$actionid}cd_deleteimage" value="1" id="cd_deleteimage"/>
    {/if}
  </p>
</div>

<div class="row">
  <p class="col-md-3 text-right">{$CompanyDirectory->Lang('logotext')}:</p>
  <p class="col-md-9">
    <input type="file" name="{$actionid}cd_logo" size="50" accept="image/*"/>
    {if $the_company->logo_location}
    <br/>
    {$CompanyDirectory->Lang('current_value')}:&nbsp;{$the_company->logo_location}<br/>
    <label for="cd_deletelogo">{$CompanyDirectory->Lang('delete')}&nbsp;</label><input type="checkbox" name="{$actionid}cd_deletelogo" value="1" id="cd_deletelogo"/>
    {/if}
  </p>
</div>

{if isset($fielddefs)}
 {foreach $fielddefs as $fldname => $fielddef}
 {$fld_value=$the_company->get_field_value($fielddef->id)}
 <div class="row">
   <p class="col-md-3 text-right">{$fielddef->name}:</p>
   <p class="col-md-9">
     {if $fielddef->type == 'file' || $fielddef->type == 'image'}
       <input type="file" name="{$actionid}cd_field_{$fielddef->id}" size="50"/>
       {if isset($fld_value) && $fld_value}
       <br/>
       {$CompanyDirectory->Lang('current_value')}:&nbsp;{$fld_value|default:''}
       <br/>
       <label for="cd_field_{$fielddef->id}">{$CompanyDirectory->Lang('delete')}&nbsp;</label><input type="checkbox" id="cd_field_{$fielddef->id}" name="{$actionid}cd_deletefield_{$fielddef->id}" value="1"/>
        {/if}
     {elseif $fielddef->type == 'checkbox'}
       <input type="checkbox" name="{$actionid}cd_field_{$fielddef->id}" value="1" {if $fld_value}checked="checked"{/if}/>
     {elseif $fielddef->type == 'textbox'}
       <input type="text" name="{$actionid}cd_field_{$fielddef->id}" value="{$fld_value|default:''}" size="50" maxlength="255"/>
     {elseif $fielddef->type == 'textarea'}
       <textarea name="{$actionid}cd_field_{$fielddef->id}" rows="5" cols="50">{$fld_value|default:''}</textarea>
     {elseif $fielddef->type == 'dropdown' || $fielddef->type == 'icon'}
       <select name="{$actionid}cd_field_{$fielddef->id}">
       {html_options options=$fielddef->options selected=$fld_value|default:''}
       </select>
     {elseif $fielddef->type == 'multiselect'}
       <select name="{$actionid}cd_field_{$fielddef->id}[]" size="3" multiple="multiple">
       {html_options options=$fielddef->options selected=$fielddef->selected|default:''}
       </select>
     {/if}
   </p>
 </div>
 {/foreach}
{/if}

<div class="row">
 <p class="col-md-3 text-right">{$CompanyDirectory->Lang('hierarchy')}:</p>
 <p class="col-md-9">
   <select name="{$actionid}cd_hier_id">
     {html_options options=$hierarchy_list selected=$the_company->hier_id}
   </select>
 </p>
</div>

{if isset($categories) && count($categories)}
<div class="row">
  <p class="col-md-3 text-right">{$CompanyDirectory->Lang('categories')}:</p>
  <p class="col-md-9">
    <select name="{$actionid}cd_categories[]" multiple="multiple" size="5">
      {html_options options=$catnames selected=$sel_categories}
    </select>
  </p>
</div>
{/if}

{$endform}
