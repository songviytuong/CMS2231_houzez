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
 * This file defines the tabular report definition class.
 *
 * @package CGExtensions
 * @category Reports
 * @author  calguy1000 <calguy1000@cmsmadesimple.org>
 * @copyright Copyright 2010 by Robert Campbell
 */

namespace CGExtensions\reports;

/**
 * This class is used for reports that generate tabular data (which is most types of financial reports, etc.).
 * This class supports grouping, and group operations like min, max, sum, average etc.
 */
class tabular_report_defn extends report_defn
{
    /**
     * @ignore
     */
    private $_groups;          // array of tabular_report_defn_group objects

    /**
     * @ignore
     */
    private $_report_group;    // a single tabular_report_defn_group object to define report headers and footers.

    /**
     * @ignore
     */
    private $_columns;         // hash of column key, and tabular_report_defn_column objects

    /**
     * @ignore
     */
    private $_content_columns; // array of column keys

    /**
     * Get the resultset for this report.
     *
     * @return \CGExtensions\reports\resultset
     */
    public function &get_resultset()
    {
        $rs = parent::get_resultset();
        if( !$this->_columns && !$rs->EOF() ) {
            // auto add column definitions if none defined
            $cols = array_keys($rs->fields);
            foreach( $cols as $one ) {
                $colobj = new report_defn_column($one,ucwords($one),'{$val}');
                $this->define_column($colobj);
            }
        }
        // initialize the content columns
        if( !is_array($this->_content_columns)) $this->_content_columns = array_keys($this->_columns);
        return $rs;
    }

    /**
     * Get the regular groups defined for this report.
     *
     * @return tabular_report_defn_group[]
     */
    public function get_groups()
    {
        return $this->_groups;
    }

    /**
     * Get all groups defined for this report, including report groups.
     *
     * @return tabular_report_defn_group[]
     */
    public function get_all_groups()
    {
        $out = $this->get_groups();
        if( is_object($this->_report_group) ) $out[] = $this->_report_group;
        return $out;
    }

    /**
     * Set the columns that will be displayed for each data row (output row that is not from a group header or footer).
     * The columns must be previously defined with define_column.
     *
     * @param string[] $line An array of column names.
     * @see define_column()
     */
    public function set_content_columns(array $line)
    {
        $this->_content_columns = $line;
    }

    /**
     * Get the columns that will be displayed for each data row.
     *
     * @return string[]
     */
    public function get_content_columns()
    {
        return $this->_content_columns;
    }

    /**
     * Define a column for the tabular report.
     * This defines the major columns for the report, and includes formatting information.
     * The columns defined must match those returned by the resultset object (or you must define a function for doing value processing).
     *
     * @param tabular_report_defn_column $col
     */
    public function define_column(tabular_report_defn_column $col)
    {
        $key = $col->get_key();
        $this->_columns[$key] = $col;
    }

    /**
     * Get the columns defined for this report in order by their weigint, or their key.
     *
     * If a sorting value is specified for any column then all columns are sorted by the sorting value and then the label.
     * otherwise the order in which they are added is retained.
     *
     * @return tabular_report_defn_column[]
     */
    public function get_columns()
    {
        static $out = null;
        if( !$out ) {
            $out = $this->_columns;
            $have_sorting = false;
            foreach( $out as $key => $col ) {
                if( $col->get_sorting() != 0 ) {
                    $have_sorting = true;
                    break;
                }
            }
            if( $have_sorting ) {
                uasort($out,function($a,$b){
                        if( $a->get_sorting() < $b->get_sorting() ) return -1;
                        if( $a->get_sorting() > $b->get_sorting() ) return 1;
                        return strcmp($a->get_label(),$b->get_label());
                    });
            }
        }
        return $out;
    }

    /**
     * Get the column specified by the column name.
     *
     * @param string $key
     * @return tabular_report_defn_column|null
     */
    public function get_column($key)
    {
        if( array_key_exists($key,$this->_columns) ) return $this->_columns[$key];
    }

