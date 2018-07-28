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
if (!isset($gCms)) exit;
if (!$this->CheckPermission('Modify Products')) return;
$this->SetCurrentTab('Products');

$get_unique_name = function( $input ) {
    $name = 'Copy of '.$input;
    $suffix = null;
    $storage = $this->GetProductStorage();
    while( $suffix < 100 ) {
        $tname = trim($name.' '.$suffix);
        if( ! $storage->get_by_name( $tname ) ) return $tname;
        if( !$suffix ) $suffix = 1;
        $suffix++;
    }
};

$get_unique_sku = function( $input ) {
    $idx = '';
    if( ($p = strpos($input,'_copy')) !== FALSE ) {
        if( $p !== FALSE ) $idx = (int)substr($input,$p+strlen('_copy'));
        $idx = max(2,$idx+1);
    }
    $new_sku = $input . '_copy' . $idx;
    while( $idx < 100 ) {
        if( !product_ops::check_sku_used($new_sku) ) return $new_sku;

        if( $idx == '' ) $idx = 1;
        $idx++;
        $new_sku = $input . '_copy' . $idx;
    }
};

try {
    $compid = \cge_param::get_int($params,'compid');
    if( $compid < 1 ) throw new \LogicException($this->Lang('error_missingparam'));

    $product = $this->GetProductStorage()->get_by_id( $compid );
    if( !$product ) throw new \LogicException($this->Lang('error_productnotfound'));

    $srcdir = product_utils::get_product_upload_path($product->id);
    $src_files = glob($srcdir.'/*');

    $product2 = clone $product;
    $product2->set_name($get_unique_name( $product->name ));
    if( $product2->alias ) $product2->set_alias( \product_ops::generate_alias( $product2->name) );
    if( $product2->sku ) $product2->set_sku( $get_unique_sku( $product2->sku ) );
    $product2 = $this->GetProductStorage()->save( $product2 );
    if( count($src_files) ) {
        $destdir = product_utils::get_product_upload_path($product2->id);
        @\cge_dir::mkdirr( $destdir );
        foreach( $src_files as $one_file ) {
            $fn = basename( $one_file );
            copy($one_file,cms_join_path($destdir,$fn));
        }
    }

    $this->SetMessage($this->Lang('msg_productcopied'));
    $this->Redirect($id,'editproduct','',array('compid'=>$product2->id));
}
catch( \Exception $e ) {
    $this->SetError($e->GetMessage());
    $this->RedirectToTab($id);
}


/*
  //
  // copy files.
  //
  if( is_dir($srcdir) ) {
      $files = glob($srcdir.'/*');
      if( is_array($files) && count($files) ) {
          @mkdir($destdir);
          foreach( $files as $onefile ) {
              $fn = basename($onefile);
              copy($onefile,cms_join_path($destdir,$fn));
          }
      }
  }
*/

//
// all done.. redirect to edit form
//

#
# EOF
#
