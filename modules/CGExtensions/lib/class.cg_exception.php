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
 * This file defines the cg_exception base class.
 * @category Exceptions
 * @author  calguy1000 <calguy1000@cmsmadesimple.org>
 * @copyright Copyright 2010 by Robert Campbell
 */

/**
 * A simple class library to extend the standard exception class
 * and provides ome cmsms related lang string lookups.
 *
 * @package CGExtensions
 * @category Exceptions
 * @author  calguy1000 <calguy1000@cmsmadesimple.org>
 * @copyright Copyright 2010 by Robert Campbell
 */
class cg_exception extends \Exception
{
    /**
     * Takes an exception message of the form [module]%%key[%%suffix]
     * and format a language string
     *
     * @param string $str The exception message
     * @param int $code The exception code
     * @param \Exception $parent a parent exception
     */
    public function __construct($str = '',$code = 0,\Exception $parent = null)
    {
        if( strpos($str,'%%') ) {
            $parts = explode('%%',$str,3);
            if( count($parts) > 1 ) {
                $module = trim($parts[0]);
                $key = trim($parts[1]);
                if( !$module ) {
                    $module = cge_tmpdata::get('module');
                    if( !$module ) {
                        $smarty = cmsms()->GetSmarty();
                        $obj = $smarty->get_template_vars('mod');
                        if( is_object($obj) ) $module = $obj->GetName();
                    }
                }

                if( $module && $key ) {
                    $mod = \cms_utils::get_module($module);
                    if( $mod ) $str = $mod->Lang($key);
                    if( isset($parts[2]) && $parts[2] ) $str .= ' '.$parts[2];
                }
            }
        }

        parent::__construct($str,$code,$parent);
    }

    /**
     * Convert this exception to a string.
     */
    public function __toString()
    {
        return get_class($this) . " '{$this->getMessage()}' in {$this->getFile()}:{$this->getLine()}\n"
            . "{$this->getTraceAsString()}";
    }
} // end of interface


#
# EOF
#
?>