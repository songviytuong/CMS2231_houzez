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
 * This file contains the cge_cached_remote_file class and various utilities.
 *
 * @package CGExtensions
 * @category Utilities
 * @author  calguy1000 <calguy1000@cmsmadesimple.org>
 * @copyright Copyright 2010 by Robert Campbell
 */

/**
 * A class to copy a remote URL to a local, temporary location for a specified amount of time.
 *
 * @package CGExtensions
 */
class cge_cached_remote_file
{
    /**
     * @ignore
     */
    private $_cache_timelimit = null;

    /**
     * @ignore
     */
    private $_src_spec = null;

    /**
     * @ignore
     */
    private $_cache_file = null;

    /**
     * Constructor
     *
     * @param string $src The source URL
     * @param int  $timelimit The amount of time in minutes before this file must be refreshed.  Default is 24 hours.
     * @param string $dest Optional destination filename.
     * @param bool $public Optional. If public is set, and dest is not set, attempt to use the PUBLIC_CACHE_LOCATION for the destination.
     */
    public function __construct($src, $timelimit = 0, $dest = '', $public = FALSE)
    {
        $this->_src_spec = $src;
        if( $timelimit <= 0 ) $timelimit = 24*60;
        $this->_cache_timelimit = $timelimit;
        if( empty($dest) ) {
            $bn = 'cgecrf_'.md5($src);
            $base = TMP_CACHE_LOCATION;
            if( $public && defined('PUBLIC_CACHE_LOCATION') ) $base = PUBLIC_CACHE_LOCATION;
            $dest = cms_join_path($base,$bn);
        }
        $this->_cache_file = $dest;
    }

    /**
     * Return the source URL
     *
     * @return string
     */
    public function get_source()
    {
        return $this->_src_spec;
    }

    /**
     * Get the destination filename
     *
     * @return string
     */
    public function get_dest()
    {
        return $this->_cache_file;
    }

    /**
     * Get the time limit
     *
     * @return int
     */
    public function get_cache_timelimit()
    {
        return $this->_cache_timelimit;
    }

    /**
     * Adjust the time limit
     *
     * @param int $minutes The number of minutes before this item needs refreshing
     */
    public function set_cache_timelimit($minutes)
    {
        $this->_cache_timelimit = max(1,(int)$minutes);
    }

    /**
     * @ignore
     */
    private function refresh_cache()
    {
        @unlink($this->_cache_file);
        $data = cge_http::get($this->_src_spec);
        if( $data ) @file_put_contents($this->_cache_file,$data);
    }

    /**
     * @ignore
     */
    private function check_cache()
    {
        $need_update = false;
        $mtime = -1;
        if( !file_exists($this->_cache_file) ) {
            $need_update = true;
        }
        else {
            $mtime = filemtime($this->_cache_file);
        }
        if( $mtime + ($this->_cache_timelimit * 60) < time() ) $need_update = true;
        if( $need_update ) $this->refresh_cache();
    }

    /**
     * Return the entire cached file into an array
     *
     * @return array
     * @see file()
     */
    public function file()
    {
        $this->check_cache();
        return @file($this->_cache_file);
    }

    /**
     * Return the contents of the cached file as a single string
     *
     * @return string
     */
    public function file_get_contents()
    {
        $this->check_cache();
        return @file_get_contents($this->_cache_file);
    }

    /**
     * Return the md5 signature of the cached file
     *
     * @return string
     */
    public function md5()
    {
        $this->check_cache();
        return @md5_file($this->_cache_file);
    }

    /**
     * Get the size of the cached file
     *
     * @return int
     */
    public function size()
    {
        $this->check_cache();
        return @filesize($this->_cache_file);
    }

    /**
     * Clean up the cached file.
     */
    public function cleanup()
    {
        @unlink($this->_cache_file);
    }
} // end of class.
#
# EOF
#
?>