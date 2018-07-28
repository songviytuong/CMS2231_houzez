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
if( !isset( $gCms ) ) return;
if( !$this->CheckPermission('Modify Site Preferences') ) return;
if( !isset( $params['submit'] ) ) $this->RedirectToTab($id,'prefs','','admin_settings');

if( isset($params['detailpage']) ) $this->SetPreference('detailpage',$params['detailpage']);
if( isset($params['sortorder']) ) $this->SetPreference('sortorder',$params['sortorder']);
if( isset($params['sortby']) ) $this->SetPreference('sortby',$params['sortby']);

$this->SetPreference('collectstats',$params['collectstats']);
$this->SetPreference('allow_duplicate_companynames',(int)$params['allow_duplicate_companynames']);
$this->SetPreference('prepend_website_http',(int)$params['prepend_website_http']);
$this->SetPreference('adminwysiwyg',(int)$params['adminwysiwyg']);

if( isset($params['frontendcreate']) ) {
  $this->SetPreference('frontend_create',(int)$params['frontendcreate']);
  $this->SetPreference('frontend_delete',(int)$params['frontenddelete']);
  $this->SetPreference('frontend_numrecords',(int)$params['frontendnumrecords']);
  $this->SetPreference('frontend_newstatus',$params['frontendnewstatus']);
  $this->SetPreference('frontend_changestatus',$params['frontendchangestatus']);
  $this->SetPreference('frontend_import',$params['frontendimport']);

  $this->SetPreference('frontend_showexpired',$params['frontend_showexpired']);
  $this->SetPreference('frontend_emailonadd',$params['frontend_emailonadd']);
  $this->SetPreference('frontend_emailonedit',$params['frontend_emailonedit']);
  $this->SetPreference('frontend_emailgroup',$params['frontend_emailgroup']);
}

$this->SetMessage($this->Lang('msg_settings_changed'));
$this->RedirectToTab($id,'prefs','','admin_settings');

// EOF
?>