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
if( !isset($gCms)) exit;
if( !$this->CheckPermission('Modify Site Preferences') ) exit;
$this->SetCurrentTab('hier');

try {
  $catid = (int) cge_utils::get_param($params,'catid');
  if( $catid < 1 ) throw new CmsException($this->Lang('error_missingparam'));

  $query = 'SELECT count(id) FROM '.cms_db_prefix().'module_compdir_hier WHERE parent_id = ?';
  $tmp = $db->GetOne($query,array($catid));
  if( $tmp > 0 ) throw new CmsException($this->Lang('error_deleteparent'));

  // Get the category details
  $query = 'SELECT * FROM '.cms_db_prefix().'module_compdir_hier WHERE id = ?';
  $row = $db->GetRow( $query, array( $catid ) );
  if( !$row ) throw new CmsException($this->Lang('error_noresultsfound'));

  // Reset all categories using this parent to have no parent (-1)
  $query = 'UPDATE '.cms_db_prefix().'module_compdir_hier SET parent_id=? WHERE parent_id=?';
  $db->Execute($query, array(-1, $catid));

  // Now remove the category
  $query = "DELETE FROM ".cms_db_prefix()."module_compdir_hier WHERE id = ?";
  $db->Execute($query, array($catid));

  // And remove it from any articles
  $query = "UPDATE ".cms_db_prefix()."module_compdir_companies SET hier_id = -1 WHERE hier_id = ?";
  $db->Execute($query, array($catid));

  $this->UpdateHierarchyPositions();
  $this->SetMessage($this->Lang('msg_hierdeleted'));
}
catch( Exception $e ) {
  $this->SetError($e->GetMessage());
}
$this->RedirectToTab($id, '', '', 'admin_settings');

#
# EOF
#
?>