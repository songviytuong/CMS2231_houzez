<?php
#BEGIN_LICENSE
#-------------------------------------------------------------------------
# Module: CGContentUtils (c) 2009-2014 by Robert Campbell
#         (calguy1000@cmsmadesimple.org)
#  An addon module for CMS Made Simple to provide various additional utilities
#  for dealing with content pages.
#
#-------------------------------------------------------------------------
# CMS - CMS Made Simple is (c) 2005 by Ted Kulp (wishy@cmsmadesimple.org)
# This projects homepage is: http://www.cmsmadesimple.org
#
#-------------------------------------------------------------------------
#
# This program is free software; you can redistribute it and/or modify
# it under the terms of the GNU General Public License as published by
# the Free Software Foundation; either version 2 of the License, or
# (at your option) any later version.
#
# However, as a special exception to the GPL, this software is distributed
# as an addon module to CMS Made Simple.  You may not use this software
# in any Non GPL version of CMS Made simple, or in any version of CMS
# Made simple that does not indicate clearly and obviously in its admin
# section that the site was built with CMS Made simple.
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
#END_LICENSE

///////////////////////////////////////////////////////////////////////////
// This module is derived from CGExtensions
$cgextensions = cms_join_path($gCms->config['root_path'],'modules',
			      'CGExtensions','CGExtensions.module.php');
if( !is_readable( $cgextensions ) ) {
  echo '<h1><font color="red">ERROR: The CGExtensions module could not be found.</font></h1>';
  return;
}
require_once($cgextensions);
///////////////////////////////////////////////////////////////////////////

define('CGCONTENTMAGIC_DTD_VERSION','1.0');

class CGContentUtils extends CGExtensions
{
    var $_dom;
    var $_template_cache;
    var $_default_template;

    public function InitializeAdmin()
    {
        if( $this->CheckPermission('Manage All Content') ) {
            $this->RegisterBulkContentFunction($this->Lang('advanced_copy'),'admin_copycontent');
            $this->RegisterBulkContentFunction($this->Lang('realias'),'admin_bulkrealias');
        }
    }

    function GetName() { return 'CGContentUtils'; }
    function GetFriendlyName() { return $this->Lang('friendlyname'); }
    function GetVersion() { return '2.2.2'; }
    function GetAuthor() { return 'calguy1000'; }
    function GetAuthorEmail() { return 'calguy1000@cmsmadesimple.org'; }
    function GetChangeLog() { return file_get_contents(__DIR__.'/changelog.inc'); }
    function IsPluginModule() { return false; }
    function HasAdmin() { return true; }
    function IsAdminOnly() { return true; }
    function GetAdminSection() { return 'extensions'; }
    function GetAdminDescription() { return $this->Lang('moddescription'); }
    function GetDependencies() { return array('CGExtensions'=>'1.53.17','CGSimpleSmarty'=>'2.0.2'); }
    function MinimumCMSVersion() { return '2.1.5'; }
    function InstallPostMessage() { return $this->Lang('postinstall'); }
    function UninstallPostMessage() { return $this->Lang('postuninstall'); }
    function UninstallPreMessage() { return $this->Lang('ask_really_uninstall'); }

    function VisibleToAdminUser()
    {
        return( $this->CheckPermission('Calguys Content Utilities') );
    }

    /*---------------------------------------------------------
      SuppressAdminOutput()
      ---------------------------------------------------------*/
    function SuppressAdminOutput(&$request)
    {
        if( isset($_REQUEST['mact']) ) {
            $ary = explode(',', cms_htmlentities($_REQUEST['mact']), 4);
            $module = (isset($ary[0])?$ary[0]:'');
            $id = (isset($ary[1])?$ary[1]:'');
            $action = (isset($ary[2])?$ary[2]:'');

            if( $action == 'do_export' ) return TRUE;
        }

        return FALSE;
    }


