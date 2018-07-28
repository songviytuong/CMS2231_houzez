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

// test if we are excluding this IP from the counting
$exclude = 0;
if( $this->GetPreference('hide_from_bots',0) ) {
    // see if we can reasonably detect if this request is from a bot.
    $browser = cge_utils::get_browser();
    if( $browser->isRobot() ) $exclude = 1;
}

if( $exclude == 0 ) {
    // it's not a bot (or we're allowing bots... so we gotta check for subnets
    $subnets = explode(",",$this->GetPreference("subnet_exclusions"));
    $test = 0;
    foreach($subnets as $subnet) {
        $test = $this->_testip( $subnet, cge_utils::get_real_ip() );
        if( $test ) $exclude = 1;
    }
}


try {
    $category =  cge_param::get_string($params,'category');
    if( isset($params['category_id']) ) $category = cge_param::get_int($params,'category_id');
    if( empty($category) ) throw new \RuntimeException($this->Lang('error_insufficientparams'));

    // begin our work.
    $category = \Banners\category::load($category);

    $banner = null;
    try {
        // do we want a specific banner ?
        $name = trim(cge_utils::get_param($params,'name'));
        if( $name ) {
            $banner = \Banners\banner::load($name);
        }
        else {
            $mode = strtolower(trim(cge_utils::get_param($params,'mode')));
            $sequential = ($mode == 'sequential');
            $banner = \Banners\banner::load_latest($category->id,$sequential);
        }
    }
    catch( \RuntimeException $e ) {
        // could not find a displayable banner.
        if( !$category->dflt_image ) {
            audit('',$this->GetName(),'Problem: '.$e->GetMessage());
            echo '<!-- '.$this->GetName().': Could not find an image to display ('.$db->ErrorMsg().')-->';
            return;
        }
        $banner = new \Banners\banner;
        $banner->name = $this->Lang('your_ad_here');
    }

    if( !$banner->image ) $banner->image = $category->dflt_image;
    if( !$banner->url ) $banner->url = $category->dflt_url;
    $banner_array = $banner->to_array();
    if( $banner_array['text'] == '' ) $banner_array['text'] = 'Banner';
    if( $banner_array['url'] != '' ) {
        $banner_array['clickthrough'] = $this->create_url($id,'link',$returnid,array('banner_id'=>$banner->id,'category_id'=>$category->id));
    }

    $tpl_ob = $smarty->CreateTemplate('string:'.$category->template);
    $tpl_ob->assign('banner',$banner_array);
    $tpl_ob->assign('category',$category->to_array());
    $tpl_ob->assign('action_params',$params);
    $tpl_ob->display();

    if( $exclude == 0 && $banner->id > 0 ) {
        // add an impression
        $banner->num_impressions = $banner->num_impressions + 1;
        $banner->last_impression = time();
        $banner->save();
    }

    // and done
}
catch( \Exception $e ) {
    audit('',$this->GetName(),'Problem: '.$e->GetMessage());
    $this->_DisplayErrorPage ($id, $params, $returnid, $e->GetMessage() );
}

?>
