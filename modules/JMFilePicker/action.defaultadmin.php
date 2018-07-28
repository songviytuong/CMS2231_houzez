<?php
#-------------------------------------------------------------------------------
#
# Fork of: GBFilePicker (c) 2010-2012 by Georg Busch (georg.busch@gmx.net)
#          a file picker tool for CMS Made Simple
#          The projects homepage is dev.cmsmadesimple.org/projects/gbfilepicker
#          CMS Made Simple is (c) 2004-2012 by Ted Kulp
#          The projects homepage is: http://www.cmsmadesimple.org
# Version: 1.3.3
# File   : action.defaultadmin.php
# Purpose: display module admin panel
# License: GPL
#
#-------------------------------------------------------------------------------
if(!function_exists('cmsms') || !is_object(cmsms())) exit;

$config = cmsms()->GetConfig();
$active_tab = 'prefs';

if(isset($params['active_tab']))
  $active_tab = $params['active_tab'];

$errormessage = '';
if(isset($params['errormessage']))
  $errormessage .= $params['errormessage'].'<br />';

$message = '';
if(isset($params['message']))
  $message .= $params['message'].'<br />';

$tabs = array();

if($this->CheckPermission('Manage JMFilePicker'))
{
  $tabs['prefs']['tabheader'] = $this->SetTabHeader('prefs',
    $this->lang('prefs'),
    ($active_tab=='prefs'?true:''));
 
  $smarty->assign('startForm', $this->CreateFormStart($id,
    'savePrefs', $returnid,'post','multipart/form-data'));
  $smarty->assign('endForm', $this->CreateFormEnd());
  
  $smarty->assign('show_filemanagement_text', $this->lang('show_filemanagement'));
  $smarty->assign('show_filemanagement_input',
    $this->CreateInputHidden($id,'show_filemanagement',0) .
    $this->CreateInputCheckbox($id, 'show_filemanagement', '1',
      $this->GetPreference('show_filemanagement')));
  
  $smarty->assign('show_thumbfiles_text', $this->lang('show_thumbfiles'));
  $smarty->assign('show_thumbfiles_input',
    $this->CreateInputHidden($id,'show_thumbfiles',0) .
    $this->CreateInputCheckbox($id, 'show_thumbfiles', '1',
      $this->GetPreference('show_thumbfiles')));
  
  $smarty->assign('allow_scaling_text', $this->lang('allow_scaling'));
  $smarty->assign('allow_scaling_input',
    $this->CreateInputHidden($id,'allow_scaling',0) .
    $this->CreateInputCheckbox($id, 'allow_scaling', '1',
      $this->GetPreference('allow_scaling')));
  
  $smarty->assign('restrict_users_diraccess_text', $this->lang('restrict_users_diraccess'));
  $smarty->assign('restrict_users_diraccess_input',
    $this->CreateInputHidden($id,'restrict_users_diraccess',0) .
    $this->CreateInputCheckbox($id, 'restrict_users_diraccess', '1',
      $this->GetPreference('restrict_users_diraccess')));
  
  $smarty->assign('create_thumbs_text', $this->lang('create_thumbs'));
  $smarty->assign('create_thumbs_input',
    $this->CreateInputHidden($id,'create_thumbs',0) .
    $this->CreateInputCheckbox($id, 'create_thumbs', '1',
      $this->GetPreference('create_thumbs')));
  
  $smarty->assign('allow_upscaling_text', $this->lang('allow_upscaling'));
  $smarty->assign('allow_upscaling_input',
    $this->CreateInputHidden($id,'allow_upscaling',0) .
    $this->CreateInputCheckbox($id, 'allow_upscaling', '1',
      $this->GetPreference('allow_upscaling')));
  
  $fileType = strtolower(jmfp_utils::GetFileType(cms_join_path($config['root_path'],'modules','JMFilePicker','images','fileicon.gif'),true));
  $smarty->assign('use_mimetype_text', $this->lang('use_mimetype'));
  $smarty->assign('use_mimetype_input',
    $this->CreateInputHidden($id,'use_mimetype',0) .
    $this->CreateInputCheckbox($id, 'use_mimetype', '1',
      ($fileType != 'image/gif'?$this->SetPreference('use_mimetype',0):$this->GetPreference('use_mimetype')), ($fileType != 'image/gif'?' disabled="disabled"':'')) .
    ($fileType == 'image/gif'?'':$this->lang('no_mimetype')));
  
  $smarty->assign('scaling_width_text', $this->lang('scaling_width'));
  $smarty->assign('scaling_width_input',
    $this->CreateInputText($id, 'scaling_width',
      $this->GetPreference('scaling_width'), 5, 4));
  
  $smarty->assign('scaling_height_text', $this->lang('scaling_height'));
  $smarty->assign('scaling_height_input',
    $this->CreateInputText($id, 'scaling_height',
      $this->GetPreference('scaling_height'), 5, 4));
  
  $smarty->assign('demo_text', $this->lang('demo'));
  $smarty->assign('settings_text', $this->lang('settings'));
  
  $smarty->assign('force_scaling_text', $this->lang('force_scaling'));
  $smarty->assign('force_scaling_input',
    $this->CreateInputHidden($id,'force_scaling',0) .
    $this->CreateInputCheckbox($id, 'force_scaling', '1',
      $this->GetPreference('force_scaling')));
  
  $smarty->assign('thumb_upload_action_text', $this->lang('thumb_upload_action'));
  $smarty->assign('thumb_upload_action_input',
    $this->CreateInputDropdown($id, 'thumb_upload_action', 
      array(
        lang('no') => null, 
        lang('yes') => 1
      ), 
      null,
      $this->GetPreference('thumb_upload_action'),
      'id="jmfp_thumb_upload_action"'
    )
  );
  $smarty->assign('thumb_upload_action', 
    $this->GetPreference('thumb_upload_action')
  );
  $smarty->assign('thumb_prefix_replacement_text', 
    $this->lang('thumb_prefix_replacement')
  );
  $smarty->assign('thumb_prefix_replacement_input',
    $this->CreateInputText($id, 'thumb_prefix_replacement',
      $this->GetPreference('thumb_prefix_replacement')
    )
  );
  $smarty->assign('default_admin_theme_text', $this->lang('default_admin_theme'));
  $smarty->assign('default_admin_theme_input',
    $this->CreateInputDropdown($id, 'default_admin_theme', 
      $this->GetThemesList(), '',
      $this->GetPreference('default_admin_theme','Default-AJAX')
    )
  );
  if( $feusers = cmsms()->GetModuleInstance('FrontEndUsers') ) {
    $groups = $feusers->GetGroupList();
    $smarty->assign( 'feu_access_text', $this->lang('feu_access') );
    $smarty->assign('feu_access_input',
      $this->CreateInputHidden($id,'feu_access','').
      $this->CreateInputSelectList($id,'feu_access[]',$groups,
        jmfp_utils::CleanArray(explode(',',$this->GetPreference('feu_access'))),
      count($groups),'',1));
    
    $smarty->assign('default_frontend_theme_text', $this->lang('default_frontend_theme'));
    $smarty->assign('default_frontend_theme_input',
    $this->CreateInputDropdown($id, 'default_frontend_theme', $this->GetThemesList(), '',
      $this->GetPreference('default_frontend_theme','Default-AJAX')));
  
  }
  $smarty->assign('submit_ajax', $this->CreateInputSubmit($id, 'submit',
    lang('submit'),'onClick="return JMFP.SubmitForm(this,\'JMFP_Result\')"'));
  
  $smarty->assign('submit', $this->CreateInputSubmit($id, 'submit', lang('submit')));
  
  $tabs['prefs']['tabcontent'] = $this->StartTab('prefs') .
    $this->ProcessTemplate('prefstab.tpl') .
    $this->EndTab();
}

