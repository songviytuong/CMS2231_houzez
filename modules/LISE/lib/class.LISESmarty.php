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

class LISESmarty 
{
  static private $_ready = FALSE;
  static private $_LI2_present = FALSE;
  static private $_CMSMS2 = FALSE;
  
  private static function _init()
  {
    if(!self::$_ready)
    {
      self::$_LI2_present = is_object( cmsms()->GetModuleInstance('ListIt2') );
      self::$_CMSMS2 = lise_utils::isCMS2();
      self::$_ready = TRUE;
    }
  }
  
  public static function LI2_present()
  {
    self::_init();
    return self::$_LI2_present;
  }
    
  public static function IsCMSMS2()
  {
    self::_init();
    return self::$_CMSMS2;
  }
  
  public static function InstanceName()
  {
    $instance = cms_utils::get_app_data('lise_instance');
    if( empty($instance) ) $instance = '::NA::'; 
    return $instance;
  }
  
  public static function Log($message = '')
  {
    \lise_utils::log();
  }
	
} // end of class
?>