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
 * Some internal methods
 *
 * @ignore
 */

namespace CGExtensions;

/**
 * Some internal methods
 *
 * @ignore
 */
final class internals
{
    /**
     * @ignore
     */
    private function __construct() {}

    /**
     * @ignore
     */
    public static function reset_countries()
    {
        $db = \CmsApp::get_instance()->GetDb();
        $query = 'TRUNCATE TABLE '.CGEXTENSIONS_TABLE_COUNTRIES;
        $db->Execute($query);

        $fn = cms_join_path(dirname(__DIR__),'countries.txt');
        $raw_countries = @file($fn);
        $n = 1;
        $query = 'INSERT INTO '.CGEXTENSIONS_TABLE_COUNTRIES.' (code,name,sorting) VALUES (?,?,?)';
        foreach($raw_countries as $one) {
            list($acronym,$country_name) = explode(',',$one);
            $acronym = trim($acronym);
            $country_name = trim($country_name);
            $db->Execute($query,array($acronym,$country_name,$n++));
        }
    }

    /**
     * @ignore
     */
    public static function reset_states()
    {
        $db = \CmsApp::get_instance()->GetDb();
        $query = 'TRUNCATE TABLE '.CGEXTENSIONS_TABLE_STATES;
        $db->Execute($query);

        $fn = cms_join_path(dirname(__DIR__),'states.txt');
        $raw_states = @file($fn);
        $query = 'INSERT INTO '.CGEXTENSIONS_TABLE_STATES.' (code,name,sorting) VALUES (?,?,?)';
        $n = 1;
        foreach($raw_states as $one) {
            list($acronym,$state_name) = explode(',',$one);
            $acronym = trim($acronym);
            $state_name = trim($state_name);
            $db->Execute($query,array($acronym,$state_name,$n++));
        }
    }
}
?>
