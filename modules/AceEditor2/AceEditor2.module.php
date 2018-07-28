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
class AceEditor2 extends CMSModule
{
	const MANAGE_PERM = 'manage_ace';
	
    public function GetName() { 
		return basename(__CLASS__); 
	}
	
    public function GetVersion() {
		return "1.05";
	}
	
    public function GetFriendlyName() {
		return 'Ace Editor 2.0'; 
	}
	
    public function GetAdminDescription() {
		return 'Ace Editor Implementation for CMSMS 2.x series'; 
	}
	
	public function IsPluginModule() { 
		return FALSE;
	}
	
	public function HasAdmin() {
		return TRUE;
	}
	
	public function GetAuthor() {
		return 'Guido Goluke'; 
	}
	
	public function GetAuthorEmail() {
		return 'info[a]majorlabel.nl';
	}
	
	public function VisibleToAdminUser() {
		return $this->CheckPermission(self::MANAGE_PERM);
	}	

    public function HasCapability($capability, $params = array())
    {
        if( $capability == CmsCoreCapabilities::SYNTAX_MODULE ) return TRUE;
        return FALSE;
    }
	
	public function GetHelp() {
		$smarty = cmsms()->GetSmarty();
		
		$smarty->assign('help_title',$this->Lang('help_title'));
		$smarty->assign('help_p1',$this->Lang('help_p1'));
		$smarty->assign('help_h1',$this->Lang('help_h1'));
		$smarty->assign('help_p2',$this->Lang('help_p2'));
		$smarty->assign('help_h2',$this->Lang('help_h2'));
		$smarty->assign('help_p3',$this->Lang('help_p3'));
		$smarty->assign('help_feat_listitem1',$this->Lang('help_feat_listitem1'));
		$smarty->assign('help_feat_listitem2',$this->Lang('help_feat_listitem2'));
		$smarty->assign('help_feat_listitem3',$this->Lang('help_feat_listitem3'));
		$smarty->assign('help_feat_listitem4',$this->Lang('help_feat_listitem4'));
		$smarty->assign('help_feat_listitem5',$this->Lang('help_feat_listitem5'));
		$smarty->assign('help_feat_listitem6',$this->Lang('help_feat_listitem6'));
		$smarty->assign('help_h3',$this->Lang('help_h3'));
		$smarty->assign('help_p4',$this->Lang('help_p4'));
		$smarty->assign('help_prefs_listitem1',$this->Lang('help_prefs_listitem1'));
		$smarty->assign('help_prefs_listitem2',$this->Lang('help_prefs_listitem2'));
		$smarty->assign('help_prefs_listitem3',$this->Lang('help_prefs_listitem3'));
		$smarty->assign('help_prefs_listitem4',$this->Lang('help_prefs_listitem4'));
		$smarty->assign('help_prefs_listitem5',$this->Lang('help_prefs_listitem5'));
		$smarty->assign('help_h4',$this->Lang('help_h4'));
		$smarty->assign('help_p5',$this->Lang('help_p5'));
		$smarty->assign('help_h5',$this->Lang('help_h5'));
		$smarty->assign('help_p6',$this->Lang('help_p6'));
		
		return $this->ProcessTemplate('help.tpl');
	}

    public function SyntaxGenerateHeader() {
		
		$script_includes = array('ace.js','theme-twilight.js','ext-language_tools.js');
		$toolbarcss = $this->GetModuleURLPath().'/lib/css/AceCMSMS.css';
		$toolbarjs = $this->GetModuleURLPath().'/lib/js/AceInitCMSMS.js';
		
		// Setup the modes you want to support, the array key is the select box label,
		// The value is the filename (mode-{FILENAME}.js)
		$AceModes = json_encode(array(
			'CSS'		=>		'css',
			'Smarty'	=>		'smarty',
			'HTML'		=>		'html',
			'Javascript'=>		'javascript',
			'JSON'		=>		'json',
			'PHP'		=>		'php',
			'SASS'		=>		'sass',
			'LESS'		=>		'less'
		));
		
		// Get the preferences
		$prefs = $this->GetCurrentAcePrefs();
		// Set the width, based on the width type preferences
		if ($prefs['editor_width_type'] == 'pc') {
			$width = $prefs['editor_width_pc'].'%';
		} else {
			$width = $prefs['editor_width_px'].'px';
		}
		
		$out = '';
		
		foreach($script_includes as $script_include) {
			$out .= '<script src="'.$this->GetModuleURLPath().'/lib/Ace/src-min/'.$script_include.'"></script>';
		}
		
        $out .= <<<EOT
			<script src="{$toolbarjs}"></script>
			<link rel="stylesheet" type="text/css" href="{$toolbarcss}">
			<script type="text/javascript">
			$(window).load(function(){
			   $('textarea.AceEditor2').each(function(){
					var originalTextArea = this;
					var currentMode = originalTextArea.dataset.cmsLang;
					var cssPrefMode = '{$prefs['editor_css_prefmode']}';
					var editor = ace.edit($(this).get(0));
					initAce(editor, originalTextArea);
					initKeyBindings(editor);
					addToolBar(editor, '{$this->GetModuleURLPath()}', {$AceModes}, currentMode, cssPrefMode);
					editor.setTheme('ace/theme/twilight');
					editor.setOptions({
						enableBasicAutocompletion: true,
						enableLiveAutocompletion: true,
						highlightGutterLine: true,
						wrap: 120,
					});
					editor.\$blockScrolling = Infinity;
				});
				aceResize();
			});
			</script>
			<style type="text/css">
			.ace_editor {
			   width: {$width};
			   height: {$prefs['editor_height_px']}px;
			   border: 0;
			}
			</style>
EOT;
        return $out;
    }
	
	public function UninstallPreMessage() { 
		return $this->Lang('ask_uninstall');
	}
	
	// Method to save the settings in the database from the admin panel
	public function SavePreference($prefname, $value) {
		$db 			= \cms_utils::get_db();
		$sql 			= 'UPDATE '.CMS_DB_PREFIX.'mod_ace_editor2 SET '.$prefname.' = ? WHERE id = ?';
		$insert_array	= array($value, 1);
		$db->Execute($sql, $insert_array);
	}
	
	// Method to get all the preferences from the database when opening the preferences screen
	public function GetCurrentAcePrefs() {
		$db 			= \cms_utils::get_db();
		$sql			= 'SELECT * from '.CMS_DB_PREFIX.'mod_ace_editor2 WHERE id = ?';
		$row			= $db->GetRow($sql, array(1));
		return $row;
	}
}