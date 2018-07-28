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
class jmfp_utils
{
  public static final function isCMS2()
  {
    return (bool)(version_compare(CMS_VERSION, '2.0') > -1);
  } 
  
  	/**
	 * Gets the file type of a file.
	 *
	 * @since 1.0
	 * @access public
	 *
	 * @param string $file - the path to a file
	 * @param string $use_mime - set to true to detect file type by mime type
	 *
	 * @return string - the mime-type or file extension
	 */
	public static final function GetFileType($file, $use_mime = '')
	{
		$filetype = '';
		if($use_mime == '')
		{
		  $jmfp = cmsms()->GetModuleInstance('JMFilePicker');
		  $use_mime = $jmfp->GetPreference('use_mimetype',false);
		}
		if($use_mime)
		{
			if (version_compare(PHP_VERSION, '5.3.0') >= 0 && function_exists('finfo_open'))
			{
				$finfo    = finfo_open(FILEINFO_MIME_TYPE);
				$filetype = finfo_file($finfo, $file);
				finfo_close($finfo);
			}
			else if(function_exists('mime_content_type'))
				$filetype = mime_content_type($file);
		}
		else
		{
			$fileinfo = pathinfo($file);
			if(isset($fileinfo['extension']))
				$filetype = $fileinfo['extension'];
		}
		return strtolower($filetype);
	}

	
	/**
	 * Return an array containing a list of files in a directory.
	 * Performs a non recursive search.
	 *
	 * @since 1.0
	 * @access public
	 *
	 * @param string $dir - the directory to list the files of (may be relative to uploads dir or absolute path)
	 * @param array|string $excl_prefix - fileprefixes to exclude (array('foo','bar',...) or csv)
	 * @param array|string $incl_prefix - fileprefixes to include (array('foo','bar',...) or csv)
	 * @param array|string $excl_sufix - filesufixes to exclude (array('foo','bar',...) or csv)
	 * @param array|string $incl_sufix - filesufixes to include (array('foo','bar',...) or csv)
	 * @param array|string $file_ext - filesufixes to include (array('foo','bar',...) or csv)
	 * @param string $media_type - file or image
	 * @param boolean $excl_dirs - set to true to exclude directories
	 * @param boolean $show_thumbfiles
	 * @param boolean $create_thumbs = true
	 *
	 * @return array
	 * @deprecated
	 */
	public static final function &GetFiles($dir = '', $excl_prefix = '', $incl_prefix = '', $excl_sufix = '',
		$incl_sufix = '', $file_ext = '', $media_type = 'image', $excl_dirs = false, $show_thumbfiles = false, $create_thumbs = true)
	{
		$config = cmsms()->GetConfig();
		$files  = Array();
		$dir    = self::CleanPath($dir);
		if(!is_readable($dir))
		{
			return $files; // ToDo: display error message?
		}
		$url    = self::CleanURL($dir);
		
		if(!file_exists($dir) || !is_dir($dir))
		{
			return $files;
		}
		
		if(!is_array($excl_prefix))
		{
			$excl_prefix = self::CleanArray(explode(',',$excl_prefix));
		}
		
		if(!is_array($incl_prefix))
		{
			$incl_prefix = self::CleanArray(explode(',',$incl_prefix));
		}
		
		if(!is_array($excl_sufix))
		{
			$excl_sufix = self::CleanArray(explode(',',$excl_sufix));
		}
		
		if(!is_array($incl_sufix))
		{
			$incl_sufix = self::CleanArray(explode(',',$incl_sufix));
		}
		
		if(!is_array($file_ext))
		{
			$file_ext = self::CleanArray(explode(',',$file_ext));
		}
		
		$_file_ext = array('jpg','jpeg','gif','png');
		if($media_type == 'image')
		{
			$file_ext = self::CleanArray(array_intersect($_file_ext, $file_ext));
			if(empty($file_ext))
			{
				$file_ext = $_file_ext;
			}
		}
		
		$excl_prefix = self::CleanArray(array_diff($excl_prefix, $incl_prefix));
		$excl_sufix  = self::CleanArray(array_diff($excl_sufix, $incl_sufix));
		
		$d = dir($dir);
		while ($entry = $d->read())
		{
			if ($entry[0] == '.' || (is_dir($dir.$entry) && $excl_dirs) || !is_readable($dir.$entry))
			{
				continue; // ToDo: how to display files/dirs with limited permission?
			}
			
			$skip        = false;
			$incl_thumbs = false;
			
			$file         = new stdClass();
			$file->is_dir = is_dir($dir.$entry);
			$fileinfo     = pathinfo($dir.$entry);
			foreach($fileinfo as $k=>$v)
			{
				$file->$k = $v;
			}
			if(!$file->is_dir)
			{
				foreach($excl_prefix as $str)
				{
					if(startswith($file->filename,$str))
					{
						$skip = true;
						break;
					}
				}
				if($skip) continue;
				
				foreach($incl_prefix as $str)
				{
					if(startswith($str,'thumb_'))
					{
						$incl_thumbs = true;
					}
					if(!startswith($file->filename,$str))
					{
						$skip = true;
						break;
					}
				}
				if($skip) continue;
				
				foreach($excl_sufix as $str)
				{
					if(endswith($file->filename,$str))
					{
						$skip = true;
						break;
					}
				}
				if($skip) continue;
				
				foreach($incl_sufix as $str)
				{
					if(!endswith($file->filename,$str))
					{
						$skip = true;
						break;
					}
				}
				if($skip)
					continue;
			}
			
			if(startswith($entry,'thumb_') && !$show_thumbfiles && !$incl_thumbs)
			{
				continue;
			}
			
			$filetype = self::GetFileType($dir.$entry);
			if (!$file->is_dir && $media_type == 'image' && !in_array(str_replace('image/','',$filetype),$file_ext))
			{
				continue;
			}
			else if(!$file->is_dir && $media_type != 'image' && !in_array($file->extension,$file_ext) && !empty($file_ext))
			{
				continue;
			}
			
			$file->fullurl      = $url.$entry;
			$file->relurl       = trim(str_replace($config['uploads_url'],'',$file->fullurl),'/');
			$file->id           = munge_string_to_url($file->relurl);
			$file->last_modifed = filemtime($dir.$entry);
			
			if (!$file->is_dir)
			{
				$file->is_image = false;
				if (!$file->is_dir && in_array(str_replace('image/','',$filetype),array('jpg','jpeg','gif','png')))
				{
					$file->is_image = true;
				}
				$file->filetype = $filetype;
				if($file->is_image)
				{
					$file->thumbnail = '';
					$file->thumburl  = '';
					if ($show_thumbfiles || $incl_thumbs)
					{
						$file->thumbnail = self::GetThumbnail($dir.str_replace('thumb_', '', $entry), $create_thumbs);
						$file->thumburl  = self::GetThumbnail($dir.str_replace('thumb_', '', $entry), $create_thumbs,true);
					}
					else
					{
						$file->thumbnail = self::GetThumbnail($dir.$entry, $create_thumbs);
						$file->thumburl  = self::GetThumbnail($dir.$entry, $create_thumbs,true);
					}
					
					$file->imgsize = '';
					$imgsize = @getimagesize($dir.$entry);
					if ($imgsize)
					{
						$file->imgsize = $imgsize[0] . ' x ' . $imgsize[1];
					}
					else
					{
						$file->imgsize = '&nbsp;';
					}
				}
				$file->filesize = '';
				$info = @stat($dir.$entry);
				if ($info)
				{
					$file->filesize = $info['size'];
				}
				$file->fileicon = self::GetFileIcon($file->extension,false,true);
			}
			else
			{
				$file->fileicon = self::GetFileIcon('',true);
			}
			$files[] = $file;
		}
		$d->close();
		usort($files, array('jmfp_utils', 'SortFiles'));
		return $files;
	}

