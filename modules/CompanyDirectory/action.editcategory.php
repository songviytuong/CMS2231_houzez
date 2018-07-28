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
if (!$this->CheckPermission('Modify Company Directory')) return;
$this->SetCurrentTab('categories');

if (isset($params['cancel'])) {
  $this->RedirectToTab($id,'','','admin_settings');
}

$catid = $category = null;
try {
  $catid = (int)cge_utils::get_param($params,'catid');
  $category = new cd_category();
  if( $catid > 0 ) $category = cd_category::load($catid);

  if( isset($params['submit']) ) {
      $category['name'] = cge_utils::get_param($params,'name');
      $category['parent_id'] = (int)cge_utils::get_param($params,'parent_id');
      $category['description'] = cge_utils::get_param($params,'description');
      $category['extra1'] = cge_utils::get_param($params,'extra1');
      $category['extra2'] = cge_utils::get_param($params,'extra2');
      $category['extra3'] = cge_utils::get_param($params,'extra3');

      // todo: handle category image
      $category->save();

      // and done...
      $this->SetMessage($this->Lang('msg_categorysaved'));
      $this->RedirectToTab($id,'','','admin_settings');
  }

}
catch( Exception $e ) {
    echo $this->ShowErrors($e->GetMessage());
}

// give everything to smarty
$parms = array();
if( isset($params['catid']) ) $parms['catid'] = (int)$params['catid'];
$smarty->assign('startform', $this->CGCreateFormStart($id, 'editcategory', $returnid,$parms));
$smarty->assign('endform', $this->CreateFormEnd());
$smarty->assign('category',$category);

$categories = array(-1=>$this->Lang('none'));
$tmp = cd_category::get_list();
if( is_array($tmp) && count($tmp) ) {
    foreach( $tmp as $key => $val ) {
        $categories[$key] = $val;
    }
}
$smarty->assign('categories',$categories);
echo $this->ProcessTemplate('editcategory.tpl');

?>
