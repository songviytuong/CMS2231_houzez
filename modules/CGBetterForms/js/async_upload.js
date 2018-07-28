if( window.jQuery ) {
    // this tag must be INSIDE the form HTML.
    // this code should be
    var thisScript = document.currentScript;
    $(function(){
        var form = $(thisScript).closest('form');
	form.CGBFUploadHandler();
	/*
        if( !document.cgbf.uploadScript ) {
	    var cgbf_uploadHandler = '{$mod->GetModuleURLPath().'/js/jquery.CGBFUploadHandler.js'}';
	    if( !document.cgbf ) document.cgbf = {};
    	    var script_el = document.createElement('script');
	    $(body).append(script_el);
	    script.onload = function() {
	       document.cgbf.uploadScript = 1;
	       form.CGBFUploadHandler();
	    }
	    script.src = cgbf_uploadHandler;
        }
	else {
	    form.CGBFUploadHandler();
	}
	*/
    });
}
