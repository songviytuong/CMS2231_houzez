<?php

if( !defined('CMS_VERSION') ) exit;

if (!$this->CheckPermission($this->_GetModuleAlias() . '_modify_item')) return;

#---------------------
# Check params
#---------------------
#Start MLE
global $hls, $hl, $mleblock;
$thisURL = $_SERVER['SCRIPT_NAME'] . '?';
foreach ($_GET as $key => $val)
    if ('hl' != $key)
        $thisURL .= $key . '=' . $val . '&amp;';
if (isset($hls)) {
    $langList = ' &nbsp; &nbsp; ';
    foreach ($hls as $key => $mle) {
        $langList .= ($hl == $key) ? $mle['flag'] . ' ' : '<a href="' . $thisURL . 'hl=' . $key . '">' . $mle['flag'] . '</a> ';
    }
}
$smarty->assign('langList', $langList);
#End MLE

if (isset($params['cancel'])) {
    lise_utils::clean_params($params, array('page'), true);
    $params['active_tab'] = 'itemtab';
    $this->Redirect($id, 'defaultadmin', $returnid, $params);
}

#---------------------
# Init params
#---------------------

$mode = lise_utils::init_var('mode', $params, 'edit');
$item_id = lise_utils::init_var('item_id', $params, -1);
$url = lise_utils::init_var('url', $params, '');
$title = lise_utils::init_var('title', $params, '');
$desc = lise_utils::init_var('desc', $params, '');
$alias = lise_utils::init_var('alias', $params, '');

$key1 = lise_utils::init_var('extra1_enabled', $params, '');
$key2 = lise_utils::init_var('extra2_enabled', $params, '');
$key3 = lise_utils::init_var('extra3_enabled', $params, '');

$time_control = lise_utils::init_var('time_control', $params, 0);
$active = 1;

$time_control_turn = $this->GetPreference('time_control');
$extra1_enabled_turn = $this->GetPreference('extra1_enabled');
$extra2_enabled_turn = $this->GetPreference('extra2_enabled');
$extra3_enabled_turn = $this->GetPreference('extra3_enabled');

$extra1_enabled_wysiwyg = $this->GetPreference('extra1_enabled_wysiwyg');
$extra2_enabled_wysiwyg = $this->GetPreference('extra2_enabled_wysiwyg');
$extra3_enabled_wysiwyg = $this->GetPreference('extra3_enabled_wysiwyg');

$url_error = FALSE;
$start_time = '';
$end_time = '';

if ($time_control) 
{
    $start_time = $params['start_time'];
    $end_time   = $params['end_time'];
}

#---------------------
# Init Item
#---------------------

$obj = $this->LoadItemByIdentifier('item_id', $item_id, $mleblock);
if ($mode == 'copy')
    $obj = LISEItemOperations::Copy($obj);

#---------------------
# Handle custom fields
#---------------------

if (isset($params['customfield'])) 
{
  if( !is_array($params['customfield']) ) $params['customfield'] = array($params['customfield']);
  
	foreach ((array)$params['customfield'] as $fldid => $value) 
  {
		if(isset($obj->fielddefs[$fldid])) $obj->fielddefs[$fldid]->SetValue($value);	
	}
  
  unset($params['customfield']);
}

#---------------------
# Submit
#---------------------
$dxx = explode(",", $_REQUEST["mact"]);

