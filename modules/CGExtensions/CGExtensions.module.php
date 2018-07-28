<?php
#BEGIN_LICENSE
#-------------------------------------------------------------------------
# Module: CGExtensions (c) 2008-2014 by Robert Campbell
#         (calguy1000@cmsmadesimple.org)
#  An addon module for CMS Made Simple to provide useful functions
#  and commonly used gui capabilities to other modules.
#
#-------------------------------------------------------------------------
# CMSMS - CMS Made Simple is (c) 2005 by Ted Kulp (wishy@cmsmadesimple.org)
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

/**
 * A base class for all CMSMS modules written by me to provide optimizations and
 * conveniences that are not built into CMSMS.
 *
 * Some of these functions and tools have, over time made their way in one way, shape
 * or form into the core.  However, many have not, and will not.
 *
 * @package CGExtensions
 */

if( defined('CGEXTENSIONS_TABLE_COUNTRIES') ) return;

/**
 * @ignore
 */
define('CGEXTENSIONS_TABLE_COUNTRIES',cms_db_prefix().'module_cge_countries');

/**
 * @ignore
 */
define('CGEXTENSIONS_TABLE_STATES',cms_db_prefix().'module_cge_states');

/**
 * @ignore
 */
define('CGEXTENSIONS_TABLE_ASSOCDATA',cms_db_prefix().'module_cge_assocdata');

/**
 * A base class for all CMSMS modules written by me to provide optimizations and
 * conveniences that are not built into CMSMS.
 *
 * @package CGExtensions
 */
class CGExtensions extends CMSModule
{
    /**
     * @ignore
     */
    private static $_initialized;

    /**
     * @ignore
     */
    private $_obj = null;

    /**
     * @ignore
     */
    public $_colors;

    /**
     * @ignore
     */
    public $_actionid = null;

    /**
     * @ignore
     */
    public $_actionname = null;

    /**
     * @ignore
     */
    public $_image_directories;

    /**
     * @ignore
     */
    public $_current_tab;

    /**
     * @ignore
     */
    public $_current_action;

    /**
     * @ignore
     */
    public $_errormsg;

    /**
     * @ignore
     */
    public $_messages;

    /**
     * @ignore
     */
    public $_returnid;

    /**
     * The constructor.
     * This method does numerous things, including setup an extended autoloader,
     * create defines for the module itself.  i.e: MOD_CGEXTENSIONS, or MOD_FRONTENDUSERS.
     * sets up a built in cache driver for temporarily caching data.
     * and register numerous smarty plugins (see the documentation for those).
     */
    public function __construct()
    {
        spl_autoload_register(array($this,'autoload'));
        parent::__construct();

        global $CMS_INSTALL_PAGE, $CMS_PHAR_INSTALL;
        if( isset($CMS_INSTALL_PAGE) || isset($CMS_PHAR_INSTALL) ) return;

        $class = get_class($this);
        if( !defined('MOD_'.strtoupper($class)) ) {
            /**
             * @ignore
             */
            define('MOD_'.strtoupper($class),$class);
        }

        if( self::$_initialized || $class != 'CGExtensions' ) return;
        self::$_initialized = TRUE;

        //
        // from here down only happens once per request (for CGExtensions only)
        //

        $smarty = CmsApp::get_instance()->GetSmarty();
        if( !$smarty ) return;

        \CGExtensions\smarty_plugins::init($smarty);

        $db = cms_utils::get_db();
        if( is_object($db) ) {
            $query = 'SET @CG_ZEROTIME = NOW() - INTERVAL 150 YEAR,@CG_FUTURETIME = NOW() + INTERVAL 5 YEAR';
            $db->Execute($query);
            $config = \cms_config::get_instance();
            if( \cge_param::get_bool($config,'cge_relax_sql') ) {
                $query = 'SET SESSION sql_mode=\'TRADITIONAL\'';
                $db->Execute($query);
            }
        }
    }

    /**
     * An extended autoload method.
     * Search for classes a <module>/lib/class.classname.php file.
     * or for interfaces in a <module>/lib/interface.classname.php file.
     * or as a last ditch effort, for simple classes in the <module>/lib/extraclasses.php file.
     * This method also supports namespaces,  including <module> and <module>/sub1/sub2 which should exist in files as described above.
     * in subdirectories below the <module>/lib directory.
     *
     * @internal
     * @param string $classname
     */
    public function autoload($classname)
    {
        if( !is_object($this) ) return FALSE;

        // check for classes.
        //if( get_class($this) != MOD_CGEXTENSIONS) cms_utils::get_module(MOD_CGEXTENSIONS);
        $path = $this->GetModulePath().'/lib';
        if( strpos($classname,'\\') !== FALSE ) {
            $t_path = str_replace('\\','/',$classname);
            if( startswith( $t_path, $this->GetName().'/' ) ) {
                $classname = basename($t_path);
                $t_path = dirname($t_path);
                $t_path = substr($t_path,strlen($this->GetName())+1);
                $path = $this->GetModulePath().'/lib/'.$t_path;
            }
        }

        $fn = $path."/class.{$classname}.php";
        if( is_file($fn) ) {
            require_once($fn);
            return TRUE;
        }

        // check for abstract classes.
        $fn = $path."/abstract.{$classname}.php";
        if( is_file($fn) ) {
            require_once($fn);
            return TRUE;
        }

        // check for interfaces
        $fn = $path."/interface.{$classname}.php";
        if( is_file($fn) ) {
            require_once($fn);
            return TRUE;
        }

        // check for traits
        $fn = $path."/trait.{$classname}.php";
        if( is_file($fn) ) {
            require_once($fn);
            return TRUE;
        }

        // check for a master file
        $fn = $this->GetModulePath()."/lib/extraclasses.php";
        if( is_file($fn) ) {
            require_once($fn);
            return TRUE;
        }

        return FALSE;
    }

    /**
     * @ignore
     */
    public function &__get($key)
    {
        switch( $key ) {
        case 'db':
            return \CmsApp::get_instance()->GetDb();

        default:
            $out = parent::__get($key);
            return $out;
        }
    }

    /**
     * @ignore
     */
    public function InitializeFrontend()
    {
        parent::InitializeFrontend();
        $this->RestrictUnknownParams();
        $this->SetParameterType('cge_msg',CLEAN_STRING);
        $this->SetParameterType('cge_msgkey',CLEAN_STRING);
        $this->SetParameterType('cge_error',CLEAN_INT);
        $this->SetParameterType('nocache',CLEAN_INT);
    }

    /**
     * @ignore
     * @deprecated
     */
    private function _load_main()
    {
        if( is_object($this->_obj) ) return;
        require_once(__DIR__.'/class.cgextensions.tools.php');
        $this->_obj = new cgextensions_tools($this);
    }


    /**
     * @ignore
     * @deprecated
     */
    private function _load_form()
    {
        require_once(__DIR__.'/form_tools.php');
    }

    /**
     * The Friendly name for this module.  For use in the admin navigation.
     *
     * @see CMSModule::GetFriendlyName()
     * @abstract
     * @return string
     */
    public function GetFriendlyName() {
        if( get_class($this) == 'CGExtensions' ) return $this->Lang('friendlyname');
        return parent::GetFriendlyName();
    }

    /**
     * Return the version of this module.
     *
     * @see CMSModule::GetVersion()
     * @abstract
     * @return string
     */
    public function GetVersion() {
        if( get_class($this) == 'CGExtensions' ) return '1.57.1';
        $str = parent::GetVersion();
        return $str;
    }

    /**
     * Return the help of this module.
     *
     * @see CMSModule::GetHelp()
     * @abstract
     * @return string
     */
    public function GetHelp() {
        $dir = $this->GetModulePath();
        $out = '';
        $fns1 = array('doc/help.inc','docs/help.inc','doc/help.html','docs/help.html','help.inc','help.html');
        foreach( $fns1 as $p1 ) {
            $test = cms_join_path($dir,$p1);
            if( is_file($test) ) {
                $out = file_get_contents($test);
                break;
            }
        }

        // check if we have api documentation and we are not generating an XML document.
        global $CMSMS_GENERATING_XML;
        if( !isset($CMSMS_GENERATING_XML) ) {
            $fns1 = array('doc/apidoc','doc/apidocs','docs/apidoc','docs/apidocs');
            foreach( $fns1 as $p1 ) {
                $test = cms_join_path($dir,$p1);
                if( is_dir($test) ) {
                    $url = $this->GetModuleURLPath()."/$p1";
                    $cge = \cms_utils::get_module(MOD_CGEXTENSIONS);
                    $lbl = $cge->Lang('view_api_docs');
                    $out = "<p><a href=\"$url\">$lbl</a></p>" . $out;
                    break;
                }
            }
        }
        return $out;
    }