    /**
     * Add a grouping to this report.
     * Groupings allow header and footer lines, and mathematic on the values displayed within that group.
     *
     * @param tabular_report_defn_group $grp The group object.
     */
    public function add_group(tabular_report_defn_group $grp)
    {
        $grp->set_report($this);
        $this->_groups[] = $grp;
    }

    /**
     * Set the report group for this report.
     * The report groups headers and footer lines are used for report level headers and footers.
     *
     * @param tabular-report_defn_group $grp The group object.
     */
    public function set_report_group(tabular_report_defn_group $grp)
    {
        $grp->set_report($this);
        $grp->set_report_group_flag(TRUE);
        $this->_report_group = $grp;
    }

    /**
     * Get the report group for this report (if there is one).
     *
     * @return tabular_report_defn_group|null
     */
    public function get_report_group()
    {
        return $this->_report_group;
    }
} // end of class

/**
 * A class that defines a cell format for a tabular report.
 * This class is used to indicate how to display a value for a certain cell.
 */
class tabular_report_cellfmt
{
    const ALIGN_LEFT = 'left';
    const ALIGN_RIGHT = 'right';
    const ALIGN_CENTER = 'center';

    /**
     * @ignore
     */
    private $_key;

    /**
     * @ignore
     */
    private $_template;

    /**
     * @ignore
     */
    private $_align; // null, left, center, right

    /**
     * @ignore
     */
    private $_span = 1;

    /**
     * @ignore
     */
    private $_class;

    /**
     * Construct a new tabular_report_cellfmt.
     *
     * @param string $key The name of the column (must match a defined column).
     * @param string $tpl The smarty template for displaying values for this cell.  Default value is '{$val}'.
     * @param string $align The alignment for this cell.  See the ALIGN constants in this class.
     * @param int    $span The number of columns this cell should span.  Some generators may ignore this.
     */
    public function __construct($key,$tpl = '{$val}',$align = null,$span = 1)
    {
        // don't set a default for fmt as 'null' is valid when used in a header.
        $this->_key = trim($key); // todo: test this.

        $this->set_template($tpl);

        switch( $align ) {
        case self::ALIGN_LEFT:
        case self::ALIGN_RIGHT:
        case self::ALIGN_CENTER:
            $this->_align = $align;
            break;
        default:
            $this->_align = null;
            break;
        }
        $this->_span = max(1,(int)$span);
    }

    /**
     * Get the key (column name) for this object.
     *
     * @return string
     */
    public function get_key()
    {
        return $this->_key;
    }

    /**
     * Get the template for values in this cell format
     *
     * @return string
     */
    public function get_template()
    {
        return $this->_template;
    }

    /**
     * Set the template for values in this cell format.
     *
     * @param string $tpl Smarty template.  It should be simple, and used for displaying a single value.
     */
    public function set_template($tpl)
    {
        $tpl = trim($tpl);
        if( !$tpl ) $tpl = '{$val}';
        $this->_template = $tpl;
    }

    /**
     * Get the alignment for cells using this format.
     *
     * @return string
     */
    public function get_alignment()
    {
        return $this->_align;
    }

    /**
     * Get the cell span for cells using this format.
     *
     * @return int
     */
    public function get_span()
    {
        return $this->_span;
    }

    /**
     * Get the class name (if any) assigned to this cell format
     *
     * @return string
     */
    public function get_class()
    {
        return $this->_class;
    }

    /**
     * Set a class name to use when outputting cells using this format.
     * Some generators may ignore this value. But HTML type generators will typically use this as a class name for the table cell.
     *
     * @param string $class
     */
    public function set_class($class)
    {
        $class = trim((string) $class);
        $this->_class = $class;
    }
} // end of class


/**
 * A column definition for a tabular report.
 */
class tabular_report_defn_column extends tabular_report_cellfmt
{
    /**
     * @ignore
     */
    private $_global_values; // array: all values for this column for the entire report

