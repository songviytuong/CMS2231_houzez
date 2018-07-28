<?php
#-------------------------------------------------------------------------
# Module: Content Aliases
# Version: 1.0, released October 2013
#
# Copyright (c) 2010 - 2013, Fernando Morgado (Jo Morg) <jomorg.morg@gmail.com>
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
class ContentAlias extends Content
{

	var $attrs;
  var $mPropertiesLoaded = false;

	function ModuleName()
	{
		return 'ContentAliases';
	}
  
  function Lang($name, $params=array())
  {
    $obj = cms_utils::get_module($this->ModuleName());
    
    if( $obj )
    {
      return $obj->Lang($name, $params);
    }
    else
    {
      return 'ModuleName() not defined properly';
    }
  }
  
  function GetAdminThemeName()
  {
    return cms_utils::get_theme_object()->GetDefaultTheme(); 
  }
	
	function IsDefaultPossible()
	{
		return TRUE;
	}
  
  // to revisit...
  public function GetModifiedDate()
  {
    // on frontend requests this will force the template to be recompiled
    // and therefore evaluation to be done for each request.
    if( cmsms()->is_frontend_request() ) return time();
    return parent::GetModifiedDate();
  }
	

  function SetProperties()
  {
    parent::SetProperties();
    
    $this->AddProperty('alias_target', 2, self::TAB_MAIN);
    
    # load and show content blocks? (main or custom)
    $this->doLoadContentBlocks = false;

	  #Turn off caching
	  $this->mCachable = false;
  }
 
  protected function display_single_element($one, $adding)
  {
    $gCms = cmsms();
    $config = $gCms->GetConfig();
    $contentops = $gCms->GetContentOperations();
    
    switch ($one) 
    {
      case 'content_en': 
        array();
        break;
      
      case 'alias_target':
      {
        
        $targ = $this->GetPropertyValue('alias_target');
        if( !empty($targ) )
          $urlext = cms_utils::get_module('CMSContentManager')->create_url( 'm1_', 'admin_editcontent', null, array( 'content_id' => $targ ) );

        $field = $contentops->CreateHierarchyDropdown($this->mId, $targ, 'alias_target');
        $field .= (
                    empty($targ) ? '' : (
                                          '&nbsp;<a href="'
                                          . $urlext            
                                          . '">'
                                          . $this->Lang('edit_orig_content')
                                          . '</a>'
                                        )
                   );
        
        return  array( lang('target'), $field);    
      }
      break;

      default:
      {
        return parent::display_single_element($one, $adding);  
      }

    }
    
  }

  public function FillParams($params, $editing = false)
  {

	  if (isset($params))
	  {
		  $parameters = array('alias_target');
      
		  foreach ($parameters as $oneparam)
		  {
			  
        if (isset($params[$oneparam]))
			  {
				  $this->SetPropertyValue($oneparam, $params[$oneparam]);
			  }
        
		  }
	  }
    
	  parent::FillParams($params);
  }

  function Show($param='')
  {

    $gCms = cmsms();
    $param = trim($param);
    
    if( !$param ) $param = 'content_en';
    $param = str_replace(' ','_',$param); 
    
    if ($param == 'content_en')
    { 
      $contentops = $gCms->GetContentOperations();
      $output = $contentops->LoadContentFromId($this->GetPropertyValue('alias_target'));
      $ret = $output->Show($param);
      return $ret;  
    }
    else
    {
      return parent::Show($param);
    }
  }

  function GetAliasContent($preserveAlias=false, $preserveType=false)
  {
    $gCms = cmsms();
    $this->makeSurePropsAreLoaded();
    $target = $this->GetPropertyValue('alias_target');
    $contentops = $gCms->GetContentOperations();
    $contentobj = $contentops->LoadContentFromId($target, true);
    
    if ($target == -1)
    {
      $contentobj = new CMSModuleContentType();
      $contentobj->SetDefaultContent('[Content Alias, no target set]:' . $this->mHierarchy . ',' . $this->mMenuText);
    }
    
    if (gettype($contentobj) != 'object')
    {
      $contentobj = new CMSModuleContentType();
      $contentobj->SetDefaultContent('[Content Alias, bad target]:'.$this->mHierarchy.','.$this->mMenuText);
    }

    // should do this via methods!
    $contentobj->mId = $this->mId;
    $contentobj->mName = $this->mName;
    
    if ($preserveAlias)
    {
      $contentobj->mAlias = $this->mAlias;
    }
    
    if ($preserveType)
    {
      $contentobj->mType = $this->mType;
    }
    
    $contentobj->mOwner = $this->mOwner;
    $contentobj->mParentId = $this->mParentId;
    $contentobj->mTargetHierarchy = $contentobj->mHierarchy;
    $contentobj->mHierarchy = $this->mHierarchy;
    $contentobj->mMenuText = $this->mMenuText;
    $contentobj->mMarkup = $this->mMarkup;
    $contentobj->mActive = $this->mActive;
    $contentobj->mCollapse = (isset($this->mCollapse)?$this->mCollapse:false);
    $contentobj->mShowInMenu = $this->mShowInMenu;
    $contentobj->mCachable = $this->mCachable;
    $contentobj->mLastModifiedBy = $this->mLastModifiedBy;
    $contentobj->mCreationDate = $this->mCreationDate;
    $contentobj->mModifiedDate = $this->mModifiedDate;
    
    return $contentobj;
  }

  function FriendlyName()
  {
    return $this->Lang('friendlyname');
  }

}

?>