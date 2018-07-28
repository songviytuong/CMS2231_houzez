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
 * A convenience class to share data between classes and functions without using global variables.
 * Data stored using this class does not survive after the request.
 *
 * @package CGExtensions
 * @category Utilities
 * @author  calguy1000 <calguy1000@cmsmadesimple.org>
 * @copyright Copyright 2010 by Robert Campbell
 */

/**
 * A convenience class to share data between classes and functions without using global variables.
 * Data stored using this class does not survive after the request.
 *
 * @package CGExtensions
 */
final class cge_tmpdata
{
    /**
     * @ignore
     */
    private static $_data;

    /**
     * @ignore
     */
    private static function _setup()
    {
        if( !is_array(self::$_data) ) self::$_data = array();
    }

    /**
     * Test if the specified key exists in stored data.
     *
     * @param string $key
     * @return bool
     */
    public static function exists($key)
    {
        if( empty($key) ) return FALSE;
        if( !is_array(self::$_data) ) return FALSE;
        if( !isset(self::$_data[$key]) ) return FALSE;
        return TRUE;
    }

    /**
     * Return the value of the specified key
     *
     * @param string $key
     * @param mixed $dflt The default value to return if the key does not exist.
     * @return mixed
     */
    public static function get($key,$dflt = null)
    {
        if( self::exists($key) ) return self::$_data[$key];
        return $dflt;
    }

    /**
     * Set the specified data into temporary storage
     *
     * @param string $key
     * @param mixed $value
     */
    public static function set($key,$value)
    {
        if( !empty($key) ) {
            self::_setup();
            self::$_data[$key] = $value;
        }
    }

    /**
     * Erase the data associated with the specified key from temporary storage.
     *
     * @param string $key
     */
    public static function erase($key)
    {
        if( self::exists($key) ) unset(self::$_data[$key]);
    }
} // end of class

#
# EOF
#
?>