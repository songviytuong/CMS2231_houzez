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

final class ModuleIntegrityCodeGenerator extends ModuleIntegrityBase
{
    private $_module_name;
    private $_c1dat;
    private $_d1dat;

    public function __construct($module_name)
    {
        $this->_module_name = trim($module_name);
        $this->_mod = \cms_utils::get_module($module_name);
        if( !$this->_mod ) throw new \RuntimeException(cgex_lang('err_modulenotfound',$module_name));

        $dir = $this->_mod->GetModulePath();
        $this->_c1dat = $dir.'/_c1.dat';
        $this->_d1dat = $dir.'/_d1.dat';
        if( !is_writable($dir) ) throw new \RuntimeException(cgex_lang('err_vrfy_dirwritable',$module_name));

        if( is_file($this->_c1dat) && !is_writable($this->_c1dat) ) throw new \RuntimeException(cgex_lang('err_vrfy_filewritable',$this->_c1dat));
        if( is_file($this->_d1dat) && !is_writable($this->_d1dat) ) throw new \RuntimeException(cgex_lang('err_vrfy_filewritable',$this->_d1dat));
    }

    private function generate_c1dat()
    {
        $tmpdata = array();
        $dir = $this->_mod->GetModulePath();
        $this->walk_directory($dir,function($path) use (&$tmpdata) {
                $key = $this->get_checksum_key($path);
                $val = $this->get_checksum_value($path);
                $sig = $this->get_checksum_signature($key,$val);
                $line = "{$key}::{$val}::{$sig}";
                $tmpdata[] = $line;
            });
        sort($tmpdata);
        $tmpdata = implode("\n",$tmpdata)."\n";
        file_put_contents($this->_c1dat,$tmpdata);
        return md5($tmpdata);
    }

    private function generate_d1dat($md5)
    {
        $d1md5 = md5("{$this->get_salt()}::$md5\n");
        $line = "{$d1md5} *.";
        file_put_contents($this->_d1dat,$line);
    }

    public function generate()
    {
        $md5 = $this->generate_c1dat();
        $this->generate_d1dat($md5);
    }
}