    /*---------------------------------------------------------
      _exportContent($start_id,$children)
      ---------------------------------------------------------*/
    function _exportContent($start_id,$children)
    {
        $gCms = cmsms();
        $hm = $gCms->GetHierarchyManager();

        $this->_dom = new DOMDocument("1.0","UTF-8");
        $root = $this->_dom->createElement('cms_export');

        if( $start_id == -1 ) {
            $children = TRUE;
            $allchildren = $hm->getChildren(TRUE,TRUE);
            foreach( $allchildren as $child ) {
                if( !$child ) continue;
                $domnode = $this->_exportContentObj($child,$children);
                if( $domnode ) $root->appendChild($domnode);
            }
        }
        else {
            $node = $hm->sureGetNodeByID($start_id);
            if( !is_null($node) ) {
                $parent_domnode = $this->_exportContentObj($node,$children);
                if( $parent_domnode ) $root->appendChild($parent_domnode);
            }
        }
        $this->_dom->appendChild($root);
        return $this->_dom->saveXML();
    }


    /*---------------------------------------------------------
      _exportContentObj($content_obj,$children)
      ---------------------------------------------------------*/
    function _exportContentObj(&$node,$children)
    {
        $content_obj = $node->getContent(FALSE,TRUE,TRUE);
        if( !is_object($content_obj) ) return;
        $domnode = $this->_createDomContentObj($content_obj);

        if( $node->hasChildren() && $children ) {
            $tmp = $node->getChildren();
            foreach( $tmp as $child ) {
                $child_domnode = $this->_exportContentObj($child,$children);
                if( $child_domnode ) $domnode->appendChild($child_domnode);
            }
        }

        return $domnode;
    }


    /*---------------------------------------------------------
      _getDefaultTemplateId()
      ---------------------------------------------------------*/
    function _getDefaultTemplateId()
    {
        if( !$this->_default_template ) {
            $tpl_type = CmsLayoutTemplateType::load('Core::Page');
            $tpl = $tpl_type->get_dflt_template();
            $this->_default_template = $tpl->get_id();
        }
        return $this->_default_template;
    }


    /*---------------------------------------------------------
      _getTemplateNameFromId()
      ---------------------------------------------------------*/
    function _getTemplateNameFromId($tplid)
    {
        if( !$this->_template_cache ) {
            $tpl_type = CmsLayoutTemplateType::load('Core::Page');
            $tpl = $tpl_type->get_dflt_template();
            $parms = array();
            $parms[] = 't:'.$tpl_type->get_id();
            $parms['as_list'] = 1;
            $list = CmsLayoutTemplate::template_query($parms);
            $this->_template_cache = array();
            if( count($list) ) $this->_template_cache = $list;
        }

        if( isset($this->_template_cache[$tplid]) ) return $this->_template_cache[$tplid];
    }


    /*---------------------------------------------------------
      _getTemplateNameFromId()
      ---------------------------------------------------------*/
    function _getTemplateIdFromName($name)
    {
        // force cache to load.
        $this->_getTemplateNameFromId(-1);

        foreach( $this->_template_cache as $id => $tpl_name ) {
            if( $tpl_name == $name ) return $id;
        }

        return NULL;
    }


    /*---------------------------------------------------------
      _createDomContentObj()
      ---------------------------------------------------------*/
    function _createDomContentObj(&$content_obj)
    {
        $root = $this->_dom->createElement('cms_content');
        $root->setAttribute('name',$content_obj->Name());

        $sub = $this->_dom->createElement('type',$content_obj->Type());
        $root->appendChild($sub);

        $sub = $this->_dom->createElement('alias',$content_obj->Alias());
        $root->appendChild($sub);

        $sub = $this->_dom->createElement('template',$this->_getTemplateNameFromId($content_obj->TemplateID()));
        $root->appendChild($sub);

        $cdata = $this->_dom->createCDATAsection($content_obj->MetaData());
        $sub = $this->_dom->createElement('metadata');
        $sub->appendChild($cdata);
        $root->appendChild($sub);

        $sub = $this->_dom->createElement('accesskey',$content_obj->AccessKey());
        $root->appendChild($sub);

        $sub = $this->_dom->createElement('tabindex',$content_obj->TabIndex());
        $root->appendChild($sub);

        $sub = $this->_dom->createElement('menutext',$content_obj->MenuText());
        $root->appendChild($sub);

        $sub = $this->_dom->createElement('active',$content_obj->Active());
        $root->appendChild($sub);

        $sub = $this->_dom->createElement('cachable',$content_obj->Cachable());
        $root->appendChild($sub);

        $sub = $this->_dom->createElement('showinmenu',$content_obj->ShowInMenu());
        $root->appendChild($sub);

        $content_obj->HasProperty('___'); // fools properties to be loaded.
        $props = $content_obj->Properties();
        if( is_array($props) && count($props) ) {
            foreach( $props as $name => $val ) {
                $sub = $this->_dom->createElement('property');
                $sub->setAttribute('name',$name);
                $sub->setAttribute('type','string');
                $cdata = $this->_dom->createCDATAsection($val);
                $sub->appendChild($cdata);
                $root->appendChild($sub);
            }
        }

        return $root;
    }


