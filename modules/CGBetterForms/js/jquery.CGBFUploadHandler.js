(function ( $ ) {
    var thisScript = document.currentScript;
    var ajax_url = thisScript.getAttribute('data-cgbf-uploadurl');
    if( !ajax_url ) throw "CGBFUploadHandler could not determine upload URL";

    $.fn.CGBFUploadHandler = function( options ) {
	// we expect a single form
	var form = this;
	var guid = $('input[name=__guid]',form).val();
	var settings=  $.extend({
	    submit_name: 'submit',
	    upload_url: ajax_url,
	    upload_fail_msg: 'One or more uploads failed'
	});

	function uploadFile( name, is_multiple, file ) {
	    var formData = new FormData();
	    formData.append( 'file', file );
	    formData.append( 'guid', guid );
	    formData.append( 'element', name );
	    return $.ajax({
		type: 'post',
		url: settings.upload_url,
		context: form,
		contentType: false,
		processData: false,
		data: formData
	    }).done(function(data){
		var hidden_name = name;
		if( is_multiple && hidden_name.substr(-2) != '[]' ) hidden_name += '[]';
		var hidden = $('<input/>').prop('type','hidden').prop('name',hidden_name).prop('value',data.tmp_name+':|:'+data.name);
		form.append(hidden);
		// todo: call upload done callback
		console.debug('finisned upload');
	    }).fail(function(xhr,textStatus,error){
		console.debug('upload failed '+textStatus+' // '+error );
	    })
	}

	// todo: call busy callback
	form.submit(function(event){
	    event.preventDefault();
	    form.off('submit');
	    var promises = [];

	    $('input[type=file]',form).each(function(){
		if( !$(this).val() ) return;
		var is_multiple = $(this).prop('multiple');
		var el_name = $(this).prop('name');
		var hidden_name = el_name;
		if( is_multiple ) hidden_name += '[]';
		var el = $(this)[0];
		for( var idx = 0; idx < el.files.length; idx++ ) {
		    var file = el.files[idx];
		    promises.push( uploadFile( el_name, is_multiple, file ) );
		}
		// remove the element.
		$(this).remove();
	    })

            if( !promises.length ) {
                form.submit();
		return;
            }

            $.when.apply($, promises).done(function(){
                // todo: call unbusy callback
	        //var submit = $('<input/>').attr('type','hidden').prop('name',settings.submit_name).val('1');
	        //form.append(submit);
	        form.submit();
            }).fail(function(){
                alert( settings.upload_fail_msg );
            })

	})
        return this;
    };

}( jQuery ));
