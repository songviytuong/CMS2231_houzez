<?php
#BEGIN_LICENSE
#-------------------------------------------------------------------------
# Module: Products (c) 2008-2017 by Robert Campbell
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
$this->SetCurrentTab('hierarchy');

if( isset($params['cancel']) ) {
    // we're cancelling
    $this->RedirectToTab($id);
}

//
// Defaults
//
$destdir = product_utils::get_hierarchy_upload_path();
$hier_rec = ['id'=>null, 'parent_id'=>-1, 'name'=>null, 'image'=>null, 'description'=>null, 'extra1'=>null, 'extra2'=>null, 'item_order'=>null ];
$hier_id = \cge_param::get_int($params,'hierarchy_id');
if( $hier_id > 0 ) {
    $sql = 'SELECT * FROM '.cms_db_prefix().'module_products_hierarchy WHERE id = ?';
    $hier_rec = $db->GetRow( $sql, [ $hier_id ] );
}


if( \cge_param::exists($params,'submit') ) {
    try {
        $old_rec = $hier_rec;
        $hier_rec['parent_id'] = \cge_param::get_int($params,'parent_id',$hier_rec['parent_id']);
        $hier_rec['name'] = \cge_param::get_string($params,'name',$hier_rec['name']);
        $hier_rec['description'] = \cge_utils::get_param($params,'description',$hier_rec['description']);
        $hier_rec['extra1'] = \cge_param::get_string($params,'extra1',$hier_rec['extra1']);
        $hier_rec['extra2'] = \cge_param::get_string($params,'extra2',$hier_rec['extra2']);

        if( !$hier_rec['name'] ) throw new \InvalidArgumentException($this->Lang('err_noname'));

        if( $hier_rec['id'] && $hier_rec['parent_id'] != $old_rec['parent_id'] ) {
            // parent change on update.
            $query = 'SELECT id FROM '.cms_db_prefix().'module_products_hierarchy WHERE parent_id = ? AND name = ?';
            $tmp = $db->GetOne($query, [ $hier_rec['parent_id'], $hier_rec['name'] ] );
            if( $tmp ) throw new \InvalidArgumentException($this->Lang('error_nameused'));
        }

        if( $hier_rec['id'] > 0 ) {
            // it's an update

            // handle deleting images
            if( \cge_param::exists($params,'deleteimg') && $hier_rec['image'] ) {
                @unlink($destdir.'/'.$hier_rec['image']);
                $hier_rec['image'] = null;
            }

            if( $old_rec['parent_id'] != $hier_rec['parent_id'] && $hier_rec['item_order'] > -1 ) {
                // changed to a different parent.
                if( $hier_rec['parent_id'] > 0 && product_utils::hierarchy_isparentof( $hier_rec['parent_id'], $hier_rec['id'] ) ) {
                    throw new \RuntimeException($this->Lang('error_invalidparent'));
                }

                // decrement all of the previous siblings with the larger item_order
                $query = 'UPDATE '.cms_db_prefix().'module_products_hieriarchy SET item_order = item_order - 1
                          WHERE parent_id = ? AND item_order > ?';
                $db->Execute( $query, [ $old_rec['parent_id'],$hier_rec['item_order'] ] );

                // find a new item order in the new parent.
                $query = 'SELECT COALESCE(MAX(item_order),0)+1 FROM '.cms_db_prefix().'module_products_hierarchy
                          WHERE parent_id = ?';
                $hier_rec['item_order']  = (int) $db->GetOne( $query,[ $hier_rec['parent_id'] ] );
            }

            $query = 'UPDATE '.cms_db_prefix().'module_products_hierarchy
                      SET name = ?, image = ?, item_order = ?, parent_id = ?, description = ?,
                          extra1 = ?, extra2 = ? WHERE id = ?';
            $db->Execute( $query,
                         [ $hier_rec['name'], $hier_rec['image'], $hier_rec['item_order'], $hier_rec['parent_id'],
                           $hier_rec['description'], $hier_rec['extra1'], $hier_rec['extra2'], $hier_rec['id'] ] );
        }
        else {
            // it's an insert
            $query = 'SELECT MAX(item_order)+1 FROM '.cms_db_prefix().'module_products_hierarchy WHERE parent_id = ?';
            $item_order = (int) $db->GetOne($query,array($parent));
            if( !$item_order ) $item_order = 1;

            $query = 'INSERT INTO '.cms_db_prefix().'module_products_hierarchy
               (name, parent_id, description, image, extra1, extra2, item_order) VALUES(?,?,?,?,?,?,?)';
            $dbr = $db->Execute($query, [ $hier_rec['name'], $hier_rec['parent_id'], $hier_rec['description'],
                                          $hier_rec['image'], $hier_rec['extra1'], $hier_rec['extra2'], $item_order ] );
            if( !$dbr ) {
                throw new \RuntimeException($db->ErrorMsg());
            }
            $hier_rec['id'] = (int) $db->Insert_ID();
        }

        $handler = new \cg_fileupload($id,$destdir);
        $handler->set_allow_overwrite();
        $handler->set_accepted_filetypes( $this->GetPreference('allowed_imagetypes') );
        $have_upload = $handler->check_upload_attempted('image');
        if( $have_upload ) {
            \cge_dir::mkdirr( $destdir );
            if( !is_dir($destdir) ) throw new \RuntimeException( $this->Lang('err_mkdir', $destdir) );
            $destname = 'h'.$hier_rec['id'].'.img';  // extension will be replaced.
            $res = $handler->handle_upload('image',$destname);
            $err = $handler->get_error();
            if( !$res ) throw new \RuntimeException( $this->GetUploadErrormessage( $err ) );
            if( $res ) {
                $hier_rec['image'] = $res;
                $sql = 'UPDATE '.cms_db_prefix().'module_products_hierarchy SET image = ? WHERE id = ?';
                $db->Execute( $sql, [ $hier_rec['image'], $hier_rec['id'] ] );
            }
        }

        $this->UpdateHierarchyPositions();
        $this->RedirectToTab();
    }
    catch( \Exception $e ) {
        echo $this->ShowErrors($e->GetMessage());
    }
}

#
# Build the form
#
$hierarchy_items = $this->BuildHierarchyList();
$image_url = null;
if( $hier_rec['image'] ) {
    $image_url = product_utils::get_hierarchy_upload_url().'/'.$hier_rec['image'];
}
$smarty->assign('image_url',$image_url);
$smarty->assign('hierarchy_items',array_flip($hierarchy_items));
$smarty->assign('hier_rec', $hier_rec);
echo $this->CGProcessTemplate('admin_edit_hierarchy_item.tpl');
#
# EOF
#
