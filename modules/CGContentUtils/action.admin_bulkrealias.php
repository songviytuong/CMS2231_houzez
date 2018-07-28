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
if( !$this->CheckPermission('Manage All Content') ) return;

try {
    $contentops = ContentOperations::get_instance();
    $contentmanager = cms_utils::get_module('CMSContentManager');

    if( isset($params['cancel']) ) {
        $contentmanager->Redirect('m1_','defaultadmin');
    }
    if( isset($params['submit']) ) {
        if( !isset($params['aliases']) || !is_array($params['aliases']) || !count($params['aliases']) ) {
            throw new \RuntimeException($this->Lang('error_nocontentselected'));
        }

        $ids = array_keys($params['aliases']);
        $contentops->LoadChildren(null,FALSE,TRUE,$ids);

        foreach( $params['aliases'] as $c_id => $c_alias ) {
            // get the conent object for the id.
            $content_obj = $contentops->LoadContentFromId($c_id);
            if( !$content_obj ) continue;

            // if it has an alias, set it and save it.
            $content_obj->SetAlias($c_alias);
            $content_obj->Save();
        }
        audit('',$this->GetName(),'Adjusted alias on '.count($ids).' content objects');
        $contentmanager->Redirect('m1_','defaultadmin');
    }
    $contentlist = \cge_param::get_string($params,'contentlist');
    if( !$contentlist ) throw new \RuntimeException($this->Lang('error_nocontentselected'));

    $tmp = explode(',',$contentlist);
    $contentlist_t = array();
    foreach( $tmp as $one ) {
        $one = (int) $one;
        if( $one < 1 ) continue;
        if( !in_array($one,$contentlist_t) ) $contentlist_t[] = $one;
    }
    if( !count($contentlist_t) ) throw new \RuntimeException($this->Lang('error_nocontentselected'));
    $contentops->LoadChildren(null,FALSE,TRUE,$contentlist_t);

    $contentlist = array();
    foreach( $contentlist_t as $c_id ) {
        $content_obj = $contentops->LoadContentFromId($c_id);
        if( !$content_obj ) continue;
        $alias = $content_obj->Alias();
        if( !$alias ) continue;
        $contentlist[] = array('id'=>$c_id,'alias'=>$alias);
    }

    // create a new form
    $tpl = $this->CreateSmartyTemplate('admin_bulkrealias.tpl');
    $tpl->assign('list',$contentlist);
    $tpl->display();
}
catch( \Exception $e ) {
    echo $this->ShowErrors($e->GetMessage());
    return;
}
