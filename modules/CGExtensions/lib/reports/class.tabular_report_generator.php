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
 * This file defines the abstract tabular report generator class.
 *
 * @package CGExtensions
 * @category Reports
 * @author  calguy1000 <calguy1000@cmsmadesimple.org>
 * @copyright Copyright 2010 by Robert Campbell
 */

namespace CGExtensions\reports;

/**
 * An abstract class to aide in generating a tabular report.
 */
abstract class tabular_report_generator extends report_generator
{
    /**
     * @ignore
     */
    private   $_row;

    /**
     * @ignore
     */
    private   $_prev_row;

    /**
     * @ignore
     */
    protected $_record_number = 0;

    /**
     * @ignore
     */
    protected function set_row($input_row)
    {
        // preprocess the data. so that we have values for all of our column keys
        // even if the values are empty.
        $rs = $this->report()->get_resultset();
        $smarty = cmsms()->GetSmarty();
        $row = array();
        foreach( $input_row as $colname => $val ) {
            $smarty->assign($colname,$val);
        }
        foreach( $this->report()->get_columns() as $key => $col ) {
            $val = '';
            if( isset($input_row[$key]) ) $val = $input_row[$key];
            $row[$key] = $col->process_value($val,$rs);
            $smarty->assign($key,$row[$key]);
        }

        if( is_array($this->_row) ) $this->_prev_row = $this->_row;
        $this->_row = $row;
    }

    /**
     * @ignore
     */
    protected function finish()
    {
        $this->do_group_footers(TRUE);
        if( ($grp = $this->report()->get_report_group()) ) {
            $this->do_group_footer($grp);
        }
    }

    /**
     * A callback function that is called before each and every line.
     *
     * @abstract
     * @return void
     */
    protected function before_line() {}

    /**
     * A callback function that is called after each and every line.
     *
     * @abstract
     * @return void
     */
    protected function after_line() {}

    /**
     * A callback function that is called before the start of outputing group footers.
     *
     * @abstract
     * @return void
     */
    protected function before_group_footers() {}

    /**
     * A callback function that is called after the outputing group footers.
     *
     * @abstract
     * @return void
     */
    protected function after_group_footers() {}

    /**
     * A callback function that is called before the outputing group headers.
     *
     * @abstract
     * @return void
     */
    protected function before_group_headers() {}

    /**
     * A callback function that is called after the outputing group headers.
     *
     * @abstract
     * @return void
     */
    protected function after_group_headers() {}

    /**
     * A callback function to draw a cell.
     *
     * @abstract
     * @param tabular_report_cellfmt $cell
     * @param string $contents the cell contents.
     */
    abstract protected function draw_cell(tabular_report_cellfmt $cell,$contents);

    /**
     * A function to get cell contents for the specified column of the current row.
     *
     * @param string $col_key The column key (must be a registered column)
     * @param string $tpl The cell template.
     * @param array $row The current row array (usually used internally)
     * @return string The formatted cell contents.
     */
    protected function get_cell_contents($col_key,$tpl = null,$row = null)
    {
        $smarty = cmsms()->GetSmarty();

        $val = '';
        if( !$row ) $row = $this->_row;
        if( isset($row[$col_key]) ) $val = $row[$col_key];
        $col = $this->report()->get_column($col_key);

        $smarty->assign('val',$val);
        $smarty->assign('value',$val);

        $smarty->assign('min',$col->get_min());
        $smarty->assign('max',$col->get_max());
        $smarty->assign('count',$col->get_count());
        $smarty->assign('sum',$col->get_sum());
        $smarty->assign('mean',$col->get_mean());
        $smarty->assign('median',$col->get_median());
        $tmp = null;
        if( $tpl ) $tmp = $smarty->fetch('string:'.$tpl);
        return $tmp;
    }

