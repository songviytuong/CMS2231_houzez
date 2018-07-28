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
if( !$this->CheckPermission('Modify Products') ) exit;
$this->SetCurrentTab('products');

try {
    // note, this does not trigger a hook.
    if( isset($params['cancel']) ) {
        $this->SetMessage($this->Lang('operation_cancelled'));
        $this->RedirectToTab();
    }

    $ms_rawdata = \cge_param::get_string($params,'cd_multiselect');
    if( !$ms_rawdata ) throw new \LogicException('Missing Parameter data for admin_bulk_editquantity action');
    $ms_data = unserialize(base64_decode($ms_rawdata));
    if( !isset($ms_data['multiselect']) || !is_array($ms_data['multiselect']) || !count($ms_data['multiselect']) ) {
        throw new \LogicException('No Data');
    }

    $stock_field = product_utils::get_quantity_field();
    if( !$stock_field ) throw new \LogicException('Could not find the name of the quantity field');

    $query = new products_query(array('productlist'=>$ms_data['multiselect']));
    $rs = $query->execute();
    if( $rs->totalrows == 0 ) throw new \LogicException('Could not retrieve the products selected');
    $list = array();
    while( !$rs->EOF() ) {
        $product = $rs->get_product();

        if( isset($product->attributes) && count($product->attributes) ) {
            foreach( $product->attributes as $attrib ) {
                $obj = new StdClass;
                $obj->product_id = $product->id;
                $obj->product_name = $product->product_name;
                $obj->attribute = $attrib['text'];
                $obj->sku = $attrib['sku'];
                $obj->stock = $attrib['qoh'];
                $list_a[$obj->sku] = $obj;
            }
        }
        else {
            $obj = new StdClass;
            $obj->product = $product;
            $obj->product_id = $product->id;
            $obj->product_name = $product->product_name;
            $obj->attribute = null;
            $obj->sku = $product->sku;
            if( isset($product->fields) && isset($product->fields[$stock_field->name]) ) {
                $obj->stock = (int) $product->fields[$stock_field->name]->value;
            }
            else {
                $obj->stock = 0;
            }
            $list_a[$obj->sku] = $obj;
        }

        $rs->MoveNext();
    }

    if( isset($params['submit']) ) {
        try {
            // update the list_a objects
            foreach( $params['cd_qoh'] as $sku => $qoh ) {
                $sku = trim($sku);
                $qoh = (int) $qoh;

                if( !isset($list_a[$sku]) ) continue; // ignore anything not explicitly known
                $obj = $list_a[$sku];
                if( $obj->attribute ) {
                    // it's an attribute sku
                    $sql = 'UPDATE '.cms_db_prefix().'module_products_attribs SET qoh = ? WHERE sku = ? AND product_id = ?';
                    $db->Execute($sql,array($qoh,$sku,(int)$obj->product_id));
                }
                else {
                    // it's a product sku
                    $sql = 'UPDATE '.cms_db_prefix().'module_products_fieldvals SET value = ? WHERE product_id = ? AND fielddef_id = ?';
                    $db->Execute($sql,array($qoh,(int)$obj->product_id,(int)$stock_field->id));
                }
            }

            $this->SetMessage($this->Lang('operation_complete'));
            $this->RedirectToTab();
        }
        catch( \Exception $e ) {
            echo $this->ShowErrors($e->GetMessage());
        }
    }

    $tpl = $this->CreateSmartyTemplate('admin_bulk_editquantity.tpl');
    $tpl->assign('formstart',$this->CGCreateFormStart($id,'admin_bulk_editquantity',$returnid,array('cd_multiselect'=>$ms_rawdata)));
    $tpl->assign('formend',$this->CreateFormEnd());
    $tpl->assign('editable',$list_a);
    $tpl->display();
}
catch( \Exception $e ) {
    $this->SetError($e->GetMessage());
    $this->RedirectToTab();
}