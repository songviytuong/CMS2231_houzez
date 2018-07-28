<?php
#-------------------------------------------------------------------------
# LISE - List It Special Edition
# Version 1.2
# A fork of ListI2
# maintained by Fernando Morgado AKA Jo Morg
# since 2015
#-------------------------------------------------------------------------
#
# Original Author: Ben Malen, <ben@conceptfactory.com.au>
# Co-Maintainer: Simon Radford, <simon@conceptfactory.com.au>
# Web: www.conceptfactory.com.au
#
#-------------------------------------------------------------------------
#
# Maintainer since 2011 up to 2014: Jonathan Schmid, <hi@jonathanschmid.de>
# Web: www.jonathanschmid.de
#
#-------------------------------------------------------------------------
#
# Some wackos started destroying stuff since 2012 and stopped at 2014:
#
# Tapio Löytty, <tapsa@orange-media.fi>
# Web: www.orange-media.fi
#
# Goran Ilic, <uniqu3e@gmail.com>
# Web: www.ich-mach-das.at
#
#-------------------------------------------------------------------------
#
# LISE is a CMS Made Simple module that enables the web developer to create
# multiple lists throughout a site. It can be duplicated and given friendly
# names for easier client maintenance.
#
#-------------------------------------------------------------------------
# BEGIN_LICENSE
#-------------------------------------------------------------------------
# This file is part of LISE
# LISE program is free software; you can redistribute it and/or modify
# it under the terms of the GNU General Public License as published by
# the Free Software Foundation; either version 2 of the License, or
# (at your option) any later version.
#
# LISE program is distributed in the hope that it will be useful,
# but WITHOUT ANY WARRANTY; without even the implied warranty of
# MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
# GNU General Public License for more details.
# You should have received a copy of the GNU General Public License
# along with this program; if not, write to the Free Software
# Foundation, Inc., 59 Temple Place, Suite 330, Boston, MA 02111-1307 USA
# Or read it online: http://www.gnu.org/licenses/licenses.html#GPL
#
#-------------------------------------------------------------------------
# END_LICENSE
#-------------------------------------------------------------------------
class lise_datetime_utils
{
  private static $_timepicker2php = array(
                                            'hh'  => 'h',
                                            'HH'  => 'H',
                                            'mm'  => 'i',
                                            'ss'  => 's',
                                            'p'   => 'A',
                                            'H'   => 'G',
                                            'h'   => 'g',
                                          );
                                      
  private static $_datepicker2php = array(
                                            'ATOM'      => 'Y-m-d',
                                            'COOKIE'    => 'D, d M Y',
                                            'ISO_8601'  => 'Y-m-d',
                                            'RFC_822'   => 'D, j M y',
                                            'RFC_850'   => 'l, d-M-y',
                                            'RFC_1036'  => 'D, j M y',
                                            'RFC_1123'  => 'D, j M Y',
                                            'RFC_2822'  => 'D, j M Y',
                                            'RSS'       => 'D, j M y',
                                            'TICKS'     => '<!>', // replace with Windows ticks
                                            'TIMESTAMP' => 'U',
                                            'W3C'       => 'Y-m-d',
                                            'dd'        => 'd',
                                            'oo'        => '<z>', // pad to three digits
                                            'DD'        => 'l',
                                            'mm'        => 'm',
                                            'MM'        => 'F',
                                            'yy'        => 'Y',
                                            '@'         => 'U',
                                            '!'         => '<!>', // replace with Windows ticks
                                            'd'         => 'j',
                                            'o'         => 'z',
                                            'D'         => 'D',
                                            'm'         => 'n',
                                            'M'         => 'M',
                                            'y'         => 'y',
                                          );
                                          
  private static function _format_replace($format, $translations)
  {
    $pattern = join( '|', array_map( 'preg_quote', array_keys($translations) ) );

    preg_match_all("/$pattern/s", $format, $matches);
    
    $processed = array();
    
    foreach ($matches[0] as $match)
    {
      if ( !isset($processed[$match]) ) 
      {
        $format = str_replace($match, $translations[$match], $format);
        $processed[$match] = true;
      }
    }
    
    return $format;
  } 
  
  public static final function date_to_unix_ts($value)
  {
    # fix to take into account timezone offsets as suggested by
    # Darren Kierman (kierweb)
    $offset = date_format(date_create($value), 'Z');
    return date_format(date_create($value), 'U') + $offset;
  }
  
  public static final function unix_ts_to_date($value, $format)
  {
    $datetime = new DateTime("@$value");
    return $datetime->format($format);
  }

  public static function format_to_datepicker($format) 
  {
    return self::_format_replace($format, self::$_datepicker2php);
  }

  public static function format_to_timepicker($format)
  {
    return self::_format_replace($format, self::$_timepicker2php);
  }
}
?>