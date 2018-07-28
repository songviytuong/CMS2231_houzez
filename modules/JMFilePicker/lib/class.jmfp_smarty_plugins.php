<?php
#-------------------------------------------------------------------------
# JMFilePicker
# Version 1.0
# (c) 2016 by Fernando Morgado aka Jo Morg <jomorg@cmsmadesimple.org>
# The module's homepage is: http://dev.cmsmadesimple.org/projects/jmfilepicker/
#
# A fork of: GBFilePicker (c) 2010-2012 by Georg Busch
# maintained by Fernando Morgado AKA Jo Morg
# since 2016
#-------------------------------------------------------------------------
# Original Author: Georg Busch <georg.busch@gmx.net>
#-------------------------------------------------------------------------
#
# JMFilePicker is a CMS Made Simple module that enables the web developer to create
# multiple lists throughout a site. It can be duplicated and given friendly
# names for easier client maintenance.
#
#-------------------------------------------------------------------------
#
# CMS - CMS Made Simple is (c) 2010 by Ted Kulp (wishy@cmsmadesimple.org)
# This project's homepage is: http://www.cmsmadesimple.org
#
#-------------------------------------------------------------------------
# BEGIN_LICENSE
#-------------------------------------------------------------------------
# This file is part of JMFilePicker
# JMFilePicker program is free software; you can redistribute it and/or modify
# it under the terms of the GNU General Public License as published by
# the Free Software Foundation; either version 2 of the License, or
# (at your option) any later version.
#
# JMFilePicker program is distributed in the hope that it will be useful,
# but WITHOUT ANY WARRANTY; without even the implied warranty of
# MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
# GNU General Public License for more details.
# You should have received a copy of the GNU General Public License
# along with this program; if not, write to the Free Software
# Foundation, Inc., 59 Temple Place, Suite 330, Boston, MA 02111-1307 USA
# Or read it online: http://www.gnu.org/licenses/licenses.html#GPL
#
#-------------------------------------------------------------------------
# END_LICENSE
#-------------------------------------------------------------------------
final class jmfp_smarty_plugins
{
	/**
	 * @ignore
	 */
	public static function jmfp_jsloader() 
	{
		static $loaded = false;
		if($loaded)
			return;
		$loaded = true;
		$config = cmsms()->GetConfig();
		return '<script language="javascript" type="text/javascript" src="' . $config['root_url'] . '/modules/JMFilePicker/js/jsLoader.js" defer="defer"></script>';
	}
	
	/**
	 * Smarty Plugin : {JMFilePicker}
	 * Purpose       : creates a filepicker input 
	 * Author        : Georg Busch (NaN)
	 * Version       : 1.0
	 * License       : GPL
	 */
	public static function JMFilePicker($params, &$template)
	{
		$output = '';
		
		if(version_compare(CMS_VERSION, '1.11') < 0)
			$smarty = $template; # backward compatibility
		else
			$smarty = $template->smarty;
		
		$id = '';
		if(isset($params['id']))
			$id = $params['id'];
		
		$value  = '';
		if(isset($params['value']))
			$value = $params['value'];
		
		$name = 'jmfp';
		if(isset($params['input_name']))
			$name = $params['input_name'];
		
		$returnid = cms_utils::get_current_pageid();
		
		if($jmfp = cms_utils::get_module('JMFilePicker'))
			$output = $jmfp->CreateFilePickerInput($jmfp, $id, $name, $value, $params, $returnid);
		
		if(isset($params['assign']))
			$smarty->assign($params['assign'], $output);
		else
			echo $output;
	}
	
