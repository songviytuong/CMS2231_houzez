<?php
#-------------------------------------------------------------------------
# LISE - List It Special Edition
# Version 1.2.2
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

/**
 * LISE Fielddef Base
 *
 * @package LISE
 * @author  Tapio Löytty
 * @since   1.0
 */
abstract class LISEFielddefBase implements ArrayAccess
{
  #---------------------
  # Constants
  #---------------------
  
  const TYPE_STRING = "string";
  const TYPE_ARRAY = "array";
  const TYPE_OBJECT = "object";
  const TYPE_TIMESTAMP = "timestamp";
  
  #---------------------
  # Variables
  #---------------------
  
  private $id;
  private $name;
  private $alias;
  private $description;
  private $type;
  private $friendlytype;
  private $value;
  private $originator;
  private $active;
  private $disabled;
  private $path;
  private $position;
  private $required;
  private $options;
  private $caller;
  private $item_id; // deprecated
  private $parent_array;
  private $template;
  private $view;
  private $hastemplate;
  
  protected $event_handler;
  
  #---------------------
  # Magic methods
  #---------------------
  
  public function __construct(&$db_info, $caller_object = NULL)
  {
    $this->id           = -1;
    $this->name         = '';
    $this->alias        = '';
    $this->description  = '';
    $this->type         = $db_info->type;
    $this->originator   = $db_info->originator;
    $this->active       = $db_info->active;
    $this->disabled     = $db_info->disabled;
    $this->path         = $db_info->path;
    $this->friendlytype = $db_info->type;
    $this->value        = new LISEFielddefValue;
    $this->position     = -1;
    $this->required     = 0;
    $this->options      = array();
    $this->caller       = NULL;
    $this->item_id      = -1;
    $this->hastemplate  = FALSE;
    $this->template     = NULL;
    $this->_get_default_template();
    
    if($caller_object instanceof CMSModule)
    {
      $this->caller = $caller_object->GetName();
    }
  }
  
  public function __get($key)
  {
    return $this->_overwrite_constants($key);
  }
  
  public function __toString()
  {
    return (string)$this->value;
  }
  
  public function __call($name, $args)
  {
    return FALSE;
  }
  
  #---------------------
  # Array methods
  #---------------------
  
  public function offsetGet($offset)
  {
    return $this->_overwrite_constants($offset);
  }
  
  public function offsetSet($offset, $value){ }
  
  public function offsetExists($offset){ }
  
  public function offsetUnset($offset){ }
  
  #---------------------
  # Private methods
  #---------------------
  
  /**
   * limits the property access to:
   * name, value, type, alias, template and view
   * mostly when called from a template
   *
   * @param mixed $key
   *
   * @return mixed|null|string
   */
  private function _overwrite_constants($key)
  {
    switch($key)
    {
      case 'name':
        return $this->GetName();
      
      case 'value':
        return $this->GetValue(self::TYPE_STRING);
      
      case 'type':
        return $this->GetType();
      
      case 'alias':
        return $this->GetAlias();
      
      case 'template':
        return $this->GetTemplate();
      
      case 'view':
        return $this->FrontEndRender();
      
      default:
        return NULL;
    }
  }
  
  private function _get_default_template()
  {
    $fn = $this->GetPath() . DIRECTORY_SEPARATOR . 'output.' . $this->GetType() . '.tpl';
    
    if(is_readable($fn))
    {
      $this->template    = @file_get_contents($fn);
      $this->hastemplate = TRUE;
    }
    
    return $this->hastemplate;
  }
  
  #---------------------
  # get/set methods
  #---------------------
  
  public final function GetId()
  {
    return $this->id;
  }
  
  public final function SetId($value)
  {
    $this->id = $value;
  }
  
  public final function GetName()
  {
    return $this->name;
  }
  
  public final function SetName($value)
  {
    $this->name = $value;
  }
  
  public final function GetAlias()
  {
    return $this->alias;
  }
  
  public final function SetAlias($value)
  {
    $this->alias = $value;
  }
  
  public final function GetDesc()
  {
    return $this->description;
  }
  
  public final function SetDesc($value)
  {
    $this->description = $value;
  }
  
  public final function GetType()
  {
    return $this->type;
  }
  
  public final function GetFriendlyType()
  {
    return $this->friendlytype;
  }
  
  public final function SetFriendlyType($value)
  {
    $this->friendlytype = $value;
  }
  
