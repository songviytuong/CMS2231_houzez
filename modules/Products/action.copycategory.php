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
$this->SetCurrentTab('categories');

if (!$this->CheckPermission('Modify Products'))
{
	echo $this->ShowErrors($this->Lang('needpermission', array('Modify Products')));
	return;
}
if (!isset($params['catid']))
{
  echo $this->ShowErrors($this->Lang('error_missingparam'));
  return;
}

# Initialization
$name = '';
$catid = (int)$params['catid'];

if (isset($params['cancel']))
{
  $this->RedirectToTab($id);
}

$query = 'SELECT * FROM '.cms_db_prefix().'module_products_categories
           WHERE id = ?';
$row = $db->GetRow($query,array($catid));

if( isset($params['submit']) )
{
  // make sure the name is not empty
  if( isset($params['name']) )
    {
      $name = trim($params['name']);
    }
  if( empty($name) )
    {
      echo $this->ShowErrors($this->Lang('error_noname'));
    }
  else
    {
      $query = 'SELECT id FROM '.cms_db_prefix().'module_products_categories
                  WHERE name = ?';
      $tmp = $db->GetOne($query,array($name));
      if( $tmp )
	{
	  echo $this->ShowErrors($this->Lang('error_nameused'));
	}
      else
	{
	  // it's good to go.
	  $now = $db->DbTimeStamp(time());
	  $query = 'INSERT INTO '.cms_db_prefix()."module_products_categories
                 (name, create_date, modified_date)
                VALUES (?,$now,$now)";
	  $db->Execute($query,array($name));
	  $new_id = $db->Insert_ID();

	  $query = 'SELECT * FROM '.cms_db_prefix().'module_products_category_fields
                 WHERE category_id = ? ORDER BY field_order';
	  $res = $db->GetArray($query,array($catid));

	  $query = 'INSERT INTO '.cms_db_prefix().'module_products_category_fields
                  (category_id, field_type, field_name, field_prompt, field_value, field_order)
                VALUES (?,?,?,?,?,?)';
	  $idx = 1;
	  foreach( $res as $one )
	    {
	      $db->Execute($query,
			   array($new_id,$one['field_type'],$one['field_name'],
				 $one['field_prompt'],$one['field_value'],$idx++));
	    }

	  $this->RedirectToTab($id);
	}
    }
}

if( $row )
{
  $smarty->assign('category',$row);
}

# Display Template
$smarty->assign('startform',
		$this->CreateFormStart($id,'copycategory',$returnid));
$smarty->assign('endform', $this->CreateFormEnd());
$smarty->assign('inputname',$this->CreateInputText($id,'name',$name,80,255));
$smarty->assign('hidden',$this->CreateInputHidden($id,'catid',$catid));
$smarty->assign('submit',
		$this->CreateInputSubmit($id, 'submit', lang('submit')));
$smarty->assign('cancel',
		$this->CreateInputSubmit($id, 'cancel', lang('cancel')));

echo $this->ProcessTemplate('copycategory.tpl');

#
# EOF
#
?>