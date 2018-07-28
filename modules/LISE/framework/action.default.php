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

# smallish hack for tags
if( isset($params['tag']) )
{
  $params['search'] = urldecode($params['tag']);
  unset($params['tag']);
}

# flag to define which kind of urls to use on pagination
# given the fack that search results and filtered pages can't use pretty URLS... period!!!
$pretty_pagination = TRUE;

# store the search and filter parameters into the session so they can be retrieved by smarty if needed
# instancename_search and # instancename_search_*, where * is a field alias
$sesvarprefix = $this->GetName() . '_';
$params2session = array(
                          'showall',
                          'category',
                          'exclude_category',
                          'subcategory',
                          'start',
                          'include_items',
                          'exclude_items',
                          'filter_year',
                          'filter_month' 
                        );


foreach($params as $k => $v)
{
  if( startswith($k, 'search') )
  {
    \LISE\Session::Store($this, $k, $v);
    $pretty_pagination = FALSE;
  }
  
  if( in_array($k, $params2session) )
  {
    \LISE\Session::Store($this, $k, $v);
    $pretty_pagination = FALSE;
  }
}

#Start MLE
global $hls, $mleblock;
#End MLE

#---------------------
# Init objects
#---------------------
$item_query = $this->GetItemQuery($params);

Events::SendEvent($this->GetName(), 'PreRenderAction', array('action_name' => $name, 'query_object' => &$item_query));

#---------------------
# Check params
#---------------------
//which template to use

$summarytemplate = 'summary_' . $this->GetPreference($this->_GetModuleAlias() . '_default_summary_template');

if(isset($params['template_summary'])) 
{
	$summarytemplate = 'summary_' . $params['template_summary'];
}
elseif(isset($params['summarytemplate'])) 
{
	$summarytemplate = 'summary_' . $params['summarytemplate'];
}

$detail_override = isset($params['detailpage']);
// Detail page check
$detailpage = $this->GetPreference('detailpage', $returnid);

if($detail_override) 
{
	if(is_numeric($params['detailpage'])) 
  {
		$detailpage = $params['detailpage'];
	}
	else 
  {
		if(!isset($hm))
			$hm = cmsms()->GetHierarchyManager();
		
		$detailpage = $hm->sureGetNodeByAlias($params['detailpage'])->GetId();
	}
  
  $_SESSION[$this->GetName() . 'dp'] = array($detailpage => $returnid);
}

if( empty($detailpage) ) $detailpage = $returnid;

# Summary page check
$summarypage = $this->GetPreference('summarypage', $returnid);

if(isset($params['summarypage'])) 
{
  if(is_numeric($params['summarypage'])) 
  {
    $summarypage = $params['summarypage'];
  }
  else 
  {
    if(!isset($hm)) $hm = cmsms()->GetHierarchyManager();
      
    $summarypage_obj = $hm->sureGetNodeByAlias($params['summarypage']);
      
    if( is_object($summarypage_obj) ) $summarypage = $summarypage_obj->GetId();
  }
}

// Workaround for BR#11074, can be removed when fixed.
if( empty($summarypage) ) $summarypage = $returnid;

$debug = (isset($params['debug']) ? true : false);
$inline = $this->GetPreference('display_inline', 0);

#---------------------
# Init items
#---------------------
$totalcount = 0;
$item_query->AppendTo(LISEQuery::VARTYPE_WHERE, 'A.active = 1');
$result = $item_query->Execute(true);

$items = array();

while($result && $row = $result->FetchRow()) 
{
	if(!isset($this->_item_cache[$row['item_id']])) 
  {
		$cache = $this->InitiateItem();
		LISEItemOperations::Load($this, $cache, $row, $mleblock);	
		$this->_item_cache[] = $cache;
	}

	$obj = clone $this->_item_cache[$row['item_id']];
	
	$linkparams = array();
	$linkparams['item'] 			= $obj->alias;
	
	lise_utils::clean_params($params, array('returnid'));
	$linkparams = array_merge($linkparams, $params);
  
  # just a minor hack to allow $params['detailpage'] to override the item set url when it exists
  # if we set $pretty_url to '' the custom url will be ignored and one will be generated
  $pretty_url = $detail_override ? '' : $pretty_url =  $obj->url;
  
	$obj->url = $this->CreatePrettyLink($id, 'detail', $detailpage, '', $linkparams, '', true, $inline, '', false, $pretty_url);
  
  // lets deal with tags if they are available
  foreach($obj->fielddefs as $one)
  {
    $linkparams = array();
    if( 'Tags' !== $one->type) continue;
    $one->SetTagsParams($this, $id, 'default', $summarypage, $linkparams);
  }
  
	$items[$row['item_id']] = $obj;	
  $totalcount = $item_query->TotalCount();
}

#---------------------
# Smarty processing
#---------------------

