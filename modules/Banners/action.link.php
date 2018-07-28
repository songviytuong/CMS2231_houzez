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
$db = $this->GetDb();

if( !isset( $params['category_id'] ) ) {
    $this->_DisplayErrorPage ($id, $params, $returnid, $this->Lang ('error_insufficientparams'));
    return;
}
else if( !isset( $params['banner_id'] ) ) {
    $this->_DisplayErrorPage ($id, $params, $returnid, $this->Lang ('error_insufficientparams'));
    return;
}

// get the details about this banner
$query = "SELECT * FROM ".cms_db_prefix()."module_banners WHERE category_id = ? AND banner_id = ?";
$dbresult = $db->Execute( $query, array( $params['category_id'], $params['banner_id'] ) );
if( !$dbresult ) {
    $this->_DisplayErrorPage ($id, $params, $returnid, $this->Lang ('error_dberror'));
    return;
}
$banner = $dbresult->FetchRow();
if( !$banner ) {
    $this->_DisplayErrorPage ($id, $params, $returnid, $this->Lang ('error_dberror'));
    return;
}

// add the hit
// test if we are excluding this IP from the counting
$exclude = 0;
if( $this->GetPreference('hide_from_bots',0) ) {
	// see if we can reasonably detect if this request is from a bot.
	$browser = cge_utils::get_browser();
	if( $browser->isRobot() ) $exclude = 1;
}

if( $exclude == 0 ) {
	$subnets = explode(",",$this->GetPreference("subnet_exclusions"));
	$test = 0;
	foreach($subnets as $subnet) {
	    $test = $this->_testip( $subnet, cge_utils::get_real_ip() );
	    if( $test ) {
            // don't allow any more processing
            $exclude = 1;
        }
    }

	$query = "INSERT INTO ".cms_db_prefix()."module_banners_hits (banner_id,time,ip_address) values (?,NOW(),?)";
	$dbresult = $db->Execute( $query, array( $params['banner_id'], cge_utils::get_real_ip()) );
}

// redirect to to the destination
redirect( $banner['url'] );

?>
