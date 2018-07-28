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
 * A set of high level convenience methods.
 *
 * @package CGExtensions/internal
 * @ignore
 */

namespace CGExtensions/internal;

final class ModuleIntegrityValidator
{
    private $_module_name;
    private $_mod;

    public function __construct($module_name)
    {
        $this->_module_name = trim($module_name);
        $this->_mod \cms_utils::get_module($module_name);
        if( !$this->_mod ) throw new \RuntimeException('Cannot get module instance for '.$module_name);
    }

    private function check_checksum_integrity($module_name,$_cdat,$_ddat)
    {
        $salt = $this->_mod->GetName().'::'.$this->_mod->GetVersion();
        $md5sum = md5($salt.'::'.md5_file($_cdat));
        $_ddat_contents = file($ddat);
        $_ddat_contents = $_ddat_contents[0];
        list($verify_code,$junk) = explode(' ',$_ddat_contents,2);
        if( $md5sum != $verify_code ) throw new \RuntimeException('Could not verify integrity of the checksum file');
    }

    public function check_module_integrity()
    {
        $dir = $this->_mod->GetModulePath();
        $_cdat = $dir.'/_c1.dat';
        $_ddat = $dir.'/_d1.dat';
        if( !is_file($_cdat) || !is_file($_ddat) ) {
            throw new \RuntimeException('Cannot validate files for '.$module_name.' (checksum files do not exist)');
        }

        // now validate the _c.da with the _d.dat
        self::check_checksum_integrity($_cdat,$_ddat);

        // get our cdat data and parse it into the two checksums and a verified flag
        // now validate all of the files within the module directory (except special files)
        // now see if there are any checksum records left that have not been validated
    }
} // end of class

#
# EOF
#
?>