	/**
	 * Replaces all multiple DIRECTORY_SEPARATOR, dots and (multiple) slashes with one single DIRECTORY_SEPARATOR to make a clean secure path parameter
	 *
	 * @since 1.0
	 * @access public
	 *
	 * @param string $path - the path to clean
	 * @param string $full_path - true to prepend uploads path on return, false to return only the cleaned $path
	 *
	 * @return string - the clean path
	 */
	public static final function CleanPath($path, $full_path = true)
	{
		$config = cmsms()->GetConfig();
		$path = trim(str_replace(array($config['uploads_path'],$config['uploads_url']), '', $path),'/'.DIRECTORY_SEPARATOR);
		$path = str_replace(DIRECTORY_SEPARATOR,'/',$path);
		$path = trim(preg_replace('/(\/\.)|(\.\/)|(\/?\.\.\/?)/','/',$path),'/');
		if($full_path)
		{
			$path = preg_replace('/[\\/]+/',DIRECTORY_SEPARATOR, '/' . $path . '/');
			$path = $config['uploads_path'] . $path;
			return $path;
		}
		return trim(preg_replace('/[\\/]+/',DIRECTORY_SEPARATOR, $path) , DIRECTORY_SEPARATOR);
	}
	
	/**
	 * Create a dropdown form element containing a list of files that match certain conditions
	 *
	 * @since 1.0
	 * @access public
	 *
	 * @param string $id - the id of the moduleinstance that creates the filepicker input
	 * @param string $name - the name of the input field
	 * @param string $dir - the directory to list the files of (may be relative to uploads dir or absolute path)
	 * @param string $selected - the preselected value
	 * @param array|string $excl_prefix - fileprefixes to exclude (array('foo','bar',...) or csv)
	 * @param array|string $incl_prefix - fileprefixes to include (array('foo','bar',...) or csv)
	 * @param array|string $excl_sufix - filesufixes to exclude (array('foo','bar',...) or csv)
	 * @param array|string $incl_sufix - filesufixes to include (array('foo','bar',...) or csv)
	 * @param array|string $file_ext - filesufixes to include (array('foo','bar',...) or csv)
	 * @param string $media_type - file or image
	 * @param boolean $allow_none - set to false to hide the option 'none'
	 * @param string $add_txt - any additional text that will be added to the html input when tag is rendered
	 *
	 * @return string - the HTML output of a select element with options
	 */
	public static final function CreateFileDropdown(
                                                    $id,
                                                    $name,
                                                    $dir = '',
                                                    $selected = '',
                                                    $excl_prefix = '',
                                                    $incl_prefix = '',
                                                    $excl_sufix = '',
                                                    $incl_sufix = '',
                                                    $file_ext = '',
                                                    $media_type = '',
                                                    $allow_none = true,
                                                    $add_txt = ''
                                                  )
	{
	  $jmfp = cmsms()->GetModuleInstance('JMFilePicker');
	  
		$files =& $jmfp->GetInputFiles($id, $name, $dir);
		
		if(empty($files) && !$allow_none)
			return $jmfp->lang('dir_empty');
		
		$dropdown = '<select class="JMFP_input JMFP_dropdown JMFP_'.$media_type.'" name="'.$id.$name.'" id="'.$id.munge_string_to_url($name).'"';
		if($add_txt != '')
			$dropdown .= ' '.$add_txt;
		
		$dropdown .= '>';
		if( $allow_none )
		{
			$dropdown .= '<option value=""';
			if($selected == '')
				$dropdown .= ' selected="selected"';
			
			$dropdown .= ' thumbnail="">--- '.lang('none').' ---</option>';
		}
		foreach( $files as $file )
		{
			$dropdown .= '<option value="'.$file->relurl.'"';
			if($file->relurl == $selected)
				$dropdown .= ' selected="selected"';
			
			if($file->is_image && $media_type == 'image')
				$dropdown .= ' thumbnail="'.(isset($file->thumburl) && $file->thumburl!=''?$file->thumburl:$file->fullurl).'"';
			
			$dropdown .= '>'.$file->basename.'</option>';
		}
		$dropdown .= "</select>";
		return $dropdown;
	}

