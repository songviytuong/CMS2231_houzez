<?php
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

#
# Initialization
#
$postalparms = array();
$newparms = array();
$resultpage = $returnid;
$errors = array();
$fielddefs = null;
$mastersearch = (int)get_parameter_value($params,'mastersearch');
$subsearch = (int)get_parameter_value($params,'subsearch');
if( $mastersearch && $subsearch ) $subsearch = FALSE; // only one type of search saving, thank you.
$sess = new cge_session('CD_SEARCH');
$tmp = cd_utils::get_fielddefs();
if( is_array($tmp) && count($tmp) ) {
  $fielddefs = array();
  foreach( $tmp as $field ) {
	$fielddefs[$field['name']] = $field;
  }
}

#
# Get parameters
#
if( isset($params['resultpage']) ) {
  $tmp = $this->resolve_alias_or_id($params['resultpage']);
  if( $tmp ) $resultpage = $tmp;
  unset($params['resultpage']);
}

if( $mastersearch && $sess->exists('master') ) {
  $newparms = $sess->get('master');
}
if( $subsearch && $sess->exists('sub') ) {
  $tmp = $sess->get('sub');
  $newparms = array_merge($newparms,$tmp);
}

#
# Handle form submission
#
if( isset($params['cd_resetall']) ) {
  $sess->clear();
  foreach( $params as $key => $value ) {
	if( startswith($key,'cd_') || startswith($key,'cdx_') ) unset($params[$key]);
  }
}
else if( isset($params['cd_reset']) ) {
  $sess->clear('master');
  foreach( $params as $key => $value ) {
	if( startswith($key,'cd_') || startswith($key,'cdx_') ) unset($params[$key]);
  }
}
else if( isset($params['cd_submit']) || isset($params['dosearch']) ) {
  try {
	//
	// first parse of parameters
	// clean them up and do basic validation.
	//
	foreach( $params as $key => $value ) {
	  $origkey = $key;
	  if( startswith($key,'cd_') ) $key = substr($key,3);
	  if( !is_array($value) ) $value = trim($value);
	  if( in_array($key,array('submit','dosearch','action','searchkey','srcsearchkey','searchformtemplate')) ) continue;
	  if( empty($value) ) continue;

	  switch( $key ) {
	  case 'name':
	  case 'phrase':
		$newparms[$key] = htmlspecialchars_decode($value);
		break;

	  case 'address':
	  case 'category':
		$newparms[$key] = $value;
		break;

	  case 'lat':
	  case 'latitude':
		// validate float
		if( $value != '' && (float)$value == 0.0 ) throw new CompanyDirectoryException($this->Lang('error_invalid_param',$key));
		$key = 'lat';
		$newparms[$key] = $value;
		break;

	  case 'long':
	  case 'longitude':
		// validate float
		if( $value != '' && (float)$value == 0.0 ) throw new CompanyDirectoryException($this->Lang('error_invalid_param',$key));
		$key = 'long';
		$newparms[$key] = $value;
		break;

	  case 'name_type':
		$value = strtolower($value);
		if( !in_array($value,array('exact','like')) ) {
		  throw new CompanyDirectoryException($this->Lang('error_invalid_param',$key).': '.$value);
		}
		$newparms[$key] = $value;
		break;

	  case 'addr_type':
	  case 'address_type':
		$value = strtolower($value);
		if( !in_array($value,array('substr','lookup')) ) throw new CompanyDirectoryException($this->Lang('error_invalid_param',$key));
		$key = 'addr_type';
		$newparms[$key] = $value;
		break;

	  case 'radius':
		// validate float.
		if( (float)$value == 0.0 ) throw new CompanyDirectoryException($this->Lang('error_invalid_param',$key).': '.$value);
		$newparms[$key] = $value;
		break;

	  case 'units':
		// validate miles or kilometers
		$value = strtolower($value);
		if( !in_array($value,array('mi','mile','miles','km','k')) ) throw new CompanyDirectoryException($this->Lang('err_invalidunits'));
		$newparms[$key] = $value;
		break;

	  case 'origpage':
	  case 'submit':
	  case 'cancel':
	  case 'resultpage':
	  case 'summarytemplate':
	  case 'detailpage':
	  case 'detailtemplate':
	  case 'action':
	  case 'module':
	  case 'dosearch':
	  case 'cdx_field':
		// do nothing.
		break;

	  case 'postal':
	  case 'postalchars':
	  case 'country':
	  case 'searchaddress':
          // doing a postal search (unless lat/long are also specified)
		$postalparms[$key] = $value;
		break;

	  default:
		$newparms[$key] = $value;
		break;
	  }
	}

	if( isset($params['cdx_field']) && is_array($params['cdx_field']) && count($params['cdx_field']) ) {
	  $value = $params['cdx_field'];
	  $tmp = array();
	  foreach( $value as $one ) {
		if( !is_array($one) ) continue;
		if( !isset($one['fldname']) || empty($one['fldname']) ) continue;
		if( !isset($one['fldval']) || empty($one['fldval']) || $one['fldval'] == '**IGNORE**' ) continue;
		if( !isset($fielddefs[$one['fldname']]) ) continue;
		if( !isset($one['expr']) || empty($one['expr']) ) $one['expr'] = 'AUTO';
		if( !isset($one['type']) || empty($one['type']) ) $one['type'] = null;
		$tmp[] = $one;
	  }
	  $newparms['fields'] = $tmp;
	}

	// done validating input params... save them
	$savedsearch = $newparms;

	// do an address lookup if we need to.
	// and we don't alredy have latitude/longitude
	if( isset($newparms['address']) && get_parameter_value($newparms,'addr_type','exact') == 'lookup' ) {
	  if( !isset($newparms['lat']) && !isset($newparms['long']) ) {
		$coords = cd_utils::geolocate($newparms['address']);
		if( $coords !== false ) {
		  $newparms['lat'] = $coords['lat'];
		  $newparms['long'] = $coords['lon'];
		  unset($newparms['address']); // don't wanna use the address again for filtering.
		}
		else {
		  throw new CompanyDirectoryException($this->Lang('error_address_lookup',$address));
		}
	  }
	}

	// do postcode search if necessary (if we don't already have latitude and longitude)
	if( count($postalparms) && isset($postalparms['postal']) && $postalparms['postal'] != '' ) {
	  $searchaddress = 0;
	  if( isset($postalparms['searchaddress']) ) $searchaddress = (int)$postalparms['searchaddress'];
	  if( !isset($newparms['lat']) && !isset($newparms['long']) ) {
		// we don't already have a latitude/longitude
		$postal = $postalparms['postal'];
		$mod = cms_utils::get_module('Postcode');
        if( !$mod ) {
            audit('',$this->GetName(),'postcode search specified, but no postcode module available');
        }
		else {
            // found the postcode module.
            $country = 'US';
            $postchars = '';
            if( isset($postalparms['country']) && strlen($postalparms['country']) == 2 ) $country = strtoupper($postalparms['country']);
            $postchars = \cge_param::get_int($postalparms,'postalchars');

            $postal_data = $mod->Lookup_Zip($country,$postal,$postchars);
            if( !is_array($postal_data) ) {
                // it didn't work
                throw new CompanyDirectoryException($this->Lang('error_postcode_lookup',$postal));
            }
            else {
                $newparms['lat'] = $postal_data['latitude'];
                $newparms['long'] = $postal_data['longitude'];
            }
		}
	  }
	  if( $searchaddress && isset($postalparms['postal']) ) $newparms['address2'] = $postalparms['postal'];
	}

	// validate newparms
	if( isset($newparms['name']) ) {
	  if( get_parameter_value($newparms,'name_type','exact') == 'like' ) $newparms['name'] = '*'.$newparms['name'].'*';
	}
	if( isset($newparms['address']) ) {
	  if( get_parameter_value($newparms,'addr_type','substr') == 'substr' ) $newparms['address'] = '*'.$newparms['address'].'*';
	}
	if( isset($newparms['name_type']) ) unset($newparms['name_type']);
	if( isset($newparms['addr_type']) ) unset($newparms['addr_type']);
	if( empty($newparms['lat']) || empty($newparms['long']) ) {
	  unset($newparms['lat']);
	  unset($newparms['long']);
	  unset($newparms['radius']);
	  unset($newparms['units']);
	}
	else if( !isset($newparms['radius']) ) {
	  unset($newparms['lat']);
	  unset($newparms['long']);
	  unset($newparms['radius']);
	  unset($newparms['units']);
	}

	//
	// create the filter object and query.
	//
	if( isset($newparms['radius']) && isset($newparms['units']) ) {
	  // further processing
	  $newparms['radius'] .= $newparms['units'];
	  unset($newparms['units']);
	}

	$filter = new cd_company_filter($newparms);

	// query 1 ... get all the company id's
	if( $this->GetPreference('collectstats') ) {
	  $tmpfilter = clone $filter; // $filter is an object, not an array
	  $tmpfilter['pagelimit'] = 1000000;
	  $tmp_query = new cd_company_query($tmpfilter);
	  $item_list = array();
	  while( !$tmp_query->EOF() ) {
		$item_list[] = $tmp_query->fields['id'];
		$tmp_query->MoveNext();
	  }
	  if( count($item_list) ) cd_utils::save_search_to_stats($filter,$item_list);
	}

	// query 2 ... get data for pagination.
	$query = new cd_company_query($filter);
	$pagination = $query->get_pagination();
	$pagination->set_extraparams(array('cd_dosearch'=>1));
	$page = $pagination->get_current_page();

	// give everything to smarty.
	$smarty->assign('filter',$filter);
	$smarty->assign('items',$query->get_results($id,$returnid));
	$smarty->assign('itemcount',$query->get_result_count());
	$smarty->assign('totalmatches',$query->get_total_matches());
	$smarty->assign('pagination',$pagination);
	$smarty->assign('pagetext',$this->Lang('page'));
	$smarty->assign('oftext',$this->Lang('of'));
	$smarty->assign('pagecount',$pagination->get_page_count());
	$smarty->assign('curpage',$page);
	$smarty->assign('hierarchy_list',array_flip(cd_utils::get_hierarchy_list()));

	if( $pagination->get_page_count() > 1 ) {
	  if( $page == 1 ) {
		$smarty->assign('firstlink',$this->Lang('firstpage'));
		$smarty->assign('prevlink',$this->Lang('prevpage'));
	  }
	  else {
		$smarty->assign('firstlink',$pagination->get_page_link(1,$this->Lang('firstpage')));
		$smarty->assign('prevlink',$pagination->get_page_link($pagination->get_current_page()-1,$this->Lang('prevpage')));
	  }
	  if( $page == $pagination->get_page_count() ) {
		$smarty->assign('lastlink',$this->Lang('lastpage'));
		$smarty->assign('nextlink',$this->Lang('nextpage'));
	  }
	  else {
		$smarty->assign('lastlink',$pagination->get_page_link($pagination->get_page_count(),$this->Lang('lastpage')));
		$smarty->assign('nextlink',$pagination->get_page_link($pagination->get_current_page()+1,$this->Lang('nextpage')));
	  }
	}

	// clear any subsearch if this is a master search
	if( $mastersearch ) $sess->clear('sub');

	// save the search parameters to the session.
	if( is_array($savedsearch) && count($savedsearch) ) {
	  // fix up saved search so it's easier to prepopulate stuff in the form.
	  $fields_o = $savedsearch['fields'];
	  $fields = array();
	  if( count($fields_o) ) {
	    foreach( $fields_o as $rec ) {
	      $fields[$rec['fldname']] = $rec;
	    }
	    $savedsearch['fields'] = $fields;
          }
	  if( $mastersearch ) $sess->put('master',$savedsearch);
	  if( $subsearch ) $sess->put('sub',$savedsearch);
	}


	$thetemplate = 'summary_'.$this->GetPreference(COMPANYDIR_PREF_DFLTSUMMARY_TEMPLATE);
	if( isset($params['summarytemplate']) ) $thetemplate = 'summary_'.trim($params['summarytemplate']);
	echo $this->ProcessTemplateFromDatabase($thetemplate);
	return;
  }
  catch( Exception $e ) {
	$errors[] = $e->GetMessage();
  }
} // submit or do_search

