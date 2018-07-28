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

class LISELoader
{
  static final public function loader($params, &$smarty)
  {
    $item = isset($params['item']) ? $params['item'] : 'item';
    $instance = isset($params['instance']) ? $params['instance'] : cms_utils::get_app_data('lise_instance'); // Mandatory
    $identifier = isset($params['identifier']) ? $params['identifier'] : null;
    $value = isset($params['value']) ? $params['value'] : null; // Mandatory
    $force_array = isset($params['force_array']) ? true : false;
    $result = array();

    if(is_null($instance))
      throw new \LISE\Exception($smarty->left_delimiter . "LISELoader" . $smarty->right_delimiter . ": Parameter instance is not given.");
  
    if(is_null($value))
      throw new \LISE\Exception($smarty->left_delimiter . "LISELoader" . $smarty->right_delimiter . ": Parameter value is not given.");
      
    // Load wanted instance
    $instance = cmsms()->GetModuleInstance($instance);
    if(!$instance instanceof LISE)
      throw new \LISE\Exception($smarty->left_delimiter . "LISELoader" . $smarty->right_delimiter . ": Loaded instance is not LISE instance.");
    
    // Get loader info
    switch($item) {
    
      case 'item':
        
        $loader = 'LoadItemByIdentifier';
        if(is_null($identifier))
          $identifier = 'item_id';
        break;
        
      case 'category':

        $loader = 'LoadCategoryByIdentifier';
        if(is_null($identifier))
          $identifier = 'category_id';        
        break;
        
      default:
        throw new \LISE\Exception($smarty->left_delimiter . "LISELoader" . $smarty->right_delimiter . ": Unknown item type");

    } // end switch
    
    global $mleblock;
    //Load
    $value = explode(',', $value);
    foreach((array)$value as $one) {
      $result[$one] = $instance->$loader($identifier, $one, $mleblock);
    }
      
    // Return singular, if singular & force array is Off
    if(count($result) == 1 && !$force_array)     
      $result = $result[key($result)];
        
    // Assign
    if(isset($params['assign'])) {
      $smarty->assign($params['assign'], $result);      
      return;
    }
  
    return $result;
    
  }
}
?>
