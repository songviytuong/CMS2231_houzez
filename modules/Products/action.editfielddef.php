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
$this->SetCurrentTab('fielddefs');

if( \cge_param::exists($params,'cancel') ) $this->RedirectToTab($id);

$fdid = \cge_param::get_int($params,'fdid');
$row = ['id'=>null, 'name'=>null,'prompt'=>null,'type'=>null,'max_length'=>null,'name'=>null,'public'=>1,'options'=>null];
if( $fdid > 0 ) {
    $query = 'SELECT * FROM '.cms_db_prefix().'module_products_fielddefs WHERE id = ?';
    $tmp = $db->GetRow($query, [ $fdid ] );
    if( is_array($tmp) && count($tmp) ) $row = $tmp;
}

if (isset($params['submit'])) {
    try {
        $old_row = $row;
        $row['name'] = \cge_param::get_string($params,'name');
        $row['prompt'] = \cge_param::get_string($params,'prompt');
        $row['options'] = \cge_param::get_string($params,'options');
        $row['type'] = \cge_param::get_string($params,'type');
        $row['public'] = \cge_param::get_bool($params,'public');
        $row['max_length'] = \cge_param::get_int($params,'max_length');

        if( !$row['type'] ) throw new \RuntimeException($this->Lang('error_nofieldtype'));
        if( !$row['name'] ) throw new \RuntimeException($this->Lang('nonamegiven'));
        if( !$this->is_alias($row['name']) ) throw new \RuntimeException($this->Lang('error_invalid_name'));
        if( $row['type'] == 'subscription' && !$fdid && $db->GetOne('SELECT id FROM '.cms_db_prefix().'module_products_fielddefs WHERE type = ?', [ $row['type'] ]) ) {
            throw new \RuntimeException('error_onesubscriptionfield');
        }
        if( $row['type'] == 'quantity' && !$fdid &&  $db->GetOne('SELECT id FROM '.cms_db_prefix().'module_products_fielddefs WHERE type = ?', [ $row['type'] ]) ) {
            throw new \RuntimeException('error_onequantityfield');
        }
        if( $row['id'] < 1 ) {
            // make sure that the fielddef name does not exist.
            $sql = 'SELECT id FROM '.cms_db_prefix().'module_products_fielddefs WHERE name = ?';
            $tmp = (int) $db->GetOne($sql, [ $row['name'] ] );
            if( $tmp ) throw new \RuntimeException($this->Lang('err_fielddef_exists'));

            // its an insert
            $max = $db->GetOne('SELECT max(item_order) + 1 FROM ' . cms_db_prefix() . 'module_products_fielddefs');
            if( !$max ) $max = 0;

            $sql = 'INSERT INTO '.cms_db_prefix().'module_products_fielddefs (name, prompt, type, max_length, item_order, options, create_date, modified_date)
                    VALUES (?,?,?,?,?,?,NOW(),NOW())';
            $dbr = $db->Execute( $sql, [ $row['name'], $row['prompt'], $row['type'], $row['max_length'], $max, $row['options'] ] );
            if( !$dbr ) throw new \LogicException('SQL ERROR: '.$e->GetMessage());
        }
        else {
            // make sure that the fielddef name does not exist.
            $sql = 'SELECT id FROM '.cms_db_prefix().'module_products_fielddefs WHERE name = ? AND id != ?';
            $tmp = (int) $db->GetOne($sql, [ $row['name'], $row['id'] ] );
            if( $tmp ) throw new \RuntimeException($this->Lang('err_fielddef_exists'));

            // its an update
            if( $row['type'] != $old_row['type'] && ($old_row['type'] == 'image' || $old_row['type'] == 'file') ) {
                // used to be a file or image field.
            }

            $sql = 'UPDATE '.cms_db_prefix().'module_products_fielddefs SET name = ?, prompt = ?, type = ?, max_length = ?, modified_date = NOW(),
                      public = ?, options = ? WHERE id = ?';
            $dbr = $db->Execute( $sql, [ $row['name'], $row['prompt'], $row['type'], $row['max_length'], $row['public'], $row['options'], $fdid ] );
            if( !$dbr ) throw new \LogicException('SQL ERROR: '.$e->GetMessage());
        }
        $this->RedirectToTab($id);
    }
    catch( \Exception $e ) {
        echo $this->ShowErrors($e->GetMessage());
    }
}


#Display template
$types = product_utils::get_field_types();
$smarty->assign('field',$row);
$smarty->assign('types',$types);
echo $this->ProcessTemplate('editfielddef.tpl');