	/**
	 * Smarty Plugin : {jmfp_filelist}
	 * Purpose       : displays a list of files
	 * Author        : Georg Busch (NaN)
	 * Version       : 1.0
	 * License       : GPL
	 */
	public static function jmfp_filelist($params, &$template)
	{
		if(version_compare(CMS_VERSION, '1.11') < 0)
			$smarty = $template; # backward compatibility
		else
			$smarty = &$template->smarty;
		
		$jmfp = cms_utils::get_module('JMFilePicker');
		
		// module params:
		$dir         = isset($params['dir'])         ? $params['dir']         : '';
		$excl_prefix = isset($params['excl_prefix']) ? $params['excl_prefix'] : '';
		$excl_sufix  = isset($params['excl_sufix'])  ? $params['excl_sufix']  : '';
		$incl_prefix = isset($params['incl_prefix']) ? $params['incl_prefix'] : '';
		$incl_sufix  = isset($params['incl_sufix'])  ? $params['incl_sufix']  : '';
		$file_ext    = isset($params['file_ext'])    ? $params['file_ext']    : '';
		$media_type  = isset($params['media_type'])  ? $params['media_type']  : 'image';
		
		$excl_dirs       = isset($params['excl_dirs']) && $jmfp->IsTrue($params['excl_dirs']);
		$show_thumbfiles = isset($params['show_thumbfiles']) && $jmfp->IsTrue($params['show_thumbfiles']);
		$create_thumbs   = isset($params['create_thumbs']) && $jmfp->IsTrue($params['create_thumbs']);
		
		// plugin params:
		$excl_files = isset($params['excl_files']) && $jmfp->IsTrue($params['excl_files']);
		$output     = isset($params['output']) ? $params['output'] : 'filename';
		$assign_as  = isset($params['assign_as']) ? $params['assign_as'] : 'string';
		$delimiter  = isset($params['delimiter']) ? $params['delimiter']: '<br />';
		
		// get files
		$files =& $jmfp->GetFiles($dir,$excl_prefix,$incl_prefix,$excl_sufix,$incl_sufix,$file_ext,$media_type,$excl_dirs,$show_thumbfiles,$create_thumbs);
		
		$file_array = array();
		foreach($files as $onefile)
		{
			if($excl_files && !$onefile->is_dir) continue;
			switch($output)
			{
				case 'full_object':
					$file_array[] = $onefile;
					break;
				case 'relurl':
					$file_array[] = $onefile->relurl;
					break;
				case 'fullurl':
					$file_array[] = $onefile->fullurl;
					break;
				case 'filename':
				default:
					$file_array[] = $onefile->basename;
					break;
			}
		}
		
		if(isset($params['assign']))
		{
			if($assign_as == "array") {
				$smarty->assign($params['assign'],$file_array);
				return;
			}
			$smarty->assign($params['assign'],implode($delimiter, $file_array));
			return;
		}
		return implode($delimiter, $file_array);
	}
	
