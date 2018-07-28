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

class CompanyDirectoryJQueryUploadHandler extends cd_jquery_upload_handler 
{
  function __construct($options=null) 
  {
    if( !is_array($options) ) {
      $options = array();
    }
	if( !isset($options['accept_file_types']) && isset($options['fdid']) ) {
	  $fielddefs = cd_utils::get_fielddefs_by_id(TRUE,TRUE);
	  if( isset($fielddefs[$options['fdid']]) ) {
		$data = $fielddefs[$options['fdid']]['data'];
		if( $data ) {
		  $exts = explode(',',$data);
		  $str = '/\.('.implode('|',$exts).')$/i';
		  $options['accept_file_types'] = $str;
		}
	  }
	}
    parent::__construct($options);
  }

  protected function after_uploaded_file(&$fileobject)
  {
	if( !isset($fileobject->error) || $fileobject->error == '' ) {
	  $the_company = null;
	  if( isset($this->options['company']) && is_object($this->options['company']) ) {
		$the_company =& $this->options['company'];
	  }
	  else {
		$the_company = cd_company::load_by_id($this->options['compid'],TRUE);
	  }
	  if( !is_object($the_company) ) return;

	  $the_company->setup_fields_and_cats();
	  $field = $the_company->get_field($this->options['fdid']);
	  $files = array();
	  if( is_object($field) && isset($field->value) && $field->value ) {
		$files = unserialize($field->value);	  
	  }

	  if( !in_array($fileobject->name,$files) ) {
		$files[] = $fileobject->name;
		$the_company->set_field($this->options['fdid'],serialize($files));
		if( !isset($this->options['nosave']) ) {
		  $the_company->save();
		}
	  }
	}
    unset($fileobject->delete_url);
    unset($fileobject->delete_type);
  }
}

#
# EOF
#
?>