	/**
	 * Replaces all multiple slashes, dots and (multiple) backslashes with one single slash to make a clean secure url parameter
	 *
	 * @since 1.0
	 * @access public
	 *
	 * @param string $url - the url to clean
	 * @param string $full_url - true to prepend uploads url on return, false to return only the cleaned $url
	 *
	 * @return string - the clean url
	 */
	public static final function CleanURL($url, $full_url = true)
	{
		$config = cmsms()->GetConfig();
		$url = trim(str_replace(array($config['uploads_path'],$config['uploads_url']), '', $url),'/'.DIRECTORY_SEPARATOR);
		$url = str_replace(DIRECTORY_SEPARATOR,'/',$url);
		$url = trim(preg_replace('/(\/\.)|(\.\/)|(\/?\.\.\/?)/','/',$url),'/');
		if($full_url)
		{
			$url = preg_replace('/\/+/','/', '/' . str_replace(array('http://', 'https://','www.'),'',$url) . '/');
			$url = $config['uploads_url'] . $url;
			return $url;
		}
		return trim(preg_replace('/\/+/','/',$url),'/');
	}
	

	/**
	 * Returns the thumbnail of a given image file.
	 *
	 * @since 1.0
	 * @access public
	 *
	 * @param string $path - the path of the file to create a thumbnail of (can be relative to the uploads dir or absolute)
	 * @param string $create_thumb - set to false if thumbnail may not be created if not exists
	 * @param string $urlonly - set to true to get only the url to the thumbnail
	 *
	 * @return string - HTML img element or url
	 */
	public static final function GetThumbnail($path, $create_thumb = true, $urlonly = false)
	{
		if($path == '')
		{
			return false;
		}
		$config = cmsms()->GetConfig();
		$filename = basename($path);
		$path     = self::CleanPath(str_replace($filename,'',$path));
		$url      = self::CleanURL(str_replace($filename,'',$path));
		
		if(!startswith($path, JMFP_THUMBNAILS_PATH))
		{
			# temporary until a propper fix is found: @filectime... the @ is to be removed (JM)
			$thumbnail = cms_join_path(JMFP_THUMBNAILS_PATH , 'thumb_' . munge_string_to_url(str_replace($config['uploads_path'], '', $path)) . '_' . $filename);
			if((!is_file($thumbnail) || @filectime($path . $filename) > filectime($thumbnail)) && $create_thumb)
			{
				self::HandleFileResizing($path . $filename, $thumbnail, get_site_preference('thumbnail_width', 96), get_site_preference('thumbnail_height',96),true,false,60,false);
				debug_buffer( 'Used space after image procesing ... ' . memory_get_usage() , 'JMFilePicker');
				
			}
			if(is_file($thumbnail))
			{
				$thumbUrl = $config['root_url'] . '/' . self::CleanURL(str_replace($config['root_path'], '', $thumbnail), false);
			}
			else
			{
				$thumbUrl = $url . $filename;
				$thumbnail_size = self::GetThumbnailSize($path . $filename);
			}
		}
		else
		{
			$filename = 'thumb_' . $filename;
			$thumbUrl = $url . $filename;
		}
		if($urlonly)
		{
			return $thumbUrl;
		}
		return '<img class="JMFP_thumbnail"' . (isset($thumbnail_size) && is_array($thumbnail_size) ? ' width="'.$thumbnail_size[0].'" height="'.$thumbnail_size[1].'"' : '') . ' id="' . munge_string_to_url($filename) . '_JMFP_thumbnail" src="' . $thumbUrl . '" alt="' . str_replace($config['uploads_url'],'',$url) . $filename . '" title="' . str_replace($config['uploads_url'],'',$url) . $filename . '" />';
	}
	
