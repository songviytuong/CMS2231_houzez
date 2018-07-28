<?php  /* -*- Mode: PHP; c-set-style: linux; tab-width: 4; c-basic-offset: 4 -*- */
#BEGIN_LICENSE
#-------------------------------------------------------------------------
# Module: Products (c) 2008-2014 by Robert Campbell
#         (calguy1000@cmsmadesimple.org)
#  An addon module for CMS Made Simple to allow users to create, manage
#  and display products in a variety of ways.
#
#-------------------------------------------------------------------------
# CMS - CMS Made Simple is (c) 2005 by Ted Kulp (wishy@cmsmadesimple.org)
# Visit the CMSMS Homepage at: http://www.cmsmadesimple.org
#
#-------------------------------------------------------------------------
#
# This program is free software; you can redistribute it and/or modify
# it under the terms of the GNU General Public License as published by
# the Free Software Foundation; either version 2 of the License, or
# (at your option) any later version.
#
# However, as a special exception to the GPL, this software is distributed
# as an addon module to CMS Made Simple.  You may not use this software
# in any Non GPL version of CMS Made simple, or in any version of CMS
# Made simple that does not indicate clearly and obviously in its admin
# section that the site was built with CMS Made simple.
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

if( !isset($gCms) ) exit;
if( !$this->CheckPermission('Modify Products') ) exit;

//
// initialize
//
function orderhier_create_flatlist($tree,$parent_id = -1)
{
  $data = array();
  $order = 1;
  foreach( $tree as &$node )
    {
      if( is_array($node) && count($node) == 2 )
	{
	  $pid = (int)substr($node[0],strlen('hier_'));
	  $data[] = array('id'=>$pid,'parent_id'=>$parent_id,'order'=>$order);
	  if( isset($node[1]) && is_array($node[1]) )
	    {
	      $data = array_merge($data,orderhier_create_flatlist($node[1],$pid));
	    }
	}
      else
	{
	  $pid = (int)substr($node,strlen('hier_'));
	  $data[] = array('id'=>$pid,'parent_id'=>$parent_id,'order'=>$order);
	}
      $order++;
    }
  return $data;
}

//
// setup the data
//
$this->SetCurrentTab('hierarchy');
$tree = product_utils::hierarchy_get_tree();

//
// handle form submission_
//
if( isset($params['cancel']) )
  {
    $this->SetMessage($this->Lang('operation_cancelled'));
    $this->RedirectToTab($id);
    return;
  }
else if( isset($params['submit']) )
  {
    $params['orderdata'] = json_decode($params['orderdata']);

    // 1. Massage the order data from the form.
    $data = orderhier_create_flatlist($params['orderdata']);

    // 2. Update the data array with info from the tree.
    $query = 'SELECT * FROM '.cms_db_prefix().'module_products_hierarchy ORDER by hierarchy';
    $dbr = $db->GetArray($query);
    $dbr = cge_array::to_hash($dbr,'id');

    // 3. Update the database
    $query = 'UPDATE '.cms_db_prefix().'module_products_hierarchy SET parent_id = ?, item_order = ?, hierarchy = ?, long_name = ? WHERE id = ?';
    foreach( $data as $rec )
      {
	$dbr = $db->Execute($query,array($rec['parent_id'],$rec['order'],'','',$rec['id']));
      }
    product_utils::update_hierarchy_positions();

    // and get out of here.
    $this->SetMessage($this->Lang('operation_complete'));
    $this->RedirectToTab($id);
    return;
  }

//
// give it to smarty
//
$smarty->assign('formstart',$this->CGCreateFormStart($id,'admin_reorder_hierarchy'));
$smarty->assign('formend',$this->CreateFormEnd());
$smarty->assign('tree',$tree);
$smarty->assign('depth',0);

// display the form.
echo $this->ProcessTemplate('admin_reorder_hierarchy.tpl');

#
# EOF
#
?>