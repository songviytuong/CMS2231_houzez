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

#Start MLE
global $hls, $hl, $mleblock;
#End MLE

#---------------------
# Init categories
#---------------------

if (!$this->CheckPermission($this->_GetModuleAlias() . '_modify_category')) 
	return;

$admintheme = cms_utils::get_theme_object();

$query_object = new LISECategoryQuery($this, $params);
$result = $query_object->Execute(true);

$items = array();
while ($result && $row = $result->FetchRow()) {

	$obj = $this->InitiateCategory();
	LISECategoryOperations::Load($this, $obj, $row, $mleblock);
	
	//$obj->depth = count(explode('.', $obj->hierarchy)) - 1;
 
    // approve
    if ($obj->active) {
        $obj->approve = $this->CreateLink($id, 'admin_approvecategory', $returnid, $admintheme->DisplayImage('icons/system/true.gif', $this->ModLang('revert'), '', '', 'systemicon'), array(
            'approve' => 0,
            'category_id' => $row['category_id']
        ));
    } else {
        $obj->approve = $this->CreateLink($id, 'admin_approvecategory', $returnid, $admintheme->DisplayImage('icons/system/false.gif', $this->ModLang('approve'), '', '', 'systemicon'), array(
            'approve' => 1,
            'category_id' => $row['category_id']
        ));
    }
    
    // edit
    $obj->editlink = $this->CreateLink($id, 'admin_editcategory', $returnid, $admintheme->DisplayImage('icons/system/edit.gif', $this->ModLang('edit'), '', '', 'systemicon'), array(
        'category_id' => $row['category_id']
    ));
	
    $obj->name = $this->CreateLink($id, 'admin_editcategory', $returnid, $obj->name, array(
        'category_id' => $row['category_id']
    ));
	
	// delete
    $obj->delete = $this->CreateLink($id, 'admin_deletecategory', $returnid, $admintheme->DisplayImage('icons/system/delete.gif', $this->ModLang('delete'), '', '', 'systemicon'), array(
        'category_id' => $row['category_id']
    ));
	
	// select box
    $obj->select = $this->CreateInputCheckbox($id, 'categories[]', $row['category_id']);
	
	$items[] = $obj;
}

#---------------------
# Smarty processing
#---------------------

$smarty->assign('items', $items);
$smarty->assign('addlink', $this->CreateLink($id, 'admin_editcategory', $returnid, $admintheme->DisplayImage('icons/system/newobject.gif', $this->ModLang('add', $this->ModLang('category')), '', '', 'systemicon') .$this->ModLang('add', $this->ModLang('category'))));
$smarty->assign('reorderlink', $this->CreateLink($id, 'admin_reordercategory', $returnid, $admintheme->DisplayImage('icons/system/reorder.gif', $this->ModLang('reorder_categories'), '', '', 'systemicon') .$this->ModLang('reorder_categories')));
 
echo $this->ModProcessTemplate('categorytab.tpl');

?>