	/**
	 * Creates the thumbnail of a given image file.
	 *
	 * @since 1.2.9
	 * @access public
	 *
	 * @param string $path - the path of the file to create a thumbnail from (can be relative to the uploads dir or absolute)
	 *
	 * @return string - absolute path of the thumbnail
	 */
	public static final function CreateThumbnail($path)
	{
		if($path == '')
		{
			return;
		}
		$config = cmsms()->GetConfig();
		$filename = basename($path);
		$path     = self::CleanPath(str_replace($filename,'',$path));
		$thumbnail= cms_join_path(JMFP_THUMBNAILS_PATH , 'thumb_' . munge_string_to_url(str_replace($config['uploads_path'], '', $path)) . '_' . $filename);
		
		if(!is_file($thumbnail) || filectime($path . $filename) > filectime($thumbnail))
		{
			if(!self::HandleFileResizing($path . $filename, $thumbnail, get_site_preference('thumbnail_width', 96), get_site_preference('thumbnail_height',96),true,false,60,false))
			{
				debug_buffer( 'Used space after image procesing ... ' . memory_get_usage() , 'JMFilePicker');
				return;
			}
		}
		return $thumbnail;
	}
	
	/**
	 * Gets the icon for a file.
	 * If FileManager is installed it uses FileManager icons.
	 * Otherwise it uses own icons.
	 *
	 * @since 1.0
	 * @access public
	 *
	 * @param string $ext - the file extension
	 * @param bool $is_dir
	 * @param bool $is_image
	 * @return string - the HTML ouput of an image
	 */
	public static final function GetFileIcon($ext = '', $is_dir = false, $is_image = false)
	{

		$config = cmsms()->GetConfig();
		if($fm =& cmsms()->GetModuleInstance('FileManager'))
			return $fm->GetFileIcon($ext, $is_dir);
		if($is_dir)
			return '<img class="JMFP_fileicon" src="'.$config['root_url'].'/modules/JMFilePicker/images/dir.gif" alt="" />';
		if ($is_image)
			return '<img class="JMFP_fileicon" src="'.$config['root_url'].'/modules/JMFilePicker/images/images.gif" alt="" />';
		return '<img class="JMFP_fileicon" src="'.$config['root_url'].'/modules/JMFilePicker/images/fileicon.gif" alt="" />';
	}
	
