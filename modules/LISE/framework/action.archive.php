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
# Init objects
#---------------------

$query = $this->GetArchiveQuery($params);

Events::SendEvent($this->GetName(), 'PreRenderAction', array('action_name' => $name, 'query_object' => &$query));

#---------------------
# Check params
#---------------------

//which template to use
$archivetemplate = 'archive_'.$this->GetPreference($this->_GetModuleAlias() . '_default_archive_template');
if(isset($params['template_archive'])) {
	$archivetemplate = 'archive_'.$params['template_archive'];
}
elseif(isset($params['archivetemplate'])) {
	$archivetemplate = 'archive_'.$params['template_archive'];
}

// Summary page check
$summarypage = $this->GetPreference('summarypage', $returnid);
if(isset($params['summarypage'])) {

	if(is_numeric($params['summarypage'])) {
		$summarypage = $params['summarypage'];
	}
	else {
		if(!isset($hm))
			$hm = cmsms()->GetHierarchyManager();
		
		$summarypage = $hm->sureGetNodeByAlias($params['summarypage'])->GetId();
	}
}

$debug = (isset($params['debug']) ? true : false);
$inline = $this->GetPreference('display_inline', 0);

#---------------------
# Init items
#---------------------

$query->AppendTo(LISEQuery::VARTYPE_WHERE, 'A.active = 1');
$result = $query->Execute(true);

$items = array();
while($result && $row = $result->FetchRow()) {

	$onerow = new stdClass;
	$onerow->month 					= $row['month'];
	$onerow->year 					= $row['year'];
	$onerow->count 					= $row['count'];
	$onerow->timestamp 				= mktime(0,0,0,$row['month'],1,$row['year']);
	
	$linkparams = array();
	$linkparams['filter_year'] 		= $onerow->year;
	$linkparams['filter_month'] 	= $onerow->month;
	
	lise_utils::clean_params($params, array('returnid'));
	$linkparams = array_merge($linkparams, $params);

	$onerow->url = $this->CreatePrettyLink($id, 'default', $summarypage, '', $linkparams, '', true, $inline);

	$items[] = $onerow;
}

#---------------------
# Smarty processing
#---------------------

$smarty->assign('archives', $items);
$smarty->assign($this->GetName() .'_archives', $items); // <- Alias for $archives

echo $this->ProcessTemplateFromDatabase($archivetemplate);

if($debug) 
	$smarty->display('string:<pre>{$archives|@print_r}</pre>');

?>
