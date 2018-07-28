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
namespace LISE;
/**
* @author Fernando Morgado(JoMorg)
* @since 1.2.2
* Customizes LISE exception handling
*/
class Exception extends \Exception
{
  private $_mod = NULL;
  
  public function __construct() 
  {
    $this->_mod = \cms_utils::get_module('LISE');
    $params = func_get_args();
    $tmp_params = array();
    $newparams = array();
        
    if( !isset($params[0]) )
    {
      $code = \LISE\Error::UNKOWN;
      # not a typo; (note: we may change the notation for PHP 5.4 -> $newparams = [$code, $code];)
      # we need it twice: once for the Lang string translation and one to display the error code itself
      $newparams[] = $newparams[] = $code;
    }
    else
    {
      # a numeric code has been provided instead of a message
      if( is_numeric($params[0]) )
      {
        $code = $params[0];
        # separate additional $params
        $tmp_params = array_slice($params, 1);
        $newparams[] = $newparams[] = $code;
      }
      else
      {
        if(count($params) == 1)
        # this is just a custom message instead of a real LISE error code: Discrete
        {
          $code = \LISE\Error::DISCRETE;
          $newparams[] = $newparams[] = $code;
          $newparams[] = $params[0]; 
        }
        else
        # the call has been called with all its parameters filled:
        # i.e.: throw new \LISE\Exception($msg, $code[, $param1][, $param2]...[, $param(n)])
        # where the extra params are passed to the <Module>->Lang() method as aditional params        
        {
          $code = $params[1];
          # separate additional $params
          $tmp_params = array_slice($params, 2);
          $newparams[] = $newparams[] = $code; 
          $newparams[] = $params[0];
        }                                       
      }
      
      # prevent non existing errors
      if( !\LISE\Error::HasCode($code) )
      {
        $code = \LISE\Error::Unknown;
        $newparams[] = $newparams[] = $code; 
      }     
    } 
    
    # we merge any aditional params and pass them to LISE->Lang();  
    $newparams = array_merge($newparams,  $tmp_params); 
    $msg = call_user_func_array(array($this->_mod, 'Lang'), $newparams) . ' @ ' . $this->file . ' (' . $this->line . ')';
    parent::__construct($msg, (int)$code);
  }
  
  public function __toString()
  {
    return '## ' . $this->message . ' ##';
  }
}

?>