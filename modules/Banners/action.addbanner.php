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
if( !$this->CheckPermission('Banners Manager') ) return;
$this->SetCurrentTab('banners');

$categorylist = \Banners\category::get_list();
$category_id = (int) cge_utils::get_param($params,'category_id');
$banner_id = (int) cge_utils::get_param($params,'banner_id');
if( $category_id < 1 ) {
    $this->SetMessage($this->Lang('error_insufficientparams'));
    $this->RedirectToTab($id);
}

try {
    $banner = new \Banners\banner;
    $banner->neverexpires = 1;
    if( $banner_id > 0 ) {
        $banner = \Banners\banner::load($banner_id);
    }
}
catch( \Exception $e ) {
    $this->SetError($e->GetMessage());
    $this->RedirectToTab();
}

if( isset($params['cancel']) ) {
    $this->RedirectToTab();
}
if( isset($params['submit']) ) {
    try {
        $get_date = function($params,$prefix) {
            $mon = (int) \cge_utils::get_param($params,$prefix.'Month');
            $day = (int) \cge_utils::get_param($params,$prefix.'Day');
            $yr = (int) \cge_utils::get_param($params,$prefix.'Year');
            return mktime(0,0,0,$mon,$day,$yr);
        };

        $banner->category_id = (int) cge_utils::get_param($params,'category_id');
        $banner->name = cge_utils::get_param($params,'input_bannername');
        $banner->description = cge_utils::get_param($params,'input_bannerdesc');
        $banner->image = cge_utils::get_param($params,'input_image');
        $banner->url = cge_utils::get_param($params,'input_url');
        $banner->text = cge_utils::get_param($params,'input_image_text');
        $banner->href_text = cge_utils::get_param($params,'input_href_text');
        $banner->max_impressions = cge_utils::get_param($params,'input_max_impressions');
        $banner->start_date = $get_date($params,'startdate_');
        $banner->expires = $get_date($params,'expiresdate_');
        $banner->neverexpires = cge_utils::get_param($params,'input_neverexpires');

        $banner->save();
        $this->RedirectToTab();
    }
    catch( \Exception $e ) {
        echo $this->ShowErrors($e->GetMessage());
    }
}

$parms = array('category_id'=>(int)$params['category_id']);
if( $banner_id > 0 ) $parms['banner_id'] = $banner_id;
$category_name = null;
if( isset($categorylist[$category_id]) ) $category_name = $categorylist[$category_id];
$smarty->assign('category_name',$category_name);
$smarty->assign('category_id',$category_id);
$smarty->assign('startform', $this->CGCreateFormStart($id,'addbanner',$returnid,$parms) );
$smarty->assign('endform', $this->CreateFormEnd() );
$smarty->assign('banner', $banner);
echo $this->ProcessTemplate ('addbanner.tpl');