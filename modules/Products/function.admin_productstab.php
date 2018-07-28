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
if (!$this->CheckPermission('Modify Products') ) return;

//
// Setup
//
$pagelimits = array('2'=>2,'5'=>5,'25'=>25,'100'=>100,'500'=>500);
$sortitems = array();
$sortitems[$this->Lang('productname')] = 'product_name';
$sortitems[$this->Lang('price')] = 'price';
$sortitems[$this->Lang('weight')] = 'weight';
$sortitems[$this->Lang('sku')] = 'sku';
$sortitems[$this->Lang('createddate')] = 'p.create_date';
$sortitems[$this->Lang('modifieddate')] = 'p.modified_date';
$sortorders = array();
$sortorders[$this->Lang('ascending')] = 'asc';
$sortorders[$this->Lang('descending')] = 'desc';
$uid = get_userid(false);
$bare_filter = array('productname'=>'','sku'=>'','hierarchy'=>'','children'=>0,'pagelimit'=>25,'sortby'=>'p.create_date',
		     'sortorder'=>'desc','categories'=>array(),'excludecats'=>0,'custom_fields'=>array());
$filter = $bare_filter;
$tmp = cms_userprefs::get('products_filter');
if( $tmp ) {
    $tmp = unserialize($tmp);
    $filter = array_merge($bare_filter,$tmp);
}

// $hierarchy = '';
// $children  = 0;
// $pagelimit = 25;
// $sortby    = 'create_date';
// $sortorder = 'desc';
$pagenumber = 1;
$fields_viewable = $field_names = [];

if( isset($params['reset']) ) {
    $filter = $bare_filter;
    cms_userprefs::remove('products_filter');
    unset($_SESSION['products_sel_pagenum']);
}

//
// Get preferences
//

//
// Handle Get parameters
//
if( isset($_SESSION['products_sel_pagenum']) ) $pagenumber = (int)$_SESSION['products_sel_pagenum'];
if( isset($params['pagenumber']) ) $pagenumber = (int)$params['pagenumber'];
$pagenumber = max(1,$pagenumber);
if( $pagenumber > 1 ) $_SESSION['products_sel_pagenum'] = $pagenumber;

//
// Handle form submit
//
if( isset($params['submit']) ) {
    $filter['productname'] = trim($params['input_productname']);
    $filter['sku'] = trim($params['input_sku']);
    if( $filter['productname'] ) $filter['sku'] = ''; // one, or the other.. but not both.
    $filter['hierarchy'] = (int)($params['input_hierarchy']);
    $filter['children'] = (int)$params['input_children'];
    $filter['pagelimit'] = (int)$params['input_pagelimit'];
    $filter['pagelimit'] = max(1,min(500,$filter['pagelimit']));
    $filter['sortby'] = trim($params['input_sortby']);
    $filter['sortorder'] = trim($params['input_sortorder']);
    $filter['custom_fields'] = array();
    if( isset($params['custom_fields']) ) $filter['custom_fields'] = $params['custom_fields'];
    $filter['categories'] = array();
    if( isset($params['categories']) ) $filter['categories'] = $params['categories'];
    $filter['excludecats'] = (int)cge_utils::get_param($params,'input_excludecats');

    cms_userprefs::set('products_filter',serialize($filter));
    unset($_SESSION['products_sel_pagenum']);
    $pagenumber = 1;
}

//
// Begin the form
//
$tpl = $this->CreateSmartyTemplate('productlist.tpl');
$tmp = product_utils::get_categories();
if( is_array($tmp) && count($tmp) ) {
    $category_list = array();
    foreach( $tmp as $one ) {
        $category_list[$one->id] = $one->name;
    }
    $tpl->assign('category_list',$category_list);
}

$fielddefs = product_utils::get_fielddefs();
foreach( $fielddefs as $onedef ) {
    switch( $onedef->type ) {
    case 'textbox':
        $sortitems[$onedef->prompt] = 'F::'.$onedef->id;
        $sortitems[$onedef->prompt.' ('.$this->Lang('numeric').')'] = 'F::'.$onedef->id.'::N';
        break;
    case 'dropdown':
        $sortitems[$onedef->prompt] = 'F::'.$onedef->id;
        break;
    }
}

