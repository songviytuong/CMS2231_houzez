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
class liseeh_FileUpload extends LISEEventHandlerBase
{
	#---------------------
	# Variables
	#---------------------	

	private $_data;

	#---------------------
	# Magic methods
	#---------------------		
	
	public function __construct(LISEFielddefBase &$field)
	{
		parent::__construct($field);
	}
	
	#---------------------
	# Overwritable events
	#---------------------	
	
	public function OnItemDelete(LISE &$mod)
	{
		// Delete file
		$path = cms_join_path($this->GetImagePath(), $this->GetValue());
		@unlink($path);		
	}
	
	public function ItemSavePreProcess(&$errors, &$params) 
	{			
		// Check if we need delete
		if (isset($params['delete_customfield'][$this->GetId()])) {
				
			if($params['delete_customfield'][$this->GetId()] == 'delete') {
			
				// Delete file
				$path = cms_join_path($this->GetImagePath(), $this->GetValue());
				@unlink($path);
				
				// Reset value
				$this->SetValue();
			}
		}
		else // Apply new value
    {
			// Fill _data from $_FILES
      if( isset($_FILES['m1_customfield']) )
      {
        //$id is statically part of key, not ideal.
        $files = self::_diverse_array($_FILES['m1_customfield']);
      }

      if(isset($files[$this->GetId()]))
        $this->_data = $files[$this->GetId()]; // <- My assumption is that $_FILES contains correct structure and therefore array is complete. Am i wrong? 1 + 1 = 2!

      // Check that _data is valid
      if(isset($this->_data) && $this->_data['error'] === 0) 
      {  
        // Validate errors
        if(strpos($this->GetOptionValue('allowed'), lisefd_FileUpload::_ext($this->_data['name'])) === FALSE) 
        {
          $errors[] = $this->ModLang('error_bad_extension') . ' (' . $this->GetName() . ')';
        }        

				
				// Set Value from _data
				if(empty($errors)) 
        {
					$this->SetValue($this->_data['name']);
				}			
			}
		}
						
		parent::ItemSavePreProcess($errors, $params);
	}	
	
	public function ItemSavePostProcess(&$errors, &$params) 
	{
		// Move file to correct place, nothing else.
		if(isset($this->_data) && $this->_data['error'] === 0) {
		
			// Get file path
			$path = $this->GetImagePath();
			
			// Assure directory exists
			if(!is_dir($path))
				@mkdir($path, 0777, true);

			// Merge filename into path
			$path = cms_join_path($path, $this->GetValue());
				
			// Execute move.
			if(!move_uploaded_file($this->_data['tmp_name'], $path)) {
			
				$errors[] = $this->ModLang('error_file_permissions');
			}
		}
	}

	#---------------------
	# Private methods
	#---------------------	
	
	private static function _diverse_array($vector) 
  {
		$result = array();
    
    if( is_array($vector) )
    {
		  foreach($vector as $key1 => $value1)
      {
			  foreach($value1 as $key2 => $value2) 
        {
				  $result[$key2][$key1] = $value2;
			  }
		  }
    }
    
		return $result;
	} 	
	
} // end of class

?>	