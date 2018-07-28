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

function products_SearchReindex(&$mod,$module)
{
    $page = 1;
    $done = FALSE;
    while( !$done ) {
        $parms = array('status'=>'published','limit'=>250,'page'=>$page);
        $query = new products_query($parms);
        $rs = $query->execute();
        while( !$rs->EOF() ) {
            $tmp = $rs->get_product(TRUE);
            if( $tmp->get_extra('searchable',1) ) {
                $words = $mod->GetSearchableText($tmp);
                if( is_array($words) && count($words) ) $module->AddWords($mod->GetName(),$tmp['id'],'product',implode(' ',$words));
            }
            $rs->MoveNext();
        }
        if( $page == $rs->numpages ) {
            $done = TRUE;
            break;
        }
        $page++;
    }
}

function products_BuildHierarchyList(&$mod)
{
    $db = cmsms()->GetDb();

    $hierarchy_items = array();
    $hierarchy_items[$mod->Lang('none')] = -1;
    $query = 'SELECT hierarchy, long_name FROM '.cms_db_prefix().'module_products_hierarchy WHERE id = -1';
    $dbr = $db->Execute( $query );
    $longname = '';
    while( $dbr && ($row = $dbr->FetchRow()) ) {
        $longname = $row['hierarchy'] . '%';
    }
    $query = 'SELECT id, long_name FROM '.cms_db_prefix().'module_products_hierarchy
           WHERE hierarchy NOT LIKE ?
           ORDER BY hierarchy';
    $dbr = $db->Execute($query,array($longname));
    while( $dbr && ($row = $dbr->FetchRow()) )  {
        $hierarchy_items[$row['long_name']] = $row['id'];
    }

    return $hierarchy_items;
}


function products_GetTypesDropdown( &$mod, $id, $name, $selected = '', $addtext = '', $selectone = false )
{
    $items = product_utils::get_field_types($selectone);

    // CreateInputDropdown wants the labels first for some reason.
    $items = array_flip($items);

    return $mod->CreateInputDropdown($id, $name, $items, -1, $selected,$addtext);
}

#
# EOF
#