if($this->CheckPermission('Use JMFilePicker'))
{
  $tabs['demo']['tabheader'] = $this->SetTabHeader('demo',
    $this->lang('demo'),
    ($active_tab=='demo'?true:''));
  
  // image dropdown
  $smarty->assign('imagedropdown_text', $this->lang('imagedropdown_example',str_replace($config['root_url'],'',$config['uploads_url']).'/images'));
  $smarty->assign('imagedropdown_input', $this->CreateFilePickerInput($this, $id,'JMFilePicker_image_dropdown','',array('dir'=>'images')));
  
  // image browser
  $smarty->assign('imagebrowser_text', $this->lang('imagebrowser_example',str_replace($config['root_url'],'',$config['uploads_url']).'/images'));
  $smarty->assign('imagebrowser_input',$this->CreateFilePickerInput($this,$id, 'JMFilePicker_image_filepicker','',array('dir'=>'images','mode'=>'browser')));
  
  // file dropdown
  $smarty->assign('filedropdown_text', $this->lang('filedropdown_example',str_replace($config['root_url'],'',$config['uploads_url']).'/'));
  $smarty->assign('filedropdown_input',$this->CreateFilePickerInput($this,$id, 'JMFilePicker_file_dropdown','',array('media_type'=>'file')));
  
  // file browser
  $smarty->assign('filebrowser_text', $this->lang('filebrowser_example',str_replace($config['root_url'],'',$config['uploads_url']).'/'));
  $smarty->assign('filebrowser_input',$this->CreateFilePickerInput($this,$id, 'JMFilePicker_file_filepicker','',array('media_type'=>'file','mode'=>'browser')));

  $tabs['demo']['tabcontent'] = $this->StartTab('demo') .
    $this->ProcessTemplate('demotab.tpl') .
    $this->EndTab();
}

$smarty->assign('tabs', $tabs);
$smarty->assign('start_tabheaders', $this->StartTabHeaders());
$smarty->assign('end_tabheaders', $this->EndTabHeaders());
$smarty->assign('start_tabcontent', $this->StartTabContent());
$smarty->assign('end_tabcontent', $this->EndTabContent());
$smarty->assign('end_tab', $this->EndTab());
$smarty->assign('module_id', $id);

if(isset($params['message']))
{
  $smarty->assign('message', $this->lang($params['message']));
}

if(isset($params['errormessage']))
{
  $smarty->assign('errormessage', $this->lang($params['errormessage']));
}

echo  $this->ProcessTemplate('defaultadmin.tpl');
?>
