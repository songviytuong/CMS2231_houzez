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

//
// retrieve all of the values of a field
// this is an action intended to be called via ajax... i.e: with the showtemplate=false parameter
//

//
// setup
//
$res = array('status'=>'ERROR','data'=>'');
$field = '';
$fieldval = '';
$fielddefs = product_utils::get_fielddefs();
$data = '';

function do_error($msg,$extra = null) {
    $res['status'] = 'ERROR';
    $res['data'] = $msg;
    if( !is_null($extra) ) $res['extra'] = $extra;
    echo json_encode($res);
    exit;
}

//
// data validation
//
if( !isset($params['field']) || !isset($params['fieldval']) ) {
    do_error($this->Lang('error_missingparam'));
}
$field = trim($params['field']);
$fieldval = trim($params['fieldval']);

//
// do the work
//
$lfield = strtolower($field);
switch( strtolower($lfield) ) {
case '::sku::':
    $query = 'SELECT sku FROM '.cms_db_prefix().'module_products WHERE sku LIKE ?';
    $data = $db->GetCol($query,array($fieldval.'%'));
    break;

case '::name::':
    $query = 'SELECT product_name FROM '.cms_db_prefix().'module_products WHERE product_name LIKE ?';
    $data = $db->GetCol($query,array($fieldval.'%'));
    break;

case '::alias::':
    $query = 'SELECT alias FROM '.cms_db_prefix().'module_products WHERE alias LIKE ?';
    $data = $db->GetCol($query,array($fieldval.'%'));
    break;

default:
    $fnd = 0;
    for( $i = 0; $i < count($fielddefs); $i++ ) {
        if( $fielddefs[$i]->name == $field ) {
            $fnd = 1;
              $query = 'SELECT DISTINCT value FROM '.cms_db_prefix().'module_products_fieldvals WHERE fielddef_id = ? AND value LIKE ?';
              $data = $db->GetCol($query,array($fielddefs[$i]->id,$fieldval.'%'));
              break;
        }
    }
    if( !$fnd ) {
        $ext = array('lookfor'=>$lfield,'fd'=>$fielddefs,'val'=>$fieldval.'%');
        do_error($this->Lang('error_invalid_name'),$ext);
    }
    break;
}

//
// output
//
$res['status'] = 'OK';
$res['data'] = $data;
echo json_encode($res);
exit;

#
# EOF
#?>