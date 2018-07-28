<script type="text/javascript">{literal}
//<![CDATA[
var upload_url = '{/literal}{module_action_link module=CompanyDirectory action=ajax_upload compid=$compid fdid=$album_field_exists urlonly=1 jsfriendly=1}{literal}';
var gallery_url = '{/literal}{module_action_link module=CompanyDirectory action=ajax_gallery compid=$compid fdid=$album_field_exists urlonly=1 jsfriendly=1}{literal}';
var delete_url = '{/literal}{module_action_link module=CompanyDirectory action=ajax_delete compid=$compid fdid=$album_field_exists urlonly=1 jsfriendly=1}{literal}';
var sort_url = '{/literal}{module_action_link module=CompanyDirectory action=ajax_sort compid=$compid fdid=$album_field_exists urlonly=1 jsfriendly=1}{literal}';

function _refresh_gallery() {
  $('#editcompany_gallery').load(gallery_url+'&showtemplate=false',function(){
    if( jQuery().fancybox ) {
      $('a.fancybox').fancybox();
    }

    // the sortable stuff
    //$('#file_list tbody').sortable().disableSelection();
    $('#file_list tbody').sortable({
      cursor: 'crosshair',
      update: function() {
        var order = [];
        $('#file_list tbody').children('tr').each(function(idx,elm){
          order.push(elm.id.split('_',2)[1]);
        });
        $.ajax({
          url: sort_url+'&showtemplate=false',
          type: 'POST',
          data: {m1_order: order},
          success: function(data,textStatus,jqXHR) {
           _refresh_gallery();
          }
        });
      }
    });
  });
}

$(document).ready(function(){
 if( 1 ) {
   $(document).bind('drop dragover', function(e) {
     e.preventDefault();
   });

   // drag drop upload stuffo
   $('#image_upload').fileupload({
     dataType: 'json',
     dropzone: $('#cd_album_dropzone'),
     url: upload_url.replace(/amp;/g,'')+'&showtemplate=false',
     form: null,
     formData: {m1_foo:'bar'},
     maxChunkSize: {/literal}{$max_chunksize}{literal},

     progressall: function(e,data) {
       var total = (data.loaded / data.total * 100).toFixed(0);
       $('#cd_album_dropzone').progressbar({ value: parseInt(total) });
       $('.ui-progressbar-value').html(total+'%');
     },

     stop: function(e,data) {
       $('#cd_album_dropzone').progressbar('destroy');
     },

     done: function(e,data) {
       _refresh_gallery();
     }
   });
 }

 // the delete ajax stuff
 $('#editcompany_gallery .delete').live('click',function(e){
   e.preventDefault();
   var filename = $(this).attr('href');
   $.ajax({
     url: delete_url+'&showtemplate=false',
     type: 'POST',
     data: {m1_filename: filename},
     success: function(data,textStatus,jqXHR) {
       _refresh_gallery();
     }
   });
 });

 // and load the gallery.
 _refresh_gallery();
});
{/literal}</script>

<legend>{$mod->Lang('drag_drop_upload')}</legend>
<table width="100%">
  <tr><td>{$mod->Lang('info_drag_drop')}</td>
  <td valign="top">
    <input type="file" name="image_upload" multiple="multiple" id="image_upload" style="width: 24em;"/>
    {cge_isie assign='ie'}{if !$ie}
    <br/><br/>
    <div align="center" id="cd_album_dropzone" style="background-color: lightblue; border: 1px dashed brown; text-align: center; padding: 0.5em; width: 28em;">
    {$mod->Lang('drop_here')}
    </div>
    {/if}
  </td>
</table>
</fieldset>

<div id='editcompany_gallery'>
</div>