	/**
	 * Gets the icon for the file operation. 
	 * If FileManager is installed it uses FileManager icons. 
	 * Otherwise it uses own icons
	 *
	 * @since 1.0
	 * @access public
	 *
	 * @param string $action - the file operation (e.g. 'delete')
	 * @return string - the HTML ouput of an image
	 */
	public static final function GetActionIcon($action)
	{
		$config = cmsms()->GetConfig();
		if($fm =& cmsms()->GetModuleInstance('FileManager'))
//			return $fm->GetActionIcon($action);
                        return '<img class="JMFP_actionicon" src="'.$config['root_url'].'/modules/JMFilePicker/images/'.$action.'.gif" title="'.$action.'" alt="'.$action.'" />';
		else
			return '<img class="JMFP_actionicon" src="'.$config['root_url'].'/modules/JMFilePicker/images/'.$action.'.gif" title="'.$action.'" alt="'.$action.'" />';
	}
	
	/**
	 * Checks if a directory is empty
	 * Taken from TinyMCE Module (extracted from filepicker).
	 * @since 1.0
	 * @access public
	 * @param string $dir - the path to a directory
	 * @return boolean
	 */
	public static final function IsDirEmpty($dir)
	{
		$d = dir(self::CleanPath($dir));
		while ($entry = $d->read())
		{
			if ($entry == '.')
				continue;
			if ($entry == '..')
				continue;
			return false;
		}
		return true;
	}
	
	/**
	 * Sorts the files by filename; shows directories first
	 * this function is meant to be called from the php usort() function: usort($array,array('jmfp_utils','SortFiles')
	 * Taken from TinyMCE filepicker.
	 * @since 1.0
	 * @access public
	 * @param object $file1 - one file to compare a php stdClass with properties (boolean) $is_dir - a flag that specifys if it is a dir or a file;(string) $basename - the basename of the file;
	 * @param object $file2 - the other file to compare a php stdClass with properties (boolean) $is_dir - a flag that specifys if it is a dir or a file;(string) $basename - the basename of the file;
	 * @return integer -1 or 1
	 */
	public static final function SortFiles($file1, $file2)
	{
		if ($file1->is_dir && !$file2->is_dir) return -1;
		if (!$file1->is_dir && $file2->is_dir) return 1;
		return strnatcasecmp($file1->basename, $file2->basename);
	}
	
