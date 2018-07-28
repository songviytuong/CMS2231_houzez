<?php
#BEGIN_LICENSE
#-------------------------------------------------------------------------
# Module: CompanyDirectory (c) 2004-6 by Ted Kulp (ted@cmsmadesimple.org)
#   Copyright 2006 - 2014 by Robert Campbell (calguy1000@cmsmadesimple.org)
#
#  An addon module for CMS Made Simple to allow management of and various ways to display
#  company information for use in directories etc.
#
#-------------------------------------------------------------------------
# CMS - CMS Made Simple is (c) 2005-2010 by Ted Kulp (wishy@cmsmadesimple.org)
# Visit the CMSMS homepage at: http://www.cmsmadesimple.org
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
if( !isset($gCms) ) exit();
if( !$this->CheckPermission( 'Modify Templates' ) ) exit();

$tab = '';
if (isset($params['active_tab']))
{
	$tab = $params['active_tab'];
	$this->SetCurrentTab($tab);
}

echo '<div class="pageoverflow" style="text-align: right; width: 80%;">'.
$this->CreateImageLink($id,'defaultadmin',$returnid,
		       $this->Lang('lbl_back'),'icons/system/back.gif',array(),'','',false).'</div><br/>';

echo $this->StartTabHeaders();
echo $this->SetTabHeader('summary_template',$this->Lang('summarytemplates'));
echo $this->SetTabHeader('detail_template',$this->Lang('detailtemplates'));
echo $this->SetTabHeader('categorylist_template',$this->Lang('categorylisttemplates'));
echo $this->SetTabHeader('hierlist_template',$this->Lang('hierarchylisttemplates'));
echo $this->SetTabHeader('abclist_template',$this->Lang('abclisttemplates'));
echo $this->SetTabHeader('newsearch_template',$this->Lang('newsearchtemplates'));
echo $this->SetTabHeader('frontendlist_template',$this->Lang('frontendlisttemplates'));
echo $this->SetTabHeader('frontendform_template',$this->Lang('frontendformtemplates'));
echo $this->SetTabHeader('frontendalbum_template',$this->Lang('frontendalbumtemplates'));
echo $this->SetTabHeader('frontendimport_template',$this->Lang('frontendimporttemplate'));
echo $this->SetTabHeader('statssummary_template',$this->Lang('statssummarytemplate'));
echo $this->SetTabHeader('default_templates',$this->Lang('defaulttemplates'));
echo $this->EndTabHeaders();

echo $this->StartTabContent();
echo $this->StartTab('summary_template', $params);
{
  echo $this->ShowTemplateList($id,$returnid,'summary_',
			       COMPANYDIR_PREF_NEWSUMMARY_TEMPLATE,
			       'summary_template',
			       COMPANYDIR_PREF_DFLTSUMMARY_TEMPLATE,
			       $this->Lang('summarytemplate_addedit'),
			       '','admin_templates');
}
echo $this->EndTab();


echo $this->StartTab('detail_template', $params);
{
  echo $this->ShowTemplateList($id,$returnid,'detail_',
			       COMPANYDIR_PREF_NEWDETAIL_TEMPLATE,
			       'detail_template',
			       COMPANYDIR_PREF_DFLTDETAIL_TEMPLATE,
			       $this->Lang('detailtemplate_addedit'),
			       '','admin_templates');
}
echo $this->EndTab();


echo $this->StartTab('categorylist_template', $params);
{
  echo $this->ShowTemplateList($id,$returnid,'categorylist_',
			       COMPANYDIR_PREF_NEWCATEGORYLIST_TEMPLATE,
			       'categorylist_template',
			       COMPANYDIR_PREF_DFLTCATEGORYLIST_TEMPLATE,
			       $this->Lang('categorylisttemplate_addedit'),
			       '','admin_templates');
}
echo $this->EndTab();

echo $this->StartTab('hierlist_template', $params);
{
  echo $this->ShowTemplateList($id,$returnid,'hierlist_',
			       COMPANYDIR_PREF_NEWHIERLIST_TEMPLATE,
			       'hierlist_template',
			       COMPANYDIR_PREF_DFLTHIERLIST_TEMPLATE,
			       $this->Lang('hierlisttemplate_addedit'),
			       '','admin_templates');
}
echo $this->EndTab();


echo $this->StartTab('abclist_template', $params);
{
  echo $this->ShowTemplateList($id,$returnid,'abclist_',
			       COMPANYDIR_PREF_NEWABCLIST_TEMPLATE,
			       'abclist_template',
			       COMPANYDIR_PREF_DFLTABCLIST_TEMPLATE,
			       $this->Lang('abclisttemplate_addedit'),
			       '','admin_templates');
}
echo $this->EndTab();

echo $this->StartTab('newsearch_template', $params);
{
  echo $this->ShowTemplateList($id,$returnid,'newsearch_',
							   COMPANYDIR_PREF_NEWSEARCHFORM_TEMPLATE,
							   'newsearch_template',
							   COMPANYDIR_PREF_DFLTSEARCHFORM_TEMPLATE,
							   $this->Lang('newsearchtemplate_addedit'),
							   '','admin_templates');
}
echo $this->EndTab();


echo $this->StartTab('frontendlist_template', $params);
{
  echo $this->ShowTemplateList($id,$returnid,'frontendlist_',
			       COMPANYDIR_PREF_NEWFRONTENDLIST_TEMPLATE,
			       'frontendlist_template',
			       COMPANYDIR_PREF_DFLTFRONTENDLIST_TEMPLATE,
			       $this->Lang('frontendlisttemplate_addedit'),
			       '','admin_templates');
}
echo $this->EndTab();


