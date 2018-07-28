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
if( !defined('CMS_VERSION') ) exit;

if(!$this->CheckPermission($this->_GetModuleAlias() . '_modify_option')) return;

#---------------------
# Init params
#---------------------
if(isset($params['cancel'])) 
{
  $params = array('active_tab' => 'fielddeftab');
  $this->Redirect($id, 'defaultadmin', $returnid, $params);
}

#---------------------
# Init variables
#---------------------
$type             = lise_utils::init_var('type', $params, null);
$fielddef_id      = lise_utils::init_var('fielddef_id', $params, null);
$name             = lise_utils::init_var('name', $params, '');
$alias            = lise_utils::init_var('alias', $params, '');
$help             = lise_utils::init_var('help', $params, '');
$custom_input     = lise_utils::init_var('custom_input', $params, array());
$extra            = lise_utils::init_var('extra', $params, ''); // <- (Remove this in 1.5)???
$required         = isset($params['required']) ? 1 : 0;
$template         = lise_utils::init_var('template', $params, '');

#---------------------
# Init field object
#---------------------

// Load fielddef from database
if(!empty( $fielddef_id) ) 
{
  $fielddef_obj = LISEFielddefOperations::Load($this, 'fielddef_id', $fielddef_id);
} 
// Load fielddef from type
elseif( !empty($type) ) 
{
  $fielddef_obj = LISEFielddefOperations::LoadFielddefByType($type);
}

if( isset($fielddef_obj) && empty($template) ) $template = $fielddef_obj->GetTemplate();



#---------------------
# Fill options
#---------------------

//Handle field options - Check if moving this here has some weird reaction
if(count($custom_input) > 0)
{
  foreach($custom_input as $key => $value) 
  {
    $fielddef_obj->SetOptionValue($key, $value);
  }
}

#---------------------
# Submit
#---------------------

if(isset($params['submit']) || isset($params['apply']) || isset($params['save_create'])) 
{

  $errors  = array();

    // check type
    if(!isset($fielddef_obj)) 
    {
      $errors[] = $this->ModLang('fielddef_type_notset');
    }  
  
    // check name
    if($name == '') 
    {
      $errors[] = $this->ModLang('fielddef_name_empty');
    }

    if( isset($fielddef_id) )
    {      
      $query = 'SELECT fielddef_id FROM ' . cms_db_prefix() . 'module_' . $this->_GetModuleAlias() . '_fielddef WHERE alias = ? AND fielddef_id != ?';
      $exists = $db->GetOne($query, array($alias, $fielddef_id));
    }
    else 
    {
      $query = 'SELECT fielddef_id FROM ' . cms_db_prefix() . 'module_' . $this->_GetModuleAlias() . '_fielddef WHERE alias = ?';
      $exists = $db->GetOne($query, array($alias));
    }  

    // check alias
    if(!lise_utils::is_valid_alias($alias) && !empty($alias)) 
    {
      $errors[] = $this->ModLang('alias_invalid');
    }
    else
    {
      if( 
          isset($fielddef_id) 
          && !empty($alias) 
          && $alias != $fielddef_obj->GetAlias() 
          && LISEFielddefOperations::Load($this, 'alias', $alias) != false
          && $exists
        ) 
        {
          $errors[] = $this->ModLang('alias_duplicate');
        }
    }

    if($exists)
    {
      $errors[] = $this->ModLang('fielddef_alias_exists');
    }
  
  // Do error check that requires object
    if(empty($errors)) 
    { 
      // check if unique
      $type_exists = LISEFielddefOperations::TestExistanceByType($this, $fielddef_obj->GetType());
      
      if($type_exists && $type_exists != $fielddef_obj->GetId() && $fielddef_obj->IsUnique())
      {
        $errors[] = $this->ModLang('fielddef_is_unique'); 
      }
    }
  
  // Do actual error check
  if (empty($errors)) 
  {
    $fielddef_obj->SetName($name);
    $fielddef_obj->SetAlias($alias);
    $fielddef_obj->SetDesc($help);
    $fielddef_obj->SetRequired($required);  
    $fielddef_obj->SetTemplate($template);
  
    //Handle field options - Check if moving this here has some weird reaction
    if(count($custom_input) > 0) 
    {

      foreach($custom_input as $key => $value) 
      {
      // handle array values
        if( is_array($value) )
        {
          $fielddef_obj->SetOptionValue( $key, implode(',', $value) );
        }
        else
        {
          $fielddef_obj->SetOptionValue($key, $value); 
        }
      }
    } 
  
    // Update extra (Remove this in 1.5)???
    if($fielddef_id > 0) 
    {
    
      $query = 'UPDATE ' . cms_db_prefix() . 'module_' . $this->_GetModuleAlias() . '_fielddef SET extra = ? WHERE fielddef_id = ?';    
      $result = $db->Execute($query, array($extra, $fielddef_id));
      
      if (!$result) 
        //die('FATAL SQL ERROR: ' . $db->ErrorMsg() . '<br/>QUERY: ' . $db->sql);    
        throw new \LISE\Exception($db->ErrorNo() . ' - ' . $db->ErrorMsg() . ' - Query: ' . $db->sql, \LISE\Error::DISCRETE_DB );  
    }
    
    // Save field
    LISEFielddefOperations::Save($this, $fielddef_obj);
  
    // if apply and ajax           
    if(isset($params['apply']) && isset($params['ajax'])) {
      $response = '<EditItem>';
      $response .= '<Response>Success</Response>';
      $response .= '<Details><![CDATA[' . $this->ModLang('changessaved') . ']]></Details>';               
      $response .= '</EditItem>';
      echo $response;
      return;
    } 
    
    // if save and create new
    if(isset($params['save_create']) ) {
      $this->Redirect($id, 'admin_editfielddef', $returnid, array(
        'message' => 'savecreate_message'
      ));
    }          

    // show saved message
    if(isset($params['submit'])) {
      $this->Redirect($id, 'defaultadmin', $returnid, array(
        'active_tab' => 'fielddeftab',
        'message' => 'changessaved'
      ));
      
    } else {
      echo $this->ShowMessage($this->ModLang('changessaved'));
    }  
  
  } // end error check
  
} // end submit or apply
elseif(isset($fielddef_obj) && $fielddef_id > 0) 
{
  $type         = $fielddef_obj->GetType();
  $name         = $fielddef_obj->GetName();
  $alias        = $fielddef_obj->GetAlias();
  $help         = $fielddef_obj->GetDesc();
  $required     = $fielddef_obj->IsRequired();
  $template     = $fielddef_obj->GetTemplate();
}