$fields_viewable['P:sku'] = $this->Lang('sku');
$fields_viewable['P:url'] = $this->Lang('url_slug');
$fields_viewable['P:alias'] = $this->Lang('url_alias');
$fields_viewable['P:weight'] = $this->Lang('weight');
$fields_viewable['P:owner'] = $this->Lang('owner');
$fields_viewable['P:modified_date'] = $this->Lang('last_modified');
$all_fields = product_ops::get_fields();
if( is_array($all_fields) ) {
    for( $i = 0; $i < count($all_fields); $i++ ) {
        switch( $all_fields[$i]['type'] ) {
        case 'image':
        case 'textarea':
            break;
        default:
            $fields_viewable['C:'.$all_fields[$i]['id']] = $all_fields[$i]['prompt'];
            $field_names[$all_fields[$i]['id']] = $all_fields[$i]['name'];
            break;
        }
    }
    if( count($fields_viewable) ) {
        // now trim down the custom fields
        // to make sure that something hasn't been deleted.
        $tmp = array();
        foreach( $filter['custom_fields'] as $fid ) {
            if( in_array($fid,array_keys($fields_viewable)) ) $tmp[] = $fid;
        }
        $filter['custom_fields'] = $tmp;
    }
    else {
        $filter['custom_fields'] = array();
    }
}
$all_fields = cge_array::to_hash($all_fields,'name');

$filterinuse = ($filter == $bare_filter)?FALSE:TRUE;
$tpl->assign('formstart',$this->CGCreateFormStart($id,'defaultadmin'));
$tpl->assign('formend',$this->CreateFormEnd());
$tpl->assign('fields_viewable',$fields_viewable);
$tpl->assign('field_names',$field_names);
$tpl->assign('filter',$filter);
$tpl->assign('filterinuse',$filterinuse);
$tpl->assign('input_hierarchy',$this->CreateHierarchyDropdown($id,'input_hierarchy',$filter['hierarchy']));
$tpl->assign('input_children',$this->CreateInputYesNoDropdown($id,'input_children',$filter['children']));
$tpl->assign('input_sortby',$this->CreateInputDropdown($id,'input_sortby',$sortitems,-1,$filter['sortby']));
$tpl->assign('input_sortorder',$this->CreateInputDropdown($id,'input_sortorder',$sortorders,-1,$filter['sortorder']));
$tpl->assign('input_pagelimit',$this->CreateInputDropdown($id,'input_pagelimit',$pagelimits,-1,$filter['pagelimit']));
$tpl->assign('input_excludecats',$this->CreateInputYesNoDropdown($id,'input_excludecats',$filter['excludecats']));

//
// Build the query
//
$fields = array();
$fields[] = 'DISTINCT p.*';
$prefix1 = "SELECT <FIELDS> FROM ".cms_db_prefix()."module_products p ";
$prefix2 = "SELECT count(p.id) AS count FROM ".cms_db_prefix().'module_products p ';
$where = array();
$joins = array();
$qparms = array();

if( $filter['productname'] ) {
    $tmp = $filter['productname'];
    $tmp = str_replace('*','%',$tmp);
    if( strpos('%',$tmp) === FALSE ) $tmp = $tmp . '%';
    $tmp = str_replace('%%','%',$tmp);
    $where[] = 'p.product_name LIKE ?';
    $qparms[] = $tmp;
}
else if( $filter['sku'] ) {
    $tmp = $filter['sku'];
    $tmp = str_replace('*','%',$tmp);
    if( strpos('%',$tmp) === FALSE ) $tmp = $tmp . '%';
    $tmp = str_replace('%%','%',$tmp);
    $joins[] = 'LEFT JOIN '.cms_db_prefix().'module_products_attribs PA ON p.id = PA.product_id';
    $where[] = '(p.sku LIKE ? OR PA.sku LIKE ?)';
    $qparms[] = $tmp;
    $qparms[] = $tmp;
}

if( count($filter['custom_fields']) && count($fields_viewable) ) {
    for( $j = 0; $j < count($filter['custom_fields']); $j++ ) {
        $fid = $filter['custom_fields'][$j];
        if( !startswith( $fid, 'C:') ) continue;
        $fid = (int) substr($fid,2);
        $fields[] = "Fv{$j}.value AS 'Fld__{$field_names[$fid]}'";
        $joins[] = 'LEFT OUTER JOIN '.cms_db_prefix()."module_products_fieldvals Fv{$j} ON Fv{$j}.product_id = p.id AND Fv{$j}.fielddef_id = ".$fid;
    }
}

