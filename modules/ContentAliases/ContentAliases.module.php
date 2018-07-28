<?php
#-------------------------------------------------------------------------
# Module: Content Aliases
# Version: 2.0, released August 2016
#
# Copyright (c) 2010 - 2016, Fernando Morgado (Jo Morg) <jomorg.morg@gmail.com>
# Copyright (c) 2008, Samuel Goldstein
#
#-------------------------------------------------------------------------
# CMS - CMS Made Simple is (c) 2008 by Ted Kulp (wishy@cmsmadesimple.org)
# This project's homepage is: http://www.cmsmadesimple.org
#
#-------------------------------------------------------------------------
#
# This program is free software; you can redistribute it and/or modify
# it under the terms of the GNU General Public License as published by
# the Free Software Foundation; either version 2 of the License, or
# (at your option) any later version.
#
# This program is distributed in the hope that it will be useful,
# but WITHOUT ANY WARRANTY; without even the implied warranty of
# MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
# GNU General Public License for more details.
# You should have received a copy of the GNU General Public License
# along with this program; if not, write to the Free Software
# Foundation, Inc., 59 Temple Place, Suite 330, Boston, MA 02111-1307 USA
# Or read it online: http://www.gnu.org/licenses/licenses.html#GPL
#
#-------------------------------------------------------------------------

class ContentAliases extends CMSModule
{
  function __construct() 
  {
    $this->CMSModule();
    $this->InstalledModules = array();
    parent::__construct();
    
    # just to make it CMSMS 2.0 compatible
    $this->myRegisterContentType(
                                  'ContentAlias',
                                  dirname(__FILE__) 
                                  . DIRECTORY_SEPARATOR 
                                  . 'lib' 
                                  . DIRECTORY_SEPARATOR 
                                  . 'contenttype.contentalias.php',
                                  'Content Alias'
                                 );      

  }
  
  function GetName()
  {
    return 'ContentAliases';
  }

  function GetFriendlyName()
  {
    return $this->Lang('friendlyname');
  }

  function IsPluginModule()
  {
    return false;
  }

  function HasAdmin()
  {
    return false;
  }

  function GetAdminDescription()
  {
    return '';
  }

  function GetVersion()
  {
    return '2.0';
  }

  function MinimumCMSVersion()
  {
    return '2.1';
  }

  function Install()
  {
    $this->Audit( 0, $this->Lang('friendlyname'), $this->Lang('installed',$this->GetVersion()));
  }

  function Uninstall()
  {
    $this->Audit( 0, $this->Lang('friendlyname'), $this->Lang('uninstalled'));
  }

  function InstallPostMessage()
  {
    return $this->Lang('postinstall');
  }

  function Upgrade($oldversion, $newversion)
  {
    $db = cmsms()->GetDb();
    $current_version = $oldversion;
    
    switch($current_version)
    {
      case '0.2';
      case '0.3':
      {
         $query = "update "
                  . cms_db_prefix()
                  . "content_props cp, "
                  . cms_db_prefix()
                  . "content c set cp.prop_name='alias_target' where c.content_id = cp.content_id and c.type='aliasmodule' and cp.prop_name='target'";
         
         error_log($query);
         
         $dbresult = $db->Execute($query);
      }
        
      case '0.4':
      case '0.5':
    }
    
    $this->Audit( 0, $this->Lang('friendlyname'), $this->Lang('upgraded',$this->GetVersion()));
  }

  function DoAction($action, $id, $params, $returnid = -1)
  {
    switch ($action)
    {
      case "default":
        break;

      case "defaultadmin":
        break;
    }
  }

  function GetHelp()
  {
    return $this->Lang('help');
  }

  function GetAuthor()
  {
    return 'Jo Morg';
  }

  function GetAuthorEmail()
  {
    return 'jomorg.morg@gmail.com';
  }

  function GetChangeLog()
  {
    return $this->Lang('changelog');
  }
  
  /**
  * Just a wrapper around the old $this->myRegisterContentType($name, $file, $friendlyname = '')
  * which is being removed in CMSMS 2.0
  * 
  * @param mixed $name
  * @param mixed $file
  * @param mixed $friendlyname
  */
  function myRegisterContentType($name, $file, $friendlyname = '')
  {
    $contentops = cmsms()->GetContentOperations();

    $obj = new CmsContentTypePlaceholder();
    $obj->class = $name;
    $obj->type  = strtolower($name);
    $obj->filename = $file;
    $obj->loaded = false;
    $obj->friendlyname = ($friendlyname != '' ? $friendlyname : $name);
    $contentops->register_content_type($obj);
  }
}

?>
