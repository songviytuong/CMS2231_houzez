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

if (!$this->VisibleToAdminUser())
{
	echo $this->ShowErrors(lang('needpermissionto', 'Custom Global Settings - Use'));
	return;
}

$admintheme = cms_utils::get_theme_object();

/**
 * Create Admin tabs
 */ 
 
$tabs = $this->GetTabs();
 
echo $this->StartTabHeaders();
	$active_tab = empty($params['active_tab']) ? '' : $params['active_tab'];

	foreach( $tabs as $tab )
	{
		echo $this->SetTabHeader('tab' . $tab['tabid'], $tab['name'], ($active_tab == 'tab' . $tab['tabid'])?true:false);
	}

	if ( $this->CheckPermission('Custom Global Settings - Manage') )
	{
		echo $this->SetTabHeader('fielddefs', $this->Lang("title_fielddefs"), ($active_tab == 'fielddefs')?true:false);
		echo $this->SetTabHeader('tabs', $this->Lang("title_tabs"), ($active_tab == 'tabs')?true:false);
		echo $this->SetTabHeader('options', lang("options"), ($active_tab == 'options')?true:false);
	}

echo $this->EndTabHeaders();


echo $this->StartTabContent();

	if ( function_exists('cms_admin_current_language') ) setlocale(LC_TIME, cms_admin_current_language()); // for cmsms 1.10 only
	for ($i = 1; $i <= 12; $i++)
	{
		$timestamp=mktime(1,1,1,$i,1,2000);
		$months[] = htmlentities(strftime('%B', $timestamp));
	}
	$monthnames = implode("','",$months);
	for ($i = 1; $i <= 7; $i++)
	{
		$timestamp=mktime(1,1,1,10,$i,2000);
		$days[] = htmlentities(strftime('%A', $timestamp));
		$daysmin[] = htmlentities(substr(strftime('%a', $timestamp), 0, 2));
	}
	$daynames = implode("','",$days);
	$daynamesmin = implode("','",$daysmin);

	$DP_locale = "
		$.datepicker.regional[''] = {
			closeText: '" . lang('close') . "',
			prevText: '" . lang('previous') . "',
			nextText: '" . lang('next') . "',
			currentText: '" . $this->Lang('now') . "',
			monthNames: ['" . $monthnames . "'],
			dayNames: ['" . $daynames . "'],
			dayNamesMin: ['" . $daynamesmin . "'],
			dateFormat: 'yyyy-mm-dd',
			firstDay: 1,
			isRTL: false,
			showMonthAfterYear: false,
			yearSuffix: ''
		};
		$.datepicker.setDefaults($.datepicker.regional['']);

		$.timepicker.regional[''] = {
			timeOnlyTitle: '" . $this->Lang('choosetime') . "',
			timeText: '" . $this->Lang('time') . "',
			hourText: '" . lang('hour') . "',
			minuteText: '" . lang('minutes') . "',
			currentText: '" . $this->Lang('now') . "',
			closeText: '" . lang('close') . "',
			ampm: false
		};
		$.timepicker.setDefaults($.timepicker.regional['']);
	";

	$smarty->assign('DP_locale', $DP_locale);
	
	echo $this->ProcessTemplate('admin_generaljs.tpl');
	
	foreach( $tabs as $tab )
	{
		echo $this->StartTab('tab' . $tab['tabid']);
			include(dirname(__FILE__).'/function.admin_general.php');
		echo $this->EndTab();
	}

	if ( $this->CheckPermission('Custom Global Settings - Manage') )
	{
		echo $this->StartTab("fielddefs");
			include(dirname(__FILE__).'/function.admin_fielddefs.php');
		echo $this->EndTab();

		echo $this->StartTab("tabs");
			include(dirname(__FILE__).'/function.admin_tabs.php');
		echo $this->EndTab();

		echo $this->StartTab("options");
			include(dirname(__FILE__).'/function.admin_options.php');
		echo $this->EndTab();
	}

echo $this->EndTabContent();

?>