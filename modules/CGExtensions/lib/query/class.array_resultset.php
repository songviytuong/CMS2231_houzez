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
 * This file contains the array_resultset class.
 *
 * @package CGExtensions
 * @category Query
 * @author  calguy1000 <calguy1000@cmsmadesimple.org>
 * @copyright Copyright 2014 by Robert Campbell
 */

namespace CGExtensions\query;

/**
 * The array resultset class simulates a resultset object from a flat array.
 * This is useful for using an array of loaded data in the reporting classes.
 *
 * This class does not support a limit or pagination.
 *
 * @property-read bool $EOF Alias for the EOF() method.
 * @property-read array $fields An array representing the current row in the result set.
 */
class array_resultset extends base_resultset
{
    /**
     * @ignore
     */
    private $_pos = 0;

    /**
     * Construct a new array_resultset from an array_query.
     *
     * @param array_query $query
     */
	public function __construct(array_query $query)
	{
		$this->_filter = $query->data();
	}

    /**
     * @ignore
     */
    protected function _query()
    {
        // do nothing
    }

    /**
     * Return the number of records in the array.
     *
     * @return int
     */
    public function RecordCount()
    {
        return count($this->_filter);
    }

    /**
     * Return the number of records in the array.
     *
     * @return int
     */
    public function TotalMatches()
    {
        return count($this->_filter);
    }

    /**
     * Move to the next record in the result set.
     */
    public function MoveNext()
    {
        $this->_pos++;
    }

    /**
     * Move to the first record in the result set.
     */
    public function MoveFirst()
    {
        $this->_pos=0;
    }

    /**
     * Move to the first record in the result set.
     *
     * @see MoveFirst()
     */
    public function Rewind()
    {
        $this->_pos=0;
    }

    /**
     * Move to the last record in the result set.
     */
    public function MoveLast()
    {
        $this->_pos = $this->RecordCount() - 1;
    }

    /**
     * Test if beyond the last record in the result set.
     *
     * @return bool
     */
    public function EOF()
    {
        $tmp = ($this->_pos >= $this->RecordCount());
        return $tmp;
    }

    /**
     * @ignore
     */
    public function Close()
    {
        // do nothing
    }

    /**
     * Get the current row from the result set.
     *
     * @return mixed
     */
    public function &get_object()
    {
        $keys = array_keys($this->_filter);
        $key = $keys[$this->_pos];
        return $this->_filter[$key];
    }

    /**
     * @ignore
     */
    public function &get_pagination()
    {
        die('not implemented: '.__METHOD__);
    }

    /**
     * Fetch all of the results.
     *
     * @return array
     */
    public function FetchAll()
    {
        return $this->_filter;
    }

    /**
     * @ignore
     */
    public function __get($key)
    {
        switch( $key ) {
        case 'EOF':
            return $this->EOF();

        case 'fields':
            $keys = array_keys($this->_filter);
            $key = $keys[$this->_pos];
            return $this->_filter[$key];
        }
    }

    public function current()
    {
        return $this->fields;
    }

    public function next()
    {
        $this->MoveNext();
    }

    public function key()
    {
        return $this->_pos;
    }

    public function valid()
    {
        return ($this->_pos >= 0 && $this->EOF()) ? TRUE : FALSE;;
    }


} // end of class