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
 * This file defines the txtfilequery class
 *
 * @package CGExtensions
 * @category Query
 * @author  calguy1000 <calguy1000@cmsmadesimple.org>
 * @copyright Copyright 2010 by Robert Campbell
 */

namespace CGExtensions\query;

/**
 * A class to generate a query object from a text file.
 *
 * @property int $limit The limit of records to use
 * @property int $offset The start record (line) to use in the report.
 * @property string $filename The absolute path to the file to use in the report.
 */
class txtfilequery extends query
{
    /**
     * @ignore
     */
    private $_data = array('limit'=>500,'offset'=>0,'filename'=>null);

    /**
     * Constructor
     *
     * @param array $parms The default properties for this object.
     */
    public function __construct($parms = array())
    {
        foreach( $parms as $key => $val ) {
            $this->OffsetSet($key,$val);
        }
    }

    /**
     * @ignore
     */
    public function OffsetGet($key)
    {
        if( array_key_exists($key,$this->_data) ) return $this->_data[$key];
    }

    /**
     * @ignore
     */
    public function OffsetSet($key,$val)
    {
        switch( $key ) {
        case 'limit':
            $val = (int)$val;
            $val = max(1,$val);
            $val = min(1000,$val);
            $this->_data[$key] = $val;
            break;

        case 'offset':
            $val = (int)$val;
            $val = max(0,$val);
            $this->_data[$key] = $val;
            break;

        case 'filename':
            $val = trim($val);
            if( !is_readable($val) ) throw new \CmsInvalidDataException('File '.$val.' does not exist for '.__CLASS__);
            $this->_data[$key] = $val;
            break;

        default:
            throw new \CmsInvalidDataException($key.' is not a valid property for a '.__CLASS__.' object');
        }
    }

    /**
     * @ignore
     */
    public function OffsetExists($key)
    {
        if( array_key_exists($key,$this->_data) ) return TRUE;
        return FALSE;
    }

    /**
     * Execute the query and return a resultset.
     *
     * @return txtfileresultset
     */
    public function &execute()
    {
        $obj = new txtfileresultset($this);
        return $obj;
    }
}