<?php
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
if (!isset($gCms)) exit;

// setup
$abclist = null;
$letter = null;

$thetemplate = $this->GetPreference(COMPANYDIR_PREF_DFLTABCLIST_TEMPLATE);
$thetemplate = cge_param::get_string($params,'abclisttemplate',$thetemplate);
if( !endswith($thetemplate,'.tpl') ) $thetemplate = 'abclist_'.$thetemplate;
$tpl = $this->CreateSmartyTemplate($thetemplate);

try {
    // clean up params, and build an alphabetic list
    $urlparms = [];
    foreach( $params as $key => $val ) {
        switch( $key ) {
        case 'returnid':
        case 'action':
        case 'abclisttemplate':
        case 'module':
        case 'cd_encoded':
        case 'cd_sig':
            // ignore these;
            break;
        default:
            $urlparms[$key] = $val;
            break;
        }
    }

    $name = \cge_param::get_string($params,'name','A');
    $alpha = $name = $name[0]; // one character only for this action.
    $name .= '*';
    $sql = 'SELECT UCASE(SUBSTR(company_name,1,1)) AS alpha, COUNT(id) AS cnt
            FROM '.cms_db_prefix().'module_compdir_companies WHERE status = ?
            GROUP BY  UCASE(SUBSTR(company_name,1,1))';
    $list = $db->GetArray($sql, [ 'published' ]);
    if( !count($list) ) throw new \Exception('No data to display');
    $abclist = [];
    foreach( range('A','Z') as $char ) {
        $abclist[$char] = [ 'url' => null, 'count' => 0, 'current' => FALSE ];
    }
    foreach( $list as $one ) {
        $abclist[$one['alpha']]['current'] = ($alpha == $one['alpha']) ? TRUE : FALSE;
        $abclist[$one['alpha']]['count'] = $one['cnt'];
        $urlparms['name'] = $one['alpha'];
        $urlparms['page'] = 1;
        $abclist[$one['alpha']]['url'] = $this->create_url('cntnt01','abclist',$returnid,$urlparms);
    }
    $tpl->assign('abclist',$abclist);

    // from here, we are just generating a summary view.
    $filter = new cd_company_filter($params);
    $filter['name'] = $name;
    $filter['id']= $id;
    $filter['returnid'] = $returnid;
    $query = new cd_company_query($filter);
    $pagination = $query->get_pagination();
    $pagination->set_action('abclist');
    $pagination->set_extraparams( [ 'name' => $name] );
    $page = $pagination->get_current_page();
    $tpl->assign('items',$query->get_results('cntnt01',$returnid));
    $tpl->assign('itemcount',$query->get_result_count());
    $tpl->assign('totalmatches',$query->get_total_matches());
    $tpl->assign('pagination',$pagination);
    $tpl->assign('curpage',$page);
    $tpl->assign('filter',$filter);
	$tpl->assign('hierarchy_list',array_flip(cd_utils::get_hierarchy_list()));
}
catch( \Exception $e ) {
    $tpl->assign('error',$e->GetMessage());
}

$tpl->display();