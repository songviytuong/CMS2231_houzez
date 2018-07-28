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


$go = 0;
if( isset($params['go']) ) $go = 1;

if( !isset($_SESSION['products_import_data']) ) die();
$params = $_SESSION['products_import_data'];

function progress($pct) {
    echo '<script type="text/javascript">parent.progress('.$pct.');</script>';
}
function do_error($str) {
    echo '<script type="text/javascript">parent.onError(\''.$str.'\');</script>';
}
function done() {
    echo '<script type="text/javascript">parent.done();</script>';
}

// setup display
if( $go == 1 ) {
    $smarty->assign('processurl',$this->create_url($id,'importcsv',$returnid, array('showtemplate'=>'false')));
    $url = $this->create_url($id,'defaultadmin',$returnid);
    $smarty->assign('doneurl',str_replace('&amp;','&',$url));
    echo $this->ProcessTemplate('importcsv.tpl');
    return;
}

set_time_limit(0);                   // ignore php timeout
ignore_user_abort(true);             // keep on going even if user pulls the plug*
while(ob_get_level())ob_end_clean(); // remove output buffers
ob_implicit_flush(true);             // output stuff directly


// begin work
echo '<!DOCTYPE html><html><head></head><body>'; // webkit hotfix

$config = $gCms->GetConfig();
$fn = $config['root_path'].'/tmp/cache/'.$params['filename'];
$fh = fopen($fn,'r');
if( !$fh ) {
    error($this->Lang('error_fileopen'));
    return;
}
$filesize = filesize($fn);

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
$importer->setPolicyValue('on_duplicate_product',trim($params['duplicateproducts']));
$importer->setPolicyValue('clearfields',(int)$params['clearfields']);
$importer->setPolicyValue('clearattribs',(int)$params['clearattribs']);
$importer->setPolicyValue('clearcategories',(int)$params['clearcategories']);

while( !feof($fh) ) {
    $line = $importer->get_unparsed_record($fh);
    $line = trim($line);
    $pos = ftell($fh);
    if( empty($line) ) continue;

    $pct = (int)($pos / $filesize * 100.0);
    progress($pct);

    $res = $importer->handleLine($line);
    if( !$res ) {
        $errors = $importer->getErrors();
        $importer->clearErrors();
        if( is_array($errors) && count($errors) ) {
            foreach( $errors as $one ) {
                do_error($one);
            }
        }
    }
}

// woot, we're done
fclose($fh);
done();
exit();

#
# EOF
#
?>
