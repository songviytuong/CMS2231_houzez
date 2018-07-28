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


class lisefd_FileUpload extends LISEFielddefBase
{
	private static $_img_types = array('gif', 'jpg', 'jpeg', 'png');

	public function __construct(&$db_info) 
	{	
		parent::__construct($db_info);
		
		$this->SetFriendlyType($this->ModLang('fielddef_'.$this->GetType()));
	}
	
	#---------------------
	# Fieldbase methods
	#---------------------	

	public function RenderForAdminListing($id, $returnid)
	{
		// Check if we have value.
		if(!$this->HasValue())
			return;
	
		// Check if we need image and if extension of filename is actually image.
		if(!$this->GetOptionValue('image') || !in_array(self::_ext($this->GetValue()), self::$_img_types))
			return $this->GetValue();

		// Check if CGSmartImage module is installed.
		$cgsi = cmsms()->GetModuleInstance('CGSmartImage');
		if(!is_object($cgsi))
			return $this->GetValue();
					
		// Check if our source file is readable.
        $path = cms_join_path($this->GetImagePath(), $this->GetValue());
		if(!is_readable($path))
			return $this->GetValue();
		
        $href = $this->GetImagePath(true) .'/'. $this->GetValue();
	
		$params['src'] = $href;
		$params['filter_croptofit'] = '48,48';
		$params['notag'] = true;
		$params['noembed'] = true;
	
		$output = cgsi_utils::process_image($params);
		
		$url = $output['output'];
		
		return '<a href="'.$href.'" class="cbox thumb"><img src="'.$url.'" width="48" height="48" /></a>';		
	}
  
  public function FrontEndRender( $params = array() )
  {
    if( empty($this->view) )
    {
      $smarty = cmsms()->GetSmarty();
      $smarty->assign('name', $this->name);
      $smarty->assign('value', $this->value);
      $smarty->assign('type', $this->type);
      $smarty->assign('alias', $this->alias);
      $smarty->assign('params', $params);
      $smarty->assign('imagepath', $this->GetImagePath(TRUE) );
      $this->view = $smarty->fetch( 'string:' . $this->GetTemplate() );
    }

    return $this->view;
    
  }	
	
	#---------------------
	# Class methods
	#---------------------		
	
	public function GetImagePath($url = false)
	{
		$config = cmsms()->GetConfig();
		$prefix = $url ? $config['uploads_url'] : $config['uploads_path'];
		$path = cms_join_path($prefix, $this->GetOptionValue('dir'));		
	
		if(strpos($path, '{$item_id}') !== false)			
			$path = str_replace('{$item_id}', $this->GetItemId(), $path);
				
		if(strpos($path, '{$field_id}') !== false)			
			$path = str_replace('{$field_id}', $this->GetId(), $path);
				
		if($url)
			$path = str_replace(DIRECTORY_SEPARATOR, '/', $path);

		return $path;
	}

	#---------------------
	# Private methods
	#---------------------	
	
	public static function _ext($filename)
	{	
		$filename = explode('.', $filename);
		return trim(strtolower(end($filename))); // <- A bit freaky yes, but should cover all possible cases.
	}
	
} // end of class
?>