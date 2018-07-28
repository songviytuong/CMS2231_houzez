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
 * This file defines the data report generator class.
 *
 * @package CGExtensions
 * @category Reports
 * @author  calguy1000 <calguy1000@cmsmadesimple.org>
 * @copyright Copyright 2010 by Robert Campbell
 */

namespace CGExtensions\reports;

/**
 * This class defines a report generator that will output an array of data rather than any formatted output.
 * footers and headers can still be used to gather totals, etc.
 */
class data_report_generator extends tabular_report_generator
{
    /**
     * @ignore
     */
    private $_data = array('structure'=>array());

    /**
     * @ignore
     */
    private $_rec;

    /**
     * @ignore
     */
    protected function start()
    {
        $this->_data['title'] = $this->report()->get_title();
        $this->_data['description'] = $this->report()->get_description();
        $this->_data['generated'] = time();
    }

    /**
     * @ignore
     */
    protected function before_group_headers()
    {
        $this->_rec = array('headers'=>array(),'footers'=>array(),'body'=>array());
    }

    /**
     * @ignore
     */
    protected function do_group_header(tabular_report_defn_group $grp)
    {
        // this method does not call the parent method
        $lines = $grp->get_header_lines();
        if( count($lines) ) {
            foreach( $lines as $line ) {
                $rec = array();
                foreach( $this->report()->get_columns() as $key => $col ) {
                    $val = $line->get_column_value($key);
                    $rec[$key] = $this->get_group_column_display_value($key,$grp->get_column(),$val);
                }
                $this->_rec['headers'][] = $rec;
            }
        }
    }

    /**
     * @ignore
     */
    function do_group_footer(tabular_report_defn_group $grp)
    {
        // this method does not call the parent method
        $lines = $grp->get_footer_lines();
        if( count($lines) ) {
            foreach( $lines as $line ) {
                $rec = array();
                foreach( $this->report()->get_columns() as $key => $col ) {
                    $val = $line->get_column_value($key);
                    $rec[$key] = $this->get_group_column_display_value($key,$grp->get_column(),$val);
                }
                $this->_rec['footers'][] = $rec;
            }
        }
        // this group has changed, go through all columns and reset this group
        foreach( $this->report()->get_columns() as $key => $col ) {
            $col->reset_group($grp->get_column());
        }
    }

    /**
     * @ignore
     */
    function after_group_footers()
    {
        $this->_data['structure'][] = $this->_rec;
        $this->_rec = null;
    }

    /**
     * @ignore
     */
    protected function set_row($row)
    {
        parent::set_row($row);
        $this->_rec['body'][] = $row;
    }

    /**
     * @ignore
     */
    protected function draw_cell(tabular_report_cellfmt $col,$val)
    {
        // nothing to do here.
    }

    /**
     * Get the output data from this report.
     *
     * @return array
     */
    public function get_output()
    {
        return $this->_data;
    }
} // end of class

?>