    /**
     * Return the Author of this module.
     *
     * @see CMSModule::GetAuthor()
     * @abstract
     * @return string
     */
    public function GetAuthor() { return 'calguy1000'; }

    /**
     * Return the email address for the author of this module.
     *
     * @see CMSModule::GetAuthorEmail()
     * @abstract
     * @return string
     */
    public function GetAuthorEmail() { return 'calguy1000@cmsmadesimple.org'; }

    /**
     * Return the changelog for this module.
     *
     * @see CMSModule::GetChangeLog()
     * @abstract
     * @return string
     */
    public function GetChangeLog()
    {
        $dir = $this->GetModulePath();
        $files = array('docs/changelog.inc','doc/changelog.inc','docs/changelog.html','doc/changelog.html','changelog.inc');
        foreach( $files as $file ) {
            $fn = cms_join_path($dir,$file);
            if( is_file($fn) ) {
                return file_get_contents($fn);
            }
        }
    }

    /**
     * Return if this is a plugin module (for the frontend of the website) or not.
     *
     * @see CMSModule::IsPluginModule()
     * @abstract
     * @return bool
     */
    public function IsPluginModule() {
        if( get_class($this) == MOD_CGEXTENSIONS ) return true;
        return parent::IsPluginModule();
    }

    /**
     * Return if this module has an admin section.
     *
     * @see CMSModule::HasAdmin()
     * @abstract
     * @return string
     */
    public function HasAdmin() {
        if( get_class($this) == MOD_CGEXTENSIONS ) return true;
        return parent::HasAdmin();
    }

    /**
     * Return if this module handles events.
     *
     * @see CMSModule::HandlesEvents()
     * @abstract
     * @return string
     */
    public function HandlesEvents() {
        if( get_class($this) == MOD_CGEXTENSIONS ) return true;
        return parent::HandlesEvents();
    }

    /**
     * Get the section of the admin navigation that this module belongs to.
     *
     * @abstract
     * @return string
     */
    public function GetAdminSection() { return 'extensions'; }

    /**
     * Get a human readable description for this module.
     *
     * @abstract
     * @return string
     */
    public function GetAdminDescription() {
        if( get_class($this) == MOD_CGEXTENSIONS ) return $this->Lang('moddescription');
        return parent::GetAdminDescription();
    }

    /**
     * Get a hash containing dependent modules, and their minimum versions.
     *
     * @abstract
     * @return string
     */
    public function GetDependencies() { return []; }

    /**
     * Display a custom message after the module has been installed.
     *
     * @abstract
     * @return string
     */
    public function InstallPostMessage() {
        if( get_class($this) == MOD_CGEXTENSIONS ) return $this->Lang('postinstall');
        return parent::InstallPostMessage();
    }

    /**
     * Return the minimum CMSMS version that this module is compatible with.
     *
     * @abstract
     * @return string
     */
    public function MinimumCMSVersion() { return '2.1.6'; }

    /**
     * Return a message to display after the module has been uninstalled.
     *
     * @abstract
     * @return string
     */
    public function UninstallPostMessage() {
        if( get_class($this) == MOD_CGEXTENSIONS ) return $this->Lang('postuninstall');
        return parent::UninstallPostMessage();
    }

    /**
     * Test if this module is visible in the admin navigation to the currently logged in admin user.
     *
     * @abstract
     * @return bool
     */
    public function VisibleToAdminUser()
    {
        if( get_class($this) == MOD_CGEXTENSIONS ) return $this->CheckPermission('Modify Site Preferences') ||  $this->CheckPermission('Modify Templates');
        return parent::VisibleToAdminUser();
    }

    /**
     * Retrieve some HTML to be output in all admin requests for this module (and its descendants).
     * By default this module calls the jsloader::render method,  and includes some standard styles
     *
     * @abstract
     * @see \CGExtensions\jsloader\jsloader::render();
     * @return bool
     */
    public function GetHeaderHTML()
    {
        $config = \Cmsapp::get_instance()->GetConfig();
        $out = \CGExtensions\jsloader\jsloader::render(array('session'=>session_id()));
        $mod = cms_utils::get_module(MOD_CGEXTENSIONS);
        $fn = $mod->find_module_file('css/admin_styles.css');
        if( $fn ) {
            $css = str_replace($config['root_path'],$config['root_url'],$fn);
            $out .= '<link rel="stylesheet" href="'.$css.'"/>'."\n";
        }
        if( $this->GetName() != MOD_CGEXTENSIONS ) {
            $fn = $this->find_module_file('css/admin_styles.css');
            if( $fn ) {
                $css = str_replace($config['root_path'],$config['root_url'],$fn);
                $out .= '<link rel="stylesheet" href="'.$css.'"/>'."\n";
            }
        }
        return $out;
    }

    /**
     * A replacement for the built in DoAction method
     * For CGExtensions derived modules some  builtin smarty variables are created
     * module hints are handled,  and input type=image values are corrected in input parameters.
     *
     * this method also handles setting the active tab, and displaying any messages or errors
     * set with the SetError or SetMessage methods.
     *
     * This method is called automatically by the system based on the incoming request, and the page template.
     * It should almost never be called manually.
     *
     * @see SetError()
     * @see SetMessage()
     * @see SetCurrentTab()
     * @see RedirectToTab()
     * @param string $name the action name
     * @param string $id The module action id
     * @param array  $params The module parameters
     * @param int    $returnid  The page that will contain the HTML results.  This is empty for admin requests.
     */
    public function DoAction($name,$id,$params,$returnid='')
    {
        if( !method_exists($this,'set_action_id') && $this->GetName() != MOD_CGEXTENSIONS ) {
            die('FATAL ERROR: A module derived from CGExtensions is not handling the set_action_id method');
        }
        $this->set_action_id($id);
        $this->set_action_name($name);

        // handle the stupid input type='image' problem.
        foreach( $params as $key => $value ) {
            if( endswith($key,'_x') ) {
                $base = substr($key,0,strlen($key)-2);
                if( isset($params[$base.'_y']) && !isset($params[$base]) ) $params[$base] = $base;
            }
        }

        // handle module hints
        $hints = cms_utils::get_app_data('__MODULE_HINT__'.$this->GetName());
        if( is_array($hints) ) {
            foreach( $hints as $key => $value ) {
                if( isset($params[$key]) ) continue;
                $params[$key] = $value;
            }
        }

        if( !CmsApp::get_instance()->is_frontend_request() && $this->CheckPermission('Modify Modules') ) {
            // display module integrity stuff
            // only to people with appropriate permission, and only on admin requests
            // data is cached for one day (or until cache is cleared)
            $prefname = 'cgeint_'.md5($this->GetName());
            $lastcheck = $this->GetPreference($prefname);
            if( $lastcheck < time() - 24 * 3600 ) {
                $cge = \cms_utils::get_module(MOD_CGEXTENSIONS);
                $rec = \CGExtensions\internal\ModuleIntegrityTools::get_cached_status($this->GetName());
                switch( $rec['status'] ) {
                case -1: // no checksum stuff
                    // only display this once per day
                    audit('',$this->GetName(),'No Verification Data: '.$rec['message']);
                    break;

                case 0: // validation failed or some other error
                    audit('',$this->GetName(),'Verify Failed: '.$rec['message']);
                    break;

                case 1:
                    // do nothing.
                    break;
                }
                $this->SetPreference($prefname,time());
            }
        }

        // redundant for cmsms 2.0
        $smarty = $this->GetActionTemplateObject();
        $smarty->assign('actionid',$id);
        $smarty->assign('actionparams',$params);
        $smarty->assign('returnid',$returnid);
        $smarty->assign('mod',$this);
        $smarty->assign($this->GetName(),$this);
        cge_tmpdata::set('module',$this->GetName());

        if( $returnid == '' ) {
            // admin action
            if( isset($params['cg_activetab']) ) {
                $this->_current_tab = trim($params['cg_activetab']);
                unset($params['cg_activetab']);
            }
            if( isset($params['cg_error']) ) {
                $this->_errormsg = explode(':err:',$params['cg_error']);
                unset($params['cg_error']);
            }
            if( isset($params['cg_message']) ) {
                $this->_messages = explode(':msg:',$params['cg_message']);
                unset($params['cg_message']);
            }

            $this->DisplayErrors();
            $this->DisplayMessages();
        }

        parent::DoAction($name,$id,$params,$returnid);
    }


