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

try
{
  $db = cmsms()->GetDb();
  $dict = NewDataDictionary($db);
  $taboptarray = array('mysql' => 'Engine=InnoDB');

  // instance tables
  $fields = '
      module_id I KEY AUTO,
      module_name C(160)
  ';

  $sqlarray = $dict->CreateTableSQL(cms_db_prefix() . 'module_lise_instances', $fields, $taboptarray);
  $r = $dict->ExecuteSQLArray($sqlarray, FALSE);
  
  if($r != 2)
  {
    //throw new Exception( $db->ErrorMsg(), $db->ErrorNo() );
    throw new \LISE\Exception($db->ErrorNo() . ' - ' . $db->ErrorMsg() , \LISE\Error::DISCRETE_DB );
  }


  // Fielddef tables
  $fields = '
    type C(255) KEY,
    originator C(255),
    path C(255),
    active I4,
    disabled I4
  ';

  $sqlarray = $dict->CreateTableSQL(cms_db_prefix() . 'module_lise_fielddefs', $fields, $taboptarray);
  $r = $dict->ExecuteSQLArray($sqlarray, FALSE);
  
  if($r != 2)
  {
    //throw new Exception( $db->ErrorMsg(), $db->ErrorNo() );
    throw new \LISE\Exception($db->ErrorNo() . ' - ' . $db->ErrorMsg() , \LISE\Error::DISCRETE_DB );
  }
} 
catch (Exception $e) 
{
  return $e;
}


#---------------------
# Events
#---------------------

$this->AddEventHandler('Core', 'ContentPostCompile', false);
$this->AddEventHandler('Core', 'ModuleInstalled', false);
$this->AddEventHandler('Core', 'ModuleUninstalled', false);
$this->AddEventHandler('Core', 'ModuleUpgraded', false);

#---------------------
# Preferences
#---------------------

$this->SetPreference('allow_autoscan', 0);
$this->SetPreference('allow_autoinstall', 1);
$this->SetPreference('allow_autoupdate', 1);

#---------------------
# Smarty plugins
#---------------------
$this->RegisterSmartyPlugin('LISELoader','function', array('LISELoader', 'loader'));

#---------------------
# Scan fielddefs
#---------------------

LISEFielddefOperations::ScanModules();

