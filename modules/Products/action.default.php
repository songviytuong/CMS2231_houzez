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
if (!isset($gCms)) exit;

$thetemplate = $this->find_layout_template($params,'summarytemplate','Products::List View');
$cache_id = '|ps'.md5(serialize($params));
$tpl = $this->CreateSmartyTemplate($thetemplate,null,$cache_id);
if( !$tpl->isCached() ) {

    // setup the query
    try {
        $query = new products_query();
        foreach( $params as $key => $value ) {
            try {
                $query[$key] = $value;
            }
            catch( Exception $e ) {
                // ignore this error.
            }
        }
        $page = \cge_param::get_int($params,'page',1);
        $query['offset'] = $query['pagelimit'] * ($page - 1);

        $results = new products_resultset($query);
        $results->curpage = $returnid;
        if( isset($params['notpretty']) ) $results->notpretty = $params['notpretty'];
        if( isset($params['detailtemplate']) ) $results->detailtemplate = $params['detailtemplate'];
        if( ($tmp = \cge_param::exists($params,'detailpage')) ) $results->detailpage = $tmp;
        $entryarray = array();
        while( !$results->EOF ) {
            $entryarray[] = $results->get_product_for_display();
            $results->MoveNext();
        }

        //
        // give everything to smarty
        //
        if( isset($query['hierarchyid']) ) $tpl->assign('active_hierarchy',$query['hierarchyid']);
        $pagination = $results->get_pagination();
        $tpl->assign('items',$entryarray);
        $tpl->assign('itemcount',count($entryarray));
        $tpl->assign('totalcount',$pagination['totalrows']);
        $tpl->assign('pagecount',$pagination['pagecount']);
        $tpl->assign('curpage',$pagination['page']);
        $page = $pagination['page'];
        if( $page == 1 ) {
            $tpl->assign('firstlink',$this->Lang('firstpage'));
            $tpl->assign('prevlink',$this->Lang('prevpage'));
        } else {
            $parms = $params;
            $parms['page'] = 1;
            $tpl->assign('firstlink',$this->CreateLink($id,'default',$returnid,$this->Lang('firstpage'),$parms));
            $tpl->assign('firstpage_url',$this->create_url($id,'default',$returnid,$parms));

            $parms['page'] = $page - 1;
            $tpl->assign('prevlink',$this->CreateLink($id,'default',$returnid,$this->Lang('prevpage'),$parms));
            $tpl->assign('prevpage_url',$this->create_url($id,'default',$returnid,$parms));
        }

        if( $page == $results->numpages ) {
            $tpl->assign('lastlink',$this->Lang('lastpage'));
            $tpl->assign('nextlink',$this->Lang('nextpage'));
        } else {
            $parms = $params;
            $parms['page'] = $results->numpages;
            $tpl->assign('lastlink',$this->CreateLink($id,'default',$returnid,$this->Lang('lastpage'),$parms));
            $tpl->assign('lastpage_url',$this->create_url($id,'default',$returnid,$parms));
            $parms['page'] = $page + 1;
            $tpl->assign('nextlink',$this->CreateLink($id,'default',$returnid,$this->Lang('nextpage'),$parms));
            $tpl->assign('nextpage_url',$this->create_url($id,'default',$returnid,$parms));
        }

        $tpl->assign('pagetext',$this->Lang('page'));
        $tpl->assign('oftext',$this->Lang('of'));
        $tpl->assign('currency_symbol',product_ops::get_currency_symbol());
        $tpl->assign('weight_units',product_ops::get_weight_units());
    }
    catch( Exception $e ) {
        echo $this->DisplayErrorMessage($e->GetMessage());
    }
}

$tpl->display();

#
# EOF
#
