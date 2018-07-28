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
class lisefd_CustomFromUDT extends LISEFielddefBase
{
  private $_opts = array();
  
	public function __construct(&$db_info) 
	{	
		parent::__construct($db_info);
		$this->SetFriendlyType( $this->ModLang('fielddef_' . $this->GetType() ) );
	}
  
  public function GetOptions()
  {
    $udts = cmsms()->GetUserTagOperations()->ListUserTags();
    $udts_opts = array_combine( $udts, $udts);

    $this->_opts['udts'] = array( -1 => lang('none') )  +  $udts_opts; 
    $this->_opts['source_udt'] = $this->GetOptionValue('source_udt', -1);
    $this->_opts['validation_udt'] = $this->GetOptionValue('render_for_admin_listing_udt', -1);
    $this->_opts['validation_udt'] = $this->GetOptionValue('validation_udt', -1);
    $this->_opts['type'] = $this->GetOptionValue('type', 'Dropdown');
    $this->_opts['types'] = array(
                                    'Dropdown'      => $this->ModLang('fielddef_Dropdown'),
                                    'MultiSelect'   => $this->ModLang('fielddef_MultiSelect'),
                                    'RadioGroup'    => $this->ModLang('fielddef_RadioGroup'),
                                    'CheckboxGroup' => $this->ModLang('fielddef_CheckboxGroup')
                                  );
    return $this->_opts;
  }
  
  public function RenderForAdminListing($id, $returnid)
  {
    $value = parent::RenderForAdminListing($id, $returnid);
    $udt = $this->GetOptionValue('render_for_admin_listing_udt', -1);
    
    if( -1 != $udt) 
    {
      $utops = cmsms()->GetUserTagOperations();
      
      if( $utops->UserTagExists($udt) )
      {
        $params = array(
                          'returnid' => $returnid,
                          'id' => $id,
                          'value' => $value,
                        );
                                   
        return $utops->CallUserTag($udt, $params);
      }
    }
    
    return $value;
  }
  
	public function CallUDT($udt)
	{
    if( -1 == $udt) return array();

    $utops = cmsms()->GetUserTagOperations();
    
    if( $utops->UserTagExists($udt) )
    {
      $params = array();           
      return $utops->CallUserTag($udt, $params);
    }
    
    return array();
	}
  
  public function Validate(&$errors) 
  {
    $errors = parent::Validate($errors);
       
    $udt = $this->GetOptionValue('validation_udt', -1);
    
    if( -1 != $udt)
    {
      $utops = cmsms()->GetUserTagOperations();
      
      if( $utops->UserTagExists($udt) )
      {
        $value = $this->GetValue();
        
        $params = array(
                          'value' => $value,
                          'errors' => $errors
                        );
                        
        $errors = $utops->CallUserTag($udt, $params);
      }
    }
       
  }  
}
?>