  public final function HasValue()
  {
    if($this->GetValue(self::TYPE_STRING) !== '')
    {
      return TRUE;
    }
    
    return FALSE;
  }
  
  public final function GetValue($type = self::TYPE_OBJECT)
  {
    $type = strtolower($type);
    
    switch($type)
    {
      case self::TYPE_STRING:
        return (string)$this->value;
      
      case self::TYPE_ARRAY:
        return (array)$this->value;
      
      case self::TYPE_TIMESTAMP:
        return strtotime((string)$this->value);
      
      default:
        return $this->value;
    }
  }
  
  public final function SetValue($value = array())
  {
    $this->value = new LISEFielddefValue($value);
  }
  
  public final function GetOriginator()
  {
    return $this->originator;
  }
  
  public final function IsActive()
  {
    return $this->active ? TRUE : FALSE;
  }
  
  public final function IsDisabled()
  {
    return $this->disabled ? TRUE : FALSE;
  }
  
  // deprecated
  public final function GetActive()
  {
    return $this->active;
  }
  
  public final function GetPosition()
  {
    return $this->position;
  }
  
  public final function SetPosition($value)
  {
    $this->position = $value;
  }
  
  public final function GetPath()
  {
    return $this->path;
  }
  
  public final function GetURLPath()
  {
    $config = cmsms()->GetConfig();
    
    $url = substr($this->GetPath(), strlen($config['root_path']));
    $url = str_replace(DIRECTORY_SEPARATOR, '/', $url);
    $url = $config->smart_root_url() . $url;
    
    return $url;
  }
  
  public final function IsRequired()
  {
    return $this->required ? TRUE : FALSE;
  }
  
  public final function GetRequired()
  {
    return $this->required;
  }
  
  public final function SetRequired($value)
  {
    $this->required = $value;
  }
  
  public final function GetItemId()
  {
    return $this->GetParentItem()->item_id;
  }
  
  public final function GetItemAlias()
  {
    return $this->GetParentItem()->alias;
  }
  
  // deprecated
  public final function SetItemId($value)
  {
    $this->item_id = $value;
  }
  
  public final function GetParentArray()
  {
    if(isset($this->parent_array))
    {
      return $this->parent_array;
    }
    
    return FALSE;
  }
  
  public final function SetParentArray(LISEFielddefArray &$obj)
  {
    $this->parent_array = $obj;
  }
  
  public final function GetParentItem()
  {
    if($this->GetParentArray())
    {
      if($this->GetParentArray()->GetParentItem())
      {
        return $this->GetParentArray()->GetParentItem();
      }
    }
    
    return FALSE;
  }
  
  public final function SetTemplate($content)
  {
    $this->template = $content;
  }
  
  public final function GetTemplate()
  {
    return $this->template;
  }
  
  public final function HasTemplate()
  {
    return $this->hastemplate;
  }
  
  #---------------------
  # Option methods
  #---------------------
  
  public final function GetOptionValues()
  {
    return $this->options;
  }
  
  public final function GetOptionValue($key, $default = '')
  {
    return isset($this->options[$key]) ? $this->options[$key] : $default;
  }
  
  public final function SetOptionValue($key, $value)
  {
    $this->options[$key] = $value;
  }
  
  #---------------------
  # Overwrite methods
  #---------------------
  
  static public function GetModuleDeps()
  {
    return NULL;
  }
  
  public function GetHeaderHTML()
  {
    $ret = NULL;
    
    $fn = $this->GetPath() . DIRECTORY_SEPARATOR . 'header.' . $this->GetType() . '.tpl';
    
    if(is_readable($fn))
    {
      $ret    = @file_get_contents($fn);
      $smarty = cmsms()->GetSmarty();
      $smarty->assign('fielddefdir', $this->GetURLPath());
      $ret = $smarty->fetch('eval:' . $ret);
    }
    
    return $ret;
  }
  
  public function IsUnique()
  {
    return FALSE;
  }
  
  public function RenderForAdminListing($id, $returnid)
  {
    $rn = 'list.' . $this->GetType() . '.tpl';
    $fn = $this->GetPath() . DIRECTORY_SEPARATOR . $rn;
    
    
    if( is_readable($fn) )
    {
      $smarty = cmsms()->GetSmarty();
      $smarty->assign('actionid', $id);
      $smarty->assign('returnid', $returnid);
  
      return $smarty->fetch('lisetemplate:fielddefs;' . $this->GetOriginator() . ';'  . $rn);
    }
    
    return $this->GetValue(self::TYPE_STRING);
  }
  
