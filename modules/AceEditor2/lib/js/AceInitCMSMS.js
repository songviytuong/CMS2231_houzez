// **
// *
// * Copyright:
// *
// * MajorLabel - Guido Goluke
// * Web: www.majorlabel.nl
// * Email: info@majorlabel.nl
// *
// *
// * Authors:
// *
// * Guido Goluke, <info@majorlabel.nl>
// *  
// *
// * License:
// *-------------------------------------------------------------------------
// *
// * This program is free software; you can redistribute it and/or modify
// * it under the terms of the GNU General Public License as published by
// * the Free Software Foundation; either version 2 of the License, or
// * (at your option) any later version.
// *
// * This program is distributed in the hope that it will be useful,
// * but WITHOUT ANY WARRANTY; without even the implied warranty of
// * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
// * GNU General Public License for more details.
// * You should have received a copy of the GNU General Public License
// * along with this program; if not, write to the Free Software
// * Foundation, Inc., 59 Temple Place, Suite 330, Boston, MA 02111-1307 USA
// * Or read it online: http://www.gnu.org/licenses/licenses.html#GPL
// *
// * -------------------------------------------------------------------------

function htmlEncode(value){
  //create a in-memory div, set it's inner text(which jQuery automatically encodes)
  //then grab the encoded contents back out.  The div never exists on the page.
  // Original: http://stackoverflow.com/questions/1219860/html-encoding-in-javascript-jquery
  return $('<div/>').text(value).html();
}

function initAce(editor, originalTextArea) {
	// Hides the system textarea from view
	originalTextArea.style.display = "none";
	// Insert the textarea before the Ace Editor
	editor.container.parentNode.insertBefore(originalTextArea, editor.container.parentNode.firstChild);
	// Update the hidden textarea when the content of the Ace Editor changes
	editor.on('input', function(){
		originalTextArea.innerHTML = htmlEncode(editor.getSession().getValue());
	});
}

function addToolBar(editor, moduleDir, AceModes, currentMode, cssPrefMode) {
	
	// Override 'HTML' mode with Smarty mode
	if (currentMode == 'html') {currentMode = 'smarty'};
	
	// Create the toolbar DIV
	$('<div id="AceToolbar"></div>').insertBefore($(editor.container));
	
	// Set the toolbar width to the editor width
	$('#AceToolbar').css('width', $('.ace_editor').outerWidth());
	
	// Create the bottombar DIV
	$(editor.container).parent().append('<div id="AceBottombar"></div>');
	$('#AceBottombar').css('width', $('.ace_editor').outerWidth());
	
	// Catch a window resize
	$(window).resize(function(){
		$('#AceBottombar, #AceToolbar').css('width', $('.ace_editor').outerWidth());
	});
	
	// Autoload the current mode, that is the mode from the textarea 'data-cms-lang' attribute
	// If the 'data-cms-lang' attribute is CSS, use the cssPrefMode
	if (currentMode == 'css') {
		$('head').append('<script src="'+moduleDir+'/lib/Ace/src-min/mode-'+cssPrefMode+'.js></script>');
		editor.getSession().setMode('ace/mode/'+cssPrefMode);
		var selectedMode = cssPrefMode;
	} else if (currentMode == 'php') {
		$('head').append('<script src="'+moduleDir+'/lib/Ace/src-min/mode-'+currentMode+'.js></script>');
		editor.getSession().setMode({path: 'ace/mode/'+currentMode, inline: true});
		var selectedMode = currentMode;
	} else {
		$('head').append('<script src="'+moduleDir+'/lib/Ace/src-min/mode-'+currentMode+'.js></script>');
		editor.getSession().setMode('ace/mode/'+currentMode);
		var selectedMode = currentMode;
	}
	
	// Append the mode select to the toolbar
	$('#AceToolbar').prepend('<select class="AceModeSelect"></select>');
	// Fill the mode select with the selected modes
	$.each(AceModes, function(Label, AceMode){
		$('.AceModeSelect').prepend('<option value="'+AceMode+'">'+Label+'</option>');
	});
	
	// Update the dropdown with the current mode selected
	$('.AceModeSelect').children().each(function(i){
		var optionValue = $(this).attr('value');
		if (optionValue == selectedMode) {
			$('.AceModeSelect option[value^='+optionValue+']').attr('selected','selected');
			return;
		}
	});
	
	// Automatically load the selected mode file, append it to the head and set the mode
	// When changing the selection
	$('.AceModeSelect').change(function(){
		var mode = $('.AceModeSelect').val();
		$('head').append('<script src="'+moduleDir+'/lib/Ace/src-min/mode-'+mode+'.js></script>');
		editor.getSession().setMode('ace/mode/'+mode);
	});
	
	// add a slider for the text size
	$('#AceToolbar').append('<div class="AceTextSize"><input type="range" min="12" max="20" value="16" step="1" id="AceTextSize"></div>');
	
	// Set the default text size
	$('.ace_editor').css('font-size', $('#AceTextSize').val()+'px');
	
	// Make the slider change the text size in the editor
	$('#AceTextSize').change(function(){
		$('.ace_editor').css('font-size', $('#AceTextSize').val()+'px');
	});
	
	// jump to line input field
	$('#AceToolbar').append('<input class="AceJumpToLine" size"="70" placeholder="type line number" type="text">');
	$('.AceJumpToLine').keyup(function(){
		editor.resize(true);
		editor.scrollToLine($('.AceJumpToLine').val(), true, true, function () {}); 
		editor.gotoLine($('.AceJumpToLine').val(), 0, true);
	});
}

function aceResize() {
	$('.ace_editor').resizable({
		handles: 'e,s'
	});
}

// Keybindings
function initKeyBindings(editor) {
	editor.commands.addCommand({
	name: 'save',
	bindKey: {win: 'Ctrl-S', mac: 'Command-Option-S'},
	exec: function() {
		$('#applybtn').trigger('click');
	},
	readOnly: true
	});
}