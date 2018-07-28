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
 * This file contains classes and utilities to assist modules.
 *
 * @package CGExtensions
 * @category Utilities
 * @author  calguy1000 <calguy1000@cmsmadesimple.org>
 * @copyright Copyright 2010 by Robert Campbell
 */

/**
 * The module helper class is an abstract class, intended to help separate functionality into different classes
 * Each instance of this class is a singleton.
 *
 * @deprecated
 */
class module_helper
{
    /**
     * @ignore
     */
    protected function __construct() {}

    /**
     * @ignore
     */
    static public function &get_instance($name)
    {
        return cge_utils::get_module($name);
    }

    /**
     * Get a preference from a named module.
     *
     * @deprecated
     * @param string $modulename The module name.
     * @param string $preference The preference name.
     * @param string $dflt The default value to return.
     * @return string
     */
    static public function get_preference($modulename,$preference,$dflt = null)
    {
        $module = self::get_instance((string) $modulename);
        if( !$module ) return $dflt;

        return $module->GetPreference((string) $preference,$dflt);
    }

    /**
     * Return a list of all of the modules that have the specified method.
     *
     * @deprecated
     * @param string $methodname
     * @return string[]
     */
    static public function get_modules_with_method($methodname)
    {
        $res = array();

        $modules = ModuleOperations::get_instance()->GetInstalledModules();
        foreach( $modules as $onemodule ) {
            $mod = ModuleOperations::get_instance()->get_module_instance($onemodule);
            if( !$mod ) continue;

            if( !method_exists($mod,$methodname) ) continue;
            $res[$mod->GetName()] = $mod->GetFriendlyName();
        }

        if( empty($res) ) return FALSE;
        return $res;
    }

    /**
     * Return a list of all of the modules that extend the specified interface
     *
     * @param string $classname
     * @return string[]
     */
    static public function get_modules_by_interface($classname)
    {
        $res = [];
        if( startswith( $classname, '\\') ) $classname = substr($classname,1);

        $modules = ModuleOperations::get_instance()->GetInstalledModules();
        foreach( $modules as $onemodule ) {
            $mod = ModuleOperations::get_instance()->get_module_instance($onemodule);
            if( !$mod ) continue;

            $tmp = class_implements($mod);
            if( !in_array( $classname, $tmp ) ) continue;
            $res[$mod->GetName()] = $mod->GetFriendlyName();
        }

        if( empty($res) ) return;
        return $res;
    }

    /**
     * Get a list of all of the modules that have the specified capability.
     *
     * @deprecated
     * @param string $capability
     * @param array $params
     * @return string[]
     */
    static public function get_modules_with_capability($capability,$params = array())
    {
        $mod = cms_utils::get_module(MOD_CGEXTENSIONS);
        $tmp = $mod->GetModulesWithCapability($capability,$params);
        if( is_array($tmp) && count($tmp) ) {
            $t2 = array();
            for( $i = 0, $n = count($tmp); $i < $n; $i++ ) {
                $t2[$tmp[$i]] = $tmp[$i];
            }
            return $t2;
        }
    }
} // class

#
# EOF
#
?>