	/**
	 * resizes images
	 * Adapted from TinyMCE filepicker.
	 * @since 1.0
	 * @access public
	 *
	 * @param string $source - the source path of the image
	 * @param string $output - the destination path of the resized image
	 * @param integer $new_width - the new wdth to scale the image to (if $keep_aspectratio is set to true this will be just some kind of max value)
	 * @param integer $new_height - the new height to scale the image to (if $keep_aspectratio is set to true this will be just some kind of max value)
	 * @param boolean $keep_aspectratio - set to false if image aspect ratio may be changed
	 * @param boolean $allow_upscaling - set to true if user may enlarge the image
	 * @param integer $quality - the quality of the new image (jpg only)
	 * @param boolean $clean_path - set to false if source is the upload_tmp_dir
	 *
	 * @todo enable format change?
	 */
	public static final function HandleFileResizing($source, $output, $new_width, $new_height, 
		$keep_aspectratio = true, $allow_upscaling = false, $quality = 100, $clean_path = true)
	{
		debug_buffer( 
			'Processing image ... 
			File : ' . basename($source) . '
			Memory Limit : ' . @ini_get("memory_limit") . '
			Used Space before image processing : ' . memory_get_usage(), 
			'JMFilePicker'
		);
		
		if(@ini_get("upload_tmp_dir") && !startswith($source, @ini_get("upload_tmp_dir")) && $clean_path)
			$source = self::CleanPath(str_replace(basename($source),'',$source)).basename($source);
		
		if($clean_path)
			$output = self::CleanPath(str_replace(basename($output),'',$output)).basename($output);
		
		$img_data = @getimagesize($source);
		
		if (!$img_data)
			return false;
		
		$required_space = $img_data[0] * $img_data[1] * 4;
		$finfo = @stat($source);
		if($finfo)
			$required_space = $required_space + $finfo['size'];
		
		debug_buffer( 'Required Space : ' . $required_space, 'JMFilePicker');
		
		if(!self::check_memory_limit($required_space))
			return false;
		
		switch($img_data['mime'])
		{
			case 'image/jpeg':
				$orig_image = @imagecreatefromjpeg($source);
				break;
			case 'image/gif' :
				$orig_image = @imagecreatefromgif($source);
				break;
			case 'image/png' :
				$orig_image = @imagecreatefrompng($source);
				break;
			default:
				return false;
		}
		
		if(!$orig_image)
			return false;
		
		debug_buffer('Used space during image procesing ... (Line ' . __LINE__ . '): ' . memory_get_usage(), 'JMFilePicker');
		
		$orig_width  = @imagesx($orig_image);
		$orig_height = @imagesy($orig_image);
		
		$aspectratio = $orig_width / $orig_height;
		
		$new_width  = floor($new_width);
		$new_height = floor($new_height);
		
		if($new_width <= 0 && $new_height > 0) { // force height
			$new_width = $orig_width;
			if($new_height > $orig_height && !$allow_upscaling)
			{
				$new_height = $orig_height;
			}
			if($keep_aspectratio)
			{
				$new_width = floor($new_height * $aspectratio);
			}
		}
		else if($new_height <= 0 && $new_width > 0) { // force width
			$new_height = $orig_height;
			if($new_width > $orig_width && !$allow_upscaling)
			{
				$new_width = $orig_width;
			}
			if($keep_aspectratio)
			{
				$new_height = floor($new_width / $aspectratio);
			}
		}
		else if($new_height > 0 && $new_width > 0) { // both
			if($new_width > $orig_width && !$allow_upscaling)
			{
				$new_width = $orig_width;
			}
			if($new_height > $orig_height && !$allow_upscaling)
			{
				$new_height = $orig_height;
			}
			$new_aspectratio = $new_width / $new_height;
			if($keep_aspectratio)
			{
				if($aspectratio > 1 && $new_aspectratio < 1)
				{ // landscape to portrait
					$_tmp = floor($new_width / $aspectratio);
					if($_tmp > 0 && $_tmp <= $new_height)
					{
						$new_height = $_tmp;
					}
				}
				else if($aspectratio < 1 && $new_aspectratio > 1)
				{ // portrait to landscape
					$_tmp = floor($new_height * $aspectratio);
					if($_tmp > 0 && $_tmp <= $new_width)
					{
						$new_width = $_tmp;
					}
				}
				else
				{
					if($new_aspectratio < $aspectratio)
					{
						$_tmp = floor($new_width / $aspectratio);
						if($_tmp > 0 && $_tmp <= $new_height)
						{
							$new_height = $_tmp;
						}
					}
					else if($new_aspectratio > $aspectratio)
					{
						$_tmp = floor($new_height * $aspectratio);
						if($_tmp > 0 && $_tmp <= $new_width)
						{
							$new_width = $_tmp;
						}
					}
				}
			}
		}
		else
		{
			$new_height = $orig_height;
			$new_width  = $orig_width;
		}
		
		if($new_width < 1)
		{
			$new_width = 1;
		}
		if($new_height < 1)
		{
			$new_height = 1;
		}
		
		$new_image = @imagecreatetruecolor(floor($new_width), floor($new_height));
		
		debug_buffer('Used space during image procesing ... (Line ' . __LINE__ . '): ' . memory_get_usage(), 'JMFilePicker');
		
		// handle transparency (adapted from supersizer plugin)
		if($img_data['mime'] == 'image/gif')
		{
			@imagetruecolortopalette($new_image, true, 256);
			@imagealphablending($new_image, false);
			@imagesavealpha($new_image,true);
			$transparent = @imagecolorallocatealpha($new_image, 255, 255, 255, 127);
			@imagefilledrectangle($new_image, 0, 0, $new_width, $new_height, $transparent);
			@imagecolortransparent($new_image, $transparent);
		}
		else if ($img_data['mime'] == 'image/png')
		{
			@imagecolortransparent($new_image, @imagecolorallocate($new_image, 0, 0, 0));   
			@imagealphablending($new_image, false);
			$color = @imagecolorallocatealpha($new_image, 0, 0, 0, 127);
			@imagefill($new_image, 0, 0, $color);
			@imagesavealpha($new_image, true);
		}
		
		@imagecopyresampled($new_image, $orig_image, 0, 0, 0, 0, $new_width, $new_height, $orig_width, $orig_height);
		
		@imagedestroy($orig_image);
		
		switch($img_data['mime'])
		{
			case 'image/jpeg': 
				$result = @imagejpeg($new_image, $output, $quality);break;
			case 'image/gif' : 
				$result = @imagegif($new_image, $output);break;
			case 'image/png' : 
				$result = @imagepng($new_image, $output);break;
			default: 
				$result = false;
		}
		
		@imagedestroy($new_image);
		
		return $result;
	}
	