    /**
     * A function to get cell contents for a group header or footer cell.
     *
     * @param string $col_key The column key (must be a registered column)
     * @param string $grp_key The group key.
     * @param string $tpl The cell template.
     * @param array $row The current resultset row.  Only for internal use.
     * @return string The formatted cell contents.
     */
    protected function get_group_cell_contents($col_key,$grp_key,$tpl,$row = null)
    {
        $smarty = cmsms()->GetSmarty();
        $col = $this->report()->get_column($col_key);
        $smarty->assign('label',$col->get_label());
        $smarty->assign('grp_min',$col->get_grp_min($grp_key));
        $smarty->assign('grp_max',$col->get_grp_max($grp_key));
        $smarty->assign('grp_count',$col->get_grp_count($grp_key));
        $smarty->assign('grp_sum',$col->get_grp_sum($grp_key));
        $smarty->assign('grp_mean',$col->get_grp_mean($grp_key));
        $smarty->assign('grp_median',$col->get_grp_median($grp_key));
        $smarty->assign('last_val',$this->_prev_row[$col_key]);
        $contents = $this->get_cell_contents($col_key,$tpl,$row);
        return $contents;
    }

    /**
     * A callback function called before each row.
     *
     * @abstract
     * @return void
     */
    protected function before_row()
    {
        $this->do_group_footers();
        $this->do_group_headers();
    }

    /**
     * A callback function called after each row.
     *
     * @abstract
     * @return void
     */
    protected function after_row()
    {
        $this->add_column_histories($this->_row);
        $this->_record_number++;
    }

    /**
     * Test if the value for a specified group has changed.
     *
     * @param tabular_report_defn_group $grp The group that references the watched column.
     * @param array $row The data row.
     * @return bool
     */
    protected function changed(tabular_report_defn_group $grp,$row)
    {
        $col_key = $grp->get_column();
        if( array_key_exists($col_key,$row) ) {
            $val = $row[$col_key];
            $col = $this->report()->get_column($col_key);
            return $col->changed($val);
        }
        return FALSE;
    }

    /**
     * A callback function that is called before a single group header is output.
     *
     * @abstract
     * @param tabular_report_defn_group $grp
     * @param bool $is_first True if this is the first of all group headers (subject to change)
     * @return void
     */
    protected function before_group_header(tabular_report_defn_group $grp,$is_first = FALSE) {}

    /**
     * A callback function that is called after a single group header is output.
     *
     * @abstract
     * @param tabular_report_defn_group $grp
     * @return void
     */
    protected function after_group_header(tabular_report_defn_group $grp) {}

    /**
     * @ignore
     */
    protected function do_group_header(tabular_report_defn_group $grp,$is_first = FALSE)
    {
        $lines = $grp->get_header_lines();
        if( count($lines) ) {
            $this->before_group_header($grp,$is_first);
            foreach( $lines as $line ) {
                $this->before_line();
                $columns = $this->report()->get_columns();
                $keys = array_keys($columns);
                for( $col_idx = 0; $col_idx < count($keys); ) {
                    $key = $keys[$col_idx];
                    $contents = null;
                    $fmt = $line->get_cell_format($key);
                    if( is_object($fmt) ) {
                        $contents = $this->get_group_cell_contents($key,$grp->get_column(),$fmt->get_template());
                    } else {
                        // there is no format information specified in the header line
                        // but we need to know stuff like (maybe background color, alignment, color etc)
                        // so get a format from the report
                        $fmt = $this->report()->get_column($key);
                        $contents = $this->get_group_cell_contents($key,$grp->get_column(),'');
                    }
                    $this->draw_cell($fmt,$contents);
                    $col_idx += max(1,$fmt->get_span());
                }
                $this->after_line();
            }
            $this->after_group_header($grp);
        }
    }

    /**
     * @ignore
     */
    protected function do_group_headers($do_headers = false)
    {
        $grps = $this->report()->get_groups();
        $grp_header_num = 0;
        if( count($grps) ) {
            foreach( $grps as $grp ) {
                if( $do_headers || $this->_record_number == 0 || $this->changed($grp,$this->_row) ) {
                    if( $grp_header_num == 0 ) $this->before_group_headers();
                    $this->do_group_header($grp,($grp_header_num == 0));
                }
                $grp_header_num++;
            }
        }
        if( $grp_header_num > 0 ) $this->after_group_headers();
    }

