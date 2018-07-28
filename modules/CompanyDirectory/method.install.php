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
if (!isset($gCms)) exit;

if( version_compare(phpversion(),'5.4.3') < 0 ) {
    return "Minimum PHP version of 5.4.3 required";
}

$db = cmsms()->GetDb();

$dict = NewDataDictionary($db);
$flds = "
	id I KEY AUTO,
	company_name C(255) NOT NULL,
	address X,
	telephone C(50),
	fax C(50),
	contact_email C(255),
	website C(255),
	details X,
	picture_location C(255),
	logo_location C(255),
	create_date " . CMS_ADODB_DT . ",
	modified_date " . CMS_ADODB_DT . ",
    status C(50),
    latitude F,
    longitude F,
    owner_id I,
    hier_id I,
    url C(255)
";

$taboptarray = array('mysql' => 'TYPE=MyISAM');
$sqlarray = $dict->CreateTableSQL(cms_db_prefix()."module_compdir_companies", $flds, $taboptarray);
$dict->ExecuteSQLArray($sqlarray);

$flds = "
	id I KEY AUTO,
	name C(255) NOT NULL,
    image  C(255),
    description X,
    parent_id I,
    item_order I,
    hierarchy C(255),
    long_name C(255),
    extra1  C(255),
    extra2  C(255),
    extra3  C(255)
";

$taboptarray = array('mysql' => 'TYPE=MyISAM');
$sqlarray = $dict->CreateTableSQL(cms_db_prefix()."module_compdir_categories",$flds, $taboptarray);
$dict->ExecuteSQLArray($sqlarray);

$flds = "
	company_id I KEY NOT NULL,
	category_id I KEY NOT NULL,
    extra1 C(255),
    extra2 C(255),
    extra3 C(255),
	create_date " . CMS_ADODB_DT . ",
	modified_date " . CMS_ADODB_DT . "
";

$taboptarray = array('mysql' => 'TYPE=MyISAM');
$sqlarray = $dict->CreateTableSQL(cms_db_prefix()."module_compdir_company_categories", $flds, $taboptarray);
$dict->ExecuteSQLArray($sqlarray);

$flds = "
	id I KEY AUTO,
	name C(255) NOT NULL,
	type C(50),
	max_length I,
	create_date " . CMS_ADODB_DT . ",
	modified_date " . CMS_ADODB_DT . ",
    item_order I,
    admin_only I,
    public I,
    dropdown_data X,
    data X
";

$taboptarray = array('mysql' => 'TYPE=MyISAM');
$sqlarray = $dict->CreateTableSQL(cms_db_prefix()."module_compdir_fielddefs", $flds, $taboptarray);
$dict->ExecuteSQLArray($sqlarray);

$flds = "
	company_id I KEY NOT NULL,
	fielddef_id I KEY NOT NULL,
	value X,
	create_date " . CMS_ADODB_DT . ",
	modified_date " . CMS_ADODB_DT . "
";

$taboptarray = array('mysql' => 'TYPE=MyISAM');
$sqlarray = $dict->CreateTableSQL(cms_db_prefix()."module_compdir_fieldvals", $flds, $taboptarray);
$dict->ExecuteSQLArray($sqlarray);


$flds = "
	id I KEY AUTO,
	date_searched ".CMS_ADODB_DT." NOT NULL,
    ip_address  C(255),
    feu_uid     I
";
$sqlarray = $dict->CreateTableSQL(cms_db_prefix()."module_compdir_searchstats", $flds, $taboptarray);
$dict->ExecuteSQLArray($sqlarray);

$flds = "
   search_id I KEY NOT NULL,
   name C(255) KEY NOT NULL,
   val  C(255) NOT NULL
";
$sqlarray = $dict->CreateTableSQL(cms_db_prefix()."module_compdir_searchstats_vars", $flds, $taboptarray);
$dict->ExecuteSQLArray($sqlarray);

$flds = "
   search_id I KEY NOT NULL,
   company_id I KEY NOT NULL
";
$sqlarray = $dict->CreateTableSQL(cms_db_prefix()."module_compdir_searchstats_res", $flds, $taboptarray);
$dict->ExecuteSQLArray($sqlarray);

$flds = "
	id I KEY AUTO,
	name C(255),
	parent_id I,
    iorder I,
	hierarchy C(255),
	long_name X
";
$sqlarray = $dict->CreateTableSQL(cms_db_prefix()."module_compdir_hier", $flds, $taboptarray);
$dict->ExecuteSQLArray($sqlarray);

