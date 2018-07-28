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

//
// initialization
//
$fields = array();
{
    // get all of the field definitions
    // and filter them for the ones that we can search on.
    $tmp = product_utils::get_fielddefs();
    if( count($tmp) ) {
        for( $i = 0; $i < count($tmp); $i++ ) {
            $obj = $tmp[$i];
            if( in_array($obj->type,array('textbox','checkbox','textarea','dropdown')) ) {
                $fields[$obj->name] = $obj;
            }
        }
    }
}

$detailpage = $this->GetPreference('detailpage',$returnid);
$thetemplate = $this->find_layout_template($params,'summarytemplate','Products::List View');
$destpage = $returnid;
$entryarray = '';
$npages = 0;
$inline = 0;


//
// handle params
//
if( isset($params['cd_cancel']) ) $this->RedirectContent($destpage);
if( isset($params['cd_ser']) && isset($params['cd_serck']) ) {
    $salt = __DIR__;
    if( md5($salt.$params['cd_ser']) == $params['cd_serck'] ) {
        $tmp = unserialize(base64_decode($params['cd_ser']));
        if( is_array($tmp) && count($tmp) ) {
            unset($params['cd_ser'],$params['cd_serck']);
            $params = array_merge($tmp,$params);
        }
    }
}

if( isset($params['summarytemplate']) ) $thetemplate = 'summary_'.$params['summarytemplate'];
if( isset($params['cd_notpretty']) ) {
    $params['notpretty'] = $params['cd_notpretty'];
    unset($params['cd_notpretty']);
}
if( isset($params['cd_detailpage']) ) {
    $params['detailpage'] = $params['cd_detailpage'];
    unset($params['cd_detailpage']);
}
if( isset($params['cd_pagelimit']) ) {
    $params['pagelimit'] = $params['cd_pagelimit'];
    unset($params['cd_pagelimit']);
}
if( isset($params['cd_origpage']) ) $destpage = (int)$params['cd_origpage'];
if( isset($params['pagelimit']) ) {
    $pagelimit = (int)$params['pagelimit'];
    $pagelimit = max($pagelimit,1);
    $pagelimit = min(500,$pagelimit);
}
if( isset($params['cd_sortby']) ) {
    $params['sortby'] = $params['cd_sortby'];
    unset($params['cd_sortby']);
}
if( isset($params['cd_sortorder']) ) {
    $params['sortorder'] = $params['cd_sortorder'];
    unset($params['cd_sortorder']);
}
if( isset($params['detailpage']) ) {
    $str = trim($params['detailpage']);
    if( $str ) $str = $this->resolve_alias_or_id($str);
    if( $str ) $detailpage = $str;
}

