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
 * A tool that can validate the file integrity of a module (given _c1.dat and _c2.dat files in the module directory.)
 *
 * @package CGExtensions/internal
 * @ignore
 */

namespace CGExtensions\internal;

abstract class ModuleIntegrityBase
{
    protected $_mod;
    private $_excludes = array('*~','#*#','.#*','.svn','CVS','*.bak','.git*','*.tmp','.cms_ignore','*.swp','_internal phpdoc.xml','*.lock','*.part',
                               '_c.dat','_d.dat','_c1.dat','_d1.dat');

    protected final function get_salt()
    {
        $salt = $this->_mod->GetName().'::'.$this->_mod->GetVersion();
        return $salt;
    }

    protected function is_excluded($filename)
    {
        foreach( $this->_excludes as $ex ) {
            if( $filename == $ex ) return TRUE;
            if( fnmatch($ex,$filename) ) return TRUE;
        }
        return FALSE;
    }

    protected final function get_checksum_key($filename)
    {
        if( !is_file($filename) ) throw new \LogicException(cgex_lang('err_vrfy_filenotfound',$filename));

        $dir = $this->_mod->GetModulePath();
        if( !startswith($filename,$dir) ) throw new \LogicException(cgex_lang('err_vrfy_rootpath',$filename));

        // make into relative filename
        $rel = substr($filename,strlen($dir));
        while( startswith($rel,'/') ) $rel = substr($rel,1);

        $salt = $this->get_salt();
        $md5sum = md5_file($filename);
        $inp = "{$salt}::{$rel}\n";
        $key = md5($inp);
        return $key;
    }

    protected final function get_checksum_value($filename)
    {
        if( !is_file($filename) ) throw new \LogicException(cgex_lang('err_vrfy_filenotfound',$filename));

        $dir = $this->_mod->GetModulePath();
        if( !startswith($filename,$dir) ) throw new \LogicException(cgex_lang('err_vrfy_rootpath',$filename));

        $salt = $this->get_salt();
        $md5 = md5_file($filename);
        $inp = "{$salt}::{$md5}\n";
        $val = md5($inp);
        return $val;
    }

    protected final function get_checksum_signature($key,$val)
    {
        $salt = $this->get_salt();
        $md5 = md5($key.'::'.$val.'::'.$salt."\n");
        return $md5;
    }

    // recursive function to walk directories
    protected final function walk_directory($dir,$callback)
    {
        $dh = opendir($dir);
        while( false !== ($entry = readdir($dh)) ) {
            if( startswith($entry,'.') ) continue;   // ignore dot files
            if( $this->is_excluded($entry) ) continue;

            $path = $dir.'/'.$entry;
            if( is_dir($path) ) {
                $this->walk_directory($path,$callback);
            }
            else {
                $callback($path);
                // we only deal with files
            }
        }
        closedir($dh);
    }

} // end of class

#
# EOF
#
?>
