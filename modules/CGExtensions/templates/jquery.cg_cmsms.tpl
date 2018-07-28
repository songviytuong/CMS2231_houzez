(function($){
    var config = {
        root_url: '{$config.root_url}',
        ssl_url:  '{$config.ssl_url}',
        admin_url: '{$config.admin_url}',
        uploads_url: '{$config.ssl_uploads_url}',
        max_upload_size: '{$config.max_upload_size}',
        url_rewriting: '{$config.url_rewriting}',
        page_extension: '{$config.page_extension}',
        query_var: '{$config.query_var}',
        thumbsize: {$mod->GetPreference('thumbnailsize',150)},
    };

    // get a config variable.
    $.fn.cmsms_config = function(key) {
        if( typeof(config[key]) != 'undefined' ) return config[key];
    };

    // display an admin error using admintheme styles
    $.fn.cmsms_admin_error = function(str) {
       var el1 = $('<div class="pageerrorcontainer"/>');
       var el2 = $('<div class="pageoverflow"/>');
       var el3 = $('<ul class="pageerror"/>');
       el3.append('<li>'+str+'</li>');
       el2.append(el3);
       el1.append(el2);
       $('body').append(el1);
       setTimeout(function(){
         el1.slideUp(400).remove();
       }, 4000);
    }

}( jQuery ));

$(document).ready(function(){
    $('input:required,select:required').addClass('required');
    $('input[readonly],select[readonly]').addClass('readonly');
    $('div.pagecontainer').tooltip();
    $('.cg_tooltip').tooltip({
      content: function() {
        var data = $(this).data('tooltip');
        if( typeof data == 'undefined' || data.length == 0 ) {
          data = $(this).next('div.cg_tooltip_data').html();
  	  if( typeof data == 'undefined' || data.length == 0 ) {
	    data = $(this).prop('title');
	  }
        }
        return data;
      }
    })
});