    /**
     * @ignore
     */
    private $_group_values; // hash of group column and totals.

    /**
     * @ignore
     */
    private $_sorting;

    /**
     * @ignore
     */
    private $_label;

    /**
     * @ignore
     */
    private $_processor_cb;

    /**
     * Construct a new column definition.
     * A column definition defines how values in an entire column will be treated.
     *
     * @param string $key The name of the column (must match the defined columns in the report definition).
     * @param string $label The displayable label for this column.
     * @param string $fmt The smarty tempalte that defines how values in this column will be displayed.
     * @param string $align The alignment for cells in this column.
     */
    public function __construct($key,$label,$fmt = null,$align = null,$sorting = null)
    {
        if( !$fmt ) $fmt = '{$val}';
        parent::__construct($key,$fmt,$align);
        $this->_label = $label;
        $this->_sorting = (int) $sorting;
        $this->_global_values = array();
        $this->_group_values = array();
    }

    /**
     * Get the label for this column definition.
     *
     * @return string
     */
    public function get_label()
    {
        return $this->_label;
    }

    /**
     * Set the label or this column definition
     *
     * @parma string $label
     */
    public function set_label($label)
    {
        $this->_label = (string) $label;
    }

    /**
     * Get the sorting for this column definition.
     *
     * @return int
     */
    public function get_sorting()
    {
        return $this->_sorting;
    }

    /**
     * Set the sorting for this column definition
     *
     * @param int $sorting
     */
    public function set_sorting($sorting)
    {
        $this->_sorting = (int) $sorting;
    }

    /**
     * Set an optional mechanism to adjust, process, or return a different value for values in this column.
     * This can be used for doing mathematical formulas on values, or retrieving foreign key related data from the database
     * or otherwise translating input data.
     *
     * @param callable $fn A callable function that is of the form  func(string $value,\CGExtensions\query\resultset)
     */
    public function set_value_processor(callable $fn)
    {
        if( !is_callable($fn) ) throw new \RuntimeException('processor supplied is not callable');
        $this->_processor_cb = $fn;
    }

    /**
     * A callback method to process a value in this column.
     * by default this method will call the value processor callback (if defined), otherwise it will do nothing.
     * This method is normally called by the report generator to determine the output value (but not the displayed string) for the column.
     *
     * @param string $val The current value for this column.
     * @param \CGExtensions\query\resultset $rs The resultset object.
     */
    public function process_value($val,\CGExtensions\query\base_resultset $rs)
    {
        if( is_callable($this->_processor_cb) ) {
            $fn = $this->_processor_cb;
            $val = $fn($val,$rs);
        }
        return $val;
    }

    /**
     * Save a value for this column.  Useful in calcualting statistics that are global to the entire report.
     * This method is normally called by the report generator.
     *
     * @param string $val
     */
    public function add_history_value($val)
    {
        $this->_global_values[] = $val;
    }

    /**
     * Add a group history value.  Useful in calculating statistics for a specific group.
     * This method is normally called by the report generator.
     *
     * @param string $grp_key The name of the group
     * @param string $val
     */
    public function add_group_history_value($grp_key,$val)
    {
        if( $grp_key ) {
            if( !isset($this->_group_values[$grp_key]) ) $this->_group_values[$grp_key] = array();
            $this->_group_values[$grp_key][] = $val;
        }
    }

    /**
     * A function to test if the supplied value for this column has changed from the previous
     * global value.  This can be useful for detecting if a group has changed.
     * This method is normally called by the report generator.
     *
     * @param string $val
     * @return bool
     */
    public function changed($val)
    {
        $cnt = count($this->_global_values);
        if( $cnt == 0 ) return TRUE; // no history
        $last = $this->_global_values[$cnt-1];
        return (bool)($last != $val);
    }

    /**
     * Clear all cached values for a specified group
     *
     * @param string $grp_key The name of the group
     */
    public function reset_group($grp_key)
    {
        $this->_group_values[$grp_key] = array();
    }

