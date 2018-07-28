<?php  /* -*- Mode: PHP; c-set-style: linux; tab-width: 4; c-basic-offset: 4 -*- */
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

$this->SetCurrentTab('products');
if( isset($params['cancel']) ) $this->RedirectToTab($id);

$allcats = '';
$allfields = '';
$ops = array('exportdraft'=>1,
             'exportcats'=>1,
             'exportfields'=>1,
             'exportoptions'=>1,
             'exportdelim'=>',');

function quote($str)
{
    if( is_string($str) ) return '"'.$str.'"';
}

function get_attr_parts( $in_key )
{
    // key is in the format ATTR:##_xxx.  need the index and the xxx portion.
    $parts = explode('_',$in_key,2);
    $key = $idx = null;
    if( count($parts) != 2 ) return;

    $key = trim($parts[1]);
    $idx = (int) substr($parts[0],5);
    return [ $idx, $key ];
}

function to_flat_array($product,$map)
{
    static $_cats = -1;
    if( $_cats == -1 )  $_cats = product_utils::get_categories( TRUE );
    static $_defs = -1;
    if( $_defs == -1 ) $_defs = product_utils::get_fielddefs(true,true,true);

    $out = array();
    foreach( $map as $key ) {
        switch( $key ) {
        case 'FLAG':
            $out[] = 'P';
            break;
        case 'name':
            $out[] = quote($product->name);
            break;
        case 'sku':
            $out[] = quote($product->sku);
            break;
        case 'details':
            $out[] = quote($product->details);
            break;
        case 'price':
            $out[] = $product->price;
            break;
        case 'create_date':
            $out[] = $product->create_date;
            break;
        case 'modified_date':
            $out[] = $product->modified_date;
            break;
        case 'taxable':
            $out[] = $product->taxable;
            break;
        case 'status':
            $out[] = quote($product->status);
            break;
        case 'weight':
            $out[] = $product->weight;
            break;

        case 'HIER':
            $val = '';
            if( $product->hierarchy_id ) {
                $hier = hierarchy_ops::get_hierarchy_info($product->hierarchy_id);
                if( is_array($hier) && count($hier) ) {
                    $val = str_replace('|','>>',$hier['long_name']);
                }
            }
            $out[] = quote($val);
            break;

        case 'OPTIONS':
            // Set:Attr:adj,sku--
            $val = '';
            if( isset($product->attributes) && count($product->attributes) ) {
                $idx = 0;
                $opts = array();
                foreach( $product->attributes as $option ) {
                    $tmp = array();
                    $tmp[] = quote($option['text']);
                    $tmp[] = $option['adjustment'];
                    $tmp[] = quote($option['sku']);
                    $tmp[] = (int) $option['qoh'];
                    $opts[] = implode(':',$tmp);
                }
                $val = implode('--',$opts);
            }
            $out[] = $val;
            break;

        default:
            if( startswith($key,'CAT:') ) {
                // categories are only 1 or 0
                $val = 0;
                if( isset($product->categories) && count($product->categories) ) {
                    $name = substr($key,4);
                    $id = $_cats[$name]->id;
                    if( in_array( $id, $product->categories ) ) $val = 1;
                }
                $out[] = $val;
            }
            elseif( startswith($key,'FIELD:') ) {
                $val = '';
                list($t0,$t1,$name) = explode(':',$key,3);
                $def = $_defs[$name];
                $fld_id = $def->id;
                if( isset($product->field_vals) && count($product->field_vals) && array_key_exists($fld_id,$product->field_vals) ) {
                    $in_val = $product->field_vals[$fld_id];
                    switch( $def->type ) {
                    case 'dimensions':
                        $val = 'l:'.$in_val['length'].',w:'.$in_val['width'].',h:'.$in_val['height'];
                        break;
                    case 'subscription':
                        $val = ''; // subscription info not output,or read... for now.
                        break;
                    default:
                        $val = $in_val;
                    }
                }
                $out[] = quote($val);
            }
            elseif( startswith($key,'ATTR:') ) {
                if( isset($product->attributes) && count($product->attributes) ) {
                    list($attr_idx,$attr_key) = get_attr_parts($key);
                    if( $attr_idx && $attr_key && isset($product->attributes[$attr_idx]) ) {
                        $val = $product->attributes[$attr_idx][$attr_key];
                        $out[] = quote($val);
                    }
                }

            }
        }
    }
    return $out;
}

if( isset($params['submit']) ) {
    set_time_limit(9999);

    //Then force the output normally and exit so we don't get a footer
    header("Content-disposition: attachment; filename=products." . date("Y-m-d") . ".csv");
    header("Content-type: text/csv");
    flush();

    $ops['exportcats'] = (int)$params['exportcats'];
    $ops['exportdraft'] = (int)$params['exportdraft'];
    $ops['exportfields'] = (int)$params['exportfields'];
    $ops['exportoptions'] = (int)$params['exportoptions'];
    $ops['exportdelim'] = trim($params['exportdelim']);
    $this->SetPreference('exportoptions',serialize($ops));

    // now do the export.
    if( $ops['exportcats'] ) {
        $allcats = product_utils::get_categories();
        $map = array('FLAG','name','sku','details','price','create_date','modified_date','taxable','status','weight','HIER');
        if( is_array($allcats) && count($allcats) ) {
            foreach( $allcats as $one ) {
                $map[] = 'CAT:'.$one->name;
            }
        }
    }

    if( $ops['exportfields'] ) {
        $allfields = product_utils::get_fielddefs(TRUE,TRUE);
        if( is_array($allfields) && count($allfields) ) {
            foreach( $allfields as $one ) {
                $map[] = 'FIELD:'.$one->type.':'.$one->name;
            }
        }
    }

    if( $ops['exportoptions'] ) {
        for( $i = 1; $i <= 20; $i++ ) {
            $prefix = sprintf("ATTR:%02d_",$i);
            $map[] = $prefix.'text';
            $map[] = $prefix.'adjustment';
            $map[] = $prefix.'sku';
            $map[] = $prefix.'qoh';
        }
    }

    $handlers = ob_list_handlers();
    for ($cnt = 0; $cnt < sizeof($handlers); $cnt++) { ob_end_clean(); }
    $output = '';
    {
        $header = $map;
        foreach( $header as &$one ) {
            $parts = explode(':',$one);
            if( count($parts) > 1 ) {
                $last = $parts[count($parts)-1];
                if( strpos($last,$ops['exportdelim']) !== FALSE ) {
                    $parts[count($parts)-1] = quote($last);
                    $one = implode(':',$parts);
                }
            }
            $one = '#'.$one;
        }
        $output .= implode($ops['exportdelim'],$header)."\n";
    }
    echo $output; flush();

    // now get the products...
    $query = new products_query();
    $query['pagelimit'] = 1000000;
    if( $ops['exportdraft'] ) $query['status'] = '!disabled';
    $results = new products_resultset($query);

    while( !$results->EOF ) {
        $product = $results->get_product(); // really don't need this for export, cuz links are irrelevant
        $tmp = to_flat_array($product,$map);
        $output = implode($ops['exportdelim'],$tmp)."\n";
        $results->MoveNext();
        echo $output; flush();
    }

    audit('',$this->GetName(),'Exported product data to csv');
    exit();
}


$tmp = $this->GetPreference('exportoptions');
if( $tmp ) $ops = unserialize($tmp);

$smarty->assign('options',$ops);
$smarty->assign('formstart',$this->CGCreateFormStart($id,'exportcsv'));
$smarty->assign('formend',$this->CreateFormEnd());
echo $this->ProcessTemplate('exportcsv.tpl');

#
# EOF
#
