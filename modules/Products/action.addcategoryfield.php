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
if (!$this->CheckPermission('Modify Products')) return;
$this->SetCurrentTab('categories');

if( !isset($params['catid']) ) {
    echo $this->ShowErrors($this->Lang('error_missingparam'));
    return;
}

#
# Initialization
#
$config = $gCms->GetConfig();
$catid = (int)$params['catid'];
$fieldtype = 'textbox';
$fieldname = '';
$fieldprompt = '';
$fieldvalue = null;
$old_fieldname = '';
if( isset($params['fldname']) ) {
    $fieldname = trim($params['fldname']);
    $query = 'SELECT * FROM '.cms_db_prefix().'module_products_category_fields
              WHERE category_id = ? AND field_name = ?';
    $row = $db->GetRow($query,array($catid,$fieldname));
    $fieldtype = $row['field_type'];
    $fieldprompt = $row['field_prompt'];
    $fieldvalue = $row['field_value'];
    $old_fieldname = $fieldname;
}


// Get the category data
$query = 'SELECT * FROM '.cms_db_prefix().'module_products_categories WHERE id = ?';
$category = $db->GetRow($query,array($catid));
$smarty->assign('category',$category);

if( isset($params['cancel']) ) {
    $this->Redirect($id,'editcategoryfields',$returnid, array('catid'=>$catid));
}
else if( isset($params['submit']) ) {
    //
    // Validate Form Input
    //
    try {
            $upload_handler = function( $id, $catid, $oldvalue, $allowed ) {
            $destdir = product_utils::get_category_upload_path($catid);
            cge_dir::mkdirr($destdir);
            if( !is_dir($destdir) ) die('directory still does not exist');
            $handler = new cg_fileupload($id,$destdir);
            $handler->set_accepted_filetypes($allowed);
            $res = $handler->handle_upload('input_fieldvalue');
            $err = $handler->get_error();
            if( !$res && $err != cg_fileupload::NOFILE )  {
                $error = sprintf("%s %s: %s",$this->Lang('field'),'input_fieldvalue',
                                 $this->GetUploadErrorMessage($err));
                throw new \RuntimeException($error);
            }
            else if( !$res && $err == cg_fileupload::NOFILE ) return '-1';
            if( $oldvalue ) @unlink($destdir.'/'.$oldvalue);
            return $res;
        };

        //
        // Get Parameter Valus
        //
        $old_field_value = $fieldvalue;
        $fieldtype = cge_utils::get_param($params,'input_fieldtype',$fieldtype);
        $fieldname = trim(cge_utils::get_param($params,'input_fieldname',$fieldname));
        $fieldprompt = trim(cge_utils::get_param($params,'input_fieldprompt',$fieldprompt));

        // Name can be empty (we'll generate one)
        if( empty($fieldname) ) {
            $query = 'SELECT COUNT(category_id)+1 FROM '.cms_db_prefix().'module_products_category_fields WHERE category_id = ?';
            $fieldname = 'field_'.$db->GetOne($query,array($catid));
        }

        // Prompt can be empty (we'll use the field name)
        if( empty($fieldprompt) ) $fieldprompt = $fieldname;

        switch($fieldtype) {
        case 'image':
            $res = $upload_handler( $id, $catid, $old_field_value, $this->GetPreference('allowed_imagetypes') );
            if( $res !== '-1' ) $fieldvalue = $res;
            break;
        case 'file':
            $res = $upload_handler( $id, $catid, $old_field_value, $this->GetPreference('allowed_filetypes') );
            if( $res !== '-1' ) $fieldvalue = $res;
            break;
        default:
            $fieldvalue = cge_utils::get_param($params,'input_fieldvalue',$fieldvalue);
            break;
        }

        // At this point, value cannot be empty
        if( !$fieldvalue ) throw new \RuntimeException('error_fieldvalue_empty');

        // Store the field definition
        if( $old_fieldname ) {
            $query = 'UPDATE '.cms_db_prefix().'module_products_category_fields
                         SET field_name = ?, field_type = ?, field_prompt = ?, field_value = ?
                       WHERE category_id = ? AND field_name = ?';
            $db->Execute($query, [ $fieldname,$fieldtype,$fieldprompt,$fieldvalue,$catid,$old_fieldname ] );
        }
        else  {
            $query = 'SELECT MAX(field_order) AS num FROM '.cms_db_prefix().'module_products_category_fields
                       WHERE category_id = ?';
            $tmp = $db->GetRow($query,[ $catid ]);
            $fieldorder = 0;
            if( is_array($tmp) ) $fieldorder = $tmp['num']+1;
            $query = 'INSERT INTO '.cms_db_prefix().'module_products_category_fields
                      (category_id, field_type, field_name, field_prompt, field_value, field_order)
                      VALUES (?,?,?,?,?,?)';
            $db->Execute($query, [ $catid,$fieldtype,$fieldname,$fieldprompt,$fieldvalue,$fieldorder ] );
        }


        // Redirect.
        $this->Redirect($id,'editcategoryfields',$returnid, array('catid'=>$catid));
    }
    catch( \Exception $e ) {
        echo $this->ShowErrors($e->GetMessage());
    }
}

//
// Create the form
//
$smarty->assign('catid',$catid);
$smarty->assign('fieldname',$fieldname);
$smarty->assign('fieldtype',$fieldtype);
$smarty->assign('fieldprompt',$fieldprompt);
$smarty->assign('fieldvalue',$fieldvalue);

$fieldtypes = array();
$fieldtypes[$this->Lang('textbox')] = 'textbox';
$fieldtypes[$this->Lang('textarea')] = 'textarea';
$fieldtypes[$this->Lang('imagetext')] = 'image';
$fieldtypes[$this->Lang('file')] = 'file';
$smarty->assign('fieldtypes',array_flip($fieldtypes));

switch( $fieldtype ) {
case 'textbox':
    $smarty->assign('input_fieldvalue',
                    $this->CreateInputText($id,'input_fieldvalue',$fieldvalue,80,255));
    break;

case 'textarea':
    $smarty->assign('input_fieldvalue',
                    $this->CreateTextArea(true,$id,$fieldvalue,'input_fieldvalue'));
    break;

case 'image':
    if( !empty($fieldvalue) ) {
        $smarty->assign('input_hidden',$this->CreateInputHidden($id,'input_fieldvalue',$fieldvalue));
    }
    $smarty->assign('filelocation',product_utils::get_category_upload_url($catid));
    if( file_exists( cms_join_path( product_utils::get_category_upload_path((int)$catid),$fieldvalue) ) ) {
        $smarty->assign('fileexists',1);
    }
    $smarty->assign('input_fieldvalue', $this->CreateFileUploadInput($id,'input_file','',40));
    break;

case 'file':
    if( !empty($fieldvalue) ) {
        $smarty->assign('input_hidden',$this->CreateInputHidden($id,'input_fieldvalue',$fieldvalue));
    }
    $smarty->assign('filelocation','uploads/'.$this->GetName().'/categories/'.$catid);
    if( file_exists( cms_join_path( product_utils::get_category_upload_path($catid),$fieldvalue) ) ) {
        $smarty->assign('fileexists',1);
    }
    $smarty->assign('input_fieldvalue',  $this->CreateFileUploadInput($id,'input_file','',40));
    break;
}

# Process template
echo $this->CGProcessTemplate('addcategoryfield.tpl');

#
# EOF
#