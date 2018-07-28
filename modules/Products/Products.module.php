<?php

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

define('PRODUCTS_PREF_NEWSUMMARY_TEMPLATE', 'products_pref_newsummary_template');
define('PRODUCTS_PREF_DFLTSUMMARY_TEMPLATE', 'products_pref_dfltsummary_template');
define('PRODUCTS_PREF_NEWDETAIL_TEMPLATE', 'products_pref_newdetail_template');
define('PRODUCTS_PREF_DFLTDETAIL_TEMPLATE', 'products_pref_dfltdetail_template');
define('PRODUCTS_PREF_NEWCATEGORYLIST_TEMPLATE', 'products_pref_newcategorylist_template');
define('PRODUCTS_PREF_DFLTCATEGORYLIST_TEMPLATE', 'products_pref_dfltcategorylist_template');
define('PRODUCTS_PREF_NEWBYHIERARCHY_TEMPLATE', 'products_pref_newbyhierarchy_template');
define('PRODUCTS_PREF_DFLTBYHIERARCHY_TEMPLATE', 'products_pref_dfltbyhierarchy_template');
define('PRODUCTS_PREF_NEWSEARCH_TEMPLATE', 'products_pref_newsearch_template');
define('PRODUCTS_PREF_DFLTSEARCH_TEMPLATE', 'products_pref_dfltsearch_template');

final class Products extends CGExtensions {

    /**
     * @ignore
     */
    private $_admin_loaded;

    /**
     * @ignore
     */
    private $_price_adjuster;

    /**
     * @ignore
     */
    public function __construct() {
        parent::__construct();
        $smarty = Smarty_CMS::get_instance();
        if (!$smarty)
            return;

        $this->AddImageDir('icons');
        $this->_admin_loaded = false;

        $smarty->registerClass('product_ops', 'product_ops');
        $smarty->register_function('products_getcategory', array($this, '_smarty_products_getcategory'));
        $smarty->register_function('products_gethierarchy', array($this, '_smarty_products_gethierarchy'));
        $smarty->register_function('products_hierarchy_breadcrumb', array($this, '_smarty_products_hierarchy_breadcrumb'));
        $smarty->register_function('products_hierarchy_parent', array($this, '_smarty_products_hierarchy_parent'));

        global $CMS_ADMIN_PAGE;
        try {
            // todo: this should go in a hook.
            // making this stuff into static routes would allow lazy loading the Products module and save exactly one query.
            $db = CmsApp::get_instance()->GetDb();
            $qparms = array('');
            $query = 'SELECT id,url FROM ' . cms_db_prefix() . 'module_products WHERE url != ?';
            if (!isset($CMS_ADMIN_PAGE)) {
                // for non admin requests we only need to register routes to published articles.
                $query .= ' AND status = ?';
                $qparms[] = 'published';
            }
            $tmp = $db->GetArray($query, $qparms);

            if (is_array($tmp)) {
                $prefix = trim($this->GetPreference('urlprefix'));
                if ($prefix)
                    $prefix .= '/';
                $detailpage = $this->GetPreference('detailpage', -1);
                if ($detailpage < 1) {
                    $contentops = ContentOperations::get_instance();
                    $detailpage = $contentops->GetDefaultContent();
                }
                foreach ($tmp as $one) {
                    $parms = array('action' => 'details', 'returnid' => $detailpage, 'productid' => $one['id']);
                    $route = new CmsRoute($prefix . $one['url'], $this->GetName(), $parms, TRUE);
                    cms_route_manager::register($route);
                }
            }
        } catch (\Exception $e) {
            // ignore
        }

        \CMSMS\HookManager::add_hook('FrontEndUsers::OnDeleteUser', function($params) {
            $id = \cge_param::get_int($params, 'id');
            if ($id < 1)
                return;

            if ($this->GetProductStorage()->count_owner_products($id))
                throw new \RuntimeException($this->Lang('error_deleteuser'));
        });
    }

    public function GetName() {
        return 'Products';
    }

    public function GetFriendlyName() {
        if ($this->GetPreference('custom_modulename')) {
            return $this->GetPreference('custom_modulename');
        } else {
            return $this->Lang('product_manager');
        }
    }

