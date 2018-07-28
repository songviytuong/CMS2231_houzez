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
 * A utility class for caching encrypted information.
 *
 * @package CGExtensions
 * @category Utilities
 * @author  calguy1000 <calguy1000@cmsmadesimple.org>
 * @copyright Copyright 2010 by Robert Campbell
 */

/**
 * A utility class for caching encrypted information.
 * This class automatically calculates an encryption key with session specific entropy.
 * However the encryption key can be overridden.
 *
 * @package CGExtensions
 * @see cge_datastore
 * @see cge_encrypt
 */
final class encrypted_store
{
    /**
     * @ignore
     */
    static private $_store;

    /**
     * @ignore
     */
    static private $_key;

    /**
     * @ignore
     */
    static private $_enckey;

    /**
     * @ignore
     */
    static private $_timeout = 600;

    /**
     * @ignore
     */
    private function __construct() {}


    /**
     * @ignore
     */
    private static function __make()
    {
        if( is_null(self::$_store) ) {
            self::$_store = new cge_datastore(self::$_timeout);
            self::$_key = md5(__FILE__);

            $config = cms_config::get_instance();
            $key = md5(__FILE__ . $config['root_url'] . $config['root_path'] . getenv('REMOTE_ADDR'));
            self::$_enckey = $key;
        }
    }


    /**
     * Get the data expiry time in seconds
     *
     * @return int
     */
    static public function get_timeout()
    {
        return self::$_timeout;
    }


    /**
     * Set the data expiry time in seconds.
     * Since this is encrypted data, it's lifetime is expected to be very short.
     * A maximum of 5 minutes (300 seconds)
     *
     * @param int $num  Expiry timeout in seconds.
     */
    static public function set_timeout($num)
    {
        $num = max($num,300);
        self::$_timeout = $num;
        if( is_object(self::$_store) ) self::$_store->set_expiry($num);
    }


    /**
     * Override the encryption key.
     * It is important to set this key with a long enough value and with enough entropy
     * to be random for different purposes.  i.e: if storing user specific data
     * for a short time it may be appropriate to use the session id as part of the encryption key.
     *
     * @param string $str
     */
    static public function set_key($str)
    {
        self::$_key = $str;
    }


    /**
     * Store encrypted data
     *
     * @param string $data  The data to store
     * @param string $key1 The first key in the encrypted set.  Up to three keys can be used
     * @param string $key2 The optional second key in the encrypted set
     * @param string $key3 The optional third key in the encrypted set
     */
    static public function put($data,$key1,$key2='',$key3='')
    {
        self::__make();
        if( is_null(self::$_enckey) ) die('abort - no encryption key set');
        $ser = serialize($data);
        $tmp = cge_encrypt::encrypt(self::$_enckey,$ser);
        self::$_store->store(base64_encode($tmp),self::$_key,$key1,$key2,$key3);
    }


    /**
     * A convenience method to store data with a special encryption key.
     *
     * @param string $data  The data to store
     * @param string $specialkey The override encryption key.
     * @param string $key1 The first key in the encrypted set.  Up to three keys can be used
     * @param string $key2 The optional second key in the encrypted set
     * @param string $key3 The optional third key in the encrypted set
     */
    static public function put_special($data,$specialkey,$key1,$key2='',$key3='')
    {
        self::__make();
        $tmp = cge_encrypt::encrypt($specialkey,serialize($data));
        self::$_store->store(base64_encode($tmp),self::$_key,$key1,$key2,$key3);
    }

    /**
     * unencrypt and return stored data
     *
     * @param string $key1 The first key in the encrypted set.  Up to three keys can be used
     * @param string $key2 The optional second key in the encrypted set
     * @param string $key3 The optional third key in the encrypted set
     * @return string.
     */
    static public function get($key1,$key2='',$key3='')
    {
        self::__make();
        $tmp = self::$_store->get(self::$_key,$key1,$key2,$key3);
        $tmp = base64_decode($tmp);
        if( !$tmp ) return;
        $tmp = cge_encrypt::decrypt(self::$_enckey,$tmp);
        if( !$tmp ) return;
        return @unserialize($tmp);
    }

    /**
     * unencrypt and return stored data using a special encryption key
     *
     * @param string $key1 The first key in the encrypted set.  Up to three keys can be used
     * @param string $specialkey The override encryption key.
     * @param string $key2 The optional second key in the encrypted set
     * @param string $key3 The optional third key in the encrypted set
     * @return string.
     */
    static public function get_special($specialkey,$key1,$key2='',$key3='')
    {
        self::__make();
        $tmp = self::$_store->get(self::$_key,$key1,$key2,$key3);
        $tmp = base64_decode($tmp);
        $data = unserialize(cge_encrypt::decrypt($specialkey,$tmp));
        return $data;
    }

    /**
     * Erase encrypted data from the datastore
     *
     * @param string $key1 The first key in the encrypted set.  Up to three keys can be used
     * @param string $key2 The optional second key in the encrypted set
     * @param string $key3 The optional third key in the encrypted set
     */
    static public function erase($key1,$key2='',$key3='')
    {
        self::__make();
        self::$_store->erase(self::$_key,$key1,$key2,$key3);
    }

    /**
     * Clean all expired data.
     */
    static public function cleanup()
    {
        self::__make();
        self::$_store->remove_expired();
    }
} // end of class

// EOF
?>