	/**
	 * Smarty Plugin : {jmfp_reassign_news_custom_fields}
	 * Purpose       : re-assigns the custom fields of the news module to smarty 
	 *                 to use JMFilePicker - needs module_custom folder
	 *                 (code based on news module action.editarticle.php & action.addarticle.php)
	 * Author        : Georg Busch (NaN)
	 * Version       : 1.0
	 * License       : GPL
   * @deprecated
	 */
	function jmfp_reassign_news_custom_fields($params, &$template) 
	{
		if(!$news =& cms_utils::get_module('News'))
			return;
		
		if(version_compare(CMS_VERSION, '1.11') < 0)
			$smarty = &$template; # backward compatibility
		else
			$smarty = &$template->smarty;
		
		$config = cmsms()->GetConfig();
		$id        = 'm1_';
		$db        = cmsms()->GetDb();
		$articleid = (isset($_GET[$id.'articleid']) ? $_GET[$id.'articleid']:'');
		
		//
		// Display custom fields
		//
		
		// Get the field values
		$fieldvals = array();
		if($articleid) 
		{
			$query = 'SELECT * FROM '.cms_db_prefix().'module_news_fieldvals
				WHERE news_id = ?';
			$tmp = $db->GetArray($query,array($articleid));
			if( is_array($tmp) )
			{
				foreach( $tmp as $one )
				{
					$fieldvals[$one['fielddef_id']] = $one;
				}
			}
		}
		
		$query = 'SELECT * FROM '.cms_db_prefix() . 'module_news_fielddefs ORDER BY item_order';
		$dbr = $db->Execute($query);
		$custom_flds = array();
		while( $dbr && ($row = $dbr->FetchRow()) )
		{
			$value = '';
			if( isset($fieldvals[$row['id']]) )
				$value = $fieldvals[$row['id']]['value'];
			
			$value = isset($_POST[$id.'customfield'][$row['id']]) && in_array($_POST[$id.'customfield'][$row['id']],$_POST[$id.'customfield']) ? $_POST[$id.'customfield'][$row['id']]:$value;
			$obj   = new StdClass();
			$name  = "customfield[".$row['id']."]";
			$obj->prompt = $row['name'];
			switch( $row['type'] )
			{
				case 'textbox':
					if(startswith($row['name'], 'JMFP_') && $jmfp = cms_utils::get_module('JMFilePicker'))
					{
						$obj->prompt = substr($row['name'],5);
						$obj->field  = $jmfp->CreateFilePickerInput($jmfp, $id, $name, $value, $params);
					}
					else
					{
						$size       = min(50,$row['max_length']);
						$obj->field = $news->CreateInputText($id,$name,$value,$size,$row['max_length']);
					}
					break;
				case 'checkbox':
					$obj->field = $news->CreateInputHidden($id,$name,$value!='1'?$value:'0').$news->CreateInputCheckbox($id,$name,'1',$value!='1'?$value:'0');
					break;
				case 'textarea':
					$obj->field = $news->CreateTextArea(true,$id,$value,$name);
					break;
				case 'file':
					$name = "customfield_".$row['id'];
					if( $value != '' )
					{
						$deln = 'delete_customfield['.$row['id'].']';
						$del  = '&nbsp;'.$news->Lang('delete').$news->CreateInputCheckbox($id,$deln,'delete');
					}
					$obj->field = $value.'&nbsp;'.$news->CreateFileUploadInput($id,$name).$del;;
					break;
			}
			$custom_flds[] = $obj;
		}
		if( count($custom_flds) > 0 )
			$smarty->assign('custom_fields',$custom_flds);
	}
	
	/**
	 * Smarty Plugin : {jmfp_news_custom_fields}
	 * Purpose       : re-assigns the custom fields of the news module to smarty 
	 *                 to use JMFilePicker - needs module_custom folder
	 *                 (code based on UDT by wishbone)
	 * Author        : Georg Busch (NaN)
	 * Version       : 1.0
	 * License       : GPL
	 */
	function jmfp_news_customfields($params, &$template) 
	{
		if(!$news =& cms_utils::get_module('News'))
			return;
		
		if(version_compare(CMS_VERSION, '1.11') < 0)
			$smarty = &$template; # backward compatibility
		else
			$smarty = &$template->smarty;
		
		$config = cmsms()->GetConfig();
		foreach($params['fields'] as &$field)
		{
			if(startswith($field->prompt,'JMFP_'))
			{
				#if(preg_match('/id=["\']([^\'^"]*\[\w*\])["\']/',$field->field,$matches1) && preg_match('/name=["\']([^\'^"]*\[\w*\])["\']/',$field->field,$matches2)) 
				if(preg_match('/name=["\']([^\'^"]*\[\w*\])["\']/',$field->field,$matches2) && preg_match('/value=["\']([^\'^"]*)["\']/',$field->field,$matches3))
				{
					#$field_id      = munge_string_to_url($matches1[1]);
					$field_name    = $matches2[1];
					$field_value   = $matches3[1];
					$jmfp          =& cms_utils::get_module('JMFilePicker');
					$field->prompt = str_replace('JMFP_', '',$field->prompt);
					$field->field  = cms_utils::get_module('JMFilePicker')->CreateFilePickerInput($jmfp, '', $field_name, $field_value, $params);
				}
			}
		}
		$smarty->assign('jmfp_news_tpl_path',$config['root_path'] . DIRECTORY_SEPARATOR . 'modules' . DIRECTORY_SEPARATOR . 'News' . DIRECTORY_SEPARATOR . 'templates' . DIRECTORY_SEPARATOR . 'editarticle.tpl');
		$smarty->assign('custom_fields',$params['fields']);
	}
  
  public static function jmfp_cms2()
  {
     return (bool)jmfp_utils::isCMS2();
  }
  
  public static function FEU_Loaded()
  {
    return (bool)jmfp::FEU_Loaded();
  }
}

?>
