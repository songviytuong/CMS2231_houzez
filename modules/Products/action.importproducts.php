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
if( !$this->CheckPermission('Modify Products') ) return;

#
# Initialization
#
$this->SetCurrentTab('products');
$flag_createfields = 0;
$flag_handleimages = 0;
$imagepath = '';
$flag_createhierarchy = 0;
$flag_createcategories = 0;
$flag_duplicateproducts = 'skip';
$delemeter = '|';
$batchsize = 50;

#
# Setup
#
$flag_createfields = $this->GetPreference('import_createfields',1);
$flag_handleimages = $this->GetPreference('import_handleimages',0);
$imagepath = $this->GetPreference('import_imagepath','');
$flag_createhierarchy = $this->GetPreference('import_createhierarchy',1);
$flag_createcategories = $this->GetPreference('import_createcategories',1);
$flag_duplicateproducts = $this->GetPreference('import_duplicateproducts','overwrite');
$delimiter = $this->GetPreference('import_delimiter','|');
$batchsize = $this->GetPreference('import_batchsize',50);
$clearfields = $this->GetPreference('import_clearfields',1);
$clearattribs = $this->GetPreference('import_clearattribs',1);
$clearcategories = $this->GetPreference('import_clearcategories',1);

#
# Handle Form Data
#
if( isset($params['cancel']) ) $this->RedirectToTab($id);

