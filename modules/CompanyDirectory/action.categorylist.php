<?php
#BEGIN_LICENSE
#-------------------------------------------------------------------------
# Module: CompanyDirectory (c) 2004-6 by Ted Kulp (ted@cmsmadesimple.org)
#   Copyright 2006 - 2014 by Robert Campbell (calguy1000@cmsmadesimple.org)
#
#  An addon module for CMS Made Simple to allow management of and various ways to display
#  company information for use in directories etc.
#
#-------------------------------------------------------------------------
# CMS - CMS Made Simple is (c) 2005-2010 by Ted Kulp (wishy@cmsmadesimple.org)
# Visit the CMSMS homepage at: http://www.cmsmadesimple.org
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
if (!isset($gCms)) exit;

$thetemplate = 'categorylist_'.$this->GetPreference(COMPANYDIR_PREF_DFLTCATEGORYLIST_TEMPLATE);
if( isset($params['categorylisttemplate'] ) ) {
    $thetemplate = 'categorylist_'.$params['categorylisttemplate'];
}

$showchildren = !cms_to_bool(cge_utils::get_param($params,'nochildren',false));

$query = '';
if( isset($params['showall']) ) {
    $query = 'SELECT a.*, bb.count
              FROM '.cms_db_prefix().'module_compdir_categories a
              LEFT OUTER JOIN
               (SELECT a.category_id,count(b.id) AS count
                FROM '.cms_db_prefix().'module_compdir_company_categories a
                LEFT OUTER JOIN '.cms_db_prefix().'module_compdir_companies b ON a.company_id = b.id
                WHERE b.status = \'published\'
                GROUP by a.category_id) bb
              ON a.id = bb.category_id ORDER BY a.hierarchy ASC';
}
else {
    $query = 'SELECT CAT.*,COALESCE(S1.count,0) AS count FROM '.cms_db_prefix().'module_compdir_categories CAT
              LEFT OUTER JOIN (SELECT CC.category_id,COUNT(CC.company_id) AS count FROM '.cms_db_prefix().'module_compdir_company_categories CC
                               LEFT JOIN '.cms_db_prefix().'module_compdir_companies CO
                               ON CC.company_id = CO.id __WHERE1__ GROUP BY CC.category_id) AS S1
              ON CAT.id = S1.category_id __WHERE2__
              ORDER BY CAT.hierarchy';

    $where1 = $where2 = array();
    $where1[] = 'CO.status = \'published\'';

    if( isset($params['categoryid']) ) {
        // we're only showing items in this category, and it's children.
        $ids = (int)$params['categoryid'];
        $ids = array($ids);
        if( $showchildren ) $ids = cd_utils::expand_categories($ids);
        $where1[] = 'CC.category_id IN ('.implode(',',$ids).')';
        $where2[] = 'CAT.id IN ('.implode(',',$ids).')';
    }
    else if( isset($params['category']) ) {
        // limit the counting to the specified categorie(s), and limit the output to the specified categorie(s).
        $params['category'] = html_entity_decode($params['category']);
        $ids = cd_utils::get_category_ids($params['category']);
        if( $showchildren ) $ids = cd_utils::expand_categories($ids);
        if( !$ids ) $ids = array();
        $where1[] = 'CC.category_id IN ('.implode(',',$ids).')';
        $where2[] = 'CAT.id IN ('.implode(',',$ids).')';
    }

    if( isset($params['hier']) ) {
        // further limit the output (count only companies in the selected hierarchies)
        $hierarchy = html_entity_decode(trim($params['hier']));
        $list = cd_utils::get_hierarchy_ids($hierarchy);
        if( $showchildren ) $list = cd_utils::expand_hierarchies($list);
        if( !is_array($list) ) $list = array();
        $where1[] = 'CO.hier_id IN ('.implode(',',$list).')';
    }

    $where1_s = '';
    if( count($where1) ) $where1_s = ' WHERE '.implode(' AND ',$where1);
    $query = str_replace('__WHERE1__',$where1_s,$query);

    $where2_s = '';
    if( count($where2) ) $where2_s = ' WHERE '.implode(' AND ',$where2);
    $query = str_replace('__WHERE2__',$where2_s,$query);
}
$dbresult = $db->Execute($query);
$results = array();
$summarypage = $this->resolve_alias_or_id(cge_utils::get_param($params,'summarypage'),$returnid);

$config = cmsms()->GetConfig();
while( $dbresult && $row = $dbresult->FetchRow() ) {
    // row to object
    $obj = new StdClass();
    foreach( $row as $k => $v ) {
        $obj->$k = $v;
    }
    $obj->direct_count = $obj->count;

    if( $obj->parent_id < 1 ) $obj->parent_id = -1;
    $obj->depth = count(explode('.',$obj->hierarchy));
    if( is_null($obj->count) ) $obj->count = 0;
    if( $obj->image ) {
        $path = cms_join_path($config['uploads_path'],'companydirectory','cat'.$obj->id);
        if( file_exists(cms_join_path($path,$obj->image)) ) {
            $obj->image_url = $config['uploads_url']."/companydirectory/cat{$obj->id}/{$obj->image}";
            if( file_exists(cms_join_path($path,'thumb_'.$obj->image)) ) {
                $obj->thumb_url = $config['uploads_url']."/companydirectory/cat{$obj->id}/thumb_{$obj->image}";
            }
        }
    }

    {
        // the old, standard, pretty url (by category).
        $parms2 = $params;
        if( isset($parms2['category']) ) unset($parms2['category']);
        unset($parms2['hier'],$parms2['action'],$parms2['module']);
        $parms2['categoryid']=$row['id'];
        $obj->summary_url = $this->create_url($id,'default',$summarypage,$parms2);
    }

    $results[$obj->id] = $obj;
}
if( $dbresult ) $dbresult->Close();
// convert it to to a tree structure
$_to_tree = function($parent_id = -1) use ($results,&$_to_tree) {
    $tree = array();
    foreach( $results as $id => $row ) {
        if( $parent_id == $row->parent_id ) {
            $children = $_to_tree($id);
            $row->children = $children;
            $tree[$id] = $row;
        }
    }
    return $tree;
};

// adjust the counts
$_count_children = function(&$tree) use (&$_count_children) {
    $sum = 0;
    foreach( $tree as &$node ) {
        $children = 0;
        if( isset($node->children) && count($node->children) ) {
            $children = $_count_children($node->children);
        }
        $node->count += $children;
        $sum += $node->count;
    }
    return $sum;
};

$results = $_to_tree();
$_count_children($results);
$smarty->assign('categorylist',$results);
echo $this->ProcessTemplateFromDatabase($thetemplate);

#
# EOF
#
