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

class cd_company_validator
{
  private static $_keys('company_name','location','address','telephone','fax','contact_email','website','details','picture_location',
			'logo_location','latlong','hier_id','status','url');
  private $_co;
  private $_required = array('company_name','location');
  private $_validate_url = TRUE;

  public function __construct(cd_company& $company)
  {
    $this->_co = $company;
    $cdmod = cms_utils::get_module('CompanyDirectory');
    if( $cdmod->GetPreference('url_required') )
      {
	$this->_required[] = 'url';
      }
  }

  public function set_required($key,$flag = TRUE)
  {
    if( in_array($key,self::$_keys) )
      {
	if( $flag && !in_array($key,$this->_required) )
	  $this->_required[] = $key;
	elseif( !$flag && in_array($key,$this->_required) )
	  {
	    $idx = array_search($key,$this->_required);
	    if( $idx !== FALSE )
	      {
		unset($this->_required[$idx]);
	      }
	  }
      }
  }

  public function test_valid()
  {
    if( in_array('company_name',$this->_required) && $this->_co['company_name'] == '' )
      throw new CompanyDirectoryException('company_name is empty');

    if( in_array('location',$this->_required) && $this->_co['address'] == '' && ($this->_co['latitude'] == '' || $this->_co['longitude'] == '') )
      throw new CompanyDirectoryException('No location information supplied.');

    if( in_array('address',$this->_required) && $this->_co['address'] == '' )
      throw new CompanyDirectoryException('No address specified.');
      
    if( in_array('telephone',$this->_required) && $this->_co['telephone'] == '' )
      throw new CompanyDirectoryException('No telephone number specified.');

    if( in_array('fax',$this->_required) && $this->_co['fax'] == '' )
      throw new CompanyDirectoryException('No fax number specified.');

    if( in_array('contact_email',$this->_required) && $this->_co['contact_email'] == '' )
      throw new CompanyDirectoryException('No contact email specified.');

    if( in_array('website',$this->_required) && $this->_co['website'] == '' )
      throw new CompanyDirectoryException('No website specified.');

    if( in_array('details',$this->_required) && $this->_co['details'] == '' )
      throw new CompanyDirectoryException('No details specified.');
      
    if( in_array('picture_location',$this->_required) && $this->_co['picture_location'] == '' )
      throw new CompanyDirectoryException('No picture specified.');

    if( in_array('logo_location',$this->_required) && $this->_co['logo_location'] == '' )
      throw new CompanyDirectoryException('No logo specified.');

    if( in_array('latlong',$this->_required) && ($this->_co['latitude'] == '' || $this->_co['longitude'] == '') )
      throw new CompanyDirectoryException('Latitude and/or Longitude are invalid.');

    if( in_array('hier_id',$this->required) && ($this->_co['hier_id'] == '' || $this->_co['hier_id'] < 0) )
      throw new CompanyDirectoryException('Hierarchy is not specified');
      
    if( in_array('status',$this->_required) && $this->_co['status'] == '' )
      throw new CompanyDirectoryException('No status specified.');

    if( in_array('url',$this->_required) && $this->_co['url'] == '' )
      throw new CompanyDirectoryException('No url specified.');

    // check the url.
    if( $this->_co['url'] && $this->_validate_url )
      {
	if( !cd_utils::validate_url($this->_co['url'],TRUE) )
	  throw new CompanyDirectoryException('URL specified is invalid or in use.');
      }
  }
} // end of class

#
# EOF
#
?>