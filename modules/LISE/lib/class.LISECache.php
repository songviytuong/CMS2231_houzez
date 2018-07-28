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
class LISECache extends ArrayObject
{ 
	#---------------------
	# Variables
	#---------------------	
	
	private $_identifiers;

	#---------------------
	# Magic methods
	#---------------------	
	
    public function __construct($identifiers) 
	{
		$this->_identifiers = $identifiers;
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
		if(!is_object($value))
			throw new \LISE\Exception(__METHOD__ . ": Value type must be object!");
			
		$key = reset($this->_identifiers);
	
		parent::offsetSet($value->$key, $value);
	}

    public function offsetExists($offset) 
	{
		if(parent::offsetExists($offset))
			return true;
			
		return FALSE;
    }
	
    public function offsetGet($offset) 
	{
		if(parent::offsetExists($offset))
			return parent::offsetGet($offset);
			
		return null;
    }

	#---------------------
	# Class methods
	#---------------------		

	public function GetCachedByIdentifier($identifier, $value)
	{
		if(!in_array($identifier, $this->_identifiers))
			throw new \LISE\Exception(__METHOD__ . ": Illegal identifier: $identifier!");
			
		foreach($this as $cached) {
		
			if($cached->$identifier == $value) {
			
				return $cached;			
			}
		}
		
		return null;
	}
	
} // end of class

?>