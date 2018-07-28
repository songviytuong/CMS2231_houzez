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


// Get the fields the user is allowed to edit.
$fields = $this->GetFields($tab['tabid']);

$userid = get_userid();
$rowarray = array();

foreach( $fields as $key => $fld )
{
	$onerow = new stdClass();

	$onerow->fieldid = $fld['fieldid'];
	$onerow->name = $fld['name'];
	$onerow->type = $fld['type'];
	$onerow->help = $fld['help'];
	$onerow->value = $fld['value'];
	$onerow->fieldclass = '';

	$fieldname = 'field[' . $tab['tabid'] . '][' . $fld['fieldid'] . ']';
	switch ( $fld['type'] )
	{
		case 'textfield':
			$size = min(50, $fld['properties']);
			$onerow->fieldhtml = $this->CreateInputText($id, $fieldname, $fld['value'], $size, $fld['properties'] );
			break;

		case 'pulldown':
		case 'radiobuttons':
			// lets parse this by smarty first
			$fld['properties'] = $smarty->fetch('eval:'.$fld['properties']);
			$fld['properties'] = preg_replace('#<!--(.+)-->#is', '', $fld['properties']); // filter out html comments
			$fld['properties'] = str_replace("\r", "\n", $fld['properties']);
			$fld['properties'] = str_replace("\n\n", "\n", $fld['properties']);
			$fld['properties'] = trim($fld['properties']);
			$properties = explode("\n", $fld['properties']);
			$items = array();
			foreach ($properties as $property)
			{
				list($key, $value) = explode("|", $property . "|");
				$value = trim($value) == "" ? $key : $value;
				$items[$value] = $key;
			}
			if ( $fld['type'] == 'pulldown' )
			{
				$onerow->fieldhtml = $this->CreateInputDropdown($id, $fieldname, $items, -1, $fld['value']);
			}
			else
			{
				$onerow->fieldhtml = $this->CreateInputRadioGroup($id, $fieldname, $items, $fld['value']);
			}
			break;

		case 'checkbox':
			$onerow->fieldhtml = $this->CreateInputCheckbox($id, $fieldname, '1', $fld['value'], '');
			break;

		case 'datepicker':
		case 'timepicker':
			$onerow->fieldhtml = $this->CreateInputText($id, $fieldname, $fld['value'], 11, 10);
			$onerow->fieldclass = ' ' . $fld['type'];
			break;

		case 'datetimepicker':
			$onerow->fieldhtml = $this->CreateInputText($id, $fieldname, $fld['value'], 18, 20);
			$onerow->fieldclass = ' ' . $fld['type'];
			break;

		case 'pageselect':
			$contentops = cmsms()->GetContentOperations();
			$onerow->fieldhtml = '<span class="cgs_pageselect">' . $contentops->CreateHierarchyDropdown('', $fld['value'], $id . $fieldname, true) . '</span>';
			break;

		case 'textarea':
			$onerow->fieldhtml = $this->CreateTextArea(FALSE, $id, $fld['value'], $fieldname);
			break;

		case 'wysiwyg':
			$onerow->fieldhtml = $this->CreateTextArea(TRUE, $id, $fld['value'], $fieldname);
			break;

		case 'button':
			$onerow->fieldhtml = $this->CreateInputSubmit($id, $fieldname, $fld['name']);
			break;
		
		case 'corefilepicker':
			$onerow->fieldhtml = '';
			$corefp = cms_utils::get_module('FilePicker');
			if ( $corefp )
			{
				$onerow->fieldhtml = $corefp->get_html($id.$fieldname, $fld['value'], $corefp->get_default_profile());
			}
			break;
		
		case 'gbfilepicker':
			$onerow->fieldhtml = '';
			$gbfp = cms_utils::get_module('GBFilePicker');
			if ( $gbfp )
			{
				$onerow->fieldhtml = $gbfp->CreateFilePickerInput($gbfp, $id, $fieldname, $fld['value'], array('dir'=>'images','mode'=>'browser'));
			}
			break;

		case 'jmfilepicker':
			$onerow->fieldhtml = '';
			$jmfp = cms_utils::get_module('JMFilePicker');
			if ( $jmfp )
			{
				$onerow->fieldhtml = $jmfp->CreateFilePickerInput($jmfp, $id, $fieldname, $fld['value'], array('dir'=>'images','mode'=>'browser'));
			}
			break;

		case 'colorpicker':
			$onerow->fieldhtml = $this->CreateInputText($id, $fieldname, $fld['value'], 11, 10);
			$onerow->fieldclass = ' inputcolorpicker';
			break;

		case 'fieldsetstart':
			$onerow->fieldhtml = '<fieldset class="cgs_fieldset"><legend class="cgs_collapsible" id="section' . $userid . '-' . $tab['tabid'] . '-' . $fld['fieldid'] . '"><span></span> ' . $fld['name'] . '</legend><div>';
			break;

		case 'fieldsetend':
			$onerow->fieldhtml = '</div></fieldset> <!-- end cgs_collapsible -->';
			break;
	}

	array_push ($rowarray, $onerow);
}

$smarty->assign('items', $rowarray );
$smarty->assign('submit',$this->CreateInputSubmit ($id, 'submitbutton', lang('submit')));
$smarty->assign('cancel',$this->CreateInputSubmit ($id, 'cancel', lang('cancel')));
$smarty->assign('startform', $this->CreateFormStart($id, 'save_general', $returnid, 'post', '', false, '', array('tabid' => $tab['tabid'])));
$smarty->assign('endform', $this->CreateFormEnd());

echo $this->ProcessTemplate('admin_general.tpl');

?>