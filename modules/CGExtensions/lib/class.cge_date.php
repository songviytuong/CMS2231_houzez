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
 * A Class to represent and operate on a date
 *
 * @package CGExtensions
 * @category Utilities
 * @author  calguy1000 <calguy1000@cmsmadesimple.org>
 * @copyright Copyright 2010 by Robert Campbell
 */

/**
 * A Class to represent and operate on a date
 *
 * @deprecated
 */
class cge_date
{
    /**
     * @ignore
     */
    private $_time;

    /**
     * Constructor
     *
     * @param mixed $time A mixed value.  If an integer value is passed, it is assumed to be a unix timestamp.  If a string is passed, then attempts are made to convert the string into a unix timestamp.
     */
    public function __construct($time = '')
    {
        $ntime = $time;
        if( !$time ) {
            $ntime = time();
        }
        else if( !is_numeric($time) ) {
            $ntime = strtotime($time);
            if( !$ntime ) {
                $db = cge_utils::get_db();
                $ntime = $db->UnixTimeStamp($time);
            }
        }
        $this->_time = $ntime;
    }

    /**
     * @ignore
     */
    private static function _explode($the_date)
    {
        $res = array();
        $res['day'] = date('d',$the_date);
        $res['month'] = date('m',$the_date);
        $res['year'] = date('Y',$the_date);
        $res['hour'] = date('H',$the_date);
        $res['minutes'] = date('i',$the_date);
        $res['seconds'] = date('s',$the_date);
        return $res;
    }

    /**
     * @ignore
     */
    private static function _implode($data)
    {
        $time = mktime(
            (isset($data['hour']))?$data['hour']:0,
            (isset($data['minutes']))?$data['minutes']:0,
            (isset($data['seconds']))?$data['seconds']:0,
            (isset($data['month']))?$data['month']:0,
            (isset($data['day']))?$data['day']:0,
            (isset($data['year']))?$data['year']:0);
        return $time;
    }

    /**
     * Convert the current object to a unix timestamp
     *
     * @return int
     */
    public function to_timestamp()
    {
        return $this->_time;
    }

    /**
     * convert the current object to a format suitable for saving in the database
     *
     * @return string
     */
    public function to_dbformat()
    {
        $db = cge_utils::get_db();
        return trim($db->DbTimeSTamp($this->_time),"'");
    }

    /**
     * Return the day of this object
     *
     * @return int
     */
    public function day()
    {
        return date('d',$this->_time);
    }

    /**
     * Set the day of this object
     *
     * @param int $d
     * @return int
     */
    public function set_day($d)
    {
        $d = (int) $d;
        $tmp = self::_explode($this->_time);
        $tmp['day'] = $d;
        $this->_time = self::_implode($tmp);
    }

    /**
     * Get the month of this object
     *
     * @return int
     */
    public function month()
    {
        return date('m',$this->_time);
    }

    /**
     * Set the month of this object
     *
     * @param int $m
     */
    public function set_month($m)
    {
        $m = (int) $m;
        $tmp = self::_explode($this->_time);
        $tmp['month'] = $m;
        $this->_time = self::_implode($tmp);
    }

    /**
     * Get the year of this object
     *
     * @return int
     */
    public function year()
    {
        return date('Y',$this->_time);
    }

    /**
     * Set the year of this object
     *
     * @param int $y
     */
    public function set_year($y)
    {
        $tmp = self::_explode($this->_time);
        $tmp['year'] = $y;
        $this->_time = self::_implode($tmp);
    }

    /**
     * Get the hour of this object
     *
     * @return int
     */
    public function hour()
    {
        return date('H',$this->_time);
    }

    /**
     * Set the hour of this object
     *
     * @param int $h
     */
    public function set_hour($h)
    {
        $h = (int) $h;
        $tmp = self::_explode($this->_time);
        $tmp['hour'] = $h;
        $this->_time = self::_implode($tmp);
    }

    /**
     * Get the minutes of this object
     *
     * @return int
     */
    public function minutes()
    {
        return date('i',$this->_time);
    }

    /**
     * Set the minutes of this object
     *
     * @param int $m
     */
    public function set_minutes($m)
    {
        $tmp = self::_explode($this->_time);
        $tmp['minutes'] = $m;
        $this->_time = self::_implode($tmp);
    }

    /**
     * Get the seconds of this object
     *
     * @return int
     */
    public function seconds()
    {
        return date('s',$this->_time);
    }

    /**
     * Set the seconds of this object
     *
     * @param int $s
     */
    public function set_seconds($s)
    {
        $tmp = self::_explode($this->_time);
        $tmp['seconds'] = $s;
        $this->_time = self::_implode($tmp);
    }

    /**
     * Set the time of this object
     *
     * @param int $h
     * @param int $m
     */
    public function set_time($h,$m)
    {
        $tmp = self::_explode($this->_time);
        $tmp['hour'] = $h;
        $tmp['minutes'] = $m;
        $this->_time = self::_implode($tmp);
    }

    /**
     * Given a time string (in the format H:M, adjust the time of this object appropriately
     *
     * @param string $time_str
     */
    public function set_time_from_str($time_str)
    {
        $tmp = self::_explode($this->_time);
        list($h1,$m1) = explode(':',trim($time_str));
        $tmp['hour'] = $h1;
        $tmp['minutes'] = $m1;
        $this->_time = self::_implode($tmp);
    }

    /**
     * Get the current date from this object in rfc format
     *
     * @return string
     */
    public function get_rfc_date()
    {
        $fmt = '%Y-%m-%dT%H:%M:%S';
        $tmp = strftime($fmt,$this->_time);
        $tmp .= date('P');
        return $tmp;
    }
}

#
# EOF
#
?>