    /**
     * A callback function that is called before a single group footer is generated.
     *
     * @abstract
     * @param tabular_report_defn_group $grp
     * @return void
     */
    protected function before_group_footer(tabular_report_defn_group $grp) {}

    /**
     * A callback function that is called after a single group footer is generated.
     *
     * @abstract
     * @param tabular_report_defn_group $grp
     * @return void
     */
    protected function after_group_footer(tabular_report_defn_group $grp) {}

    /**
     * @ignore
     */
    protected function do_group_footer(tabular_report_defn_group $grp)
    {
        $lines = $grp->get_footer_lines();
        if( count($lines) ) {
            $this->before_group_footer($grp);
            foreach( $lines as $line ) {
                $this->before_line();
                $columns = $this->report()->get_columns();
                $keys = array_keys($columns);
                for( $col_idx = 0; $col_idx < count($keys); ) {
                    $key = $keys[$col_idx];
                    $contents = null;
                    $fmt = $line->get_cell_format($key);
                    if( is_object($fmt) ) {
                        $contents = $this->get_group_cell_contents($key,$grp->get_column(),$fmt->get_template(),$this->_prev_row);
                    } else {
                        // there is no format information specified in the footer line
                        // but we need to know stuff like (maybe background color, alignment, color etc)
                        // so get a format from the report
                        $fmt = $this->report()->get_column($key);
                        $contents = $this->get_group_cell_contents($key,$grp->get_column(),'',$this->_prev_row);
                    }
                    $this->draw_cell($fmt,$contents);
                    $col_idx += max(1,$fmt->get_span());
                }
                $this->after_line();
            }
            $this->after_group_footer($grp);
        }
        // this group has changed, go through all columns and reset this group
        foreach( $this->report()->get_columns() as $key => $col ) {
            $col->reset_group($grp->get_column());
        }
    }

    /**
     * @ignore
     */
    protected function do_group_footers($do_footers = false)
    {
        $grp_footer_num = 0;
        if( $do_footers || $this->_record_number > 0 ) {
            // check for column changes
            $grps = $this->report()->get_groups();
            if( count($grps) ) {
                end($grps);
                do {
                    $grp = current($grps);
                    if( $do_footers || $this->changed($grp,$this->_row) ) {
                        if( $grp_footer_num == 0 ) $this->before_group_footers();
                        $this->do_group_footer($grp);
                        $grp_footer_num++;
                    }
                }
                while( prev($grps) );
            }
        }
        if( $grp_footer_num > 0 ) $this->after_group_footers();
    }

    /**
     * @ignore
     */
    protected function add_column_histories($row)
    {
        foreach( $this->report()->get_columns() as $key => &$col ) {
            if( array_key_exists($key,$row) ) {
                $val = $row[$key];
                $col->add_history_value($val);
                $grps = $this->report()->get_all_groups();
                if( count($grps) ) {
                    foreach( $grps as &$grp ) {
                        $col->add_group_history_value($grp->get_column(), $val);
                    }
                }
            }
        }
    }

    /**
     * @ignore
     */
    protected function start()
    {
        if( ($grp = $this->report()->get_report_group()) ) {
            $this->do_group_header($grp,TRUE);
        }
    }

    /**
     * @ignore
     */
    protected function each_row($row)
    {
        $this->set_row($row);
        $this->before_row();
        $this->before_line();
        $content_columns = $this->report()->get_content_columns();
        foreach( $this->report()->get_columns() as $key => $col ) {
            if( in_array($key,$content_columns) ) {
                // this column is in the main content row
                // though the value may still be null.
                $tpl = $this->report()->get_column($key)->get_template();
                if( !$tpl ) $tpl = '{$val}';
                $this->draw_cell($col,$this->get_cell_contents($key,$tpl));
            }
            else {
                // this column is not in the main content row
                // so draw a null value
                $this->draw_cell($col,null);
            }
        }
        $this->after_line();
        $this->after_row();
    }

} // end of class

?>