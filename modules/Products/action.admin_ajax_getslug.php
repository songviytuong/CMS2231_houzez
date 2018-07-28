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
if (!$this->CheckPermission('Modify Products')) return;

$pid = \cge_param::get_int($params,'pid');
$name = \cge_param::get_string($params,'name');
$hier_id = \cge_param::get_int($params,'hier');
$tmp = \cge_utils::get_param($params,'cats');

// clean cats array
$cats_t = array();
foreach( $cats_t as $cat ) {
    $tmp_i = (int) $cat;
    if( $tmp_i > 0 ) $cats_t[] = $tmp_i;
}
$cats_t = array_unique($cats_t);

// get all of our herarchies and categories
$hier = hierarchy_ops::get_hierarchy_info($hier_id);
$allcats = product_utils::get_categories();


// give everything to smarty
// we give the hierarchy long name to smarty in a few ways
// as an array, and as a single string
$tpl = 'string:{strip}'.$this->GetTemplate('slugtemplate').'{/strip}';
$tpl = $smarty->CreateTemplate($tpl);
$ln = $hier['long_name'];
$parts_t = explode(' | ',$ln);
$parts = array();
foreach( $parts_t as $p ) {
    $p = trim(munge_string_to_url($p));
    if( $p ) $parts[] = $p;
}
$tpl->assign('hier_parts',$parts);
$tpl->assign('hierarchy',implode('/',$parts));
$tpl->assign('hierarchy3',implode('/',array_slice($parts,0,3)));

$categories = array();
if( count($cats_t) ) {
    foreach( $cats_t as $c_id ) {
        if( !isset($allcats[$c_id]) ) continue;
        $categories[] = munge_string_to_url($callcats[$c_id]['name']);
    }
}
$tpl->assign('category_parts',$categories);
$firstcat = (count($categories))?$categories[0]:'';
$tpl->assign('first_category',$firstcat);
$tpl->assign('name',trim(munge_string_to_url($name)));

$test_i = 1;
$base_url = $tpl->fetch();
while( $test_i < 100 ) {
    // process the template
    $url = trim($base_url," /\t\r\n\0\x08");
    if( $test_i > 1 ) $url .= "-{$test_i}";
    $test_i++;

    $route = cms_route_manager::find_match($url);
    if( !$route ) break;

    $dflts = $route->get_defaults();
    if( $rout->get_dest() == $this->GetName() ) {
        // route is for this module
        if( isset($dflts['compid']) && $dflts['compid'] == $pid ) {
            // it's for this product
            break;
        }
    }
}

// give it back via ajax
\cge_utils::send_ajax_and_exit($url);

#
# EOF
#
?>
