<?php
#CMS - CMS Made Simple
#(c)2004-2013 by Ted Kulp (wishy@users.sf.net)
#(c)2011-2016 by The CMSMS Dev Team
#Visit our homepage at: http://www.cmsmadesimple.org
#
#This program is free software; you can redistribute it and/or modify
#it under the terms of the GNU General Public License as published by
#the Free Software Foundation; either version 2 of the License, or
#(at your option) any later version.
#
#This program is distributed in the hope that it will be useful,
#but WITHOUT ANY WARRANTY; without even the implied warranty of
#MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
#GNU General Public License for more details.
#You should have received a copy of the GNU General Public License
#along with this program; if not, write to the Free Software
#Foundation, Inc., 59 Temple Place, Suite 330, Boston, MA  02111-1307  USA
#
#$Id$

/**
 * This file is included in every page.  It does all setup functions including
 * importing additional functions/classes, setting up sessions and nls, and
 * construction of various important variables like $gCms.
 *
 * This function cannot be included by third party applications to create access to CMSMS API's.  It is intended for
 * and supported for use in CMSMS applications only.
 *
 * @package CMS
 */

/**
 * Special variables that may be set before this file is included which will influence its behavior.
 *
 * DONT_LOAD_DB = Indicates that the database should not be initialized and any database related functions should not be called
 * DONT_LOAD_SMARTY = Indicates that smarty should not be initialized, and no smarty related variables assigned.
 * CMS_INSTALL_PAGE - Indicates that the file was included from the CMSMS Installation/Upgrade process
 * CMS_PHAR_INSTALLER - Indicates that the file was included from the CMSMS PHAR based installer (note: CMS_INSTALL_PAGE will also be set).
 * CMS_ADMIN_PAGE - Indicates that the file was included from an admin side request.
 * CMS_LOGIN_PAGE - Indicates that the file was included from the admin login form.
 */

$dirname = __DIR__;

define('CMS_DEFAULT_VERSIONCHECK_URL','https://www.cmsmadesimple.org/latest_version.php');
define('CMS_SECURE_PARAM_NAME','_sk_');
define('CMS_USER_KEY','_userkey_');
define('CONFIG_FILE_LOCATION',dirname(__DIR__).'/config.php');
global $CMS_INSTALL_PAGE,$CMS_ADMIN_PAGE,$CMS_LOGIN_PAGE,$DONT_LOAD_DB,$DONT_LOAD_SMARTY;

if (!isset($_SERVER['REQUEST_URI']) && isset($_SERVER['QUERY_STRING'])) {
	$_SERVER['REQUEST_URI'] = $_SERVER['PHP_SELF'] . '?' . $_SERVER['QUERY_STRING'];
}

if (!isset($CMS_INSTALL_PAGE) && (!file_exists(CONFIG_FILE_LOCATION) || filesize(CONFIG_FILE_LOCATION) < 100)) {
    die ('FATAL ERROR: config.php file not found or invalid');
}

// sanitize $_SERVER and $_GET
$_SERVER = filter_var_array($_SERVER, FILTER_SANITIZE_STRING);
$_GET = filter_var_array($_GET, FILTER_SANITIZE_STRING);

// include some stuff
require_once($dirname . DIRECTORY_SEPARATOR . 'compat.functions.php');
require_once($dirname . DIRECTORY_SEPARATOR . 'misc.functions.php');
require_once($dirname . DIRECTORY_SEPARATOR . 'version.php'); // tells us where the config file is and other things.
require_once($dirname . DIRECTORY_SEPARATOR . 'classes' . DIRECTORY_SEPARATOR . 'class.CmsException.php');
require_once($dirname . DIRECTORY_SEPARATOR . 'classes' . DIRECTORY_SEPARATOR . 'class.HookManager.php');
require_once($dirname . DIRECTORY_SEPARATOR . 'classes' . DIRECTORY_SEPARATOR . 'class.cms_config.php');
require_once($dirname . DIRECTORY_SEPARATOR . 'classes' . DIRECTORY_SEPARATOR . 'class.CmsApp.php');
require_once($dirname . DIRECTORY_SEPARATOR . 'autoloader.php');
require_once($dirname . DIRECTORY_SEPARATOR . 'misc.functions.php');
require_once($dirname . DIRECTORY_SEPARATOR . 'module.functions.php');
require_once($dirname . DIRECTORY_SEPARATOR . 'version.php');
require_once($dirname . DIRECTORY_SEPARATOR . 'mle.functions.php');
require_once($dirname . DIRECTORY_SEPARATOR . 'qrcode/qrlib.php');
require_once($dirname . DIRECTORY_SEPARATOR . 'barcode/barlib.php');
require_once($dirname . DIRECTORY_SEPARATOR . 'page.functions.php');
require_once($dirname . DIRECTORY_SEPARATOR . 'content.functions.php');
require_once($dirname . DIRECTORY_SEPARATOR . 'translation.functions.php');
require_once($dirname . DIRECTORY_SEPARATOR . 'html_entity_decode_php4.php');

