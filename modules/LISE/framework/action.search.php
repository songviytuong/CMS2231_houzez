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
$template = 'search_' . $this->GetPreference($this->_GetModuleAlias() . '_default_search_template');

if(isset($params['template_search']))
{
  $template = 'search_' . $params['template_search'];
}
elseif(isset($params['searchtemplate']))
{
  $template = 'search_' . $params['searchtemplate'];
}

if(isset($params['template_summary'])) 
{
  $summarytemplate_bypass = $params['template_summary'];
}
elseif(isset($params['summarytemplate'])) 
{
  $summarytemplate_bypass = $params['summarytemplate'];
}

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

$debug = (isset($params['debug']) ? true : false);

#---------------------
# Grab template
#---------------------
$template = $this->GetTemplate($template);

#---------------------
# Init fielddefs
#---------------------
#Load fielddefs only if we have variable request on template
if(stripos($template, '$fielddefs')) 
{  
  $filters = array();
  if(!empty($params['filter']))
  {
    $filters = explode(',', $params['filter']);
  }
  
  $filters_order_by = array();
  if(!empty($params['filterorderby'])) 
  {
    $filters_order_by = explode(',', $params['filterorderby']);
  }

  $fielddefs = $this->GetFieldDefs($filters);
  $i = 0;
  
  foreach($fielddefs as $fielddef)
  {
    $orderby = isset($filters_order_by[$i]) ? $filters_order_by[$i++] : '';
    LISEFielddefOperations::LoadValuesForFieldDef($this, $fielddef, $orderby);
  }

  $smarty->assign('fielddefs', $fielddefs);
  $smarty->assign('filterprompt', $this->ModLang('filterprompt', $this->GetPreference('item_plural', '')));
}

#---------------------
# Smarty processing
#---------------------

$smarty->assign('formstart', $this->CreateFormStart($id, 'default', $summarypage, 'post', 'multipart/form-data', false, '', $params));
$smarty->assign('formend', $this->CreateFormEnd());
$smarty->assign('modulealias', $this->_GetModuleAlias()); // Deprecated

echo $this->ProcessTemplateFromData($template);

if($debug) 
  $smarty->display('string:<pre>{$fielddefs|@print_r}</pre>');

?>
