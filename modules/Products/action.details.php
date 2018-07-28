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

$thetemplate = $this->find_layout_template($params,'detailtemplate','Products::Detail View');
$cache_id = '|pd'.md5(serialize($params));
$tpl = $this->CreateSmartyTemplate($thetemplate,null,$cache_id);
if( !$tpl->isCached() ) {
    $query = new products_query;
    if( isset($params['productid']) ) {
        $query['productid'] = $params['productid'];
    }
    else if( isset($params['alias']) ) {
        $query['alias'] = $params['alias'];
    }
    $rs = $query->execute();
    $rs->curpage = $returnid;
    if( $rs->totalrows == 1 ) {
        $onerow = $rs->get_product_for_display();
        if( $onerow->hierarchy_id > 0 ) $tpl->assign('active_hierarchy',$onerow->hierarchy_id);
        $tpl->assign('weight_units',product_ops::get_weight_units());
        $tpl->assign('currency_symbol',product_ops::get_currency_symbol());
        $tpl->assign('entry',$onerow);
    }
    else {
        // product not found for some reason.
        $action = $this->GetPreference('prodnotfound','domsg');
        switch($action) {
        case 'do404':
            throw new CmsError404Exception('product not found');
            break;

        case 'do301':
            $page = $this->GetPreference('prodnotfoundpage',-1);
            if( $page != '' && $page != -1 ) cge_redirect::redirect301($page);
            // fall through to domsg

        case 'domsg':
        default:
            $msg = $this->GetPreference('prodnotfoundmsg', $this->Lang('error_product_notfound'));
            echo $this->ProcessTemplateFromData($msg);
            return;
        }
    }
}

$tpl->display();