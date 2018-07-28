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
//
// functions
//
function _get_childnode(&$parent,$nodename)
{
  $children = $parent->childNodes;
  foreach( $children as $childnode ) {
	if( $childnode->nodeName == $nodename ) {
	  return $childnode;
	}
  }
  return NULL;
}

function _get_childnode_value(&$parent,$nodename)
{
  $ob = _get_childnode($parent,$nodename);
  if( is_object($ob) ) return $ob->nodeValue;
}

//
// initialize
//
$this->SetCurrentTab('companies');
$ignore_address = 0;
$do_convert_address = 0;
$status = 'draft';
$imported = 0;
$category = -1;
$hierarchy = -1;
$check_duplicate_name = 0;
$errors = array();
$can_do_lookups = cd_utils::can_geolocate();

//
// handle form data
//
if( isset($params['cancel']) ) {
  $this->RedirectToTab($id);
}
else if( isset($params['submit']) ) {
  set_time_limit(0);

  if( isset($params['status']) ) $status = trim($params['status']);
  if( isset($params['ignore_address']) ) $ignore_address = (int)$params['ignore_address'];
  if( isset($params['do_convert_address']) ) $do_convert_address = (int)$params['do_convert_address'];
  if( isset($params['check_duplicate_name']) ) $check_duplicate_name = (int)$params['check_duplicate_name'];
  if( isset($params['category']) ) $category = (int)$params['category'];
  if( isset($params['hierarchy']) ) $hierarchy = (int)$params['hierarchy'];

  $name = $id.'kmlfile';
  if( !isset($_FILES) ||
	  !isset($_FILES[$name]) || 
	  $_FILES[$name]['error'] > 0 ||
	  $_FILES[$name]['size'] == 0 ) {
    //bad upload
    $this->SetError($this->Lang('error_upload'));
    $this->RedirectToTab();
  }

  $doc = new DomDocument();
  $doc->load($_FILES[$name]['tmp_name']);
  $places = $doc->getElementsByTagName('Placemark');
  if( $places->length == 0 ) {
	$this->SetError($this->Lang('error_kml_noplacemarks'));
	$this->RedirectToTab();
  }

  for( $idx = 0; $idx < $places->length; $idx++ ) {
	$node = $places->item($idx);
	if( !$node ) continue;

	$address = '';
	$name = '';
	$description = '';
	$latitude = '';
	$longitude = '';
	$phone = '';

	$name    = _get_childnode_value($node,'name');
	$desc    = _get_childnode_value($node,'description');
	$phone   = _get_childnode_value($node,'phonenumber');

	// get the address.
	if( !$ignore_address ) {
	  $_address_N = _get_childnode($node,'address');
	  if( !$_address_N ) {
		$errors[] = $this->Lang('error_kmlimport_noaddress',$idx);
		continue;
	  }
		
	  $address = $_address_N->nodeValue;
	}

	// get the coordinates.
	{
	  $_point_N  = _get_childnode($node,'Point');
	  if( !$_point_N ) {
		$errors[] = $this->Lang('error_kmlimport_nopoint',$idx);
		continue;
	  }
	  $_coords_N  = _get_childnode($_point_N,'coordinates');
	  if( !$_coords_N ) {
		$errors[] = $this->Lang('error_kmlimport_nopoint',$idx);
		continue;
	  }
	  $coords = $_coords_N->nodeValue;
	  list($longitude,$latitude) = explode(',',$coords);
	}

	if( $address != '' && ($latitude == '' || $longitude == '') && $do_convert_address == 1 ) {
	  $coords = cd_utils::geolocate($address);
	  if( is_array($coords) ) {
		$latitude = $coords['lat'];
		$longitude = $coords['lon'];
	  }
	}

	// got enough information to add a node.
	if( $name != '' && ($address != '' || ($latitude != '' && $longitude != '')) ) {
	  if( $check_duplicate_name ) {
		$query = 'SELECT id FROM '.cms_db_prefix().'module_compdir_companies
                  WHERE company_name = ?';
		$tmp = $db->GetOne($query,array($name));
		if( $tmp ) {
		  // it's a duplicate
		  // continue without error
		  continue;
		}
	  }

	  $query = 'INSERT INTO '.cms_db_prefix().'module_compdir_companies
                (company_name, address, telephone, details, status, hier_id, latitude, longitude, create_date, modified_date)
                VALUES (?,?,?,?,?,?,?,?,NOW(),NOW())';
	  $dbr = $db->Execute($query,array($name,$address,$phone,$desc,$status,$hierarchy,$latitude,$longitude));
	  if( !$dbr ) {
		$errors[] = $this->Lang('error_kmlimport_dberror',$idx);
		continue;
	  }
	  $new_id = $db->Insert_ID();

	  if( $category > 0 ) {
		$query = 'INSERT INTO '.cms_db_prefix().'module_compdir_company_categories
                  (company_id,category_id,create_date,modified_date) VALUES (?,?,NOW(),NOW())';
		$dbr = $db->Execute($query,array($new_id,$category));
	  }

	  $imported++;
	}
  }

  // woot, done
  audit('',$this->GetName(),'Imported '.$imported.' companies from KML');
  $smarty->assign('finished',1);
  $smarty->assign('imported',$imported);
  if( count($errors) ) {
	$smarty->assign('errorcount',count($errors));
	$smarty->assign('errors',$errors);
  }
}

//
// build the form
//
$statuses = array($this->Lang('published')=>'published',
		  $this->Lang('draft')=>'draft',
		  $this->Lang('disabled')=>'disabled');
$smarty->assign('statustext',$this->Lang('status'));
$smarty->assign('inputstatus',$this->CreateInputDropdown($id,'status', $statuses,-1,'draft'));
$smarty->assign('can_do_lookups',$can_do_lookups);
$smarty->assign('formstart',
				$this->CGCreateFormStart($id,'importkml','',array(),
										 false,'post','multipart/form-data'));
$smarty->assign('formend',$this->CreateFormEnd());
$tmp = cd_utils::get_categories(TRUE);
if( is_array($tmp) && count($tmp) ) {
  $catlist = array(-1=>$this->Lang('none'));
  foreach( $tmp as $id => $one ) {
	$catlist[$id] = $one->name;
  }
  $smarty->assign('categories',$catlist);
}
$tmp = cd_utils::get_hierarchy_list();
if( is_array($tmp) && count($tmp) ) {
  $smarty->assign('hierarchies',array_flip($tmp));
}

echo $this->ProcessTemplate('importkml.tpl');

#
# EOF
#
?>