if( !empty($filter['hierarchy']) ) {
    $tquery = 'SELECT long_name FROM '.cms_db_prefix().'module_products_hierarchy WHERE id = ?';
    $long_name = $db->GetOne($tquery,[ (int) $filter['hierarchy'] ]);

    $joins[] = 'LEFT JOIN '.cms_db_prefix().'module_products_prodtohier ph ON ph.product_id = p.id';
    $joins[] = 'LEFT JOIN '.cms_db_prefix().'module_products_hierarchy h ON h.id = ph.hierarchy_id';
    $where[] = 'h.long_name LIKE ?';
    if( $filter['children'] ) {
        $qparms[] = $long_name.'%';
    }
    else {
        $qparms[] = $long_name;
    }
}

if( count($filter['categories']) > 0 ) {
    $joins[] = 'LEFT OUTER JOIN '.cms_db_prefix().'module_products_product_categories pc ON p.id = pc.product_id';
    if( $filter['excludecats'] ) {
        $where[] = 'COALESCE(pc.category_id,-1) NOT IN ('.implode(',',$filter['categories']).')';
    }
    else {
        $where[] = 'pc.category_id IN ('.implode(',',$filter['categories']).')';
    }
}

// handle funky custom field sort orders
if( startswith($filter['sortby'],'F::') ) {
    list($junk,$fid,$numeric) = explode('::',$filter['sortby'],3);
    $joins[] = 'LEFT JOIN '.cms_db_prefix().'module_products_fieldvals fv ON fv.product_id = p.id';
    $where[] = 'fv.fielddef_id = ?';
    $qparms[] = $fid;
    if( $numeric ) {
        $order = " ORDER BY CAST(fv.value AS DECIMAL(12,3)) {$filter['sortorder']}";
    } else {
        $order = " ORDER BY fv.value {$filter['sortorder']}";
    }
}
else {
    $order = " ORDER BY {$filter['sortby']} {$filter['sortorder']}";
}

$str = implode(' ',$joins);
if( count($where) ) {
    $str .= ' WHERE ' . implode(' AND ',$where) . $order;
}
else {
    $str .= $order;
}
$query1 = str_replace('<FIELDS>',implode(',',$fields),$prefix1) . $str;
$query2 = $prefix2 . $str;

//
// Setup start element, and count pages
//
$totalcount = $db->GetOne($query2,$qparms);
$pagecount = (int)($totalcount/$filter['pagelimit']);
if( ($totalcount % $filter['pagelimit']) != 0 ) $pagecount++;
$startelement = ($pagenumber-1) * $filter['pagelimit'];