	/**
	 * returns the calculated size of the thumbnail
	 *
	 * @since 1.2
	 * @access public
	 *
	 * @param string $path - the source path of the image
	 * @return array - array(width,height)
	 */
	public static final function GetThumbnailSize($path)
	{
		$path = self::CleanPath(str_replace(basename($path),'',$path)).basename($path);
		$img_data = @getimagesize($path);
		
		if (!$img_data)
		{
			return false;
		}
		
		$orig_width  = $img_data[0];
		$orig_height = $img_data[1];
		$aspectratio = $orig_width / $orig_height;
		
		$new_width  = floor(get_site_preference('thumbnail_width', 96));
		$new_height = floor(get_site_preference('thumbnail_height', 96));
		
		if($new_width <= 0)
		{
			$new_width = 96;
		}
		
		if($new_height <= 0)
		{
			$new_height = 96;
		}
		
		if($new_width > $orig_width)
		{
			$new_width = $orig_width;
		}
		if($new_height > $orig_height)
		{
			$new_height = $orig_height;
		}
		$new_aspectratio = $new_width / $new_height;
		
		if($aspectratio > 1 && $new_aspectratio < 1)
		{ // landscape to portrait
			$_tmp = floor($new_width / $aspectratio);
			if($_tmp > 0 && $_tmp <= $new_height)
			{
				$new_height = $_tmp;
			}
		}
		else if($aspectratio < 1 && $new_aspectratio > 1)
		{ // portrait to landscape
			$_tmp = floor($new_height * $aspectratio);
			if($_tmp > 0 && $_tmp <= $new_width)
			{
				$new_width = $_tmp;
			}
		}
		else
		{
			if($new_aspectratio < $aspectratio)
			{
				$_tmp = floor($new_width / $aspectratio);
				if($_tmp > 0 && $_tmp <= $new_height)
				{
					$new_height = $_tmp;
				}
			}
			else if($new_aspectratio > $aspectratio)
			{
				$_tmp = floor($new_height * $aspectratio);
				if($_tmp > 0 && $_tmp <= $new_width)
				{
					$new_width = $_tmp;
				}
			}
		}
		
		if($new_width < 1)
		{
			$new_width = 1;
		}
		if($new_height < 1)
		{
			$new_height = 1;
		}
		return array($new_width, $new_height);
	}
	
	/**
	 * Checks if a filename contains illegal chars
	 * Taken from TinyMCE Module.
	 * @since 1.0
	 * @access public
	 * @param string $filename - the filename to check
	 * @return boolean
	 */
	public static final function ContainsIllegalChars($filename)
	{
		if (strpos($filename, '\'') !== false) return true;
		if (strpos($filename, '"' ) !== false) return true;
		if (strpos($filename, '/' ) !== false) return true;
		if (strpos($filename, '\\') !== false) return true;
		if (strpos($filename, '&' ) !== false) return true;
		if (strpos($filename, '\$') !== false) return true;
		if (strpos($filename, '+' ) !== false) return true;
		return false;
	}
	
