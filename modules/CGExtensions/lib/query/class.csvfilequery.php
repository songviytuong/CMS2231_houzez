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
 * This class defines the csvfilequery class
 *
 * @package CGExtensions
 * @category Query
 * @author  calguy1000 <calguy1000@cmsmadesimple.org>
 * @copyright Copyright 2010 by Robert Campbell
 */

namespace CGExtensions\query;

/**
 * A class that represents the contents of a csv file as a query.
 * This class does not provide for filtering of the contents of the csv file
 *
 * @property string $delimiter The field delimiter for the csv file.  The default value is a commma (,)
 * @property string $enclosure The enclosure that field contents may be enclosed in (particularly if the delimiter may be present in the field contents).  The default value is the double quote (")
 * @property array $map An array that can be used to rename all of the columns of the input file from the standard col_<index> format to real names.
 */
class csvfilequery extends txtfilequery
{
    /**
     * @ignore
     */
    private $_data = array('delimiter'=>',','enclosure'=>'"','map'=>null);

    /**
     * Constructor
     *
     * @param array $params The default properties for this query.
     */
    public function __construct($params = array())
    {
        foreach( $params as $key => $val ) {
            switch( $key ) {
            case 'delimiter':
            case 'enclosure':
            case 'map':
                $this->_data[$key] = $val;
                unset($params[$key]);
                break;
            }
        }
        parent::__construct($params);
    }

    /**
     * @ignore
     */
    public function OffsetGet($key)
    {
        if( array_key_exists($key,$this->_data) ) return $this->_data[$key];
        return parent::OffsetGet($key);
    }

    /**
     * @ignore
     */
    public function OffsetSet($key,$value)
    {
        switch( $key ) {
        case 'delimiter':
        case 'enclosure':
            $this->_data[$key] = $value;
            break;

        default:
            parent::OffsetSet($key,$value);
        }
    }

    /**
     * @ignore
     */
    public function OffsetExists($key)
    {
        if( array_key_exists($key,$this->_data) ) return TRUE;
        return parent::OffsetExists($key);
    }

    /**
     * Execute the query and generate a resultset.
     *
     * @return csvfileresultset
     */
    public function &execute()
    {
        $obj = new csvfileresultset($this);
        return $obj;
    }
}