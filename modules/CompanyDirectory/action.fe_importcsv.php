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
if( !isset($gCms) ) exit();
if( !$this->GetPreference('frontend_import',0) ) return;

//
// initialization
//
$filestr = $id.'cd_csvfile';
$message = '';
$errors = array();
$delimiter = '';
$frontendusers = $this->GetModuleInstance('FrontEndUsers');
if( !$frontendusers ) exit();
$feu_uid = $frontendusers->LoggedInId();
if( $feu_uid <= 0 ) exit(); // not logged in.

$maxrecords = $this->GetPreference('frontend_numrecords',0);
$query = 'SELECT COUNT(id) FROM '.cms_db_prefix().'module_compdir_companies
           WHERE owner_id = ?';
$numrecords = $db->GetOne($query,array($feu_uid));

if( $maxrecords - $numrecords <= 0 )
  {
    $message = $this->Lang('error_nospotsleft');
  }
else if( isset($params['cd_submit']) )
  {
    $delimiter = trim($params['cd_delimiter']);
    if( $delimiter == '' )
      {
	$errors[] = $this->Lang('error_delimiter');
      }
    else if( !isset($_FILES) ||
	     !isset($_FILES[$filestr])  ||
	     $_FILES[$filestr]['error'] != 0 ||
	     $_FILES[$filestr]['size'] == 0 )
      {
	$errors[] = $this->Lang('error_upload');
      }

    if( count($errors) == 0 )
      {
	$importer = new cd_ascii_importer($this);
	$importer->set_delimiter($delimiter);
	$importer->set_max_companies($maxrecords - $numrecords);
	$importer->do_fielddefs(false);
	$importer->do_fieldvals(true);
	$importer->do_categorydefs(false);
	$importer->do_categoryvals(true);
	$importer->do_latlong_lookup(false);
	$importer->check_duplicate_companies(true);
	$importer->do_hierarchydefs(false);
	$importer->do_hierarchyvals(true);
	$importer->set_user($feu_uid);
	$importer->create_url($this->GetPreference('url_required',0));

	$res = $importer->import_file($_FILES[$filestr]['tmp_name']);
	$errors = $importer->get_errors();

	$message = $this->Lang('msg_import_complete');

	$query = 'SELECT COUNT(id) FROM '.cms_db_prefix().'module_compdir_companies
                  WHERE owner_id = ?';
	$numrecords = $db->GetOne($query,array($feu_uid));

	if( $numrecords > 0 )
	  {
		audit('',$this->GetName(),'Imported '.$numrecords.' from csv via the frontend');
	  }

      }
  }


//
// give everything to smarty
//
if( count($errors) )
  {
    $smarty->assign('errors',$errors);
  }
if( $message != '' )
  {
    $smarty->assign('message',$message);
  }
$smarty->assign('maxrecords',$maxrecords);
$smarty->assign('numrecords',$numrecords);
$smarty->assign('formstart',$this->CGCreateFormStart($id,'fe_importcsv',$returnid,array(),false,'post','multipart/form-data'));
$smarty->assign('formend',$this->CreateFormEnd());

echo $this->ProcessTemplateFromDatabase(COMPANYDIR_FRONTENDIMPORT_TEMPLATE);

#
# EOF
#
?>