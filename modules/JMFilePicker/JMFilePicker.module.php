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

$cfg = cmsms()->GetConfig();
define('JMFP_THUMBNAILS_PATH', cms_join_path($cfg['uploads_path'] , 'JMFilePickerThumbs'));

/**
 * Class definition and methods for JMFilePicker
 *
 * @package CMSModule
 * @license GPL
 */

/**
 * Main class of the JMFilePicker Module
 *
 * @author Georg Busch (NaN)
 * @copyright 2010-2012 Georg Busch (NaN)
 * @version 1.3.3
 *
 * @package CMSModule
 * @license GPL
 */
class JMFilePicker extends CMSModule
{
	/**
	 * @access protected
	 * @var boolean
	 * @ignore
	 */
	protected $_isAdmin;
	
	/**
	 * @access protected
	 * @var boolean
	 * @ignore
	 */
	protected $_loaded;
	
	/**
	 * @access protected
	 * @var string
	 * @ignore
	 */
	protected $_username;

  private function _initialize()
  {
    $this->_autoload_register();
    $this->_loaded = false;
  }

  protected function _autoload_register()
  {
    spl_autoload_register(array($this, '_auto_load'));    
  }
    

  protected function _auto_load($class)
  {
    $_fn = cms_join_path(
                          dirname(__FILE__),
                          'lib',
                          "class.{$class}.php"
                        );
                        
    if( file_exists($_fn) )
    {
      require_once($_fn);
      return;
    }
    
    return;
  }

	/**
	 * Constructor
	 * @ignore
	 */
	function __construct()
	{
    $this->_initialize();
    $smarty = cmsms()->GetSmarty();
    $smarty->register_function('jmfp_jsloader', array('jmfp_smarty_plugins', 'jmfp_jsloader'));
    $smarty->register_function('jmfp_cms2', array('jmfp_smarty_plugins', 'jmfp_cms2'));
    $smarty->register_function('jmfp', array('jmfp_smarty_plugins', 'JMFilePicker'));
		parent::__construct();
	}
	
	/**
	 * @link http://www.cmsmadesimple.org/apidoc/CMS/CMSModule.html#GetName
	 * @ignore
	 */
	function GetName()
	{
		return 'JMFilePicker';
	}
	
	/**
	 * @link http://www.cmsmadesimple.org/apidoc/CMS/CMSModule.html#GetFriendlyName
	 * @ignore
	 */
	function GetFriendlyName()
	{
		return $this->Lang('JMFilePicker');
	}
	
	/**
	 * @link http://www.cmsmadesimple.org/apidoc/CMS/CMSModule.html#GetVersion
	 * @ignore
	 */
	function GetVersion()
	{
		return '1.0.1';
	}
	
	/**
	 * @link http://www.cmsmadesimple.org/apidoc/CMS/CMSModule.html#GetHelp
	 * @ignore
	 */
	function GetHelp()
	{
    $smarty = cmsms()->GetSmarty();
    $config = cmsms()->GetConfig();
    $smarty->assign('root_url', $config['root_url']);
    return $this->ProcessTemplate('help.tpl');
	}
	
	/**
	 * @link http://www.cmsmadesimple.org/apidoc/CMS/CMSModule.html#GetAuthor
	 * @ignore
	 */
	function GetAuthor()
	{
		return 'Jo Morg';
	}
	
	/**
	 * @link http://www.cmsmadesimple.org/apidoc/CMS/CMSModule.html#GetChangeLog
	 * @ignore
	 */
	function GetChangeLog()
	{
    $smarty = cmsms()->GetSmarty();
    return $this->ProcessTemplate('changelog.tpl');
	}
	
	/**
	 * @link http://www.cmsmadesimple.org/apidoc/CMS/CMSModule.html#HasAdmin
	 * @ignore
	 */
	function HasAdmin()
	{
		return $this->CheckPermission('Manage JMFilePicker');
	}
	
	/**
	 * @link http://www.cmsmadesimple.org/apidoc/CMS/CMSModule.html#GetAdminSection
	 * @ignore
	 */
	function GetAdminSection()
	{
		return 'extensions';
	}
	
	/**
	 * @link http://www.cmsmadesimple.org/apidoc/CMS/CMSModule.html#GetAdminDescription
	 * @ignore
	 */
	function GetAdminDescription()
	{
		return $this->lang('admindescription');
	}
	
	/**
	 * @link http://www.cmsmadesimple.org/apidoc/CMS/CMSModule.html#VisibleToAdminUser
	 * @ignore
	 */
	function VisibleToAdminUser()
	{
		return $this->CheckPermission('Manage JMFilePicker');
	}
	
