<?php
#BEGIN_LICENSE
#-------------------------------------------------------------------------
# Module: CGContentUtils (c) 2009 by Robert Campbell
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
if( !isset($gCms) ) exit();
if( !$this->CheckPermission('Manage All Content') ) {
  echo $this->ShowErrors($this->Lang('error_permissiondenied'));
  return;
}
if( !isset($params['contentlist']) ) {
  echo $this->ShowErrors($this->Lang('error_nocontentselected'));
  return;
}

//
// initialize
//
$templates = array();
$contents = array();
$newdata = array();
$addblocks = array();
$contentops = $gCms->GetContentOperations();
$copiedcontent = array();


//
// setup
//
if( isset($params['cancel']) ) $this->RedirectToAdmin('listcontent.php');

//
// get the data
//
$contentlist = explode(',',$params['contentlist']);
foreach( $contentlist as $oneid )
{
    // get the content object for this page.
    $content = $contentops->LoadContentFromId($oneid,true);
    $contents[$oneid] = $content;
    $newdata[$oneid] = array();

    // get a proposed new alias for this content block
    {
        $num = 2;
        $newalias = $content->Alias().'-'.$num;
        while (($err = $contentops->CheckAliasError($newalias)) !== FALSE) {
            $num++;
            $newalias = $content->Alias().'_'.$num;
        }
        $newdata[$oneid]['new_alias'] = $newalias;
    }
}

$sort_by_hier = function($a,$b) {
    if (!is_subclass_of($a, 'ContentBase')) return 0;
    if (!is_subclass_of($b, 'ContentBase')) return 0;
    return strcmp($a->Hierarchy(), $b->Hierarchy());
};
uasort($contents, $sort_by_hier);

$parent_in_list = function($list,$child) {
    if (!is_subclass_of($child, 'ContentBase')) return false;
    foreach ($list as $id => $obj) {
        if ($obj->Id() == $child->ParentId()) return true;
    }

    return false;
};

$parent_dropdowns = array();

// now parse each template object... and see if the content blocks have the promptoncopy attribute
// and if it's valid.
foreach( $contents as $content_id => &$obj ) {
    if ($parent_in_list($contents, $obj)) {
        $result = $contentops->CreateHierarchyDropdown('', '', "{$id}new_parent_id[{$content_id}]", 1, 0, 0, true);
        $result = str_replace('<option value="-1">none</option>', '<option value="0">Preserve Hierarchy</option><option value="-1">None</option>', $result);
        $parent_dropdowns[$content_id] = $result;
    }
    else {
        $result = $contentops->CreateHierarchyDropdown('', $obj->ParentId(), "{$id}new_parent_id[{$content_id}]", 1, 0, 0, true);
        $result = str_replace('<option value="-1">none</option>', '<option value="-1">None</option>', $result);
        $parent_dropdowns[$content_id] = $result;
    }

    if( !is_a($obj,'Content') ) continue;
}

$mapped_ids = array();
//
// handle form submit
//
if( isset($params['submit']) ) {
    //
    // validate form contents
    //
    try {
        // check out the names.
        foreach($params['new_name'] as $cid => $value ) {
            $value = trim($value);
            if( empty($value) ) throw new \RuntimeException($this->Lang('error_copycontent_invalid_name',$cid));
        }

        // check out the menutext.
        foreach($params['new_menutext'] as $cid => $value ) {
            $value = trim($value);
            if( empty($value) ) throw new \RuntimeException($this->Lang('error_copycontent_invalid_menutext',$cid));
        }

        // check out the aliases.
        foreach($params['new_alias'] as $cid => $value ) {
            $value = trim($value);
            if( !empty($value) ) {
                // empty aliases are okay (we'll auto generate them)
                $tmp = $contentops->CheckAliasError($value);
                if( $tmp ) throw new \RuntimeException($tmp);
            }
        }

        // validate the blocks and collect values
        foreach($params as $key => $value) {
            if( !startswith($key,'block_') ) continue;

            $tmp = explode('_',$key,3);
            $content_id = $tmp[1];
            $blockname = $tmp[2];
            if( !isset($addblocks[$content_id][$blockname]) ) continue;

            // found the block... now we validate it.
            // todo.

            // and store the value
            $addblocks[$content_id][$blockname]['value'] = $value;
        }

        // done validation... now start copying content objects.
        foreach( $contents as $content_id => $source ) {
            $dest = clone($source);

            $dest->SetId(-1); // force new object
            $dest->SetItemOrder(-1);
            $dest->SetOldItemOrder(-1);

            $dest->SetAlias($params['new_alias'][$content_id]);
            $dest->SetName($params['new_name'][$content_id]);
            if ($params['new_parent_id'][$content_id] != 0) {
                //We'll set it later...  scout's honor
                $dest->SetParentId($params['new_parent_id'][$content_id]);
                //$dest->SetOldParentId($params['new_parent_id'][$content_id]);
            }
            $dest->SetMenuText($params['new_menutext'][$content_id]);
            $dest->SetDefaultContent(0);
            $dest->SetOwner(get_userid());
            $dest->SetURL('');
            $dest->SetLastModifiedBy(get_userid());

            // set properties
            if (isset($addblocks[$content_id])) {
                foreach($addblocks[$content_id] as $blockname => $blockinfo ) {
                    if( !isset($blockinfo['value']) ) continue;
                    $dest->SetPropertyValue($blockname,$blockinfo['value']);
                }
            }

            $res = $dest->ValidateData();
            if( $res !== FALSE ) throw new \RuntimeException($res);
            $copiedcontent[$content_id] = $dest;
        }

        if( (count($copiedcontent) > 0) ) {
            // have array of copied content objects
            // now ready to save them.
            foreach( $copiedcontent as $key => &$dest ) {
                if ($params['new_parent_id'][$key] == '0') {
                    $old_id = $dest->ParentId();
                    //var_dump('new id', $key, $old_id);
                    $dest->SetParentId($mapped_ids[$old_id]);
                    $dest->SetOldParentId($mapped_ids[$old_id]);
                }
                $dest->Save();
                $mapped_ids[$key] = $dest->Id();
            }
            $contentops->SetAllHierarchyPositions();

            // something for the audit log
            audit('','','Advanced Copy of Content');

            // and redirect
            if( version_compare(CMS_VERSION,'1.99-alpha0') < 0 ) {
                $this->RedirectToAdmin('listcontent.php', array('message'=>'bulk_success'));
            }
            else {
                $cm = cms_utils::get_module('CMSContentManager');
                $this->SetMessage($this->Lang('bulk_success'));
                if( $cm ) $cm->Redirect($id,'defaultadmin',$returnid);
            }
        }
    }
    catch( \Exception $e ) {
        echo $this->ShowErrors($e->GetMessage());
    }
}

//
// build our form
//
$parms = array('contentlist'=>$params['contentlist']);
$smarty->assign('formstart',$this->CGCreateFormStart($id,'admin_copycontent','',$parms));
$smarty->assign('formend',$this->CreateFormEnd());
$smarty->assign('prompt_parent',lang('parent'));
$smarty->assign('parent_dropdown',$contentops->CreateHierarchyDropdown('','',$id.'parent_id', 1, 0, 0, true));
$smarty->assign('parent_dropdowns', $parent_dropdowns);
$smarty->assign('contents',$contents);
$smarty->assign('addblocks',$addblocks);
$smarty->assign('newdata', $newdata);



//
// process the template
//
echo $this->ProcessTemplate('admin_copycontent.tpl');

#
# EOF
#
?>