#
# Give everything to smarty
#
$thetemplate = $this->GetPreference(COMPANYDIR_PREF_DFLTSEARCHFORM_TEMPLATE);
$thetemplate = \cge_param::get_string($params,'searchformtemplate',$thetemplate);
$tpl = $this->CreateSmartyTemplate($thetemplate,'newsearch_');

// if it's a subsearch, or a master search, give stuff to smarty.
if( $mastersearch && $sess->exists('master') ) $tpl->assign('saved',$newparms);
if( $subsearch && $sess->exists('sub') ) $tpl->assign('saved',$newparms);

if( count($errors) ) $tpl->assign('errors',$errors);
$tpl->assign('fielddefs',$fielddefs);
$tmp = cd_utils::get_hierarchy_list(-1,FALSE);
if( is_array($tmp) && count($tmp) ) {
  $tmp2 = array(''=>$this->Lang('any'));
  foreach( $tmp as $k => $v ) $tmp2[$v] = $k; // backwards intentionally.
  $tpl->assign('hierarchies',$tmp2);
}

$tmp = cd_category::get_list();
if( is_array($tmp) ) $tpl->assign('categories',$tmp);

if( !isset($params['cd_origpage']) ) $params['cd_origpage'] = $returnid;
$tpl->assign('formstart',$this->CGCreateFormStart($id,'search',$resultpage,$params));
$tpl->assign('formend',$this->CreateFormEnd());

// Process the template
$tpl->display();

#
# EOF
#