    public function AllowAutoInstall() {
        return FALSE;
    }

    public function AllowAutoUpgrade() {
        return FALSE;
    }

    public function IsPluginModule() {
        return true;
    }

    public function HasAdmin() {
        return TRUE;
    }

    public function GetVersion() {
        return '2.28.3.1';
    }

    public function MinimumCMSVersion() {
        return '2.2.2';
    }

    public function GetAdminDescription() {
        return $this->Lang('module_description');
    }

    public function UninstallPostMessage() {
        return $this->Lang('postuninstall');
    }

    public function UninstallPreMessage() {
        return $this->Lang('preuninstall');
    }

    public function GetAdminSection() {
        return 'content';
    }

    public function GetAuthor() {
        return 'calguy1000';
    }

    public function GetAuthorEmail() {
        return 'calguy1000@cmsmadesimple.org';
    }

    public function GetEventDescription($eventname) {
        return $this->lang('eventdesc-' . $eventname);
    }

    public function GetEventHelp($eventname) {
        return $this->lang('eventhelp-' . $eventname);
    }

    public function HandlersEvents() {
        return TRUE;
    }

    public function AllowSmartyCaching() {
        return TRUE;
    }

    public function LazyLoadFrontend() {
        return FALSE;
    }

    public function LazyLoadAdmin() {
        return TRUE;
    }

    public function InstallPostMessage() {
        return $this->Lang('postinstall');
    }

    function GetDependencies() {
        return array('CGExtensions' => '1.56.2', 'CGSimpleSmarty' => '2.1.6', 'JQueryTools' => '1.4');
    }

    function VisibleToAdminUser() {
        return $this->CheckPermission('Modify Products') || $this->CheckPermission('Modify Site Preferences');
    }

    public function HasCapability($capability, $params = array()) {
        switch ($capability) {
            case CmsCoreCapabilities::PLUGIN_MODULE:
            case CmsCoreCapabilities::ADMINSEARCH:
                return TRUE;
        }
        return FALSE;
    }

    public function get_adminsearch_slaves() {
        return [ '\Products\AdminSearch_sl'];
    }

    function GetHeaderHTML() {
        $use_ssl = false;
        if (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] == 'on')
            $use_ssl = true;
        $config = cmsms()->GetConfig();
        $smarty = cmsms()->GetSmarty();
        $modulename = $this->GetName();
        $moduledir = $this->GetParentURLPath($use_ssl);
        $admindir = $config['admin_url'];
        $userkey = get_secure_param();

        $smarty->assign('moduledir', $moduledir);
        $smarty->assign('userkey', $userkey);
        $smarty->assign('admindir', $admindir);
        $smarty->assign('modulename', $modulename);

        $txt = parent::GetHeaderHTML();
        $obj = cge_utils::get_module('JQueryTools', '1.2.6');
        if (is_object($obj)) {
            $tmpl = <<<EOT
{JQueryTools action='require' lib='tablesorter,jquerytools,fancybox'}
{JQueryTools action='placemarker'}
EOT;
            $txt .= $this->ProcessTemplateFromData($tmpl);
        }
        $txt .= <<<EOT
<script type="text/javascript">
$(document).ready(function(){
  $('ul.option-menu-horiz').menu({ position: { my: "left top", at: "left-1 bottom+2" } });
});
</script>
EOT;

        $globals_js = ($use_ssl ? $config['ssl_url'] : $config['root_url']) . '/modules/' . LISE . '/lib/js/';
        $globals_css = ($use_ssl ? $config['ssl_url'] : $config['root_url']) . '/modules/' . LISE . '/lib/css/';
        $framework_js = ($use_ssl ? $config['ssl_url'] : $config['root_url']) . '/modules/' . LISE . '/framework/js/';
        $framework_css = ($use_ssl ? $config['ssl_url'] : $config['root_url']) . '/modules/' . LISE . '/framework/css/';

        $txt .= <<<EOT
<link type="text/css" rel="stylesheet" href="{$globals_css}lise-globals.css" />  
<link type="text/css" rel="stylesheet" href="{$framework_css}colorbox.css" />
<script type="text/javascript" src="{$globals_js}lise-globals.js"></script>
<script type="text/javascript" src="{$framework_js}jquery.colorbox.js"></script>
EOT;

