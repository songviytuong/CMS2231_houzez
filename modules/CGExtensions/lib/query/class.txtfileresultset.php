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
 * This file defines the txtfileresultset class
 *
 * @package CGExtensions
 * @category Query
 * @author  calguy1000 <calguy1000@cmsmadesimple.org>
 * @copyright Copyright 2010 by Robert Campbell
 */

namespace CGExtensions\query;

/**
 * A class to return lines out of a text file, suitable for using in some reports.
 * note: it may not be suitable to use a text file in a tabular report.
 *
 * @property string $fields Get the current record (in this case a line).
 * @see txtfilequery
 */
class txtfileresultset extends resultset
{
    /**
     * @ignore
     */
    private $_fileobj;

    /**
     * @ignore
     */
    protected function _query()
    {
        if( is_object($this->_fileobj) ) return;

        $this->_fileobj = new \SplFileObject($this->_filter['filename']);
        $this->_fileobj->seek($this->_filter['offset']);
    }

    /**
     * @ignore
     */
    public function __get($key)
    {
        if( $key == 'fields' ) {
            $rec = array();
            $rec['line'] = $this->_fileobj->key() + 1;
            $rec['text'] = $this->_fileobj->current();
            return $rec;
        }
        return parent::__get($key);
    }

    /**
     * Get the file object used in this query.
     *
     * @return \SplFileObject
     */
    protected function &get_fileobject()
    {
        return $this->_fileobj;
    }

    /**
     * Return the number of records that match this query.
     * in the case of this object, as no line counting is performed, this method always returns the limit property.
     */
    public function RecordCount()
    {
        $his->_query();
        return $this->_filter['limit'];
    }

    /**
     * Move to the next record (line) that matches the query.
     */
    public function MoveNext()
    {
        $this->_query();
        $line_num = $this->_fileobj->key();
        $this->_fileobj->seek($line_num+1);
    }

    /**
     * Move to the first record (line) that matches the query.
     */
    public function MoveFirst()
    {
        $this->_query();
        $this->_fileobj->seek($this->_filter['offset']);
    }

    /**
     * Test if we are at the end of our query matches.
     *
     * @return bool
     */
    public function EOF()
    {
        $this->_query();
        $line = $this->_fileobj->key();
        if( $this->_fileobj->eof() || $line >= $this->_filter['offset'] + $this->_filter['limit'] ) return TRUE;
        return FALSE;
    }

    /**
     * Close the file
     */
    public function Close() { }

    /**
     * Return the total number of records (lines) that match our query.
     * As the contents of the file are not scanned, this method always returns -1
     */
    public function TotalMatches()
    {
        return -1;
    }

    /**
     * Get the object representing this class
     *
     * @return \StdClass
     */
    public function &get_object()
    {
        $this->_query();
        $fields = $this->fields;
        $obj = new \Stdclass;
        foreach( $fields as $key => $val ) {
            $obj->$key = $val;
        }
        return $obj;
    }

} // end of class
?>