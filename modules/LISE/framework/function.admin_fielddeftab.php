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

if (!$this->CheckPermission($this->_GetModuleAlias() . '_modify_option')) return;

$admintheme = cms_utils::get_theme_object();
$fielddefs = $this->GetFieldDefs();

foreach($fielddefs as $fielddef) {

	$fielddef->SetName($this->CreateLink($id, 'admin_editfielddef', $returnid, $fielddef->GetName(), array('fielddef_id'=>$fielddef->GetId())));
	
	if($fielddef->IsRequired()) {
		$fielddef->SetRequired($this->CreateLink($id,'admin_requirefielddef',$returnid,
					$admintheme->DisplayImage('icons/system/true.gif', $this->ModLang('status_optional'),'','','systemicon'),array('require'=>0,'fielddef_id'=>$fielddef->GetId())));
	} else {
		$fielddef->SetRequired($this->CreateLink($id,'admin_requirefielddef', $returnid,
					$admintheme->DisplayImage('icons/system/false.gif',$this->ModLang('status_required'),'','','systemicon'),array('require'=>1,'fielddef_id'=>$fielddef->GetId())));
	}

    $fielddef->editlink = $this->CreateLink($id, 'admin_editfielddef', $returnid, 
					$admintheme->DisplayImage('icons/system/edit.gif', $this->ModLang('edit'), '', '', 'systemicon'), array('fielddef_id' =>$fielddef->GetId()));


	$fielddef->deletelink = $this->CreateLink($id, 'admin_deletefielddef', $returnid, 
					$admintheme->DisplayImage('icons/system/delete.gif', $this->ModLang('delete'), '', '', 'systemicon'), array('fielddef_id' =>$fielddef->GetId()));
	$fielddef->select = $this->CreateInputCheckbox($id, 'fielddefs[]', $fielddef->GetId());

}

#---------------------
# Smarty processing
#---------------------

$smarty->assign('startform', $this->CreateFormStart($id, 'admin_deletefielddef', $returnid));
$smarty->assign('endform', $this->CreateFormEnd());

$smarty->assign_by_ref('items', $fielddefs);
$smarty->assign('submitorder', $this->CreateInputSubmit($id, 'submit_fielddeforder', $this->ModLang('submit_order')));
$smarty->assign('addlink', $this->CreateLink($id, 'admin_editfielddef', $returnid, $admintheme->DisplayImage('icons/system/newobject.gif', $this->ModLang('add', $this->ModLang('fielddef')), '', '', 'systemicon') . $this->ModLang('add', $this->ModLang('fielddef'))));
$smarty->assign('submitmassdelete', $this->CreateInputSubmit($id, 'submitmassdelete', $this->ModLang('delete_selected', $this->ModLang('fielddefs')), '', '', $this->ModLang('areyousure_deletemultiple', $this->ModLang('fielddefs'))));

echo $this->ModProcessTemplate('fielddeftab.tpl');

?>
