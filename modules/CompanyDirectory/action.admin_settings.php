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
if( !isset($gCms) ) exit;
if( !$this->CheckPermission('Modify Site Preferences') ) exit;

$tab = '';
if (isset($params['active_tab'])) {
  $tab = $params['active_tab'];
  $this->SetCurrentTab($tab);
}

echo '<div class="pageoverflow" style="text-align: right; width: 80%;">'.
$this->CreateImageLink($id,'defaultadmin',$returnid,
					   $this->Lang('lbl_back'),'icons/system/back.gif',array(),'','',false).'</div><br/>';

echo $this->StartTabHeaders();
echo $this->SetTabHeader('fielddefs',$this->Lang('fielddefs'));
echo $this->SetTabHeader('categories',$this->Lang('categories'));
echo $this->SetTabHeader('hier',$this->Lang('hierarchy'));
echo $this->SetTabHeader('email_template',$this->Lang('email_template'));
echo $this->SetTabHeader('urls',$this->Lang('urls'));
echo $this->SetTabHeader('prefs',$this->Lang('preferences'));
echo $this->EndTabHeaders();

echo $this->StartTabContent();

echo $this->StartTab('fielddefs', $params);
include(__DIR__.'/function.admin_fielddefstab.php');
echo $this->EndTab();

echo $this->StartTab('categories', $params);
include(__DIR__.'/action.admin_categories_tab.php');
echo $this->EndTab();

# Hierarchy Tab
echo $this->StartTab('hier',$params);
include(__DIR__.'/action.admin_hiertab.php');
echo $this->EndTab();

# Admin Email Template Tab
echo $this->StartTab('email_template',$params);
include(__DIR__.'/function.admin_email_template_tab.php');
echo $this->EndTab();

# URLS tab
echo $this->StartTab('urls',$params);
include(__DIR__.'/function.admin_urlstab.php');
echo $this->EndTab();

# Prefs tab
echo $this->StartTab('prefs',$params);
include(__DIR__.'/function.admin_prefstab.php');
echo $this->EndTab();

echo $this->EndTabContent();

#
# EOF
#
?>