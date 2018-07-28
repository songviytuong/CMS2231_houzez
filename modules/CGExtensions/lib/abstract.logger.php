<?php
#BEGIN_LICENSE
#-------------------------------------------------------------------------
# Module: CGExtensions (c) 2016 by Robert Campbell
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
namespace CGExtensions;

/**
 * An abstract class to implement logging.
 *
 * @package CGExtensions
 * @category Utilities
 * @author calguy1000 <calguy1000@cmsmadesimple.org>
 * @copyright Copyright 2016
 */

/**
 * An abstract class to assist with logging.  An instance of this class
 * will typically be passed into a functional class to assist with logging and debugging.
 *
 * This class can also handle displaying progress.
 *
 * @package CGExtensions
 */
abstract class logger
{
    /**
     * @ignore
     */
    private $_cur_step = 0;

    /**
     * @ignore
     */
    private $_total_steps = 1;

    /**
     * Constructor
     *
     * @param int $total_steps
     */
    public function __construct($total_steps = 1)
    {
        $this->total_steps = max(1,(int)$total_steps);
    }

    /**
     * Advance the progress meter.
     */
    public function advance()
    {
        $this->_cur_step = min($this->_cur_step + 1,$this->_total_steps);
        $this->display_progress($this->get_percent_complete());
    }

    /**
     * Test if the operation is complete.
     *
     * @return bool
     */
    public function done()
    {
        return ($this->_cur_step == $this->_total_steps);
    }

    /**
     * Get the progress as a percentage.
     *
     * @return float A value between 0 and 100
     */
    public function get_percent_complete()
    {
        return (float) $this->_cur_step / (float) $this->_total_steps * 100.0;
    }

    /**
     * Reset the progress meter
     */
    public function reset()
    {
        $this->_cur_step = 0;
        $this->display_progress($this->get_percent_complete());
    }

    /**
     * Display a debug message.
     *
     * @param string $str The message to display.
     */
    abstract public function debug($str);

    /**
     * Display a verbose message.
     *
     * Typically some flag in the derived class would indicate if these should be actually output.
     *
     * @param string $str The message to display.
     */
    abstract public function verbose($str);

    /**
     * Display an information message
     *
     * @param string $str The message to display.
     */
    abstract public function info($str);

    /**
     * Displa a warning message
     *
     * @param string $str The message to display.
     */
    abstract public function warning($str);

    /**
     * Displa an error message
     *
     * @param string $str The message to display.
     */
    abstract public function error($str);

    /**
     * Displa a fatal message.
     *
     * @param string $str The message to display.
     */
    abstract public function fatal($str);


    /**
     * Displa the current progress
     *
     * @param float $percent The progress percentage.
     */
    abstract public function display_progress($percent);

} // end of class
