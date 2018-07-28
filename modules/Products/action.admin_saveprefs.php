<?php

/* -*- Mode: PHP; c-set-style: linux; tab-width: 4; c-basic-offset: 4 -*- */
#BEGIN_LICENSE
#-------------------------------------------------------------------------
# Module: Products (c) 2008-2014 by Robert Campbell
#         (calguy1000@cmsmadesimple.org)
#  An addon module for CMS Made Simple to allow users to create, manage
#  and display products in a variety of ways.
#
#-------------------------------------------------------------------------
# CMS - CMS Made Simple is (c) 2005 by Ted Kulp (wishy@cmsmadesimple.org)
# Visit the CMSMS Homepage at: http://www.cmsmadesimple.org
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
if (!isset($gCms))
    return;
if (!$this->CheckPermission('Modify Site Preferences'))
    return;

$this->SetCurrentTab('prefs');
$module_name = $this->GetName();

if (isset($params['setecomhandlers'])) {
    $this->AddEventHandler('CGEcommerceBase', 'OrderUpdated', FALSE);
    $this->SetMessage($this->Lang('msg_eventhandlers_created'));
    $this->RedirectToTab($id);
}

if (!isset($params['submit']))
    $this->RedirectToTab($id);

if (isset($params['taxable'])) {
    $this->SetPreference('default_taxable', (int) $params['taxable']);
} else {
    $this->SetPreference('default_taxable', 0);
}

if (isset($params['status'])) {
    $this->SetPreference('default_status', $params['status']);
} else {
    $this->SetPreference('default_status', 0);
}

if (isset($params['detailpage'])) {
    $this->SetPreference('detailpage', $params['detailpage']);
}

if (isset($params['hierpage'])) {
    $this->SetPreference('hierpage', $params['hierpage']);
}

if (isset($params['prettyhierurls'])) {
    $this->SetPreference('prettyhierurls', $params['prettyhierurls']);
}

if (isset($params['sortorder'])) {
    $this->SetPreference('sortorder', $params['sortorder']);
}

if (isset($params['isnotnull'])) {
    $this->SetPreference('isnotnull', $params['isnotnull']);
}

if (isset($params['summary_newdefault'])) {
    $this->SetPreference('summary_newdefault', (int) $params['summary_newdefault']);
}

if (isset($params['summary_pagelimit'])) {
    $this->SetPreference('summary_pagelimit', (int) $params['summary_pagelimit']);
}

if (isset($params['sortby'])) {
    $this->SetPreference('sortby', $params['sortby']);
}

if (isset($params['currencysymbol'])) {
    $this->SetPreference('products_currencysymbol', trim($params['currencysymbol']));
}

if (isset($params['weightunits'])) {
    $this->SetPreference('products_weightunits', trim($params['weightunits']));
}

if (isset($params['lengthunits'])) {
    $this->SetPreference('products_lengthunits', trim($params['lengthunits']));
}

if (isset($params['allowed_imagetypes'])) {
    $this->SetPreference('allowed_imagetypes', trim($params['allowed_imagetypes']));
}

if (isset($params['allowed_filetypes'])) {
    $this->SetPreference('allowed_filetypes', trim($params['allowed_filetypes']));
}
#+Lee Mle
if (isset($params["allowmle"])) {
    $this->SetPreference("allowmle", $params["allowmle"]);
    $_fields = array(
        'module_products' => array('product_name', 'details'),
        'module_products_categories' => array('name'),
    );
    $module_fields = json_encode($_fields);
    $_update = "UPDATE " . cms_db_prefix() . "modules SET sync = 1, sync_target = ? WHERE module_name = ?";
    $db->Execute($_update, array($module_fields, $module_name));
} else {
    $this->SetPreference("allowmle", '0');
    $_delete = "DELETE FROM " . cms_db_prefix() . "module_lise_modules WHERE (`module_name`= ?)";
    $db->Execute($_delete, array($module_name));
    $_update = "UPDATE " . cms_db_prefix() . "modules SET sync = 0, sync_target = '' WHERE module_name = ?";
    $db->Execute($_update, array($module_name));
}

if (isset($params['allowtravel'])) {
    $this->SetPreference('allowtravel', $params["allowtravel"]);
} else {
    $this->SetPreference('allowtravel', '0');
    $this->SetPreference('custom_modulename', '');
}
#-Lee

$this->SetPreference('feu_ownergroup', \cge_param::get_int($params, 'feu_ownergroup'));

if (isset($params['urlprefix'])) {
    if ($params['urlprefix'] != '') {
        $this->SetPreference('urlprefix', $params['urlprefix']);
    } else {
        $this->SetPreference('custom_modulename', '');
    }
}

if (isset($params['custom_modulename'])) {
    
    if ($params['custom_modulename'] != '') {
        $this->SetPreference('custom_modulename', $params['custom_modulename']);
    } else {
        $this->RemovePreference('custom_modulename');
    }
}

if (isset($params['deleteproductfiles'])) {
    $this->SetPreference('deleteproductfiles', trim($params['deleteproductfiles']));
}

$this->SetPreference('use_detailpage_for_search', (int) $params['use_detailpage_for_search']);
$this->SetPreference('usehierpathurls', (int) $params['usehierpathurls']);
$this->SetPreference('prodnotfound', trim($params['prodnotfound']));
$this->SetPreference('prodnotfoundmsg', trim($params['prodnotfoundmsg']));
$this->SetPreference('prodnotfoundpage', trim($params['prodnotfoundpage']));
$this->SetPreference('skurequired', (int) $params['skurequired']);
$this->SetTemplate('slugtemplate', \cge_param::get_string($params, 'slugtemplate'));

$this->RedirectToTab($id);

// EOF
?>