#---------------------
# Load instructions (Remove this in 1.5)????
#---------------------

$query = 'SELECT extra FROM ' . cms_db_prefix() . 'module_' . $this->_GetModuleAlias() . '_fielddef WHERE fielddef_id = ?';
$extra = $db->GetOne($query, array($fielddef_id));

if($extra && !empty($extra)) 
{
  $smarty->assign('input_extra', $this->CreateTextArea(false, $id, $extra, 'extra'));
}  

#---------------------
# Message control
#---------------------

// display errors if there are any
if (!empty($errors)) {
    if (isset($params['apply']) && isset($params['ajax'])) {
        $response = '<EditItem>';
        $response .= '<Response>Error</Response>';
        $response .= '<Details><![CDATA[';
        foreach ($errors as $error) {
            $response .= '<li>' . $error . '</li>';
        }
        $response .= ']]></Details>';
        $response .= '</EditItem>';
        echo $response;
        return;
    } else {
        echo $this->ShowErrors($errors);
    }
}

if(isset($params['message']) && empty($errors)) 
    echo $this->ShowMessage($this->ModLang('changessaved_create'));
  
#---------------------
# Smarty processing
#---------------------

unset($params['submit']); // ???
unset($params['apply']); // ???

if(isset($fielddef_obj))
  $smarty->assign('fielddef', $fielddef_obj);

if(isset($fielddef_obj) && $fielddef_id > 0) {
  $smarty->assign('inputtype', $fielddef_obj->GetFriendlyType()); // <- Assign static text, as this type is saved  
}
else {
  $fielddefs = array_merge(array($this->ModLang('select_one')=>null), LISEFielddefOperations::GetFielddefTypes());
  $smarty->assign('inputtype', $this->CreateInputDropdown($id, 'type', $fielddefs, -1, $type, 'id="m1_type"')); // <- Assign dropdown
}

$smarty->assign('inputname', $this->CreateInputText($id, 'name', $name, 20, 255));
$smarty->assign('input_alias', $this->CreateInputText($id, 'alias', $alias, 20, 255));
$smarty->assign('inputhelp', $this->CreateInputText($id, 'help', $help, 100, 255));
$smarty->assign('input_required', $this->CreateInputcheckbox($id, 'required', 1, $required));
$smarty->assign('backlink', $this->CreateBackLink('fielddeftab'));
$smarty->assign('input_template', $this->CreateSyntaxArea($id, $template, 'template'));
$smarty->assign('title',     (isset($fielddef_id) ? $this->ModLang('editfielddef') : $this->ModLang('add', $this->ModLang('fielddef'))));
$smarty->assign('startform', $this->CreateFormStart($id, 'admin_editfielddef', $returnid, 'post', 'multipart/form-data', false, '', $params));
$smarty->assign('endform',   $this->CreateFormEnd());

echo $this->ModProcessTemplate('editfielddef.tpl');

?>