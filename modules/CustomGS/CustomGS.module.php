<?php
#-------------------------------------------------------------------------
# Module: Custom Global Settings
# Author: Rolf Tjassens, Jos
#-------------------------------------------------------------------------
# CMS - CMS Made Simple is (c) 2011 by Ted Kulp (wishy@cmsmadesimple.org)
# This project's homepage is: http://www.cmsmadesimple.org
# The module's homepage is: http://dev.cmsmadesimple.org/projects/customgs
#-------------------------------------------------------------------------
# This program is free software; you can redistribute it and/or modify
# it under the terms of the GNU General Public License as published by
# the Free Software Foundation; either version 2 of the License, or
# (at your option) any later version.
#
# This program is distributed in the hope that it will be useful,
# but WITHOUT ANY WARRANTY; without even the implied warranty of
# MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
# GNU General Public License for more details.
# You should have received a copy of the GNU General Public License
# along with this program; if not, write to the Free Software
# Foundation, Inc., 59 Temple Place, Suite 330, Boston, MA 02111-1307 USA
# Or read it online: http://www.gnu.org/licenses/licenses.html#GPL
#-------------------------------------------------------------------------

if (!isset($gCms)) exit;

class CustomGS extends CMSModule
{
	function GetName()
	{
		return 'CustomGS';
	}

	function GetFriendlyName()
	{
		return $this->GetPreference('input_custom_modulename');
	}
	
	function GetVersion()
	{
		return '3.2';
	}
	
	function MinimumCMSVersion()
	{
		return '1.12';
	}
	
	function GetHelp()
	{
		return file_get_contents(dirname(__FILE__).'/help_text.inc');
	}
	
	function GetAuthor()
	{
		return 'Rolf Tjassens, Jos';
	}
	
	function GetAuthorEmail()
	{
		return 'info at cmscanbesimple dot org, josvd at live dot nl';
	}
	
	function GetChangeLog()
	{
		return file_get_contents(dirname(__FILE__).'/changelog.inc');
	}
	
	function IsPluginModule()
	{
		return true;
	}
	
	function HasAdmin()
	{
		return true;
	}
	
	function GetAdminSection()
	{
		return $this->GetPreference('admin_section', 'extensions');
	}
	
	function GetAdminDescription()
	{
		return $this->Lang('moddescription');
	}

	function VisibleToAdminUser() 
	{
		return $this->CheckPermission('Custom Global Settings - Manage') || $this->CheckPermission('Custom Global Settings - Use');
	}

	function GetDependencies()
	{
		return array();
	}
	
	function InitializeFrontend() {
		$this->RegisterModulePlugin();
		$this->RestrictUnknownParams();
		$this->SetParameterType('showvars',CLEAN_INT);
		
		$fields = $this->GetSettings();
		global $CMS_VERSION;
		if ($CMS_VERSION >= '2') {
			// by exception we use assignGlobal in stead of assign to make the variable global by default. Not to use in other modules!
			cmsms()->GetSmarty()->assignGlobal('CustomGS', $fields);
		}
		else
		{
			cmsms()->GetSmarty()->assign('CustomGS', $fields);
		}
	}
	
	function SetParameters()
	{
		$this->CreateParameter('showvars',1,'Set this parameter to show all available variables and their values. For testing purposes only.');
	}
	
	function GetEventDescription($eventname)
	{
		return $this->Lang('event_info_'.$eventname );
	}

	function GetEventHelp($eventname)
	{
		return $this->Lang('event_help_'.$eventname );
	}

	function InstallPostMessage()
	{
		return $this->Lang('postinstall');
	}

	function UninstallPreMessage()
	{
		return $this->Lang('uninstall_confirm');
	}
	
	function UninstallPostMessage()
	{
		return $this->Lang('postuninstall');
	}

	function GetHeaderHTML()
	{
		$tmpl = <<<EOT
<link rel="stylesheet" type="text/css" href="../modules/CustomGS/lib/jquery/jquery-ui.smoothness.css" media="all" /> <!-- smoothness/jquery-ui-1.8.12.custom.css -->
<link rel="stylesheet" type="text/css" href="../modules/CustomGS/lib/jquery/colorpicker.css" media="all">
<script type="text/javascript" src="../modules/CustomGS/lib/jquery/jquery.tablednd.js"></script>
<style type="text/css">
	.cms_label { margin-right:12px; }
	.smartyvar { padding:0 3px; cursor:text; }
	/* css for timepicker */
	.ui-timepicker-div .ui-widget-header { margin-bottom: 8px; }
	.ui-timepicker-div dl { text-align: left; }
	.ui-timepicker-div dl dt { height: 25px; margin-bottom: -25px; }
	.ui-timepicker-div dl dd { margin: 0 10px 10px 65px; }
	.ui-timepicker-div td { font-size: 90%; }
	.ui-tpicker-grid-label { background: none; border: none; margin: 0; padding: 0; }

	.cgs_pageselect {
		display: inline-block;
		height:32px;
		overflow:hidden;
	}
				
	.cgs_fieldset {
			margin-top:10px;
			padding-top:0;
			padding-bottom:10px;
	}

	.cgs_collapsible {
			cursor: pointer;
	}

	.collapse-open span {
			display:inline-block;
			width:14px;
			height:14px;
			background:url(../modules/CustomGS/lib/jquery/images/ui-icons_454545_256x240.png) -18px -192px no-repeat;
	}

	.collapse-close span {
			display:inline-block;
			width:14px;
			height:14px;
			background:url(../modules/CustomGS/lib/jquery/images/ui-icons_454545_256x240.png) -2px -192px no-repeat;
	}
</style>
EOT;
		return $tmpl;
	}