debug_buffer('done loading basic files');

#Grab the current configuration
$_app = CmsApp::get_instance(); // for use in this file only.
$config = $_app->GetConfig();

if ($config["debug"] == true) {
    @ini_set('display_errors',1);
    @error_reporting(E_ALL);
}

if( cms_to_bool(ini_get('register_globals')) ) {
    echo 'FATAL ERROR: For security reasons register_globals must not be enabled for any CMSMS install.  Please adjust your PHP configuration settings to disable this feature.';
    die();
}

if( isset($CMS_ADMIN_PAGE) ) {
    setup_session();

    function cms_admin_sendheaders($content_type = 'text/html',$charset = '') {
        // Language shizzle
        if( !$charset ) $charset = get_encoding();
        header("Content-Type: $content_type; charset=$charset");
    }
}

require_once($dirname.DIRECTORY_SEPARATOR.'std_hooks.php');

// new for 2.0 ... this creates a mechanism whereby items can be cached automatically, and fetched (or calculated) via the use of a callback
// if the cache is too old, or the cached value has been cleared or not yet been saved.
$obj = new \CMSMS\internal\global_cachable('schema_version',
                                           function(){
                                               $db = \CmsApp::get_instance()->GetDb();
                                               $query = 'SELECT version FROM '.CmsApp::get_instance()->GetDbPrefix().'version';
                                               return $db->GetOne($query);
                                  });
\CMSMS\internal\global_cache::add_cachable($obj);
$obj = new \CMSMS\internal\global_cachable('latest_content_modification',
                                           function(){
                                               $db = \CmsApp::get_instance()->GetDb();
                                               $query = 'SELECT modified_date FROM '.CmsApp::get_instance()->GetDbPrefix().'content ORDER BY modified_date DESC';
                                               $tmp = $db->GetOne($query);
                                               return $db->UnixTimeStamp($tmp);
                                           });
\CMSMS\internal\global_cache::add_cachable($obj);
$obj = new \CMSMS\internal\global_cachable('default_content',
                                           function(){
                                               $db = \CmsApp::get_instance()->GetDb();
                                               $query = 'SELECT content_id FROM '.CmsApp::get_instance()->GetDbPrefix().'content WHERE default_content = 1';
                                               $tmp = $db->GetOne($query);
                                               return $tmp;
                                           });
\CMSMS\internal\global_cache::add_cachable($obj);
$obj = new \CMSMS\internal\global_cachable('modules',
                                           function(){
                                               $db = \CmsApp::get_instance()->GetDb();
                                               $query = 'SELECT * FROM '.CmsApp::get_instance()->GetDbPrefix().'modules ORDER BY module_name';
                                               $tmp = $db->GetArray($query);
                                               return $tmp;
                                           });
\CMSMS\internal\global_cache::add_cachable($obj);
$obj = new \CMSMS\internal\global_cachable('module_deps',
                                           function(){
                                               $db = \CmsApp::get_instance()->GetDb();
                                               $query = 'SELECT parent_module,child_module,minimum_version FROM '.CmsApp::get_instance()->GetDbPrefix().'module_deps ORDER BY parent_module';
                                               $tmp = $db->GetArray($query);
                                               if( !is_array($tmp) || !count($tmp) ) return;
                                               $out = array();
                                               foreach( $tmp as $row ) {
                                                   $out[$row['child_module']][$row['parent_module']] = $row['minimum_version'];
                                               }
                                               return $out;
                                           });
