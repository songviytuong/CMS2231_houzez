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
if (!isset($gCms)) exit;
if (!$this->CheckPermission('Modify Products')) exit;
$this->SetCurrentTab('categories');

if (isset($params['cancel']))  $this->RedirectToTab($id);

$table_name = cms_db_prefix().'module_products_categories';
$catid = \cge_param::get_int($params,'catid');
$category = [ 'id'=>$catid,'name'=>null ];
if( $catid > 0 ) {
	$query = "SELECT * FROM $table_name WHERE id = ?";
	$category = $db->GetRow($query, array($catid));
}

if( \cge_param::exists($params,'submit') ) {
    try {
        $name = \cge_param::get_string($params,'name');
        if( $name ) {
            if( $catid > 0 ) {
                $sql = "SELECT id FROM $table_name WHERE name = ? AND id != ?";
                $tmp = $db->GetOne($sql,[ $name, $catid ] );
                if( $tmp > 0 ) throw new \LogicException($this->Lang('categoryexists'));

                $sql = 'UPDATE '.cms_db_prefix().'module_products_categories SET name = ?, modified_date = NOW() WHERE id = ?';
                $db->Execute($sql, [ $name, $catid ] );
            }
            else {
                $sql = "SELECT id FROM $table_name WHERE name = ?";
                $tmp = $db->GetOne($sql,[ $name ] );
                if( $tmp > 0 ) throw new \LogicException($this->Lang('categoryexists'));

                $query = 'INSERT INTO '.cms_db_prefix().'module_products_categories (name, create_date, modified_date) VALUES (?,NOW(),NOW())';
                $db->Execute($query, [ $name ] );
            }
            $this->RedirectToTab($id);
        }
    }
    catch( \Exception $e ) {
		echo $this->ShowErrors($e->GetMessage());
	}
}

$smarty->assign('category',$category);
echo $this->CGProcessTemplate('editcategory.tpl');
