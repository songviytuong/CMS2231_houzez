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
 * This class defines the pagination class.
 *
 * @package CGExtensions
 * @category Query
 * @author  calguy1000 <calguy1000@cmsmadesimple.org>
 * @copyright Copyright 2010 by Robert Campbell
 */

namespace CGExtensions\query;

/**
 * A class to assist in building a paginator navigation for the results of a query.
 *
 * @property-read int $pagecount The number of pages
 * @property-read int $page The current page number (one based)
 * @property-read int pagelimit The page limit from the query object
 * @property-read int totalroas The total matching rows for the resultset (independent of limit or offset)
 */
class pagination implements \ArrayAccess
{
    /**
     * @ignore
     */
    private $_rs;

    /**
     * The constructor
     *
     * @see resultset
     * @see query
     * @param resultset $rs A resultset object )
     */
    public function __construct(resultset $rs)
    {
        $this->_rs = $rs;
    }

    /**
     * @ignore
     */
    public function OffsetGet($key)
    {
        switch( $key ) {
        case 'pagecount':
            $n = $this->_rs->TotalMatches();
            $p = (int) ceil($n / $this->_rs->get_query()['limit']);
            return $p;

        case 'page':
            $p = (int)($this->_rs->get_query()['offset'] / $this->_rs->get_query()['limit']) + 1;
            return $p;

        case 'pagelimit':
            return $this->_rs->get_query()['limit'];

        case 'totalrows':
            return $this->_rs->TotalMatches();

        default:
            throw new \RuntimeException($key.' is not a member of '.__CLASS__);
        }
    }

    /**
     * @ignore
     */
    public function OffsetSet($key,$value)
    {
        // do nothing
    }

    /**
     * @ignore
     */
    public function OffsetExists($key)
    {
        // do nothing
    }

    /**
     * @ignore
     */
    public function OffsetUnset($key)
    {
        // do nothing
    }

    /**
     * Get a list of page numbers suitable for using in a loop to build a navigation list.
     * This method will use optimization to ensure that the number of items returned in the list will never grow too large
     *
     * @param int $surround - The number of page numbers to surround the current page with.
     * @return int[]
     */
    public function get_pagelist($surround = 3)
    {
        $list = array();
        for( $i = 1; $i <= min($surround,$this['pagecount']); $i++ ) {
            $list[] = (int)$i;
        }

        $x1 = max(1,(int)($this['page'] + $surround / 2));
        $x2 = min($this['pagecount'],(int)($this['page'] + $surround / 2) );
        for( $i = $x1; $i <= $x2; $i++ ) {
            $list[] = (int)$i;
        }

        for( $i = max(1,$this['pagecount'] - $surround); $i <= $this['pagecount']; $i++) {
            $list[] = (int)$i;
        }

        $list = array_unique($list);
        sort($list);
        return $list;
    }

    /**
     * Get a hash of page numbers suitable for using in a loop to build a navigation list.
     *
     * @see get_pagelit
     * @param int $surround The number of pages around the current page (and the beginning and end) to return.
     * @return array
     */
    public function get_pagehash($surround = 3)
    {
        $list = $this->get_pagelist($surround);
        $out = array();
        foreach( $list as $one ) {
            $out[$one] = $one;
        }
        return $out;
    }
} // end of class

?>