if( isset($params['test']) ) {
    // get the form data
    $flag_createfields = (int)$params['createfields'];
    $flag_handleimages = (int)$params['handleimages'];
    $imagepath = trim($params['imagepath']);
    $flag_createhierarchy = (int)$params['createhierarchy'];
    $flag_createcategories = (int)$params['createcategories'];
    $flag_duplicateproducts = $params['duplicateproducts'];
    $delimiter = $params['delimiter'];
    $batchsize = (int)$params['batchsize'];
    $clearfields = (int)$params['clearfields'];
    $clearattribs = (int)$params['clearattribs'];
    $clearcategories = (int)$params['clearcategories'];

    // validate the form data
    $error = '';
    $messages = array();
    $import_errors = array();
    $config = $gCms->GetConfig();
    $uh = new cg_fileupload($id,$config['root_path'].'/tmp/cache');
    $uh->set_accepted_filetypes('csv');
    $uh->set_allow_overwrite();
    $res = $uh->handle_upload('csvfile','products');
    if( $res === false ) {
        $tmp = $uh->get_error();
        $error = $this->GetUploadErrorMessage($tmp);
    }

    if( empty($error) ) {
        // ready to do some testing on the csv file.
        $fn = $config['root_path'].'/tmp/cache/products.csv';
        $the_filesize = filesize($fn);
        $fh = fopen($fn,'r');
        if( !$fh ) $error = $this->Lang('error_fileopen',$fn);

        if( empty($error) ) {
            $linenum = 0;
            $importer = new productsCsvImporter($this);
            $importer->setDelim($delimiter);
            while( !feof($fh) && $linenum < 20 ) {
                $line = $importer->get_unparsed_record($fh);
                $line = trim($line);
                $linenum++;
                $tmp = array();

                if( empty($line) ) continue;

                $res = $importer->testLine($line,$tmp);
                if( $res === FALSE ) {
                    $error = $this->Lang('error_fileformat');
                    break;
                }
                $messages = array_merge($messages,$tmp);
            }
        }
    }

    if( !empty($error) && isset($importer) && is_object($importer) ) $import_errors = $importer->getErrors();

    if( empty($error) ) {
        // save the preferences
        $this->SetPreference('import_createfields',$flag_createfields);
        $this->SetPreference('import_handleimages',$flag_handleimages);
        $this->SetPreference('import_imagepath',$imagepath);
        $this->SetPreference('import_createhierarchy',$flag_createhierarchy);
        $this->SetPreference('import_createcategories',$flag_createcategories);
        $this->SetPreference('import_duplicateproducts',$flag_duplicateproducts);
        $this->SetPreference('import_delimiter',$delimiter);
        $this->SetPreference('import_batchsize',$batchsize);
        $this->SetPreference('import_clearfields',$clearfields);
        $this->SetPreference('import_clearattribs',$clearattribs);
        $this->SetPreference('import_clearcategories',$clearcategories);

        // save parameters in session
        $params['filename'] = 'products.csv';
        $_SESSION['products_import_data'] = $params;

        // Get ready for the go action
        $smarty->assign('csvfile',$params['filename']);
        if( count($messages) > 0 ) $smarty->assign('messages',$messages);
        echo $this->ShowMessage($this->Lang('info_import_test_passed'));
    }
    else {
        $smarty->assign('errors',$import_errors);
        echo $this->ShowErrors($error);
    }
}
else if( isset($params['go']) ) {
    $this->Redirect($id,'importcsv',$returnid,$params);
    $cge = $this->GetModuleInstance('CGExtensions');
    $fn = $cge->GetModulePath().'/lib/Progress2_Lite.php';
    include($fn);

    if( !isset($_SESSION['products_import_data']) ) die();
    $params = $_SESSION['products_import_data'];
    $batchsize = 50;
    $clearfields = 1;
    $clearattribs = 1;
    $clearcategories = 1;
    $linenum = 0;
    $fpos = 0;
    if( isset($params['batchsize']) ) $batchsize = (int)$params['batchsize'];
    if( isset($params['linenum']) ) $linenum = (int)$params['linenum'];
    if( isset($params['fpos']) ) $fpos = (int)$params['fpos'];
    if( isset($params['clearfields']) ) $clearfields = (int)$params['clearfields'];
    if( isset($params['clearattribs']) ) $clearattribs = (int)$params['clearattribs'];
    if( isset($params['clearcategories']) ) $clearcategories = (int)$params['clearcategories'];

    $config = $gCms->GetConfig();
    $fn = $config['root_path'].'/tmp/cache/'.$params['filename'];
    $the_filesize = filesize($fn);
    $fh = fopen($fn,'r');
    if( !$fh ) {
        echo $this->Lang('error_fileopen');
        return;
    }

    $imageHandler = new importImageHandler($this);
    $imageHandler->setSourceLocation(cms_join_path($config['uploads_path'],$params['imagepath']));
    $imageHandler->setDestinationBase(product_utils::get_base_upload_path());
    $imageHandler->setUniqueNames();

    $importer = new productsCsvImporter($this);
    $importer->setImageHandler($imageHandler);
    $importer->setDelim($params['delimiter']);
    $importer->setPolicyValue('create_fields',(int)$params['createfields']);
    $importer->setPolicyValue('handle_images',(int)$params['handleimages']);
    $importer->setPolicyValue('create_hierarchy',(int)$params['createhierarchy']);
    $importer->setPolicyValue('create_categories',(int)$params['createcategories']);
    $importer->setPolicyValue('image_source_location',$params['imagepath']);
    $importer->setPolicyValue('skip_existing_products',$params['duplicateproducts'] == 'skip');

    $batchlines = 0;
    if( $fpos > 0 ) {
        // process the first line again.
        $line = $importer->get_unparsed_record($fh);
        $line = trim($line);
        if( empty($line) ) return;
        $res = $importer->handleLine($line);

        // seek to our old position.
        fseek($fh,$fpos);
    }
    while( !feof($fh) && $batchlines < $batchsize ) {
        $line = $importer->get_unparsed_record($fh);
        $line = trim($line);
        $linenum++;
        $batchlines++;
        $pos = ftell($fh);
        $smarty->assign('progress',(int)($pos / $the_filesize * 100.0));
        if( empty($line) ) continue;

        $res = $importer->handleLine($line);
    }
    if( !feof($fh) ) {
        // ready for the next batch

        // save any errors
        $errors = $importer->get_errors();
        if( is_array($errors) && count($errors) ) {
            if( !isset($_SESSION['products_import_data']['errors']) ) $_SESSION['products_import_data']['errors'] = array();
            $_SESSION['products_import_data']['errors'] =  array_merge($_SESSION['products_import_data']['errors'],$errors);
        }

        // save our position
        $pos = ftell($fh);
        fclose($fh);
        $_SESSION['products_import_data']['fpos'] = $pos;
        $_SESSION['products_import_data']['linenum'] = $linenum;

        $parms = array('go'=>1);
        $this->Redirect($id,'importproducts',$returnid,$parms);
    }
    // we're done.
    fclose($fh);
    $errors = $importer->getErrors();
    if( is_array($errors) ) $_SESSION['products_import_data']['errors'] =  array_merge($_SESSION['products_import_data']['errors'],$errors);
    $smarty->assign('errors',$_SESSION['products_import_data']['errors']);
    unset($_SESSION['products_import_data']['errors']);
}

#
# Give Everything to Smarty
#
$smarty->assign('flag_createfields',$flag_createfields);
$smarty->assign('flag_handleimages',$flag_handleimages);
$smarty->assign('imagepath',$imagepath);
$smarty->assign('flag_createhierarchy',$flag_createhierarchy);
$smarty->assign('flag_createcategories',$flag_createcategories);
$smarty->assign('flag_duplicateproducts',$flag_duplicateproducts);
$smarty->assign('delimiter',$delimiter);
$smarty->assign('batchsize',$batchsize);
$smarty->assign('clearfields',$clearfields);
$smarty->assign('clearattribs',$clearattribs);
$smarty->assign('clearcategories',$clearcategories);

$smarty->assign('formstart',$this->CGCreateFormStart($id,'importproducts',$returnid,array(),false,'post','multipart/form-data'));
$smarty->assign('formend',$this->CreateFormEnd());
$yesno = array('0'=>$this->Lang('no'),'1'=>$this->Lang('yes'));
$smarty->assign('yesno',$yesno);

#
# Process The Template
#
echo $this->ProcessTemplate('importproducts.tpl');

#
# EOF
#
?>
