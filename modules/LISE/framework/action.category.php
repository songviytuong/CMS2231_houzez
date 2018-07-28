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
$thisURL = $_SERVER['SCRIPT_NAME'] . '?';
foreach ($_GET as $key => $val)
    if ('hl' != $key)
        $thisURL .= $key . '=' . $val . '&amp;';
if (isset($hls)) {
    $langList = ' &nbsp; &nbsp; ';
    foreach ($hls as $key => $mle) {
        $langList .= ($hl == $key) ? $mle['flag'] . ' ' : '<a href="' . $thisURL . 'hl=' . $key . '">' . $mle['flag'] . '</a> ';
    }
}
$smarty->assign('langList', $langList);
#End MLE

#---------------------
# Init objects
#---------------------

$query_object = $this->GetCategoryQuery($params);

Events::SendEvent($this->GetName(), 'PreRenderAction', array('action_name' => $name, 'query_object' => &$query_object));

#---------------------
# Init
#---------------------

//which template to use
$template = 'category_'.$this->GetPreference($this->_GetModuleAlias() . '_default_category_template');
if(isset($params['template_category'])) {
	$template = 'category_'.$params['template_category'];
}
elseif(isset($params['categorytemplate'])) {
	$template = 'category_'.$params['categorytemplate'];
}

$debug = (isset($params['debug']) ? true : false);
$inline = $this->GetPreference('display_inline', 0);

#---------------------
# Init items
#---------------------

$query_object->AppendTo(LISEQuery::VARTYPE_WHERE, 'B.active = 1 AND B.parent_id = -1');
$dbr = $query_object->Execute(true);

$items = array();
while($dbr && !$dbr->EOF) {

	$items[$dbr->fields['category_id']] = $dbr->fields['category_id'];
	$dbr->MoveNext();
}

if($dbr) 
	$dbr->Close();	

#---------------------
# Build hierarchy
#---------------------

// Set collapse true/false
$showparents = array();
if (isset($params['collapse'])) {

	// Grap current path
	$current_path = cms_utils::get_app_data('lise_id_hierarchy');

	if ($current_path) {
	
		$splitted_path = explode('.', $current_path);
		foreach($splitted_path as $path) {
		
			$showparents[] = $path;
		}
	}
}

$origdepth = 1;
$prevdepth = 1;
$count = 0;
$nodelist = array();


LISEHierarchyManager::GetChildNodes($this, $id, $returnid, $items, $nodelist, $count, $prevdepth, $origdepth, $params, $showparents,$mleblock);

#---------------------
# Smarty processing
#---------------------

$smarty->assign('categories', $nodelist);

echo $this->ProcessTemplateFromDatabase($template);

?>