    function _get_childnode_value(&$parent,$nodename)
    {
        $children = $parent->childNodes;
        foreach( $children as $childnode ) {
            if( $childnode->nodeName == $nodename ) return $childnode->nodeValue;
        }
        return NULL;
    }


    function _get_childnode(&$parent,$nodename)
    {
        $children = $parent->childNodes;
        foreach( $children as $childnode ) {
            if( $childnode->nodeName == $nodename ) return $childnode;
        }
        return NULL;
    }


    function _get_node_attribute(&$node,$attrname)
    {
        $attr = $node->attributes->getNamedItem($attrname);
        if( $attr ) return $attr->nodeValue;
        return NULL;
    }


    /*---------------------------------------------------------
      _scanContent()
      ---------------------------------------------------------*/
    function _scanContent(&$node,$parent_id = 0)
    {
        while( $node != NULL ) {
            if( $node->nodeName != 'cms_content' ) break;

            $content_obj = $this->_extractDomContentObj($node);
            if( $content_obj ) {
                // see if there are more.
                scan_content($node->firstChild,$parent_id++);
            }

            // go to the next
            $node = $node->nextSibling;
        }
    }


    /*---------------------------------------------------------
      _importContent()
      ---------------------------------------------------------*/
    function _importContent(&$node,$parent_id)
    {
        while( $node != NULL ) {
            if( $node->nodeName == 'cms_content' ) {
                $content_obj = $this->_extractDomContentObj($node);
                if( $content_obj ) {
                    // save it
                    $content_obj->SetParentId($parent_id);
                    $content_obj->SetOwner(get_userid());
                    $content_obj->Save();
                    $new_parent_id = $content_obj->Id();
                    // see if there are more.
                    $this->_importContent($node->firstChild,$new_parent_id);
                }
            }

            // go to the next
            $node = $node->nextSibling;
        }
    }


    /*---------------------------------------------------------
      _extractDomContentObj()
      ---------------------------------------------------------*/
    function &_extractDomContentObj(&$node)
    {
        $gCms = cmsms();
        $contentops = $gCms->getContentOperations();

        // a. get the content type
        $contenttype = $this->_get_childnode_value($node,'type');

        // b. create the new content object for filling.
        $content_obj = $contentops->CreateNewContent($contenttype);
        if( !$content_obj ) return NULL;

        $content_obj->SetName($this->_get_node_attribute($node,'name'));
        $content_obj->SetMenuText($this->_get_childnode_value($node,'menutext'));
        $content_obj->SetActive($this->_get_childnode_value($node,'active'));
        $content_obj->SetAccessKey($this->_get_childnode_value($node,'accesskey'));
        $content_obj->SetTabIndex($this->_get_childnode_value($node,'tabindex'));
        $content_obj->SetMetaData($this->_get_childnode_value($node,'metadata'));
        $content_obj->SetCachable($this->_get_childnode_value($node,'cachable'));
        $content_obj->SetShowInMenu($this->_get_childnode_value($node,'showinmenu'));

        $alias = $this->_get_childnode_value($node,'alias');
        $tmp = $contentops->CheckAliasError($alias);
        if( $tmp ) $alias = '';
        $content_obj->SetAlias($alias);

        // todo, handle null.
        $tpl_id = $this->_getTemplateIdFromName($this->_get_childnode_value($node,'template'));
        if( !$tpl_id ) $tpl_id = $this->_getDefaultTemplateId();
        $content_obj->SetTemplateId($tpl_id);

        // now to get the properties.
        $children = $node->childNodes;
        foreach( $children as $childnode ) {
            if( $childnode->nodeName != 'property' ) continue;
            $propname = $this->_get_node_attribute($childnode,'name');
            $proptype = $this->_get_node_attribute($childnode,'type');
            $propval  = $childnode->nodeValue;

            $content_obj->setPropertyValue($propname,$propval);
        }

        return $content_obj;
    }


