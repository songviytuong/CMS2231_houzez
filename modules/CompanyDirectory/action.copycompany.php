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
if (!isset($gCms)) exit;
if (!$this->CheckPermission('Modify Company Directory'))
{
  echo $this->ShowErrors($this->Lang('needpermission', array('Modify Company Directory')));
  return;
}

// initialization
$this->SetCurrentTab('companies');
$compid = '';
$srcdir = cms_join_path($gCms->config['uploads_path'],'companydirectory','id'.$compid);

// get params
if( !isset($params['compid']) )
  {
    echo $this->ShowErrors($this->Lang('error_missingparam'));
    return;
  }
$compid = (int)$params['compid'];

//
// get all the data
//

// get the company info.
$query = 'SELECT * FROM '.cms_db_prefix().'module_compdir_companies WHERE id = ?';
$company = $db->GetRow($query,array($compid));
if( !$company )
  {
    echo $this->ShowErrors($this->Lang('error_noresultsfound'));
    return;
  }

// get the fields.
$query = 'SELECT * FROM '.cms_db_prefix().'module_compdir_fieldvals WHERE company_id = ?';
$fields = $db->GetArray($query,array($compid));

// get the categories.
$query = 'SELECT * FROM '.cms_db_prefix().'module_compdir_company_categories WHERE company_id = ?';
$categories = $db->GetArray($query,array($compid));

// get the files.
$srcfiles = glob($srcdir.'/*.*');

//
// do the copy
//
if( $this->GetPreference('url_required',0) || $this->GetPreference('url_createoncopy') )
  {
	// Gotta Generate a URL
	$new_url = cd_utils::generate_url($company['company_name']);
	if( !$new_url )
	  {
		// error
		$this->SetError($this->Lang('error_invalidname'));
		$this->RedirectToTab($id);
	  }
	if( !cd_utils::validate_url($new_url) )
	  {
		// error.
		$this->SetError($this->Lang('error_invalidurl'));
		$this->RedirectToTab($id);
	  }
	$company['url'] = $new_url;
  }
else
  {
	// We don't need a URL, so make sure that we don't create a copy of an existing one.
	$company['url'] = '';
  }

$query = 'INSERT INTO '.cms_db_prefix().'module_compdir_companies (company_name, url, address, telephone,
            fax, contact_email, website, details, picture_location, logo_location, create_date,
            modified_date, status, latitude, longitude, owner_id,hier_id)
          VALUES (?,?,?,?,?,?,?,?,?,?,NOW(),NOW(),?,?,?,?,?)';
$dbr = $db->Execute($query,
		    array($company['company_name'],
				  $company['url'],
				  $company['address'],
				  $company['telephone'],
				  $company['fax'],
				  $company['contact_email'],
				  $company['website'],
				  $company['details'],
				  $company['picture_location'],
				  $company['logo_location'],
				  $company['status'],
				  $company['latitude'],
				  $company['longitude'],
				  $company['owner_id'],
				  $company['hier_id']));
if( !$dbr ) die($db->sql.'<br/>'.$db->ErrorMsg());
$new_compid = $db->Insert_ID();


if( is_array($fields) && count($fields) ) {
  $query = 'INSERT INTO '.cms_db_prefix().'module_compdir_fieldvals (company_id,fielddef_id,value,create_date,modified_date)
            VALUES (?,?,?,NOW(),NOW())';
  foreach( $fields as $field ) {
	$dbr = $db->Execute($query, array($new_compid,$field['fielddef_id'],$field['value']));
	if( !$dbr ) die($db->sql.'<br/>'.$db->ErrorMsg());
  }
}

if( is_array($categories) && count($categories) ) {
  $query = 'INSERT INTO '.cms_db_prefix().'module_compdir_company_categories (company_id,category_id,create_date,modified_date)
            VALUES (?,?,NOW(),NOW())';
  foreach( $categories as $category ) {
	$dbr = $db->Execute($query,array($new_compid,$category['category_id']));
	if( !$dbr ) die($db->sql.'<br/>'.$db->ErrorMsg());
  }
}

// copy files
if( count($srcfiles) ) {
  $destdir = cms_join_path($gCms->config['uploads_path'],'companydirectory','id'.$new_compid);
  cge_dir::mkdirr($destdir);
  foreach( $srcfiles as $onefile ) {
	$bn = basename($onefile);
	@copy($srcfile,cms_join_path($destdir,$bn));
  }
}

// update search index.
$module = cms_utils::get_search_module();
if ($module != FALSE && $company['status'] == 'published' ) {
  $module->AddWords($this->GetName(), $cid, 'company',
					implode(' ', array($company['company_name'],
									   $company['company_name'],
									   $company['address'],
									   $company['telephone'],
									   $company['fax'],
									   $company['details'])));
}


// and redirect somewhere.
$this->SetMessage($this->Lang('msg_companycopied'));
$this->Redirect($id,'editcompany','',array('compid'=>$new_compid,'nocancel'=>1));

#
# EOF
#
?>