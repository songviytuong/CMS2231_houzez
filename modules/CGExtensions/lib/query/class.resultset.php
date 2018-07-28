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
abstract class resultset extends base_resultset implements \Iterator
{
    /**
     * A member to store the database recordset.
     */
    protected $_rs;

    /**
     * @ignore
     */
    private $_pos;

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

    /**
     * Use the data from the query object, perform the database query and set the recordset member.
     *
     * This method should first see if the recordset has been set and not repeat the query... for the same of optimal behavior.
     */
    //abstract protected function _query();

    /**
     * Get the number of records returned in this recordset.
     *
     * @return int
     */
    public function RecordCount()
    {
        $this->_query();
        if( $this->_rs ) return $this->_rs->RecordCount();
    }

    /**
     * Move the pointer to the next matching row in the recordset.
     */
    public function MoveNext()
    {
        $this->_query();
        if( $this->_rs ) {
            $this->_pos++;
            return $this->_rs->MoveNext();
        }
    }

    /**
     * Move the pointer  to the first matching row in the recordset.
     */
    public function MoveFirst()
    {
        $this->_query();
        $this->_pos = 0;
        if( $this->_rs ) return $this->_rs->MoveFirst();
    }

    /**
     * Move the pointer to the last matching row in the recordset.
     */
    public function MoveLast()
    {
        $this->_query();
        if( $this->_rs ) {
            $this->_pos = max(0,$this->RecordCount() - 1);
            return $this->_rs->MoveLast();
        }
    }

    public function current()
    {
        return $this->get_object();
    }

    public function next()
    {
        $this->MoveNext();
    }

    public function rewind()
    {
        $this->MoveFirst();
    }

    public function key()
    {
        return $this->_pos;
    }

    public function valid()
    {
        return ($this->_pos >= 0 && !$this->EOF()) ? TRUE : FALSE;;
    }

    /**
     * Test if the pointer is at the end of the recordset (there are no more records)
     *
     * @return bool
     */
    public function EOF()
    {
        $this->_query();
        if( $this->_rs ) return $this->_rs->EOF();
        return TRUE;
    }

    /**
     * Close the recordset, and free resources.
     */
    public function Close()
    {
        if( $this->_rs ) return $this->_rs->Close();
    }

    /**
     * @ignore
     */
    public function __get($key)
    {
        if( $key == 'EOF' ) return $this->EOF();
        if( $key == 'fields' && $this->_rs ) {
            if( !$this->_rs->EOF() ) return $this->_rs->fields;
        }
        throw new \CmsInvalidDataException("$key is not a gettable member of ".__CLASS__);
    }

    /**
     * return the total number of matches (independent of limit and offset)
     *
     * @return int
     */
    public function TotalMatches()
    {
        $this->_query();
        return $this->_totalmatching;
    }

    /**
     * Get a pagination object for this query and resultset
     *
     * @return pagination
     */
    public function &get_pagination()
    {
        $pagination = new pagination($this);
        return $pagination;
    }

    /**
     * Fetch all of the records in this resultset as an array of objects.
     *
     * @return object[]
     */
    public function FetchAll()
    {
        $out = array();
        $this->MoveFirst();
        while( !$this->EOF() ) {
            $out[] = $this->get_object();
            $this->MoveNext();
        }
        return $out;
    }

    /**
     * A convenience method used to aide in converting a string that may (or may not) contain wildcard (*) characters
     * into a string suitable for use in a substring match
     *
     * @param string $str The string to parse for wildcards.
     */
    protected function wildcard($str)
    {
        if( strpos($str,'*') != FALSE ) {
            $str = str_replace('*','%',$str);
        }
        else if( strpos($str,'%') === FALSE ) {
            $str = '%'.$str.'%';
        }
        return $str;
    }
}

?>