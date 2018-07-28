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
class LISEItem
{
	#---------------------
	# Attributes
	#---------------------

	//public $id;
	public $item_id; // deprecated
	public $alias;
  public $title;
	public $url;
	public $position;
	public $active;
	public $create_time;
	public $modified_time;
	public $start_time;
	public $end_time;
	public $owner;	
	
	public $key1;
	public $key2;
	public $key3;

	public $fielddefs;
	
	static public $mandatory = array('title');
		
	#---------------------
	# Magic methods
	#---------------------		
	
	public function __construct() 
	{
		$this->item_id = null;
		$this->alias = null;
		$this->title = '';
		$this->position = -1;
		$this->active = 1;
		$this->create_time = '';
		$this->modified_time = '';
		$this->start_time = '';
		$this->end_time = '';
    $this->owner = null;
		$this->url = null;
		
		$this->key1 = null;
		$this->key2 = null;
		$this->key3 = null;
    
		
		$this->fielddefs = new LISEFielddefArray(array());
	}
	
	public function __clone()
	{
		$this->fielddefs->SetParentItem($this);		
	}
	
	public function __get($key)
	{
		if(isset($this->fielddefs[$key]))
    {
      $value = $this->fielddefs[$key]->GetValue();
           
			return $value;
    }
	}
	
	public function __set($key, $value)
	{
		if(isset($this->fielddefs[$key])) {
		
			$this->fielddefs[$key]->SetValue($value);
		}
		else {
		
			$this->$key = $value;
		}
	}	

	public function __isset($key)
	{
		if(isset($this->fielddefs[$key]) && $this->fielddefs[$key]->HasValue())
			return true;
			
		return FALSE;
	}	
	
	public function __toString()
	{
		return (string)$this->title;
	}	
	
	#---------------------
	# Utility methods
	#---------------------	
	
	// Delete this awful method. Used only by importer.
	public function SetPropertyValue($property, $value)
	{
		if(property_exists($this, $property)) {  // <- For internal properties
		
			if(is_array($value)) {
				$this->$property = $value[0];
			}
			else {
				$this->$property = $value; 
			}
		} 
		elseif(isset($this->fielddefs[$property])) { // <- For field definitions
		
			$this->$property = (array)$value;
		}
		else { // Anything else.
		
			$this->$property = $value; 
		}
	}
	
} // end of class

?>