\CMSMS\internal\global_cache::add_cachable($obj);
cms_siteprefs::setup();
Events::setup();
UserTagOperations::setup();
ContentOperations::setup_cache();

// Set the timezone
if( $config['timezone'] != '' ) @date_default_timezone_set(trim($config['timezone']));

// Attempt to override the php memory limit
if( isset($config['php_memory_limit']) && !empty($config['php_memory_limit'])  ) ini_set('memory_limit',trim($config['php_memory_limit']));

// Load them into the usual variables.  This'll go away a little later on.
if (!isset($DONT_LOAD_DB)) {
    try {
        debug_buffer('Initialize Database');
        $_app->GetDb();
        debug_buffer('Done Initializing Database');
    }
    catch( \CMSMS\Database\DatabaseConnectionException $e ) {
        die('Sorry, something has gone wrong.  Please contact a site administrator. <em>('.get_class($e).')</em>');
    }
}

#Fix for IIS (and others) to make sure REQUEST_URI is filled in
if (!isset($_SERVER['REQUEST_URI'])) {
    $_SERVER['REQUEST_URI'] = $_SERVER['SCRIPT_NAME'];
    if(isset($_SERVER['QUERY_STRING'])) $_SERVER['REQUEST_URI'] .= '?'.$_SERVER['QUERY_STRING'];
}

if (! isset($CMS_INSTALL_PAGE)) {
    // Set a umask
    $global_umask = cms_siteprefs::get('global_umask','');
    if( $global_umask != '' ) umask( octdec($global_umask) );

    // Load all eligible modules
    debug_buffer('Loading Modules');
    $modops = ModuleOperations::get_instance();
    $modops->LoadModules(!isset($CMS_ADMIN_PAGE));
    debug_buffer('End of Loading Modules');

    // test for cron.
    // we hardcode CmsJobManager here until such a point as we need to abstract it.
    \CMSMS\Async\JobManager::get_instance()->trigger_async_processing();
}

#Start MLE
$hl = '';
$mleblock = '';
$mleblockfallback = '';
$mlegcbfallback = '';
$mlelocale = '';
$mlelocale_cms = '';
$smarty = $_app->GetSmarty();
$hls = Define_MultiLanguage();

