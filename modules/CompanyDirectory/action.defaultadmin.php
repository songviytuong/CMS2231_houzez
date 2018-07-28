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
if( !$this->VisibleToAdminUser() ) return;

$tab = '';
if (isset($params['active_tab'])) {
    $tab = $params['active_tab'];
    $this->SetCurrentTab($tab);
}

// the top nav bar
if( $this->CheckPermission('Modify Templates') || $this->CheckPermission('Modify Site Preferences') ) {
    echo '<div class="pageoverflow" style="text-align: right; width: 80%;">';
    if( $this->CheckPermission('Modify Site Preferences') ) {
        echo $this->CreateImageLink($id,'admin_settings',$returnid, $this->Lang('lbl_settings'),
                                    'icons/topfiles/preferences.gif',array(),'','',false);
    }
    if( $this->CheckPermission('Modify Templates') ) {
        echo $this->CreateImageLink($id,'admin_templates',$returnid, $this->Lang('lbl_templates'),
                                    'icons/topfiles/template.gif',array(),'','',false);
    }
    echo '</div>';
}

$collectstats = $this->GetPreference('collectstats',0);

if( !$collectstats ) {
    include(__DIR__.'/function.admin_companiestab.php');
}
else {
    echo $this->StartTabHeaders();
    if ($this->CheckPermission('Modify Company Directory')) {
        echo $this->SetTabHeader('companies',$this->Lang('companies'));
        echo $this->SetTabHeader('searches',$this->Lang('searches'));
    }
    echo $this->EndTabHeaders();

    echo $this->StartTabContent();
    if ($this->CheckPermission('Modify Company Directory')) {
        echo $this->StartTab('companies', $params);
        include(__DIR__.'/function.admin_companiestab.php');
        echo $this->EndTab();
    }

    if( $this->GetPreference('collectstats',0) ) {
        echo $this->StartTab('searches', $params);
        include(__DIR__.'/function.admin_searchestab.php');
        echo $this->EndTab();
    }
    echo $this->EndTabContent();
}