	/**
	 * @link http://www.cmsmadesimple.org/apidoc/CMS/CMSModule.html#MinimumCMSVersion
	 * @ignore
	 */
	function MinimumCMSVersion()
	{
		return "1.12";
	}
	
	
	/**
	 * @link http://www.cmsmadesimple.org/apidoc/CMS/CMSModule.html#InstallPostMessage
	 * @ignore
	 */
	function InstallPostMessage()
	{
		return $this->Lang('post_install', $this->GetVersion());
	}
	
	/**
	 * @link http://www.cmsmadesimple.org/apidoc/CMS/CMSModule.html#UninstallPostMessage
	 * @ignore
	 */
	function UninstallPostMessage()
	{
		return $this->Lang('post_uninstall', $this->GetVersion());
	}
	
	/**
	 * @link http://www.cmsmadesimple.org/apidoc/CMS/CMSModule.html#UninstallPreMessage
	 * @ignore
	 */
	function UninstallPreMessage()
	{
		return $this->Lang('confirm_uninstall');
	}
	
	/**
	 * @link http://www.cmsmadesimple.org/apidoc/CMS/CMSModule.html#HandlesEvents
	 * @ignore
	 */
	function HandlesEvents()
	{
		return false;
	}
	
	/**
	 * @link http://www.cmsmadesimple.org/apidoc/CMS/CMSModule.html#IsPluginModule
	 * @ignore
	 */
	function IsPluginModule()
	{
		return false;
	}
  
  function InitializeAdmin()
  {
    if(!is_dir(JMFP_THUMBNAILS_PATH))
    {
      @mkdir(JMFP_THUMBNAILS_PATH, 0755);
    }
    
    $userops        = cmsms()->GetUserOperations();
    $this->_isAdmin = $this->CheckPermission('jmfp_dummy_permission');
    
    if($user = $userops->LoadUserById(get_userid(false)))
    {
      $this->_username = $user->username;
    }
    
  }
	
	/**
	 * @link http://www.cmsmadesimple.org/apidoc/CMS/CMSModule.html#DoAction
	 * @ignore
	 */
	function DoAction($action, $id, $params, $returnid = '')
	{
		switch($action)
		{
			case 'upload':
			case 'savePrefs':
			case 'fileBrowser':
			case 'filepicker':
			case 'defaultadmin':
			case 'reloadDropdown':
				parent::DoAction($action, $id, $params, $returnid);
				break;
			case 'delete':
				unset($params['action']);
				parent::DoAction('fileBrowser', $id, $params, $returnid);
				break;
			default: break;
		}
	}
	
	/**
	 * @link http://www.cmsmadesimple.org/apidoc/CMS/CMSModule.html#HasCapability
	 * @ignore
	 */
	function HasCapability($capability,$params = array())
	{
		switch( $capability )
		{
			case 'contentblocks':
			case 'content_attributes':
 				return TRUE;
			default:
				return FALSE;
		}
	}
  
  function GetContentBlockFieldInput($blockName, $value, $params, $adding, ContentBase $content_obj)
  {
    //$adding = ($adding || ($content_obj->Id() < 1)) ? TRUE : FALSE; // hack for the core.
    if( empty($blockName) ) return FALSE;

    if($this->CheckPermission('Use JMFilePicker'))
    {
      if(isset($params['smarty']) && jmfp_utils::IsTrue($params['smarty']))
      {
        foreach($params as $k=>$v)
        {
          $params[$k] = $this->DoSmarty($v);
        }
      }
      
      return $this->CreateFilePickerInput($this, '', str_replace(' ', '_', $blockName), $value, $params);
    }
    
    return;
  }
	
	/**
	 * @link http://www.cmsmadesimple.org/apidoc/CMS/CMSModule.html#GetContentBlockInput
	 * @ignore
	 */
	function GetContentBlockInput($blockname, $value, $params, $adding = false)
    {
		if($this->CheckPermission('Use JMFilePicker'))
		{
			if(isset($params['smarty']) && jmfp_utils::IsTrue($params['smarty']))
			{
				foreach($params as $k=>$v)
				{
					$params[$k] = $this->DoSmarty($v);
				}
			}
			return $this->CreateFilePickerInput($this, '', str_replace(' ','_',$blockname), $value, $params);
		}
		return;
	}
	
	
#-------------------------------------------------------------------------------
# Not part of the CMSms module API
#-------------------------------------------------------------------------------
	