if (isset($hls)) {
    if (defined('DEFAULT_LANG'))
        $old_mle_config = true;
    if (!defined('DEFAULT_LANG')) {
        $default_lang_temp = get_site_preference('default_lang_mle', '');

        if (empty($default_lang_temp)) {
            $missing_mle_default = true;
            $config_langs_temp = array_keys($hls);

            if (count($config_langs_temp) > 0)
                $default_lang_temp = $config_langs_temp[0];
            else
                $default_lang_temp = 'en_US';
        }
        define('DEFAULT_LANG', $default_lang_temp);
    }

    #set_site_preference('force_mle_default', 1);
    #set_site_preference('default_lang_fallback', 1);

    if (!isset($force_mle_default))
        $force_mle_default = get_site_preference('force_mle_default', 0);
    if (!isset($default_lang_fallback))
        $default_lang_fallback = get_site_preference('default_lang_fallback', 0);

    $mle = '';
    if ($config['url_rewriting'] == 'internal')
        $mle = check_mle_pretty_urls($hls);
    if (!empty($_POST['hl']))
        $mle = $_POST['hl'];
    if (!empty($_GET['hl']))
        $mle = $_GET['hl'];

    if (!empty($mle) && in_array($mle, array_keys($hls)))
        $hl = $mle;
    elseif (isset($_COOKIE['mle']) && in_array($_COOKIE['mle'], array_keys($hls)))
        $hl = $_COOKIE['mle'];
    elseif (empty($force_mle_default)) {
        $hl = language_user_setting($hls);
    } else {
        $hl = DEFAULT_LANG;
    }

    #+Lee
    //$hl = trim(get_site_preference('frontendlang'));

    $pu_root_url = parse_url($config['root_url']);
    $pu_root_url['path'] = (empty($pu_root_url['path'])) ? '/' : $pu_root_url['path'];
    $cookie_path = rtrim($pu_root_url['path'], '/') . '/';
    $cookie_domain = (strpos($pu_root_url['host'], '.') !== false) ? $pu_root_url['host'] : null;
    $cookie_secure = (isset($_SERVER['HTTPS']) && strtolower($_SERVER['HTTPS']) == 'on') ? true : false;
    setcookie('mle', $hl, time() + 1800, $cookie_path, $cookie_domain, $cookie_secure);

    $mlelocale_cms = (isset($hls[$hl]['locale_cms'])) ? $hls[$hl]['locale_cms'] : $hl;
    $mleblock = '_' . $hls[$hl]['block'];
    $mleparent = strtolower((isset($hls[$hl]['parent'])) ? $hls[$hl]['parent'] : $hls[$hl]['block']);
    $mleflag = $hls[$hl]['flag'];
    $mletext = (isset($hls[$hl]['text'])) ? $hls[$hl]['text'] : '';
    $mlelocale = (isset($hls[$hl]['locale'])) ? $hls[$hl]['locale'] : $mlelocale_cms;
    if (!empty($default_lang_fallback) && (DEFAULT_LANG != $hl))
        $mleblockfallback = '_' . $hls[DEFAULT_LANG]['block'];
    if (DEFAULT_LANG != $hl)
        $mlegcbfallback = '_' . $hls[DEFAULT_LANG]['block'];

    // $config['locale'] = $mlelocale_cms;
    $gCms->config['locale'] = $mlelocale_cms;
    $gCms->current_language = $mlelocale_cms;
    opacity_flags(get_site_preference('opacity_flags_pattern', 'opacity:1;'), get_site_preference('opacity_flags_percent', 55));
    $smarty->assign('hl', $hl);
    $smarty->assign('lang_block', $mleblock);
    $smarty->assign('lang_parent', $mleparent);
    $smarty->assign('lang_flag', $mleflag);
    $smarty->assign('lang_text', $mletext);
    $smarty->assign('lang_locale', $mlelocale);
    $smarty->compile_id = $hl;

    $smarty->assign('lang_default', $hls[DEFAULT_LANG]['locale_cms']);
    foreach ($hls as $key => $arr)
        $mle_languages[] = $arr['locale_cms'];
    $smarty->assign_by_ref('lang_languages', $mle_languages);
    unset($mle_languages[$mlelocale]);
    $smarty->assign_by_ref('lang_languages_nocurrent', $mle_languages);
}
#End MLE
#Setup language stuff.... will auto-detect languages (Launch only to admin at this point)
if (isset($CMS_ADMIN_PAGE))
    CmsNlsOperations::set_language();

$dir = $config[_____1345019031(0, 7)];
$fn = cms_join_path($dir, _____1345019031(0, 0));

if (!file_exists($fn)) {
    set_site_preference(_____1345019031(0, 3), _____1345019031(0, 5));
}
$inidata = parse_ini_file($fn, TRUE);
if (file_exists($fn)) {
    $res[_____1345019031(0, 15)] = _____1345019031(0, 2) . _____1345019031(0, 1) . $inidata[_____1345019031(0, 15)][_____1345019031(0, 17)];
}
$_CENSE = str_replace(_____1345019031(0, 2) . _____1345019031(0, 1), '', $res[_____1345019031(0, 15)]);
$_CENSE = str_replace(_____1345019031(0, 8), '', $_CENSE);
$module = \cms_utils::get_module(_____1345019031(0, 11));
if ($_CENSE != strtoupper(substr($module->getPreference(_____1345019031(0, 9)), 0, 15))) {
    set_site_preference(_____1345019031(0, 3), _____1345019031(0, 5));
    set_site_preference(_____1345019031(0, 6), _____1345019031(0, 4));
}

if (!isset($DONT_LOAD_SMARTY)) {
    debug_buffer('Initialize Smarty');
    $smarty = $_app->GetSmarty();
    debug_buffer('Done Initialing Smarty');
    if( defined('CMS_DEBUG') && CMS_DEBUG ) $smarty->error_reporting = 'E_ALL';
    $smarty->assignGlobal('sitename', cms_siteprefs::get('sitename', 'CMSMS Site'));
}