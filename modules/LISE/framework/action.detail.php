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
# Check params
#---------------------
if (!isset($params['item'])) {
    die('missing parameter, this should not happen');
}

global $mle, $mleblock;

$template = 'detail_' . $this->GetPreference($this->_GetModuleAlias() . '_default_detail_template');
if (isset($params['template_detail'])) {

	$template = 'detail_' . $params['template_detail'];
}
elseif (isset($params['detailtemplate'])) {

	$template = 'detail_' . $params['detailtemplate'];
}

if(isset($params['item'])) {
	cms_utils::set_app_data('lise_item', $params['item']);
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

// return page can be in a session var
$test = isset($_SESSION[$this->GetName() . 'dp']) ? $_SESSION[$this->GetName() . 'dp'] : '';

if( is_array($test) )
{
  $contentops = cmsms()->GetContentOperations();
  $current_page_obj = $contentops->getContentObject();
  $current_page = $current_page_obj->Id();
  
  if( isset($test[$current_page]) )
  {
    $summarypage = $test[$current_page];
    $return_page_obj = $contentops->LoadContentFromId($summarypage);
    $ret_pretty_url = $return_page_obj->GetURL();
  }
}

$identifier = is_numeric($params['item']) ? 'item_id' : 'alias';
$debug = (isset($params['debug']) ? true : false);

#---------------------
# Init item
#---------------------
$item = $this->LoadItemByIdentifier($identifier, $params['item'], $mleblock);

/************************************************************************/
# quick dirty fix (needs to be revisited)
# we do need an url for each item here already 
# probably there are parameters missing so this needs more work
# JoMorg
/************************************************************************/
$config = cmsms()->GetConfig();

if( empty($item->url) || $config['url_rewriting'] != 'mod_rewrite')
{
  $detailspage = $this->GetPreference('detailpage', $returnid);
  $string_array = array();
  $string_array[] = $this->prefix;
  $string_array[] = $item->alias;
  $string_array[] = $detailspage;

  $prettyurl = implode('/', $string_array);    

  $item->url = $this->create_url($id, 'detail', $detailspage, array('item' => $params['item']), false, false, $prettyurl);
}
/************************************************************************/

// lets deal with tags if they are available
foreach($item->fielddefs as $one)
{
  $linkparams = array();
  if( 'Tags' !== $one->type) continue;
  $one->SetTagsParams($this, $id, 'default', $summarypage, $linkparams);
}

# try to get the return link right for pagedetail overrides...
if( !empty($ret_pretty_url) )
{
  $ret_pretty_link = '<a href="' . $ret_pretty_url .'" class="return-link">return</a>';
}
else
{
  $ret_pretty_url = $this->CreatePrettyLink($id, 'default', $summarypage, '', $params, '', TRUE);
  $ret_pretty_link = $this->CreatePrettyLink($id, 'default', $summarypage, $this->ModLang('return_url'), $params);
}



#---------------------
# Smarty processing
#---------------------

$smarty->assign('item', $item);
$smarty->assign('LISE_action', 'detail');
$smarty->assign($this->GetName() . '_item', $item); // <- Alias for $item

$smarty->assign('return_url', $ret_pretty_url);
$smarty->assign('return_link', $ret_pretty_link); 

echo $this->ProcessTemplateFromDatabase($template);

if($debug) 
	$smarty->display('string:<pre>{$item|@print_r}</pre>');

?>