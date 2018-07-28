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

$embed_modes = array();
$embed_modes['none'] = $this->Lang('none');
$embed_modes['smart'] = $this->Lang('smart');
$embed_modes['sizelimit'] = $this->Lang('prompt_embed_sizelimit');
$embed_modes['smart_limited'] = $this->Lang('prompt_embed_smartlimited');
$embed_modes['type'] = $this->Lang('prompt_embed_type');
$smarty->assign('embed_modes',$embed_modes);
$smarty->assign('embed_mode',$this->GetPreference('embed_mode'));
$smarty->assign('embed_sizelimit',$this->GetPreference('embed_sizelimit'));
$smarty->assign('embed_types',$this->GetPreference('embed_types'));

$smarty->assign('formstart',$this->CGCreateFormSTart($id,'admin_embedding_tab'));
$smarty->assign('formend',$this->CreateFormEnd());
echo $this->ProcessTemplate('admin_embedding_tab.tpl');
#
# EOF
#
?>