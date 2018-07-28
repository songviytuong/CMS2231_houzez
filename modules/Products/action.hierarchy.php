<?php
#BEGIN_LICENSE
#-------------------------------------------------------------------------
# Module: Products (c) 2008-2014 by Robert Campbell
#         (calguy1000@cmsmadesimple.org)
#  An addon module for CMS Made Simple to allow users to create, manage
#  and display products in a variety of ways.
#
#-------------------------------------------------------------------------
# CMS - CMS Made Simple is (c) 2005 by Ted Kulp (wishy@cmsmadesimple.org)
# Visit the CMSMS Homepage at: http://www.cmsmadesimple.org
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

if( !isset($gCms) ) exit;
$config = $gCms->GetConfig();

$summarypage = $returnid;
if( isset($params['summarypage']) ) {
    $summarypage = $this->resolve_alias_or_id($params['summarypage']);
    if( !$summarypage ) $summarypage = $returnid;
}

$active_hierarchy = (int)$smarty->get_template_vars('active_hierarchy');
if( !isset($params['parent']) && $active_hierarchy > 0 ) $params['parent'] = $active_hierarchy;

$inline = (int)get_parameter_value($params,'inline',0);

$hierpage = $returnid;
$tmp = $this->GetPreference('hierpage');
if( $tmp > 0 ) $hierpage = $tmp;

if( isset($params['hierarchypage']) ) {
    $tmp = $this->resolve_alias_or_id($params['hierarchypage']);
    if( $tmp ) $hierpage = $tmp;
}

if( !function_exists('products_byhierarchy_postprocess') ) {
    function products_byhierarchy_postprocess(&$data,$params,$summarypage,$hierpage,$inline,$id)
    {
        if( is_array($data) ) {
            $config = cmsms()->GetConfig();
            $module = cge_utils::get_module('Products');
            $imgdir = product_utils::get_hierarchy_upload_path();

            for( $i = 0; $i < count($data); $i++ ) {
                $rec =& $data[$i];

                $tn = cms_join_path($imgdir,'thumb_'.$rec['image']);
                if( file_exists($tn) ) $rec['thumbnail'] = 'thumb_'.$rec['image'];

                $tn = cms_join_path($imgdir,'preview_'.$rec['image']);
                if( file_exists($tn) ) $rec['preview'] = 'preview_'.$rec['image'];
                if( !isset($rec['count']) ) $rec['count'] = 0;

                $parms = $params;
                $parms['parent'] = $rec['id'];
                unset($parms['inline']);

                $rec['down_url'] = $module->CreateURL($id,'hierarchy',$hierpage,$parms,$inline);

                $parms = $params;
                $parms['hierarchyid'] = $rec['id'];
                if( isset($parms['summarypage']) ) unset($parms['summarypage']);
                if( $rec['count'] > 0 ) {
                    // summary URLS are non inline
                    $rec['url'] = $module->create_url('cntnt01','default',$summarypage,$parms);
                }

                if( isset($rec['children']) ) products_byhierarchy_postprocess($rec['children'],$params,$summarypage,$hierpage,$inline,$id);
            }
        }
    }
}

$thetemplate = $this->find_layout_template($params,'hierarchytemplate','Products::Hierarchy View');
unset($params['hierarchytemplate']);
$tpl = $this->CreateSmartyTemplate($thetemplate);

$nodes = array();
$parents = array(-1);
if( isset($params['parent'] ) ) {
    $parents = array((int)$params['parent']);
    unset($params['parent']);
}
else if( isset($params['parents']) ) {
    $tmp = explode(',',$params['parents']);
    $tmp2 = array();
    $all_hierarchy = hierarchy_ops::get_all_hierarchy_info();
    if( !is_array($all_hierarchy) || count($all_hierarchy) == 0 ) return; // nothing to do.
    foreach( $tmp as $one ) {
        $one = trim($one);
        foreach( $all_hierarchy as $onehier ) {
            if( is_numeric($one) && $onehier['id'] == $one ) {
                $tmp2[] = $one;
                break;
            }
            else if( $onehier['name'] == $one ) {
                $tmp2[] = $onehier['id'];
                break;
            }
        }
    }
    $tmp2 = array_unique($tmp2);
    if( !is_array($tmp2) || count($tmp2) == 0 ) return; // nothing to display.
    $parents = $tmp2;
    unset($params['parents']);
}
/* not used?
   else if( isset($params['hierarchy']) ) {
   $tmp = explode(',',$params['hierarchy']);
   $tmp2 = array();
   foreach( $tmp as $one ) {
   $tmp2[] = "'".trim($one)."'";
   }
   $tmp2 = implode(',',$tmp2);
   $query = 'SELECT id FROM '.cms_db_prefix().'module_products_hierarchy WHERE name IN ('.$tmp2.')';
   $nodes = $db->GetCol($query);
   $nodes = array_unique($nodes);
   unset($params['hierarchy']);
   }
*/

if( !count($parents) ) return; // nothing found to start with

$data = array();
if( count($nodes) ) {
    // not used?
    // this will only display the selected hierarchies (not including their children) that have products.
    $nodes = implode(',',$nodes);
    $query = 'SELECT ph.*,count(pr.id) AS count FROM '.cms_db_prefix().'module_products_hierarchy ph
              LEFT OUTER JOIN '.cms_db_prefix().'module_products_prodtohier pth
                ON ph.id = pth.hierarchy_id
              LEFT OUTER JOIN '.cms_db_prefix().'module_products pr
                ON pth.product_id = pr.id
             WHERE pr.status = \'published\'
               AND ph.id IN ('.$nodes.')
             GROUP BY ph.id ORDER BY ph.hierarchy';
    $tmp = $db->GetArray($query);
    products_byhierarchy_postprocess($tmp,$params,$summarypage,$hierpage,$inline,$id);
    $data = $tmp;
}
else {
    foreach( $parents as $parent_id ) {
        if( !$parent_id ) continue;

        $tmp = product_utils::hierarchy_get_tree($parent_id);
        if( is_array($tmp) && count($tmp) ) {
            products_byhierarchy_postprocess($tmp,$params,$summarypage,$hierpage,$inline,$id);
            foreach( $tmp as $tmp2 ) {
                $data[] = $tmp2;
            }
        }
    }
}

$hierdata = '';
$tpl->assign('hierdata',$data);
if( count($parents) == 1 ) {
    $hierdata = hierarchy_ops::get_hierarchy_info($parents[0]);
    if( $hierdata ) {
        // only if we have a parent hierarchy?
        $hierdata['parent_url'] = $this->create_url($id,'hierarchy',$returnid,array('parent'=>$hierdata['parent_id']));
        $tpl->assign('active_hierarchy',$parents[0]);
        if( $inline == 0 ) $hierdata['canonical'] = $this->create_url($id,'hierarchy',$returnid,array('parent'=>$parents[0]));
        $tpl->assign('hierarchy_item',$hierdata);
    }
}

$nochildren = cge_utils::to_bool(cge_utils::get_param($params,'nochildren',0));

//
// template
//
$tpl->assign('hierarchy_image_location',$config['uploads_url'].'/'.$this->GetName().'/hierarchy');
$tpl->assign('nochildren',$nochildren);
$tpl->display();

#
# EOF
#
