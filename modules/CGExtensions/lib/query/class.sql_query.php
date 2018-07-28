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
 * This file contains the sql_query class.
 *
 * @package CGExtensions
 * @category Query
 * @author  calguy1000 <calguy1000@cmsmadesimple.org>
 * @copyright Copyright 2014 by Robert Campbell
 */
namespace CGExtensions\query;


/**
 * A simple query class that generically accepts any SQL query.
 *
 * @property string $sql - The SQL query to execute
 * @property int    $limit - The number of elements to return in one recordset
 * @property int    $offset - The offset to begin returning elements
 * @property array  $parms SQL Query parameters (must be specified in the proper order)
 */
class sql_query extends query
{
    /**
     * @ignore
     */
    private $_data = array('sql'=>null,'limit'=>1000,'offset'=>0,'parms'=>array());

    /**
     * Constructor
     *
     * @param array $parms Construction parameters.
     */
    public function __construct($parms = array())
    {
        foreach( $parms as $key => $val ) {
            if( array_key_exists($key,$this->_data) ) $this[$key] = $val;
        }
    }

    /**
     * @ignore
     */
    public function OffsetGet($key)
    {
        if( isset($this->_data[$key]) ) return $this->_data[$key];
        throw new \CmsInvalidDataException($key.' is not a valid member of '.__CLASS__);
    }

    /**
     * @ignore
     */
    public function OffsetSet($key,$value)
    {
        if( !array_key_exists($key,$this->_data) ) throw new \CmsInvalidDataException($key.' is not a valid member of '.__CLASS__);
        switch( $key ) {
        case 'sql':
            $this->_data[$key] = $value;
            break;

        case 'limit':
            $value = max(1,min(1000,(int)$value));
            $this->_data[$key] = $value;
            break;

        case 'offset':
            $val = max(0,min(9000000,(int)$value));
            $this->_data[$key] = $value;
            break;

        case 'parms':
            if( is_null($value) || count($value) == 0 ) {
                $this->_data[$key] = array();
            }
            else if( is_array($value) && count($value) > 0 ) {
                $this->_data[$key] = $value;
            }
            break;
        }


    }

    /**
     * @ignore
     */
    public function OffsetExists($key)
    {
        return array_key_exists($key,$this->_data);
    }

    /**
     * Execute the query and return a resultset
     *
     * @return sql_resultset
     */
    public function &execute()
    {
        $rs = new sql_resultset($this);
        return $rs;
    }
} // end of class


?>