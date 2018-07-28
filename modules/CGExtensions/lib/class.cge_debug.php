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
 * This file provides a static class containing debugging utilities.
 *
 * @package CGExtensions
 * @category Exceptions
 * @author  calguy1000 <calguy1000@cmsmadesimple.org>
 * @copyright Copyright 2010 by Robert Campbell
 */

/**
 * A simple class with some debug functions.
 * This class supports output to different files.
 *
 * @deprecated
 * @package CGExtensions
 */
final class cge_debug
{
    /**
     * @ignore
     */
    private function __construct() {}

    /**
     * @ignore
     */
    static private $_output;

    /**
     * @ignore
     */
    static private $_instant = 1;

    /**
     * @ignore
     */
    static private $_html = 1;

    /**
     * @ignore
     */
    static private $_filename;

    /**
     * Set flag indicating that output should be in html.
     *
     * @param bool $var
     */
    static function set_html($var = true)
    {
        self::$_html = (bool)$var;
    }

    /**
     * Get flag indicating that output should be in html or not.
     *
     * @return bool
     */
    static public function is_html()
    {
        return self::$_html;
    }

    /**
     * Set flag indicating that output should be output instantly, or cached
     *
     * @param bool $var
     */
    static public function set_instant($var = true)
    {
        self::$_instant = (bool)$var;
    }

    /**
     * Get flag indicating whether output should be output instantly, or cached
     *
     * @return bool
     */
    static public function is_instant()
    {
        return self::$_instant;
    }

    /**
     * Set filename for debug output.
     * The default value for this variable is TMP_CACHE_LOCATION/cge_debug.log
     *
     * @param string $str The absolute path to the filename.
     */
    static public function set_filename($str)
    {
        self::$_filename = $str;
    }


    /**
     * Output accrued debug information to a specified file.
     * If the filename parameter is not specified, the currently set filename
     * will be used, or a hardcoded filename.
     *
     * @param string $filename
     */
    static public function output($filename = '')
    {
        if( !$filename ) {
            if( self::$_filename ) $filename = self::$_filename;
            if( !$filename ) $filename = TMP_CACHE_LOCATION.'/cge_debug.log';
        }

        if( !count(self::$_output) ) return;

        if( !empty($filename) ) {
            $fh = @fopen($filename,'a');
            if( !$fh ) {
                trigger_error('Problem opening debug file: '.$filename);
                return;
            }

            foreach( self::$_output as $one ) {
                fputs($fh,$one);
            }
            fclose($fh);
            return;
        }

        foreach( self::$_output as $one ) {
            echo $one;
        }
    }

    /**
     * Add information to the debug log.
     *
     * @param mixed $var The variable to add to the debug log.  This method attempts to parse objects and arrays.
     * @param string $title The title for the debug message.
     */
    static public function add($var,$title = '')
    {
        $out = '';
        if( !$var ) return;

        if( empty($title) )	$title = 'DEBUG: ';
        if( self::is_html() ) {
            $out .= '<b>{$title}:</b>';
        }
        else {
            $out .= $title.": ";
        }

        ob_start();
        if( self::is_html() ) echo '<pre>';
        if( is_array($var) ) {
            echo "\nNumber of elements: " . count($var) . "\n";
            print_r($var);
        }
        elseif(is_object($var)) {
            print_r($var);
        }
        elseif(is_string($var)) {
            print_r(htmlentities(str_replace("\t", '  ', $var)));
        }
        elseif(is_bool($var)) {
            echo $var === true ? 'true' : 'false';
        }
        else {
            print_r($var);
        }
        if( self::is_html() ) echo '</pre>';

        $out .= ob_get_contents();
        ob_end_clean();
        $out .= "\n";

        if( self::is_instant() ) {
            echo $out;
        }
        else {
            self::$_output[] = $out;
        }
    }
}

#
# EOF
#
?>