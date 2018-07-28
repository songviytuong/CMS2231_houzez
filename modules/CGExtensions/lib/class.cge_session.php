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
 * This file defines the cge_session class.
 *
 * @package CGExtensions
 * @category Utilities
 * @author  calguy1000 <calguy1000@cmsmadesimple.org>
 * @copyright Copyright 2010 by Robert Campbell
 */

/**
 * A simple class for storing, and retrieving data from the session.
 *
 * Sample Usage:<br/>
 * <code>
 * $sess = new cge_session(__FILE__);<br/>
 * $sess->put('foo','bar');<br/>
 * $foo = $sess->get('foo');
 * </code>
 */
class cge_session
{
    /**
     * @ignore
     */
    private $_keyname;

    /**
     * Constructor.
     *
     * @param string $keyname  An optional primary key for the session data.  The key is useful for preventing conflicts in session data stored by different modules or actions.
     */
    public function __construct($keyname = null)
    {
        $keyname = trim((string)$keyname);
        if( !$keyname ) $keyname = 's'.md5(__FILE__);
        $this->_keyname = $keyname;
    }

    /**
     * Clear or erase a session variable.
     *
     * @param string $key The session variable to erase.  If no data is specified, all data associated with the primary key will be erased.
     */
    public function clear($key = '')
    {
        $key = trim((string) $key);
        if( empty($key) ) {
            unset($_SESSION[$this->_keyname]);
        }
        else {
            unset($_SESSION[$this->_keyname][$key]);
        }
    }

    /**
     * Set a session variable.
     * This is an alias for the put method.
     *
     * @param string $key
     * @param mixed $value
     */
    public function set($key,$value)
    {
        $this->put($key,$value);
    }

    /**
     * Set a session variable.
     * This is an alias for the put method.
     *
     * @param string $key
     * @param mixed $value
     */
    public function put($key,$value)
    {
        $key = trim((string) $key);
        if( !isset($_SESSION[$this->_keyname]) )  $_SESSION[$this->_keyname] = array();
        $_SESSION[$this->_keyname][$key] = $value;
    }

    /**
     * Test if a session variable exists.
     *
     * @param string $key
     * @return bool
     */
    public function exists($key)
    {
        $key = trim((string) $key);
        if( !isset($_SESSION[$this->_keyname]) ) return FALSE;
        if( !isset($_SESSION[$this->_keyname][$key]) ) return FALSE;
        return TRUE;
    }

    /**
     * Retrieve a session variable.
     *
     * @param string $key
     * @param mixed $dfltvalue The default value to return if the data cannot be found in the session.
     * @return mixed
     */
    public function get($key,$dfltvalue=null)
    {
        $key = trim((string) $key);
        if( !isset($_SESSION[$this->_keyname]) ) return $dfltvalue;
        if( !isset($_SESSION[$this->_keyname][$key]) ) return $dfltvalue;
        return $_SESSION[$this->_keyname][$key];
    }

} // end of class

#
# EOF
#
?>
