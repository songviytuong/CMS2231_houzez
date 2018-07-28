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
 * This file defines the csvfileresultset class
 *
 * @package CGExtensions
 * @category Query
 * @author  calguy1000 <calguy1000@cmsmadesimple.org>
 * @copyright Copyright 2010 by Robert Campbell
 */

namespace CGExtensions\query;

/**
 * A class to return records out of a csv file, suitable for using in some reports.
 *
 * @property string $fields Get the current record (in this case a line).
 * @see csvfilequery
 */
class csvfileresultset extends txtfileresultset
{
    /**
     * @ignore
     */
    private $_loaded;

    /**
     * @ignore
     */
    protected function _query()
    {
        parent::_query();
        if( $this->_loaded ) return;
        $this->_loaded = 1;

        $obj = $this->get_fileobject();
        $obj->SetFlags(\SplFileObject::READ_CSV);
        $obj->setCsvControl($this->_filter['delimiter'],$this->_filter['enclosure']);
        $obj->seek($this->_filter['offset']); // just in case
    }

    /**
     * @ignore
     */
    public function __get($key)
    {
        if( $key == 'fields' ) {
            $rec = array();
            $rec['line'] = $this->get_fileobject()->key() + 1;
            $cur = $this->get_fileobject()->current();
            $map = $this->_filter['map'];
            if( is_array($map) ) {
                foreach( $map as $col => $fldname ) {
                    $rec[$fldname] = null;
                    if( isset($cur[$col]) ) $rec[$fldname] = $cur[$col];
                }
            }
            else {
                foreach( $cur as $key => $val ) {
                    $rec['col_'.$key] = $val;
                }
            }
            return $rec;
        }
        return parent::__get($key);
    }

} // end of class
?>