    /**
     * Get the count of values stored for this column.
     *
     * @see self::add_history_value()
     * @return int
     */
    public function get_count()
    {
        return count($this->_global_values);
    }

    /**
     * Get the minimum of all values stored for this column.
     * This method assumes that the data stored is in someway numeric, and can be
     * compared using numeric operators.
     *
     * @return string
     */
    public function get_min()
    {
        $min = null;
        foreach( $this->_global_values as $val ) {
            if( $min == null || $val < $min ) $min = $val;
        }
        return $min;
    }

    /**
     * Get the maximum of all values stored for this column.
     * This method assumes that the data stored is in someway numeric, and can be
     * compared using numeric operators.
     *
     * @return string
     */
    public function get_max()
    {
        $max = null;
        foreach( $this->_global_values as $val ) {
            if( $max == null || $val > $max ) $max = $val;
        }
        return $max;
    }

    /**
     * Get the sum of all values stored for this column.
     * This method assumes that the data stored is in someway numeric, and can be
     * compared using numeric operators.
     *
     * @return string
     */
    public function get_sum()
    {
        $sum = 0;
        foreach( $this->_global_values as $val ) {
            $sum += $val;
        }
        return $sum;
    }

    /**
     * Get the mean/average of all values stored for this column.
     * This method assumes that the data stored is in someway numeric, and can be
     * compared using numeric operators.
     *
     * @return string
     */
    public function get_mean()
    {
        if( $this->get_count() == 0 ) return 0;
        return $this->get_sum() / $this->get_count();
    }

    /**
     * Get the median/middle of all values stored for this column.
     * This method assumes that the data stored is in someway numeric, and can be
     * compared using numeric operators.
     *
     * @return string
     */
    public function get_median()
    {
        if( $this->get_count() == 0 ) return 0;
        $tmp = $this->_global_values;
        sort($tmp);
        $idx = (int) ($this->get_count() / 2);
        return $tmp[$idx];
    }

    /**
     * Get all of the values stored for this column for the named group.
     *
     * @param string $grp_key
     * @return string[]
     */
    protected function get_grp_values($grp_key)
    {
        $grp_key = trim($grp_key);
        if( !$grp_key ) return;
        if( isset($this->_group_values[$grp_key]) ) return $this->_group_values[$grp_key];
    }

    /**
     * Get the count of all values stored for this column for the specified group.
     *
     * @param string $grp_key
     * @return int
     */
    public function get_grp_count($grp_key)
    {
        $vals = $this->get_grp_values($grp_key);
        if( !is_array($vals) || count($vals) == 0 ) return;
        return count($vals);
    }

    /**
     * Get the minimum of all values stored for this column for the specified group
     * This method assumes that the data stored is in someway numeric, and can be
     * compared using numeric operators.
     *
     * @param string $grp_key
     * @return string
     */
    public function get_grp_min($grp_key)
    {
        $vals = $this->get_grp_values($grp_key);
        if( !is_array($vals) || count($vals) == 0 ) return;

        $min = null;
        foreach( $vals as $one ) {
            if( $min == null || $one < $min ) $min = $one;
        }
        return $min;
    }

    /**
     * Get the maximum of all values stored for this column for the specified group
     * This method assumes that the data stored is in someway numeric, and can be
     * compared using numeric operators.
     *
     * @param string $grp_key
     * @return string
     */
    public function get_grp_max($grp_key)
    {
        $vals = $this->get_grp_values($grp_key);
        if( !is_array($vals) || count($vals) == 0 ) return;

        $max = null;
        foreach( $vals as $one ) {
            if( $max == null || $one > $max ) $max = $one;
        }
        return $max;
    }

