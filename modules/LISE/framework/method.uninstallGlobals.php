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


#---------------------
# Database tables
#---------------------

$dict = NewDataDictionary($db);

$sqlarray = $dict->DropTableSQL(cms_db_prefix() . 'module_' . $this->_GetModuleAlias() . '_item');
$dict->ExecuteSQLArray($sqlarray);

$sqlarray = $dict->DropTableSQL(cms_db_prefix() . 'module_' . $this->_GetModuleAlias() . '_fielddef');
$dict->ExecuteSQLArray($sqlarray);

$sqlarray = $dict->DropTableSQL(cms_db_prefix() . 'module_' . $this->_GetModuleAlias() . '_fielddef_opts');
$dict->ExecuteSQLArray($sqlarray);

$sqlarray = $dict->DropTableSQL(cms_db_prefix() . 'module_' . $this->_GetModuleAlias() . '_category'); // the only good cat is a dead cat
$dict->ExecuteSQLArray($sqlarray);

$sqlarray = $dict->DropTableSQL(cms_db_prefix() . 'module_' . $this->_GetModuleAlias() . '_item_categories');
$dict->ExecuteSQLArray($sqlarray);

// DEPRECATED
$sqlarray = $dict->DropTableSQL(cms_db_prefix() . 'module_' . $this->_GetModuleAlias() . '_template');
$dict->ExecuteSQLArray($sqlarray);

$sqlarray = $dict->DropTableSQL(cms_db_prefix() . 'module_' . $this->_GetModuleAlias() . '_fieldval');
$dict->ExecuteSQLArray($sqlarray);

#---------------------
# Templates
#---------------------	

$this->DeleteTemplate();

#---------------------
# Preferences
#---------------------

$this->RemovePreference();

#---------------------
# Permissions
#---------------------

$this->RemovePermission($this->_GetModuleAlias() . '_modify_item');
$this->RemovePermission($this->_GetModuleAlias() . '_modify_category');
$this->RemovePermission($this->_GetModuleAlias() . '_modify_option');
$this->RemovePermission($this->_GetModuleAlias() . '_remove_item');
$this->RemovePermission($this->_GetModuleAlias() . '_approve_item');
$this->RemovePermission($this->_GetModuleAlias() . '_modify_all_item');

#---------------------
# Events
#---------------------

$this->RemoveEvent('PreItemSave');
$this->RemoveEvent('PostItemSave');

$this->RemoveEvent('PreItemDelete');
$this->RemoveEvent('PostItemDelete');

$this->RemoveEvent('PreItemLoad');
$this->RemoveEvent('PostItemLoad');

$this->RemoveEvent('PreRenderAction');

