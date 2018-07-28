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

global $CMS_ADMIN_PAGE;
$config = cmsms()->GetConfig();

//input name
if(!isset($params['name']) || $params['name']=='')
{
	return;
}
else
{
	$name = htmlentities(trim($params['name']));
}
if($id == 'cntnt01' && isset($_SESSION['JMFP_id_'.$name]))
{
	$id = $_SESSION['JMFP_id_'.$name];
}

if(!$session_params =& $this->GetInputParams($id,$name))
{
	return;
}

$params = array_merge($params, $session_params);

if($params['mode'] != 'dropdown' || $params['name'] != $name)
{
	return;
}

// check permission
if(isset($CMS_ADMIN_PAGE) && $CMS_ADMIN_PAGE == 1)
{
	check_login();
	if(!$this->CheckPermission('Use JMFilePicker'))
		return;
	$username = $this->_username;
}
else
{
	if( !$feusers = cmsms()->GetModuleInstance('FrontEndUsers' ) )
	{
		return;
	}
	if(!$userid = $feusers->LoggedInId())
	{
		return;
	}
	if(!$groups = $feusers->GetMemberGroupsArray($userid))
	{
		return;
	}
	$access = false;
	foreach($groups as $_group)
	{
		if(in_array($_group['groupid'],$params['feu_access']))
		{
			$access = true;
			break;
		}
	}
	if(!$access)
	{
		return;
	}
	$username = $feusers->GetUserName($userid);
}

// module id
$_id = $id;
if($params['id'] == '')
{
	$_id = '';
}

$ajax = isset($params['ajax']) && jmfp_utils::IsTrue($params['ajax']);
$xml  = $ajax && isset($params['xml']) && jmfp_utils::IsTrue($params['xml']);

if($ajax)
{
	@ob_end_clean();
	@ob_start();
	header("Cache-Control: no-store, no-cache, must-revalidate");
	header("Cache-Control: post-check=0, pre-check=0", false);
	header("Pragma: no-cache");
	if($xml)
	{
		header('Content-Type: text/xml');
		echo '<?xml version="1.0" encoding="UTF-8"?>';
		echo '<result><![CDATA[';
	}
	else
	{
		header('Content-type: text/html; charset=utf-8');
	}
}

echo jmfp_utils::CreateFileDropdown($_id, $name,
	$params['start_dir'],
	isset($params['value']) ? $params['value'] : '',
	$params['exclude_prefix'],
	$params['include_prefix'],
	$params['exclude_sufix'],
	$params['include_sufix'],
	$params['file_extensions'],
	$params['media_type'],
	$params['allow_none'],
	$params['add_txt']);

if($ajax)
{
	if($xml)
	{
		echo ']]></result>';
	}
	@ob_end_flush();
	exit;
}
?>