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
if( !isset($gCms) ) exit;

$category_id = \cge_param::get_string($params,'category');
if( !$category_id ) {
    $this->_DisplayErrorPage ($id, $params, $returnid, $this->Lang ('error_insufficientparams'));
    return;
}

$category = \Banners\category::load($category_id);
$category_id = $category->id; // category_id is now assured to be an integer
$thetemplate = \cge_param::get_string($params,'listtemplate','bannerlist_template');
$tpl = $this->CreateSmartyTemplate($thetemplate);
$docount = \cge_param::get_bool($params,'docount',1);

$tpl->assign('category',$category);

// todo: use the banner class to load these things.
// Now get all the non-expired banners in this category
$query = 'SELECT * FROM '.cms_db_prefix()."module_banners
          WHERE category_id = ? AND start_date <= NOW() AND (expires IS NULL OR expires > NOW())
          AND ((num_impressions < max_impressions) OR (max_impressions = 0))";
$data = $db->GetArray($query,[ $category_id ]);
if( $data )  {
    $sql = 'UPDATE '.cms_db_prefix().'module_banners SET num_impressions = num_impressions + 1, last_impression = NOW() WHERE banner_id = ?';
    for( $i = 0; $i < count($data); $i++ ) {
        $row =& $data[$i];
        if( empty($row['text']) ) $row['text'] = 'Banner';
        $row['clickthrough'] = $this->create_url($id,'link',$returnid, [ 'banner_id'=>$row['banner_id'], 'category_id'=>$category_id] );
        if( $docount ) $db->Execute($sql, [ $row['banner_id'] ]);
    }
}
$tpl->assign('banners',$data);
$tpl->display();

#
# EOF
