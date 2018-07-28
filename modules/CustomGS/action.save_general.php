<?php
#-------------------------------------------------------------------------
# Module: Custom Global Settings
# Author: Rolf Tjassens, Jos
#-------------------------------------------------------------------------
# CMS - CMS Made Simple is (c) 2011 by Ted Kulp (wishy@cmsmadesimple.org)
# This project's homepage is: http://www.cmsmadesimple.org
# The module's homepage is: http://dev.cmsmadesimple.org/projects/customgs
#-------------------------------------------------------------------------
# This program is free software; you can redistribute it and/or modify
# it under the terms of the GNU General Public License as published by
# the Free Software Foundation; either version 2 of the License, or
# (at your option) any later version.
#
# This program is distributed in the hope that it will be useful,
# but WITHOUT ANY WARRANTY; without even the implied warranty of
# MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
# GNU General Public License for more details.
# You should have received a copy of the GNU General Public License
# along with this program; if not, write to the Free Software
# Foundation, Inc., 59 Temple Place, Suite 330, Boston, MA 02111-1307 USA
# Or read it online: http://www.gnu.org/licenses/licenses.html#GPL
#-------------------------------------------------------------------------

if (!isset($gCms)) exit;

if( !$this->CheckPermission('Custom Global Settings - Use') ) $this->Redirect($id, "defaultadmin", $returnid);

$tabid = $params['tabid'];
// Get the fields the user is allowed to edit.
$fields = $this->GetFields($tabid);
$clearcache = 0;

foreach( $fields as $key => $fld )
{
	$value = $fld['value'];
	$newvalue = isset($params['field'][$tabid][$key]) ? $params['field'][$tabid][$key] : 0;
		
	// Sent event only when value has changed.
	if ( $newvalue != $value )
	{
		if ( $fld['type'] != 'button' )
		{
			// Save field value
			$query = "UPDATE " . cms_db_prefix() . "module_customgs SET value=? WHERE fieldid=?";
			$result = $db->Execute($query, array($newvalue, $key));
		}

		$this->SendEvent('OnSettingChange', array(
					'fieldid' => $fld['fieldid'],
					'name' => $fld['name'],
					'alias' => str_replace('__', '_', str_replace('-', '_', munge_string_to_url($fld['name']))),
					'value' => $newvalue,
					'clearcache' => $fld['clearcache']
		));
		$clearcache = $clearcache || $fld['clearcache'];
	}
}

// Clear the stylesheet cache if required by one of the fields and only if that field has been changed
if ( $clearcache ) $this->ClearStylesheetCache();

// Show saved parameters in debug mode
debug_display($params);

// Put mention into the admin log
audit('', 'Custom Global Settings - General tab', 'Saved');

$this->Redirect($id, 'defaultadmin', $returnid, array('module_message' => $this->Lang('settingssaved'), 'active_tab' => 'tab' . $tabid));
?>