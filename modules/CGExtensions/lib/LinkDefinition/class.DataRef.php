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
 * This file defines the DataRef part of a link definition.
 *
 * @package CGExtensions
 * @category Communications
 * @author  calguy1000 <calguy1000@cmsmadesimple.org>
 * @copyright Copyright 2014 by Robert Campbell
 */

namespace CGExtensions\LinkDefinition;

/**
 * A class to abstract a data reference
 * i.e: a content page, stylesheet, or a module data item
 * this can then be used by the DataReferenceLinkGenerator stuff
 * to generate links to these data items
 */
class DataRef
{
    /**
     * @ignore
     */
    private $_data = array('key1'=>null,'key2'=>null,'key3'=>null,'key4'=>null);

    /**
     * Constructor
     *
     * @param array $parms An associative array of parameters
     */
    public function __construct($parms = array())
    {
        foreach( $parms as $key => $val ) {
            $this->$key = $val;
        }
    }

    /**
     * @ignore
     */
    public function __get($key)
    {
        if( array_key_exists($key,$this->_data) ) return $this->_data[$key];
    }

    /**
     * @ignore
     */
    public function __set($key,$val)
    {
        if( !array_key_exists($key,$this->_data) ) throw new \Exception($key.' is not an invalid member of '.__CLASS__);
        $this->_data[$key] = $val;
    }

    /**
     * @ignore
     */
    public function __isset($key)
    {
        return isset($this->_data[$key]);
    }

    /**
     * @ignore
     */
    public function __unset($key)
    {
        if( array_key_exists($key,$this->_data) ) $this->_data[$key] = null;
    }

    /**
     * @ignore
     */
    public function __toString()
    {
        return '__DataRef::'.implode('::',array_values($this->_data));
    }

    /**
     * Create a new dataref object from a string
     * @param string $str Input string of the format __DataRef::key1val::key2val::key3val::key4val
     * @return DataRef
     */
    public static function fromString($str)
    {
        if( !startswith($str,'__DataRef::') ) throw new \Exception('String provided is not a valid dataref');
        $parts = explode('::',$str);
        if( count($parts) < 2 || count($parts) > 5 )  throw new \Exception('String provided is not a valid dataref');

        $obj = new self();
        for( $i = 1; $i < count($parts); $i++ ) {
            $key = 'key'.$i;
            $obj->$key = $parts[$i];
        }
        return $obj;
    }
} // end of class

#
# EOF
#
?>