	/**
	* Method to get parameters of a field by name or by fieldid
	*
	* @final
	* @access public
	* @return array()
	*/
	function GetField($field)
	{
		$db = cmsms()->GetDB();
		$query = "SELECT * FROM ".cms_db_prefix()."module_customgs WHERE fieldid=? OR name=? ORDER BY fieldid DESC";
		$result = $db->Execute($query, array($field, $field));
		if( $result && $result->RecordCount() > 0 )
		{
			$row = $result->FetchRow();
		}
		else
		{
			$row = FALSE;
		}
		return $row;
	}

	/**
	* Method to get parameters of fields
	*
	* @final
	* @access public
	* @return array()
	*/
	function GetFields($tabid)
	{
		$userid = get_userid();
		$userops = cmsms()->GetUserOperations();
		$adminperm = $userops->UserInGroup($userid, 1); // is admin
		
		$fields = array();

		$db = cmsms()->GetDB();
		$query = "SELECT f.* FROM ".cms_db_prefix()."module_customgs f
					JOIN ".cms_db_prefix()."module_customgs_tabfield tf ON f.fieldid = tf.fieldid AND tf.tabid = ?
					ORDER BY f.sortorder ASC";
		$result = $db->Execute($query, array($tabid));
		if ( $result && $result->RecordCount() > 0 )
		{
			while ( $row=$result->FetchRow() )
			{
				// check editor permissions
				$editperm = FALSE;
				if ( !$adminperm && !empty($row['editors']) )
				{
					$editors = explode(';', $row['editors']);
					foreach ($editors as $editor)
					{
						$editperm = $editperm || $userops->UserInGroup($userid, $editor);
					}
				}
				else
				{
					$editperm = TRUE;
				}
				if ( $editperm )
				{
					$fields[$row['fieldid']] = $row;
				}
			}
		}
		return $fields;
	}

	/**
	* Method to get parameters of a tab by name or by tabid
	*
	* @final
	* @access public
	* @return array()
	*/
	function GetTab($tab)
	{
		$db = cmsms()->GetDB();
		$query = "SELECT * FROM ".cms_db_prefix()."module_customgs_tab WHERE tabid=? OR name=?";
		$result = $db->Execute($query, array($tab, $tab));
		if( $result && $result->RecordCount() > 0 )
		{
			$row = $result->FetchRow();
		}
		else
		{
			$row = FALSE;
		}
		return $row;
	}

	/**
	* Method to get tabs
	*
	* @final
	* @access public
	* @return array()
	*/
	function GetTabs($field = NULL)
	{
		$userid = get_userid();
		$userops = cmsms()->GetUserOperations();
		$adminperm = $userops->UserInGroup($userid, 1); // is admin
		
		$tabs = array();

		$db = cmsms()->GetDB();
		if ( empty($field) ) 
		{
			$query = "SELECT * FROM ".cms_db_prefix()."module_customgs_tab ORDER BY sortorder ASC";
			$result = $db->Execute($query);
		}
		else
		{
			$query = "SELECT t.*, tf.fieldid AS checked FROM ".cms_db_prefix()."module_customgs_tab t
						LEFT JOIN ".cms_db_prefix()."module_customgs_tabfield tf ON t.tabid = tf.tabid AND tf.fieldid = ?
						ORDER BY t.sortorder ASC";
			$result = $db->Execute($query, array($field));
		}
		if ( $result && $result->RecordCount() > 0 )
		{
			while ( $row=$result->FetchRow() )
			{
				// check editor permissions
				$editperm = FALSE;
				if ( !$adminperm && !empty($row['editors']) && empty($field) )
				{
					$editors = explode(';', $row['editors']);
					foreach ($editors as $editor)
					{
						$editperm = $editperm || $userops->UserInGroup($userid, $editor);
					}
				}
				else
				{
					$editperm = TRUE;
				}
				if ( $editperm )
				{
					$tabs[] = $row;
				}
			}
		}
		return $tabs;
	}

	/**
	* Method to get all settings
	*
	* @final
	* @access public
	* @return array()
	*/
	function GetSettings($parseSmarty = true)
	{
		$fields = array();
		
		$smarty = cmsms()->GetSmarty();
		$db = cmsms()->GetDB();
		$query = "SELECT * FROM " . cms_db_prefix() . "module_customgs";
		$result = $db->Execute($query);
		if ( $result && $result->RecordCount() > 0 )
		{
			while ( $row=$result->FetchRow() )
			{
				if ( $row['type'] != 'fieldsetstart' && $row['type'] != 'fieldsetend' )
				{
					$alias = str_replace('__', '_', str_replace('-', '_', munge_string_to_url($row['name'])));
					if ( $row['type'] == 'colorpicker' )
					{
						$fields[$alias] = "#".$row['value'];
					}
					elseif ( $parseSmarty && ($row['type'] == 'textarea' || $row['type'] == 'wysiwyg') && $row['properties'] )
					{
						$fields[$alias] = $smarty->fetch('string:'.$row['value']);
					}
					else
					{
						$fields[$alias] = $row['value'];
					}
					$fields[$row['fieldid']] = $fields[$alias];
				}
			}
		}
		return $fields;
	}

	/**
	* Method to clear the combined stylesheet cache
	*
	* @final
	* @access private
	* @return void
	*/
	function ClearStylesheetCache()
	{
		foreach (glob("../tmp/cache/stylesheet_combined_*.css") as $filename) {
			@unlink($filename);
		}
	}

}
?>