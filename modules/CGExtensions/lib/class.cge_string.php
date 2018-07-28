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
 * A set of string utility functions.
 *
 * @package CGExtensions
 * @category Utilities
 * @author  calguy1000 <calguy1000@cmsmadesimple.org>
 * @copyright Copyright 2010 by Robert Campbell
 */

/**
 * A set of string utility functions.
 *
 * @package CGExtensions
 */
final class cge_string
{
    /**
     * @ignore
     */
    private function __construct() {}

    /**
     * A simple utility function to mask the first N characters of an input string
     *
     * @param string $instr The input string
     * @param int $numchars The number of characters to mask
     * @param string $mask The mask character
     * @return string
     */
    public static function mask_string($instr,$numchars,$mask = '*')
    {
        if( empty($mask) ) return $instr;
        if( strlen($mask) > 1 ) $mask = $mask[0];
        if( $numchars < 0 ) $numchars = strlen($instr) + $numchars;
        $numchars = min($numchars,strlen($instr));
        if( $numchars == 0 ) return $instr;

        for( $i = 0; $i < $numchars; $i++ ) {
            $instr[$i] = $mask;
        }
        return $instr;
    }

    /**
     * Truncate the input string after N words.
     *
     * @param string $str The input string
     * @param int $limit The word limit
     * @param string $end_char How to terminate the output string
     * @return string
     */
    public static function word_limiter($str, $limit = 100, $end_char = '...')
    {
        if (trim($str) == '') return $str;
        preg_match('/^\s*(?:\S+\s*){1,'. (int) $limit .'}/', $str, $matches);
        if (strlen($matches[0]) == strlen($str)) $end_char = '';
        return rtrim($matches[0]) . $end_char;
    }

    /**
     * Given an input string in the format of ###[GgMmKk] convert it into a byte count.
     * Each kilobyte is 1024 butes.  Each megabyte is 1024 kilobytes.  And each Gigabyte is 1024 megabytes.
     *
     * @param string $val
     * @return int
     */
    public static function str_to_bytes($val)
    {
        if(is_string($val) && $val != '') {
            $val = trim($val);
            $last = strtolower(substr($val, strlen($val/1), 1));
            switch($last) {
            case 'g':
                $val *= 1024;
            case 'm':
                $val *= 1024;
            case 'k':
                $val *= 1024;
            }
        }

        return (int) $val;
    }

    /**
     * Test that the string contains characters that are safe for smarty variables.
     *
     * i.e:  underscores, and alphanumerics, and starts with an underscore and/or alphabetic.
     *
     * @param string $val
     * @return bool
     */
    public static function is_smarty_safe($string)
    {
        return preg_match('/^[_A-Z][_A-Z0-9]*$/i',$string);
    }


    /**
     * Convert a locale specific string to a float
     */
    public static function to_float($in)
    {
        if( is_float($in) ) return $in;
        if( !is_string($in) ) $in = (string) $in;
        $lc = localeconv();
        $dp = $lc['decimal_point'];
        $ts = $lc['thousands_sep'];
        $tmp = str_replace($ts,'',$in);
        $out = str_replace($dp,'.',$tmp);
        return (float) $out;
    }

    public static function to_string($in)
    {
        if( is_string($in) ) return $in;
        if( !is_float($in) ) return $in;
        return sprintf('%F',$in);
    }
} // end of class

#
# EOF
#
?>