//
// handle form submission
//
try {
    // take the params passed from the tag, and/or form, or from a pagination link and build a query object
    $products_query = new products_query;
    foreach( $params as $key => $value ) {
        try {
            $products_query[$key] = $value;
        }
        catch( Exception $e ) {
            // ignore this error.
        }
    }

    if( isset($params['cd_prodname']) && $params['cd_prodname']) $products_query['productnamelike'] = trim($params['cd_prodname']);
    if( isset($params['cd_proddesc']) && $params['cd_proddesc']) $products_query['desclike'] = trim($params['cd_proddesc']);
    if( isset($params['cd_allany']) ) $products_query['useor'] = $params['cd_allany'];

    if( isset($params['cd_prodprice_min']) || isset($params['cd_prodprice_max']) ) {
        if( isset($params['cd_prodprice_min']) ) $price_min = (float)trim($params['cd_prodprice_min']);
        if( isset($params['cd_prodprice_max']) ) $price_max = (float)trim($params['cd_prodprice_max']);
        $products_query['pricerange'] = "{$price_min}:{$price_max}";
    }
    else if( isset($params['cd_prodprice']) && $params['cd_prodprice'] != -1 ) {
        if( strpos($params['cd_prodprice'],':') !== FALSE ) {
            list($min,$max) = explode(':',trim($params['cd_prodprice']),2);
            $min = trim($min);
            $max = trim($max);
            if( $min != '' && $max != '' ) {
                $min = floatval($min);
                $max = floatval($max);
                $products_query['pricerange'] = "{$min}:{$max}";
            }
            else if( $min != '' ) {
                $min = floatval($min);
                $products_query['pricerange'] = "{$min}:";
            }
            else if( $max  != '' ) {
                $max = floatval($max);
                $products_query['pricerange'] = ":{$max}";
            }
        }
    }

    if( isset($params['cd_prodvalue']) && !is_array($params['cd_prodvalue']) ) $params['cd_prodvalue'] = unserialize($params['cd_prodvalue']);
    $tfields = array_keys($fields);
    foreach( $tfields as $one ) {
        $fieldid = $fields[$one]->id;
        if( isset($params['cd_prodvalue'][$one]) && $params['cd_prodvalue'][$one] != '-1' && !empty($params['cd_prodvalue'][$one]) ) {
            $products_query->add_field_expr($fieldid,trim($params['cd_prodvalue'][$one]));
            continue;
        }

        $key1 = 'cd_prodvalue_'.$one.'_min';
        $key2 = 'cd_prodvalue_'.$one.'_max';
        if( isset($params[$key1]) || isset($params[$key2]) ) {
            $tdata = array('min'=>'','max'=>'');
            if( isset($params[$key1]) ) $tdata['min'] = (float)trim($params[$key1]);
            if( isset($params[$key2]) ) $tdata['max'] = (float)trim($params[$key2]);
            if( $tdata['min'] && $tdata['max'] ) {
                if( $tdata['min'] > $tdata['max'] ) {
                    $tmp = $tdata['max'];
                    $tdata['max'] = $tdata['min'];
                    $tdata['min'] = $tmp;
                }
                $products_query->add_field_expr($fieldid,"{$tdata['min']}:{$tdata['max']}");
            }
            else if( $tdata['min'] ) {
                $products_query->add_field_expr($fieldid,"{$tdata['min']}:");
            }
            else if( $tdata['max'] ) {
                $products_query->add_field_expr($ieldid,":{$tdata['min']}");
            }
        }
    }

    $results = $products_query->execute();
    $results->curpage = $returnid;
    if( isset($params['notpretty']) ) $results->notpretty = $params['notpretty'];
    if( isset($params['detailpage']) ) $results->detailpage = $params['detailpage'];
    if( isset($params['detailtemplate']) ) $results->detailtemplate = $params['detailtemplate'];
    $entryarray = array();
    while( !$results->EOF ) {
        $entryarray[] = $results->get_product_for_display();
        $results->MoveNext();
    }

    $smarty->assign('items', $entryarray);
    $smarty->assign('itemcount', count($entryarray));
    $smarty->assign('totalcount',$results->totalrows);
    $smarty->assign('pagecount',$results->numpages);
    $pagination = $results->get_pagination();
    $smarty->assign('curpage',$pagination['page']);

    $ser = base64_encode(serialize($params));
    $serck = md5(__DIR__.$ser);
    $parms = array('cd_ser'=>$ser,'cd_serck'=>$serck);

    $page = $pagination['page'];
    if( $page == 1 ) {
        $smarty->assign('firstlink',$this->Lang('firstpage'));
        $smarty->assign('prevlink',$this->Lang('prevpage'));
    } else {
        $parms['page'] = 1;
        $smarty->assign('firstlink',$this->CreateLink($id,'do_search',$returnid,$this->Lang('firstpage'),$parms));
        $smarty->assign('firstpage_url',$this->create_url($id,'do_search',$returnid,$parms));

        $parms['page'] = $page - 1;
        $smarty->assign('prevlink',$this->CreateLink($id,'do_search',$returnid,$this->Lang('prevpage'),$parms));
        $smarty->assign('prevpage_url',$this->create_url($id,'do_search',$returnid,$parms));
    }

    if( $page == $results->numpages ) {
        $smarty->assign('lastlink',$this->Lang('lastpage'));
        $smarty->assign('nextlink',$this->Lang('nextpage'));
    } else {
        $parms['page'] = $results->numpages;
        $smarty->assign('lastlink',$this->CreateLink($id,'do_search',$returnid,$this->Lang('lastpage'),$parms));
        $smarty->assign('lastpage_url',$this->create_url($id,'do_search',$returnid,$parms));
        $parms['page'] = $page + 1;
        $smarty->assign('nextlink',$this->CreateLink($id,'do_search',$returnid,$this->Lang('nextpage'),$parms));
        $smarty->assign('nextpage_url',$this->create_url($id,'do_search',$returnid,$parms));
    }

    $smarty->assign('pagetext',$this->Lang('page'));
    $smarty->assign('oftext',$this->Lang('of'));
    $smarty->assign('currency_symbol',product_ops::get_currency_symbol());
    $smarty->assign('weight_units',product_ops::get_weight_units());
}
catch( Exception $e ) {
    \cge_utils::log_exception( $e );
    die('got exception: '.$e->GetMessage());
}

//
// Process the template
//
echo $this->ProcessTemplateFromDatabase($thetemplate);

#
# EOF
#
