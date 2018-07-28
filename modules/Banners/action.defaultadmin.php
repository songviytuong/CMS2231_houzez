<?php
#BEGIN_LICENSE
#-------------------------------------------------------------------------
# Module: Banners (c) 2008 by Robert Campbell
#         (calguy1000@cmsmadesimple.org)
#  An addon module for CMS Made Simple to allow management, display,
#  and tracking of banner images.
#
#-------------------------------------------------------------------------
# CMS - CMS Made Simple is (c) 2005 by Ted Kulp (wishy@cmsmadesimple.org)
# This project's homepage is: http://www.cmsmadesimple.org
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
if( !$this->VisibleToAdminUser() ) exit;

echo $this->StartTabHeaders();
if( $this->CheckPermission('Banners Manager') ) {
    echo $this->SetTabHeader('banners', $this->Lang('banners'));
    echo $this->SetTabHeader('categories', $this->Lang ('categories'));
}
if( $this->CheckPermission('Modify Templates') )  {
    echo $this->SetTabHeader('bannerlist_template',$this->Lang('bannerlist_template'));
    echo $this->SetTabHeader('statreport_template',$this->Lang('statreport_template'));
}
if( $this->CheckPermission('Modify Site Preferences') ) {
    echo $this->SetTabHeader('preferences', $this->Lang('preferences'));
}
echo $this->EndTabHeaders();

echo $this->StartTabContent();

// the banners tab
if( $this->CheckPermission('Banners Manager') ) {
    echo $this->StartTab('banners',$params);
    require_once('function.DisplayBannersTab.php');
    echo $this->EndTab();

    // the categories tab
    echo $this->StartTab('categories',$params);
    require_once('function.DisplayCategoriesTab.php');
    echo $this->EndTab();
}

// the banner list tab.
if( $this->CheckPermission('Modify Templates') ) {
    echo $this->StartTab('bannerlist_template',$params);
    include('function.bannerlist_template_tab.php');
    echo $this->EndTab();

    echo $this->StartTab('statreport_template',$params);
    include('function.statreport_template_tab.php');
    echo $this->EndTab();
}

// the preferences tab
if( $this->CheckPermission('Modify Site Preferences') ) {
    echo $this->StartTab('preferences',$params);
    require_once('function.DisplayPrefsTab.php');
    _DisplayPrefsTab($this, $id, $params, $returnid );
    echo $this->EndTab();
}

// done tabs
echo $this->EndTabContent();
