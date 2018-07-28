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
# Init items
#---------------------

if (!$this->CheckPermission($this->_GetModuleAlias() . '_modify_option'))
    return;
	
$admintheme = cms_utils::get_theme_object();
$templates = $this->ListTemplates();
$items = array();
$addlinks = array();

foreach ($templates as $template) {

	list($tpl_type, $tpl_name) = explode('_', $template, 2);

    $onerow = new stdClass();

    $onerow->link   = $this->CreateLink($id, 'admin_edittemplate', $returnid, $tpl_name, array('name' => $template));
    $onerow->name   = $tpl_name;
    $onerow->delete = $this->CreateLink($id, 'admin_deletetemplate', $returnid, $admintheme->DisplayImage('icons/system/delete.gif', $this->ModLang('delete'), '', '', 'systemicon'), array('name' => $template));
    $onerow->edit   = $this->CreateLink($id, 'admin_edittemplate', $returnid, $admintheme->DisplayImage('icons/system/edit.gif', $this->ModLang('edit'), '', '', 'systemicon'), array('name' => $template));

	$tpl_default = $this->GetPreference($this->_GetModuleAlias() . '_default_'.$tpl_type.'_template');
	
	if($tpl_default == $tpl_name) {

		$onerow->default = $admintheme->DisplayImage('icons/system/true.gif', $this->ModLang('is_default'),'','','systemicon');
		
		if($tpl_type != 'filter') // <- For upgrade, so ppl are abel to remove all filter templates after moving stuff to search instance. (1.2.1 -> 1.2.2)
			unset($onerow->delete); // <- Disable delete button
		
	} else {
	
		$onerow->default = $this->CreateLink($id,'admin_setdefaulttemplate',$returnid,
						$admintheme->DisplayImage('icons/system/false.gif',$this->ModLang('status_default'),'','','systemicon'),array('name' => $template));
	}	
	
    $items[$tpl_type][] = $onerow;
	
	if(!isset($addlinks[$tpl_type]))
		$addlinks[$tpl_type] = $this->CreateLink($id, 'admin_edittemplate', $returnid, $admintheme->DisplayImage('icons/system/newobject.gif', $this->ModLang('add', $this->ModLang($tpl_type . 'template')), '', '', 'systemicon') . $this->ModLang('add', $this->ModLang($tpl_type . 'template')), array('type' => $tpl_type));
}

ksort($items);

#---------------------
# Smarty processing
#---------------------

$smarty->assign('items', $items);
$smarty->assign('addlinks', $addlinks);

echo $this->ModProcessTemplate('templatetab.tpl');
?>