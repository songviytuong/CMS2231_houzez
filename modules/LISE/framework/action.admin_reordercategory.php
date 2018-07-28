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

#BEGIN_LICENSE
#-------------------------------------------------------------------------
#  A function for the LISE module to allow re-ordering the hierarchical category tree.
# (c) 2012 by Robert Campbell (calguy1000@cmsmadesimple.org)
# 
# This program is free software; you can redistribute it and/or modify
# it under the terms of the GNU General Public License as published by
# the Free Software Foundation; either version 2 of the License, or
# (at your option) any later version.
#
# This program is distributed in the hope that it will be useful,
# but WITHOUT ANY WARRANTY; without even the implied warranty of
# MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
# GNU General Public License for more details.
# You should have received a copy of the GNU General Public License
# along with this program; if not, write to the Free Software
# Foundation, Inc., 59 Temple Place, Suite 330, Boston, MA 02111-1307 USA
# Or read it online: http://www.gnu.org/licenses/licenses.html#GPL
#
#-------------------------------------------------------------------------
#END_LICENSE
if( !defined('CMS_VERSION') ) exit;

if (!$this->CheckPermission($this->_GetModuleAlias() . '_modify_category')) return;

//
// functions
//
function lise_get_category_tree($module_alias,$parent_id = -1)
{
  $db = cmsms()->GetDb();
  $thetable = cms_db_prefix().'module_'.$module_alias.'_category';

  $query = 'SELECT * FROM '.$thetable.' WHERE parent_id = ? ORDER BY hierarchy';
  $data= $db->GetArray($query,array($parent_id));

  if( is_array($data) && count($data) )
    {
      for( $i = 0; $i < count($data); $i++ )
	{
	  $tmp = lise_get_category_tree($module_alias,$data[$i]['category_id']);
	  if( is_array($tmp) && count($tmp) )
	    {
	      $data[$i]['children'] = $tmp;
	    }
	}

      return $data;
    }
}

function lise_create_category_flatlist($tree,$parent_id = -1)
{
  $data = array();
  $order = 1;
  foreach( $tree as &$node )
    {
      if( is_array($node) && count($node) == 2 )
	{
	  $pid = (int)substr($node[0],strlen('cat_'));
	  $data[] = array('id'=>$pid,'parent_id'=>$parent_id,'order'=>$order);
	  if( isset($node[1]) && is_array($node[1]) )
	    {
	      $data = array_merge($data,lise_create_category_flatlist($node[1],$pid));
	    }
	}
      else
	{
	  $pid = (int)substr($node,strlen('cat_'));
	  $data[] = array('id'=>$pid,'parent_id'=>$parent_id,'order'=>$order);
	}
      $order++;
    }
  return $data;
}

//
// Get the data
//
$tree = lise_get_category_tree($this->_GetModuleAlias());

//print_r($tree);

//
// Handle form submission
//
if( isset($params['cancel']) )
  {
    $this->Redirect($id, 'defaultadmin', $returnid, array('active_tab' => 'categorytab'));
  }
else if( isset($params['submit']) ) 
  {

    $orderdata = json_decode($params['orderdata']);
	
    $flatlist = lise_create_category_flatlist($orderdata);
    $thetable = cms_db_prefix().'module_'.$this->_GetModuleAlias().'_category';

    // get the full category list.
    $categories = array();
    {
      $query = 'SELECT * FROM '.$thetable.' ORDER BY hierarchy';
      $tmp = $db->GetArray($query);
      for( $i = 0; $i < count($tmp); $i++ )
	{
	  $rec = $tmp[$i];
	  $categories[$rec['category_id']] = $tmp;
	}
    }
    
    // and update the database with our new order info.
    $query = 'UPDATE '.$thetable.' SET parent_id = ?, position = ?, hierarchy = ? WHERE category_id = ?';
    foreach( $flatlist as $rec )
      {
	$dbr = $db->Execute($query,array($rec['parent_id'],$rec['order'],'',$rec['id']));
      }
    LISECategoryOperations::UpdateHierarchyPositions($this);
    
    $this->Redirect($id, 'defaultadmin', $returnid, array('active_tab' => 'categorytab', 'message' => 'changessaved'));
  }

//
// give data to smarty
//
$smarty->assign('formstart',$this->CreateFormStart($id,'admin_reordercategory'));
$smarty->assign('formend',$this->CreateFormEnd());

$smarty->assign('tree',$tree);

$smarty->assign('submit', $this->CreateInputSubmit($id, 'submit', lang('submit')));
$smarty->assign('cancel', $this->CreateInputSubmit($id, 'cancel', lang('cancel')));

echo $this->ModProcessTemplate('admin_reordercategory.tpl');

?>