	/**
	 * Checks if a var is empty.
	 * If $var is an array it recursivley checks all elements.
	 *
	 * @since 1.0
	 * @access public
	 *
	 * @param mixed &$var - the var to check for empty value(s)
	 * @param boolean $trim - true to trim off spaces
	 * @param boolean $unset_empty_indexes - true to delete empty elements from array
	 * @return boolean - true if empty, false if not
	 */
	public static final function IsVarEmpty(&$var, $trim = true, $unset_empty_indexes = false)
	{
		if (is_array($var))
		{
			foreach ($var as $k=>$v)
			{
				if (!self::IsVarEmpty($v))
				{
					return false;
				}
				
				if($unset_empty_indexes)
				{
					unset($var[$k]);
				}
				return true;
			}
		}
		else if($trim && !is_object($var) && trim($var) == '')
		{
			return true;
		}
		else if($var == '')
		{
			return true;
		}
		return false;
	}
	
	/**
	 * Removes empty elements from an array. 
	 * (can be useful when using function explode to create the array from a csv)
	 *
	 * @since 1.0
	 * @access public
	 *
	 * @param array $array - the array to clean up
	 * @return array - an array without empty elements or an empty array
	 */
	public static final function CleanArray($array)
	{
		if (is_array($array))
		{
			foreach ($array as $k=>$v)
			{
				if (self::IsVarEmpty($v,true,true))
				{
					unset($array[$k]);
				}
				else
				{
					if(is_array($v))
					{
						$v = self::CleanArray($v);
						if(self::IsVarEmpty($v,true,true))
						{
							unset($array[$k]);
						}
						else
						{
							$array[$k] = $v;
						}
					}
				}
			}
			return $array;
		}
		return array();
	}
	
	/**
	 * Checks if a value is really meant to be "true".
	 * Can be usefull when checking smarty params for the value true
	 *
	 * @since 1.0
	 * @access public
	 *
	 * @param mixed $value - the value to check
	 * @return bool
	 */
	public static final function IsTrue($value)
	{
		return (strtolower($value) === 'true' || $value === 1 || $value === '1' || $value === true);
	}

	/**
	 * Checks if a value is really meant to be "false". 
	 * Can be usefull when checking smarty params for the value false
	 *
	 * @since 1.0
	 * @access public
	 *
	 * @param mixed $value - the value to check
	 * @return bool
	 */
	public static final function IsFalse($value)
	{
		return (strtolower($value) === 'false' || $value === '0' || $value === 0 || $value === false || $value === '');
	}

	/**
	 * @since 1.0
	 * @ignore
	 */
	public static final function check_memory_limit($required_space, $adjust = true)
	{
		$old_memory_limit = @ini_get("memory_limit");
		if($old_memory_limit === FALSE && $old_memory_limit !== NULL) # ???
			return false;
		
		if(!preg_match('/(\d+)[\s]*([a-z]+)/i', $old_memory_limit, $matches))
			return false; # ToDo: unlimited???
		
		$unit         = isset($matches[2]) ? strtolower($matches[2]) : '';
		$memory_limit = isset($matches[1]) ? intval($matches[1]) : 0;
		
		switch($unit)
		{
			case 'g':
			case 'gb':
				$memory_limit *= 1073741824;
				break;
			case 'm':
			case 'mb':
				$memory_limit *= 1048576;
				break;
			case 'k':
			case 'kb':
				$memory_limit *= 1024;
				break;
		}
		
		debug_buffer('Available space : ' . ($memory_limit - memory_get_usage()), 'JMFilePicker');
		
		if($memory_limit > 0 && ($memory_limit - memory_get_usage() <= $required_space))
		{
			if($adjust)
			{
				$memory_limit = (ceil((memory_get_usage() + $required_space) / 1048576) + 16) . 'M'; # + 16 = required memory for CMSms
				debug_buffer( 'Not enough memory. Try to adjust memory limit to : ' . $memory_limit, 'JMFilePicker');
				$ini_set = @ini_set('memory_limit', $memory_limit);
				if($ini_set === NULL || $ini_set === FALSE || $old_memory_limit == @ini_get("memory_limit"))
				{
					debug_buffer( 'Could not adjust memory limit. Skipping whatever i\'m about to do ...', 'JMFilePicker');
					return false;
				}
				return true;
			}
			debug_buffer( 'Not enough memory. Skipping whatever i\'m about to do ...', 'JMFilePicker');
			return false;
		}
		return true;
	}
  
  public static function FEU_Loaded()
  {
    return is_object( cmsms()->GetModuleInstance('FrontEndUsers') );
  }
}
?>
