<?php
#BEGIN_LICENSE
#-------------------------------------------------------------------------
# Module: Banners (c) 2008 by Robert Campbell
#         (calguy1000@cmsmadesimple.org)
#  An addon module for CMS Made Simple to allow management, display,
#  and tracking of banner images.
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
if( !$this->CheckPermission('Banners Manager') ) exit;

// get a category list for the filter
$categorylist = \Banners\category::get_list();
$theme = cms_utils::get_theme_object();

// get the current category for the filter
$dfltcategory = null;
if( count($categorylist) ) {
    $keys = array_keys($categorylist);
    $dfltcategory = $keys[0];
}
$curcategory = get_preference(get_userid(),'banners_curcategory',$dfltcategory);
if( isset($params['submitcategory']) ) {
    $curcategory = (isset ($params['input_category']) ? $params['input_category'] :'');
    set_preference(get_userid(),'banners_curcategory',$curcategory);
}


if( !$categorylist ) {
    $smarty->assign('error',1);
    $smarty->assign('message', $this->Lang('error_nocategories'));
}
else {
    $rowarray = null;
    $smarty->assign('categorylist',$categorylist);
    $smarty->assign('curcategory',$curcategory);
    // setup the form part of the template
    $smarty->assign ('startform', $this->CreateFormStart ($id, 'defaultadmin'));
    $smarty->assign ('input_category', $this->CreateInputDropDown ($id, "input_category", $categorylist, -1, $curcategory));
    $smarty->assign ('endform', $this->CreateFormEnd ());

    if( $curcategory != '' ) {
        // fill in the banners part of the report
        $dbresult = null;
        $rowarray = array();
        // correlated subquery, neat eh.
        $query = 'SELECT b.*,
                        (SELECT COUNT(*) FROM '.cms_db_prefix().'module_banners_hits h WHERE h.banner_id = b.banner_id) AS hits
                  FROM '.cms_db_prefix().'module_banners b
                  WHERE b.category_id = ?';
        $dbresult = $db->Execute( $query, array((int)$curcategory));

        while( $row = $dbresult->FetchRow() ) {

            $onerow = new stdClass();
            $onerow->id = $row['banner_id'];
            $onerow->name = $row['name'];
            $onerow->description = $row['description'];
            $onerow->created = $row['created'];
            $onerow->start = $row['start_date'];
            $onerow->hits = $row['hits'];
            if( $row['expires'] == false ) {
                $onerow->expires = $this->Lang('never');
            }
            else {
                $onerow->expires = $row['expires'];
            }
            $onerow->impressions = $row['num_impressions'];
            $onerow->max_impressions = ($row['max_impressions'] == '') ? 0 : $row['max_impressions'];
            $onerow->start_ts = $db->UnixTimeStamp($row['start_date']);
            $onerow->expires_ts = $db->UnixTimeStamp($row['expires']);
            $onerow->fin_expr = ($onerow->impressions >= $onerow->max_impressions && $onerow->max_impressions > 0);
            $rowarray[] = $onerow;
        } // while
        $dbresult->Close();
        unset($dbresult);
    } // if

    $smarty->assign('items',$rowarray);
    $smarty->assign('itemcount', count($rowarray));
    $smarty->assign ('addbanner',
                     $this->CreateImageLink ($id, 'addbanner', $returnid, $this->Lang ('addbanner'), 'icons/system/newobject.gif',
                                             array ('category_id' => $curcategory), '', '', false));

    $smarty->assign ('report_url',
                     $this->CreateURL( $id, 'statsreport', $returnid, array('disable_theme'=>1) ));

} // else

echo $this->ProcessTemplate('bannerlist.tpl');