    /**
     * A convenience method to encrypt some data
     *
     * @see cge_encrypt
     * @param string $key The encryption key
     * @param string $data The data to encrypt
     * @return string The encrypted data
     */
    function encrypt($key,$data)
    {
        return cge_encrypt::encrypt($key,$data);
    }


    /**
     * A convenience method to decrypt some data
     *
     * @see cge_encrypt
     * @param string $key The encryption key
     * @param string $data The data to decrypt
     * @return string The derypted data
     */
    function decrypt($key,$data)
    {
        return cge_encrypt::decrypt($key,$data);
    }


    /**
     * A convenience function to create a url for a module action.
     * This method is deprecated as the CMSModule::create_url method replaces it.
     *
     * @deprecated
     * @param string $id the module action id
     * @param string $action The module action
     * @param string $returnid The page that the url will refer to.  This is empty for admin requests
     * @param array  $params Module parameters
     * @param bool   $inline For frontend requests only dicates wether this url should be inline only.
     * @param string $prettyurl
     */
    function CreateURL($id,$action,$returnid,$params=array(),$inline=false,$prettyurl='')
    {
        $this->_load_main();
        return $this->_obj->__CreatePrettyLink($id,$action,$returnid,'',$params,'',true,$inline,'',false,$prettyurl);
    }


  /* ======================================== */
  /* FORM FUNCTIONS                           */
  /* ======================================== */

    /**
     * A convenience method to create a control that contains a 'sortable list'.
     * The output control is translated, and interactive and suitable for use in forms.
     *
     * @deprecated
     * @param string $id The module action id
     * @param string $name The input element name
     * @param array $items An associative array of the items for this list.
     * @param string $selected A comma separated string of selected item keys
     * @param bool $allowduplicates
     * @param int $max_selected The maximum number of items that can be selected
     * @param string $template Specify an alternate template for the sortable list control
     * @param string $label_left  A label for the left column.
     * @param string $label_right A label for the right column.
     * @return string
     */
    function CreateSortableListArea($id,$name,$items, $selected = '', $allowduplicates = true, $max_selected = -1,
                                    $template = '', $label_left = '', $label_right = '')
    {
        $cge = $this->GetModuleInstance(MOD_CGEXTENSIONS);
        if( empty($label_left) ) $label_left = $cge->Lang('selected');
        if( empty($label_right) ) $label_right = $cge->Lang('available');

        if( !$template ) $template = 'sortablelists_'.$cge->GetPreference('dflt_sortablelist_template');
        $tpl = $this->CreateSmartyTemplate($template);
        $tpl->assign('selectarea_selected_str',null);
        $tpl->assign('selectarea_selected',[]);
        if( !empty($selected) ) {
            $sel = explode(',',$selected);
            $tmp = [];
            foreach($sel as $theid) {
                if( array_key_exists($theid,$items) ) $tmp[$theid] = $items[$theid];
            }
            $tpl->assign('selectarea_selected_str',$selected);
            $tpl->assign('selectarea_selected',$tmp);
        }
        $tpl->assign('cge',$cge);
        $tpl->assign('max_selected',$max_selected);
        $tpl->assign('label_left',$label_left);
        $tpl->assign('label_right',$label_right);
        $tpl->assign('selectarea_masterlist',$items);
        $tpl->assign('selectarea_prefix',$id.$name);
        if( $allowduplicates ) $allowduplicates = 1; else $allowduplicates = 0;
        $tpl->assign('allowduplicates',$allowduplicates);
        $tpl->assign('upstr',$cge->Lang('up'));
        $tpl->assign('downstr',$cge->Lang('down'));
        return $tpl->fetch();
    }


    /**
     * Create a translated Yes/No dropdown.
     * The output control is translated, and suitable for use in forms.
     * This method is deprecated.  It is best to assign all data to smarty and then create input elements as necessary in the smarty template.
     *
     * @deprecated
     * @param string $id the module action id
     * @param string $name The name for the input element
     * @param int    $selectedvalue The selected value (0 == no, 1 == yes)
     * @param string $addtext
     * @return string
     */
    function CreateInputYesNoDropdown($id,$name,$selectedvalue='',$addtext='')
    {
        $this->_load_form();
        return cge_CreateInputYesNoDropdown($this,$id,$name,$selectedvalue,$addtext);
    }

    /**
     * Create a custom submit button.
     * The output control is translated, and suitable for use in forms.
     * This method is deprecated.  It is best to assign all data to smarty and then create input elements as necessary in the smarty template.
     *
     * @deprecated
     * @param string $id the module action id
     * @param string $name The name for the input element
     * @param string $value The value for the submit button
     * @param string $addtext Additional text for the tag
     * @param string $image an optional image path
     * @param string $confirmtext Optional confirmation text
     * @param string $class Optional value for the class attribute
     * @return string
     */
    function CGCreateInputSubmit($id,$name,$value='',$addtext='',$image='', $confirmtext='',$class='')
    {
        $this->_load_form();
        return cge_CreateInputSubmit($this,$id,$name,$value,$addtext,$image,$confirmtext,$class);
    }


    /**
     * Create a custom checkbox.
     * This is similar to the standard checkbox but has a hidden field with the same name
     * before it so that some value for this field is always returned to the form handler.
     * This method is deprecated.  It is best to assign all data to smarty and then create input elements as necessary in the smarty template.
     *
     * @deprecated
     * @param string $id the module action id
     * @param string $name The name for the input element
     * @param string $value The value for the checkbox
     * @param string $selectedvalue The current value of the field.
     * @param string $addtext Additional text for the tag
     * @return string
     */
    function CreateInputCheckbox($id,$name,$value='',$selectedvalue='', $addtext='')
    {
        $this->_load_form();
        return cge_CreateInputCheckbox($this,$id,$name,$value,$selectedvalue,$addtext);
    }


    /**
     * A Convenience function for creating form tags.
     * This method re-organises some of the parameters of the original CreateFormStart method
     * and handles current tab functionalty, and sets the encoding type of the form to multipart/form-data
     *
     * This method is deprecated and will be replaced in CMSMS 2.0 by the core {form_start} tag.
     *
     * @deprecated
     * @param string $id the module action id
     * @param string $action the destination action
     * @param string $returnid The destination pagpe for the action handler.  Empty for admin requests
     * @param array  $params additional parameters to be passed with the form
     * @param bool   $inline wether this is an inline form request (output will replace module tag rather than the entire content section of the template.
     * @param string $method The form method.
     * @param string $enctype The form encoding type
     * @param string $idsuffix
     * @param string $extra Extra text for thhe form tag
     * @return string
     */
    function CGCreateFormStart($id,$action='default',$returnid='',$params=array(),$inline=false,$method='post',
                               $enctype='',$idsuffix='',$extra='')
    {
        if( !empty($this->_current_tab) ) $params['cg_activetab'] = $this->_current_tab;
        if( $enctype == '' ) $enctype = 'multipart/form-data';
        return $this->CreateFormStart($id,$action,$returnid,$method,$enctype,$inline,$idsuffix,$params,$extra);
    }


    /**
     * A convenience function for creating a frontend form
     * This method re-organises some of the parameters of the original CreateFormStart method
     * and sets the encoding type of the form to multipart/form-data
     *
     * This method is deprecated and will be replaced in CMSMS 2.0 by the core {form_start} tag.
     *
     * @deprecated
     * @param string $id the module action id
     * @param string $action the destination action
     * @param string $returnid The destination pagpe for the action handler.  Empty for admin requests
     * @param array  $params additional parameters to be passed with the form
     * @param bool   $inline wether this is an inline form request (output will replace module tag rather than the entire content section of the template.
     * @param string $method The form method.
     * @param string $enctype The form encoding type
     * @param string $idsuffix
     * @param string $extra Extra text for thhe form tag
     * @return string
     */
    function CGCreateFrontendFormStart($id,$action='default',$returnid='', $params=array(),$inline=true,$method='post',
                                       $enctype='',$idsuffix='',$extra='')
    {
        $this->_load_form();
        return $this->CreateFrontendFormStart($id,$returnid,$action,$method,$enctype,$inline,$idsuffix,$params,$extra);
    }


