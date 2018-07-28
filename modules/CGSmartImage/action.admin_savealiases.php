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

$this->SetCurrentTab('aliases');

$aliases = array();
$error = false;
for( $i = 0; $i < count($params['alias_name']); $i++ )
  {
    $name = trim($params['alias_name'][$i]);
    $options = trim($params['alias_options'][$i]);

    if( $name == '' && $options == '' ) continue;
    if( $options == '' )
      {
	$this->SetError($this->Lang('error_alias_nooptions_atrow',$i+1));
	$error = true;
	continue;
      }
    if( !$name )
      {
	$this->SetError($this->Lang('error_alias_noname_atrow',$i+1));
	$error = true;
	continue;
      }
    if( isset($aliases[$name]) )
      {
	$this->SetError($this->Lang('error_alias_duplicatename_atrow',$i+1));
	$error = true;
	continue;
      }

    $aliases[$name] = array('name'=>$name,'options'=>$options);
  }

if( $error )
  {
    $_SESSION[$this->GetName().'_alias_names'] = $params['alias_name'];
    $_SESSION[$this->GetName().'_alias_options'] = $params['alias_options'];
  }
else
  {
    unset($_SESSION[$this->GetName().'_alias_names']);
    unset($_SESSION[$this->GetName().'_alias_options']);
    $this->SetPreference('aliases',serialize($aliases));
    $this->SetMessage($this->Lang('msg_aliases_updated'));
  }
$this->RedirectToTab($id);

#
# EOF
#
?>