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

class LISEFielddefArray extends ArrayObject
{ 
	#---------------------
	# Variables
	#---------------------	
	
	private $_parent_item;

	#---------------------
	# Magic methods
	#---------------------	
	
    public function __construct($array) 
	{
        foreach($array as $key => $value) {
		
			$value->SetParentArray($this);
            $this->offsetSet($key, $value);
        }	
	}
	
	public function __toString()
	{
		return "Array";
	}	
	
	#---------------------
	# Array Object methods
	#---------------------		
	
	public function offsetSet($key, $value)
	{
		if(!$value instanceof LISEFielddefBase)
			die('Not a LISE Fielddef Object'); // <- Put mention to admin log instead of killing script and ignore value.
			
		parent::offsetSet($key, $value);
	}

    public function offsetExists($offset) 
	{
		if(parent::offsetExists($offset))
			return true;
			
		foreach($this as $field) {
		
			if(is_object($field))
				if($field->GetAlias() == $offset)
					return true;
		}
		
		return FALSE;
    }
	
    public function offsetGet($offset) 
	{
		if(parent::offsetExists($offset)) {
			
			$obj = parent::offsetGet($offset);
			
			if(!cmsms()->is_frontend_request()) {
			
				$smarty = cmsms()->GetSmarty();
				$smarty->assign('fielddef', $obj);
			}
						
			return $obj;
		}
			
		foreach($this as $field) {
		
			if(is_object($field))
				if($field->GetAlias() == $offset) {
					
					if(!cmsms()->is_frontend_request()) {
					
						$smarty = cmsms()->GetSmarty();	
						$smarty->assign('fielddef', $field);
					}
					
					return parent::offsetGet($field->GetId());	
				}
		}
		
		return null;
    }

	#---------------------
	# Class methods
	#---------------------		

	public final function GetParentItem() {
	
		if(isset($this->_parent_item))
			return $this->_parent_item;
		
		return FALSE;
	}

	public final function SetParentItem(&$obj) {
	
		$this->_parent_item = $obj;
	}		
	
} // end of class

?>