	/**
	 * Creates the filepicker input.
	 *
	 * @since 1.0
	 * @access public
	 * @deprecated
	 *
	 * @param object &$module - deprecated
	 * @param string $id - the id of the moduleinstance that creates the filepicker input
	 * @param string $name - the name of the input field
	 * @param string $value - the preselected value
	 * @param array $params - the input params (param_name => param_value):<br /><ul>
	 *        <li>(string)  'feu_access'               => a csv of group ids of the frontend users module,</li>
	 *        <li>(boolean) 'restrict_users_diraccess' => set to true if user may only access a dir of his username (notice: this has no effect if you are admin; in frontend this will always be true),</li>
	 *        <li>(string)  'header_template'          => specify wich template should be used to create the html output that will be placed in the &lt;head&gt; section (default is header.tpl of the selected theme of JMFilePickers preferences),</li>
	 *        <li>(string)  'input_template'           => specify wich template should be used to create the input elements (default is input.tpl of the selected theme of JMFilePickers preferences),</li>
	 *        <li>(string)  'upload_template'          => specify wich template should be used to create the upload form of mode dropdown (default is upload.tpl of the selected theme of JMFilePickers preferences),</li>
	 *        <li>(string)  'filebrowser_template'     => specify wich template should be used to create the filebrowser output (default is filebrowser.tpl of the selected theme of JMFilePickers preferences),</li>
	 *        <li>(string)  'prompt'                   => the prompt of the input field,</li>
	 *        <li>(string)  'media_type'               => the media type (at the moment only image / file are supported),</li>
	 *        <li>(mixed)   'file_extensions'          => an array or a csv of allowed file extensions (deprecated),</li>
	 *        <li>(mixed)   'exclude_prefix'           => an array or a csv of file prefixes that will be excluded (deprecated),</li>
	 *        <li>(mixed)   'exclude_sufix'            => an array or a csv of file suffixes that will be excluded (deprecated),</li>
	 *        <li>(mixed)   'include_prefix'           => an array or a csv of file prefixes that will be included (deprecated),</li>
	 *        <li>(mixed)   'include_sufix'            => an array or a csv of file suffixes that will be included (deprecated),</li>
	 *        <li>(boolean) 'show_subdirs'             => set to true if user may browse subdirs (notice: this has no effect if you are admin)</li>
	 *        <li>(string)  'mode'                     => dropdown/browser,</li>
	 *        <li>(boolean) 'allow_none'               => set to false if the option "none" should not be shown (notice: this has no effect if you are admin),</li>
	 *        <li>(boolean) 'lock_input'               => set to false if user may enter the path in the inputfield ('mode'=>'browser', 'media_type' => 'file') (notice: this has no effect if you are admin),</li>
	 *        <li>(boolean) 'upload'                   => set to true if user may upload files (notice: this has no effect if you are admin or have permission to modify files),</li>
	 *        <li>(boolean) 'delete'                   => set to true if user may delete files/dirs (notice: this has no effect if you are admin or have permission to modify files),</li>
	 *        <li>(boolean) 'create_dirs'              => set to true if user may create dirs (notice: this has no effect if you are admin or have permission to modify files),</li>
	 *        <li>(string)  'add_txt'                  => any additional text that will be added to the html input when tag is rendered,</li>
	 *        <li>(integer) 'size'                     => the size of the textinput ('mode' => 'browser', 'media_type' => 'file' only),</li>
	 *        <li>(integer) 'maxlength'                => the max length of the textinput ('mode' => 'browser', 'media_type' => 'file' only),</li>
	 *        <li>(integer) 'scaling_width'            => the default width of images when allow_scaling is true,</li>
	 *        <li>(integer) 'scaling_height'           => the default height of images when allow_scaling is true,</li>
	 *        <li>(boolean) 'show_thumbfiles'          => set to true if thumbs should also be shown as regular files,</li>
	 *        <li>(boolean) 'allow_scaling'            => set to false if user may not scale the images on upload,</li>
	 *        <li>(boolean) 'create_thumbs'            => set to false if the module may not create thumbs for the input,</li>
	 *        <li>(boolean) 'allow_upscaling'          => set to true if user may enlarge the images</li>
	 *        <li>(boolean) 'force_scaling'            => set to true to force resizing of image to a given size if user may not resize images</li>
	 *        <li>(boolean) 'keep_aspectratio'         => set to false to change aspect ratio to that one of the scaling size on resizing images</li></ul>
	 * @param integer $returnid - the page id to return to and to print out the result after module has finished its task;<br />usually this has nothing to say but is required for frontend usage (must be an existing content id)
	 *
	 * @return string - the HTML output of the filepicker
	 */
	public function CreateFilePickerInput(
																					$module,
																					$id,
																					$name,
																					$value = '',
																					$params = array(),
																					$returnid = ''
																				)
	{
    $cache_id = '|ns'.md5(serialize(func_get_args()));
    
		$config = cmsms()->GetConfig();
		$smarty = cmsms()->GetSmarty();
    $output = '';
		
		if(
		    class_exists('cms_utils') &&
        cms_utils::get_current_pageid() &&
        $returnid == ''
    )
			$returnid = cms_utils::get_current_pageid();
		
		$name = str_replace(' ', '_', $name);
  
		if(!$params =& $this->SetInputParams('', $id, $name, $params))
			return $output;
		
		$value  = jmfp_utils::CleanURL($value, false);
		

		
		$smarty->assign('thumb_width', cms_siteprefs::get('thumbnail_width', 96));
		$smarty->assign('thumb_height', cms_siteprefs::get('thumbnail_height', 96));
		
		if($params['media_type'] == 'image')
		{
			$thumbnail_size = jmfp_utils::GetThumbnailSize($value);
			$smarty->assign('jmfp_thumb_width', $thumbnail_size[0]);
			$smarty->assign('jmfp_thumb_height', $thumbnail_size[1]);
			$smarty->assign('jmfp_thumburl', jmfp_utils::GetThumbnail($value, $params['create_thumbs'],true));
		}
		
		$smarty->assign('jmfp_value', $value);
		$smarty->assign('jmfp_loaded', $this->_loaded);
		
		$input       = '';
		$upload_link = '';
		$browse_link = '';
		$clear_link  = '';
		$reload_link = '';
		$upload_url  = '';
		$browse_url  = '';
		$reload_url  = '';
		
		$filebrowser_url = str_replace('&amp;','&',$this->CreateLink(($id == '' ? 'm1_' : $id), 'fileBrowser', $returnid, '',array('name' =>$name,'dir'=>($this->_isAdmin?$params['dir']:'')),'', true));
		
		if($params['mode'] == 'dropdown')
		{
			$input = jmfp_utils::CreateFileDropdown(
				$id,
				$name,
				$params['dir'],
				$value,
				$params['exclude_prefix'],
				$params['include_prefix'],
				$params['exclude_sufix'],
				$params['include_sufix'],
				$params['file_extensions'],
				$params['media_type'],
				$params['allow_none'],
				$params['add_txt']);
			
			if($params['upload'])
			{
				$upload_url  = str_replace('&amp;','&',$this->CreateLink(($id == '' ? 'm1_' : $id), 'upload', $returnid, $this->lang('upload'),array('name' =>$name,'dir'=>($this->_isAdmin?$params['dir']:'')),'', true));
				$upload_link = $this->CreateLink(($id == '' ? 'm1_' : $id), 'upload', $returnid, $this->lang('upload'), array('name' =>$name), '', false, false, 'id="'.$id.munge_string_to_url($name).'_JMFP_upload" class="JMFP_link JMFP_upload"');
			}
			
			$reload_url  = str_replace('&amp;','&',$this->CreateLink(($id == '' ? 'm1_' : $id),'reloadDropdown',$returnid,$this->lang('reload_dropdown'),array('name' =>$name,'dir'=>($this->_isAdmin?$params['dir']:'')),'',true));
			$reload_link = $this->CreateLink(($id == '' ? 'm1_' : $id), 'reloadDropdown', $returnid, $this->lang('reload_dropdown'), array('name' =>$name), '', false, false, 'id="'.$id.munge_string_to_url($name).'_JMFP_reload_dropdown" class="JMFP_link JMFP_reload_dropdown"');
		}
		else if($params['mode'] == 'browser')
		{
			if($params['media_type'] == 'image')
				$input = '<input id="'.$id.munge_string_to_url($name).'" class="JMFP_input JMFP_hiddeninput" type="hidden" name="'.$id.$name.'" value="' . $value . '" />';
			else if($params['media_type'] == 'file')
				$input = '<input id="'.$id.munge_string_to_url($name).'" class="JMFP_input JMFP_textinput" type="text"' . ($params['lock_input']?' disabled="disabled"':'') . ($params['add_txt'] != ''? ' '.$params['add_txt'].' ':'') . ($params['size'] != ''?' size="' . $params['size'] . '"':'') . ($params['maxlength'] != ''?' maxlength="' . $params['maxlength'] . '"':'') . ' name="' . $id.$name . '" value="' . $value . '" />';
			
			$browse_url  = str_replace('&amp;','&',$this->CreateLink(($id == '' ? 'm1_' : $id), 'fileBrowser', $returnid, $this->lang('browse_'.$params['media_type']),array('name' =>$name,'dir'=>($this->_isAdmin?$params['dir']:'')),'', true));
			$browse_link = $this->CreateLink(($id == '' ? 'm1_' : $id), 'fileBrowser', $returnid, $this->lang('browse_'.$params['media_type']), array('name' =>$name,'dir'=>($this->_isAdmin?$params['dir']:'')), '', false, false, 'id="'.$id.munge_string_to_url($name).'_JMFP_browse" class="JMFP_link JMFP_browse"');
			if($params['allow_none'])
				$clear_link = '<a href="#" onclick="document.getElementById(\''.$id.munge_string_to_url($name).'\').value = \'\';return false;" id="'.$id.munge_string_to_url($name).'_JMFP_clear" class="JMFP_link JMFP_clear">'.$this->lang('none').'</a>';
		}
		
		$smarty->assign('jmfp_filebrowser_url', $filebrowser_url);
		$smarty->assign('jmfp_input', $input);
		$smarty->assign('jmfp_upload_url', $upload_url);
		$smarty->assign('jmfp_upload_link', $upload_link);
		$smarty->assign('jmfp_reload_dropdown_url', $reload_url);
		$smarty->assign('jmfp_reload_dropdown_link', $reload_link);
		$smarty->assign('jmfp_browse_url', $browse_url);
		$smarty->assign('jmfp_browse_link', $browse_link);
		$smarty->assign('jmfp_clear_link', $clear_link);
  
		$smarty->assign('jmfp_title', $this->Lang('browser_title'));
		$smarty->assign('debug',$config['debug'] ? 'true' : '\'\'');
		
		foreach($params as $k => $v)
		{
			$smarty->assign('jmfp_' . $k, $v);
		}
    
    $smarty->assign('jmfp_name', $name);
    $smarty->assign('jmfp_inputid', $id.$name);
    $smarty->assign('jmfp_cssid', $id.munge_string_to_url($name));

		$smarty->assign('jmfp_id', ($id == '' ? 'm1_' : $id));
		$smarty->assign('jmfp_reload_dir_text', $this->lang('reload_dir'));
		$smarty->assign('jmfp_clear_cache_text', $this->lang('clear_cache'));
		$smarty->assign('jmfp_close_text', $this->lang('close'));
		$smarty->assign('jmfp_upload_text', $this->lang('upload'));
		$smarty->assign('jmfp_browse_text', $this->lang('browse_'.$params['media_type']));


    if(!$this->_loaded)
		{

      $themeName = cms_utils::get_theme_object()->themeName;
      $admin_url = $config['admin_url'];
				
			$smarty->assign('expand_img', 
				$admin_url . '/themes/' . $themeName . '/images/icons/system/expand.gif',
				'','','','systemicon'
			);
			$smarty->assign('contract_img', 
				$admin_url . '/themes/' . $themeName . '/images/icons/system/contract.gif',
				'','','','systemicon'
			);
      
      $template = $this->GetTemplateResource('header.tpl');
      $template_obj = $smarty->createTemplate($template, $cache_id);
      $output = $template_obj->fetch();
      
			$this->_loaded = true;
		}
    $template = $this->GetTemplateResource('input.tpl');
    $template_obj = $smarty->createTemplate($template, $cache_id);
    $output .= $template_obj->fetch();
    
		return $output;
  
	}
	
	
	/**
	 * @since 1.1
	 * @access private
	 * @ignore
	 */
	private function &SetInputParams($module, $id, $name, $params = array())
	{
		global $CMS_ADMIN_PAGE;
		$config = cmsms()->GetConfig();
		@session_start();
		$_SESSION['JMFP_' . ($id == '' ? 'm1_' : $id).$name] = array();
		$result = false;
		$name = str_replace(' ','_',$name);
		if(!$session_params =& $this->GetInputParams($id, $name))
			return $result;
		
		if(isset($params['prompt']))
			$session_params['prompt'] = $params['prompt'];
		
		if(isset($params['header_template']))
			$session_params['header_template'] = $params['header_template'];
		if(isset($params['input_template']))
			$session_params['input_template'] = $params['input_template'];
		if(isset($params['upload_template']))
			$session_params['upload_template'] = $params['upload_template'];
		if(isset($params['filebrowser_template']))
			$session_params['filebrowser_template'] = $params['filebrowser_template'];
		
		$session_params['module'] = $this->GetName();
		if(isset($params['feu_access']))
		{
			if(!is_array($params['feu_access']))
				$session_params['feu_access'] = jmfp_utils::CleanArray(explode(',',$params['feu_access']));
			else
				$session_params['feu_access'] = jmfp_utils::CleanArray($params['feu_access']);
		}
		if(isset($params['restrict_users_diraccess']) && jmfp_utils::IsFalse($params['restrict_users_diraccess']))
			$session_params['restrict_users_diraccess'] = false;
		
		$dir = $session_params['start_dir'];
		if(isset($params['dir']) && $params['dir'] != '')
		{
			$dir = jmfp_utils::CleanURL($params['dir'],false);
			if(!$this->_isAdmin)
				$session_params['start_dir'] = $dir;
		}
		
		if(isset($CMS_ADMIN_PAGE) && $CMS_ADMIN_PAGE == 1)
		{
			check_login();
			if(!$this->CheckPermission('Use JMFilePicker'))
				return $result;
			
			$username = $this->_username;
		}
		else
		{
			if( !$feusers = cmsms()->GetModuleInstance('FrontEndUsers' ) )
				return $result;
			if(!$userid = $feusers->LoggedInId())
				return $result;
			if(!$groups = $feusers->GetMemberGroupsArray($userid))
				return $result;
			$access = false;
			foreach($groups as $_group)
			{
				if(in_array($_group['groupid'],$session_params['feu_access']))
				{
					$access = true;
					break;
				}
			}
			if(!$access)
				return $result;
			
			$username = $feusers->GetUserName($userid);
			$params['media_type'] = 'image';
			$params['restrict_users_diraccess'] = true;
		}
		
		if(!$this->_isAdmin && $session_params['restrict_users_diraccess'])
		{
			if(!in_array($username, jmfp_utils::CleanArray(explode('/',$dir))))
				$session_params['start_dir'] .= '/' . $dir;
			else
				$session_params['start_dir'] = $dir;
			
			$_dir = jmfp_utils::CleanPath($session_params['start_dir']);
			@mkdir($_dir, 0755, true);
			if(!is_dir($_dir) || !is_readable($_dir))
				return $result;
		}
		
		if(isset($params['media_type']))
			$session_params['media_type'] = strtolower($params['media_type']);
		
		if($session_params['media_type'] == 'file')
			$session_params['file_extensions'] = array();
		if(isset($params['file_extensions']) && $params['file_extensions'] != '')
		{
			$_file_ext = jmfp_utils::CleanArray(explode(',',strtolower($params['file_extensions'])));
			if($session_params['media_type'] == 'image')
				$_file_ext = jmfp_utils::CleanArray(array_intersect($_file_ext, array('jpg','jpeg','gif','png')));
			if(empty($_file_ext))
				$_file_ext = $session_params['file_extensions'];
			$session_params['file_extensions'] = $_file_ext;
		}
		if(isset($params['exclude_prefix']))
			$session_params['exclude_prefix'] = trim($params['exclude_prefix']);
		if(isset($params['exclude_sufix']))
			$session_params['exclude_sufix'] = trim($params['exclude_sufix']);
		if(isset($params['include_prefix']))
			$session_params['include_prefix'] = trim($params['include_prefix']);
		if(isset($params['include_sufix']))
			$session_params['include_sufix'] = trim($params['include_sufix']);
		
		if(isset($params['show_subdirs']) && jmfp_utils::IsTrue($params['show_subdirs']))
			$session_params['show_subdirs'] = true;
		else if(isset($params['show_subdirs']) && jmfp_utils::IsFalse($params['show_subdirs']) && !$this->_isAdmin)
			$session_params['show_subdirs'] = false;
		
		if(isset($params['mode']))
			$session_params['mode'] = strtolower($params['mode']);
		if(isset($params['allow_none']) && jmfp_utils::IsFalse($params['allow_none']) && !$this->_isAdmin)
			$session_params['allow_none'] = false;
		
		if(isset($params['lock_input']) && jmfp_utils::IsFalse($params['lock_input']))
			$session_params['lock_input'] = false;
		else if(isset($params['lock_input']) && jmfp_utils::IsTrue($params['lock_input']) && !$this->_isAdmin)
			$session_params['lock_input'] = true;
		
		if(isset($params['upload']) && jmfp_utils::IsTrue($params['upload']) && $this->GetPreference('show_filemanagement'))
			$session_params['upload'] = true;
		else if(isset($params['upload']) && jmfp_utils::IsFalse($params['upload']) && !$this->_isAdmin)
			$session_params['upload'] = false;
		
		if(isset($params['delete']) && jmfp_utils::IsTrue($params['delete']) && $this->GetPreference('show_filemanagement'))
			$session_params['delete'] = true;
		else if(isset($params['delete']) && jmfp_utils::IsFalse($params['delete']) && !$this->_isAdmin)
			$session_params['delete'] = false;
		
		if(isset($params['create_dirs']) && jmfp_utils::IsTrue($params['create_dirs']) && $this->GetPreference('show_filemanagement'))
		{
			$session_params['create_dirs']  = true;
			$session_params['show_subdirs'] = true;
		}
		else if(isset($params['create_dirs']) && jmfp_utils::IsFalse($params['create_dirs']) && !$this->_isAdmin)
			$session_params['create_dirs'] = false;
		
		if(isset($params['add_txt']))
			$session_params['add_txt'] = trim($params['add_txt']);
		if(isset($params['size']))
			$session_params['size'] = intval($params['size']);
		if(isset($params['maxlength']))
			$session_params['maxlength'] = intval($params['maxlength']);
		if(isset($params['scaling_width']))
			$session_params['scaling_width'] = intval($params['scaling_width']);
		if(isset($params['scaling_height']))
			$session_params['scaling_height'] = intval($params['scaling_height']);
		if(isset($params['show_thumbfiles']))
			$session_params['show_thumbfiles'] = intval($params['show_thumbfiles']);
		if(isset($params['allow_scaling']))
			$session_params['allow_scaling'] = intval($params['allow_scaling']);
		if(isset($params['create_thumbs']))
			$session_params['create_thumbs'] = intval($params['create_thumbs']);
		if(isset($params['allow_upscaling']))
			$session_params['allow_upscaling'] = intval($params['allow_upscaling']);
		if(isset($params['force_scaling']))
			$session_params['force_scaling'] = intval($params['force_scaling']);
		if(isset($params['keep_aspect_ratio']))
			$session_params['keep_aspect_ratio'] = intval($params['keep_aspect_ratio']);
		
		if($session_params['mode'] == 'dropdown')
		{
			$session_params['dir']       = $dir;
			$session_params['start_dir'] = $dir;
		}
		
		$_SESSION['JMFP_id_'.$name] = ($id == '' ? 'm1_' : $id);
		
		$_SESSION['JMFP_' . ($id == '' ? 'm1_' : $id).$name] = $session_params;
		
		$session_params['dir'] = $dir;
		return $session_params;
	}
	
	
	/**
	 * @since 1.1
	 * @access protected
	 * @ignore
	 */
	protected function &GetInputParams($id, $name)
	{
		$name   = str_replace(' ','_',$name);
		$params = array(
			'id'                       => $id,
			'name'                     => $name,
			'module'                   => $this->GetName(),
			'start_dir'                => '',
			'feu_access'               => jmfp_utils::CleanArray(explode(',', $this->GetPreference('feu_access'))),
			'restrict_users_diraccess' => intval($this->GetPreference('restrict_users_diraccess', false)),
			'prompt'                   => '',
			'media_type'               => 'image',
			'file_extensions'          => array('jpg','jpeg','gif','png'),
			'exclude_prefix'           => '',
			'exclude_sufix'            => '',
			'include_prefix'           => '',
			'include_sufix'            => '',
			'show_subdirs'             => intval($this->_isAdmin),
			'mode'                     => 'dropdown',
			'allow_none'               => true,
			'lock_input'               => intval(!$this->_isAdmin),
			'upload'                   => intval($this->_isAdmin || ($this->GetPreference('show_filemanagement', false) && $this->CheckPermission('Modify Files'))),
			'delete'                   => intval($this->_isAdmin || ($this->GetPreference('show_filemanagement', false) && $this->CheckPermission('Modify Files'))),
			'create_dirs'              => intval($this->_isAdmin || ($this->GetPreference('show_filemanagement', false) && $this->CheckPermission('Modify Files'))),
			'add_txt'                  => '',
			'size'                     => '',
			'maxlength'                => '',
			'scaling_width'            => intval($this->GetPreference('scaling_width', '')),
			'scaling_height'           => intval($this->GetPreference('scaling_height', '')),
			'show_thumbfiles'          => intval($this->GetPreference('show_thumbfiles', false)),
			'allow_scaling'            => intval($this->GetPreference('allow_scaling', false) || $this->_isAdmin),
			'create_thumbs'            => intval($this->GetPreference('create_thumbs', true)),
			'allow_upscaling'          => intval($this->GetPreference('allow_upscaling', false) || $this->_isAdmin),
			'force_scaling'            => intval($this->GetPreference('force_scaling',false)),
			'keep_aspect_ratio'        => intval($this->GetPreference('keep_aspectratio',true)));
		
		global $CMS_ADMIN_PAGE;
		$config = cmsms()->GetConfig();
		$result = false;
		if(isset($CMS_ADMIN_PAGE) && $CMS_ADMIN_PAGE == 1)
		{
			check_login();
			if(!$this->CheckPermission('Use JMFilePicker'))
				return $result;
			if(!$this->_isAdmin && $params['restrict_users_diraccess'])
				$params['start_dir'] = $this->_username;
			
			$params['input_template'] = 'themes/'.$this->GetPreference('default_admin_theme','Default-AJAX').'/input.tpl';
			$params['filebrowser_template'] = 'themes/'.$this->GetPreference('default_admin_theme','Default-AJAX').'/filebrowser.tpl';
			$params['upload_template'] = 'themes/'.$this->GetPreference('default_admin_theme','Default-AJAX').'/upload.tpl';
			$params['header_template'] = 'themes/'.$this->GetPreference('default_admin_theme','Default-AJAX').'/header.tpl';
		}
		else
		{
			if( !$feusers = cmsms()->GetModuleInstance('FrontEndUsers' ) )
				return $result;
			if(!$userid = $feusers->LoggedInId())
				return $result;
			if(!$groups = $feusers->GetMemberGroupsArray($userid))
				return $result;
			
			$access = false;
			foreach($groups as $_group)
			{
				if(in_array($_group['groupid'], $params['feu_access']))
				{
					$access = true;
					break;
				}
			}
			if(!$access)
				return $result;
			
			$params['input_template'] = 'themes/'.$this->GetPreference('default_frontend_theme','Default-AJAX').'/input.tpl';
			$params['filebrowser_template'] = 'themes/'.$this->GetPreference('default_frontend_theme','Default-AJAX').'/filebrowser.tpl';
			$params['upload_template'] = 'themes/'.$this->GetPreference('default_frontend_theme','Default-AJAX').'/upload.tpl';
			$params['header_template'] = 'themes/'.$this->GetPreference('default_frontend_theme','Default-AJAX').'/header.tpl';
			$params['restrict_users_diraccess'] = true;
			$params['start_dir'] = $feusers->GetPreference('image_destination_path', 'feusers') . '/' . $feusers->GetUserName($userid);
		}
		
		if(isset($_SESSION['JMFP_' . ($id == '' ? 'm1_' : $id).$name]))
		{
			$params = array_merge($params, $_SESSION['JMFP_' . ($id == '' ? 'm1_' : $id).$name]);
			return $params;
		}
		
		return $params;
	}
	
	
	/**
	 * Return an array containing a list of files in a directory related to a certain input.<br />
	 * Performs a non recursive search.
	 *
	 * @since 1.1
	 * @access public
	 *
	 * @param string $id - the id of the moduleinstance that creates the filepicker input
	 * @param string $name - the name of the input field
	 * @param string $dir - the directory to list the files of (may be relative to uploads dir or absolute path)
	 *
	 * @return array
	 */
	public function &GetInputFiles($id, $name, $dir)
	{
		$params =& $this->GetInputParams($id, $name);
		return jmfp_utils::GetFiles($dir, $params['exclude_prefix'],
			$params['include_prefix'], $params['exclude_sufix'],
			$params['include_sufix'], $params['file_extensions'],
			$params['media_type'], ($params['mode'] == 'dropdown' ? true : !$params['show_subdirs']), $params['show_thumbfiles'],
			$params['create_thumbs']);
	}
	
	
	/**
	 * Indicates if JMFilePicker output is already done<br />
	 * can be useful to avoid ouput of javascript and css twice
	 *
	 * @since 1.1
	 * @access public
	 *
	 * @return bool - true if output done; false if not
	 */
	public function Loaded()
	{
		return $this->_loaded;
	}
	
	
	/**
	 * Processes given value using smarty
	 * @since 1.2.9
	 * @access public
	 *
	 * @param string $tpl - the value to process by smarty
	 * @return string - the processed value
	 * @ignore
	 */
	public function DoSmarty($tpl)
	{
	  
		if(!is_array($tpl) && !is_object($tpl) && preg_match_all('/:::([^:]+):::/', $tpl, $matches))
		{
			if(isset($_GET['content_id']))
			{
				$manager =& cmsms()->GetHierarchyManager();
				$node = $manager->sureGetNodeByAlias($_GET['content_id']);
			}
			if(isset($node) && is_object($node))
			{
				$content =& $node->GetContent();
			}
			if(isset($content) && is_object($content) && $content->Type() != 'content2')
			{
				$smarty = cmsms()->GetSmarty();
				$smarty->assign('content_obj', $content);
				$smarty->assign('content_id', $content->Id());
				$smarty->assign('content_alias', $content->Alias());
				$smarty->assign('page', $content->Alias());
				$smarty->assign('page_id', $content->Alias());
				$smarty->assign('page_alias', $content->Alias());
				$smarty->assign('page_name', $content->Alias());
				$smarty->assign('position', $content->Hierarchy());
				$smarty->assign('friendly_position', cmsms()->GetContentOperations()->CreateFriendlyHierarchyPosition($content->Hierarchy()));
			}
			$tpl = $this->ProcessTemplateFromData(preg_replace('/:::([^:]+):::/', '{$1}', $tpl));
			#$tpl = $smarty->fetch('string:' . preg_replace('/:::([^:]+):::/', '{$1}', $tpl));
		}
		return $tpl;
	}
	
	
	/**
	 * Returns a list of available themes
	 * @since 1.2.9
	 * @access public
	 * @return array - the themes
	 * @deprecated
	 */
	public function GetThemesList()
	{
		$dir = cms_join_path(dirname(__FILE__), 'templates', 'themes') . DIRECTORY_SEPARATOR;
		$d   = dir($dir);
		$default_themes = array();
		while ($entry = $d->read())
		{
			if ($entry[0] == '.' 
				|| !is_dir($dir.$entry)
				|| !file_exists(cms_join_path($dir.$entry,'input.tpl'))
				|| !file_exists(cms_join_path($dir.$entry,'filebrowser.tpl'))
				|| !file_exists(cms_join_path($dir.$entry,'header.tpl')))
			{
				continue;
			}
			$default_themes[$entry] = $entry;
		}
		$d->close();
		asort($default_themes);
		return $default_themes;
	}
}
?>
