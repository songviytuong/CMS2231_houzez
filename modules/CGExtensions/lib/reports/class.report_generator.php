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
 * This file defines the abstract report generator class.
 *
 * @package CGExtensions
 * @category Reports
 * @author  calguy1000 <calguy1000@cmsmadesimple.org>
 * @copyright Copyright 2010 by Robert Campbell
 */

namespace CGExtensions\reports;

/**
 * An abstract class for a report generator.
 */
abstract class report_generator
{
    /**
     * @ignore
     * @var \CGExtensions\reports\report_defn $_report_defn A reference to the report definition.
     */
    private $_report_defn; // \CG\report_defn;

    /**
     * Constructor.
     *
     * @param \CGExtensions\reports\report_defn $report_defn The report definition.
     */
    public function __construct(report_defn $rpt)
    {
        $this->_report_defn = $rpt;
    }

    /**
     * Get the report definition.
     *
     * @return \CGExtensions\reports\report_defn
     */
    protected function report()
    {
        return $this->_report_defn;
    }

    /**
     * A callback function when the report is started.
     *
     * @abstract
     * @return void
     */
    protected function start() {}

    /**
     * A callback function for when the report is finished.
     *
     * @abstract
     * @return void
     */
    protected function finish() {}

    /**
     * A callback functon for each data row.
     *
     * @abstract
     * @param array $row The row returned from the query.
     */
    abstract protected function each_row($row);

    /**
     * Generate the report output.
     *
     * @return void
     */
    public function generate()
    {
        $this->start();
        $rs = $this->report()->get_resultset();
        while( !$rs->EOF() ) {
            $this->each_row($rs->fields);
            $rs->MoveNext();
        }
        unset($rs);
        $this->finish();
    }

    /**
     * Get the generated output.
     * This method may return textual data suitable for echoing/displaying.  Or it it may generate a static file and return nothing.
     *
     * @abstract
     * @return mixed
     */
    abstract public function get_output();
} // end of class

?>