if (isset($params['submit']) || isset($params['apply']) || isset($params['save_create'])) {
    
    

	$errors = array(); 
	
	// check title
	if (empty($title)) 
  {
		$errors[] = $this->ModLang('item_title_empty');
	}

  // check alias
  if (!lise_utils::is_valid_alias($alias) && !empty($alias))
  {
//    $errors[] = $this->ModLang('alias_invalid');
  }

	// Check for duplicate
    if ($item_id > 0)
    {
      $query = 'SELECT item_id FROM ' . cms_db_prefix() . 'module_' . $this->_GetModuleAlias() . '_item WHERE alias = ? AND item_id != ?';
      $exists = $db->GetOne($query, array($alias, $item_id));
    } 
    else 
    {	
      $query = 'SELECT item_id FROM ' . cms_db_prefix() . 'module_' . $this->_GetModuleAlias() . '_item WHERE alias = ?';
      $exists = $db->GetOne($query, array($alias));
    }	

    if ($exists)
    {
      $errors[] = $this->ModLang('item_alias_exists');
    }	

	// check if start date is less end date
	if ($time_control && $start_time && $end_time && strtotime($start_time) > strtotime($end_time))
  {
		$errors[] = $this->ModLang('error_startgreaterend');
	}
  
  // validate url format and route
  if( !empty($url) )
  {
    if( startswith($url,'/') || endswith($url,'/') ) 
    {
      $errors[] = $this->ModLang('item_url_invalid');
      $url = $obj->url;
      $url_error = TRUE;
    }
    else
    {
      $translated = munge_string_to_url($url, false, true);
      
      if( strtolower($translated) != strtolower($url) )
      {
        $errors[] = $this->ModLang('item_url_invalid');
        $url = $obj->url;
        $url_error = TRUE;
      } 
    }
    
    if(!$url_error)
    {
      $url = trim($url," /\t\r\n\0\x08");

      if($item_id == -1 || $url !== $obj->url)
      {
        cms_route_manager::load_routes();
        $route = cms_route_manager::find_match($url);
        
        if($route)
        { 
          $errors[] = $this->ModLang('item_url_invalid');
          $url = $obj->url;
          $url_error = TRUE;
        }
      }  
    }
  } 
	
	// PreProcess & Validations
	foreach($obj->fielddefs as $field)
  {
		$field->EventHandler()->ItemSavePreProcess($errors, $params);
	}
	
	// title and required fields have values, let's continue
	if (empty($errors)) 
  {
        $obj->title = $title;
        $obj->desc = $desc;
        $obj->alias = $alias;
        $obj->active = isset($params['active']) ? 1 : 0;
        $obj->start_time = $start_time;
        $obj->end_time = $end_time;
        $obj->url = $url;
        $obj->key1 = $key1;
        $obj->key2 = $key2;
        $obj->key3 = $key3;
        //$obj->categories	= $categories;
        //$obj->category_id = $category_id;
        // Save item to database
        $this->SaveItem($obj, $mleblock);

        // PostProcess
        foreach ($obj->fielddefs as $field) {
            $field->EventHandler()->ItemSavePostProcess($errors, $params);
        }

        // if apply and ajax     
        if (isset($params['apply']) && isset($params['ajax'])) {
            $module_fix = str_replace("LISE", "", $dxx[0]);    
            Events::SendEvent($dxx[0],'PreItemSave', array('proid' => &$item_id, 'module' => $module_fix, 'modified_date' => trim($db->DBTimeStamp(time()), "'")));
        
            $response = '<EditItem>';
            $response .= '<Response>Success</Response>';
            $response .= '<Details><![CDATA[' . $this->ModLang('changessaved') . ']]></Details>';
            $response .= '</EditItem>';
            echo $response;
            return;
        }

        // if save and create new
        if (isset($params['save_create'])) {
            $this->Redirect($id, 'admin_edititem', $returnid, array(
                'message' => 'savecreate_message'
            ));
        }

        // show saved message
        if (isset($params['submit'])) {
            lise_utils::clean_params($params, array('page'), true);
            $params['active_tab'] = 'itemtab';
            $params['message'] = 'changessaved';
            $this->Redirect($id, 'defaultadmin', $returnid, $params);
        } else {
            echo $this->ShowMessage($this->ModLang('changessaved'));
        }

        
    } // end error check
} // end submit or apply
elseif ($obj->item_id > 0 || $mode == 'copy') {

    $item_id = $obj->item_id;
    $title = $obj->title;
    $desc = $obj->desc;
    $alias = $obj->alias;
    $active = $obj->active;
    $start_time = $obj->start_time;
    $end_time = $obj->end_time;
    $url = $obj->url;
    $key1 = $obj->key1;
    $key2 = $obj->key2;
    $key3 = $obj->key3;

    if (!empty($start_time) || !empty($end_time)) {
        $time_control = 1;
    }
    //$categories	= $obj->categories;
    //$category_id 	= $obj->category_id;
}

#---------------------
# Message control
#---------------------