    function HasCapability($capability,$params = array())
    {
        switch( $capability ) {
        case 'contentblocks':
            return TRUE;
        case 'bulkcontentoption':
            return TRUE;
        default:
            return FALSE;
        }
    }


    private function _prepare_options($input,$delim = '|')
    {
        $smarty = \CmsApp::get_instance()->GetSmarty();
        $txt = $smarty->fetch('string:'.$input);
        return $this->_clean_options($txt,$delim);
    }


    private function _clean_options($input,$delim = '|')
    {
        $opts = array();
        $tmp = explode("\n",$input);
        foreach( $tmp as $one ) {
            $one = trim($one);
            if( !$one ) continue;
            if( strpos($one,$delim) === FALSE ) $one = $one.$delim.$one;
            list($val,$lbl) = explode($delim,$one,2);
            $val = trim($val);
            $lbl = trim($lbl);
            if( !strlen($val) && $lbl ) $val = $lbl;
            if( $val && !strlen($lbl) ) $lbl = $val;
            $val = cms_htmlentities($val);
            $lbl = cms_htmlentities($lbl);
            $opts[$val] = $lbl;
        }
        return $opts;
    }

    function GetContentBlockFieldInput($blockName,$value,$params,$adding,ContentBase $content_obj)
    {
        $gCms = cmsms();
        $db = $gCms->GetDb();
        $config = $gCms->GetConfig();
        $adding = ($adding || $content_obj->Id() < 1) ? TRUE : FALSE; // hack for the core.

        if( empty($blockName) ) return FALSE;
        $name = $blockName;
        if( isset($params['name']) ) $name = trim($params['name']);

        if( isset($params['groups']) && !$this->CheckPermission('Manage All Content')) {
            // manage all content is just that... manage everything.
            // groups are specified, and we don't get superuser privilege.
            $my_uid = get_userid(FALSE);
            if( $my_uid <= 0 ) return FALSE; // not loggedin?

            $allgroups = array();
            {
                // get a hash of all of the groups and ids.
                $tmp = cmsms()->GetGroupOperations()->LoadGroups();
                if( !is_array($tmp) || count($tmp) == 0 ) return FALSE; // no groups?
                foreach( $tmp as $one ) {
                    if( !$one->active ) continue;
                    $allgroups[$one->name] = $one->id;
                }
            }

            // get the gids of all of the groups that this field is visible to.
            $groups = array();
            $tmp = explode(',',$params['groups']);
            foreach( $tmp as $one ) {
                $one = trim($one);
                if( $one ) {
                    if( !isset($allgroups[$one]) ) continue;
                    $groups[] = $allgroups[$one];
                }
            }

            if( count($groups) == 0 ) {
                // no valid groups specified... user has to be an administrator
                $groups[] = 1;
            }

            // now do the check to see if the current user is a member of the specified group(s)
            $groups = array_unique($groups);
            $valid = FALSE;
            foreach( $groups as $gid ) {
                $users = cmsms()->GetUserOperations()->LoadUsersInGroup($gid);
                if( !is_array($users) || !count($users) ) continue;
                foreach( $users as $user ) {
                    if( $user->id == $my_uid ) {
                        $valid = TRUE;
                        break;
                    }
                }
                if( $valid ) break;
            }
            if( !$valid ) {
                // user is not a member of any of the specified groups
                return FALSE;
            }
        }

        $query = 'SELECT * FROM '.cms_db_prefix().'module_cgcontentutils WHERE name = ?';
        $row = $db->GetRow($query,array($name));
        if( !$row ) return FALSE;
        $row['attribs'] = unserialize($row['attribs']);

        // for adding situations, if we do not have a value, but have one in the field definition... use it.
        if( $adding && !$value && $row['value'] ) $value = $row['value'];

        $lbl = trim($row['prompt']);
        if( \cge_param::get_bool($params,'required') && !startswith($lbl,'*') ) {
            $lbl = '*'.$lbl;
        }
        $txt = '';

        switch( $row['type'] ) {
        case 'textinput':
            $tmp = '<input type="text" name="%s" size="%d" maxlength="%d" value="%s"/>';
            $value = ($adding) ? $row['value'] : $value;
            $value = cms_htmlentities($value);
            $txt = sprintf($tmp,$blockName,$row['attribs']['length'],$row['attribs']['maxlength'], ($adding)?$row['value']:$value);
            break;

        case 'textarea':
            if( $row['attribs']['wysiwyg'] ) {
                $txt = create_textarea(TRUE,($adding)?$row['value']:$value,$blockName,'',$blockName,'','',$row['attribs']['cols'],$row['attribs']['rows']);
            }
            else {
                $tmp = '<textarea name="%s" rows="%d" cols="%d">%s</textarea>';
                $txt = sprintf($tmp,$blockName,$row['attribs']['rows'],$row['attribs']['cols'], ($adding)?$row['value']:$value);
            }
            break;

        case 'statictext':
            $txt = $this->ProcessTemplateFromData($row['attribs']['fieldtext']);
            break;

        case 'pageselector':
            $contentops = $gCms->GetContentOperations();
            if( $value == '' ) $value = $row['value'];
            $txt = $contentops->CreateHierarchyDropdown('',$value,$blockName,1,1);
            break;

        case 'advpageselector':
            $start = $row['attribs']['adv_start'];
            $navhidden = $row['attribs']['adv_navhidden'];
            $obj = new \CGExtensions\content_list_builder(array('parent'=>$start,'show_navhidden'=>$navhidden,'current'=>$value));
            $txt = sprintf('<select name="%s">',$blockName).$obj->get_options().'</select>';
            break;

        case 'dropdown':
            // get the options
            if( $value == '' ) $value = $row['value'];
            $opts = $this->_prepare_options($row['attribs']['options']);
            // build the field.
            $txt = $this->CreateInputDropdown('',$blockName,$opts,-1,$value);
            break;

        case 'sortable_list':
            // get the ptions
            if( $value == '' ) $value = $row['value'];
            $opts = $this->_prepare_options($row['attribs']['options']);
            $txt = $this->CreateSortableListArea('',$blockName,array_flip($opts),$value,true,
                                                 (int)$row['attribs']['sortable_maxitems'],'sortable_list.tpl');
            break;

        case 'dropdown_udt':
            // get the options
            if( $value == '' ) $value = $row['value'];
            $parms = array();
            $opts = UserTagOperations::get_instance()->CallUserTag($row['attribs']['udt'],$parms);
            if( is_array($opts) && count($opts) ) {
                $opts = array_flip($opts);
                $txt = $this->CreateInputDropdown('',$blockName,$opts,-1,$value);
            }
            else if( is_string($opts) && startswith( $opts, '<option') ) {
                $txt = '<select name="'.$blockName.'">'.$opts.'</select>';
            }
            break;

        case 'multiselect':
            // get the options
            if( $value == '' ) $value = $row['value'];
            $delim = get_parameter_value($row['attribs'],'storagedelimiter',',');
            $value = explode($delim,$value);
            $opts = $this->_prepare_options($row['attribs']['options']);

            // build the field.
            $size = max(3,min(10,count($opts)));
            $txt = $this->CreateInputSelectList('',$blockName.'[]',$opts,$value,$size);
            break;

        case 'checkbox':
            if( empty($value) && isset($row['value']) ) $value = $row['value'];
            $txt = $this->CreateInputHidden('',$blockName,isset($row['value'])?$row['value']:'').$this->CreateInputCheckbox('',$blockName,$row['attribs']['value'],$value);
            break;

        case 'radiobuttons':
            // get the options.
            if( $value == '' ) $value = $row['value'];
            $tmp = explode("\n",$row['attribs']['options']);
            $opts = array();
            for( $i = 0; $i < count($tmp); $i++ ) {
                if(empty($tmp[$i])) continue;
                $tmp2 = explode('|',trim($tmp[$i]),2);
                if( is_array($tmp2) && count($tmp2) == 2 ) {
                    $opts[$tmp2[0]] = $tmp2[1];
                }
                else {
                    $opts[$tmp2[0]] = $tmp2[0];
                }
            }

            // build the field.
            $txt = $this->CreateInputRadioGroup('',$blockName,$opts,$value,'','<br/>');
            break;

        case 'gcb_selector':
            // get the generic template type id
            $type = CmsLayoutTemplateType::load('Core::Generic');
            $type_id = $type->get_id();
            unset($type);
            // build a CmsLayoutTemplateQuery for generic temlates that have the prefix
            $query = new CmsLayoutTemplateQuery("t:$type_id");
            $list = array();
            $prefix = null;
            if( isset($row['attribs']['gcb_prefix']) ) $prefix = $row['attribs']['gcb_prefix'];
            while( $query && !$query->EOF() ) {
                $obj = $query->GetObject();
                $str = $obj->get_name();
                if( startswith($str,$prefix) ) $list[$obj->get_name()] = substr($str,strlen($prefix));
                $query->MoveNext();
            }
            unset($query);
            // build the field
            $txt = $this->CreateInputDropdown('',$blockName,array_flip($list),-1,$value);
            break;

        case 'file_selector':
            // 1.  Get the directory contents
            $dir = cms_join_path($config['uploads_path'],$row['attribs']['dir']);
            $filetypes = $row['attribs']['filetypes'];
            if( $filetypes != '' ) {
                $filetypes = explode(',',$filetypes);
                for( $i = 0; $i < count($filetypes); $i++ ) {
                    $filetypes[$i] = '*.'.$filetypes[$i];
                }
            }
            $excludes = $row['attribs']['excludeprefix'];
            if( $excludes != '' ) {
                $excludes = explode(',',$excludes);
                for( $i = 0; $i < count($excludes); $i++ ) {
                    $excludes[$i] = $excludes[$i].'*';
                }
            }
            $fl = cge_dir::recursive_glob($dir,$filetypes,'FILES',$excludes, ($row['attribs']['recurse']) ? -1 : 0);

            // 2.  Remove prefix
            for( $i = 0; $i < count($fl); $i++ ) {
                $fl[$i] = str_replace($dir,'',$fl[$i]);
            }

            // 2.  Sort
            if( is_array($fl) && $row['attribs']['sortfiles'] ) sort($fl);

            $opts = array();
            $opts[$this->Lang('none')] = -1;
            $url_prefix = $config['uploads_url'].'/'.$row['attribs']['dir'];
            for( $i = 0; $i < count($fl); $i++ ) {
                $opts[$fl[$i]] = $url_prefix.$fl[$i];
            }
            $txt = $this->CreateInputDropdown('',$blockName,$opts,-1,$value);
            break;
        }

        if( $lbl && $txt ) return array($lbl,$txt);
        if( $txt ) return $txt;
    }

