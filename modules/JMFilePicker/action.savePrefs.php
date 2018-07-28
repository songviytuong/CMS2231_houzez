<?php
#-------------------------------------------------------------------------
# JMFilePicker
# Version 1.0
# (c) 2016 by Fernando Morgado aka Jo Morg <jomorg@cmsmadesimple.org>
# The module's homepage is: http://dev.cmsmadesimple.org/projects/jmfilepicker/
#
# A fork of: GBFilePicker (c) 2010-2012 by Georg Busch
# maintained by Fernando Morgado AKA Jo Morg
# since 2016
#-------------------------------------------------------------------------
# Original Author: Georg Busch <georg.busch@gmx.net>
#-------------------------------------------------------------------------
#
# JMFilePicker is a CMS Made Simple module that enables the web developer to create
# multiple lists throughout a site. It can be duplicated and given friendly
# names for easier client maintenance.
#
#-------------------------------------------------------------------------
#
# CMS - CMS Made Simple is (c) 2010 by Ted Kulp (wishy@cmsmadesimple.org)
# This project's homepage is: http://www.cmsmadesimple.org
#
#-------------------------------------------------------------------------
# BEGIN_LICENSE
#-------------------------------------------------------------------------
# This file is part of JMFilePicker
# JMFilePicker program is free software; you can redistribute it and/or modify
# it under the terms of the GNU General Public License as published by
# the Free Software Foundation; either version 2 of the License, or
# (at your option) any later version.
#
# JMFilePicker program is distributed in the hope that it will be useful,
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

if(!function_exists('cmsms') || !is_object(cmsms())) exit;

if(isset($params['submit'])) {
	
	if(isset($params['thumb_upload_action']))
		$this->SetPreference('thumb_upload_action', $params['thumb_upload_action']);
	
	if(isset($params['thumb_prefix_replacement']))
		$this->SetPreference('thumb_prefix_replacement', $params['thumb_prefix_replacement']);
	
	if(isset($params['restrict_users_diraccess']))
		$this->SetPreference('restrict_users_diraccess', $params['restrict_users_diraccess']);
	
	if(isset($params['show_filemanagement']))
		$this->SetPreference('show_filemanagement', $params['show_filemanagement']);

	if(isset($params['show_thumbfiles']))
		$this->SetPreference('show_thumbfiles', $params['show_thumbfiles']);

	if(isset($params['allow_scaling']))
		$this->SetPreference('allow_scaling', $params['allow_scaling']);

	if(isset($params['scaling_width']))
		$this->SetPreference('scaling_width', $params['scaling_width']);

	if(isset($params['scaling_height']))
		$this->SetPreference('scaling_height', $params['scaling_height']);
	
	if(isset($params['create_thumbs']))
		$this->SetPreference('create_thumbs', $params['create_thumbs']);
	
	if(isset($params['allow_upscaling']))
		$this->SetPreference('force_scaling', $params['force_scaling']);
	
	if(isset($params['force_scaling']))
		$this->SetPreference('allow_upscaling', $params['allow_upscaling']);
	
	if(isset($params['default_admin_theme']))
		$this->SetPreference('default_admin_theme', $params['default_admin_theme']);
	
	if(isset($params['default_frontend_theme']))
		$this->SetPreference('default_frontend_theme', $params['default_frontend_theme']);
	
	if(isset($params['use_mimetype']))
		$this->SetPreference('use_mimetype', $params['use_mimetype']);
	
	if(isset($params['feu_access'])) {
		if(is_array($params['feu_access']))
			$params['feu_access'] = implode(',',$params['feu_access']);
		$this->SetPreference('feu_access', $params['feu_access']);
	}
	
}

if(isset($params['toggle']) && isset($params['display'])) {
	switch($params['toggle']) {
		
		case 'fileoperations':
			if(!$userid = get_userid(false)) {
				if(!session_id()) {
					@session_start();
				}
				$_SESSION['GPFP_fileoperations_display'] = $params['display'];
			}
			else {
				set_preference($userid, 'JMFP_fileoperations_display', intval($params['display']));
			}
			break;
			
		default: break;
	}
}

if(isset($params['ajax']) && jmfp_utils::IsTrue($params['ajax']))
{
	@ob_end_clean();
	@ob_start();
	header("Cache-Control: no-store, no-cache, must-revalidate");
	header("Cache-Control: post-check=0, pre-check=0", false);
	header("Pragma: no-cache");
	if(isset($params['xml']) && jmfp_utils::IsTrue($params['xml'])) 
	{
		header('Content-Type: text/xml');
		echo '<?xml version="1.0" encoding="UTF-8"?>';
		echo '<result><![CDATA[';
	}
	else
	{
		header('Content-type: text/html; charset=utf-8');
	}
	echo '<div class="pagemcontainer"><p class="pagemessage">'.$this->lang('prefs_updated').'</p></div>';
	if(isset($params['xml']) && jmfp_utils::IsTrue($params['xml'])) 
	{
		echo ']]></result>';
	}
	@ob_end_flush();
	exit;
}
$this->Redirect($id, 'defaultadmin', $returnid, array('message' => 'prefs_updated', 'submit' => true));
?>