    /**
     * A convenience method to create a hidden input element for forms.
     * This method is deprecated.  It is best to assign all data to smarty and then create input elements as necessary in the smarty template.
     *
     * @deprecated
     * @param string $id the module action id
     * @param string $name The name of the input element
     * @param string $value The value of the input element
     * @param string $addtext Additional text for the tag
     * @param string $delim the delimiter for value separation.
     * @return string
     */
    function CreateInputHidden($id,$name,$value='',$addtext='',$delim=',')
    {
        $this->_load_form();
        return cge_CreateInputHidden($this,$id,$name,$value,$addtext,$delim);
    }


    /**
     * For admin requests only, pass variables so that the specified tab will be displayed
     * by default in the resulting action.
     *
     * @param string $id the module action id.  For admin requests this is usually 'm1_'
     * @param string $tab The name of the parameter
     * @param string $params Extra parameters for the request
     * @param string $action The designated module action.  If none is specified 'defaultadmin' is assumed.
     */
    function RedirectToTab( $id = '', $tab = '', $params = '', $action = '' )
    {
        if( $id == '' ) $id = 'm1_';
        $this->_load_main();
        if( !$action ) $action = $this->_current_action;
        return $this->_obj->RedirectToTab($id,$tab,$params,$action);
    }


    /**
     * Redirect to a specified module action.
     * This method is usable both for admin and frontend requests.
     *
     * @param string $id the module action id.  For admin requests this is usually 'm1_'
     * @param string $action The designated module action.  If none is specified 'defaultadmin' is assumed.
     * @param int $returnid The destination page.  empty for admin requests.
     * @param array $params Extra parameters for the URL
     * @param bool $inline Wether the output should be an inline URL or not ??
     */
    function Redirect($id,$action,$returnid='',$params = array(),$inline=false)
    {
        $parms = [];
        if( is_array( $params ) ) $parms = $params;
        if( is_array($this->_errormsg) && count($this->_errormsg) ) $parms['cg_error'] = implode(':err:',$this->_errormsg);
        if( is_array($this->_messages) && count($this->_messages) ) $parms['cg_message'] = implode(':msg:',$this->_messages);

        parent::Redirect( $id, $action, $returnid, $parms, $inline );
    }

    /**
     * @ignore
     */
    function CGRedirect($id,$action,$returnid='',$params=array(),$inline = false)
    {
        $this->Redirect($id,$action,$returnid,$params,$inline);
    }


    /**
     * Test if the current code is handling an admin action or a frontend action
     *
     * @return bool True for an admin action, false otherwise.
     */
    function IsAdminAction()
    {
        $gCms = CmsApp::get_instance();
        if( $gCms->test_state(CmsApp::STATE_ADMIN_PAGE) && !$gCms->test_state(CmsApp::STATE_INSTALL) &&
            !$gCms->test_state(CmsApp::STATE_STYLESHEET) ) {
            return TRUE;
        }
        return FALSE;
    }


    /**
     * Set an error to display on the next admin request from a CGExtensions derived module.
     * The error message will be carried on to the next admin request and displayed.
     *
     * @param string $str The error message.
     */
    function SetError($str)
    {
        if( !is_array( $this->_errormsg ) ) $this->_errormsg = array();
        if( !is_array($str) ) $str = array($str);
        $this->_errormsg = array_merge($this->_errormsg,$str);
    }


    /**
     * Set a message to display on the next admin request from a CGExtensions derived module.
     * The message will be carried on to the next admin request and displayed.
     *
     * @param string $str The informational message to display.
     */
    function SetMessage($str)
    {
        if( !is_array( $this->_messages ) ) $this->_messages = array();
        $this->_messages[] = $str;
    }

    /**
     * Display any set error message in the admin console.
     */
    function DisplayErrors()
    {
        if( is_array($this->_errormsg) && count($this->_errormsg) ) {
            echo $this->ShowErrors($this->_errormsg);
            $this->_errormsg = [];
        }
    }


    /**
     * Display any set informational messages in the admin console.
     */
    function DisplayMessages()
    {
        if( is_array($this->_messages) && count($this->_messages) ) {
            $message = implode('<br/>',$this->_messages);
            echo $this->ShowMessage($message);
            $this->_messages = [];
        }
    }


    /**
     * Set the current action for the next request of the admin console.
     * Used for the various admin forms.
     *
     * @param string $action The action name
     */
    function SetCurrentAction($action)
    {
        $action = trim($action);
        $this->_current_action = $action;
    }


    /**
     * Set the current tab for the next request of the admin console.
     * Used for the various template forms.
     *
     * @param string $tab The tab name.
     */
    function SetCurrentTab($tab)
    {
        $this->_current_tab = trim($tab);
    }


    /**
     * A replacement for the built in SetTabHeader.
     * This method is a smart replacement that will automatically handle an active tab on the
     * requiest.
     *
     * @param string $name The tab name (for coding purposes)
     * @param string $str  The human readable label for the tab.
     * @param mixed  $state  If Empty or 'unknown' then detect any currently set tab.
     */
    function SetTabHeader($name,$str,$state = 'unknown')
    {
        if( $state == 'unknown' || $state == '') $state = ($name == $this->_current_tab);
        return parent::SetTabHeader($name,$str,$state);
    }


    /**
     * A function for using a template to display an error message.
     * This method is suitable for frontend displays.
     *
     * @deprecated
     * @param string $txt The error message
     * @param string $class An optional class attribute value.
     */
    function DisplayErrorMessage($txt,$class = 'alert alert-danger')
    {
        $mod = \cms_utils::get_module(MOD_CGEXTENSIONS);
        $tpl = $mod->CreateSmartyTemplate('cg_errormsg');
        $tpl->assign('cg_errorclass',$class);
        $tpl->assign('cg_errormsg',$txt);
        return $tpl->fetch();
    }


    /**
     * A convenience function for retrieving the current error template
     *
     * @deprecated
     */
    function GetErrorTemplate()
    {
        return $this->GetTemplate('cg_errormsg',MOD_CGEXTENSIONS);
    }


    /**
     * Reset the error template to factory defaults
     *
     * @deprecated
     */
    function ResetErrorTemplate()
    {
        $fn = cms_join_path(__DIR__,'templates','orig_error_template.tpl');
        if( is_file( $fn ) ) {
            $template = @file_get_contents($fn);
            $this->SetTemplate( 'cg_errormsg', $template,MOD_CGEXTENSIONS );
        }
    }


    /**
     * Set the error template
     *
     * @deprecated
     * @param string $tmpl Smarty Template source
     */
    function SetErrorTemplate($tmpl)
    {
        return $this->SetTemplate('cg_errormsg',$tmpl,MOD_CGEXTENSIONS);
    }


    /**
     * A function to return an array of of country codes and country names.
     * i.e:  array( array('code'=>'AB','name'=>'Alberta'), array('code'=>'MB','code'=>'Manitoba'));
     * @return array
     */
    protected function get_state_list()
    {
        $db = \CmsApp::get_instance()->GetDb();
        $query = 'SELECT * FROM '.CGEXTENSIONS_TABLE_STATES.' ORDER BY sorting ASC,name ASC';
        $tmp = $db->GetAll($query);
        return $tmp;
    }


    /**
     * A function to return an array of of country codes and country names.
     * This method returns data that is suitable for use in a list.
     * i.e:  array( array('code'=>'AB','name'=>'Alberta'), array('code'=>'MB','code'=>'Manitoba'));
     *
     * @return array
     */
    public function get_state_list_options()
    {
        $tmp = $this->get_state_list();
        $result = [];
        for( $i = 0, $n = count($tmp); $i < $n; $i++ ) {
            $rec = $tmp[$i];
            $result[$rec['code']] = $rec['name'];
        }
        return $result;
    }