//
// Begin the output
//
$tpl->assign('totalproducts',$db->GetOne('SELECT COUNT(id) FROM '.cms_db_prefix().'module_products'));
$tpl->assign('pagenumber',$pagenumber);
$tpl->assign('pagecount',$pagecount);
$tpl->assign('totalrows',$totalcount);
if( $pagenumber > 1 ) {
    $parms = array('pagenumber'=>1);
    $tpl->assign('firstpage_url', $this->CreateURL($id,'defaultadmin','',$parms));
    $parms = array('pagenumber'=>$pagenumber -1);
    $tpl->assign('prevpage_url', $this->CreateURL($id,'defaultadmin','',$parms));
}
if( $pagenumber < $pagecount ) {
    $parms = array('pagenumber'=>$pagenumber + 1);
    $tpl->assign('nextpage_url', $this->CreateURL($id,'defaultadmin','',$parms));
    $parms = array('pagenumber'=>$pagecount);
    $tpl->assign('lastpage_url', $this->CreateURL($id,'defaultadmin','',$parms));
}
$entryarray = array();
$dbresult = $db->SelectLimit($query1,$filter['pagelimit'],$startelement,$qparms);
$theme = cms_utils::get_theme_object();
while ($dbresult && $row = $dbresult->FetchRow()) {
    foreach( $row as $key => $value ) {
        if( startswith($key,'Fld__') ) {
            unset($row[$key]);
            $key = substr($key,strlen('Fld__'));
            $row[$key] = $value;

            $tmp = @unserialize($value);
            if( $tmp !== FALSE ) {
                $row[$key] = product_utils::get_displayable_fieldval($key,$tmp);
            }
            else {
                $row[$key] = product_utils::get_displayable_fieldval($key,$value);
            }
        }
    }
    
    $row['ajax'] = false;
    /*ImportSEO*/
    $theme = cms_utils::get_theme_object();
    $module = \cms_utils::get_module('LISESEO');
    $mod = \cms_utils::get_module(MOD_PRODUCTS);
    $arr = product_utils::get_importseo_status($row['sku']);
    
    if($arr["status"] == 1){
        $row['ajax'] = true;
        $row['importseo'] = $mod->CreateImageLink($id,'admin_ajax_importseo', $returnid,
                                              $mod->Lang('import_seo'),
                                              'icons/system/back.gif',
                                              array('compid' => $row['id']));
    } else if($arr["status"] == 2){
        $row['importseo'] = $module->CreateLink($id, 'admin_edititem', $returnid, $theme->DisplayImage('icons/system/accept.gif', $mod->Lang('import_seo'), '', '', 'systemicon'), array('item_id' => $arr["item_id"], 'target' => '_blank'));
    } else {
        $row['importseo'] = $module->CreateLink($id, 'admin_edititem', $returnid, $theme->DisplayImage('icons/system/run.gif', $mod->Lang('import_seo'), '', '', 'systemicon'), array('item_id' => $arr["item_id"], 'target' => '_blank'));
    }
    /*End ImportSEO*/
    

    $row['edit_url'] = $this->CreateURL($id,'editproduct',$returnid, array('compid'=>$row['id']));
    $row['editlink'] = $this->CreateLink($id, 'editproduct', $returnid,
                                         $theme->DisplayImage('icons/system/edit.gif', $this->Lang('edit'),'','','systemicon'),
                                         array('compid'=>$row['id']));
    $row['copylink'] = $this->CreateLink($id, 'admin_copyproduct', $returnid,
                                         $theme->DisplayImage('icons/system/copy.gif', $this->Lang('copy_product'),'','','systemicon'), array('compid'=>$row['id']));
    $row['deletelink'] = $this->CreateLink($id, 'deleteproduct', $returnid,
                                           $theme->DisplayImage('icons/system/delete.gif', $this->Lang('delete'),'','','systemicon'), array('compid'=>$row['id']),
                                           $this->Lang('areyousure_deleteproduct'));
    $entryarray[] = $row;
}

$tpl->assign('items', $entryarray);
$tpl->assign('itemcount', count($entryarray));

$tpl->assign('importlink',
             $this->CreateImageLink($id,'importproducts',$returnid,$this->Lang('import_from_csv'), 'icons/system/import.gif',array(),'','',false));

$tpl->assign('exportlink',
             $this->CreateImageLink($id,'exportcsv',$returnid,$this->Lang('export_to_csv'), 'icons/system/export.gif',array(),'','',false));
$tpl->assign('addlink',
             $this->CreateLink($id, 'addproduct', $returnid,
                               $theme->DisplayImage('icons/system/newfolder.gif', $this->Lang('addproduct'),'','','systemicon'),
                               array('hierarchy'=>$filter['hierarchy']), '', false, false, '') .' '.
             $this->CreateLink($id, 'addproduct', $returnid, $this->Lang('addproduct'),
                               array('hierarchy'=>$filter['hierarchy']), '', false, false, 'class="pageoptions"'));

$tpl->assign('allowtravel', $this->GetPreference('allowtravel',0));

$tpl->assign('idtext',$this->Lang('id'));
$tpl->assign('producttext', $this->Lang('product'));
$tpl->assign('sku', $this->Lang('sku'));
$tpl->assign('pricetext', $this->Lang('price'));
$tpl->assign('weight_units',product_ops::get_weight_units());
$tpl->assign('weighttext',$this->Lang('weight'));
$tpl->assign('formstart2',$this->CreateFormStart($id,'admin_bulkaction',$returnid));
$tpl->assign('formend2',$this->CreateFormEnd());
$tpl->assign('filterinuse',$filterinuse);
$bulkactions = array();
$bulkactions['delete'] = $this->Lang('delete');
$bulkactions['setdraft'] = $this->Lang('setdraft');
$bulkactions['setdisabled'] = $this->Lang('setdisabled');
$bulkactions['setpublished'] = $this->Lang('setpublished');
if( product_utils::have_quantity_field() ) {
    $bulkactions['editquantity'] = $this->Lang('editquantity');
}
$tpl->assign('bulkactions',$bulkactions);

// Display template
$tpl->display();

// EOF
