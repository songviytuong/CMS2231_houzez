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
if ( !$this->CheckAccess() ) return false;

$db = cmsms()->GetDb();
$current_version = $oldversion;

switch($current_version)
{
	case "2.0":
		die('This release is NOT backwards compatible with previous releases! First uninstall and remove the module, afterwards do a new install from the Forge.');
		
	case "3.0":
	case "3.0.1":
	case "3.0.2":
	case "3.0.3":
	case "3.0.4":
	case "3.0.5":
	case "3.0.6":
	case "3.0.7":
	case "3.0.8":
	case "3.0.9":
		// Remove redundant event handlers
		$this->RemoveEventHandler('Core','ModuleInstalled');
		$this->RemoveEventHandler('Core','ModuleUninstalled');
		$this->RemoveEventHandler('Core','ModuleUpgraded');
		$this->RemoveEventHandler('Core','LogoutPost');
		
		// Remove redundant files
		$deletefiles = array(
			dirname(dirname(dirname(__FILE__))).'/tmp/siteinfo.txt',
			dirname(__FILE__).'/'.'event.Core.LogoutPost.php',
			dirname(__FILE__).'/'.'event.Core.ModuleInstalled.php',
			dirname(__FILE__).'/'.'event.Core.ModuleUninstalled.php',
			dirname(__FILE__).'/'.'event.Core.ModuleUpgraded.php'
		);
		foreach ($deletefiles as $deletefile) @unlink($deletefile);
		
		// version 3.1
		
	case "3.1":
	case "3.1.1":
	case "3.2":
	
		// version 3.3
		
}

?>