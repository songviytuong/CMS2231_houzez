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

class cd_upload_handler extends cge_uploader
{
  private $_current_value;
  private $_handle_thumbs = 1;

  public function __construct($prefix,$destdir = '') 
  {
    parent::__construct($prefix,$destdir);
	
    $mod = cge_utils::get_cge();
    $this->set_accepted_filetypes($mod->GetPreference('alloweduploadfiles'));
    $this->set_accepted_imagetypes($mod->GetPreference('imageextensions'));
    $this->set_preview($mod->GetPreference('allow_resizing',0));
    $this->set_preview_size($mod->GetPreference('resizeimage',0));
    $this->set_watermark($mod->GetPreference('allow_watermarking',0));
    $this->set_thumbnail($mod->GetPreference('allow_thumbnailing',0));
    $this->set_thumbnail_size($mod->GetPreference('thumbnailsize'));
    $this->set_delete_orig($mod->GetPreference('delete_orig_image'));
    $this->set_accepted_filetypes();
  }

  public function set_accepted_filetypes($dat = null) 
  {
    if( is_null($dat) ) {
      $cgex = cms_utils::get_module('CGExtensions');
      parent::set_accepted_filetypes($cgex->GetPreference('alloweduploadfiles'));
      return;
    }
    parent::set_accepted_filetypes($dat);
  }

  public function set_current_value($name = null)
  {
	$this->_current_value = $name;
  }

  public function handle_thumbs($flag = TRUE)
  {
	$this->_handle_thumbs = $flag;
  }

  public function delete_uploads()
  {
	if( $this->_current_value ) {
	  $tmp = array();
	  $tmp[] = cms_join_path($this->get_dest_dir(),'thumb_'.$this->_current_value);
	  $tmp[] = cms_join_path($this->get_dest_dir(),'preview_'.$this->_current_value);
	  $tmp[] = cms_join_path($this->get_dest_dir(),$this->_current_value);
	  foreach( $tmp as $fn ) {
		if( file_exists($fn) ) {
		  @unlink($fn);
		}
	  }
	}
	// todo, return something.
  }

  public function handle_upload($name,$destfilename = '',$subfield = false)
  {
	// if the file is set
	$res = $this->check_upload($name);
	if( $res ) {
	  $this->delete_uploads();

	  // handle upload...
	  return parent::handle_upload($name,$destfilename,$subfield);
	}
	return false;
  }

  public function reset()
  {
	parent::reset_errors();
	$this->_current_value = null;
  }
} // end of class

#
# EOF
#
?>