# Indexes
$sqlarray = $dict->CreateIndexSQL('compdir_comp_name', cms_db_prefix().'module_compdir_companies','company_name');
$dict->ExecuteSQLArray($sqlarray);

$sqlarray = $dict->CreateIndexSQL('compdir_catg_name',cms_db_prefix().'module_compdir_categories','name');
$dict->ExecuteSQLArray($sqlarray);

$sqlarray = $dict->CreateIndexSQL('compdir_catg_iorder',cms_db_prefix().'module_compdir_categories','parent_id,item_order');
$dict->ExecuteSQLArray($sqlarray);

$sqlarray = $dict->CreateIndexSQL('compdir_compcat',cms_db_prefix().'module_compdir_company_categories','category_id,company_id');
$dict->ExecuteSQLArray($sqlarray);

$sqlarray = $dict->CreateIndexSQL('compdir_fielddef',cms_db_prefix().'module_compdir_fielddefs','name,id');
$dict->ExecuteSQLArray($sqlarray);

$sqlarray = $dict->CreateIndexSQL('cd_status',cms_db_prefix().'module_compdir_companies','status');
$dict->ExecuteSQLArray($sqlarray);

$sqlarray = $dict->CreateIndexSQL('cd_comp_url',cms_db_prefix().'module_compdir_companies','url');
$dict->ExecuteSQLArray($sqlarray);

$sqlarray = $dict->CreateIndexSQL('cd_comp_url2',cms_db_prefix().'module_compdir_companies','status,url');
$dict->ExecuteSQLArray($sqlarray);

$sqlarray = $dict->CreateIndexSQL('cd_comp_hier',cms_db_prefix().'module_compdir_companies','hier_id');
$dict->ExecuteSQLArray($sqlarray);

$sqlarray = $dict->CreateIndexSQL('cd_fld_name',cms_db_prefix().'module_compdir_fielddefs','name');
$dict->ExecuteSQLArray($sqlarray);

$sqlarray = $dict->CreateIndexSQL('cd_fld_order',cms_db_prefix().'module_compdir_fielddefs','item_order');
$dict->ExecuteSQLArray($sqlarray);

$sqlarray = $dict->CreateIndexSQL('cd_fld_public',cms_db_prefix().'module_compdir_fielddefs','public');
$dict->ExecuteSQLArray($sqlarray);

#
# Templates
#


# Setup summary template
$fn = cms_join_path(__DIR__,'templates','orig_summary_template.tpl');
if( file_exists( $fn ) ) {
  $template = file_get_contents( $fn );
  $this->SetPreference(COMPANYDIR_PREF_NEWSUMMARY_TEMPLATE,$template);
  $this->SetTemplate('summary_Sample',$template);
  $this->SetPreference(COMPANYDIR_PREF_DFLTSUMMARY_TEMPLATE,'Sample');
}

# Setup detail template
$fn = cms_join_path(__DIR__,'templates','orig_detail_template.tpl');
if( file_exists( $fn ) ) {
  $template = file_get_contents( $fn );
  $this->SetPreference(COMPANYDIR_PREF_NEWDETAIL_TEMPLATE,$template);
  $this->SetTemplate('detail_Sample',$template);
  $this->SetPreference(COMPANYDIR_PREF_DFLTDETAIL_TEMPLATE,'Sample');
}

# Setup default category list template
$fn = cms_join_path(__DIR__,'templates','orig_categorylist_template.tpl');
if( file_exists( $fn ) ) {
  $template = file_get_contents( $fn );
  $this->SetPreference(COMPANYDIR_PREF_NEWCATEGORYLIST_TEMPLATE,$template);
  $this->SetTemplate('categorylist_Sample',$template);
  $this->SetPreference(COMPANYDIR_PREF_DFLTCATEGORYLIST_TEMPLATE,'Sample');
}

# Setup default hierarchy list template
$fn = cms_join_path(__DIR__,'templates','orig_hierlist_template.tpl');
if( file_exists( $fn ) ) {
  $template = file_get_contents( $fn );
  $this->SetPreference(COMPANYDIR_PREF_NEWHIERLIST_TEMPLATE,$template);
  $this->SetTemplate('hierlist_Sample',$template);
  $this->SetPreference(COMPANYDIR_PREF_DFLTHIERLIST_TEMPLATE,'Sample');
}

# Setup default search form template
$fn = cms_join_path(__DIR__,'templates','orig_newsearch_template.tpl');
if( file_exists( $fn ) ) {
  $template = file_get_contents( $fn );
  $this->SetPreference(COMPANYDIR_PREF_NEWSEARCHFORM_TEMPLATE,$template);
  $this->SetTemplate('newsearch_Sample',$template);
  $this->SetPreference(COMPANYDIR_PREF_DFLTSEARCHFORM_TEMPLATE,'Sample');
}

