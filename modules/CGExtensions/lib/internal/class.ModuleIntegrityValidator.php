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

final class ModuleIntegrityValidator extends ModuleIntegrityBase
{
    private $_module_name;
    private $_cdat;
    private $_ddat;
    private $_verify_code;
    private $_signature;
    private static $__mod;

    public function __construct($module_name)
    {
        $this->_module_name = trim($module_name);
        $this->_mod = \cms_utils::get_module($module_name);
        if( !$this->_mod ) throw new \RuntimeException(cgex_lang('err_modulenotfound',$module_name));
        $dir = $this->_mod->GetModulePath();
        $this->_cdat = $dir.'/_c1.dat';
        $this->_ddat = $dir.'/_d1.dat';
    }

    private function get_verify_code()
    {
        if( !$this->_verify_code ) {
            $_ddat_contents = file($this->_ddat);
            $this->_verify_code = substr($_ddat_contents[0],0,32);
        }
        return $this->_verify_code;
    }

    private function check_checksum_integrity()
    {
        $salt = $this->get_salt();
        $before = md5_file($this->_cdat);
        $before = $salt.'::'.$before."\n";
        $md5sum = md5($before);
        if( $md5sum != $this->get_verify_code() ) throw new \RuntimeException('Could not verify integrity of the checksum file');
    }

    private function parse_cdat()
    {
        $salt = $this->get_salt();
        $out = array();
        $lines = file($this->_cdat);
        foreach( $lines as $line ) {
            $parts = explode('::',trim($line));
            if( count($parts) != 3 ) throw new \RuntimeException(cgex_lang('err_vrify_c1filebad'));

            $rec = array();
            $rec['file'] = $parts[0];
            $rec['filedata'] = $parts[1];
            if( $parts[2] != md5($rec['file'].'::'.$rec['filedata']."::{$salt}\n") ) {
                throw new \RuntimeException(cgex_lang('err_vrify_c1fildbad'));
            }
            $out[] = $rec;
        }
        return $out;
    }

    public function get_signature()
    {
        if( !$this->_signature ) {
            $dir = $this->_mod->GetModulePath();
            $tmpdata = array();
            $this->walk_directory($dir,function($path) use (&$tmpdata) {
                $key = $this->get_checksum_key($path);
                $val = $this->get_checksum_value($path);
                $sig = $this->get_checksum_signature($key,$val);
                $line = "{$key}::{$val}::{$sig}";
                $tmpdata[] = $line;
                });
            sort($tmpdata);
            $tmpdata = implode("\n",$tmpdata)."\n";

            $salt = $this->get_salt();
            $md5 = md5($tmpdata);
            $this->_signature = md5("{$salt}::{$md5}\n");
        }
        return $this->_signature;
    }

    public function check_extrafiles()
    {
        // walk the directory, generate the key, see if there are any extra files
        $dir = $this->_mod->GetModulePath();
        $cdata = $this->parse_cdat();
        $cdata = \cge_array::to_hash($cdata,'file');
        $tmpdata = array();
        $this->walk_directory($dir,function($path) use (&$tmpdata,$cdata) {
                $key = $this->get_checksum_key($path);
                if( !isset($cdata[$key]) ) {
                    $tmpdata[] = $path;
                }
            });
        if( count($tmpdata) ) return $tmpdata;
    }

    public function check_module_integrity()
    {
        if( !is_file($this->_cdat) || !is_file($this->_ddat) ) {
            throw new \cg_notfoundexception(cgex_lang('err_vrfy_nochecksumdata',$this->_module_name));
        }

        // now validate the _c.dat with the _d.dat
        $this->check_checksum_integrity();

        if( $this->get_verify_code() != $this->get_signature() ) return FALSE;
        return TRUE;
    }

} // end of class

#
# EOF
#
?>