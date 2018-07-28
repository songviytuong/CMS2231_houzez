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
#-------------------------------------------------------------------------
# Current available events in system:
#  - OnItemLoad(LISE &$mod)
#  - OnItemSave(LISE &$mod)
#  - OnItemDelete(LISE &$mod)
#  - ItemSavePreProcess(Array &$errors, Array &$params) 
#  - ItemSavePostProcess(Array &$errors, Array &$params)
#
#-------------------------------------------------------------------------
class liseeh_SelectDateTime extends LISEEventHandlerBase
{

  #---------------------
  # Overwritable events
  #---------------------    

  /**
   * LISE Field Database Save method
   *
   * @return void
   */  
  public function OnItemSave(LISE $mod)
  {    
    $db = cmsms()->GetDb();
  
    $query  = 'DELETE FROM ' . cms_db_prefix() . 'module_' . $mod->_GetModuleAlias() . '_fieldval WHERE item_id = ? AND fielddef_id = ?';
    $result = $db->Execute($query, array($this->GetParentItem()->item_id, $this->GetId()));
      
//    if (!$result)
//      die('FATAL SQL ERROR: ' . $db->ErrorMsg() . '<br/>QUERY: ' . $db->sql);

    if(!$result) 
      throw new \LISE\Exception($db->ErrorNo() . ' - ' . $db->ErrorMsg() . ' - Query: ' . $db->sql, \LISE\Error::DISCRETE_DB );
  
    $query  = 'INSERT INTO ' . cms_db_prefix() . 'module_' . $mod->_GetModuleAlias() . '_fieldval (item_id, fielddef_id, value_index, value) VALUES (?,?,?,?)';
    $index = 0;
    $compatibility = $this->GetOptionValue('backwards_compatibility', FALSE);
    
    foreach($this->GetValue() as $one_val)
    {
      if(!$one_val) continue;
      
      $value = $one_val;
      
      if(!$compatibility)
      {
        $value = lise_datetime_utils::date_to_unix_ts($one_val);
      }
    
      $result = $db->Execute($query, array($this->GetParentItem()->item_id, $this->GetId(), $index, $value));

//      if (!$result)
//        die('FATAL SQL ERROR: ' . $db->ErrorMsg() . '<br/>QUERY: ' . $db->sql);

      if(!$result) 
        throw new \LISE\Exception($db->ErrorNo() . ' - ' . $db->ErrorMsg() . ' - Query: ' . $db->sql, \LISE\Error::DISCRETE_DB );

      $index++;            
    }
  
  }

  /**
   * LISE Field Database Load method
   *
   * @return void
   */    
  public function OnItemLoad(LISE &$mod)
  {
    $db = cmsms()->GetDb();
  
    $query = "SELECT value_index, value, data FROM " . cms_db_prefix() . "module_" . $mod->_GetModuleAlias() . "_fieldval WHERE fielddef_id = ? AND item_id = ?";
    $dbr = $db->Execute($query, array($this->GetId(), $this->GetParentItem()->item_id));
    
    $compatibility = $this->GetOptionValue('backwards_compatibility', FALSE);
    
    if(!$compatibility)
    {
      $date_format = lise_datetime_utils::format_to_datepicker( $this->GetOptionValue('date_format', 'dd-mm-yy') );
      $time_format = lise_datetime_utils::format_to_timepicker( $this->GetOptionValue('time_format', 'HH:mm') );
      $format_type = $this->GetOptionValue('format_type', 0);
      
      /**
      * 0 - combined
      * 1 - date_format
      * 2 - time_format
      */
      switch($format_type) 
      {
         case 0:
            $format = ($date_format) . ' ' . $time_format;
           break;
         case 1:
            $format = $date_format;
           break;
         case 2:
            $format = $time_format;
           break;
      }
    }
    
    $input_arr = array();
    
    while($dbr && !$dbr->EOF)
    {
      // ???? (JM)
      if(!is_null($dbr->fields['data']))
      {
        $this->SetValue( unserialize($dbr->fields['data']) );
        return;
      }
      
      $value = $dbr->fields['value'];
      
      
      
      if(!$compatibility)
      {
        $this->SetOptionValue('unix_datetime_stamp', $value);
        $value = lise_datetime_utils::unix_ts_to_date($value, $format);
      }
      else
      {
        $this->SetOptionValue( 'unix_datetime_stamp', lise_datetime_utils::date_to_unix_ts($value) );
      }
      
      $input_arr[$dbr->fields['value_index']] = $value;
      $dbr->MoveNext();
    }
    
    if($dbr) $dbr->Close();      
      
    $this->SetValue($input_arr); // <- Always set array, regardless of contents, check if this can fail.  
  }  

} // end of class

?> 