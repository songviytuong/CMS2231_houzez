<?php
/**
 *
 * Copyright:
 *
 * MajorLabel - Guido Goluke
 * Web: www.majorlabel.nl
 * Email: info@majorlabel.nl
 *
 *
 * Authors:
 *
 * Guido Goluke, <info@majorlabel.nl>
 *  
 *
 * License:
 *-------------------------------------------------------------------------
 *
 * This program is free software; you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation; either version 2 of the License, or
 * (at your option) any later version.
 *
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU General Public License for more details.
 * You should have received a copy of the GNU General Public License
 * along with this program; if not, write to the Free Software
 * Foundation, Inc., 59 Temple Place, Suite 330, Boston, MA 02111-1307 USA
 * Or read it online: http://www.gnu.org/licenses/licenses.html#GPL
 *
 * ------------------------------------------------------------------------- */
$lang['friendlyname'] 			= 'Ace Editor for CMSMS 2.x series';
$lang['admindescription'] 		= 'Implementation of the Ace Editor for the CMSMS 2.x series';
$lang['ask_unistall'] 			= 'Are you sure you want to completely remove Ace Editor 2?';

// Preferences page
$lang['prefspage_title'] 		= 'Ace Editor 2 Preferences';
$lang['prefspage_intro'] 		= 'You can set some preferences here. Use the width type to indicate what your prefered width type is. Then use either the slider (if you\'ve selected percent) of the input field (if you\'ve selected pixels) to set the default width. <b>Remember</b>, you can grab and drag the right and bottom side of the Ace Editor on the fly to change the width and height. In the last input field you can select the Ace Editor default height.';
$lang['width_pref_label'] 		= 'Set prefered width type';
$lang['width_pref_percent'] 	= 'Percentage';
$lang['width_pref_pixels'] 		= 'Pixels';
$lang['width_perc_label'] 		= 'Slide to the desired percentage (between 5% and 95%)';
$lang['width_pixels_label'] 	= 'Enter the desired width in pixels';
$lang['height_pixels_label'] 	= 'Enter the desired height in pixels';
$lang['save_prefs'] 			= 'Save Ace Preferences';
$lang['pref_saved_mess']		= 'Ace Preferences saved';
$lang['css_prefmode_label']		= 'In case of editing CSS, select your prefered mode';
$lang['cssmode_css']			= 'CSS';
$lang['cssmode_less']			= 'LESS';
$lang['cssmode_sass']			= 'SASS';

// Help page
$lang['help_title']				= 'About the Ace Editor for CMSMS 2.x';
$lang['help_p1']				= 'Ace Editor 2.0 gives you the possibility to edit your templates and stylesheets (and also UDT\'s) with the open source syntax highlighter Ace Editor. This includes syntax highlighting, indentation and autocompletion.';
$lang['help_h1']				= 'To install:';
$lang['help_p2']				= 'Simply install the module through the module manager. After that, go to \'My Preferences\' in CMSMS and choose Ace Editor 2 as your syntax highlighter.';
$lang['help_h2']				= 'Features';
$lang['help_p3']				= 'At this point (version 1.02) Ace Editor 2 will give you the following features:';
$lang['help_feat_listitem1']	= 'Automatically detect the kind of file you are editing and select the correct mode.';
$lang['help_feat_listitem2']	= 'The ability to change syntax mode while editing through a dropdown in the top toolbar.';
$lang['help_feat_listitem3']	= 'The ability to set the font size while editing through a slider in the top toolbar.';
$lang['help_feat_listitem4']	= 'The goto-line function through an input field in the top toolbar.';
$lang['help_feat_listitem5']	= 'The top toolbar will <b>not</b> include the search and search-replace function, since that is implemented natively in Ace Editor. Just press \'ctrl+F\' and a searchbox will open on the top-right side of the editor.';
$lang['help_feat_listitem6']	= 'The ability to adjust the editor\'s height and width by dragging the right and bottom side of the editor while editing.';
$lang['help_h3']				= 'User defined settings';
$lang['help_p4']				= 'Through the Extensions->Ace Editor 2.0 link you can find a page where you\'ll be able to set some preferences:';
$lang['help_prefs_listitem1']	= 'The preferred width type. You can set the standard width you want Ace Editor to have. In order to set the width, you first need to specify if you want to use a percentage width or fixed pixel width.';
$lang['help_prefs_listitem2']	= 'The preferred width percentage. If you set your width preference to a percentage, you\'ll need to specify which percentage you want. Use the slider to set it anywhere between 10% and 95%. The input field below the slider will show you the percentage you\'ve chosen.';
$lang['help_prefs_listitem3']	= 'The preferred width in pixels. Of course this will only have an effect if you set your width preference to pixels. <b>DO NOT</b> enter any text in this field, just the number of pixels without the suffix \'px\'.';
$lang['help_prefs_listitem4']	= 'The preferred height in pixels. The same rules apply here that apply for the pixel width input field.';
$lang['help_prefs_listitem5']	= 'Ace Editor 2.0 also supports LESS and SASS stylesheet syntax highlighting. In this dropdown, you can select the syntax mode you want the editor to start in when editing stylesheets.';
$lang['help_h4']				= 'Any Requests?';
$lang['help_p5']				= 'Any requests or code suggestions? You can find the project on Github at <a href=\'https://github.com/Luke1982/aceeditor2\' target=\'_blank\'>https://github.com/Luke1982/aceeditor2</a>. Here you can drop code suggestions. Any requests? Make a feature request in the CMSMS forge.';
$lang['help_h5']				= 'Planned features:';
$lang['help_p6']				= 'Not a lot, since it does what I want it to do at this point. I\'ll probably add theme selection at some point, but only if a feature request comes in, since I like the Twilight theme and don\'t need any other. I\'d like to improve the Smarty mode to use the correct comment style. Also, there\'s going to be the option to set your own softwrap. Apart from this there\'s nothing in the pipeline.';