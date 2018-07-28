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
 * A set of convenience methods to work with dates and times
 *
 * @package CGExtensions
 * @category Utilities
 * @deprecated
 * @author  calguy1000 <calguy1000@cmsmadesimple.org>
 * @copyright Copyright 2010 by Robert Campbell
 */

/**
 * A set of convenience methods to work with dates and times
 *
 * @package CGExtensions
 */
final class cge_date_utils
{
    private function __construct() {}

    /**
     * Given month, day year input fields in parameters, and a prefix create a unix timestamp
     * this is useful when processing form data from {html_select_date}
     *
     * i.e: <code>$ts = \cge_date_utils::date_from_form($params,$id,'startdate');</code>
     *
     * @param array $params An associative array, usually from form submission.
     * @param string $prefix The prefix for the Month, Day, and Year fields within the params array
     * @param string $prefix2 An optional second prefix to append to the first one (i.e: the field name)
     * @return int unix timestamp representing the date in the input parmeters at 00:00 hours.  or null
     */
    public static function date_from_form($params,$prefix,$prefix2 = null)
    {
        $prefix = (string) $prefix;
        $prefix .= (string) $prefix2;
        if( !is_array($params) ) return;

        $ts = mktime(0,0,0,
                     \cge_param::get_int($params,$prefix.'Month'),
                     \cge_param::get_int($params,$prefix.'Day'),
                     \cge_param::get_int($params,$prefix.'Year'));
        return $ts;
    }

    /**
     * Convert a string to a timestamp.
     * An alias for strtotime
     *
     * @deprecated
     * @param string $str The input date/time string
     * @return int The unix timestamp
     */
    static public function str_to_timestamp($str)
    {
        return strtotime($str);
    }

    /**
     * Given a unxix timestamp, an hour and minutes value
     * adjust the unix timestamp accordingly.
     *
     * @param int $timestamp
     * @param int $hour
     * @param int $minutes
     * @return int
     */
    static public function ts_set_time($timestamp,$hour,$minutes)
    {
        $obj = new cge_date($timestamp);
        $obj->set_time($hour,$minutes);
        return $obj->to_timestamp();
    }

    /**
     * Create a unix timestamp from a string.
     * adjust the unix timestamp accordingly.
     *
     * @param int $timestamp
     * @param string $str
     * @return int
     * @deprecated
     */
    static public function ts_set_time_from_str($timestamp,$str)
    {
        $obj = new cge_date($timestamp);
        $obj->set_time_from_str($str);
        return $obj->to_timestamp();
    }

    /**
     * Test if the given year (or the current year) is a leapyear
     *
     * @param int $year Optional year.
     * @return bool
     */
    static public function is_leapyear($year = '')
    {
        if( !$year ) $year = date('Y');

        $f = 0;
        if( $year % 4 == 0 ) $f = 1;
        if( $year % 100 == 0 ) $f == 0;
        if( $year % 400 == 0 ) $f = 1;
        return $f;
    }

    /**
     * Return the days in the given month/year
     *
     * @param int $month The specified month, if not specified the current month is used.
     * @param int $year The specified year.  If not specified, the current year is used.
     * @return int
     */
    static public function days_in_month($month = '',$year = '')
    {
        $days_in_month = array(31, 28, 31, 30, 31, 30, 31, 31, 30, 31, 30, 31);

        if( !$month ) $month = date('m');
        if( !$year ) $year = date('Y');
        if( self::is_leapyear($year) )$days_in_year[1] = 29;

        // month is a value from 1 to 12.
        return $days_in_year[$month-1];
    }

    /**
     * Create a cge_date given specified time values
     *
     * @deprecated
     * @param int $month
     * @param int $day
     * @param int $year
     * @param int $hour
     * @param int $minute
     * @param int $seconds
     * @return cge_date
     */
    static public function &date_at($month,$day,$year,$hour = 0,$minute = 0,$seconds = 0)
    {
        $tmp = mktime($hour,$minute,$seconds,$month,$day,$year);
        return new cge_date($tmp);
    }

    /**
     * Convert a timestamp to database format
     *
     * @param int $ts
     * @return string
     */
    static public function ts_to_dbformat($ts)
    {
        $db = cge_utils::get_db();
        return trim($db->DbTimeSTamp($ts),"'");
    }

    /**
     * Convert a locale specific date/time string to a unix timestamp
     *
     * @param string $str The input string
     * @return int The unix timestamp.
     */
    static public function from_locale_str($str)
    {
        $lang = CmsNlsOperations::get_current_language();
        $date = $time = null;
        if( strpos($str,' ') !== FALSE ) {
            list($date,$time) = explode(' ',$str);
        }
        else {
            $date = $str;
        }
        $sep = $str[2];
        if( $lang != 'en_US') {
            list($day,$month,$year) = explode($sep,$date);
            $newstr = trim("$month/$day/$year $time");
            return strtotime($newstr);
        }
        return strtotime($str);
    }

    /**
     * Convert a unix timestamp to a locale specific format
     * (currently only support US and non US).
     *
     * @param int $ts The unix timestamp
     * @param bool $time_too Wether or not to include time in the output string
     * @param string $sep The separator between fields.  Default is '/'
     * @return string
     */
    static public function to_locale_str($ts,$time_too = TRUE,$sep = '/')
    {
        $lang = CmsNlsOperations::get_current_language();
        $fmt = "%d{$sep}%m{$sep}%Y";
        if( $lang == 'en_US' ) {
            $fmt = "%m{$sep}%d{$sep}%Y";
        }
        if( $time_too ) $fmt .= " %T";
        return strftime($fmt,$ts);
    }


    static public function rfc_date($ts)
    {
        $fmt = '%Y-%m-%dT%H:%M:%S';
        $tmp = strftime($fmt,$ts);
        $tmp .= date('P');
        return $tmp;
    }
} // end of class

#
# EOF
#
?>