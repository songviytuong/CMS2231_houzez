<?php 
#-------------------------------------------------------------------------
# Module: SimpleSiteInfo
# Author: Noel McGran, Rolf Tjassens
#-------------------------------------------------------------------------
# CMS Made Simple is (c) 2004 - 2011 by Ted Kulp (wishy@cmsmadesimple.org)
# CMS Made Simple is (c) 2011 - 2016 by The CMSMS Dev Team
# This project's homepage is: http://www.cmsmadesimple.org
# The module's homepage is: http://dev.cmsmadesimple.org/projects/simplesiteinfo
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

if ( !cmsms() ) exit;

class SimpleSiteInfo extends CMSModule {

	function GetName(){ return 'SimpleSiteInfo'; }
	function GetFriendlyName(){ return $this->Lang('friendlyname'); }
	function GetVersion(){ return '3.3'; }
	function GetHelp() { return file_get_contents(dirname(__FILE__).'/help_text.inc'); }
	function GetAuthor(){ return 'Noel McGran, Rolf Tjassens'; }
	function GetAuthorEmail(){ return 'nmcgran@telus.net, info at cmscanbesimple dot org'; }
	function GetChangeLog() { return file_get_contents(dirname(__FILE__).'/changelog.inc'); }
	function SetParameters(){ $this->RestrictUnknownParams(); }
	function IsPluginModule(){ return true; }
	function HasAdmin(){ return true; }
	function GetAdminSection(){ return 'siteadmin'; }
	function GetAdminDescription(){ return $this->Lang('moddescription'); }
	function VisibleToAdminUser(){ return ($this->CheckPermission('Modify Site Preferences') || $this->CheckPermission('Modify Modules')); }
	function GetDependencies(){ return array(); }
	function MinimumCMSVersion(){ return "1.12"; }
	function InstallPostMessage(){ return $this->Lang('postinstall'); }
	function UninstallPostMessage(){ return $this->Lang('postuninstall'); }
	
	function InitializeFrontend()
	{
		$this->RestrictUnknownParams();
		$this->SetParameterType('key',CLEAN_STRING);
	}
	
	function CheckAccess()
	{
		if ( !$this->VisibleToAdminUser() )  {
			echo '<p class="red">' . $this->Lang('error_permission') . '</p>';
			return false;
		}
		else return true;
	}
	
	function SSIencryption($data, $key)
	{
		$iv = substr( $key, 8 ); // 16 bytes
		return openssl_encrypt ( $data, 'aes-128-cbc', $key, true, $iv );
	}
	
	function UpdateInfoFile() {
		// Basic Setup
		global $CMS_VERSION;
		$db = cmsms()->GetDb();
		$config = cmsms()->GetConfig();
		$admin_url = $config['admin_url'];
		$php_version = phpversion();
		$config_writable = '0';
		$installer_present = '0';
		$maintenance_mode = '0';
		
		$version_file_pwd = $this->getPreference('SimpleSiteInfoPwd');
		$local_key = substr( $version_file_pwd, 20 );
		
		// SimpleSiteInfo Version
		$simplesiteinfo_version = $this->GetVersion();
		
		// Check for writable config file
		if( is_writable(CONFIG_FILE_LOCATION) ) $config_writable = '1';
		
		// Check for install folder presence - 1.12 series or perhaps the 2.0 series with expanded installer
		if( file_exists(dirname(dirname(dirname(__FILE__))).'/install') ) $installer_present = '1';
		
		// Check for installer file presence - 2.0 series
		$pattern = cms_join_path(CMS_ROOT_PATH,'cmsms-*-install.php');
		$files = glob($pattern);
		if( is_array($files) && count($files) > 0 ) $installer_present = '1';
		
		// Check for maintenance mode
		if( get_site_preference('enablesitedownmessage') == '1' )  $maintenance_mode = '1';
		
		// Output Start
		$file_out  = "CMSMS*\n";
		$file_out .= $admin_url . "*\n";
		$file_out .= $CMS_VERSION . "*\n";
		$file_out .= $php_version . "*\n";
		
		// Module Query
		$query = "SELECT * FROM ".cms_db_prefix()."modules WHERE active=1 ORDER BY module_name ASC";
		$dbresult = $db->Execute($query);
		
		while($dbresult && $row = $dbresult->FetchRow()) {
   			$file_out .= $row['module_name'] . "," .$row['version'] . "|";
		}
		$file_out = substr($file_out, 0, -1);
		
		// Output
		$file_out .= "*\n";
		$file_out .= $simplesiteinfo_version . "*\n";
		$file_out .= $config_writable . "*\n";
		$file_out .= $installer_present . "*\n";
		$file_out .= $maintenance_mode . "*";
		
		$file_out_enc = $this->SSIencryption( $file_out, $version_file_pwd );
		
		$file_path = cmsms()->config['root_path'] . '/tmp/templates_c/SimpleSiteInfo^' . md5($local_key) . '.txt';
		
		if ( version_compare( CMS_VERSION, '2.0', '<' ) ) {
			cmsms()->variables['content-type'] = 'text/plain'; // 1.12 series
		} else {
			cmsms()->set_content_type('text/plain'); // 2.0 series
		}
		
		file_put_contents( $file_path, $file_out_enc );
	}
}

?>