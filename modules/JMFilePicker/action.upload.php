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
$smarty = cmsms()->GetSmarty();

//input name
if(!isset($params['name']) || $params['name']=='')
{
	return;
}
else
{
	$name = trim($params['name']);
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

// dir stuff
$current_dir = $config['uploads_path'] . DIRECTORY_SEPARATOR;
$current_url  = $config['uploads_url'] . '/';

if($params['start_dir'] != '')
{
	$current_dir .= str_replace('/', DIRECTORY_SEPARATOR, $params['start_dir']) . DIRECTORY_SEPARATOR;
	$current_url .= $params['start_dir'] . '/';
}

$upload = $params['upload'] && ($this->GetPreference('show_filemanagement') || $this->_isAdmin);

if(file_exists($current_dir) && $upload)
{
	if (isset($params['upload_file'])) // do upload
	{
		if (isset($_FILES[$id.'newfile']))
		{
			//CHeck for uploaded file
			if ($_FILES[$id.'newfile']['name'] != '')
			{
				// get file type
				$filetype = jmfp_utils::GetFileType($_FILES[$id.'newfile']['tmp_name'],$this->GetPreference('use_mimetype',false));
				if(!$filetype || $filetype == 'tmp') {
					if($this->GetPreference('use_mimetype',false))
					{
						$filetype = $_FILES[$id.'newfile']['file_type'];
					}
					else
					{
						$filetype = jmfp_utils::GetFileType($_FILES[$id.'newfile']['name']);
					}
				}
				
				//check filename
				if (jmfp_utils::ContainsIllegalChars($_FILES[$id.'newfile']['name']))
				{
					$errormessage = $this->Lang('contains_illegalchars', $_FILES[$id.'newfile']['name']);
				}
				else if (($_FILES[$id.'newfile']['size']>$config['max_upload_size'])
					|| ($_FILES[$id.'newfile']['error'] == 1))
				{
					$errormessage = $this->Lang('file_too_big', $_FILES[$id.'newfile']['name']);
				}
				else if($params['media_type'] == 'image' && !in_array(str_replace('image/','',$filetype),$params['file_extensions']))
				{
					$errormessage = $this->Lang('no_imagefile',$_FILES[$id.'newfile']['name'] . ' ('.$filetype.')');
				}
				else if($params['media_type'] != 'image' && !empty($params['file_extensions']) && !in_array(strtolower(substr($_FILES[$id.'newfile']['name'], strrpos($_FILES[$id.'newfile']['name'], '.') + 1)),$params['file_extensions']))
				{
					$errormessage = $this->Lang('filetype_notallowed', $filetype);
				}
				else
				{
					$filename = $current_dir.jmfp_utils::CleanPath($_FILES[$id.'newfile']['name'], false);
					$resize   = $params['force_scaling'];
					if (isset($params['resize_on']))
					{
						$resize = $params['resize_on'];
					}
					if ($resize)
					{
						$width = $params['scaling_width'];
						if(isset($params['resize_x']))
						{
							$width = $params['resize_x'];
						}
						$height = $params['scaling_height'];
						if(isset($params['resize_y']))
						{
							$height = $params['resize_y'];
						}
						$keep_aspectratio = $params['keep_aspect_ratio'];
						if(isset($params['keep_aspectratio']))
						{
							$keep_aspectratio = $params['keep_aspectratio'];
						}
						if (jmfp_utils::HandleFileResizing($_FILES[$id.'newfile']['tmp_name'], $filename, $width, $height, $keep_aspectratio, ($params['allow_upscaling'] && $params['force_upscaling']), 100, false))
						{
							if ($params['create_thumbs'])
							{
								jmfp_utils::CreateThumbnail($filename);
								#$thumbname = $current_dir."thumb_".jmfp_utils::CleanPath($_FILES[$id.'newfile']['name'], false);
								#jmfp_utils::HandleFileResizing($filename,$thumbname,get_site_preference('thumbnail_width',96),get_site_preference('thumbnail_height',96),true,false,60,false);
							}
							$message = $this->Lang('file_uploaded', $_FILES[$id.'newfile']['name']);
							$value   = jmfp_utils::CleanPath($params['start_dir'].'/'.$_FILES[$id.'newfile']['name'],false);
						}
						else
						{
							$errormessage = $this->Lang('upload_failed', $_FILES[$id.'newfile']['name']);
						}
					}
					else
					{
						if (cms_move_uploaded_file($_FILES[$id.'newfile']['tmp_name'], $filename))
						{
							if ($params['create_thumbs'])
							{
								jmfp_utils::CreateThumbnail($filename);
								#$thumbname = $current_dir."thumb_".jmfp_utils::CleanPath($_FILES[$id.'newfile']['name'],false);
								#jmfp_utils::HandleFileResizing($filename,$thumbname,get_site_preference('thumbnail_width',96),get_site_preference('thumbnail_height',96),true,false,60,false);
							}
							$message = $this->Lang('file_uploaded',$_FILES[$id.'newfile']['name']);
							$value   = jmfp_utils::CleanPath($params['start_dir'].'/'.$_FILES[$id.'newfile']['name'],false);
						}
						else
						{
							$errormessage = $this->Lang('upload_failed',$_FILES[$id.'newfile']['name']);
						}
					}
				}
			}
			else
			{
				$errormessage = $this->Lang('no_file_uploaded');
			}
		}
		else
		{
			//This shouldn't happen
			$errormessage = $this->Lang('no_file_uploaded');
		}
	}
	$smarty->assign('jmfp_formstart', $this->CreateFormStart($id, 'upload',
		$returnid, 'post', 'multipart/form-data', false, '',
		array('name'=>$name)));
	
	$smarty->assign('jmfp_allow_scaling', $params['allow_scaling']);
	$smarty->assign('jmfp_success_text', $this->Lang('success'));
	
	$smarty->assign('jmfp_fileupload_text', $this->Lang('fileupload'));
	$smarty->assign('jmfp_fileupload_input', $this->CreateInputFile($id, 'newfile', '', 20));
	$smarty->assign('jmfp_fileupload_submit',$this->CreateInputSubmit($id, 'upload_file', $this->Lang('upload')));

	if ($params['allow_scaling'])
	{
		$smarty->assign('jmfp_allow_upscaling', $params['allow_upscaling']);
		
		$smarty->assign('jmfp_resizeimage_text', $this->Lang('resize_image'));
		$smarty->assign('jmfp_resizeimage_input',
			$this->CreateInputHidden($id,'resize_on',0) .
			$this->CreateInputCheckbox($id, 'resize_on', '1',$params['force_scaling']));
		
		$smarty->assign('jmfp_imagesize_text', $this->Lang('image_size'));
		$smarty->assign('jmfp_imagesize_x_input', $this->CreateInputText($id, 'resize_x', $params['scaling_width'], 4, 4));
		$smarty->assign('jmfp_imagesize_y_input', $this->CreateInputText($id, 'resize_y', $params['scaling_height'], 4, 4));
		
		$smarty->assign('jmfp_keepaspectratio_text', $this->Lang('keep_aspectratio'));
		$smarty->assign('jmfp_keepaspectratio_input',
			$this->CreateInputHidden($id,'keep_aspectratio',0).
			$this->CreateInputCheckbox($id, 'keep_aspectratio', '1',1));
		
		$smarty->assign('jmfp_forceupscaling_text', $this->Lang('force_upscaling'));
		$smarty->assign('jmfp_forceupscaling_input',
			$this->CreateInputHidden($id,'force_upscaling',0).
			$this->CreateInputCheckbox($id, 'force_upscaling', '1',0));
	}
	$smarty->assign('jmfp_formend', $this->CreateFormEnd());
}
else
{
	$errormessage = $this->Lang('dir_notfound',$current_dir);
}

if(isset($errormessage))
{
	$smarty->assign('jmfp_errormessage', $errormessage);
}
if(isset($message))
{
	$smarty->assign('jmfp_message', $message);
}

$smarty->assign('jmfp_inputid', $_id.$name);
$smarty->assign('jmfp_cssid', $_id.munge_string_to_url($name));
$smarty->assign('jmfp_media_type', $params['media_type']);
$smarty->assign('jmfp_error_text', $this->Lang('error'));

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

echo $this->ProcessTemplate('upload.tpl');

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