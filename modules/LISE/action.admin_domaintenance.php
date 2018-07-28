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

 #BEGIN_LICENSE
#-------------------------------------------------------------------------
# 
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
#
#-------------------------------------------------------------------------
#END_LICENSE
if( !defined('CMS_VERSION') ) exit;

$parms = array('active_tab' => 'maintenancetab');

#---------------------
# Fix fielddef tables
#---------------------
if(isset($params['fix_fielddefs'])) 
{
  $type_map = array(
                      'textbox'     => 'TextInput',
                      'dropdown'    => 'Dropdown',
                      'hierarchy'   => 'ContentPages',
                      'checkbox'    => 'Checkbox',
                      'textarea'    => 'TextArea',
                      'gallery'     => 'GalleryDropdown',
                      'select_date' => 'SelectDate',
                      'upload_file' => 'GBFilePicker',
                      'select_file' => 'SelectFile'
                    );

  $modules = $this->ListModules();
  
  foreach($modules as $module) {

    $mod = cmsms()->GetModuleInstance($module->module_name);
    
    if(is_object($mod)) {
      
      foreach($type_map as $old_type=>$new_type) {

        $query  = 'UPDATE ' . cms_db_prefix() . 'module_' . $mod->_GetModuleAlias() . '_fielddef SET type = ? WHERE type = ?';
        $result = $db->Execute($query, array($new_type, $old_type));
      }
    }
  }
  
  $parms['message'] = 'message_fielddefs_fixed';
}

#---------------------
# import from LI2
#---------------------
if(isset($params['import_from_LI2']))  
{
    $listit2 = cmsms()->GetModuleInstance('ListIt2');
    $modules = $listit2->ListModules();

    foreach($modules as $module) 
    {
      $curr_mod = cmsms()->GetModuleInstance($module->module_name);

      if( !is_object($curr_mod)) 
      {
         throw new \LISE\Exception('Error in ' . __CLASS__ . ' invalid instance name!');
      }
      
      $duplicator = new LISE_LI2converter($module->module_name);
      $module_fullname = $duplicator->Run();  
    }
	
	$parms['message'] = 'message_instances_copied';
}

#---------------------
# Fix import from LI2
#---------------------
if(isset($params['fix_import_from_LI2']))
{
  $modules = $this->ListModules();
  $error_messages = array();
  
  foreach($modules as $module)
  {
    $mod = cmsms()->GetModuleInstance($module->module_name);
    
    if( !is_object($mod) ) continue; # module is not active or was just deleted, or something odd....
    
    $tableprefix = cms_db_prefix() . 'module_' . $mod->_GetModuleAlias();

    try
    {
      $tablename = $tableprefix . '_item';
      
      if( !lise_utils::db_column_exists($tablename, 'url') )
      {
        $q = 'ALTER TABLE ' . $tablename . ' ADD url VARCHAR(250)';
        $r = $db->Execute($q);
        if(!$r) throw new \LISE\Exception($db->ErrorMsg(), \LISE\Error::DISCRETE_DB );
      }
      
      $tablename = $tableprefix . '_fielddef';
      
      if( !lise_utils::db_column_exists($tablename, 'template') )
      {
        $q = 'ALTER TABLE ' . $tablename . ' ADD template VARCHAR(250)';
        $r = $db->Execute($q);
        if(!$r) throw new \LISE\Exception($db->ErrorMsg(), \LISE\Error::DISCRETE_DB );
      }
    }
    catch(Exception $e)
    {
      //$error_messages[] = 'Error: ' . $e->getMessage();  
      $error_messages[] = $e; // converts to string
    }
  }
  
  if( !empty($error_messages) ) 
  {
    $parms['db_errors'] = implode(', ', $error_messages);
  }    
}


#---------------------
# Redirect
#---------------------

$this->Redirect($id, 'defaultadmin', $returnid, $parms);

?>