    /**
     * A convenience function to create a state dropdown list.
     *
     * @deprecated
     * @param string $id The module action id
     * @param string $name the name for the dropdown.
     * @param string $value The initial value for the dropdown.
     * @param mixed $selectone  If true, then a hardcoded "Select One" string will be prepended to the list.  If a string then that string will be used.
     * @param string $addtext Additional text for the select tag.
     */
    function CreateInputStateDropdown($id,$name,$value='AL',$selectone=false,$addtext='')
    {
        $tmp = $this->get_state_list();

        $states = [];
        if( $selectone !== false ) {
            if( is_string($selectone) ) {
                $states[$selectone] = '';
            }
            else {
                $cge = \cms_utils::get_module(MOD_CGEXTENSIONS);
                $states[$cge->Lang('select_one')] = '';
            }
        }
        foreach($tmp as $row) {
            $states[$row['name']] = $row['code'];
        }
        return $this->CreateInputDropdown($id,$name,$states,-1,strtoupper($value),$addtext);
    }


    /**
     * A function to return an array of of country codes and country names.
     * i.e:  array( array('code'=>'US','name'=>'United States'), array('code'=>'CA','code'=>'Canada'));
     */
    public function get_country_list()
    {
        $db = \CmsApp::get_instance()->GetDb();
        $query = 'SELECT * FROM '.CGEXTENSIONS_TABLE_COUNTRIES.' ORDER BY sorting ASC,name ASC';
        $tmp = $db->GetAll($query);
        return $tmp;
    }


    /**
     * A function to return an array of of country codes and country names.
     * This method returns data suitable for giving to smarty and displaying in a dropdown.
     */
    public function get_country_list_options()
    {
        $tmp = $this->get_country_list();
        $result = [];
        for( $i = 0, $n = count($tmp); $i < $n; $i++ ) {
            $rec = $tmp[$i];
            $result[$rec['code']] = $rec['name'];
        }
        return $result;
    }


    /**
     * A convenience function to create a country dropdown list
     *
     * @deprecated
     * @param string $id The module action id
     * @param string $name the name for the dropdown.
     * @param string $value The initial value for the dropdown.
     * @param mixed $selectone  If true, then a hardcoded "Select One" string will be prepended to the list.  If a string then that string will be used.
     * @param string $addtext Additional text for the select tag.
     */
    function CreateInputCountryDropdown($id,$name,$value='US',$selectone=false,$addtext='')
    {
        $tmp = $this->get_country_list();

        if( is_array($tmp) && count($tmp) ) {
            $countries = [];
            if( $selectone !== false ) {
                $cge = \cms_utils::get_module(MOD_CGEXTENSIONS);
                $countries[$cge->Lang('select_one')] = '';
            }
            foreach($tmp as $row) {
                $countries[$row['name']] = $row['code'];
            }
            return $this->CreateInputDropdown($id,$name,$countries,-1,strtoupper($value),$addtext);
        }
    }


    /**
     * A convenience function to get the country name given the acronym
     *
     * @param string $the_acronym
     * @return string
     */
    function GetCountry($the_acronym)
    {
        $db = \CmsApp::get_instance()->GetDb();
        $query = 'SELECT name FROM '.CGEXTENSIONS_TABLE_COUNTRIES.' WHERE code = ?';
        $name = $db->GetOne($query,array($the_acronym));
        return $name;
    }


    /**
     * A convenience function to get the state name given the acronym
     *
     * @param string $the_acronym
     * @return string
     */
    function GetState($the_acronym)
    {
        $db = \CmsApp::get_instance()->GetDb();
        $query = 'SELECT name FROM '.CGEXTENSIONS_TABLE_STATES.' WHERE code = ?';
        $name = $db->GetOne($query,array($the_acronym));
        return $name;
    }


    /**
     * A convenience function to create an image dropdown from all of the image files in a specified directory.
     * This method will not ignore thumbnails.
     *
     * @deprecated
     * @param string $id The module action id
     * @param string $name the name for the dropdown.
     * @param string $selectedfile The initial value for the dropdown (an image filename)
     * @param string $dir The path (relative to the uploads path) to the directory to pull images from.  If not specified, the image uploads path will be used.
     * @param mixed  $none  If true, then 'None' will be prepended to the list of output images.  If a string it's value will be used.
     * @return string.
     */
    function CreateImageDropdown($id,$name,$selectedfile,$dir = '',$none = '')
    {
        $config = cms_config::get_instance();

        if( startswith( $dir, '.' ) ) $dir = '';
        if( $dir == '' ) $dir = $config['image_uploads_path'];
        if( !is_dir($dir) ) $dir = cms_join_path($config['uploads_path'],$dir);

        $extensions = $this->GetPreference('imageextensions');

        $filelist = cge_dir::get_file_list($dir,$extensions);
        if( $none ) {
            if( !is_string($none) ) {
                $cge = $this->GetModuleInstance(MOD_CGEXTENSIONS);
                $none = $cge->Lang('none');
            }
            $filelist = array_merge(array($none=>''),$filelist);
        }
        return $this->CreateInputDropdown($id,$name,$filelist,-1,$selectedfile);
    }


    /**
     * A convenience function to create a list of filenames in a specified directory.
     *
     * @deprecated
     * @param string $id The module action id
     * @param string $name the name for the dropdown.
     * @param string $selectedfile The initial value for the dropdown (an image filename)
     * @param string $dir The path (relative to the uploads path) to the directory to pull images from.  If not specified, the image uploads path will be used.
     * @param string $extensions A comma separated list of filename extensions to include in the list.  If not specified the module preference will be used.
     * @param bool   $allownone Allow no files to be selected.
     * @param bool   $allowmultiple To allow selecting multiple files.
     * @param int    $size The size of the dropdown.
     * @return string.
     */
    function CreateFileDropdown($id,$name,$selectedfile='',$dir = '',$extensions = '',$allownone = '',$allowmultiple = false,$size = 3)
    {
        $config = cms_config::get_instance();

        if( $dir == '' ) $dir = $config['uploads_path'];
        else {
            while( startswith($dir,'/') && $dir != '' ) $dir = substr($dir,1);
            $dir = $config['uploads_path'].$dir;
        }
        if( $extensions == '' ) $extensions = $this->GetPreference('fileextensions','');

        $tmp = cge_dir::get_file_list($dir,$extensions);
        $tmp2 = [];
        if( !empty($allownone) ) {
            $cge = \cms_utils::get_module(MOD_CGEXTENSIONS);
            $tmp2[$cge->Lang('none')] = '';
        }
        $filelist = array_merge($tmp2,$tmp);

        if( $allowmultiple ) {
            if( !endswith($name,'[]') ) $name .= '[]';
            return $this->CreateInputSelectList($id,$name,$filelist,[],$size);
        }
        return $this->CreateInputDropdown($id,$name,$filelist,-1,$selectedfile);
    }


    /**
     * A convenience function to create a color selection dropdown
     *
     * @deprecated
     * @param string $id The module action id
     * @param string $name the name for the dropdown.
     * @param string $selectedvalue The initial value for the input field.
     * @return string
     */
    function CreateColorDropdown($id,$name,$selectedvalue='')
    {
        $this->_load_form();
        $cgextensions = $this->GetModuleInstance(MOD_CGEXTENSIONS);
        return cge_CreateColorDropdown($cgextensions,$id,$name,$selectedvalue);
    }

    /* ======================================== */
    /* IMAGE FUNCTIONS                         */
    /* ======================================== */

    /**
     * @ignore
     */
    function TransformImage($srcSpec,$destSpec,$size='')
    {
        return cge_image::transform_image($srcSpec,$destSpec,$size);
    }

    /**
     * A convenience method to create an image tag.
     * This method will automatically search through added image dirs for frontend and admin requests
     * and through the admin theme directories for admin requests.
     *
     * @deprecated
     * @see cge_tags::create_image
     * @see AddImageDir.
     * @param string $id The module action id
     * @param string $alt The alt attribute for the tag
     * @param int $width Width in pixels
     * @param int $height Height in pixels
     * @param string $class Value for the class attribute
     * @param string $addtext Additional text for the img tag.
     * @return string
     */
    function CreateImageTag($id,$alt='',$width='',$height='',$class='', $addtext='')
    {
        $this->_load_main();
        return $this->_obj->CreateImageTag($id,$alt,$width,$height,$class,$addtext);
    }


