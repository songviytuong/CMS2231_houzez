<?php
#-------------------------------------------------------------------------
# LISE - List It Special Edition
# Version 1.2
# A fork of ListI2
# maintained by Fernando Morgado AKA Jo Morg
# since 2015
#-------------------------------------------------------------------------
#
# Original Author: Ben Malen, <ben@conceptfactory.com.au>
# Co-Maintainer: Simon Radford, <simon@conceptfactory.com.au>
# Web: www.conceptfactory.com.au
#
#-------------------------------------------------------------------------
#
# Maintainer since 2011 up to 2014: Jonathan Schmid, <hi@jonathanschmid.de>
# Web: www.jonathanschmid.de
#
#-------------------------------------------------------------------------
#
# Some wackos started destroying stuff since 2012 and stopped at 2014:
#
# Tapio Löytty, <tapsa@orange-media.fi>
# Web: www.orange-media.fi
#
# Goran Ilic, <uniqu3e@gmail.com>
# Web: www.ich-mach-das.at
#
#-------------------------------------------------------------------------
#
# LISE is a CMS Made Simple module that enables the web developer to create
# multiple lists throughout a site. It can be duplicated and given friendly
# names for easier client maintenance.
#
#-------------------------------------------------------------------------
# BEGIN_LICENSE
#-------------------------------------------------------------------------
# This file is part of LISE
# LISE program is free software; you can redistribute it and/or modify
# it under the terms of the GNU General Public License as published by
# the Free Software Foundation; either version 2 of the License, or
# (at your option) any later version.
#
# LISE program is distributed in the hope that it will be useful,
# but WITHOUT ANY WARRANTY; without even the implied warranty of
# MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
# GNU General Public License for more details.
# You should have received a copy of the GNU General Public License
# along with this program; if not, write to the Free Software
# Foundation, Inc., 59 Temple Place, Suite 330, Boston, MA 02111-1307 USA
# Or read it online: http://www.gnu.org/licenses/licenses.html#GPL
#
#-------------------------------------------------------------------------
# END_LICENSE
#-------------------------------------------------------------------------

if( !defined('CMS_VERSION') ) exit;

$fieldName = 'm1_filename';


//$invalid_names = array('lise', 'original', 'xdefs', 'loader');
//$modules = $this->ListModules();
//foreach($modules as $mod) 
//{
//	$mod->module_name = substr($mod->module_name, strlen(LISEDuplicator::MOD_PREFIX));
//	$invalid_names[] = strtolower($mod->module_name);
//}
//
#---------------------
# Submit
#---------------------

if (isset($params['upload'])) 
{
	$errors = array();
  
  
  if (!isset ($_FILES[$fieldName]) || !isset ($_FILES)
    || !is_array ($_FILES[$fieldName]) || !$_FILES[$fieldName]['name'])
    {
      echo 'error no xml file';
    }
    else
    {
      // normalize the file variable
      $file = $_FILES[$fieldName];
      
      if( !isset($file['tmp_name']) || trim($file['tmp_name']) == '' ) 
      {
        echo 'error no xml file';
      }
    }
    
    $xmlstr = file_get_contents($file['tmp_name']);
    $importer = new LISEInstanceImporter($xmlstr);
    $module_fullname = $importer->Run();
	
//	if(empty($module_name)) 
//  {
//		$errors[] = $this->ModLang('module_name_empty');
//	}
//	
//	if(preg_match('/[^0-9a-zA-Z]/', $module_name)) 
//  {
//		$errors[] = $this->ModLang('module_name_invalid');
//	}
//	
//	if(in_array(strtolower($module_name), $invalid_names))
//  {
//		$errors[] = $this->ModLang('module_name_invalid');
//	}	
//
//	if (empty($errors))
//  {
//		$duplicator = new LISEDuplicator($module_name);
//		$module_fullname = $duplicator->Run();
//		
//		if($this->GetPreference('allow_autoinstall')) 
//    {
//			$modops = cmsms()->GetModuleOperations();
//			$modops->InstallModule($module_fullname);
//		}
//		
//		$params = array('message' => 'modulecopied','active_tab' => 'instancestab');
//		$this->Redirect($id, 'defaultadmin', '', $params);  
//	}
}

$params = array('message' => 'modulecopied','active_tab' => 'instancestab');

$this->Redirect($id, 'defaultadmin', '', $params);
?>