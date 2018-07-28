<?php
/**
 *
 * Copyright:
 *
 * MajorLabel - Guido Goluke
 * Web: www.majorlabel.nl
 * Email: info@majorlabel.nl
 *
 *
 * Authors:
 *
 * Guido Goluke, <info@majorlabel.nl>
 *  
 *
 * License:
 *-------------------------------------------------------------------------
 *
 * This program is free software; you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation; either version 2 of the License, or
 * (at your option) any later version.
 *
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU General Public License for more details.
 * You should have received a copy of the GNU General Public License
 * along with this program; if not, write to the Free Software
 * Foundation, Inc., 59 Temple Place, Suite 330, Boston, MA 02111-1307 USA
 * Or read it online: http://www.gnu.org/licenses/licenses.html#GPL
 *
 * ------------------------------------------------------------------------- */
if( !defined('CMS_VERSION') ) exit;
if( !$this->CheckPermission(AceEditor2::MANAGE_PERM) ) return;

// Handle the submit action to save preferences
if (isset($params['submit'])) {
	// Use the class method 'SavePreference' from the AceEditor2 class to save the values
	// The 'paramname' (from the input name attribute) MUST be the same as the database column name
	foreach ($params as $paramname => $paramvalue) {
		$this->SavePreference($paramname, $paramvalue);
	}
	$this->SetMessage($this->Lang('pref_saved_mess'));
	$this->RedirectToAdminTab();
}

// Get the currently selected preferences from the database and send them to the template
$ace_prefs = $this->GetCurrentAcePrefs();
foreach ($ace_prefs as $ace_pref_name => $ace_pref_value) {
	$smarty->assign($ace_pref_name, $ace_pref_value);
}

$tpl = $smarty->CreateTemplate($this->GetTemplateResource('manage_ace_prefs.tpl'),null,null,$smarty);
$tpl->display();