    function GetContentBlockFieldValue($blockName,$blockParams,$inputParams,ContentBase $content_obj)
    {
        $db = cmsms()->GetDb();
        $query = 'SELECT * FROM '.cms_db_prefix().'module_cgcontentutils WHERE name = ?';
        $row = $db->GetRow($query,array($blockName));
        if( !$row ) return FALSE;
        $row['attribs'] = unserialize($row['attribs']);

        switch( $row['type'] ) {
        case 'radiobuttons':
        case 'dropdown':
        case 'multiselect':
            $delim = trim(get_parameter_value($row['attribs'],'storagedelimiter'));
            if( !$delim ) $delim = ',';
            $value = array();
            if( isset($inputParams[$blockName]) ) {
                $val = $inputParams[$blockName];
                if( is_array($val) ) $value = implode($delim,$inputParams[$blockName]);
            }
            return $value;
            break;

        case 'statictext':
            // static text never gets rendered.
            return '';

        case 'gcb_selector':
        default:
            if( isset($inputParams[$blockName]) ) return $inputParams[$blockName];
            break;
        }
    }

    function ValidateContentBlockFieldValue($blockName,$value,$blockparams,ContentBase $content_obj)
    {
        $gCms = cmsms();
        $db = $gCms->GetDb();

        if( empty($blockName) ) return FALSE;
        $query = 'SELECT * FROM '.cms_db_prefix().'module_cgcontentutils WHERE name = ?';
        $row = $db->GetRow($query, [ $blockName ]);
        if( !$row ) return FALSE;
        $row['attribs'] = unserialize($row['attribs']);

        if( \cge_param::get_bool($blockparams,'required') && empty($value) ) {
            return lang('nofieldgiven',array($blockName));
        }
    }

    /*
    function RenderContentBlockField($blockName,$value,$blockparams,ContentBase $content_obj)
    {
        die(__METHOD__);
    }
    */
} // end of class

?>