    /**
     * A convenience method to display an image.
     * This method will automatically search through added image dirs for frontend and admin requests
     * and through the admin theme directories for admin requests.
     *
     * @deprecated
     * @see cge_tags::create_image
     * @see AddImageDir.
     * @param string $image The basename for the desired image.
     * @param string $alt The alt attribute for the tag
     * @param string $class Value for the class attribute
     * @param int $width Width in pixels
     * @param int $height Height in pixels
     * @return string
     */
    function DisplayImage($image,$alt='',$class='',$width='',$height='')
    {
        $this->_load_main();
        return $this->_obj->DisplayImage($image,$alt,$class,$width,$height);
    }


    /**
     * A convenience method to create a link to a module action containing an image and optionally some text.
     *
     * This method will automatically search through added image dirs for frontend and admin requests
     * and through the admin theme directories for admin requests.
     *
     * @deprecated
     * @see CreateLink
     * @see CreateURL())
     * @see cge_tags::create_image
     * @see AddImageDir())
     * @see DisplayImage()
     * @param string $id The module action id
     * @param string $action The name of the destination action
     * @param int $returnid The page for the destination of the request.  Empty for admin requests.
     * @param string $contents The text content of the image.
     * @param string $image The basename of the image to display.
     * @param array  $params Additional link parameters
     * @param string $classname Class for the img tag.
     * @param string $warn_message An optional confirmation message
     * @param bool   $imageonly Wether the contents (if specified) should be ignored.
     * @param bool $inline
     * @param string $addtext
     * @param bool $targetcontentonly
     * @param string $prettyurl An optional pretty url slug.
     * @return string
     */
    function CreateImageLink($id,$action,$returnid,$contents,$image, $params=array(),$classname='',
                             $warn_message='',$imageonly=true, $inline=false,
                             $addtext='',$targetcontentonly=false,$prettyurl='')
    {
        $this->_load_main();
        return $this->_obj->CreateImageLink($id,$action,$returnid,$contents,$image, $params,$classname,$warn_message,
                                            $imageonly,$inline,$addtext, $targetcontentonly,$prettyurl);
    }



    /**
     * Add a directory to the list of searchable directories
     *
     * @param string $dir A directory relative to this modules installation directory.
     */
    function AddImageDir($dir)
    {
        if( strpos('/',$dir) !== 0 ) $dir = "modules/".$this->GetName().'/'.$dir;
        $this->_image_directories[] = $dir;
    }


    /**
     * List all templates stored with this module that begin with the same prefix.
     *
     * @deprecated
     * @see cge_template_utils::get_templates_by_prefix()
     * @param string $prefix The optional prefix
     * @param bool $trim
     * @return array
     */
    function ListTemplatesWithPrefix($prefix='',$trim = false )
    {
        return cge_template_utils::get_templates_by_prefix($this,$prefix,$trim);
    }


    /**
     * Create a dropdown of all templates beginning with the specified prefix
     *
     * @deprecated
     * @param string $id The module action id
     * @param string $name The name for the input element.
     * @param string $prefix The optional prefix
     * @param string $selectedvalue The default value for the input element
     * @param string $addtext
     * @return string
     */
    function CreateTemplateDropdown($id,$name,$prefix='',$selectedvalue=-1,$addtext='')
    {
        return cge_template_utils::create_template_dropdown($id,$name,$prefix,$selectedvalue,$addtext);
    }


    /**
     * Part of the multiple database template functionality
     * this function provides an interface for adding, editing,
     * deleting and marking active all templates that match
     * a prefix.
     *
     * @deprecated Use the CmsLayoutTemplate class(es) in 2.0 capable modules.
     * @param string $id The module action id (pass in the value from doaction)
     * @param int $returnid The page id to use on subsequent forms and links.
     * @param string $prefix The template prefix
     * @param string $defaulttemplatepref The name of the template containing the system default template.  This can either be the name of a database template or a filename ending with .tpl.
     * @param string $active_tab The tab to return to
     * @param string $defaultprefname The name of the preference that contains the name of the current default template.  If empty string then there will be no possibility to set a default template for this list.
     * @param string $title Title text to display in the add/edit template form
     * @param string $info Information text to display in the add/edit template form
     * @param string $destaction The action to return to.
     */
    function ShowTemplateList($id,$returnid,$prefix, $defaulttemplatepref,$active_tab, $defaultprefname,
                              $title,$info = '',$destaction = 'defaultadmin')
    {
        $cgextensions = $this->GetModuleInstance(MOD_CGEXTENSIONS);
        return $cgextensions->_DisplayTemplateList($this,$id,$returnid,$prefix, $defaulttemplatepref,$active_tab,
                                                   $defaultprefname,$title,$info,$destaction);
    }


    /**
     * @ignore
     */
    function _DisplayTemplateList(&$module,$id,$returnid,$prefix,	$defaulttemplatepref,$active_tab,$defaultprefname,
                                  $title, $info = '',$destaction = 'defaultadmin')
    {
        $this->_load_main();
        return $this->_obj->_DisplayTemplateList($module,$id,$returnid,$prefix,$defaulttemplatepref,$active_tab,
                                                 $defaultprefname,$title,$info,$destaction);
    }



    /**
     * GetDefaultTemplateForm.
     * A function to return a form suitable for editing a single template.
     *
     * @deprecated (this functionality is irrelevant in CMSMS 2.0)
     * @see cge_template_admin::get_start_template_form
     * @param GExtensions $module A CGExtensions derived module reference
     * @param string $id
     * @param string $returnid
     * @param string $prefname
     * @param string $action
     * @param string $active_tab
     * @param string $title
     * @param string $filename
     * @param string $info
     * @return string
     */
    function GetDefaultTemplateForm(&$module,$id,$returnid,$prefname,$action,$active_tab,$title,$filename, $info = '')
    {
        return cge_template_admin::get_start_template_form($module,$id,$returnid,$prefname,$action,$active_tab,$title,
                                                           $filename,$info);
    }


    /**
     * EditDefaultTemplateForm
     *
     * A function to return a form suitable for editing a single template.
     *
     * @deprecated (this functionality is irrelevant in CMSMS 2.0)
     * @see cge_template_admin::get_start_template_form
     * @param GExtensions $module A CGExtensions derived module reference
     * @param string $id
     * @param string $returnid
     * @param string $prefname
     * @param string $active_tab
     * @param string $title
     * @param string $filename
     * @param string $info
     * @param string $action
     * @return string
     */
    function EditDefaultTemplateForm(&$module,$id,$returnid,$prefname, $active_tab,$title,$filename,$info = '',$action = 'defaultadmin')
    {
        echo cge_template_admin::get_start_template_form($module,$id,$returnid,$prefname, $action,$active_tab,$title, $filename,$info);
    }


    /**
     * A convenience function to create a url to a certain CMS page
     *
     * @param mixed $pageid A frontend page id or alias.
     * @return string
     */
    function CreateContentURL($pageid)
    {
        die('this is still used');
        $config = cms_config::get_instance();

        $contentops = ContentOperations::get_instance();
        $alias = $contentops->GetPageAliasFromID( $pageid );

        $text = '';
        if ($config["assume_mod_rewrite"]) {
            // mod_rewrite
            if( $alias == false ) {
                return '<!-- ERROR: could not get an alias for pageid='.$pageid.'-->';
            }
            else {
                $text .= $config["root_url"]."/".$alias.(isset($config['page_extension'])?$config['page_extension']:'.shtml');
            }
        }
        else {
            $text .= $config["root_url"]."/index.php?".$config["query_var"]."=".$pageid;
            return $text;
        }
    }


    /**
     * Get the username of the currently logged in admin user.
     *
     * @deprecated
     * @param int $uid
     * @return string
     */
    function GetAdminUsername($uid)
    {
        $user = UserOperations::LoadUserByID($uid);
        return $user->username;
    }


    /**
     * Get a human readable error message for an upload code.
     *
     * @deprecated
     * @see cg_fileupload
     * @param string $code The upload error code.
     * @return string
     */
    function GetUploadErrorMessage($code)
    {
        $cgextensions = $this->GetModuleInstance(MOD_CGEXTENSIONS);
        return $cgextensions->Lang($code);
    }


    /**
     * @ignore
     */
    function is_alias($str)
    {
        if( !preg_match('/^[\-\_\w]+$/', $str) ) return false;
        return true;
    }


    /**
     * @ignore
     */
    protected function set_action_id($id) { $this->_actionid = $id; }

