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
 * This class defines the abstract query class.
 *
 * @package CGExtensions
 * @category Query
 * @author  calguy1000 <calguy1000@cmsmadesimple.org>
 * @copyright Copyright 2010 by Robert Campbell
 */

namespace CGExtensions\query;

/**
 * An abstract class to provide the basic interface for a query class.
 * descendents of this class should implement at least the limit, and offset parameters
 * to allow the pagination class to work.
 *
 * This class supports accessing members as either object members with the -> operator, or as array members with the [] operator.
 */
abstract class query implements \ArrayAccess
{
    /**
     * Constructor.
     * This method accepts an array of parameters, and sets internal data for the query object.
     * Identically to calling $this['key'] = $val multiple times.
     *
     * @param array $parms
     */

    /**
     * @ignore
     */
    public function __get($key)
    {
        return $this->OffsetGet($key);
    }

    /**
     * @ignore
     */
    public function __set($key,$value)
    {
        return $this->OffsetSet($key,$value);
    }

    /**
     * @ignore
     */
    public function __isset($key)
    {
        return $this->OffsetExists($key,$value);
    }

    /**
     * @ignore
     */
    public function __unset($key)
    {
        return $this->OffsetUnset($key);
    }

    /**
     * Return the value of a currently set variable.
     *
     * @ignore
     * @param string $key
     * @return mixed
     */
    abstract public function OffsetGet($key);

    /**
     * Set a value into the query object.
     *
     * @param string $key
     * @param mixed $value
     */
    abstract public function OffsetSet($key,$value);

    /**
     * Test if the key is set in the data object.
     *
     * @param string $key
     * @return bool
     */
    abstract public function OffsetExists($key);

    /**
     * Unset a variable in the object
     *
     * @param string $key
     */
    public function OffsetUnset($key)
    {
        // do nothing
    }

    /**
     * Execute the query and return the resultset
     *
     * @return resultset
     */
    abstract public function &execute();
}

?>