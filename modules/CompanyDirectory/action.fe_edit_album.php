<?php  /* -*- Mode: PHP; tab-width: 4; c-basic-offset: 2 -*- */
#BEGIN_LICENSE
#-------------------------------------------------------------------------
# Module: CompanyDirectory (c) 2004-6 by Ted Kulp (ted@cmsmadesimple.org)
#   Copyright 2006 - 2014 by Robert Campbell (calguy1000@cmsmadesimple.org)
#
#  An addon module for CMS Made Simple to allow management of and various ways to display
#  company information for use in directories etc.
#
#-------------------------------------------------------------------------
# CMS - CMS Made Simple is (c) 2005-2010 by Ted Kulp (wishy@cmsmadesimple.org)
# Visit the CMSMS homepage at: http://www.cmsmadesimple.org
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

$feu = $this->GetModuleInstance('FrontEndUsers');
if( !$feu ) {
  echo '<h3><font color="red">'.$this->Lang('error_nofeu')."</font></h3>\n";
  return;
}
else if( !$feu->LoggedIn() ) {
  echo '<h3><font color="red">'.$this->Lang('error_feu_loggedin')."</font></h3>\n";
  return;
}
$feu_uid = $feu->LoggedInId();

$subaction = 'fulltemplate';

//
// Strip all params of the cd_ prefix
//
$p2 = array();
foreach( $params as $key => $value ) {
  $t = substr($key,0,3);
  if( $t == 'cd_' ) {
    $newkey = substr($key,3);
    $p2[$newkey] = $value;
  }
  else {
    $p2[$key] = $value;
  }
}
$params = $p2;

//
// initialization
//
if( !isset($params['companyid']) || !isset($params['fldid']) ) {
  echo '<h3><font color="red">'.$this->Lang('error_missingparam')."</font></h3>\n";
  return;
}
$fldid = (int)$params['fldid'];
$compid = (int)$params['companyid'];
if( $compid <= 0 ) {
  echo '<h3><font color="red">'.$this->Lang('error_invalid_param',$compid)."</font></h3>\n";
  return;
}
if( isset($params['subaction']) ) {
  $subaction = trim($params['subaction']);
}
$tmp = cd_utils::get_fielddefs(false,true);
if( !is_array($tmp) || count($tmp) == 0 ) {
  echo '<h3><font color="red">'.$this->Lang('error_fielddef_notfound',$params['fldid'])."</font></h3>\n";
  return;
}
$fnd = false;
foreach( $tmp as $one ) {
  if( $one['id'] == $fldid && $one['type'] == 'album' ) {
    $fnd = true;
    break;
  }
}
if( !$fnd ) {
  echo '<h3><font color="red">'.$this->Lang('error_fielddef_notfound',$params['fldid'])."</font></h3>\n";
  return;
}

$smarty->assign('companyid',$compid);
$smarty->assign('fldid',$fldid);
$config = cmsms()->GetConfig();
$basedir = cms_join_path($config['uploads_path'],'companydirectory','id'.$compid,'album_'.$fldid);
$baseurl = $config['uploads_url']."/companydirectory/id{$compid}/album_{$fldid}";
$smarty->assign('base_dir',$basedir);
$smarty->assign('base_url',$baseurl);

$smarty->assign('subaction',$subaction);
switch( $subaction ) {
 case 'gallery':
   $the_company = cd_company::load_by_id($compid,TRUE);
   $field = $the_company->get_field($fldid);
   if( is_object($field) && isset($field->value) && $field->value ) {
	 $files = unserialize($field->value);
	 $smarty->assign('files',$files);
   }
   // fall through
 case 'fulltemplate':
   $thetemplate = 'frontendalbum_'.$this->GetPreference(COMPANYDIR_PREF_DFLTFRONTENDALBUM_TEMPLATE);
   if( isset($params['frontendalbum'] ) ) {
	 $thetemplate = 'frontendalbum_'.$params['frontendalbum'];
   }
   echo $this->ProcessTemplateFromDatabase($thetemplate);
   break;

 case 'sort':
   if( isset($params['order']) && count($params['order']) ) {
	 $the_company = cd_company::load_by_id($compid,TRUE);
	 $field = $the_company->get_field($fldid);
	 if( is_object($field) && isset($field->value) && $field->value ) {
	   $files = unserialize($field->value);
	   if( count($files) == count($params['order']) ) {
		 $new_files = array();
		 foreach( $params['order'] as $idx ) {
		   $new_files[] = $files[$idx];
		 }
		 $the_company->set_field($fldid,serialize($new_files));
		 $the_company->save();
	   }
	 }
   }
   exit;

 case 'delete':
   $idx = (int)$params['idx'];
   $the_company = cd_company::load_by_id($compid,TRUE);
   $field = $the_company->get_field($fldid);
   if( is_object($field) && isset($field->value) && $field->value ) {
	 $files = unserialize($field->value);
	 if( $idx >= 0 && $idx < count($files) ) {
	   $filename = $files[$idx];
	   $basedir = cms_join_path($config['uploads_path'],'companydirectory','id'.$compid,'album_'.$fldid);
	   @unlink(cms_join_path($basedir,$filename));
	   array_splice($files,$idx,1);
	   $the_company->set_field($fldid,serialize($files));
	   $the_company->save();
	 }
   }
   exit;

 case 'upload':
   // ajax upload
   $options = array('param_name'=>'image_upload');
   $options['compid'] = $compid;
   $options['fdid']= $fldid;
   $options['upload_dir'] = cms_join_path($config['uploads_path'],'companydirectory','id'.$compid,'album_'.$fldid).'/';
   $options['upload_url'] = $config['uploads_url']."/companydirectory/id{$compid}/album_{$fldid}";
   $upload_handler = new CompanyDirectoryJQueryUploadHandler($options);

   try {
	 header('Pragma: no-cache');
	 header('Cache-Control: private, no-cache');
	 header('Content-Disposition: inline; filename="files.json"');
	 header('X-Content-Type-Options: nosniff');
	 header('Access-Control-Allow-Origin: *');
	 header('Access-Control-Allow-Methods: OPTIONS, HEAD, GET, POST, PUT, DELETE');
	 header('Access-Control-Allow-Headers: X-File-Name, X-File-Type, X-File-Size');

	 switch ($_SERVER['REQUEST_METHOD']) {
	 case 'OPTIONS':
	   break;
	 case 'HEAD':
	 case 'GET':
	   $upload_handler->get();
	   break;
	 case 'POST':
	   $upload_handler->post();
	   break;
	 case 'DELETE':
	   $upload_handler->delete();
	   break;
	 default:
	   header('HTTP/1.1 405 Method Not Allowed');
	 }
   }
   catch( Exception $e ) {
	 debug_to_log($e->GetMessage());
   }
   exit;
}

#
# EOF
#
?>