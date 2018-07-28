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

class lisefd_JMFilePicker extends LISEFielddefBase
{
  
	public function __construct(&$db_info) 
	{
		parent::__construct($db_info);
		
		$this->SetFriendlyType($this->ModLang('fielddef_' . $this->GetType()));
	}
	
	static public function GetModuleDeps()
	{
		return array('JMFilePicker' => '1.0.1');
	}
	
	public function RenderForAdminListing($id, $returnid)
	{
		if(!$this->HasValue())
			return;
	
		if(!$this->GetOptionValue('image'))
			return $this->GetValue();

		$config = cmsms()->GetConfig();
		
		$_invalid = array('.', '..');
        $href = $config['uploads_url'] . '/' . $this->GetValue();
	
		// Try if we can use CGSmartImage
		$cgsi = cmsms()->GetModuleInstance('CGSmartImage');
		if(is_object($cgsi))
    {
			$params['src'] = $href;
			$params['filter_croptofit'] = '48,48';
			$params['notag'] = true;
			$params['noembed'] = true;
		
			$output = cgsi_utils::process_image($params);
			
			$url = $output['output'];
		}
		// Nope, lets use internal thumbs instead.
		else 
    {
			$url = $config['uploads_url'] . '/JMFilePickerThumbs';	
			$value = explode('/', $this->GetValue()); // <- Static presentation of DIRECTORY_SEPARATOR, wrong but JMFilePicker ain't supporting it!	TODO!!!
			$actual_value = array_pop($value);
			$url .= '/thumb_';
			if(count($value)) {
				
				foreach($_invalid as $one) {
								
					if(in_array($one, $value)) {
					
						$key = array_search($one, $value);
						if($key !== FALSE)
							unset($value[$key]);
					}
				}
				
				$url .= implode("-", $value) . '_';	
			}
			$url .= $actual_value;
		}
		
		return '<a href="'.$href.'" class="cbox thumb"><img src="'.$url.'" width="48" height="48" /></a>';		
	}
	
	public function GetInput($id)
	{
    
		$config = cmsms()->GetConfig();
		$mod = $this->GetModuleInstance();
		
		$JMFilePicker = cmsms()->GetModuleInstance('JMFilePicker');
		if(is_object($JMFilePicker)) {
		
			//$dir = $this->_CompileExtraDir($this->GetOptionValue('dir'), $this->GetItemId(), $this->GetAlias());
			$dir = $this->GetOptionValue('dir');

			//if($dir !== false){
			
			// make dir if not exists
			$path = $config['uploads_path'] . DIRECTORY_SEPARATOR . $dir;
			if(!is_dir($path)){
				@mkdir($path, 0777, true);
			}

			// JMFilePicker "Update dropdown" does not work if id contains "[]", strip it out
			$name = 'customfield['.$this->GetId().']';
			$savename = 'customfield_'.$this->GetId().'_';

			$jmfilepicker = $JMFilePicker->CreateFilePickerInput($JMFilePicker, $id, $savename, $this->GetValue(), array(
				'media_type' => ($this->GetOptionValue('image')?'image':'file'),
				'file_extensions' => $this->GetOptionValue('allowed'),
				'dir' => $dir,
				'upload' => true,
				'exclude_prefix' => $this->GetOptionValue('exclude_prefix'),
				'mode' => ($this->GetOptionValue('filebrowser')?'browser':'dropdown'),
				'create_dirs' => $this->GetOptionValue('create_dirs'),
				'delete' => $this->GetOptionValue('delete'),
				'show_subdirs' => $this->GetOptionValue('show_subdirs')
			));

			$search       = 'name="'.$id.$savename;
			$replace      = 'name="'.$id.$name;
			$jmfilepicker = str_replace($search, $replace, $jmfilepicker);

			return $jmfilepicker;
		}
	}
	
/*	
	private function _CompileExtraDir($path, $item_id = null, $item_alias = null){

		if(strpos($path, '{$item_alias}') !== false){
			if(!isset($item_alias) || strlen($item_alias) == 0)
				return false;
			$path = str_replace('{$item_alias}', $item_alias, $path);
		}
		if(strpos($path, '{$item_id}') !== false){
			if(!isset($item_id) || !is_int($item_id))
				return false;
			$path = str_replace('{$item_id}', $item_id, $path);
		}

		return $path;
	}
*/	
} // end of class
?>