{*
 ** frontend edit album template **
 This is a sample template... illustrating how to enable editing using the fe_edit_gallery action
 Like all other module templates, this is not intended to be a complete working solution for all websites.  It is simply a starting point.

 This template provides sorting, drag and drop upload (for most non IE browsers) and drag to delete functionality.  but it's styling is crude.

 This template uses the JQueryUI progrees bar, draggable and droppable classes, as well as the bluimp file upload capabilities.
 These javascript libraries must be included in the page before this template can be  used successfully.

 The file field named 'image_upload' is important and must be retained.
 The fe_edit_album action accepts these parameters:
   companyid    = the company id
   cd_fldid     = the field id (must be a field of type album, and must be public)
   cd_subaction = none (outputs whole template), gallery, delete, sort, or upload
   cd_order     = array of integers representing the new order (for the sort subaction)
   cd_idx       = integer index of the item to delete (for the delete subaction)
*}

{if $subaction != 'gallery'}
<script type="text/javascript">
//<![CDATA[
function _refresh_gallery() {
  $('#cd_edit_gallery').load('{module_action_link module='CompanyDirectory' action=$actionparams.action companyid=$companyid cd_fldid=$actionparams.cd_fldid cd_subaction=gallery urlonly=1 jsfriendly=1}&showtemplate=false',function(){
  // fancyboxes for images
  if( $.fancybox ) {
     $('a.fancybox').fancybox();
   }

   $('#cd_edit_gallery_files li').draggable({
     revert: 'invalid'
   });

   // make sortable stuff
   $('#cd_edit_gallery_files').sortable({
     cursor: 'crosshair',
     update: function() {
       var order = [];
       $('#cd_edit_gallery_files li').each(function(idx,elm){
         alert(elm.id+' '+elm.id.split('_',3)[2]);
         order.push(elm.id.split('_',3)[2]);
       });
       $.ajax({
         url: '{module_action_link module='CompanyDirectory' action=$actionparams.action companyid=$companyid cd_fldid=$actionparams.cd_fldid cd_subaction=sort urlonly=1 jsfriendly=1}&showtemplate=false',
	 type: 'POST',
         data: { cntnt01cd_order: order },
         success: function(data,textStatus,jqXHR) {
           _refresh_gallery();
         }
       });
     }
   });
 });
}

$(document).ready(function(){
  _refresh_gallery();

  if( $.fileupload ) {
    $(document).bind('drop dragover', function(e) {
      e.preventDefault();
    });
  }

  // drag/drop upload stuff
  $('#image_upload').fileupload({
    dataType: 'json',
    dropzone: $('#cd_album_dropzone'),
    url: '{module_action_link module=CompanyDirectory action=$actionparams.action companyid=$companyid cd_fldid=$actionparams.cd_fldid cd_subaction=upload urlonly=1 jsfriendly=1}&showtemplate=false',
    form: null,
    formData: { cntnt01cd_foo: 'bar' },
    maxChunkSize: 500*1024,

    progressall: function(e,data) {
      // create a progress bar (requires jquery UI)
      if( $.progressbar ) {
        var total = (data.loaded / data.total * 100).toFixed(0);
        $('#cd_album_dropzone').progressbar({ value: parseInt(total) });
        $('.ui-progressbar-value').html(total+'%');
      }
    },

    stop: function(e,data) {
      // hide the progress bar (requires jquery UI)
      if( $.progressbar ) {
        $('#cd_album_dropzone').progressbar('destroy');
      }
    },

    done: function(e,data) {
      if( data.result ) {
        for( var key in data.result ) {
          if( data.result[key].error ) {
            alert(data.result[key].name+' failed: '+data.result[key].error);
          }
        }
      }
      _refresh_gallery();
    }
  });

  $('#cd_album_delzone').droppable({
     drop: function(event,ui) {
       ui.draggable.fadeOut('slow');
       var x = ui.draggable.attr('id');
       var idx = x.split('_',3)[2];

       $.ajax({
         url: '{module_action_link module='CompanyDirectory' action=$actionparams.action companyid=$companyid cd_fldid=$actionparams.cd_fldid cd_subaction=delete urlonly=1 jsfriendly=1}&showtemplate=false',
         type: 'POST',
         data: { cntnt01cd_idx: idx },
	 error: function (jqXHR, textStatus, errorThrown) {
           alert('upload failed: '.errorThrown);
         },
         success: function( data, textStatus, jqXHR ) {
           _refresh_gallery();
         }
       });
     }
  });
});
//]]>
</script>

<style type="text/css">
{* this css should be moved into your public stylesheets *}
#cd_edit_gallery_files li {
  margin: 3px 3px 3px 0; padding: 1px;
  float: left;
  width: 100px;
  height: 90px;
  font-size: 4em;
  text-align: center;
  border: 1px solid black;
}
#cd_album_dropzone {
  height: 64px;
  width: 64px;
  float: left;
  bordeR: 1px solid red;
  background-image: url('{root_url}/modules/CompanyDirectory/icons/upload_sm.png');
}
#cd_album_delzone {
  height: 64px;
  width: 64px;
  float: left;
  border: 1px solid green;
  background-image: url('{root_url}/modules/CompanyDirectory/icons/recycle_sm.png');
}
</style>

{cge_isie assign='ie'}
<fieldset>
<legend>{$CompanyDirectory->Lang('upload')}:</legend>
  <div style="width: 49%; float: left;">
    <input type="file" name="image_upload" id="image_upload" multiple/>
  </div>
  {if !$ie}
  <div style="width: 49%; float: left;">
    <div id="cd_album_dropzone" title="{$CompanyDirectory->Lang('drop_here')}"></div>
    <div id="cd_album_delzone" title="{$CompanyDirectory->Lang('drop_here_to_delete')}"></div>
  </div>
  {/if}
  <div style="clear: both;"></div>
</fieldset>

<div id="cd_edit_gallery">
{/if}

  {if isset($files)}
    <ul id="cd_edit_gallery_files" style="list-style: none;">
    {foreach from=$files item='one_file'}
      <li id="file_idx_{$one_file@index}"><a class="fancybox" href="{CGSmartImage src1=$base_url src2=$one_file noembed=1 width=500 width=500 notag=1}">{CGSmartImage src1=$base_dir src2=$one_file width=80 height=80}</a></li>
    {/foreach}
    </ul>
  {/if}

{if $subaction != 'gallery'}
</div>
{/if}