        return $txt;
    }

    public function InitializeFrontend() {
        $this->RegisterModulePlugin();
        $this->RestrictUnknownParams();

        $this->SetParameterType('productid', CLEAN_INT);
        $this->SetParameterType('detailpage', CLEAN_STRING);
        $this->SetParameterType('categorylisttemplate', CLEAN_STRING);
        $this->SetParameterType('categorylistdtltemplate', CLEAN_STRING);
        $this->SetParameterType('detailtemplate', CLEAN_STRING);
        $this->SetParameterType('summarytemplate', CLEAN_STRING);
        $this->SetParameterType('hierarchytemplate', CLEAN_STRING);
        $this->SetParameterType('hierarchypage', CLEAN_STRING);
        $this->SetParameterType('sortby', CLEAN_STRING);
        $this->SetParameterType('sortorder', CLEAN_STRING);
        $this->SetParameterType('sorttype', CLEAN_STRING);
        $this->SetParameterType('isnotnull', CLEAN_STRING);
        $this->SetParameterType('excludecat', CLEAN_STRING);
        $this->SetParameterType('notpretty', CLEAN_STRING);
        $this->SetParameterType('category', CLEAN_STRING);
        $this->SetParameterType('categoryname', CLEAN_STRING);
        $this->SetParameterType('hierarchy', CLEAN_STRING);
        $this->SetParameterType('pagelimit', CLEAN_INT);
        $this->SetParameterType('parent', CLEAN_INT);
        $this->SetParameterType('owner', CLEAN_INT);
        $this->SetParameterType('parents', CLEAN_STRING);
        $this->SetParameterType('showall', CLEAN_INT);
        $this->SetParameterType('field', CLEAN_STRING);
        $this->SetParameterType('fieldid', CLEAN_INT);
        $this->SetParameterType('fieldval', CLEAN_STRING);
        $this->SetParameterType('categoryfield', CLEAN_STRING);
        $this->SetParameterType('inline', CLEAN_INT);
        $this->SetParameterType('resultpage', CLEAN_STRING);
        $this->SetParameterType('searchformtemplate', CLEAN_STRING);
        $this->SetParameterType('searchfield', CLEAN_STRING);
        $this->SetParameterType('summarypage', CLEAN_STRING);
        $this->SetParameterType('junk', CLEAN_STRING);
        $this->SetParameterType('page', CLEAN_INT);
        $this->SetParameterType('alias', CLEAN_STRING);
        $this->SetParameterType('hierarchyid', CLEAN_INT);
        $this->SetParameterType('categoryid', CLEAN_INT);
        $this->SetParameterType('productlist', CLEAN_NONE);
        $this->SetParameterType('nochildren', CLEAN_INT);
        $this->SetParameterType(CLEAN_REGEXP . '/cd_.*/', CLEAN_STRING);

        // Friendly URL stuff
        $detailpage = $this->GetPreference('detailpage', -1);
        if ($detailpage == -1) {
            $contentops = cmsms()->GetContentOperations();
            $detailpage = $contentops->GetDefaultPageID();
        }
        $str = '/^' . $this->GetPreference('urlprefix', '[Pp]roducts');
        if ($this->GetPreference('usehierpathurls')) {
            $this->RegisterRoute($str . '\/details\/(?P<returnid>[0-9]+)\/([^\/]+\/)+(?P<alias>.*)$/', array('action' => 'details', 'returnid' => $detailpage));
            $this->RegisterRoute($str . '\/details\/([^\/]+\/)+(?P<alias>.*)$/', array('action' => 'details', 'returnid' => $detailpage));
        }

        // detail view
        $this->RegisterRoute($str . '\/(?P<productid>[0-9]+)\/(?P<returnid>[0-9]+)\/(?P<junk>.*?)$/', array('action' => 'details'));
        $this->RegisterRoute($str . '\/(?P<productid>[0-9]+)\/(?P<junk>.*?)$/', array('action' => 'details', 'returnid' => $detailpage));
        // $this->RegisterRoute($str.'\/(?P<productid>[0-9]+)$/'); broken?
        // view category list
        $this->RegisterRoute($str . '\/viewcategory\/(?P<categoryid>[0-9]+)\/(?P<returnid>[0-9]+)$/', array('action' => 'categorylist'));

        // default views.... used?
        $this->RegisterRoute($str . '\/summary\/($P<returnid>[0-9]+)\/(?P<junk>.*?)$/');
        $this->RegisterRoute($str . '\/summary\/($P<returnid>[0-9]+)$/');

        // viewing summary view of products by category
        $this->RegisterRoute($str . '\/bycategory\/(?P<categoryid>[0-9]+)\/(?P<returnid>[0-9]+)\/(?P<junk>.*?)$/');
        $this->RegisterRoute($str . '\/bycategory\/(?P<categoryid>[0-9]+)\/(?P<returnid>[0-9]+)$/');

        // viewing summary view of products by hierarchy
        $this->RegisterRoute($str . '\/byhierarchy\/(?P<hierarchyid>[0-9]+)\/(?P<returnid>[0-9]+)\/(?P<junk>.*?)$/');
        $this->RegisterRoute($str . '\/byhierarchy\/(?P<hierarchyid>[0-9]+)\/(?P<returnid>[0-9]+)$/');

        // for viewing the product hierarchy
        $hierpage = $this->GetPreference('hierpage', -1);
        if ($hierpage <= 0)
            $hierpage = $detailpage;
        $this->RegisterRoute($str . '\/hierarchy\/(?P<parent>[0-9]+)\/(?P<returnid>[0-9]+)$/');
        $this->RegisterRoute($str . '\/hierarchy\/(?P<parent>[0-9]+)\/(?P<returnid>[0-9]+)\/(?P<junk>.*?)$/');
        $this->RegisterRoute($str . '\/hierarchy\/(?P<parent>[0-9]+)\/(?P<junk>.*?)$/', array('action' => 'hierarchy', 'returnid' => $hierpage));
    }

    public function InitializeAdmin() {
        $this->CreateParameter('action', 'default', $this->Lang('param_action'));
        $this->CreateParameter('productid', '', $this->Lang('param_productid'));
        $this->CreateParameter('owner', '', $this->Lang('param_owner'));
        $this->CreateParameter('detailpage', '', $this->Lang('param_detailpage'));
        $this->CreateParameter('categorylisttemplate', '', $this->Lang('param_categorylisttemplate'));
        $this->CreateParameter('categorylistdtltemplate', '', $this->Lang('param_categorylistdtltemplate'));
        $this->CreateParameter('detailtemplate', '', $this->Lang('param_detailtemplate'));
        $this->CreateParameter('summarytemplate', '', $this->Lang('param_summarytemplate'));
        $this->CreateParameter('hierarchytemplate', '', $this->Lang('param_hierarchytemplate'));
        $this->CreateParameter('hierarchypage', '', $this->Lang('param_hierarchypage'));
        $this->CreateParameter('sortby', 'product_name', $this->Lang('param_sortby'));
        $this->CreateParameter('sortorder', 'asc', $this->Lang('param_sortorder'));
        $this->CreateParameter('sorttype', '', $this->Lang('param_sorttype'));
        $this->CreateParameter('isnotnull', '', $this->Lang('param_isnotnull'));
        $this->CreateParameter('excludecat', '', $this->Lang('param_excludecat'));
        $this->CreateParameter('notpretty', '', $this->Lang('param_notpretty'));
        $this->CreateParameter('category', '', $this->Lang('param_category'));
        $this->CreateParameter('hierarchy', '', $this->Lang('param_hierarchy'));
        $this->CreateParameter('hierarchyid', '', $this->Lang('param_hierarchyid'));
        $this->CreateParameter('pagelimit', '', $this->Lang('param_pagelimit'));
        $this->CreateParameter('parent', '', $this->Lang('param_parent'));
        $this->CreateParameter('parents', '', $this->Lang('param_parents'));
        $this->CreateParameter('showall', '', $this->Lang('param_showall'));
        $this->CreateParameter('field', '', $this->Lang('param_field'));
        $this->CreateParameter('fieldid', '', $this->Lang('param_fieldid'));
        $this->CreateParameter('fieldval', '', $this->Lang('param_fieldval'));
        $this->CreateParameter('categoryfield', '', $this->Lang('param_categoryfield'));
        $this->CreateParameter('inline', 0, $this->Lang('param_inline'));
        $this->CreateParameter('resultpage', '', $this->Lang('param_resultpage'));
        $this->CreateParameter('searchformtemplate', '', $this->Lang('param_searchformtemplate'));
        $this->CreateParameter('searchfield', '', $this->Lang('param_searchfield'));
        $this->CreateParameter('summarypage', $this->Lang('param_summarypage'));
        $this->CreateParameter('productlist', $this->Lang('param_productlist'));
        $this->CreateParameter('nochildren', $this->Lang('param_nochildren'));
    }

    /**
     * @ignore
     */
    protected function _load_admin() {
        if (!$this->_admin_loaded) {
            require_once(__DIR__ . '/functions.admin_tools.php');
            $this->_admin_loaded = true;
        }
    }

    /**
     * @ignore
     */
    public function GetProductStorage() {
        static $obj;
        if (!$obj)
            $obj = new \Products\ProductStorage($this, \cge_utils::get_db());
        return $obj;
    }

    /**
     * @ignore
     * @deprecated
     */
    protected function GetTypesDropdown($id, $name, $selected = '', $addtext = '', $selectone = false) {
        $this->_load_admin();
        return products_GetTypesDropdown($this, $id, $name, $selected, $addtext, $selectone);
    }

    /**
     * @ignore
     * @deprecated
     */
    function &GetCategory($category_id, $full = false) {
        $gCms = cmsms();
        $db = $gCms->GetDb();
        $config = $gCms->GetConfig();

        $query = 'SELECT * FROM ' . cms_db_prefix() . 'module_products_categories WHERE id = ?';
        $query2 = 'SELECT * FROM ' . cms_db_prefix() . 'module_products_category_fields WHERE category_id = ?';

        $row = $db->GetRow($query, array($category_id));
        if (!$row)
            return FALSE;

        $onerow = new stdClass();
        $onerow->id = $row['id'];
        $onerow->name = $row['name'];
        $onerow->value = false;
        $onerow->file_location = product_utils::get_category_upload_url($onerow->id);

        if ($full) {
            $tmp2 = $db->GetArray($query2, array($row['id']));
            if (is_array($tmp2))
                $onerow->data = $tmp2;
        }

        return $onerow;
    }

    public function RegisterEvents() {
        $this->AddEventHandler('Products', 'ProductSave', false);
    }

    function SearchResult($returnid, $productid, $attr = '') {
        return product_ops::get_search_result($returnid, $productid, $attr);
    }

    function SearchReindex(&$module) {
        $this->_load_admin();
        return products_SearchReindex($this, $module);
    }

    public function GetSearchableText(\Products\Product $product) {
        if ($product->status != $product::STATUS_PUBLISHED)
            return [];

        $fielddefs = product_utils::get_fielddefs(true);
        $results = array();
        $results[] = $product->name;
        $results[] = strip_tags($product->details);
        $results[] = $product->sku;
        $results[] = $product->alias;
        $fieldvals = $product->field_vals;
        if (count($fielddefs)) {
            foreach ($fielddefs as $onedef) {
                if ($onedef->public)
                    continue;
                if (!isset($fieldvals[$onedef->id]))
                    continue;

                switch ($onedef->type) {
                    case 'textbox':
                    case 'textarea':
                    case 'dropdown':
                        if (isset($onedef->value))
                            $results[] = $onedef->value;
                        break;
                }
            }
        }
        foreach ($product->attribs as $attrib) {
            $results[] = strip_tags($row->text);
            $results[] = $row->sku;
        }
        return $results;
    }

    // deprecated, move to ops
    // internal
    public function UpdateHierarchyPositions() {
        return product_utils::update_hierarchy_positions();
    }

    // deprecated, move to ops
    // internal
    public function BuildHierarchyList() {
        return array_flip(hierarchy_ops::build_hierarchy_list());
    }

    // deprecated, move to ops
    function CreateHierarchyDropdown($id, $name, $selectedvalue) {
        $tmp = $this->BuildHierarchyList();
        $tmp = array_merge(array($this->Lang('any') => ''), $tmp);
        return $this->CreateInputDropdown($id, $name, $tmp, -1, $selectedvalue);
    }

    public function get_pretty_url($id, $action, $returnid = '', $params = array(), $inline = false) {
        if ($inline || !product_utils::can_do_pretty($action, $params))
            return;
        $prettyurl = null;

        switch ($action) {
            case 'detail':
            case 'details':
                // if we got here, then either pretty urls are not enabled... or something is wrong
                return;

            case 'default':
                if (isset($params['categoryid'])) {
                    // if the category id parameter is set, use bycategory
                    $prettyurl = sprintf("%s/bycategory/%d/%d", $this->GetPreference('urlprefix', 'products'), (int) $params['categoryid'], $returnid);
                    if (isset($params['categoryname']))
                        $prettyurl .= '/' . munge_string_to_url($params['categoryname']);
                }
                else if (isset($params['hierarchyid'])) {
                    // if the hierarchy id parameter is set, use byhierarchy
                    $nochildren = \cge_param::get_bool($params, 'nochildren');
                    if ($nochildren) {
                        // do not want children, no pretty url.
                    } else {
                        $prettyurl = sprintf("%s/byhierarchy/%d/%d", $this->GetPreference('urlprefix', 'products'), (int) $params['hierarchyid'], $returnid);
                    }
                } else if (isset($params['fieldid'])) {
                    // no pretty urls for this atm.
                } else if (\cge_param::exists($params, 'page')) {
                    // no pretty urls for pagination
                } else {
                    // otherwise use summary
                    $prettyurl = sprintf("%s/summary/%d", $this->GetPreference('urlprefix', 'products'), $returnid);
                }
                break;

            case 'categorylist':
                if (isset($params['categoryid']) && !isset($params['categorylistdtltemplate'])) {
                    $prettyurl = sprintf("%s/viewcategory/%s/%s", $this->GetPreference('urlprefix', 'products'), (int) $params['categoryid'], $returnid);
                }
                break;

            case 'hierarchy':
                $nochildren = cge_utils::to_bool(cge_utils::get_param($params, 'nochildren', 0));
                if (!$nochildren) {
                    $prettyurl = sprintf('%s/hierarchy/%d', $this->GetPreference('urlprefix', 'products'), (int) $params['parent']);
                    if ($this->GetPreference('hierpage', -1) == -1) {
                        // use returnid in the link.
                        $prettyurl .= '/' . $returnid;
                    }
                    if ($this->GetPreference('prettyhierurls', 0)) {
                        // add the name to the url.
                        $info = hierarchy_ops::get_hierarchy_info($params['parent']);
                        if (is_array($info))
                            $prettyurl .= '/' . munge_string_to_url($info['name']);
                    }
                    break;
                }
        } // switch

        return $prettyurl;
    }

    // deprecated
    function GetHierarchyInfo($hierarchy_id) {
        return hierarchy_ops::get_hierarchy_info($hierarchy_id);
    }

    // deprecated
    function GetHierarchyPath($hierarchy_id) {
        return hierarchy_ops::get_hierarchy_path($hierarchy_id);
    }

    // deprecated
    function GetProductHierarchyPath($productid) {
        return product_ops::get_product_hierarchy_path($productid);
    }

    /**
     * @ignore
     */
    public function GetProductById($product_id) {
        return $this->GetProductStorage()->get_by_id($product_id);
    }

    /**
     * @ignore
     * @deprecated
     */
    function DeleteProduct($product_id) {
        // note: now no longer update search
        return $this->GetProductStorage()->delete_by_id($product_id);
    }

    function _smarty_products_getcategory($params, &$smarty) {
        if (!isset($params['categoryid']))
            return;

        $catid = (int) $params['categoryid'];
        $obj = $this->GetCategory($catid, true);

        if (isset($params['assign'])) {
            $smarty->assign($params['assign'], $obj);
            return;
        }
        return $obj;
    }

    function _smarty_products_gethierarchy($params, &$smarty) {
        $id = \cge_param::get_int($params, 'id');
        if ($id < 1)
            return;

        $obj = hierarchy_ops::get_hierarchy_info($id);

        if (isset($params['assign'])) {
            $smarty->assign($params['assign'], $obj);
            return;
        }
        return $obj;
    }

    function _smarty_products_hierarchy_breadcrumb($params, &$smarty) {
        if (!isset($params['hierarchyid']))
            return;
        $returnid = $this->GetPreference('hierpage');
        if ($returnid <= 0)
            $returnid = cms_utils::get_current_pageid();
        if (isset($params['pageid'])) {
            $tmp = $this->resolve_alias_or_id($params['pageid']);
            if ($tmp)
                $returnid = $tmp;
        }
        $delim = ' &raquo; ';
        if (isset($params['delim']))
            $delim = $params['delim'];

        $hierid = (int) $params['hierarchyid'];
        $bc = hierarchy_ops::get_breadcrumb('prod', $hierid, $returnid, $delim);

        if (isset($params['assign'])) {
            $smarty->assign($params['assign'], $bc);
            return;
        }
        return $bc;
    }

    function _smarty_products_hierarchy_parent($params, &$smarty) {
        if (!isset($params['hierarchyid']))
            return;
        $hid = (int) $params['hierarchyid'];
        $info = hierarchy_ops::get_hierarchy_info($hid);
        if (!is_array($info))
            return;

        if (isset($params['assign'])) {
            $smarty->assign($params['assign'], $info['parent_id']);
            return;
        }
        return $info['parent_id'];
    }

    /**
     * @ignore
     */
    function get_product_info($product_id) {
        $product_id = (int) $product_id;
        if ($product_id < 1)
            throw new \LogicException('Invalid product_id passed to ' . __METHOD__);

        $product = $this->GetProductStorage()->get_by_id($product_id, true);
        if (!$product)
            return;
        if ($product->status != $product::STATUS_PUBLISHED)
            throw new \LogicException('Cannot get ecomm product information for an unpublished product');

        $out = product_utils::product_to_ecomm_productinfo($product);
        return $out;
    }

    /**
     * @ignore
     */
    function get_product_by_sku($sku) {
        $sku = trim($sku);
        if (!$sku)
            throw new \LogicException('Invalid sku passed to ' . __METHOD__);

        $product = $this->GetProductStorage()->get_by_any_sku($sku, true);
        if (!$product)
            return;
        if ($product->status != $product::STATUS_PUBLISHED)
            throw new \LogicException('Cannot get ecomm product information for an unpublished product');

        $out = product_utils::product_to_ecomm_productinfo($product);
        return $out;
    }

    /**
     * @ignore
     */
    public static function tpl_type_lang_cb($str) {
        $mod = \cms_utils::get_module('Products');
        $str = str_replace(' ', '_', $str);
        if (is_object($mod))
            return $mod->Lang('tpltype_' . $str);
    }

    /**
     * @ignore
     */
    public static function tpl_type_reset_cb(CmsLayoutTemplateType $type) {
        $mod = \cms_utils::get_module('Products');
        if ($type->get_originator() != $mod->GetName())
            throw new CmsLogicException('Cannot reset contents for this template type');

        $fn = null;
        switch ($type->get_name()) {
            case 'List View':
                $fn = 'orig_summary_template.tpl';
                break;
            case 'Detail View':
                $fn = 'orig_detail_template.tpl';
                break;
            case 'Hierarchy View':
                $fn = 'orig_byhierarchy_template.tpl';
                break;
            case 'Category View':
                $fn = 'orig_categorylist_template.tpl';
                break;
            case 'Search':
                $fn = 'orig_search_template.tpl';
                break;
        }

        if (!$fn)
            return;
        $fn = __DIR__ . '/templates/' . $fn;
        if (file_exists($fn))
            return @file_get_contents($fn);
    }

    public function set_price_adjuster(\Products\PriceAdjuster $adjuster) {
        if ($this->_price_adjuster)
            return;
        $this->_price_adjuster = $adjuster;
    }

    public function get_adjusted_price(\Products\Product $product, $value) {
        $value = (float) $value;
        if ($this->_price_adjuster)
            return $this->_price_adjuster->get_adjusted_price($product, $value);
        return $value;
    }

}

// class

#
# EOF
#
