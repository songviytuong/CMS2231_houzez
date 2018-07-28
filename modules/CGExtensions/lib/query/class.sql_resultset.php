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
 * This file contains the sql_resultset class.
 *
 * @package CGExtensions
 * @category Query
 * @author  calguy1000 <calguy1000@cmsmadesimple.org>
 * @copyright Copyright 2014 by Robert Campbell
 */

namespace CGExtensions\query;

/**
 * A class to allow iterating and fetching the results from an SQL query.
 */
class sql_resultset extends resultset
{
    /**
     * Constructor
     *
     * @param sql_query $query The input query object
     */
    public function __construct(sql_query $query)
    {
        $this->_filter = $query;
        $this->_query();
    }

    /**
     * @ignore
     * @internal
     */
    protected function _query()
    {
        if( $this->_rs ) return;

        $sql = $this->_filter['sql'];
        // get the first two words out of the query
        list($w1,$w2,$junk) = explode(' ',$sql);
        if( strtoupper($w1) == 'SELECT' ) {
            if( strtoupper($w2) != 'SQL_CALC_FOUND_ROWS') {
                // inject SQL_CALC_FOUND_ROWS
                $sql = substr_replace($sql,'SELECT SQl_CALC_FOUND_ROWS',0,strlen('SELECT'));
            }
        }

        $db = \cge_utils::get_db();
        $this->_rs = $db->SelectLimit($sql, $this->_filter['limit'], $this->_filter['offset'], $this->_filter['parms']);
        $this->_totalmatching = (int) $db->GetOne('SELECT FOUND_ROWS()');
    }

    /**
     * Get the object associated with the resultset.
     *
     * In this class, the method returns an associative array representing a single row.
     */
    public function &get_object()
    {
        $row = $this->fields;
        return $row;
    }
} // end of class

?>