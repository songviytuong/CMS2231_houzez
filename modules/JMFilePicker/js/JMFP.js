//------------------------------------------------------------------------------
//
// Module : JMFilePicker (c) 2010-2012 by Georg Busch (georg.busch@gmx.net)
//          a filepicker tool for CMS Made Simple
//          The projects homepage is dev.cmsmadesimple.org/projects/gbfilepicker
//          CMS Made Simple is (c) 2004-2012 by Ted Kulp
//          The projects homepage is: cmsmadesimple.org
// Version: 1.3.3
// File   : JMFP.js
// License: GPL
//
//------------------------------------------------------------------------------

JMFP = {
	options: {
		title:'FilePicker',
		moduleId:'',
		draggable:true,
		dragAxis:'x',
		resizable:true,
		resizableHandles:'e,w',
		closeText:'Close',
		reloadText:'Reload',
		thumbnailWidth:96,
		thumbnailHeight:96,
		rootUrl:'..',
		fadeSpeed:300,
		animateSpeed:300,
		debug:false
	},
	fileBrowser: function(){
		return (document.getElementById('JMFP_header') != null);
	},
	getCurrentPickerId:function(){
		return JMFP.tmp.currentPickerId;
	},
	getCurrentDir:function(){
		return JMFP.tmp.currentDir;
	},
	getCurrentUrl:function(){
		return JMFP.tmp.currentUrl;
	},
	tmp: {
		currentPickerId:'',
		currentDir:'',
		currentUrl:'',
		height:0,
		fileListHeight:0,
		inputs:{},
		template:{}
	},
	inputs: {},
	init: function() {
		if(arguments[0] && JMFP.typeOf(arguments[0]) == 'object') {
			for (var i in arguments[0]) {
				if(typeof JMFP.options[i] != 'undefined') {
					JMFP.options[i] = arguments[0][i];
				}
				else if (i == 'inputs' && typeof arguments[0][i] == 'object') {
					for(var j in arguments[0][i]) {
						JMFP.registerInput(arguments[0][i][j]);
					}
				}
			}
		}
	},
	registerInput: function(obj) {
		var input = {
			id:'',
			moduleId:JMFP.options.moduleId,
			title: JMFP.options.title,
			draggable: JMFP.options.draggable,
			dragAxis: JMFP.options.dragAxis,
			resizable: JMFP.options.resizable,
			resizableHandles: JMFP.options.resizableHandles,
			closeText: JMFP.options.closeText,
			reloadText: JMFP.options.reloadText,
			thumbnailWidth: JMFP.options.thumbnailWidth,
			thumbnailHeight: JMFP.options.thumbnailHeight,
			animateSpeed:JMFP.options.animateSpeed,
			fadeSpeed:JMFP.options.fadeSpeed,
			debug:JMFP.options.debug,
			dir:null,
			mode:null,
			browseUrl:'',
			uploadUrl:''
		};
		if(typeof obj.id != 'undefined' && obj.id != '') {
			for (var i in obj) {
				if(typeof input[i] != 'undefined') {
					input[i] = obj[i];
				}
			}
			JMFP.inputs[input.id] = input;
			JMFP.inputs[input.id].titlebar = function() {
				return '<span id="JMFP_loading_img_wrapper"><img id="JMFP_loading_img" alt="" src="'+ JMFP.options.rootUrl +'/modules/JMFilePicker/templates/themes/Default-AJAX/img/loading.gif" /></span><h3 id="JMFP_title">' + this.title + '</h3><div id="JMFP_menu"><a id="JMFP_reload_dir" title="' + this.reloadText + '" href="#" onclick="JMFP.reloadDir();return false;">'+ this.reloadText +'</a><a id="JMFP_close" title="' + this.closeText + '" href="#" onclick="JMFP.close(JMFP.getCurrentPickerId());return false;">[X]</a><div class="clearb"></div></div><div class="clearb"></div>';
			};
		}
	},
	getTemplate: function(pickerId) {
		
		if(JMFP.inputs[pickerId].debug) {
			alert('creating template ... ');
		}
		
		if(document.getElementById('JMFP_content') != null) {
			JMFP.tmp.template['#JMFP_titlebar'].html(JMFP.inputs[pickerId].titlebar());
			
			if(JMFP.inputs[pickerId].debug) {
				alert('created titlebar');
			}
			
		}
		else {
			jQuery('body').append('<div id="JMFP_wrapper" class="pagecontainer"><div id="JMFP_background" onclick="JMFP.close(JMFP.getCurrentPickerId())"></div><div id="JMFP"><div id="JMFP_titlebar">' + JMFP.inputs[pickerId].titlebar() + '</div><div id="JMFP_content"></div></div></div>');
			
			if(JMFP.inputs[pickerId].debug) {
				alert('appended wrapper to body');
			}
			
			JMFP.tmp.template['#JMFP_wrapper']     = jQuery('#JMFP_wrapper');
			JMFP.tmp.template['#JMFP']             = jQuery("#JMFP");
			JMFP.tmp.template['#JMFP_content']     = jQuery("#JMFP_content");
			JMFP.tmp.template['#JMFP_titlebar']    = jQuery("#JMFP_titlebar");
			JMFP.tmp.template['#JMFP_background']  = jQuery('#JMFP_background');
		}
		
		JMFP.tmp.template['#JMFP_loading_img'] = jQuery("#JMFP_loading_img");
		
		jQuery(window).resize(function() {
			JMFP.resize();
		});
		JMFP.tmp.template['#JMFP_wrapper'].css('display','block').css('z-index',9999).css('opacity',1);
		if(JMFP.inputs[pickerId].draggable) {
			JMFP.tmp.template['#JMFP'].draggable({handle: '#JMFP_titlebar', containment: "parent", cursor: "move", axis:JMFP.inputs[pickerId].dragAxis});
		}
		if(JMFP.inputs[pickerId].resizable) {
			JMFP.tmp.template['#JMFP'].resizable({handles: JMFP.inputs[pickerId].resizableHandles});
		}
		return;
	},
	reloadDir: function() {
		JMFP.loadDir(JMFP.tmp.currentUrl,JMFP.tmp.currentPickerId,JMFP.tmp.currentDir);
	},
	toggleThumbnail: function (pickerId, url, title, alt) {
		if(typeof JMFP.inputs[pickerId] == 'undefined') {
			JMFP.registerInput({id:pickerId});
		}
		var thumbnailWrapper = jQuery('#' + pickerId + '_JMFP_thumbnail_wrapper');
		if(typeof thumbnailWrapper.attr('id') == 'undefined') {
			return;
		}
		thumbnailWrapper.fadeTo(JMFP.inputs[pickerId].fadeSpeed, 0, function () {
			thumbnailWrapper.html('');
			if(url != '') {
				var altTxt    = '',
					titleTxt  = '',
					altAttr   = '',
					titleAttr = '';
				if(typeof(title) != 'undefined') {
					titleTxt = title;
				}
				if(typeof(alt) != 'undefined') {
					altTxt = alt;
				}
				if(titleTxt != '') {
					titleAttr = ' title="' + titleTxt + '"';
				}
				if(altTxt != '') {
					altAttr = ' alt="' + altTxt + '"';
				}
				thumbnailWrapper.html('<img class="JMFP_thumbnail" id="' + pickerId + '_JMFP_thumbnail" src="' + url + '"' + titleAttr + altAttr + ' />').onImagesLoad({
					callbackIfNoImagesExist:true,
					all: function(elm) {
						var thumbnailSize = JMFP.getThumbnailSize(pickerId);
						//jQuery('#' + pickerId + '_JMFP_thumbnail').attr('width',thumbnailSize[0]).attr('height',thumbnailSize[1]);
						var img               = jQuery('#' + thumbnailWrapper.attr('id').replace('_wrapper', '')),
							//thumbHeight       = parseInt(img.height()),
							thumbHeight       = JMFP.inputs[pickerId].thumbnailHeight,
							thumbMarginTop    = parseInt(img.css('margin-top').replace(/[^\d]*/g, '')),
							thumbMarginBottom = parseInt(img.css('margin-bottom').replace(/[^\d]*/g, '')),
							thumbPaddingTop   = parseInt(img.css('padding-top').replace(/[^\d]*/g, '')),
							thumbPaddinBottom = parseInt(img.css('padding-bottom').replace(/[^\d]*/g, '')),
							thumbBorderTop    = parseInt(img.css('border-top-width').replace(/[^\d]*/g, '')),
							thumbBorderBottom = parseInt(img.css('border-bottom-width').replace(/[^\d]*/g, '')),
							newHeight         = eval((isNaN(thumbHeight) || typeof thumbHeight == 'undefined' ? 0 : thumbHeight) + (isNaN(thumbMarginTop) || typeof thumbMarginTop == 'undefined' ? 0 : thumbMarginTop) + (isNaN(thumbMarginBottom) || typeof thumbMarginBottom == 'undefined' ? 0 : thumbMarginBottom) + (isNaN(thumbPaddingTop) || typeof thumbPaddingTop == 'undefined' ? 0 : thumbPaddingTop) + (isNaN(thumbPaddinBottom) || typeof thumbPaddinBottom == 'undefined' ? 0 : thumbPaddinBottom) + (isNaN(thumbBorderTop) || typeof thumbBorderTop == 'undefined' ? 0 : thumbBorderTop) + (isNaN(thumbBorderBottom) || typeof thumbBorderBottom == 'undefined' ? 0 : thumbBorderBottom));
						thumbnailWrapper.animate({height:newHeight+'px'}, JMFP.inputs[pickerId].animateSpeed, 'swing', function() {
							thumbnailWrapper.fadeTo(JMFP.inputs[pickerId].fadeSpeed, 1);
						});
					}
				});
			}
			else {
				thumbnailWrapper.animate({height:'0px'});
			}
		});
	},
	getThumbnailSize: function(pickerId) {
		var thumbImg    = document.getElementById(pickerId + '_JMFP_thumbnail'),
			origWidth   = thumbImg.width,
			origHeight  = thumbImg.height,
			aspectratio = eval(origWidth / origHeight),
			newWidth    = Math.floor(JMFP.inputs[pickerId].thumbnailWidth),
			newHeight   = Math.floor(JMFP.inputs[pickerId].thumbnailHeight);
		
		if(newWidth <= 0) {
			newWidth = 96;
		}
		if(newHeight <= 0) {
			newHeight = 96;
		}
		if(newWidth > origWidth) {
			newWidth = origWidth;
		}
		if(newHeight > origHeight) {
			newHeight = origHeight;
		}
		
		var newAspectratio = eval(newWidth / newHeight);
		
		if(aspectratio > 1 && newAspectratio < 1) { // landscape to portrait
			var _tmp = Math.floor(eval(newWidth / aspectratio));
			if(_tmp > 0 && _tmp <= newHeight) {
				newHeight = _tmp;
			}
		}
		else if(aspectratio < 1 && newAspectratio > 1) { // portrait to landscape
			var _tmp = Math.floor(eval(newHeight * aspectratio));
			if(_tmp > 0 && _tmp <= newWidth) {
				newWidth = _tmp;
			}
		}
		else {
			if(newAspectratio < aspectratio) {
				var _tmp = Math.floor(eval(newWidth / aspectratio));
				if(_tmp > 0 && _tmp <= newHeight) {
					newHeight = _tmp;
				}
			}
			else if(newAspectratio > aspectratio) {
				var _tmp = Math.floor(eval(newHeight * aspectratio));
				if(_tmp > 0 && _tmp <= newWidth) {
					newWidth = _tmp;
				}
			}
		}
		if(newWidth < 1) {
			newWidth = 1;
		}
		if(newHeight < 1) {
			newHeight = 1;
		}
		return new Array(newWidth, newHeight);
	},
	close: function (pickerId) {
		jQuery(window).unbind('resize');
		JMFP.tmp.template['#JMFP_loading_img'].css('display','none');
		JMFP.tmp.template['#JMFP_wrapper'].fadeTo(JMFP.inputs[pickerId].fadeSpeed,0,function(){
			JMFP.tmp.template['#JMFP_wrapper'].css('display','none').css('z-index',-9999);
			if(JMFP.ieVersion() < 8) {
				JMFP.tmp.template['#JMFP_wrapper'].remove();
			}
			else {
				JMFP.tmp.template['#JMFP_background'].css('display','none').css('opacity',0);
				JMFP.tmp.template['#JMFP_content'].html('').css('opacity',0);
				var attribs = {
					titleBarHeight:        JMFP.tmp.template['#JMFP_titlebar'].height(),
					titleBarPaddingTop:    JMFP.tmp.template['#JMFP_titlebar'].css('padding-top').replace(/[^\d]*/g, ''),
					titleBarPaddingBottom: JMFP.tmp.template['#JMFP_titlebar'].css('padding-bottom').replace(/[^\d]*/g, ''),
					titleBarMarginTop:     JMFP.tmp.template['#JMFP_titlebar'].css('margin-top').replace(/[^\d]*/g, ''),
					titleBarMarginBottom:  JMFP.tmp.template['#JMFP_titlebar'].css('margin-bottom').replace(/[^\d]*/g, ''),
					titleBarBorderTop:     JMFP.tmp.template['#JMFP_titlebar'].css('border-top-width').replace(/[^\d]*/g, ''),
					titleBarBorderBottom:  JMFP.tmp.template['#JMFP_titlebar'].css('border-bottom-width').replace(/[^\d]*/g, ''),
					jmfpPaddingTop:    JMFP.tmp.template['#JMFP'].css('padding-top').replace(/[^\d]*/g, ''),
					jmfpPaddingBottom: JMFP.tmp.template['#JMFP'].css('padding-bottom').replace(/[^\d]*/g, ''),
					jmfpMarginTop:     JMFP.tmp.template['#JMFP'].css('margin-top').replace(/[^\d]*/g, ''),
					jmfpMarginBottom:  JMFP.tmp.template['#JMFP'].css('margin-bottom').replace(/[^\d]*/g, ''),
					jmfpBorderTop:     JMFP.tmp.template['#JMFP'].css('border-top-width').replace(/[^\d]*/g, ''),
					jmfpBorderBottom:  JMFP.tmp.template['#JMFP'].css('border-bottom-width').replace(/[^\d]*/g, '')
				}
				
				var jmfpHeight = 0;
				for(var i in attribs) {
					attribs[i] = parseInt(attribs[i]);
					if(typeof attribs[i] == 'undefined' || attribs[i] == 'undefined' || isNaN(attribs[i])) {
						attribs[i] = 0;
					}
					
					jmfpHeight = eval(jmfpHeight + attribs[i]);
				}
				
				JMFP.tmp.template['#JMFP'].css('height', jmfpHeight + 'px').css('display','none').css('opacity',0);
				
			}
			JMFP.tmp.currentUrl      = '';
			JMFP.tmp.currentDir      = '';
			JMFP.tmp.currentPickerId = '';
			JMFP.tmp.height          = 0;
			JMFP.tmp.fileListHeight  = 0;
		});
		return false;
	},
	loadDir: function (url, pickerId) {
		if(typeof JMFP.inputs[pickerId] == 'undefined') {
			JMFP.registerInput({id:pickerId});
		}
		var dir;
		if(typeof arguments[2] != 'undefined') {
			dir = arguments[2];
		}
		if(JMFP.fileBrowser() == false) {
			
			/**
			 * open filepicker
			 */
			
			JMFP.getTemplate(pickerId);
			
			JMFP.tmp.template['#JMFP_background'].css('display','block').fadeTo(JMFP.inputs[pickerId].fadeSpeed, 0.65, function () {
				
				if(JMFP.inputs[pickerId].debug) {
					alert('faded in background');
				}
				
				JMFP.tmp.template['#JMFP'].css('display','block').fadeTo(JMFP.inputs[pickerId].fadeSpeed, 1, function() {
					JMFP.tmp.template['#JMFP_loading_img'].css('display','block');
						
					if(JMFP.inputs[pickerId].debug) {
						alert('loading from server');
					}
					
					jQuery.get(url + '&' + JMFP.inputs[pickerId].moduleId + 'showtemplate=false&'  + JMFP.inputs[pickerId].moduleId + 'disable_theme=1&' + JMFP.inputs[pickerId].moduleId + 'ajax=1', function(data) {
						
						if(JMFP.inputs[pickerId].debug) {
							alert('content loaded');
						}
						
						JMFP.tmp.template['#JMFP'].css('height',JMFP.tmp.template['#JMFP'].height() + 'px');
						JMFP.tmp.template['#JMFP_content'].html(data);
						
						if(JMFP.inputs[pickerId].debug) {
							alert('replaced content with loaded data');
						}
						
						JMFP.tmp.template['#JMFP_header']   = jQuery("#JMFP_header");
						JMFP.ajaxForm();
						JMFP.tmp.template['#JMFP_filelist'] = jQuery("#JMFP_filelist");
						if(typeof JMFP.tmp.template['#JMFP_filelist'].attr('id') != 'undefined') {
							JMFP.tmp.template['#JMFP_fileoperations']        = jQuery('#JMFP_fileoperations');
							JMFP.tmp.template['#JMFP_toggle_fileoperations'] = jQuery('#JMFP_toggle_fileoperations');
							JMFP.tmp.template['#JMFP_filelist'].css('max-height','').css('opacity',1);;
							
							if(JMFP.inputs[pickerId].debug) {
								alert('set max-height to "" + faded in filelist');
							}
						}
						
						if(jQuery('#JMFP_content img').length) {
							JMFP.tmp.template['#JMFP_content'].onImagesLoad({
								callbackIfNoImagesExist:true,
								all: function (elm) {
									
									if(JMFP.inputs[pickerId].debug) {
										alert('images loaded; JMFP.tmp.height:' + JMFP.tmp.height);
									}
									
									JMFP.getHeight();
									if(typeof JMFP.tmp.template['#JMFP_filelist'].attr('id') != 'undefined') {
										JMFP.tmp.template['#JMFP_filelist'].css('max-height', JMFP.tmp.fileListHeight + 'px');
										if(JMFP.inputs[pickerId].debug) {
											alert('set max-height to ' + JMFP.tmp.fileListHeight + '; JMFP.tmp.height:' + JMFP.tmp.height);
										}
									}
									if(JMFP.ieVersion() < 8) {
										JMFP.tmp.template['#JMFP'].css('height','auto');
									}
									JMFP.tmp.template['#JMFP'].animate({height: JMFP.tmp.height + (JMFP.tmp.height != 'auto' ? 'px' : '')}, JMFP.inputs[pickerId].animateSpeed , 'swing', function() {
										
										if(JMFP.inputs[pickerId].debug) {
											alert('animated height; JMFP.tmp.height:' + JMFP.tmp.height);
										}
										
										JMFP.tmp.template['#JMFP_content'].fadeTo(JMFP.inputs[pickerId].fadeSpeed, 1, function() {
											JMFP.tmp.template['#JMFP_loading_img'].css('display','none');
											
											if(JMFP.inputs[pickerId].debug) {
												alert('faded in content');
											}
											
										});
									});
								}
							});
						}
						else {
							JMFP.getHeight();
							if(typeof JMFP.tmp.template['#JMFP_filelist'].attr('id') != 'undefined') {
								JMFP.tmp.template['#JMFP_filelist'].css('max-height', JMFP.tmp.fileListHeight + 'px');
								if(JMFP.inputs[pickerId].debug) {
									alert('set max-height to ' + JMFP.tmp.fileListHeight);
								}
							}
							if(JMFP.ieVersion() < 8) {
								JMFP.tmp.template['#JMFP'].css('height','auto');
							}
							JMFP.tmp.template['#JMFP'].animate({height: JMFP.tmp.height + (JMFP.tmp.height != 'auto' ? 'px' : '')}, JMFP.inputs[pickerId].animateSpeed , 'swing', function() {
								
								if(JMFP.inputs[pickerId].debug) {
									alert('animated height');
								}
								
								JMFP.tmp.template['#JMFP_content'].fadeTo(JMFP.inputs[pickerId].fadeSpeed, 1, function() {
									JMFP.tmp.template['#JMFP_loading_img'].css('display','none');
									
									if(JMFP.inputs[pickerId].debug) {
										alert('faded in content');
									}
									
								});
							});
						}
					});
				});
			});
		}
		else {
			
			/**
			 * loading selected dir
			 */
			
			JMFP.tmp.template['#JMFP_loading_img'].css('display','block');
			if(JMFP.inputs[pickerId].debug) {
				alert('loading from server');
			}
			
			jQuery.get(url + '&' + JMFP.inputs[pickerId].moduleId + 'showtemplate=false&'  + JMFP.inputs[pickerId].moduleId + 'disable_theme=1&' + JMFP.inputs[pickerId].moduleId + 'ajax=1', function(data) {
					
				if(JMFP.inputs[pickerId].debug) {
					alert('content loaded');
				}
				
				if(typeof JMFP.tmp.template['#JMFP_filelist'].attr('id') != 'undefined') {
					var fadeId = '#JMFP_filelist';
				}
				else {
					var fadeId = '#JMFP_content';
				}
				JMFP.tmp.template[fadeId].fadeTo(JMFP.inputs[pickerId].fadeSpeed, 0, function() {
					
					if(JMFP.inputs[pickerId].debug) {
						alert('faded out filelist');
					}
					
					JMFP.tmp.template['#JMFP'].css('height',JMFP.tmp.template['#JMFP'].height() + 'px');
					JMFP.tmp.template['#JMFP_content'].html(data);
					
					if(JMFP.inputs[pickerId].debug) {
						alert('replaced content with loaded data');
					}
					JMFP.tmp.template['#JMFP_header']   = jQuery("#JMFP_header");
					JMFP.ajaxForm();
					JMFP.tmp.template['#JMFP_filelist'] = jQuery("#JMFP_filelist");
					if(typeof JMFP.tmp.template['#JMFP_filelist'].attr('id') != 'undefined') {
						JMFP.tmp.template['#JMFP_fileoperations']        = jQuery('#JMFP_fileoperations');
						JMFP.tmp.template['#JMFP_toggle_fileoperations'] = jQuery('#JMFP_toggle_fileoperations');
						JMFP.tmp.template['#JMFP_filelist'].css('max-height','');
						if(JMFP.inputs[pickerId].debug) {
							alert('set max-height to ""');
						}
					}
					if(jQuery('#JMFP_content img').length) {
						JMFP.tmp.template['#JMFP_content'].onImagesLoad({
							callbackIfNoImagesExist:true,
							all: function (elm) {
								
								if(JMFP.inputs[pickerId].debug) {
									alert('images loaded');
								}
								
								JMFP.getHeight();
								if(typeof JMFP.tmp.template['#JMFP_filelist'].attr('id') != 'undefined') {
									JMFP.tmp.template['#JMFP_filelist'].css('max-height', JMFP.tmp.fileListHeight + 'px');
									
									if(JMFP.inputs[pickerId].debug) {
										alert('set max-height to ' + JMFP.tmp.fileListHeight);
									}
								}
								if(JMFP.ieVersion() < 8) {
									JMFP.tmp.template['#JMFP'].css('height','auto');
								}
								JMFP.tmp.template['#JMFP'].animate({height: JMFP.tmp.height + (JMFP.tmp.height != 'auto' ? 'px' : '')}, JMFP.inputs[pickerId].animateSpeed , 'swing', function() {
										
									if(JMFP.inputs[pickerId].debug) {
										alert('animated height');
									}
									
									if(typeof JMFP.tmp.template['#JMFP_filelist'].attr('id') != 'undefined') {
										var fadeId = '#JMFP_filelist';
									}
									else {
										var fadeId = '#JMFP_content';
									}
									JMFP.tmp.template[fadeId].fadeTo(JMFP.inputs[pickerId].fadeSpeed, 1, function() {
										JMFP.tmp.template['#JMFP_loading_img'].css('display','none');
										
										if(JMFP.inputs[pickerId].debug) {
											alert('faded in filelist');
										}
										
									});
								});
							}
						});
					}
					else {
						JMFP.getHeight();
						if(typeof JMFP.tmp.template['#JMFP_filelist'].attr('id') != 'undefined') {
							JMFP.tmp.template['#JMFP_filelist'].css('max-height', JMFP.tmp.fileListHeight + 'px');
							if(JMFP.inputs[pickerId].debug) {
								alert('set max-height to ' + JMFP.tmp.fileListHeight);
							}
						}
						if(JMFP.ieVersion() < 8) {
							JMFP.tmp.template['#JMFP'].css('height','auto');
						}
						JMFP.tmp.template['#JMFP'].animate({height: JMFP.tmp.height + (JMFP.tmp.height != 'auto' ? 'px' : '')}, JMFP.inputs[pickerId].animateSpeed , 'swing', function() {
								
							if(JMFP.inputs[pickerId].debug) {
								alert('animated height');
							}
							
							if(typeof JMFP.tmp.template['#JMFP_filelist'].attr('id') != 'undefined') {
								var fadeId = '#JMFP_filelist';
							}
							else {
								var fadeId = '#JMFP_content';
							}
							JMFP.tmp.template[fadeId].fadeTo(JMFP.inputs[pickerId].fadeSpeed, 1, function() {
								JMFP.tmp.template['#JMFP_loading_img'].css('display','none');
								
								if(JMFP.inputs[pickerId].debug) {
									alert('faded in filelist');
								}
								
							});
						});
					}
				});
			});
		}
		JMFP.tmp.currentPickerId = pickerId;
		JMFP.tmp.currentDir      = dir;
		JMFP.tmp.currentUrl      = url;
		return false;
	},
	getHeight: function () {
		
		var e = 'all';
		if(arguments[0]) {
			e = arguments[0];
		}
		
		if(e == 'fileoperations' && typeof JMFP.tmp.template['#JMFP_fileoperations'].attr('id') != 'undefined') {
			var headerHeight = JMFP.tmp.template['#JMFP_header'].height();
				attribs = {
					fileOperationsHeight:        JMFP.tmp.template['#JMFP_fileoperations'].height(),
					fileOperationsPaddingTop:    JMFP.tmp.template['#JMFP_fileoperations'].css('padding-top').replace(/[^\d]*/g, ''),
					fileOperationsPaddingBottom: JMFP.tmp.template['#JMFP_fileoperations'].css('padding-bottom').replace(/[^\d]*/g, ''),
					fileOperationsMarginTop:     JMFP.tmp.template['#JMFP_fileoperations'].css('margin-top').replace(/[^\d]*/g, ''),
					fileOperationsMarginBottom:  JMFP.tmp.template['#JMFP_fileoperations'].css('margin-bottom').replace(/[^\d]*/g, ''),
					fileOperationsBorderTop:     JMFP.tmp.template['#JMFP_fileoperations'].css('border-top-width').replace(/[^\d]*/g, ''),
					fileOperationsBorderBottom:  JMFP.tmp.template['#JMFP_fileoperations'].css('border-bottom-width').replace(/[^\d]*/g, '')
				};
			if(JMFP.tmp.template['#JMFP_toggle_fileoperations'].attr('class') == 'notifications-show') {
				for(var i in attribs) {
					attribs[i] = parseInt(attribs[i]);
					if(typeof attribs[i] == 'undefined' || attribs[i] == 'undefined' || isNaN(attribs[i])) {
						attribs[i] = 0;
					}
					headerHeight = eval(headerHeight - attribs[i]);
				}
			}
			else if(JMFP.tmp.template['#JMFP_toggle_fileoperations'].attr('class') == 'notifications-hide') {
				attribs.foo = 0; // dunno why i need to do this
				for(var i in attribs) {
					attribs[i] = parseInt(attribs[i]);
					if(typeof attribs[i] == 'undefined' || attribs[i] == 'undefined' || isNaN(attribs[i])) {
						attribs[i] = 0;
					}
					headerHeight = eval(headerHeight + attribs[i]);
				}
			}
		}
		
		if ((e == 'filelist' || e == 'all' || e == 'fileoperations') && typeof JMFP.tmp.template['#JMFP_filelist'] != 'undefined' && typeof JMFP.tmp.template['#JMFP_filelist'].attr('id') != 'undefined') {
		
			if(typeof headerHeight == 'undefined') {
				var headerHeight = JMFP.tmp.template['#JMFP_header'].height();
			}
			var attribs = {
					headerHeight:        headerHeight,
					headerPaddingTop:    JMFP.tmp.template['#JMFP_header'].css('padding-top').replace(/[^\d]*/g, ''),
					headerPaddingBottom: JMFP.tmp.template['#JMFP_header'].css('padding-bottom').replace(/[^\d]*/g, ''),
					headerMarginTop:     JMFP.tmp.template['#JMFP_header'].css('margin-top').replace(/[^\d]*/g, ''),
					headerMarginBottom:  JMFP.tmp.template['#JMFP_header'].css('margin-bottom').replace(/[^\d]*/g, ''),
					headerBorderTop:     JMFP.tmp.template['#JMFP_header'].css('border-top-width').replace(/[^\d]*/g, ''),
					headerBorderBottom:  JMFP.tmp.template['#JMFP_header'].css('border-bottom-width').replace(/[^\d]*/g, ''),
					filelistPaddingTop:    JMFP.tmp.template['#JMFP_filelist'].css('padding-top').replace(/[^\d]*/g, ''),
					filelistPaddingBottom: JMFP.tmp.template['#JMFP_filelist'].css('padding-bottom').replace(/[^\d]*/g, ''),
					filelistMarginTop:     JMFP.tmp.template['#JMFP_filelist'].css('margin-top').replace(/[^\d]*/g, ''),
					filelistMarginBottom:  JMFP.tmp.template['#JMFP_filelist'].css('margin-bottom').replace(/[^\d]*/g, ''),
					filelistBorderTop:     JMFP.tmp.template['#JMFP_filelist'].css('border-top-width').replace(/[^\d]*/g, ''),
					filelistBorderBottom:  JMFP.tmp.template['#JMFP_filelist'].css('border-bottom-width').replace(/[^\d]*/g, ''),
					contentPaddingTop:    JMFP.tmp.template['#JMFP_content'].css('padding-top').replace(/[^\d]*/g, ''),
					contentPaddingBottom: JMFP.tmp.template['#JMFP_content'].css('padding-bottom').replace(/[^\d]*/g, ''),
					contentMarginTop:     JMFP.tmp.template['#JMFP_content'].css('margin-top').replace(/[^\d]*/g, ''),
					contentMarginBottom:  JMFP.tmp.template['#JMFP_content'].css('margin-bottom').replace(/[^\d]*/g, ''),
					contentBorderTop:     JMFP.tmp.template['#JMFP_content'].css('border-top-width').replace(/[^\d]*/g, ''),
					contentBorderBottom:  JMFP.tmp.template['#JMFP_content'].css('border-bottom-width').replace(/[^\d]*/g, ''),
					titlebarHeight:        JMFP.tmp.template['#JMFP_titlebar'].height(),
					titlebarPaddingTop:    JMFP.tmp.template['#JMFP_titlebar'].css('padding-top').replace(/[^\d]*/g, ''),
					titlebarPaddingBottom: JMFP.tmp.template['#JMFP_titlebar'].css('padding-bottom').replace(/[^\d]*/g, ''),
					titlebarMarginTop:     JMFP.tmp.template['#JMFP_titlebar'].css('margin-top').replace(/[^\d]*/g, ''),
					titlebarMarginBottom:  JMFP.tmp.template['#JMFP_titlebar'].css('margin-bottom').replace(/[^\d]*/g, ''),
					titlebarBorderTop:     JMFP.tmp.template['#JMFP_titlebar'].css('border-top-width').replace(/[^\d]*/g, ''),
					titlebarBorderBottom:  JMFP.tmp.template['#JMFP_titlebar'].css('border-bottom-width').replace(/[^\d]*/g, ''),
					jmfpPaddingTop:    JMFP.tmp.template['#JMFP'].css('padding-top').replace(/[^\d]*/g, ''),
					jmfpPaddingBottom: JMFP.tmp.template['#JMFP'].css('padding-bottom').replace(/[^\d]*/g, ''),
					jmfpMarginTop:     JMFP.tmp.template['#JMFP'].css('margin-top').replace(/[^\d]*/g, ''),
					jmfpMarginBottom:  JMFP.tmp.template['#JMFP'].css('margin-bottom').replace(/[^\d]*/g, ''),
					jmfpBorderTop:     JMFP.tmp.template['#JMFP'].css('border-top-width').replace(/[^\d]*/g, ''),
					jmfpBorderBottom:  JMFP.tmp.template['#JMFP'].css('border-bottom-width').replace(/[^\d]*/g, '')
				},
				minHeight = parseInt(JMFP.tmp.template['#JMFP_filelist'].css('min-height').replace(/[^\d]*/g,''));
			
			minHeight = typeof minHeight == 'undefined' || isNaN(minHeight) ? 0 : minHeight;
			
			JMFP.tmp.fileListHeight = parseInt(jQuery(window).height());
			JMFP.tmp.fileListHeight = typeof JMFP.tmp.fileListHeight == 'undefined' || isNaN(JMFP.tmp.fileListHeight) ? 0 : JMFP.tmp.fileListHeight;
			
			for(var i in attribs) {
				attribs[i] = parseInt(attribs[i]);
				if(typeof attribs[i] == 'undefined' || attribs[i] == 'undefined' || isNaN(attribs[i])) {
					attribs[i] = 0;
				}
				JMFP.tmp.fileListHeight = eval(JMFP.tmp.fileListHeight - attribs[i]);
			}
			
			if(JMFP.tmp.fileListHeight <= minHeight) {
				JMFP.tmp.fileListHeight = minHeight;
			}
		}
		if(e == 'jmfp' || e == 'all' || e == 'fileoperations') {
			if(JMFP.ieVersion() < 8) {
				JMFP.tmp.height = 'auto';
				return;
			}
			var contentHeight  = JMFP.tmp.template['#JMFP_content'].height(),
				fileListHeight = JMFP.tmp.template['#JMFP_filelist'].height();
			
			contentHeight  = typeof contentHeight == 'undefined' || isNaN(contentHeight) ? 0 : contentHeight;
			fileListHeight = typeof fileListHeight == 'undefined' || isNaN(fileListHeight) ? 0 : fileListHeight;
			
			if(fileListHeight > JMFP.tmp.fileListHeight) {
				JMFP.tmp.height = eval(contentHeight - fileListHeight + JMFP.tmp.fileListHeight);
			}
			else {
				JMFP.tmp.height = contentHeight;
			}
			// dunno why i need to do this
			if(!fileListHeight && !JMFP.tmp.fileListHeight) {
				JMFP.tmp.height = eval(JMFP.tmp.height + 5);
			}
			//---
			var attribs = {
				titlebarHeight:        JMFP.tmp.template['#JMFP_titlebar'].height(),
				titlebarPaddingTop:    JMFP.tmp.template['#JMFP_titlebar'].css('padding-top').replace(/[^\d]*/g, ''),
				titlebarPaddingBottom: JMFP.tmp.template['#JMFP_titlebar'].css('padding-bottom').replace(/[^\d]*/g, ''),
				titlebarMarginTop:     JMFP.tmp.template['#JMFP_titlebar'].css('margin-top').replace(/[^\d]*/g, ''),
				titlebarMarginBottom:  JMFP.tmp.template['#JMFP_titlebar'].css('margin-bottom').replace(/[^\d]*/g, ''),
				titlebarBorderTop:     JMFP.tmp.template['#JMFP_titlebar'].css('border-top-width').replace(/[^\d]*/g, ''),
				titlebarBorderBottom:  JMFP.tmp.template['#JMFP_titlebar'].css('border-bottom-width').replace(/[^\d]*/g, ''),
				jmfpContentPaddingTop:    JMFP.tmp.template['#JMFP_content'].css('padding-top').replace(/[^\d]*/g, ''),
				jmfpContentPaddingBottom: JMFP.tmp.template['#JMFP_content'].css('padding-bottom').replace(/[^\d]*/g, ''),
				jmfpContentMarginTop:     JMFP.tmp.template['#JMFP_content'].css('margin-top').replace(/[^\d]*/g, ''),
				jmfpContentMarginBottom:  JMFP.tmp.template['#JMFP_content'].css('margin-bottom').replace(/[^\d]*/g, ''),
				jmfpContentBorderTop:     JMFP.tmp.template['#JMFP_content'].css('border-top-width').replace(/[^\d]*/g, ''),
				jmfpContentBorderBottom:  JMFP.tmp.template['#JMFP_content'].css('border-bottom-width').replace(/[^\d]*/g, ''),
				jmfpPaddingTop:    JMFP.tmp.template['#JMFP'].css('padding-top').replace(/[^\d]*/g, ''),
				jmfpPaddingBottom: JMFP.tmp.template['#JMFP'].css('padding-bottom').replace(/[^\d]*/g, ''),
				foo:10 // dunno why i need to do this
			};
			for(var i in attribs) {
				attribs[i] = parseInt(attribs[i]);
				if(typeof attribs[i] == 'undefined' || attribs[i] == 'undefined' || isNaN(attribs[i])) {
					attribs[i] = 0;
				}
				JMFP.tmp.height = eval(JMFP.tmp.height + attribs[i]);
			}
			
			attribs = {
				jmfpMarginTop:    JMFP.tmp.template['#JMFP'].css('margin-top').replace(/[^\d]*/g, ''),
				jmfpMarginBottom: JMFP.tmp.template['#JMFP'].css('margin-bottom').replace(/[^\d]*/g, ''),
				jmfpBorderTop:    JMFP.tmp.template['#JMFP'].css('border-top-width').replace(/[^\d]*/g, ''),
				jmfpBorderBottom: JMFP.tmp.template['#JMFP'].css('border-bottom-width').replace(/[^\d]*/g, '')
			};
			for(var i in attribs) {
				attribs[i] = parseInt(attribs[i]);
				if(typeof attribs[i] == 'undefined' || attribs[i] == 'undefined' || isNaN(attribs[i])) {
					attribs[i] = 0;
				}
				JMFP.tmp.height = eval(JMFP.tmp.height - attribs[i]);
			}
		}
	},
	resize: function() {
		var e = 'filelist';
		if(typeof arguments[0] != 'undefined') {
			e = arguments[0];
		}
		JMFP.getHeight(e);
		JMFP.tmp.template['#JMFP'].css('height', 'auto');
		if(typeof JMFP.tmp.template['#JMFP_filelist'] != 'undefined') {
			JMFP.tmp.template['#JMFP_filelist'].css('max-height', JMFP.tmp.fileListHeight + 'px');
		}
		return false;
	},
	pickFile: function (url, pickerId) {
		if(typeof JMFP.inputs[pickerId] == 'undefined') {
			JMFP.registerInput({id:pickerId});
		}
		jQuery('#' + pickerId).val(url);
		JMFP.close(pickerId);
		jQuery('#' + pickerId).trigger('change');
		return false;
	},
	reloadDropdown: function (url, targetId) {
		
		if(typeof JMFP.inputs[targetId] == 'undefined') {
			JMFP.registerInput({id:targetId});
		}
		
		var targetWrapper = jQuery('#' + targetId + '_JMFP_dropdown_wrapper'),
			reloadLink    = jQuery('#' + targetId + '_JMFP_reload_dropdown'),
			uploadLink    = jQuery('#' + targetId + '_JMFP_upload'),
			input         = jQuery('#' + targetId);
		
		if(typeof targetWrapper.attr('id') == 'undefined') {
			return;
		}
		var selOpt = jQuery('#' + targetId + ' option:selected:first');
		targetWrapper.closest('.JMFP_input_wrapper').children('img.JMFP_loading_img:first').removeAttr('style');
		targetWrapper.closest('.JMFP_input_wrapper').find('.JMFP_link').addClass('JMFP_disabled').unbind('click').click(function(){return false;});
		input.attr('disabled','disabled').addClass('JMFP_disabled').unbind('change');
		targetWrapper.addClass('JMFP_disabled').fadeTo(JMFP.inputs[targetId].fadeSpeed, 0, function () {
			jQuery.get(url + '&' + JMFP.inputs[targetId].moduleId + 'showtemplate=false&'  + JMFP.inputs[targetId].moduleId + 'disable_theme=1&' + JMFP.inputs[targetId].moduleId + 'ajax=1&' + JMFP.inputs[targetId].moduleId + 'value=' + selOpt.attr('value'), function(data) {
				// replace
				targetWrapper.html(data);
				// toggle thumbnail
				var selOpt = jQuery('#' + targetId + ' option:selected:first');
				JMFP.toggleThumbnail(targetId,selOpt.attr('thumbnail'),selOpt.attr('value'),selOpt.attr('value'));
				// fade in
				targetWrapper.fadeTo(JMFP.inputs[targetId].fadeSpeed, 1, function(){
					reloadLink.removeClass('JMFP_disabled').unbind('click').click(function(){
						var pickerId = this.id.substr(0,this.id.lastIndexOf('_JMFP_reload_dropdown'));
						if(JMFP.inputs[pickerId].browseUrl != '')
							JMFP.reloadDropdown(JMFP.inputs[pickerId].browseUrl, pickerId);
						return false;
					});
					uploadLink.removeClass('JMFP_disabled').unbind('click').click(function(){
						var pickerId = this.id.substr(0,this.id.lastIndexOf('_JMFP_upload'));
						if(JMFP.inputs[pickerId].uploadUrl != '')
							JMFP.loadDir(JMFP.inputs[pickerId].uploadUrl, pickerId);
						return false;
					});
					jQuery('#' + targetId).removeAttr('disabled').removeClass('JMFP_disabled').change(function(){
						JMFP.toggleThumbnail(this.id, jQuery('#'+this.id+' option:selected:first').attr('thumbnail'),this.value,this.value);
					});
					targetWrapper.closest('.JMFP_input_wrapper').children('img.JMFP_loading_img:first').css('display','none');
				});
			});
		});
	},
	selectAll: function (obj) {
		if (obj.value == 1) {
			jQuery('input[name^="'+obj.id+'-"]').attr('checked','checked');
			obj.value = 0;
		}
		else {
			jQuery('input[name^="'+obj.id+'-"]').removeAttr('checked');
			obj.value = 1;
		}
	},
	typeOf: function (value) {
		var type = typeof value;
		if (type === 'object') {
			if (value) {
				if (value instanceof Array) {
					type = 'array';
				}
			} else {
				type = 'null';
			}
		}
		return type;
	},
	ajaxForm: function () {
		var form = jQuery('#JMFP_header form:first');
		if(form.attr('id') != 'undefined') {
			form.append('<input type="hidden" name="'+JMFP.inputs[JMFP.tmp.currentPickerId].moduleId+'disable_theme" value="1" />');
			form.append('<input type="hidden" name="'+JMFP.inputs[JMFP.tmp.currentPickerId].moduleId+'showtemplate" value="false" />');
			form.append('<input type="hidden" name="'+JMFP.inputs[JMFP.tmp.currentPickerId].moduleId+'ajax" value="1" />');
			
			var options = {
				beforeSubmit: function(formData, jqForm, options){
					JMFP.tmp.template['#JMFP_loading_img'].css('display','block');
					jqForm.find('input').addClass('JMFP_disabled');
					return true;
				},
				success: function(responseText) {
					JMFP.tmp.template['#JMFP_content'].fadeTo(JMFP.inputs[JMFP.tmp.currentPickerId].fadeSpeed, 0, function() {
						JMFP.tmp.template['#JMFP_content'].html(responseText);
						
						JMFP.tmp.template['#JMFP_header']   = jQuery("#JMFP_header");
						JMFP.tmp.template['#JMFP_filelist'] = jQuery("#JMFP_filelist");
						if(typeof JMFP.tmp.template['#JMFP_filelist'].attr('id') != 'undefined') {
							JMFP.tmp.template['#JMFP_fileoperations']        = jQuery('#JMFP_fileoperations');
							JMFP.tmp.template['#JMFP_toggle_fileoperations'] = jQuery('#JMFP_toggle_fileoperations');
							JMFP.tmp.template['#JMFP_filelist'].css('max-height', '').css('opacity','1');
						}
						JMFP.tmp.template['#JMFP_content'].onImagesLoad({
							callbackIfNoImagesExist:true,
							all: function() {
								JMFP.getHeight();
								if(typeof JMFP.tmp.template['#JMFP_filelist'].attr('id') != 'undefined') {
									JMFP.tmp.template['#JMFP_filelist'].css('max-height', JMFP.tmp.fileListHeight + 'px');
								}
								if(JMFP.ieVersion() < 8) {
									JMFP.tmp.template['#JMFP'].css('height','auto');
								}
								JMFP.tmp.template['#JMFP'].animate({height: JMFP.tmp.height + (JMFP.tmp.height != 'auto' ? 'px' : '')}, JMFP.inputs[JMFP.tmp.currentPickerId].animateSpeed , 'swing', function() {
									JMFP.tmp.template['#JMFP_content'].fadeTo(JMFP.inputs[JMFP.tmp.currentPickerId].fadeSpeed, 1, function() {
										
										for(var i in JMFP.inputs)
											JMFP.reloadDropdown(JMFP.inputs[i].browseUrl, i);
										
										JMFP.tmp.template['#JMFP_loading_img'].css('display','none');
										JMFP.ajaxForm();
									});
								});
							}
						});
					});
					return false;
				}
			};
			form.ajaxForm(options);
		}
	},
	deleteFile: function (url, confirmMsg, value) {
		var conf = confirm(confirmMsg);
		if(conf) {
			var _url = JMFP.tmp.currentUrl;
			JMFP.loadDir(url + '&' + JMFP.inputs[JMFP.tmp.currentPickerId].moduleId + 'showtemplate=false&'  + JMFP.inputs[JMFP.tmp.currentPickerId].moduleId + 'disable_theme=1&' + JMFP.inputs[JMFP.tmp.currentPickerId].moduleId + 'ajax=1',JMFP.tmp.currentPickerId,JMFP.tmp.currentDir);
			for(var i in JMFP.inputs)
				JMFP.reloadDropdown(JMFP.inputs[i].browseUrl, i);
			JMFP.tmp.currentUrl = _url;
		}
		return false;
	},
	ieVersion: function() {
		var version = 999;
		if (navigator.appVersion.indexOf("MSIE") != -1) {
			version = parseFloat(navigator.appVersion.split("MSIE")[1]);
		}
		return version;
	}
};
jmfp_onload.push(function(){
	jsLoader.load(
		{
			url: JMFP.options.rootUrl + '/modules/JMFilePicker/js/jq.min.js',
			loadType: 'defer',
			ready:function() {
				return (typeof jQuery == 'function');
			},
			callBack: function(ready) {
				if(ready) {
					jQuery(document).ready(function() {
						jQuery('.JMFP_input').attr('disabled','disabled').addClass('JMFP_disabled').click(function() {return false;});
						jQuery('.JMFP_link').click(function() {return false;}).addClass('JMFP_disabled');
					});
					jsLoader.load([{
						url: JMFP.options.rootUrl + '/modules/JMFilePicker/js/jq.ui.core.min.js',
						loadType: 'defer',
						ready: function() {
							return (typeof jQuery == 'function' && typeof jQuery.ui != 'undefined')
						},
						callBack: function (ready) {
							if(ready) {
								jsLoader.load(
									{
										url: JMFP.options.rootUrl + '/modules/JMFilePicker/js/jq.ui.widget.min.js',
										loadType: 'defer',
										ready: function() {
											return (typeof jQuery == 'function' && typeof jQuery.ui != 'undefined' && typeof jQuery.widget != 'undefined')
										},
										callBack: function(ready) {
											if(ready) {
												jsLoader.load(
													{
														url: JMFP.options.rootUrl + '/modules/JMFilePicker/js/jq.ui.mouse.min.js',
														loadType: 'defer',
														ready: function() {
															return (typeof jQuery != 'undefined' && typeof jQuery.ui != 'undefined' && typeof jQuery.ui.mouse != 'undefined' && typeof jQuery.widget != 'undefined')
														}
													},
													function (ready) {
														jsLoader.load([
															{
																url: JMFP.options.rootUrl + '/modules/JMFilePicker/js/jq.ui.draggable.min.js',
																loadType: 'defer',
																ready: function() {
																	return (typeof jQuery != 'undefined' && typeof jQuery.ui != 'undefined' && typeof jQuery().draggable != 'undefined')
																}
															},
															{
																url: JMFP.options.rootUrl + '/modules/JMFilePicker/js/jq.ui.resizable.min.js',
																loadType: 'defer',
																ready: function() {
																	return (typeof jQuery != 'undefined' && typeof jQuery.ui != 'undefined' && typeof jQuery().resizable != 'undefined' && typeof jQuery.widget != 'undefined')
																}
															}
														]);
													}
												);
											}
										}
									}
								);
							}
						}
					},
					{
						url: JMFP.options.rootUrl + '/modules/JMFilePicker/js/jq.onImgLoad.min.js',
						loadType: 'defer',
						ready: function() {
							return (typeof jQuery != 'undefined' && typeof jQuery().onImagesLoad != 'undefined')
						},
						callBack: function(ready){
							if(ready) {
								$.fn.onImagesLoad.defaults.onError = function(obj) {
									jQuery(obj).attr('src', JMFP.options.rootUrl + '/modules/JMFilePicker/images/imagecorrupt.gif');
								}
							}
						}
					},
					{
						url: JMFP.options.rootUrl + '/modules/JMFilePicker/js/jq.form.min.js',
						loadType: 'defer',
						ready: function() {
							return (typeof jQuery != 'undefined' && typeof jQuery().ajaxSubmit != 'undefined')
						}
					}
					]);
				}
			}
		},
		function (ready) {
			if(ready) {
				jQuery(document).ready(function(){
					jQuery('.jmfp_contract, .jmfp_expand').live('click', function() {
						JMFP.tmp.template['#JMFP'].css('height','auto');
						if(this.className == 'jmfp_expand')
							jQuery('#JMFP_fileoperations_wrapper').removeClass('jmfp_no-border');
						JMFP.tmp.template['#JMFP_fileoperations']
							.slideToggle(function(){
								JMFP.resize();
								if(JMFP.tmp.template['#JMFP_fileoperations'].css('display') == 'none')
									jQuery('#JMFP_fileoperations_wrapper').addClass('jmfp_no-border');
							})
						;
						
						this.className = (this.className == 'jmfp_contract' ? 'jmfp_expand' : 'jmfp_contract');
						jQuery.get(this.href + JMFP.options.moduleId + 'display=' + (this.className == 'jmfp_contract' ? 1 : 0) + '&' + JMFP.options.moduleId + 'disable_theme=1&' + JMFP.options.moduleId + 'showtemplate=false&' + JMFP.options.moduleId + 'ajax=1');
						return false;
					});
					
					jQuery('.JMFP_loading_img').css('display','none');
					jQuery('.JMFP_input').removeAttr('disabled').removeClass('JMFP_disabled').unbind('click');
					jQuery('.JMFP_link').removeClass('JMFP_disabled').unbind('click');
					jQuery('.JMFP_browse').live('click', function() {
						var pickerId = this.id.substr(0,this.id.lastIndexOf('_JMFP_browse'));
						if(JMFP.inputs[pickerId].browseUrl != '')
							JMFP.loadDir(JMFP.inputs[pickerId].browseUrl, pickerId);
						return false;
					});
					jQuery('.JMFP_upload').live('click', function() {
						var pickerId = this.id.substr(0,this.id.lastIndexOf('_JMFP_upload'));
						if(JMFP.inputs[pickerId].uploadUrl != '')
							JMFP.loadDir(JMFP.inputs[pickerId].uploadUrl, pickerId);
						return false;
					});
					jQuery('.JMFP_reload_dropdown').live('click', function(){
						var pickerId = this.id.substr(0,this.id.lastIndexOf('_JMFP_reload_dropdown'));
						if(JMFP.inputs[pickerId].browseUrl != '')
							JMFP.reloadDropdown(JMFP.inputs[pickerId].browseUrl, pickerId);
						return false;
					});
					jQuery().ajaxError(function(event, request, settings){
						alert('Error: requesting page ' + settings.url);
						return false;
					});
					jQuery('.JMFP_clear').live('click', function(){
						var id = this.id.substr(0,this.id.lastIndexOf('_JMFP_clear'));
						jQuery('#'+id).val('');
						JMFP.toggleThumbnail(id,'');
						return false;
					});
					jQuery('select.JMFP_dropdown.JMFP_image').unbind('change').live('change', function(){
						JMFP.toggleThumbnail(this.id, jQuery('#'+this.id+' option:selected:first').attr('thumbnail'),this.value,this.value);
					});
				});
			}
		},
		'','','',JMFP.options.debug
	);
});
if (document.readyState == "complete") {
	for(var i = 0; i<jmfp_onload.length; i++) {
		jmfp_onload[i]();
		jmfp_onload[i] = null;
		delete jmfp_onload[i];
	}
	jmfp_onload = null;
	delete window['jmfp_onload'];
} else {
	if (attachEvent) {
		attachEvent('onload', function(e){
			for(var i = 0; i<jmfp_onload.length; i++) {
				jmfp_onload[i]();
				jmfp_onload[i] = null;
				delete jmfp_onload[i];
			}
			jmfp_onload = null;
			delete window['jmfp_onload'];
		});
	} else if (addEventListener) {
		addEventListener('load', function(e){
			for(var i = 0; i<jmfp_onload.length; i++) {
				jmfp_onload[i]();
				jmfp_onload[i] = null;
				delete jmfp_onload[i];
			}
			jmfp_onload = null;
			delete window['jmfp_onload'];
		}, false);
	}
}