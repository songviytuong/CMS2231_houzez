<?php
#-------------------------------------------------------------------------
# LISE - List It Special Edition
# Version 1.2.2
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
#	- OnItemLoad(LISE &$mod)
#	- OnItemSave(LISE &$mod)
#	- OnItemDelete(LISE &$mod)
#	- ItemSavePreProcess(Array &$errors, Array &$params) 
#	- ItemSavePostProcess(Array &$errors, Array &$params)
#
#-------------------------------------------------------------------------
class LISEEventHandlerBase
{
	#---------------------
	# Attributes
	#---------------------

	private $_field;
	
	#---------------------
	# Magic methods
	#---------------------		
	
	public function __construct(LISEFielddefBase &$field)
	{
		$this->_field	 	= $field;
	}
	
	public function __call($name, $args)
	{
		if(method_exists($this->_field, $name))
			return call_user_func_array(array($this->_field, $name), $args);
	
		return FALSE;
	}

	#---------------------
	# Overwritable events
	#---------------------		

	/**
	 * LISE Field Database Save method
	 *
	 * @return void
	 */	
	public function OnItemSave(LISE &$mod)
	{
		$db = cmsms()->GetDb();
	
		$query  = 'DELETE FROM ' . cms_db_prefix() . 'module_' . $mod->_GetModuleAlias() . '_fieldval WHERE item_id = ? AND fielddef_id = ?';
		$result = $db->Execute($query, array($this->GetParentItem()->item_id, $this->GetId()));
			
		if (!$result)
			//die('FATAL SQL ERROR: ' . $db->ErrorMsg() . '<br/>QUERY: ' . $db->sql);
      throw new \LISE\Exception($db->ErrorNo() . ' - ' . $db->ErrorMsg() . ' - Query: ' . $db->sql, \LISE\Error::DISCRETE_DB ); 
	
		$query  = 'INSERT INTO ' . cms_db_prefix() . 'module_' . $mod->_GetModuleAlias() . '_fieldval (item_id, fielddef_id, value_index, value) VALUES (?,?,?,?)';
		$index = 0;
		
		foreach($this->GetValue() as $one_val) {
		
			if(!$one_val)
				continue;
		
			$result = $db->Execute($query, array($this->GetParentItem()->item_id, $this->GetId(), $index, $one_val));

			if (!$result)
				//die('FATAL SQL ERROR: ' . $db->ErrorMsg() . '<br/>QUERY: ' . $db->sql);
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
	
		$input_arr = array();
		while($dbr && !$dbr->EOF) {
		
			if(!is_null($dbr->fields['data'])) {
			
				$this->SetValue(unserialize($dbr->fields['data']));
				return;
			}
		
			$input_arr[$dbr->fields['value_index']] = $dbr->fields['value'];
			$dbr->MoveNext();
		}
		
		if($dbr) 
			$dbr->Close();			
			
		$this->SetValue($input_arr); // <- Always set array, regardless of contents, check if this can fail.	
	}	

	/**
	 * Executed in edit_item action. Just before database save process is about to take place.
	 *
	 * @return void
	 */	
	public function ItemSavePreProcess(&$errors, &$params) 
	{
		$this->_field->Validate($errors);
	}	

	#---------------------
	# Utility methods
	#---------------------	

	protected function GetField()
	{
		return $this->_field;
	}

} // end of class

?>	