// display errors if there are any
if (!empty($errors)) 
{
  $formated_errors = '';
  
  foreach ($errors as $error) 
  {
    $formated_errors .= '<li>' . $error . '</li>';
  }
  
    if (isset($params['apply']) && isset($params['ajax'])) 
    {
      $response = '<EditItem>';
      $response .= '<Response>Error</Response>';
      $response .= '<Details><![CDATA[';
      $response .= $formated_errors;
      $response .= ']]></Details>';
      $response .= '</EditItem>';
      echo $response;
      return;
    }
    else
    {
      echo $this->ShowErrors('<ul>' . $formated_errors . '</ul>');
    }
}

if(isset($params['message']) && empty($errors)) 
    echo $this->ShowMessage($this->ModLang('changessaved_create'));

#---------------------
# Smarty processing
#---------------------

$smarty->assign('itemObject', $obj);

$ajax_url1 = $this->create_url($id, 'ajax_geturl', $returnid);
$ajax_url2 = $this->create_url($id, 'ajax_get_alias', $returnid);
$smarty->assign('ajax_get_url', $ajax_url1);
$smarty->assign('ajax_get_alias', $ajax_url2);

$smarty->assign('backlink', $this->CreateBackLink('itemtab'));
$smarty->assign('title', ($item_id > 0 ? $this->ModLang('edit') . ' ' . $this->GetPreference('item_singular', '') : $this->ModLang('add', $this->GetPreference('item_singular', ''))));
$item_name = ($item_id > 0 ? $title : '&laquo;' . $this->ModLang('untitled') . '&raquo;');
$header = $this->GetPreference('item_singular', '') . ': ' . $item_name;
$smarty->assign('header', $header);
$smarty->assign('startform', $this->CreateFormStart($id, 'admin_edititem', $returnid, 'post', 'multipart/form-data', false, '', $params));
$smarty->assign('endform', $this->CreateFormEnd());

$smarty->assign('input_title', $this->CreateInputText($id, 'title', $title, 50));
$smarty->assign('input_desc', $this->CreateTextArea(true, $id, $desc, 'desc', '', '', '', '', '80', '3'));
$smarty->assign('input_alias', $this->CreateInputText($id, 'alias', $alias, 50));
$smarty->assign('input_url', $this->CreateInputText($id, 'url', $url, 50));
$smarty->assign('input_time_control', $this->CreateInputcheckbox($id, 'time_control', 1, $time_control, 'onclick="togglecollapse(\'expiryinfo\');"'));
$smarty->assign('use_time_control', $time_control);
$smarty->assign('time_control_turn', $time_control_turn);
$smarty->assign('extra1_enabled_turn', $extra1_enabled_turn);
if($extra1_enabled_wysiwyg == 1){
    $smarty->assign('input_extra1_enabled', $this->CreateTextArea(true, $id, $key1, 'extra1_enabled', '', '', '', '', '80', '3'));
}
else {
    $smarty->assign('input_extra1_enabled', $this->CreateInputText($id, 'extra1_enabled', $key1, 50));
}

$smarty->assign('extra2_enabled_turn', $extra2_enabled_turn);

if($extra2_enabled_wysiwyg == 1){
    $smarty->assign('input_extra2_enabled', $this->CreateTextArea(true, $id, $key2, 'extra2_enabled', '', '', '', '', '80', '3'));
}
else {
    $smarty->assign('input_extra2_enabled', $this->CreateInputText($id, 'extra2_enabled', $key2, 50));
}

$smarty->assign('extra3_enabled_turn', $extra3_enabled_turn);

if($extra3_enabled_wysiwyg == 1){
    $smarty->assign('input_extra3_enabled', $this->CreateTextArea(true, $id, $key3, 'extra3_enabled', '', '', '', '', '80', '3'));
}
else {
    $smarty->assign('input_extra3_enabled', $this->CreateInputText($id, 'extra3_enabled', $key3, 50));
}

$smarty->assign('input_start_time', $this->CreateInputText($id, 'start_time', $start_time, 20));
$smarty->assign('input_end_time', $this->CreateInputText($id, 'end_time', $end_time, 20));

#Status: Active Languages
$language_status = active_languages();
if(isset($language_status)){
    $smarty->assign('activelang',$language_status);
}
#Status: End Active Languages

if($this->CheckPermission($this->_GetModuleAlias() . '_approve_item'))
	$smarty->assign('input_active', $this->CreateInputcheckbox($id, 'active', 1, $active));

echo $this->ModProcessTemplate('edititem.tpl');

?>