    /**
     * @ignore
     */
    protected function set_action_name($name) { $this->_actionname = $name; }

    /**
     * @ignore
     */
    protected function get_action_name() { return $this->_actionname; }

    /**
     * Return the current action id
     *
     * @depcreated
     * @internal
     * @return int
     */
    protected function get_action_id()
    {
        if( $this->_actionid ) return $this->_actionid;
        if( !\CmsApp::get_instance()->is_frontend_request() ) return 'm1_';
    }


    /**
     * Return the current action id
     *
     * @depcreated
     * @internal
     * @return int
     */
    function GetActionId()
    {
        if( !method_exists($this,'get_action_id') && $this->GetName() != MOD_CGEXTENSIONS ) {
            die('FATAL ERROR: A module derived from CGExtensions is not handling the get_action_id method');
        }
        return $this->get_action_id();
    }


    /**
     * Get a form for adding or editing a single template.
     *
     * @deprecated
     * @see cge_template_admin::get_single_template_form
     * @param CGExtensions $module A CGExtensions module reference
     * @param string $id
     * @param int $returnid
     * @param string $tmplname The name of the template to edit
     * @param string $active_tab
     * @param string $title
     * @param string $filename The name of the file (in the module's template directory) containing the system default template.
     * @param string $info
     * @param string $destaction
     */
    function GetSingleTemplateForm(&$module,$id,$returnid,$tmplname,$active_tab,$title,$filename, $info = '',$destaction='defaultadmin',$simple = 0)
    {
        return cge_template_admin::get_single_template_form($module,$id,$returnid,$tmplname,$active_tab,$title,$filename,
                                                            $info,$destaction,$simple);
    }


    /**
     * Retrieve a human readable string for any error generated during watermarking.
     *
     * @deprecated
     * @param string $error the watermarking error code
     * @return string
     */
    function GetWatermarkError($error)
    {
        if( empty($error) || $error === 0 ) return '';
        $mod = $this->GetModuleInstance(MOD_CGEXTENSIONS);
        return $mod->Lang('watermarkerror_'.$error);
    }


    /**
     * Setup and initializing charting functionality
     *
     * @deprecated
     */
    function InitializeCharting()
    {
        require_once(__DIR__.'/lib/pData.class');
        require_once(__DIR__.'/lib/pChart.class');
    }


    /**
     * Initialize associative data functionality
     *
     * @deprecated
     */
    function InitializeAssocData()
    {
        require_once(__DIR__.'/lib/class.AssocData.php');
    }


    /**
     * A convenience method to clear any session data associated with this module.
     *
     * @param string $key If not specified clear all session data relative to this module."
     */
    function session_clear($key = '')
    {
        $pkey = 'c'.md5(__FILE__.get_class($this));
        if( empty($key) ) {
            unset($_SESSION[$pkey]);
        }
        else {
            unset($_SESSION[$pkey][$key]);
        }
    }

    /**
     * A convenience method to store some session data associated with this module.
     *
     * @param string $key The variable key.
     * @param string $value The data to store.
     */
    function session_put($key,$value)
    {
        $pkey = 'c'.md5(__FILE__.get_class($this));
        if( !isset($_SESSION[$pkey]) ) $_SESSION[$pkey] = [];
        $_SESSION[$pkey][$key] = $value;
    }

    /**
     * A convenience method to retrieve some session data associated with this module.
     *
     * @param string $key The variable key.
     * @param string $dfltvalue "The default value to return if the specified data does not exist."
     * @return mixed.
     */
    function session_get($key,$dfltvalue='')
    {
        $pkey = 'c'.md5(__FILE__.get_class($this));
        if( !isset($_SESSION[$pkey]) ) return $dfltvalue;
        if( !isset($_SESSION[$pkey][$key]) ) return $dfltvalue;
        return $_SESSION[$pkey][$key];
    }


    /**
     * Return data identified by a key either from the supplied parameters, or from session.
     *
     * @param array $params Input parameters
     * @param string $key The data key
     * @param string $defaultvalue  The data to return if the specified data does not exist in the session or in the input parameters.
     * @return mixed.
     */
    function param_session_get(&$params,$key,$defaultvalue='')
    {
        if( isset($params[$key]) ) return $params[$key];
        return $this->session_get($key,$defaultvalue);
    }


    /**
     * Given a page alias resolve it to a page id.
     *
     * @param mixed $txt The page alias to resolve.  If an integer page id is passed in that is acceptable as well.
     * @param int $dflt The default page id to return if no match can be found
     * @return int
     */
    function resolve_alias_or_id($txt,$dflt = null)
    {
        $txt = trim($txt);
        if( !$txt ) return $dflt;
        $manager = CmsApp::get_instance()->GetHierarchyManager();
        $node = null;
        if( is_numeric($txt) && (int) $txt > 0 ) {
            $node = $manager->find_by_tag('id',(int)$txt);
        }
        else {
            $node = $manager->find_by_tag('alias',$txt);
        }
        if( $node ) return (int)$node->get_tag('id');
        return $dflt;
    }


    /**
     * Perform an HTTP post request.
     *
     * @param string $URL the url to post to
     * @param array $data The array to post.
     * @param string $referer An optional referrer string.
     * @return string
     */
    function http_post($URL,$data = '',$referer='')
    {
        return cge_http::post($URL,$data,$referer);
    }


    /**
     * Perform an HTTP GET request.
     *
     * @param string $URL the url to post to
     * @param string $referer An optional referrer string.
     * @return string
     */
    function http_get($URL,$referer='')
    {
        return cge_http::get($URL,$referer);
    }

  /**
   * Similar to GetPreference except the default value is used even if the preference exists, but is blank.
   *
   * @param string $pref_name The preference name
   * @param string $dflt_value The default value for the preference if not set (or empty)
   * @param bool $allow_empty Wether the default value should be used if the preference exists, but is empty.
   * @return string.
   */
  public function CGGetPreference($pref_name,$dflt_value = null,$allow_empty = FALSE)
  {
    $tmp = trim($this->GetPreference($pref_name,$dflt_value));
    if( !empty($tmp) || is_numeric($tmp) ) return $tmp;
    if( $allow_empty ) return $tmp;
    return $dflt_value;
  }

  /**
   * A wrapper to get a module specific user preference.
   * this method only applies to admin users.
   *
   * @param string $pref_name The preference name
   * @param string $dflt_value The default value for the preference if not set (or empty)
   * @param bool $allow_empty Wether the default value should be used if the preference exists, but is empty.
   * @return string.
   */
  public function CGGetUserPreference($pref_name,$dflt_value = null,$allow_empty = FALSE)
  {
      $key = '__'.$this->GetName().'_'.$pref_name;
      $tmp = cms_userprefs::get($key,$dflt_value);
      if( !empty($tmp) || is_numeric($tmp) ) return $tmp;
      if( $allow_empty ) return $tmp;
      return $dflt_value;
  }

  /**
   * A wrapper to set a user preference that is module specific.
   * this method only applies to admin users.
   *
   * @param string $pref_name The preference name
   * @param string $value The preference value.
   */
  public function CGSetUserPreference($pref_name,$value)
  {
      $key = '__'.$this->GetName().'_'.$pref_name;
      return cms_userprefs::set($key,$value);
  }

  /**
   * A wrapper to remove a user preference that is module specific.
   * this method only applies to admin users.
   *
   * @param string $pref_name The preference name
   * @param string $value The preference value.
   */
  public function CGRemoveUserPreference($pref_name)
  {
      $key = '__'.$this->GetName().'_'.$pref_name;
      return cms_userprefs::remove($key,$value);
  }

  /**
   * find a file for this module
   * looks in module_custom, and in the module directory
   *
   * @param string $filename
   * @return string
   */
  public function find_module_file($filename)
  {
      if( !$filename ) return;
      $tmp = realpath($filename);
      if( $tmp ) return; // absolute paths not accepted.

      $config = cms_config::get_instance();
      $dirlist = [];
      if( version_compare(CMS_VERSION,'2.2-beta1') >= 0 && $config['assets_path'] ) {
          $dirlist[] = $config['assets_path']."/module_custom/".$this->GetName();
      }
      $dirlist[] = $config['root_path']."/module_custom/".$this->GetName();
      $dirlist[] = $this->GetModulePath();
      foreach( $dirlist as $dir ) {
          $fn = "$dir/$filename";
          if( is_file($fn) ) return $fn;
      }
  }

