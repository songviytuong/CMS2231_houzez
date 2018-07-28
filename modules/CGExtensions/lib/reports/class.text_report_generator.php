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
 * This class will take a report definition and output a text file representation of the report.
 */
class text_report_generator extends tabular_report_generator
{
    /**
     * @ignore
     */
    private $_col_width = 15;

    /**
     * @ignore
     */
    private $_out;

    /**
     * Set the width of each column (in characters)
     *
     * @param int $val
     */
    public function set_column_width($val)
    {
        $this->_col_width = max(1,min(200,(int)$val));
    }

    /**
     * Get the column width (in characters)
     *
     * @return int
     */
    protected function get_column_width()
    {
        return $this->_col_width;
    }

    /**
     * @ignore
     */
    protected function start()
    {
        parent::start();
    }

    /**
     * @ignore
     */
    protected function finish()
    {
        parent::finish();
    }

    /**
     * @ignore
     */
    protected function after_line()
    {
        parent::after_line();
        $this->_out .= "\n";
    }

    /**
     * @ignore
     */
    protected function after_group_footers()
    {
        parent::after_group_footers();
        $this->_out .= "\n";
    }

    /**
     * @ignore
     */
    protected function draw_cell(tabular_report_cellfmt $col,$val)
    {
        $this->_out .= str_pad($val,$this->get_column_width(),' ',STR_PAD_LEFT);
    }

    /**
     * Get the output of the report.
     *
     * @return string Output suitable for saving to a text file.
     */
    public function get_output()
    {
        return $this->_out;
    }
} // end of class

?>