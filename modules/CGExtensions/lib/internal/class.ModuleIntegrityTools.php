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
 * A set of high level internal utilities.
 *
 * @package CGExtensions/internal
 * @category Internal
 * @author  calguy1000 <calguy1000@cmsmadesimple.org>
 * @copyright Copyright 2010 by Robert Campbell
 * @ignore
 */

/**
 * Tools for checking the integrity of one or more modules.
 *
 * @package CGExtensions/internal
 * @ignore
 */

namespace CGExtensions\internal;

final class ModuleIntegrityTools
{
    private static $__mod;
    private function __construct() {}

    private static function lang()
    {
        if( !self::$__mod ) self::$__mod = \cge_utils::get_module('CGExtensions');

        $args = func_get_args();
        return call_user_func_array(array(self::$__mod,'Lang'),$args);
    }

    private static function check_module($module_name)
    {
        $rec = array('module'=>$module_name,'status'=>-2,'checksum'=>null,'message'=>null);
        $mod = \cms_utils::get_module($module_name);
        if( !$mod ) throw new \cg_notfoundException($module_name.' could not be loaded');
        $rec['version'] = $mod->GetVersion();

        try {
            $checker = new \CGExtensions\internal\ModuleIntegrityValidator($module_name);
            $rec['checksum'] = $checker->get_signature();
            $rec['status'] = 0;
            if( $checker->check_module_integrity()) {
                $rec['status'] = 1;
                $rec['message'] = self::lang('msg_vrfy_integrityverified');
            }
            else {
                if( $checker->check_extrafiles() ) {
                    $rec['message'] = self::lang('err_vrfy_extrafiles');
                } else {
                    $rec['message'] = self::lang('stat_vrfy_passed');
                }
            }
        }
        catch( \cg_notfoundexception $e ) {
            $rec['status'] = -1;
            $rec['message'] = $e->GetMessage();
        }
        catch( \Exception $e ) {
            $rec['status'] = 0;
            $rec['message'] = $e->GetMessage();
        }

        return $rec;
    }

    public static function check_noncore_modules()
    {
        $module_names = \ModuleOperations::get_instance()->GetInstalledModules();
        if( !count($module_names) ) throw new \LogicException('Could not get a list of installed modules');

        $out = array();
        foreach( $module_names as $module_name ) {
            if( \ModuleOperations::get_instance()->IsSystemModule($module_name) ) continue; // ignore system modules.

            $out[] = self::check_module($module_name);
        }
        return $out;
    }

    public static function check_cge_modules()
    {
        $module_names = ModuleOperations::get_instance()->GetInstalledModules();
        if( !count($module_names) ) throw new \LogicException('Could not get a list of installed modules');

        $out = array();
        foreach( $module_names as $module_name ) {
            if( ModuleOperations::get_instance()->IsSystemModule($module_name) ) continue; // ignore system modules.

            $mod = \cms_utils::get_module($module_name);
            if( !$mod ) throw new \cg_notfoundException($module_name.' could not be loaded');
            if( !$mod instanceof CGExtensions ) continue;

            $out[] = self::check_module($module_name);
        }
        return $out;
    }

    public static function has_checksum_data($mod)
    {
        if( is_string($mod) ) $mod = \cms_utils::get_module($mod);
        if( !is_object($mod) || !$mod instanceof \CMSModule ) throw new \LogicException('Invalid data passed to '.__METHOD__);

        $dir = $mod->GetModulePath();
        if( is_file("$dir/_c1.dat") && is_file("$dir/_d1.dat") ) return TRUE;
        return FALSE;
    }

    public static function get_cached_status($module_name)
    {
        $driver = new \cms_filecache_driver(array('cache_dir'=>TMP_CACHE_LOCATION,'lifetime'=>24*3600));
        $val = $driver->get($module_name,__CLASS__);
        if( !$val ) {
            // gotta do it ourselves
            $val = self::check_module($module_name);
            $driver->set($module_name,serialize($val),__CLASS__);
        }
        else {
            $val = unserialize($val);
        }
        return $val;
    }

    public static function clear_cached_checks()
    {
        $driver = new \cms_filecache_driver(array('cache_dir'=>TMP_CACHE_LOCATION,'lifetime'=>24*3600));
        $driver->clear(__CLASS__);
    }
}