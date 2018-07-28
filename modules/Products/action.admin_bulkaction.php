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

if( isset($params['multiselect']) && is_array($params['multiselect']) && count($params['multiselect']) && isset($params['bulkaction']) ) {
    try {
        for( $i = 0; $i < count($params['multiselect']); $i++ ) {
            $params['multiselect'][$i] = (int)$params['multiselect'][$i];
        }

        $bulk_modify_product_status = function( $product_list, $status ) {
            $query = new products_query( ['status'=>'*', 'productlist'=>$product_list ] );
            $rs = $query->execute();
            if( $rs->totalrows == 0 ) throw new \LogicException('Internal error: Products did not match in query');
            while( !$rs->EOF ){
                $product = $rs->get_object();
                $product->set_status( $status );
                $this->GetProductStorage()->Save( $product );
                $rs->MoveNext();
            }
        };

        switch( $params['bulkaction'] ) {
        case 'delete':
            foreach( $params['multiselect'] as $product_id ) {
                $this->GetProductStorage()->delete_by_id( $product_id );
            }
            break;

        case 'setdraft':
            $bulk_modify_product_status( $params['multiselect'], \Products\Product::STATUS_DRAFT );
            break;

        case 'setdisabled':
            $bulk_modify_product_status( $params['multiselect'], \Products\Product::STATUS_DISABLED );
            break;

        case 'setpublished':
            $bulk_modify_product_status( $params['multiselect'], \Products\Product::STATUS_PUBLISHED );
            break;

        case 'editquantity':
            // here we have to display a form
            $parms = array('multiselect'=>$params['multiselect']);
            $data = array('cd_multiselect'=>base64_encode(serialize($params)));
            $this->Redirect($id,'admin_bulk_editquantity',$returnid,$data);
        }
    }
    catch( \Exception $e ) {
        $this->SetError($e->GetMessage());
        $this->RedirectToTab($id);
    }
}

$this->Setmessage($this->Lang('operation_complete'));
$this->RedirectToTab($id);
#
# EOF
#
