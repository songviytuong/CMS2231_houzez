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
class LISEConfig implements ArrayAccess
{
	#---------------------
	# Attributes
	#---------------------	
 
	private $_data = array();
	private $_CMSMS_CFG;

	#---------------------
	# Magic methods
	#--------------------- 	
	
	public function __construct(LISE $mod) 
	{
    $this->_CMSMS_CFG = \cmsms()->GetConfig();
    $this->_data['module_path'] = $mod->GetModulePath();
    $this->_data['LISE_instance_name'] = $mod->GetName();
    
    # for backward compatibility
    $this->_data['module_alias'] = strtolower( $this->_data['LISE_instance_name'] );
    $this->_data['item_query_class'] = 'LISEItemQuery';
    $this->_data['category_query_class'] = 'LISECategoryQuery';
    $this->_data['archive_query_class'] = 'LISEArchiveQuery';       
    
    $fn = cms_join_path($this->_data['module_path'], 'data', 'cfg.inc');
    $cfg = array();
    
    if( is_readable($fn) )
    {
      include($fn);
      
      if( isset($cfg) )
      {
        foreach($cfg as $key => $value) 
        {
          $this->_data[$key] = $value;
        }
      }
    }    
    
    # the following is deprecated
    # kept for compatibility purposes with very old LI2 -> LISE conversions
    # scheduled for removal
  
		$lise_config = array();
		$fn = cms_join_path($this->_data['module_path'], LISE_CONFIG_FILE);
		
    if(is_readable($fn))
    {
			include($fn);
      
			if( isset($lise_config) )
      {
				foreach($lise_config as $key => $value) 
        {
					$this->_data[$key] = $value;
				}
			}
		}    
	}
  
  /**
   * Get a data by key
   *
   * @param string The key data to retrieve
   *
   * @access public
   * @return mixed|null
   */
  public function __get ($key) 
  {
    if($this->_CMSMS_CFG->offsetExists($key)) return $this->_CMSMS_CFG[$key];
    return $this->_data[$key];
  }

  public function __set($key, $value) 
  {
    throw new \LISE\Exception('Read Only');
  }

  public function offsetExists($key) 
  {
    return ( isset($this->_data[$key]) || $this->_CMSMS_CFG->offsetExists($key) );
  }

   public function offsetGet($key) 
   {
     if($this->_CMSMS_CFG->offsetExists($key)) return $this->_CMSMS_CFG[$key];
     
      if(isset($this->_data[$key])) 
      {
        $ret = $this->_data[$key];
      }
      else
      {
        $ret = NULL;
      }
    
    return $ret;
   }

   public function offsetSet($key, $value) 
   {
     throw new \LISE\Exception(\LISE\Error::READ_ONLY_CFG);
   }

   public function offsetUnset($key) 
   {
     throw new \LISE\Exception(\LISE\Error::READ_ONLY_CFG);
   }
   
   public function get($key)
  {
    if($this->_CMSMS_CFG->offsetExists($key)) return $this->_CMSMS_CFG[$key];
    
    if( $this->exists($key) )
    {
      return $this->_data[$key];
    }
  }

  public function set($key, $value)
  {
    throw new \LISE\Exception(\LISE\Error::READ_ONLY_CFG);
  }

  public function erase($key)
  {
    throw new \LISE\Exception(\LISE\Error::READ_ONLY_CFG);
  }
} // end of class
?>