# Setup default front end form template
$fn = cms_join_path(__DIR__,'templates','orig_frontendform_template.tpl');
if( file_exists( $fn ) ) {
  $template = file_get_contents( $fn );
  $this->SetPreference(COMPANYDIR_PREF_NEWFRONTENDFORM_TEMPLATE,$template);
  $this->SetTemplate('frontendform_Sample',$template);
  $this->SetPreference(COMPANYDIR_PREF_DFLTFRONTENDFORM_TEMPLATE,'Sample');
}

# Setup default front end list template
$fn = cms_join_path(__DIR__,'templates','orig_frontendlist_template.tpl');
if( file_exists( $fn ) ) {
  $template = file_get_contents( $fn );
  $this->SetPreference(COMPANYDIR_PREF_NEWFRONTENDLIST_TEMPLATE,$template);
  $this->SetTemplate('frontendlist_Sample',$template);
  $this->SetPreference(COMPANYDIR_PREF_DFLTFRONTENDLIST_TEMPLATE,'Sample');
}

# Setup default abc list template
$fn = cms_join_path(__DIR__,'templates','orig_abclist_template.tpl');
if( file_exists( $fn ) ) {
  $template = file_get_contents( $fn );
  $this->SetPreference(COMPANYDIR_PREF_NEWABCLIST_TEMPLATE,$template);
  $this->SetTemplate('abclist_Sample',$template);
  $this->SetPreference(COMPANYDIR_PREF_DFLTABCLIST_TEMPLATE,'Sample');
}

# Setup default front end form template
$fn = cms_join_path(__DIR__,'templates','orig_frontendalbum_template.tpl');
if( file_exists( $fn ) ) {
  $template = file_get_contents( $fn );
  $this->SetPreference(COMPANYDIR_PREF_NEWFRONTENDALBUM_TEMPLATE,$template);
  $this->SetTemplate('frontendalbum_Sample',$template);
  $this->SetPreference(COMPANYDIR_PREF_DFLTFRONTENDALBUM_TEMPLATE,'Sample');
}

# Setup default frontend import template
$fn = cms_join_path(__DIR__,'templates','orig_frontendimport_template.tpl');
if( file_exists( $fn ) ) {
  $template = file_get_contents( $fn );
  $this->SetTemplate(COMPANYDIR_FRONTENDIMPORT_TEMPLATE,$template);
}

# setup search stats summary template
$fn = cms_join_path(__DIR__,'templates','orig_searchstats_summary_template.tpl');
if( file_exists( $fn ) ) {
  $template = file_get_contents( $fn );
  $this->SetPreference(COMPANYDIR_PREF_NEWSTATSSUMMARY_TEMPLATE,$template);
  $this->SetTemplate('statssummary_Sample',$template);
  $this->SetPreference(COMPANYDIR_PREF_DFLTSTATSSUMMARY_TEMPLATE,'Sample');
}

# setup frontend edit email template
$fn = __DIR__.'/templates/orig_admin_feedit_email_template.tpl';
if( file_exists($fn) ) {
  $template = @file_get_contents($fn);
  $this->SetTemplate('admin_feedit_email_template',$template);
}

# setup default frontend import template
$fn = cms_join_path(__DIR__,'templates','orig_frontendimport_template.tpl');
if( file_exists( $fn ) ) {
  $template = file_get_contents( $fn );
  $this->SetTemplate(COMPANYDIR_FRONTENDIMPORT_TEMPLATE,$template);
}

#Set Permission
$this->CreatePermission('Modify Company Directory', 'Modify Company Directory');

# Preferences
$this->SetPreference('import_delimeter','|');
$this->SetPreference('import_fielddefs',1);
$this->SetPreference('import_fieldvals',1);
$this->SetPreference('import_categorydefs',1);
$this->SetPreference('import_categoryvals',1);
$this->SetPreference('import_lookuplatlong',0);
$this->SetPreference('import_checkduplicates',1);
$this->SetPreference('admin_feedit_email_subject',$this->Lang('feedit_email_subject'));
$this->SetPreference('admin_feedit_email_ishtml',1);
$this->SetPreference('frontend_editor2',1);

# Events
$this->CreateEvent('OnAddCompany');
$this->CreateEvent('OnDeleteCompany');
$this->CreateEVent('OnEditCompany');

cd_utils::create_fulltext_index();
?>