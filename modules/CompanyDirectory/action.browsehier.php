<?php  /* -*- Mode: PHP; tab-width: 4; c-basic-offset: 2 -*- */
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
if( !isset($gCms) ) exit;

// initialization
$thetemplate = 'hierlist_'.$this->GetPreference(COMPANYDIR_PREF_DFLTHIERLIST_TEMPLATE);
if( isset($params['hierlisttemplate'] ) ) $thetemplate = 'hierlist_'.$params['hierlisttemplate'];

$category = '';
$category_info = '';
$where = array();
$parms = array();
$querystart = 'SELECT ch.*,count(cc.id) as count FROM '.cms_db_prefix().'module_compdir_hier ch LEFT OUTER JOIN '.cms_db_prefix().'module_compdir_companies cc ON ch.id = cc.hier_id';
$queryend = 'GROUP BY ch.id ORDER BY hierarchy';

$hier = trim(cge_utils::get_param($params,'hier',-1));
// find the id of the starting point, given it's name
if( $hier && !is_numeric($hier) ) {
  $list = cd_utils::get_hierarchy();
  foreach( $list as $row ) {
    if( $row['name'] == $hier ) {
      $hier = (int)$row['id'];
      break;
    }
  }
}

// get the count(s)
$count_list = array();
{
  $query = 'SELECT hier_id,COUNT(id) AS count FROM '.cms_db_prefix().'module_compdir_companies GROUP BY hier_id ORDER BY hier_id';
  $tmp = $db->GetArray($query);
  if( is_array($tmp) && count($tmp) ) {
    $count_list = cge_array::to_hash($tmp,'hier_id');
  }
}

// get the hierarchy tree
$tree = cd_utils::get_hierarchy(TRUE,$hier);
$mod =& $this;
$_func = function(&$tree) use( &$_func, &$mod, $count_list, $params, $id, $returnid ) {
  $sum = 0;
  foreach( $tree as &$row ) {
    $row['direct_count'] = 0;
    $sumb = 0;
    if( isset($row['children']) ) $sumb = $_func( $row['children'] );
    if( isset($count_list[$row['id']]) ) $row['direct_count'] = $count_list[$row['id']]['count'];
    $sumb += $row['direct_count'];
    $row['count'] = $sumb;
    $sum += $sumb;

    $parms = $params;
    unset($parms['action'],$parms['module']);
    $parms['hier'] = $row['id'];
    $summarypage = $mod->resolve_alias_or_id(cge_utils::get_param($params,'summarypage'),$returnid);
    if( isset($params['summarytemplate']) ) $parms['summarytemplate'] = $params['summarytemplate'];
    $row['url'] = $mod->create_url($id,'default',$summarypage,$parms);
  }
  return $sum;
};

$_func($tree);

// and give it to smarty
$smarty->assign('hierdata',$tree);

// and process the template.
echo $this->ProcessTemplateFromDatabase($thetemplate);

#
# EOF
#
?>
