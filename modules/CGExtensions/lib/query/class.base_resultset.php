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
 * This file contains the abstract resultset class.
 *
 * @package CGExtensions
 * @category Query
 * @author  calguy1000 <calguy1000@cmsmadesimple.org>
 * @copyright Copyright 2014 by Robert Campbell
 */

namespace CGExtensions\query;

/**
 * An abstract class to query the database and manage the results.
 */
abstract class base_resultset implements \iterator
{
    /**
     * The current filter object.
     */
    protected $_filter;

    /**
     * The total number of records matching the query (independent of limit and offset)
     */
    protected $_totalmatching;

    /**
     * The constructor
     *
     * @param query $query
     */
    public function __construct(query $query)
    {
        $this->_filter = $query;
    }

    /**
     * Return the query object
     *
     * @return query
     */
    public function &get_query()
    {
        return $this->_filter;
    }

    public function getIterator()
    {
        return;
    }

    /**
     * Use the data from the query object, perform the database query and set the recordset member.
     *
     * This method should first see if the recordset has been set and not repeat the query... for the same of optimal behavior.
     */
    abstract protected function _query();

    /**
     * Get the number of records returned in this recordset.
     *
     * @return int
     */
    abstract public function RecordCount();

    /**
     * Move the pointer to the next matching row in the recordset.
     */
    abstract public function MoveNext();

    /**
     * Move the pointer  to the first matching row in the recordset.
     */
    abstract public function MoveFirst();

    /**
     * Move the pointer to the first matching row in the recordset.
     */
    abstract public function Rewind();

    /**
     * Move the pointer to the last matching row in the recordset.
     */
    abstract public function MoveLast();

    /**
     * Test if the pointer is at the end of the recordset (there are no more records)
     *
     * @return bool
     */
    abstract public function EOF();

    /**
     * Close the recordset, and free resources.
     */
    abstract public function Close();

    /**
     * return the total number of matches (independent of limit and offset)
     *
     * @return int
     */
    abstract public function TotalMatches();

    /**
     * Get an object representing the data at the current pointer position
     *
     * @return object
     */
    abstract public function &get_object();

    /**
     * Get a pagination object for this query and resultset
     *
     * @return pagination
     */
    abstract public function &get_pagination();

    /**
     * Fetch all of the records in this resultset as an array of objects.
     *
     * @return object[]
     */
    abstract public function FetchAll();
} // end of class

?>