  public function RenderForEdit($id, $returnid)
  {
    $rn = 'admin.' . $this->GetType() . '.tpl';
    $fn = $this->GetPath() . DIRECTORY_SEPARATOR . $rn;
    
    if( is_readable($fn) )
    {
      $smarty = cmsms()->GetSmarty();
      $smarty->assign('actionid', $id);
      $smarty->assign('returnid', $returnid);
      return $smarty->fetch('lisetemplate:fielddefs;' . $this->GetOriginator() . ';'  . $rn);}
    
    return '';
  }
  
  public function RenderInput($id, $returnid)
  {
    $rn = 'input.' . $this->GetType() . '.tpl';
    $fn = $this->GetPath() . DIRECTORY_SEPARATOR . $rn;
    
    if( is_readable($fn) )
    {
      $smarty = cmsms()->GetSmarty();
      $smarty->assign('actionid', $id);
      $smarty->assign('returnid', $returnid);
      return $smarty->fetch('lisetemplate:fielddefs;' . $this->GetOriginator() . ';'  . $rn);
    }
    
    return '';
  }
  
  public function FrontEndRender($params = array())
  {
    if(empty($this->view) && $this->hastemplate)
    {
      $smarty = cmsms()->GetSmarty();
      $smarty->assign('name', $this->name);
      $smarty->assign('value', $this->value);
      $smarty->assign('type', $this->type);
      $smarty->assign('alias', $this->alias);
      $smarty->assign('params', $params);
      $this->view = $smarty->fetch('string:' . $this->GetTemplate());
    }
    else
    {
      $this->view = '';
    }
    
    return $this->view;
  }
  
  /**
   * a shorter alias to FrontEndRender() method
   */
  public function View($params = array())
  {
    return $this->FrontEndRender($params);
  }
  
  public function Validate(&$errors)
  {
    if($this->GetValue(self::TYPE_STRING) == '' && $this->IsRequired())
    {
      $errors[] = $this->ModLang('required_field_empty') . ' (' . $this->GetName() . ')';
    }
  }
  
  #---------------------
  # Event handler
  #---------------------
  
  /************************************
   * NOTICE: Highly experimental
   ************************************/
  
  // Should i make this final or not, lets leave it like this for now.
  public function EventHandler()
  {
    // Check if field has own event handler
    if(!isset($this->event_handler))
    {
      
      $fn = $this->GetPath() . DIRECTORY_SEPARATOR . 'liseeh.' . $this->GetType() . '.php';
      if(is_readable($fn))
      {
        
        require_once($fn);
        
        $class = 'liseeh_' . $this->GetType();
        if(class_exists($class))
        {
          $this->event_handler = new $class($this);
        }
      }
    }
    
    // Ensure that we have default event handler
    if(!isset($this->event_handler))
    {
      $this->event_handler = new LISEEventHandlerBase($this);
    }
    
    return $this->event_handler;
  }
  
  #---------------------
  # Module methods
  #---------------------
  
  public final function GetModuleInstance($caller = FALSE)
  {
    if($caller && !is_null($this->caller))
    {
      return cmsms()->GetModuleInstance($this->caller);
    }
    
    return cmsms()->GetModuleInstance($this->originator);
  }
  
  #---------------------
  # Lang methods
  #---------------------
  
  public final function ModLang()
  {
    $mod = $this->GetModuleInstance();
    if(!is_object($mod))
    {
      throw new \LISE\Exception('Could not retrive module instance from originator!');
    }
    //throw new LISEException('Could not retrive module instance from originator!'); // <- Send own missing lang string instead of failure?
    $args = func_get_args();
    
    return call_user_func_array(array($mod, 'lang'), $args);
  }
  
} // end of class

/**
 * LISE Fielddef value
 *
 * @package LISE
 * @author  Tapio L
 * @since   1.3.1
 */
class LISEFielddefValue extends ArrayObject
{
  #---------------------
  # Magic methods
  #---------------------
  
  public function __construct($array = array())
  {
    foreach((array)$array as $key => $value)
    {
      
      $this->offsetSet($key, $value);
    }
  }
  
  public function __toString()
  {
    return (string)implode(LISE_VALUE_SEPARATOR, (array)$this);
  }
  
} // end of class
?>
