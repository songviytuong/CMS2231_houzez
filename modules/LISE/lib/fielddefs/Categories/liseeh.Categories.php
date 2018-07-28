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
class liseeh_Categories extends LISEEventHandlerBase
{
	#---------------------
	# Magic methods
	#---------------------		
	
	public function __construct(LISEFielddefBase &$field)
	{
		parent::__construct($field);
	}
	
	#---------------------
	# Database methods
	#---------------------	
	
	/**
	 * LISE Field Database Save method
	 *
	 * @package LISE
	 * @since 1.0
	 * @return void
	 */	
	public function OnItemSave(LISE $mod)
	{
		$db = cmsms()->GetDb();
	
		$query  = 'DELETE FROM ' . cms_db_prefix() . 'module_' . $mod->_GetModuleAlias() . '_item_categories WHERE item_id = ?';
		$result = $db->Execute($query, array($this->GetParentItem()->item_id));

		$query  = 'INSERT INTO ' . cms_db_prefix() . 'module_' . $mod->_GetModuleAlias() . '_item_categories (item_id, category_id) VALUES (?,?)';

		if(count($this->GetValue())) {
		
			foreach ($this->GetValue() as $category_id)
      {
        $category_id = empty($category_id) ? -1 : $category_id;
				$result = $db->Execute($query, array($this->GetParentItem()->item_id, $category_id));

      if(!$result) 
        throw new \LISE\Exception($db->ErrorNo() . ' - ' . $db->ErrorMsg() . ' - Query: ' . $db->sql, \LISE\Error::DISCRETE_DB );
			}
		}
	}
	
	/**
	 * LISE Field Database Load method
	 *
	 * @package LISE
	 * @since 1.0
	 * @return void
	 */		
	public function OnItemLoad(LISE &$mod)
	{
		$db = cmsms()->GetDb();
	
		$query = 'SELECT B.category_id FROM ' . cms_db_prefix() . 'module_' . $mod->_GetModuleAlias() . '_category B 
					LEFT JOIN ' . cms_db_prefix() . 'module_' . $mod->_GetModuleAlias() . '_item_categories IB 
					ON B.category_id = IB.category_id 
					WHERE IB.item_id = ? 
					AND B.active = 1';			
		
		$this->SetValue($db->GetCol($query, array($this->GetParentItem()->item_id)));
	}	
	
} // end of class

?>	