echo $this->StartTab('frontendform_template', $params);
{
  echo $this->ShowTemplateList($id,$returnid,'frontendform_',
			       COMPANYDIR_PREF_NEWFRONTENDFORM_TEMPLATE,
			       'frontendform_template',
			       COMPANYDIR_PREF_DFLTFRONTENDFORM_TEMPLATE,
			       $this->Lang('frontendformtemplate_addedit'),
			       '','admin_templates');
}
echo $this->EndTab();


echo $this->StartTab('frontendalbum_template', $params);
{
  echo $this->ShowTemplateList($id,$returnid,'frontendalbum_',
			       COMPANYDIR_PREF_NEWFRONTENDALBUM_TEMPLATE,
			       'frontendalbum_template',
			       COMPANYDIR_PREF_DFLTFRONTENDALBUM_TEMPLATE,
			       $this->Lang('frontendalbumtemplate_addedit'),
			       '','admin_templates');
}
echo $this->EndTab();


echo $this->StartTab('frontendimport_template',$params);
$smarty->assign('iformstart',$this->CGCreateFormStart($id,'admin_doimporttemplate'));
$smarty->assign('iformend',$this->CreateFormEnd());
$smarty->assign('feimport_template',$this->GetTemplate(COMPANYDIR_FRONTENDIMPORT_TEMPLATE));
echo $this->ProcessTemplate('frontendimport_form.tpl');
echo $this->EndTab();

echo $this->StartTab('statssummary_template');
{
  echo $this->ShowTemplateList($id,$returnid,'statssummary_',
							   COMPANYDIR_PREF_NEWSTATSSUMMARY_TEMPLATE,
							   'statssummary_template',
							   COMPANYDIR_PREF_DFLTSTATSSUMMARY_TEMPLATE,
							   $this->Lang('statssummary_addedit'),
							   '','admin_templates');
}
echo $this->EndTab();

echo $this->StartTab('default_templates');
{
  $smarty->assign('info_dflt_template',
                  $this->Lang('default_template_notice'));

  $parts = array();
  $parts[] = cge_template_admin::get_start_template_form($this,$id,'',
												   COMPANYDIR_PREF_NEWSUMMARY_TEMPLATE,'admin_templates','default_templates',
												   $this->Lang('title_summary_dflttemplate'),
												   'orig_summary_template.tpl');


  $parts[] = cge_template_admin::get_start_template_form($this,$id,'',
												   COMPANYDIR_PREF_NEWDETAIL_TEMPLATE,'admin_templates','default_templates',
												   $this->Lang('title_detail_dflttemplate'),
												   'orig_detail_template.tpl');

  $parts[] = cge_template_admin::get_start_template_form($this,$id,'',
												   COMPANYDIR_PREF_NEWCATEGORYLIST_TEMPLATE,'admin_templates','default_templates',
												   $this->Lang('title_categorylist_dflttemplate'),
												   'orig_categorylist_template.tpl');

  $parts[] = cge_template_admin::get_start_template_form($this,$id,'',
												   COMPANYDIR_PREF_NEWHIERLIST_TEMPLATE,'admin_templates','default_templates',
												   $this->Lang('title_hierlist_dflttemplate'),
												   'orig_hierlist_template.tpl');

  $parts[] = cge_template_admin::get_start_template_form($this,$id,'',
												   COMPANYDIR_PREF_NEWABCLIST_TEMPLATE,'admin_templates','default_templates',
												   $this->Lang('title_abclist_dflttemplate'),
												   'orig_abclist_template.tpl');

  $parts[] = cge_template_admin::get_start_template_form($this,$id,'',
												   COMPANYDIR_PREF_NEWSEARCHFORM_TEMPLATE,'admin_templates','default_templates',
												   $this->Lang('title_newsearch_dflttemplate'),
												   'orig_newsearch_template.tpl');

  $parts[] = cge_template_admin::get_start_template_form($this,$id,'',
												   COMPANYDIR_PREF_NEWFRONTENDLIST_TEMPLATE,'admin_templates','default_templates',
												   $this->Lang('title_frontendlist_dflttemplate'),
												   'orig_frontendlist_template.tpl');

  $parts[] = cge_template_admin::get_start_template_form($this,$id,'',
												   COMPANYDIR_PREF_NEWFRONTENDFORM_TEMPLATE,'admin_templates','default_templates',
												   $this->Lang('title_frontendform_dflttemplate'),
												   'orig_frontendform_template.tpl');

  $parts[] = cge_template_admin::get_start_template_form($this,$id,'',
												   COMPANYDIR_PREF_NEWFRONTENDALBUM_TEMPLATE,'admin_templates','default_templates',
												   $this->Lang('title_frontendalbum_dflttemplate'),
												   'orig_frontendalbum_template.tpl');

  $parts[] = cge_template_admin::get_start_template_form($this,$id,'',
												   COMPANYDIR_PREF_NEWSTATSSUMMARY_TEMPLATE,'admin_templates','default_templates',
												   $this->Lang('title_statssummary_dflttemplate'),
												   'orig_searchstats_summary_template.tpl');

  $smarty->assign('dflt_tpl_parts',$parts);

  echo $this->ProcessTemplate('dflt_templates.tpl');
}
echo $this->EndTab();
echo $this->EndTabContent();

// EOF
