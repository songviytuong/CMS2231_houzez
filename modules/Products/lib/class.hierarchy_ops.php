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

class hierarchy_ops
{
    private static $_cache_loaded;
    private static $_allhierarchy;

    private static function _update_hierarchy_counts(&$data,$parent_id = -1)
    {
        $n = 0;
        foreach( $data as &$rec ) {
            if( !isset($rec['direct_count']) ) continue;
            if( $rec['parent_id'] != $parent_id ) continue;
            $rec['count'] = $rec['direct_count'];
            $rec['count'] += self::_update_hierarchy_counts($data,$rec['id']);
            $n += $rec['count'];
        }
        return $n;
    }

    public static function get_all_hierarchy_info($count = FALSE, $all = TRUE)
    {
        if( ! self::$_cache_loaded ) {
            $db = cmsms()->GetDb();
            $query = 'SELECT ph.*,count(pr.id) AS direct_count FROM '.cms_db_prefix().'module_products_hierarchy ph
                  LEFT OUTER JOIN '.cms_db_prefix().'module_products_prodtohier pth
                  ON ph.id = pth.hierarchy_id
                  LEFT OUTER JOIN '.cms_db_prefix().'module_products pr
                  ON pth.product_id = pr.id';
            if( !$all ) $query .= ' AND pr.status = '.$db->qstr('published');
            $query .= ' GROUP BY ph.id ORDER BY ph.hierarchy';
            $tmp = $db->GetAll($query);
            if( is_array($tmp) && count($tmp) ) $tmp = cge_array::to_hash($tmp,'id');
            self::_update_hierarchy_counts($tmp);
            self::$_allhierarchy = $tmp;
            self::$_cache_loaded = TRUE;
        }

        return self::$_allhierarchy;
    }

    public static function get_hierarchy_info($hierarchy_id)
    {
        $hierarchy_id = (int) $hierarchy_id;
        $allinfo = self::get_all_hierarchy_info();
        if( is_array($allinfo) && count($allinfo) ) {
            if( isset($allinfo[$hierarchy_id]) ) return $allinfo[$hierarchy_id];
        }
    }

    public static function get_hierarchy_info_by_name($name)
    {
        $name = trim($name);
    }

    public static function get_hierarchy_path($hier_id)
    {
        $out = array();
        while( $hier_id > 0 ) {
            $out[] = $hier_id;

            $hier_info = self::get_hierarchy_info($hier_id);
            if( !$hier_info ) break;

            $hier_id = (int) $hier_info['parent_id'];
            if( $hier_id < 0 ) break;
        }

        return array_reverse($out);
    }


    public static function get_breadcrumb($id,$hier_id,$hierpage,$delim = ' &raquo; ')
    {
        $hierarchy_path = self::get_hierarchy_path($hier_id);
        if( !$hierarchy_path ) return FALSE;

        $module = cms_utils::get_module(MOD_PRODUCTS);
        $tmp = array();
        foreach( $hierarchy_path as $one ) {
            $info = hierarchy_ops::get_hierarchy_info($one);
            $link = $module->CreateLink($id,'hierarchy',$hierpage,$info['name'],array('parent'=>$info['id']));
            $tmp[] = $link;
        }
        if( $delim != '' ) return implode($delim,$tmp);
        return $tmp;
    }

    public static function get_flat_list($full = TRUE,$id = 'prod',$returndid = '')
    {
        if( !function_exists('__hiertree_cb') ) {
            function __hiertree_cb(&$row)
            {
                global $id,$returnid,$entryarray;
                $mod = cms_utils::get_module(MOD_PRODUCTS);
                $row['ajax'] = false;  
                if( is_object($mod) ) {
                    /*ImportSEO*/
                    $row['alias'] = munge_string_to_url($row['name']);
                    $theme = cms_utils::get_theme_object();
                    $module = \cms_utils::get_module('LISESEO');
                    $arr = product_utils::get_importseo_status($row['alias']);
                    if($arr["status"] == 1){
                        $row['ajax'] = true;
                        $row['importseo'] = $mod->CreateImageLink($id,'admin_ajax_importseo', $returnid,
                                                              $mod->Lang('import_seo'),
                                                              'icons/system/back.gif',
                                                              array('hierarchy_alias'=>$row['alias']));
                    } else if($arr["status"] == 2){
                        $row['importseo'] = $module->CreateLink($id, 'admin_edititem', $returnid, $theme->DisplayImage('icons/system/accept.gif', $mod->Lang('import_seo'), '', '', 'systemicon'), array('item_id' => $arr["item_id"], 'target' => '_blank'));
                    } else {
                        $row['importseo'] = $module->CreateLink($id, 'admin_edititem', $returnid, $theme->DisplayImage('icons/system/run.gif', $mod->Lang('import_seo'), '', '', 'systemicon'), array('item_id' => $arr["item_id"], 'target' => '_blank'));
                    }
                    /*End ImportSEO*/
                    $row['edit_url'] = $mod->CreateURL($id,'admin_edit_hierarchy_item', $returnid, array('hierarchy_id'=>$row['id']));
                    $row['depth'] = count(explode('.', $row['hierarchy'])) - 1;
                    $row['edit_link'] = $mod->CreateImageLink($id,'admin_edit_hierarchy_item', $returnid,
                                                              $mod->Lang('edit_hierarchy_item'),
                                                              'icons/system/edit.gif',
                                                              array('hierarchy_id'=>$row['id']));
                    $row['delete_link'] = $mod->CreateImageLink($id,'admin_delete_hierarchy_item', $returnid,
                                                                $mod->Lang('delete_hierarchy_item'),
                                                                'icons/system/delete.gif',
                                                                array('hierarchy_id'=>$row['id']),'',
                                                                $mod->Lang('confirm_delete_hierarchy_node'));

                    $entryarray[] = $row;
                }
            }

            function __hiertree_flatten($tree,&$entryarray)
            {
                if( is_array($tree) && count($tree) ) {
                    foreach( $tree as $one ) {
                        $copy = $one;
                        unset($copy['children']);
                        $entryarray[] = $copy;
                        if( isset($one['children']) ) __hiertree_flatten($one['children'],$entryarray);
                    }
                }
            } // function.
        }

        $entryarray = array();
        $cb = '';
        if( $full ) $cb = '__hiertree_cb';
        $tree = product_utils::hierarchy_get_tree(-1,0,$cb);
        __hiertree_flatten($tree,$entryarray);
        return $entryarray;
    }

    public static function build_hierarchy_list()
    {
        $tmp = hierarchy_ops::get_flat_list(FALSE);
        $mod = cms_utils::get_module(MOD_PRODUCTS);
        $list = array(-1=>$mod->Lang('none'));
        if( is_array($tmp) && count($tmp) ) {
            foreach( $tmp as $one ) {
                $list[$one['id']] = $one['long_name'];
            }
        }
        return $list;
    }
} // end of class

#
# EOF
#