  /**
   * Get a list of module files matching a specified pattern in a specified module subdirectory.
   * This method can be used for finding a list of files matching a pattern (i.e a list of classes, or even a list of templates).
   * This method will search for files in a matching directory in the module_custom directory (if one exists) and in the module directory.
   * i.e: $this->get_module_files('templates','summary*tpl');
   *
   * @param string $dirname The directory name (relative to the module directory) to search in.
   * @param string $pattern An optional pattern, if no pattern is specified, *.* is assumed.
   * @return string[]
   */
  public function get_module_files($dirname,$pattern = null)
  {
      if( !$dirname ) return;
      $tmp = realpath($dirname);
      if( file_exists($dirname) ) return; // absolute paths not accepted.
      if( !$pattern ) $pattern = '*.*';

      $config = cms_config::get_instance();
      $files = [];
      $dirlist = [];
      $dirlist[] = $config['root_path']."/module_custom/".$this->GetName();
      $dirlist[] = $this->GetModulePath();
      foreach( $dirlist as $dir ) {
          $fn = "$dir/$dirname";
          if( !is_dir($fn) ) continue;

          $_list = glob("$fn/$pattern");
          if( !count($_list) ) continue;
          $files = array_merge($files,$_list);
      }
      if( count($files) ) return $files;
  }

  /**
   * Given a filename, search for it in the module_custom and module's templates directory.
   * i.e.: $this->find_template_file('somereport.tpl');
   *
   * @param string $filename The template filename (only the filename) to search for
   * @return string The absolute path to the filename.
   */
  public function find_template_file($filename)
  {
      if( !$filename ) return;
      $filename = "templates/".basename($filename);
      return $this->find_module_file($filename);
  }

  /**
   * A convenience method to generate a new smarty template object given a resource string,
   * and a prefix.  This method will also automatically assign a few common smarty variables
   * to the new scope.
   *
   * Note: the parent smarty scope depends on how this function is called.  If called directly from a module action for the same module
   *  the parent will be the current smarty scope.  If called from any method that is using a different module than the
   *  action module, then the parent scope will be the global smarty scope.
   *
   * @param string $template_name The desired template name.
   * @param string $prefix an optional prefix for database templates.
   * @param string $cache_id An optional smarty cache id.
   * @param string $compile_id An optional smarty compile id.
   * @return object
   */
  public function CreateSmartyTemplate($template_name,$prefix = null,$cache_id = null,$compile_id = null,$parent = null)
  {
      $smarty = null;
      if( $parent ) $smarty = $parent;
      if( !$smarty ) $smarty = $this->GetActionTemplateObject();
      if( !$smarty ) $smarty = Smarty_CMS::get_instance();

      $tpl = $smarty->createTemplate($this->CGGetTemplateResource($template_name,$prefix),$cache_id,$compile_id,$smarty);

      // for convenience, I assign a few smarty variables.
      $tpl->assign('module',$this->GetName());
      $tpl->assign($this->GetName(),$this);
      $tpl->assign('mod',$this);
      $tpl->assign('actionid',$this->get_action_id());
      if( ($actionparams = $smarty->getTemplateVars('actionparams')) ) $tpl->assign('actionparams',$actionparams);
      return $tpl;
  }

  /**
   * A convenience method to generate a smarty resource string given a template name and an optional prefix.
   * if the supplied template name begins with :: then we assume a 'cms_template' resource.
   * if the supplied template name appears to be a smarty resource name we don't do anything.
   * if the supplied template name ends with .tpl then a file template is assumed.
   *
   * @param string $template_name The desired template name
   * @param string $prefix an optional prefix for database templates.
   * @return string
   */
  public function CGGetTemplateResource($template_name,$prefix = null)
  {
      $template_name = trim($template_name);
      if( startswith($template_name,'::') ) {
          $template_name = substr($template_name,2);
          $template_name = 'cms_template:'.$template_name;
      }
      else if( !strpos($template_name,':') ) {
          // it's not a resource.
          if( endswith($template_name,'.tpl') ) return $this->GetFileResource($template_name);
          return $this->GetDatabaseResource($prefix.$template_name);
      }
      if( startswith($template_name,'string:') || startswith($template_name,'eval:') || startswith($template_name,'extends:') ) {
	  throw new \LogicException('Invalid resource name passed to '.__METHOD__);
      }
      return $template_name;
  }

  /**
   * An advanced method to process either a file, or database template for this module
   * through smarty
   *
   * @param string $template_name  The template name.  If the value of this parameter ends with .tpl then a file template is assumed.  Otherwise a database template is assumed.
   * @param string $prefix  For database templates, optionally prefix thie template name with this value.
   * @return string The output from the processed smarty template.
   */
  public function CGProcessTemplate($template_name,$prefix = null)
  {
      $rsrc = $this->CGGetTemplateResource($template_name,$prefix);
      $smarty = $this->GetActionTemplateObject();
      if( !$smarty ) $smarty = Smarty_CMS::get_instance();
      return $smarty->fetch($rsrc);
  }

  /**
   * Get the name of the module that the current action is for.
   * (only works with modules derived from CGExtensions).
   * This method is useful to find the module action that was used to send an event.
   *
   * @return string
   */
  public function GetActionModule()
  {
      return cge_tmpdata::get('module');
  }

  /**
   * Create a url to an action that will show a message.
   *
   * This method is capable of using the \cge_message class to extract longer messages.
   *
   * @param int|string A page id or alias to display the message on
   * @param string $msg The message to display.  Or the message key name.
   * @param bool $is_key If true, it indicates that the $msg parameter is a key to extract from \cge_message.
   * @param bool $is_error Indicates if the message should be displayed as an error.
   * @see CGExtensions::DisplayErrorMessage();
   * @return string The URL to the action.
   */
  public function GetShowMessageURL($page,$msg,$is_key = false,$is_error = false)
  {
      $page = $this->resolve_alias_or_id($page);
      if( !$page ) throw new \LogicException('Invalid page passed to '.__METHOD__);

      $parms = [];
      if( $is_key ) {
          $parms['cge_msgkey'] = trim($msg);
      }
      else {
          $parms['cge_msg'] = trim($msg);
      }
      $parms['cge_error'] = ($is_error) ? 1 : 0;
      $mod = \cms_utils::get_module(MOD_CGEXTENSIONS);
      return $mod->create_url('cntnt01','showmessage',$page,$parms);
  }


  /**
   * Show a message on the frontend of the website.
   * suitable for displaying errors and brief messages.
   *
   * @params tring $msg The message to display
   * @param bool $is_error whether or not the msg is an error
   * @param string $title.  If not an error, optionally display a title to the message.
   */
  public function ShowFormattedMessage($msg,$is_error = FALSE,$title = null)
  {
      if( $is_error ) {
          echo $this->DisplayErrorMessage($msg);
      }
      else {
          // todo... need a template for this.
          echo '<div class="cge_message">';
          if( $title ) echo '<div class="cge_msgtitle">'.$title.'</div>';
          echo '<div class="cge_msgbody">'.$msg.'</div>';
          echo '</div>';
      }
  }

  /**
   * A function to intelligently determine which template to use given parameters, a parameter name, and a type name.
   * This method will either return a template name (string) or null if nothing can be found.
   *
   * @return string|null
   * @param array $params Input module action parameters array.
   * @param strng $paramname The param name that may hold a template name.
   * @param string $typename The complete template TypeName i.e:  Uploads::Summary
   */
  public function find_layout_template( array $params, $paramname, $typename )
  {
      $paramname = (string) $paramname;
      $typename = (string) $typename;
      $thetemplate = null;
      if( !is_array($params) || !($thetemplate = \cge_param::get_string($params,$paramname)) ) {
          $tpl = \CmsLayoutTemplate::load_dflt_by_type($typename);
          if( !is_object($tpl) ) {
              audit('',$this->GetName(),'No default '.$typename.' template found');
              return;
          }
          $thetemplate = $tpl->get_name();
          unset($tpl);
      }
      return $thetemplate;
  }
} // class

/**
 * @ignore
 */
function cgex_lang()
{
    $mod = \cms_utils::get_module(MOD_CGEXTENSIONS);
    $args = func_get_args();
    return call_user_func_array(array($mod,'Lang'),$args);
}

// EOF