    /**
     * Get the sum of all values stored for this column for the specified group
     * This method assumes that the data stored is in someway numeric, and can be
     * compared using numeric operators.
     *
     * @param string $grp_key
     * @return string
     */
    public function get_grp_sum($grp_key)
    {
        $vals = $this->get_grp_values($grp_key);
        if( !is_array($vals) || count($vals) == 0 ) return;

        $sum = 0;
        foreach( $vals as $one ) {
            $sum += $one;
        }
        return $sum;
    }

    /**
     * Get the mean/average of all values stored for this column for the specified group
     * This method assumes that the data stored is in someway numeric, and can be
     * compared using numeric operators.
     *
     * @param string $grp_key
     * @return string
     */
    public function get_grp_mean($grp_key)
    {
        $count = $this->get_grp_count($grp_key);
        $sum = $this->get_grp_sum($grp_key);
        if( $count > 0 ) return $sum / $count;
    }

    /**
     * Get the median/middle of all values stored for this column for the specified group
     * This method assumes that the data stored is in someway numeric, and can be
     * compared using numeric operators.
     *
     * @param string $grp_key
     * @return string
     */
    public function get_grp_median($grp_key)
    {
        $vals = $this->get_grp_values($grp_key);
        if( !is_array($vals) || count($vals) == 0 ) return;

        $idx = (int) count($vals) / 2;
        sort($vals);
        return $vals[$idx];
    }
}

/**
 * A class to define a grouping within a tabular report.
 * Groups can create multiple header and footer lines to display labels or calculated values.
 * Each column inside a group can display a different value (such as a count, min/max/average/mean/sum) of grouped values.
 */
class tabular_report_defn_group
{
    const ACT_PAGE = '__PAGE__';
    const ACT_LINE = '__LINE__';

    /**
     * @ignore
     */
    private $_report;

    /**
     * @ignore
     */
    private $_old_value;

    /**
     * @ignore
     */
    private $_column;

    /**
     * @ignore
     */
    private $_header_lines;

    /**
     * @ignore
     */
    private $_footer_lines;

    /**
     * @ignore
     */
    private $_after_action;

    /**
     * @ignore
     */
    private $_before_action;

    /**
     * @ignore
     */
    private $_is_report_group;

    /**
     * Construct a new group definition.
     *
     * @param string $col The column that this group is based on (This column will be tracked for changes in value).  The column must be defined in the report definition.
     */
    public function __construct($col)
    {
        $this->_column = trim($col);
    }

    /**
     * Get the column that this group watches.
     *
     * @return string
     */
    public function get_column()
    {
        return $this->_column;
    }

    /**
     * Set the column that this group watches.
     *
     * @param string $str The column name (the column must be defined in the report definition).
     */
    public function set_column($str)
    {
        $str = trim($str);
        if( $str ) $this->_column = $str;
    }

    /**
     * Get the header lines for this report.
     *
     * @return tabular_report_defn_group_line[]
     */
    public function get_header_lines()
    {
        return $this->_header_lines;
    }

    /**
     * Add a header line to this report.
     *
     * @param tabular_report_defn_group_line $line The line definition.
     */
    public function add_header_line(tabular_report_defn_group_line $line)
    {
        $line->set_group($this);
        $this->_header_lines[] = $line;
    }

    /**
     * Get the footer lines for this report.
     *
     * @return tabular_report_defn_group_line[]
     */
    public function get_footer_lines()
    {
        return $this->_footer_lines;
    }

    /**
     * Add a footer line to this report.
     *
     * @param tabular_report_defn_group_line $line The line definition.
     */
    public function add_footer_line(tabular_report_defn_group_line $line)
    {
        $line->set_group($this);
        $this->_footer_lines[] = $line;
    }

    /**
     * Set an action to perform after group footers are output (if any).
     * Some generators (for example PDF) may be able to do certain actions
     * like generate a new page after the group.  This flag indicates the
     * preferred behavior for this group.
     *
     * @param string $tmp The behavior. There are constants for this behavior defined in this class.  unknown values will be ignored.
     */
    public function set_after_action($tmp)
    {
        switch( strtoupper($tmp) ) {
        case self::ACT_PAGE:
        case self::ACT_LINE:
            $this->_after_action = $tmp;
            break;
        }
    }

