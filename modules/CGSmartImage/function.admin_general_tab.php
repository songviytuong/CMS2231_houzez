<?php
#BEGIN_LICENSE
#-------------------------------------------------------------------------
# Module: CGSmartImage (c) 2011 by Robert Campbell (calguy1000@cmsmadesimple.org)
#
#  An addon module for CMS Made Simple to allow creating image tags in a smart
#  way to optimize performance.
#
#-------------------------------------------------------------------------
# CMS - CMS Made Simple is (c) 2005-2010 by Ted Kulp (wishy@cmsmadesimple.org)
# This project's homepage is: http://www.cmsmadesimple.org
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
if( !$this->CheckPermission('Modify Site Preferences') ) return;


$tmp = array();
$tmp['tl'] = $this->Lang('prompt_loc_topleft');
$tmp['tc'] = $this->Lang('prompt_loc_topcenter');
$tmp['tr'] = $this->Lang('prompt_loc_topright');
$tmp['cl'] = $this->Lang('prompt_loc_centerleft');
$tmp['c'] = $this->Lang('prompt_loc_center');
$tmp['cr'] = $this->Lang('prompt_loc_centerright');
$tmp['bl'] = $this->Lang('prompt_loc_bottomleft');
$tmp['bc'] = $this->Lang('prompt_loc_bottomcenter');
$tmp['br'] = $this->Lang('prompt_loc_bottomright');
$smarty->assign('croptofit_locs',$tmp);
$smarty->assign('cache_age',$this->GetPreference('cache_age'));
$smarty->assign('cache_path',$this->GetPreference('cache_path'));
$smarty->assign('image_url_prefix',$this->GetPreference('image_url_prefix'));
$smarty->assign('croptofit_default_loc',$this->GetPreference('croptofit_default_loc','c'));
$smarty->assign('image_url_hascachedir',$this->GetPreference('image_url_hascachedir'));
$smarty->assign('formstart',$this->CGCreateFormStart($id,'admin_general_tab'));
$smarty->assign('formend',$this->CreateFormEnd());
$smarty->assign('silent',$this->GetPreference('silent',0));
$smarty->assign('checkmemory',$this->GetPreference('checkmemory',1));
$smarty->assign('force_extension',$this->GetPreference('force_extension',0));
$smarty->assign('progressive',$this->GetPreference('progressive',0));
$smarty->assign('autoscale_op',$this->GetPreference('autoscale_op','croptofit'));

echo $this->ProcessTemplate('admin_general_tab.tpl');

#
# EOF
#
?>