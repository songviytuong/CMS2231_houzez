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
$this->SetCurrentTab('hierarchy');
if( !isset($params['hierarchy_id']) ) {
    $this->SetError($this->Lang('error_missingparam'));
    $this->RedirectToTab($id);
}
$hierarchy_id = (int)$params['hierarchy_id'];

// Get this hierarchy item'
$query = 'SELECT * FROM '.cms_db_prefix().'module_products_hierarchy WHERE id = ?';
$data = $db->GetRow($query,array($hierarchy_id));
if( $data['image'] ) {
    $destdir = product_utils::get_hierarchy_upload_path();
    $fn = cms_join_path($destdir,$data['image']);
    if( @file_exists($fn) )	@unlink($fn);
    $fn = cms_join_path($destdir,'thumb_'.$data['image']);
    if( @file_exists($fn) )	@unlink($fn);
    $fn = cms_join_path($destdir,'preview_'.$data['image']);
    if( @file_exists($fn) )	@unlink($fn);
}

// reset all peer hierarchies item order
$query = 'UPDATE '.cms_db_prefix().'module_products_hierarchy SET item_order = item_order - 1
          WHERE parent_id = ? AND item_order > ?';
$dbr = $db->Execute($query,array($data['parent_id'],$data['item_order']));

// Reset all hierarchies using this parent to have no parent (-1)
$query = 'UPDATE '.cms_db_prefix().'module_products_hierarchy SET parent_id = -1 WHERE parent_id = ?';
$dbr = $db->Execute( $query, array( $hierarchy_id ) );

// Now remove it
$query = 'DELETE FROM '.cms_db_prefix().'module_products_hierarchy WHERE id = ?';
$db->Execute( $query, array( $hierarchy_id ) );

// And now update any products to have no category
// if they have this hierarchy_id
$query = 'DELETE FROM '.cms_db_prefix().'module_products_prodtohier WHERE hierarchy_id = ?';
$db->Execute( $query, array( $hierarchy_id ) );

$this->UpdateHierarchyPositions();

// done
$this->RedirectToTab($id);

#
# EOF
#
?>