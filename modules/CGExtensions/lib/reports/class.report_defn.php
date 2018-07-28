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
 * This file defines the abstract report definition class.
 *
 * @package CGExtensions
 * @category Reports
 * @author  calguy1000 <calguy1000@cmsmadesimple.org>
 * @copyright Copyright 2014 by Robert Campbell
 */

namespace CGExtensions\reports;

/**
 * An abstrat class to define a report definition.
 */
abstract class report_defn
{
    /**
     * @ignore
     */
    private $_query;           // object of type query

    /**
     * @ignore
     */
    private $_rs;              // object of type resultset

    /**
     * @ignore
     */
    private $_title;           // string

    /**
     * @ignore
     */
    private $_desc;            // string

    /**
     * Set the query that will be used for this report.
     *
     * @param \CGExtensions\query\query $query The query object
     */
    public function set_query(\CGExtensions\query\query $query)
    {
        $this->_query = $query;
    }

    /**
     * Get the query object used for this report.
     *
     * @return \CGExtensions\query\query& The query object.
     */
    protected function &get_query()
    {
        return $this->_query;
    }

    /**
     * Get the resultset object that will be used to provide data for this report.
     *
     * @return \CGExtensions\query\resultset& The resultset object
     */
    public function &get_resultset()
    {
        if( !is_object($this->_rs) ) {
            if( !is_object($this->_query) ) throw new \LogicException('No query supplied to report definition');
            $this->_rs = $this->_query->execute();
            $this->_rs->MoveFirst();
        }
        return $this->_rs;
    }

    /**
     * Get the title of this report.
     *
     * @return string
     */
    public function get_title()
    {
        return $this->_title;
    }

    /**
     * Set the title of this report.
     *
     * @param string $str The title
     */
    public function set_title($str)
    {
        $this->_title = trim($str);
    }

    /**
     * Get the description of this report.
     *
     * @return string
     */
    public function get_description()
    {
        return $this->_desc;
    }

    /**
     * Set the description for this report
     *
     * @param string $str The description
     */
    public function set_description($str)
    {
        $this->_desc = trim($str);
    }

} // end of class

?>