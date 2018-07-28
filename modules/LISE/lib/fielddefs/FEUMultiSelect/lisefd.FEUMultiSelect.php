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
class lisefd_FEUMultiSelect extends LISEFielddefBase
{
  private $_opts = array();
  
  public function __construct(&$db_info) 
  {   
    parent::__construct($db_info);
    
    $this->SetFriendlyType( $this->ModLang('fielddef_' . $this->GetType() ) );
  }
    
  static public function GetModuleDeps()
  {
    
    return array(
                  'FrontEndUsers' => '1.18.1',
                  'CGExtensions' => '1.29.1'    //??
                );
  }
  
  public function GetHeaderHTML()
  {
    $tmpl = '';
    if( $this->GetOptionValue('type', 'MultiSelect') == 'MultiSelect' )
    {
        $tmpl = <<<EOT
<link type="text/css" rel="stylesheet" href="{$this->GetURLPath()}/jquery.multi-select.css" />
<script type="text/javascript" src="{$this->GetURLPath()}/jquery.multi-select.js"></script>
EOT;
    }
    return $tmpl;
  }
    
  // get available groups from FEU module 
  public function GetFEUGroups() 
  {   
    $FEU = cmsms()->GetModuleInstance('FrontEndUsers');
    
    if(is_object($FEU))
    {
      $groups = $FEU->GetGroupListFull();
       
      if($groups)
      {
        $options = array();
        
        foreach($groups as $option) 
        {
          $options[$option['id']] = $option['groupname'];
        }
      }
      
      return $options;
    }
  }
  
  public function GetFeuProperties()
  {
    $FEU = cmsms()->GetModuleInstance('FrontEndUsers');
    $feu_props = $FEU->GetPropertyDefns();
    
    // remove selfreg prop
    if( isset($feu_props['__SELFREG']) ) unset($feu_props['__SELFREG']);
    
    $feu_options = array();
    $feu_optionsb = array();
    foreach($feu_props as $one)$feu_options[ $one['name'] ] = $one['prompt'];
    asort($feu_options);
    $feu_optionsb[-1] = lang('none'); 
    $feu_optionsb[0] = $FEU->Lang('prompt_username');
    $feu_options = array_merge($feu_optionsb, $feu_options);
    return $feu_options;
  } 
     
  public function GetOptions() 
  {
    $this->_opts['type'] = $this->GetOptionValue('type', 'MultiSelect');
    $this->_opts['types'] = array(
                                    'MultiSelect'         => $this->ModLang('fielddef_MultiSelect'),
                                    'CheckboxGroup'       => $this->ModLang('fielddef_CheckboxGroup'),
                                    'JQueryMultiSelect' => $this->ModLang('fielddef_JQueryMultiSelect')
                                  );
    return $this->_opts;
  }
    
  // get list of users from FEU module based on selected group
  public function GetFEUUserList() 
  {    
    $FEU = cmsms()->GetModuleInstance('FrontEndUsers');
    
    if(is_object($FEU))
    {    
      // GetUsersInGroup() is deprecated but GetFullUsersInGroup() seems to have a bug, 
      // change this after FEU BR #8753 http://dev.cmsmadesimple.org/bug/view/8753 is confirmed and fixed 
      $groups =  explode(',', $this->GetOptionValue('feu_options') );
      $feu_prop = $this->GetOptionValue('feu_field');
      $feu_prop2 = $this->GetOptionValue('feu_field2');
      $use_username = $this->GetOptionValue('use_username');
      $use_uid = $this->GetOptionValue('use_uid');
      $separator = $this->GetOptionValue('separator');
      $users = array();
      
      foreach($groups as $group)
      {
        $tmpusers = $FEU->GetUsersInGroup($group);
        foreach($tmpusers as $one)
        {
          if( array_key_exists($one['id'], $users) ) continue;
          
          $uid = (bool)$use_uid ? '[' . $one['id'] . '] ' : ''; 
          #now lets build the multiselect
          if($use_username)
          {
            $users[$one['id']] = $uid . $one['username'];
          }
          else
          {
            if( $feu_prop == NULL || (is_numeric($feu_prop) && $feu_prop == -1) )
            {
              $users[$one['id']] = $uid . $one['username'];
            }
            else
            {
              $users[$one['id']] = $uid;
              
              if(is_numeric($feu_prop) && $feu_prop == 0)
              {
                $users[$one['id']] .= $one['username'];
              }
              else
              {
                $users[$one['id']] .= $FEU->GetUserPropertyFull($feu_prop, $one['id']);
              }
     
              if( is_numeric($feu_prop2) && $feu_prop2 == 0 && !(is_int($feu_prop) && $feu_prop < 1) )
              {
                $users[$one['id']] .= $separator . $one['username'];
              }
              elseif( !(is_int($feu_prop2) && $feu_prop2 == -1) )
              {
                $users[$one['id']] .= $separator . $FEU->GetUserPropertyFull($feu_prop2, $one['id']);
              } 
            }
          }
        }
        
      }
      
      asort($users);
      
      return $users;
    }
  }
  
  public function RenderForAdminListing($id, $returnid)
  {
    $users = (array)$this->GetValue();
    $smarty = cmsms()->GetSmarty();
    $smarty->assign('users', $users);
    return parent::RenderForAdminListing($id, $returnid);
  }
}// end of class
?>