$pagenumber = $item_query->GetPageNumber();
$pagecount = $item_query->GetPageCount();

$smarty->assign('totalcount', $totalcount);

// Assign some pagination variables to smarty
if($pagenumber == 1) 
{
	$smarty->assign('prevpage',$this->ModLang('prevpage'));
	$smarty->assign('firstpage',$this->ModLang('firstpage'));
} 
else 
{
	$params['pagenumber'] = $pagenumber-1;
  
  if($pretty_pagination)
  {
	  $smarty->assign('prevpage', $this->CreatePrettyLink($id, 'default', $summarypage, $this->ModLang('prevpage'),$params, '', false, $inline));
	  $smarty->assign('prevurl', $this->CreatePrettyLink($id, 'default', $summarypage,'', $params, '', true, $inline));
  }
  else
  {
    $smarty->assign('prevpage', $this->CreateLink($id, 'default', $summarypage, $this->ModLang('prevpage'),$params, '', false, $inline));
    $smarty->assign('prevurl', $this->CreateLink($id, 'default', $summarypage,'', $params, '', true, $inline));
  }  
	
  $params['pagenumber'] = 1;
  
  if($pretty_pagination)
  {
    $smarty->assign('firstpage', $this->CreatePrettyLink($id, 'default', $summarypage, $this->ModLang('firstpage'),$params, '', false, $inline));
    $smarty->assign('firsturl', $this->CreatePrettyLink($id, 'default', $summarypage,'', $params, '', true, $inline));
  }
  else
  {
	  $smarty->assign('firstpage', $this->CreateLink($id, 'default', $summarypage, $this->ModLang('firstpage'),$params, '', false, $inline));
	  $smarty->assign('firsturl', $this->CreateLink($id, 'default', $summarypage,'', $params, '', true, $inline));
  }
}

if($pagenumber >= $pagecount) 
{
	$smarty->assign('nextpage',$this->ModLang('nextpage'));
	$smarty->assign('lastpage',$this->ModLang('lastpage'));
}
else
{
	$params['pagenumber'] = $pagenumber+1;
  
  if($pretty_pagination)
  {  
    $smarty->assign('nextpage', $this->CreatePrettyLink($id, 'default', $summarypage, $this->ModLang('nextpage'), $params, '', false, $inline));
    $smarty->assign('nexturl', $this->CreatePrettyLink($id, 'default', $summarypage, '', $params, '', true, $inline));
  }
  else
  {  
	  $smarty->assign('nextpage', $this->CreateLink($id, 'default', $summarypage, $this->ModLang('nextpage'), $params, '', false, $inline));
	  $smarty->assign('nexturl', $this->CreateLink($id, 'default', $summarypage, '', $params, '', true, $inline));
  }
  
	$params['pagenumber'] = $pagecount;

  if($pretty_pagination)
  {   
    $smarty->assign('lastpage', $this->CreatePrettyLink($id, 'default', $summarypage, $this->ModLang('lastpage'), $params, '', false, $inline));
    $smarty->assign('lasturl', $this->CreatePrettyLink($id, 'default', $summarypage, '', $params, '', true, $inline)); 
  }
  else
  {
	  $smarty->assign('lastpage', $this->CreateLink($id, 'default', $summarypage, $this->ModLang('lastpage'), $params, '', false, $inline));
	  $smarty->assign('lasturl', $this->CreateLink($id, 'default', $summarypage, '', $params, '', true, $inline));
  }   
}

$smarty->assign('pagenumber', $pagenumber);
$smarty->assign('pagecount', $pagecount);

$pagelinks = array();

while($pagecount)
{
	$obj = new stdClass();
	$params['pagenumber'] = $pagecount;
  
  if($pretty_pagination)
  {   
    $obj->link = $this->CreatePrettyLink($id, 'default', $summarypage, $pagecount, $params, '', false, $inline);
    $obj->url = $this->CreatePrettyLink($id, 'default', $summarypage, '', $params, '', true, $inline);
  }
  else
  {   
	  $obj->link = $this->CreateLink($id, 'default', $summarypage, $pagecount, $params, '', false, $inline);
	  $obj->url = $this->CreateLink($id, 'default', $summarypage, '', $params, '', true, $inline);
  }
	
	$pagelinks[$pagecount] = $obj;
	$pagecount--;
}

$pagelinks = array_reverse($pagelinks, true);
#Start MLE
$smarty->assign('hls', $hls);
$smarty->assign('mleblock', $mleblock); //_en | _fr
#End MLE
$smarty->assign('pagelinks', $pagelinks);
$smarty->assign('items', $items);
$smarty->assign('LISE_action', 'default');
$smarty->assign($this->GetName() . '_items', $items); // <- Alias for $items

echo $this->ProcessTemplateFromDatabase($summarytemplate);

if($debug) 
	$smarty->display('string:<pre>{$items|@print_r}</pre>');
?>
