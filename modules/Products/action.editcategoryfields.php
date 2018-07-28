<?php
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
if (!$this->CheckPermission('Modify Products') ) exit;
$this->SetCurrentTab('categories');

$catid = \cge_param::get_int($params,'catid');
if( !$catid ) {
    echo $this->ShowErrors($this->Lang('error_missingparam'));
    return;
}

// Get the info for this category
$query = 'SELECT * FROM '.cms_db_prefix().'module_products_categories WHERE id = ?';
$category = $db->GetRow($query,array($catid));
$smarty->assign('category',$category);
$theme = cms_utils::get_theme_object();

// get the list of fields for this product
$query = 'SELECT * FROM '.cms_db_prefix().'module_products_category_fields WHERE category_id = ? ORDER BY field_order ASC';
$fields = $db->GetArray($query, [ $catid ]);
$theme = cms_utils::get_theme_object();
for( $i = 0; $i < count($fields); $i++ )  {
    if( $fields[$i]['field_order'] > 1 ){
        $fields[$i]['move_up'] = $this->CreateImageLink($id,'movecategoryfield',$returnid,$this->Lang('move_up'),
                                                        'icons/system/sort_up.gif',
                                                        array('catid'=>$catid,'dir'=>'up','fldname'=>$fields[$i]['field_name']));
    }
    if( $i < count($fields) - 1 ) {
        $fields[$i]['move_down'] = $this->CreateImageLink($id,'movecategoryfield',$returnid,$this->Lang('move_down'),
                                                          'icons/system/sort_down.gif',
                                                          array('catid'=>$catid,'dir'=>'down','fldname'=>$fields[$i]['field_name']));
    }
}
$smarty->assign('fields',$fields);
$smarty->assign('catid',$catid);

# Display Template
echo $this->CGProcessTemplate('editcategoryfields.tpl');

#
# EOF
#
