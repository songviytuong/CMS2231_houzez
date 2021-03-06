tinymce.PluginManager.add('cmsms_filepicker', function(editor) {

    tinymce.activeEditor.settings.file_picker_types = 'file image media';
    tinymce.activeEditor.settings.file_picker_callback = function(callback, value, meta) {

	if( typeof top.filepicker != 'undefined' ) alert('woot');
        var height, width, mywin;
	var self = this;

        ( function(window) {
            height = '600';
            width = '900';
            if (window.innerHeight < 650) {
                height = Math.max(window.innerHeight * 0.8, 250);
            }
            if (window.innerWidth < 950) {
                width = Math.max(window.innerWidth * 0.8, 250);
            }
        } )(window);

	// generate a uniquie id for the active editor so we can access it later.
	var inst = 'i'+(new Date().getTime()).toString(16);
	tinymce.activeEditor.dom.setAttrib(tinyMCE.activeEditor.dom.select('html'),'data-cmsfp-instance',inst);

	if( !top.document.CMSFileBrowser ) top.document.CMSFileBrowser = {};
	top.document.CMSFileBrowser.onselect = function(inst,file) {
 	    file = cms_data.uploads_url + '/' + file;
   	    function basename(str) {
                var base = new String(str).substring(str.lastIndexOf('/') + 1);
                if(base.lastIndexOf(".") != -1)
                base = base.substring(0, base.lastIndexOf("."));
                return base;
            }

	    var opts = {};
	    if( meta.filetype == 'file' ) {
		opts.text = basename(file);
	    } else if( meta.filetype == 'image' ) {
		opts.alt = basename(file);
		/*
		opts.height = 50;
		opts.width = 75;
		*/
	    }
	    callback(file, opts);
	    top.document.CMSFileBrowser.onselect = null;
	    mywin.close();
	}


	// here we open the filepicker window.
	var url = cmsms_tiny.filepicker_url + '&inst=' + inst + '&type='+meta.filetype;
        mywin = tinymce.activeEditor.windowManager.open({
            title : cmsms_tiny.filepicker_title,
            file : url,
            classes : 'filepicker',
            height : height,
            width : width,
            inline : 1,
            resizable : true,
            maximizable : true,
        }, {
	    onFileSelected: function(filename) {
		console.debug('woot got callback with '+filename);
	    }
	});


    };
    return false;
});
