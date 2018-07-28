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
class lisefd_ContentPages extends LISEFielddefBase
{
	private $_lise;

	public function __construct(&$db_info) 
	{	
		parent::__construct($db_info);
		
		$this->SetFriendlyType($this->ModLang('fielddef_'.$this->GetType()));
		
		$this->_lise = cmsms()->GetModuleInstance(LISE);
	}
	
	public function RenderInput($id, $returnid)
	{
		$type = $this->GetOptionValue('subtype', 'Dropdown');
		$obj = LISEFielddefOperations::LoadFielddefByType($type);
		
		if(is_object($obj))
			return $obj->RenderInput($id, $returnid);
			
		return false;
	}
	
	public function RenderForAdminListing($id, $returnid)
	{
		$manager = cmsms()->GetHierarchyManager();
		$id_list = $this->GetValue(parent::TYPE_ARRAY);
		$use_name = get_site_preference('listcontent_showtitle',true);
		
		$output = array();
		foreach($id_list as $oneid) {
		
			$node = $manager->find_by_tag('id', $oneid);
			
			if($node) {
				$content = $node->getContent(FALSE, FALSE, FALSE);
			
				if($content) {
					
					$txt = $use_name ? $content->Name() : $content->MenuText();
					$output[] = $txt;
				}
			}
		}
		
		return implode(', ', $output);
	}	
	
	public function GetOptions()
	{
		$contentops = cmsms()->GetContentOperations();
				
		$result = array();
		$userid = get_userid();
		$type = $this->GetOptionValue('subtype', 'Dropdown');
		$show_all = $this->GetOptionValue('showall') ? true : false;		
		$use_name = get_site_preference('listcontent_showtitle',true);
		$allcontent = $contentops->GetAllContent(false);
		
		if ($allcontent !== FALSE && count($allcontent) > 0) {
		  
			if($type == 'Dropdown' || $type == 'RadioGroup')
				$result[-1] = lang('none');
			  
			foreach ($allcontent as $one) {
			
				// Check if object is valid
				if(!is_object($one)) 
					continue;
					
				// If it doesn't have a valid link...
				// don't include it.
				if(!$one->HasUsableLink())
					continue;
					
				// If we have a valid userid... only include pages where this user
				// has write access... or is an admin user... or has appropriate permission.
				if(!$show_all && !check_permission($userid,'Manage All Content') && !check_authorship($userid, $one->Id()))
					continue;
								
				// Don't include content types that do not want children either...
				if (!$one->WantsChildren()) 
					continue;
				
				// Else append to array.
				$txt = $use_name ? $one->Name() : $one->MenuText();
				$result[$one->Id()] = $one->Hierarchy() . '. - ' . $txt;
			}
		}

		return $result;
	}

	public function SubTypes()
	{
        return array(
            'Dropdown' => $this->_lise->ModLang('fielddef_Dropdown'),
            'MultiSelect' => $this->_lise->ModLang('fielddef_MultiSelect'),
            'RadioGroup' => $this->_lise->ModLang('fielddef_RadioGroup'),
            'CheckboxGroup' => $this->_lise->ModLang('fielddef_CheckboxGroup')
        );
	}
	
	public function Separator()
	{
		return $this->GetOptionValue('separator');	
	}	

} // end of class
?>