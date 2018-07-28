<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

class RealEstate extends CMSModule {

    const MANAGE_PERM = 'manage_realestate';

    /*
     * Constructor function
     */

    public final function __construct() {
        parent::__construct();
        $smarty = Smarty_CMS::get_instance();
        if (!$smarty)
            return;
        $this->SetParameters();
    }

    /**
     * Get the real name of this module.
     * @return string
     */
    public final function GetName() {
        return 'RealEstate';
    }

    public function LazyLoadAdmin() {
        return TRUE;
    }

    function GetAdminSection() {
        return 'content';
    }

    function AllowSmartyCaching() {
        return TRUE;
    }

    function LazyLoadFrontend() {
        return TRUE;
    }

    /**
     * Get a friendly (translated) name of this module.
     * @return string
     */
    public final function GetFriendlyName() {
        return $this->Lang('friendlyname');
    }

    public function GetAdminDescription() {
        return $this->Lang('admindescription');
    }

    public function VisibleToAdminUser() {
        return $this->CheckPermission(self::MANAGE_PERM);
    }

    /**
     * Get the version of this module.
     * @return string
     */
    public final function GetVersion() {
        return '1.1.0';
    }

    /**
     * Is this an module only for the CMSms backend?.
     * @return bloolean
     */
    public final function IsAdminOnly() {
        return false;
    }

    /**
     * Gets a help text for this module.
     * @return string
     */
    public final function GetHelp() {
        
    }

    /**
     * Gets the author of this module
     * @return string
     */
    public final function GetAuthor() {
        return 'Lee Peace';
    }

    /**
     * Gets the module authors email address.
     * @return string
     */
    public final function GetAuthorEmail() {
        return 'songviytuong@gmail.com';
    }

    /**
     * Get the changelog of this module
     * @return string
     */
    public final function GetChangeLog() {
        
    }

    /**
     * Get the dependencies for this module.
     * @return array
     */
    public final function GetDependencies() {
        return array();
    }

    /**
     * Is this an optional module for CMSms?
     * @return boolean
     */
    public final function IsPluginModule() {
        return true;
    }

    /**
     * Has this module an admin
     * @return boolean
     */
    public final function HasAdmin() {
        return true;
    }

    /**
     * Shall this module handle events?
     * @return boolean
     */
    public final function HandlesEvents() {
        
    }

    public function UninstallPreMessage() {
        return $this->Lang('ask_uninstall');
    }

    public function get_pretty_url($id, $action, $returnid = '', $params = array(), $inline = false) {
        if ($action != 'detail' || !isset($params['rid']))
            return;
        if (isset($params['detailtemplate']))
            return; // can't make a pretty URL

        $realestate = RealEstateItem::load_by_id((int) $params['rid']);
        if (!is_object($realestate))
            return;
        return "realestate/$returnid/{$params['rid']}/" . munge_string_to_url($realestate->title);
    }

    public function InitializeFrontend() {
        $this->RegisterModulePlugin();
        $this->RestrictUnknownParams();
        $this->SetParameterType('rid', CLEAN_INT);
        $this->SetParameterType('junk', CLEAN_STRING);
        $this->RegisterRoute('/realestate\/(?P<returnid>[0-9]+)\/(?P<rid>[0-9]+)\/(?P<junk>.*?)$/', array('action' => 'detail'));
    }

    public function InitializeAdmin() {
        $this->CreateParameter('rid', null, $this->Lang('param_rid'));
        
    }

    function SetParameters() {
        $this->RegisterModulePlugin();
        $this->RestrictUnknownParams();

        $this->CreateParameter('template', '', $this->lang('paramtemplatehelp'));
        $this->SetParameterType('template', CLEAN_STRING);
        $this->CreateParameter('detailtemplate', '', $this->lang('paramtemplatehelp'));
        $this->SetParameterType('detailtemplate', CLEAN_STRING);
    }

    function GetReals() {
        $db = cmsms()->GetDb();
        $q = "SELECT * FROM " . cms_db_prefix() . "houzez_realestate";
        $result = $db->Execute($q);
        if (!$result || ($result->NumRows() == 0)) {
            return false;
        }
        $output = array();
        while ($row = $result->FetchRow()) {
            $output[] = $row;
        }
        return $output;
    }

    function GetRealTemplates() {
        $db = cmsms()->GetDb();
        $q = "SELECT * FROM " . cms_db_prefix() . "houzez_realestate_templates";
        $result = $db->Execute($q);
        if (!$result || ($result->NumRows() == 0)) {
            return false;
        }
        $output = array();
        while ($row = $result->FetchRow()) {
            $output[] = $row;
        }
        return $output;
    }

    function GetTemplateContent($id) {
        $template = $this->GetTemplateFull($id);
        if ($template != false)
            return $template["content"];
        return false;
    }

    function GetTemplateFull($id) {
        $db = cmsms()->GetDb();
        $q = "";
        $p = array();
        if (is_numeric($id)) {
            $q = "SELECT * FROM " . cms_db_prefix() . "houzez_realestate_templates WHERE id=?";
            $p = array($id);
        } else {
            $q = "SELECT * FROM " . cms_db_prefix() . "houzez_realestate_templates WHERE name=?";
            $p = array($id);
        }
        $result = $db->Execute($q, $p);
        if (!$result || ($result->NumRows() == 0)) {
            return false;
        }
        $row = $result->FetchRow();
        return $row;
    }

}
