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
if( !isset($params['order_id']) ) return;

// handle the case of attempted recursion.
if( cge_tmpdata::exists(__FILE__) ) return;
cge_tmpdata::set(__FILE__,1);

// get the field definitions.
$defs = product_utils::get_fielddefs(TRUE,TRUE);

// check field defs for an entry of type 'quantity'
if( !is_array($defs) || count($defs) == 0 ) return;
$qoh_field_id = -1;
foreach( $defs as $id => $def ) {
    if( $def->type == 'quantity' ) $qoh_field_id = (int)$def->id;
}
if( $qoh_field_id < 1 ) return;

// get the order.
$order_id = (int)$params['order_id'];
$order_obj = orders_ops::load_by_id($order_id);
if( !$order_obj ) return;
if( !in_array($order_obj->get_status(),array('invoiced','paid')) ) return;

// find the line with with a product in it.
for( $s = 0; $s < $order_obj->count_destinations(); $s++ ) {
    $shipping = $order_obj->get_shipping($s);
    for( $i = 0; $i < $shipping->count_all_items(); $i++ ) {
        $item = $shipping->get_item($i);
        if( $item->get_source() != 'Products' ) continue;
        if( $item->get_item_type() != line_item::ITEMTYPE_PRODUCT ) continue;

        // get the product id... and update the quantity available.
        $sku = $item->get_sku();
        $product_id = $item->get_item_id();
        $product = $this->GetProductStorage()->get_by_any_sku($sku);
        if( ! $product || $product->id != $product_id ) {
            audit('',$this->GetName(),'in OrderUpdated product id does not match order item when fetched by sku');
            return;
        }

        $cur_val = '--undefined--';
        if( $product->sku == $sku ) {
            // the sku is for the product itself...
            $cur_val = 0;
            $found = 0;
            $query = 'SELECT * FROM '.cms_db_prefix().'module_products_fieldvals WHERE product_id = ? AND fielddef_id = ?';
            $dbr = $db->GetRow($query,array($product_id,$qoh_field_id));
            if( $dbr ) {
                $cur_val = (int)$dbr['value'];
                $found = 1;
            }
            $cur_val -= (int)$item->get_quantity();
            if( !$found ) {
                $query = 'INSERT INTO '.cms_db_prefix().'module_products_fieldvals (product_id,fielddef_id,value,create_date,modified_date) VALUES (?,?,?,NOW(),NOW())';
                $dbr = $db->Execute($query,array($product_id,$qoh_field_id,$cur_val));
            }
            else {
                $query = 'UPDATE '.cms_db_prefix().'module_products_fieldvals SET value = ?, modified_date = NOW() WHERE product_id = ? AND fielddef_id = ?';
                $dbr = $db->Execute($query,array($cur_val,$product_id,$qoh_field_id));
            }
            audit($product_id,$this->GetName(),'Updated quantity of available product to '.$cur_val);
        }
        else if( count($product->attribs) ) {
            // it may be an option?
            foreach( $product->attribs as $one ) {
                if( $one->sku == $sku && $one->id > 0 ) {
                    // found the option
                    $cur_val = (int) $one->qoh - (int) $item->get_quantity();
                    $sql = 'UPDATE '.cms_db_prefix().'module_products_attribs SET qoh = ? WHERE id = ?';
                    $dbr = $db->Execute( $sql,[ $cur_val,(int) $one->id ] );
                    break;
                }
            }
        }
    }
}

// setup for another order... shouldn't happen, but just in case.
cge_tmpdata::erase(__FILE__);

#
# EOF
#