    /**
     * Get the preferred action to perform after group footers are output (if any)
     *
     * @return string
     */
    public function get_after_action()
    {
        return $this->_after_action;
    }

    /**
     * Set an action to perform before group headers are output (if any).
     * Some generators (for example PDF) may be able to do certain actions
     * like generate a new page after the group.  This flag indicates the
     * preferred behavior for this group.
     *
     * @param string $tmp The behavior. There are constants for this behavior defined in this class.  unknown values will be ignored.
     */
    public function set_before_action($tmp)
    {
        switch( strtoupper($tmp) ) {
        case self::ACT_PAGE:
        case self::ACT_LINE:
            $this->_before_action = $tmp;
            break;
        }
    }

    /**
     * Get the preferred action to perform before group headers are output (if any)
     *
     * @return string
     */
    public function get_before_action()
    {
        return $this->_before_action;
    }

    /**
     * Set the report for this group
     *
     * @internal
     * @param report_defn $rpt
     */
    public function set_report(report_defn $rpt)
    {
        $this->_report = $rpt;
    }

    /**
     * Get the report for this group
     *
     * @internal
     * @return tabular_report_defn
     */
    public function get_report()
    {
        return $this->_report;
    }

    /**
     * Sets wether this group is a report level group.
     * For internal use only.
     *
     * @internal
     * @param bool $set_report_group_flag
     */
    public function set_report_group_flag($flag = null)
    {
        $this->_is_report_group = (bool) $flag;
    }

    /**
     * Test wether this group is a report group.
     * For internal use only.
     *
     * @internal
     * @return bool
     */
    public function is_report_group()
    {
        return $this->_is_report_group;
    }
} // end of class


/**
 * A class to define a group header or footer line.
 */
class tabular_report_defn_group_line
{
    /**
     * @ignore
     */
    private $_columns;

    /**
     * @ignore
     */
    private $_group;

    /**
     * Construct a new group line for tabular report groups.
     * These lines can be used for either headers or footers.
     *
     * This method accepts an associative array of either strings or tabular_report_cellfmt objects.
     * If the value is a string, it is passed to the constructor of tabular_report_cellfmt.
     * The keys of the associative array must match defined report columns.
     *
     * It is possible to define nothing for a particular column in a group line.
     * in which case nothing will be output for that particular column in that particular
     * header or footer line.
     *
     * @param array $hash An associative array of strings or tabular_report_cellfmt objects.
     */
    public function __construct($hash)
    {
        foreach( $hash as $key => $tmp ) {
            if( !$key || !$tmp ) continue;

            $tpl = null;
            if( is_string($tmp) && $tmp !== '' ) {
                // treat the value as a template for display.
                // here we should get the column from the report
                // and just adjust it's template.
                $tpl = $tmp;
            }
            else if( is_object($tmp) && is_a($tmp,'CGExtensions\reports\tabular_report_cellfmt' ) ) {
                // we passed in an absolute cellfmt, so we use that.
                $tpl = $tmp;
            }
            $this->_columns[$key] = $tpl;
        }
    }

    /**
     * Get the cell format for a specific column for this group line
     *
     * @param string $key The column key.
     * @return tabular_report_cellfmt|null
     */
    public function get_cell_format($key)
    {
        if( !array_key_exists($key,$this->_columns) ) return;
        $tmp = $this->_columns[$key];
        if( is_object($tmp) ) {
            return $tmp;
        }
        $report = $this->_group->get_report();
        $orig = $report->get_column($key);
        $tpl = clone($orig);
        $tpl->set_template($tmp);
        $this->_columns[$key] = $tpl;
        return $tpl;
    }

    /**
     * Set the group for this group line.
     *
     * @internal
     * @param tabular_report_defn_group $grp
     */
    public function set_group(tabular_report_defn_group $grp)
    {
        $this->_group = $grp;
    }
}
?>