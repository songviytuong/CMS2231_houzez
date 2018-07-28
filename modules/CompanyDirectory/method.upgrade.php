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

$db = $this->GetDb();
$taboptarray = array('mysql' => 'TYPE=MyISAM');
$dict = NewDataDictionary($db);
$current_version = $oldversion;

switch($current_version) {
 case "1.0.4":
   {
     $sqlarray = $dict->AddColumnSQL(cms_db_prefix()."module_compdir_fielddefs", "item_order I");
     $dict->ExecuteSQLArray($sqlarray);

     $count = 0;
     $dbresult = $db->Execute('SELECT * FROM ' . cms_db_prefix() . 'module_compdir_fielddefs');
     while ($dbresult && $row = $dbresult->FetchRow()) {
       $db->Execute('UPDATE ' . cms_db_prefix() . 'module_compdir_fielddefs SET item_order = ? WHERE id = ?', array($count, $row['id']));
       $count++;
     }
   }

 case "1.0.5":
   {
     $sqlarray = $dict->AddColumnSQL(cms_db_prefix()."module_compdir_fielddefs", "user_editable I, user_viewable I");
     $dict->ExecuteSQLArray($sqlarray);
     $sqlarray = $dict->AddColumnSQL(cms_db_prefix()."module_compdir_companies", "status C(50)");
     $dict->ExecuteSQLArray($sqlarray);
     $db->Execute( 'UPDATE '.cms_db_prefix().'module_compdir_fielddefs SET admin_only = 1, public = 1' );

     // convert displaysummary to summary_blah and mark it as default
     $template = $this->GetTemplate('displaysummary');
     $this->SetTemplate('summary__dflt',$template);
     $this->SetPreference(COMPANYDIR_PREF_DFLTSUMMARY_TEMPLATE,'_dflt');
     $this->DeleteTemplate('displaysummary');

     // convert displaydetail to detail_blah and mark it as default
     $template = $this->GetTemplate('displaydetail');
     $this->SetTemplate('detail__dflt',$template);
     $this->SetPreference(COMPANYDIR_PREF_DFLTDETAIL_TEMPLATE,'_dflt');
     $this->DeleteTemplate('displaydetail');

     // Setup default category list template
     $fn = cms_join_path(__DIR__,'templates','orig_categorylist_template.tpl');
     if( file_exists( $fn ) ) {
       $template = file_get_contents( $fn );
       $this->SetPreference(COMPANYDIR_PREF_NEWCATEGORYLIST_TEMPLATE,$template);
       $this->SetTemplate('categorylist_Sample',$template);
       $this->SetPreference(COMPANYDIR_PREF_DFLTCATEGORYLIST_TEMPLATE,'Sample');
     }

     // Setup default front end form template
     $fn = cms_join_path(__DIR__,'templates','orig_frontendform_template.tpl');
     if( file_exists( $fn ) ) {
       $template = file_get_contents( $fn );
       $this->SetPreference(COMPANYDIR_PREF_NEWFRONTENDFORM_TEMPLATE,$template);
       $this->SetTemplate('frontendform_Sample',$template);
       $this->SetPreference(COMPANYDIR_PREF_DFLTFRONTENDFORM_TEMPLATE,'Sample');
     }
   }

 case '1.1.6':
   {
     $sqlarray = $dict->AddColumnSQL(cms_db_prefix().'module_compdir_fielddefs','dropdown_data X');
     $dict->ExecuteSQLArray($sqlarray);
     $sqlarray = $dict->CreateIndexSQL('compdir_comp_name',
				       cms_db_prefix().'module_compdir_companies',
				       'company_name');
     $dict->ExecuteSQLArray($sqlarray);
     $sqlarray = $dict->CreateIndexSQL('compdir_catg_name',
				       cms_db_prefix().'module_compdir_categories',
				       'name');
     $dict->ExecuteSQLArray($sqlarray);
     $sqlarray = $dict->CreateIndexSQL('compdir_compcat',
				       cms_db_prefix().'module_compdir_company_categories',
				       'category_id,company_id');
     $dict->ExecuteSQLArray($sqlarray);
     $sqlarray = $dict->CreateIndexSQL('compdir_fielddef',
				       cms_db_prefix().'module_compdir_company_fielddefs',
				       'name,id');
     $dict->ExecuteSQLArray($sqlarray);
   }

 case '1.1.7':
   {
     $sqlarray = $dict->CreateIndexSQL('cd_status',
				       cms_db_prefix().'module_compdir_companies',
				       'status');
     $dict->ExecuteSQLArray($sqlarray);

     $sqlarray = $dict->CreateIndexSQL('cd_fld_name',
				       cms_db_prefix().'module_compdir_fielddefs',
				       'name');
     $dict->ExecuteSQLArray($sqlarray);

     $sqlarray = $dict->CreateIndexSQL('cd_fld_order',
				       cms_db_prefix().'module_compdir_fielddefs',
				       'item_order');
     $dict->ExecuteSQLArray($sqlarray);

     $sqlarray = $dict->CreateIndexSQL('cd_fld_public',
				       cms_db_prefix().'module_compdir_fielddefs',
				       'public');
     $dict->ExecuteSQLArray($sqlarray);
   }

 case '1.1.7':
 case '1.1.8':
   {
     $sqlarray = $dict->AddColumnSQL(cms_db_prefix().'module_compdir_companies','latitude F, longitude F,owner_id I');
     $dict->ExecuteSQLArray($sqlarray);

     $sqlarray = $dict->CreateIndexSQL('cd_fld_coords',
				       cms_db_prefix().'module_compdir_companies',
				       'latitude, longitude');
     $dict->ExecuteSQLArray($sqlarray);

     $sqlarray = $dict->CreateIndexSQL('cd_fld_owner',
				       cms_db_prefix().'module_compdir_companies',
				       'owner_id');
     $dict->ExecuteSQLArray($sqlarray);

     $this->SetPreference('import_delimeter','|');
     $this->SetPreference('import_fielddefs',1);
     $this->SetPreference('import_fieldvals',1);
     $this->SetPreference('import_categorydefs',1);
     $this->SetPreference('import_categoryvals',1);
     $this->SetPreference('import_lookuplatlong',0);
     $this->SetPreference('import_checkduplicates',1);

     // Setup default search form template
     $fn = cms_join_path(__DIR__,'templates','orig_searchform_template.tpl');
     if( file_exists( $fn ) ) {
       $template = file_get_contents( $fn );
       $this->SetPreference(COMPANYDIR_PREF_NEWSEARCHFORM_TEMPLATE,$template);
       $this->SetTemplate('searchform_Sample',$template);
       $this->SetPreference(COMPANYDIR_PREF_DFLTSEARCHFORM_TEMPLATE,'Sample');
     }
   }

 case '1.2':
   {
     $flds = "company_id I KEY NOT NULL, date_searched ".CMS_ADODB_DT." NOT NULL, postcode C(20)";
     $sqlarray = $dict->CreateTableSQL(cms_db_prefix()."module_compdir_searchstats", $flds, $taboptarray);
     $dict->ExecuteSQLArray($sqlarray);
   }

 case '1.4.1':
   {
     $fn = cms_join_path(__DIR__,'templates','orig_frontendlist_template.tpl');
     if( file_exists( $fn ) ) {
       $template = file_get_contents( $fn );
       $this->SetPreference(COMPANYDIR_PREF_NEWFRONTENDLIST_TEMPLATE,$template);
       $this->SetTemplate('frontendlist_Sample',$template);
       $this->SetPreference(COMPANYDIR_PREF_DFLTFRONTENDLIST_TEMPLATE,'Sample');
     }

     $flds = "
  	   id I KEY AUTO,
	   name C(255),
  	   parent_id I,
	   hierarchy C(255),
	   long_name X
     ";
     $sqlarray = $dict->CreateTableSQL(cms_db_prefix()."module_compdir_hier", $flds, $taboptarray);
     $dict->ExecuteSQLArray($sqlarray);

     $sqlarray = $dict->AddColumnSQL(cms_db_prefix().'module_compdir_companies','hier_id I');
     $dict->ExecuteSQLArray($sqlarray);

   }

 case '1.5':
   {
     # Setup default hierarchy list template
     $fn = cms_join_path(__DIR__,'templates','orig_hierlist_template.tpl');
     if( file_exists( $fn ) ) {
       $template = file_get_contents( $fn );
       $this->SetPreference(COMPANYDIR_PREF_NEWHIERLIST_TEMPLATE,$template);
       $this->SetTemplate('hierlist_Sample',$template);
       $this->SetPreference(COMPANYDIR_PREF_DFLTHIERLIST_TEMPLATE,'Sample');
     }
   }

 case '1.5.1':
   {
     # Setup default frontend import template
     $fn = cms_join_path(__DIR__,'templates','orig_frontendimport_template.tpl');
     if( file_exists( $fn ) ) {
       $template = file_get_contents( $fn );
       $this->SetTemplate(COMPANYDIR_FRONTENDIMPORT_TEMPLATE,$template);
     }
   }

 case '1.5.2':
 case '1.5.3':
 case '1.5.4':
 case '1.5.5':
 case '1.5.6':
 case '1.5.7':
 case '1.5.8':
 case '1.6':
   {
     $sqlarray = $dict->AddColumnSQL(cms_db_prefix().'module_compdir_categories',
				     'extra1 C(255), extra2 C(255), extra3 C(255)');
     $dict->ExecuteSQLArray($sqlarray);
   }

 case '1.6.1':
 case '1.6.2':
 case '1.6.3':
 case '1.6.4':
 case '1.7':
 case '1.7.1':
 case '1.7.2':
   {
     // copied from above to solve an issue... should silently fail if fields already exist';
     $sqlarray = $dict->AddColumnSQL(cms_db_prefix().'module_compdir_companies','latitude F, longitude F,owner_id I,hier_id I');
     $dict->ExecuteSQLArray($sqlarray);

     $sqlarray = $dict->CreateIndexSQL('cd_fld_coords',
				       cms_db_prefix().'module_compdir_companies',
				       'latitude, longitude');
     $dict->ExecuteSQLArray($sqlarray);

     $sqlarray = $dict->CreateIndexSQL('cd_fld_owner',
				       cms_db_prefix().'module_compdir_companies',
				       'owner_id');
     $dict->ExecuteSQLArray($sqlarray);

     // new stuff....
     $this->SetPreference('admin_feedit_email_subject',$this->Lang('feedit_email_subject'));
     $this->SetPreference('admin_feedit_email_ishtml',1);

     $sqlarray = $dict->AddColumnSQL(cms_db_prefix().'module_compdir_company_categories',
				     'extra1 C(255), extra2 C(255), extra3 C(255)');
     $dict->ExecuteSQLArray($sqlarray);

     $fn = __DIR__.'/templates/orig_admin_feedit_email_template.tpl';
     if( file_exists($fn) ) {
	   $template = @file_get_contents($fn);
	   $this->SetTemplate('admin_feedit_email_template',$template);
	 }

   }

 case '1.7.3':
 {
   $sqlarray = $dict->AddColumnSQL(cms_db_prefix().'module_compdir_companies','url C(255)');
   $dict->ExecuteSQLArray($sqlarray);

   $query = 'UPDATE '.cms_db_prefix().'module_compdir_companies SET url = ?';
   $db->Execute($query,array(''));
 }
}

if( version_compare($oldversion,'1.12') < 0 ) {
  $sqlarray = $dict->AddColumnSQL(cms_db_prefix().'module_compdir_categories','image C(255),description X');
  $dict->ExecuteSQLArray($sqlarray);
}

if( version_compare($oldversion,'1.13') < 0 ) {
  $sqlarray = $dict->AddColumnSQL(cms_db_prefix().'module_compdir_fielddefs','data X');
  $dict->ExecuteSQLArray($sqlarray);
}

if( version_compare($oldversion,'1.14') < 0 ) {
  $this->CreateEvent('OnAddCompany');
  $this->CreateEvent('OnDeleteCompany');
  $this->CreateEVent('OnEditCompany');
}

if( version_compare($oldversion,'1.15') < 0 ) {
  $this->SetPreference('use_oldsearch',1); // backwards compatibility stuff.

  $fn = cms_join_path(__DIR__,'templates','orig_newsearch_template.tpl');
  if( file_exists( $fn ) ) {
	$template = file_get_contents( $fn );
	$this->SetTemplate(COMPANYDIR_SEARCHFORM_SYSDFLTTEMPLATE,$template);
	$this->SetTemplate('newsearch_Sample',$template);
	$this->SetPreference(COMPANYDIR_SEARCHFORM_DFLTTEMPLATENAME,'Sample');
  }
}

if( version_compare($oldversion,'1.17') < 0 ) {
  $fn = cms_join_path(__DIR__,'templates','orig_frontendalbum_template.tpl');
  if( file_exists( $fn ) ) {
    $template = file_get_contents( $fn );
    $this->SetPreference(COMPANYDIR_PREF_NEWFRONTENDALBUM_TEMPLATE,$template);
    $this->SetTemplate('frontendalbum_Sample',$template);
    $this->SetPreference(COMPANYDIR_PREF_DFLTFRONTENDALBUM_TEMPLATE,'Sample');
  }
}

if( version_compare($oldversion,'1.19') < 0 ) {
  $sqlarray = $dict->AddColumnSQL(cms_db_prefix().'module_compdir_categories','iorder I');
  $dict->ExecuteSQLArray($sqlarray);

  $sqlarray = $dict->CreateIndexSQL('cdcat_iorder',cms_db_prefix().'module_compdir_categories','iorder');
  $dict->ExecuteSQLArray($sqlarray);

  $sqlarray = $dict->AddColumnSQL(cms_db_prefix().'module_compdir_hier','iorder I');
  $dict->ExecuteSQLArray($sqlarray);

  $sqlarray = $dict->CreateIndexSQL('cdhier_hier',cms_db_prefix().'module_compdir_hier','hierarchy');
  $dict->ExecuteSQLArray($sqlarray);

  $query = 'SELECT id FROM '.cms_db_prefix().'module_compdir_categories ORDER BY create_date ASC';
  $idlist = $db->GetCol($query);
  if( is_array($idlist) && count($idlist) ) {
	$query = 'UPDATE '.cms_db_prefix().'module_compdir_categories SET iorder = ? WHERE id = ?';
	$i = 1;
	foreach( $idlist as $one ) {
	  $db->Execute($query,array($i++,(int)$one));
	}
  }

  //debug_display($db->sql.' -- '.$db->ErrorMsg());

  $query = 'SELECT id,name,parent_id FROM '.cms_db_prefix().'module_compdir_hier ORDER BY hierarchy';
  $hier = $db->GetArray($query);
  if( is_array($hier) && count($hier) ) {
    $update_hierorder = function($parent_id = -1) use (&$update_hierorder,&$hier) {
      $iorder = 1;
      foreach( $hier as &$row ) {
        if( $row['parent_id'] == $parent_id ) {
		  $row['iorder'] = $iorder++;
		  $update_hierorder($row['id']);
		}
	  }
    };
	$update_hierorder();

	$query = 'UPDATE '.cms_db_prefix().'module_compdir_hier SET iorder = ? WHERE id = ?';
	foreach( $hier as $row ) {
	  $dbr = $db->Execute($query,array($row['iorder'],$row['id']));
	}
	cd_utils::update_hierarchy_positions();
  }
}

if( version_compare($oldversion,'1.19.2') < 0 ) {
  $sqlarray = $dict->CreateIndexSQL('cd_comp_hier',cms_db_prefix().'module_compdir_companies','hier_id');
  $dict->ExecuteSQLArray($sqlarray);

  $sqlarray = $dict->CreateIndexSQL('cd_comp_url',cms_db_prefix().'module_compdir_companies','url');
  $dict->ExecuteSQLArray($sqlarray);

  $sqlarray = $dict->CreateIndexSQL('cd_comp_url2',cms_db_prefix().'module_compdir_companies','status,url');
  $dict->ExecuteSQLArray($sqlarray);

  $sqlarray = $dict->CreateIndexSQL('compdir_catg_iorder',cms_db_prefix().'module_compdir_categories','iorder');
  $dict->ExecuteSQLArray($sqlarray);

  // changes the hierarchy field to use item orders, instead of id's.
  cd_utils::update_hierarchy_positions();
}

if( version_compare($oldversion,'1.20') < 0 ) {
  $query = 'SELECT * FROM '.cms_db_prefix().'module_compdir_fielddefs ORDER BY id';
  $dbr = $db->GetArray($query);
  $query2 = 'UPDATE '.cms_db_prefix().'module_compdir_fielddefs SET item_order = ? WHERE id = ?';
  for( $i = 0; $i < count($dbr); $i++ ) {
	$db->Execute($query2,array($i+1,$dbr[$i]['id']));
  }

  $oldsearch = $this->ListTemplatesWithPrefix('searchform_',TRUE);
  if( is_array($oldsearch) && count($oldsearch) ) {
	// just so we don't lose this data, we're gonna edit these templates
	// and savethem under new names
	$tmpl_prefix = "{* OLD SEARCH FORM, SAVED FOR REFERENCE PURPOSES BUT NOT USEABLE *}\n";
	foreach( $oldsearch as $one ) {
	  $tmpl = $this->GetTemplate('searchform_'.$one);
	  $tmpl = $tpmpl_prefix . $tmpl;
	  $this->SetTemplate('newsearch_old_'.$one,$tmpl);
	}
  }

  $fn = cms_join_path(__DIR__,'templates','orig_newsearch_template.tpl');
  if( file_exists( $fn ) ) {
	$template = file_get_contents( $fn );
	$this->SetPreference(COMPANYDIR_PREF_NEWSEARCHFORM_TEMPLATE,$template);
	$this->SetTemplate('newsearch_Sample_1.20',$template);
	$this->SetPreference(COMPANYDIR_PREF_DFLTSEARCHFORM_TEMPLATE,'Sample_1.20');
  }
}

if( version_compare($oldversion,'1.21') < 0 ) {
  $sqlarray = $dict->DropTableSQL( cms_db_prefix()."module_compdir_searchstats" );
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

  # setup search stats summary template
  $fn = cms_join_path(__DIR__,'templates','orig_searchstats_summary_template.tpl');
  if( file_exists( $fn ) ) {
	$template = file_get_contents( $fn );
	$this->SetPreference(COMPANYDIR_PREF_NEWSTATSSUMMARY_TEMPLATE,$template);
	$this->SetTemplate('statssummary_Sample',$template);
	$this->SetPreference(COMPANYDIR_PREF_DFLTSTATSSUMMARY_TEMPLATE,'Sample');
  }

  cd_utils::create_fulltext_index();
}

if( version_compare($oldversion,'1.22') < 0 ) {
  // create new fields
  $sqlarray = $dict->AddColumnSQL(cms_db_prefix().'module_compdir_categories','parent_id I, item_order I, hierarchy C(255), long_name C(255)');
  $dict->ExecuteSqlArray($sqlarray);

  // convert iorder to item_order
  $query = 'UPDATE '.cms_db_prefix().'module_compdir_categories SET parent_id = -1, item_order = iorder';
  $db->Execute($query);

  // drop columns we no longer need
  $sqlarray = $dict->DropColumnSQL(cms_db_prefix().'module_compdir_categories','iorder,create_date,modified_date');
  $dict->ExecuteSqlArray($sqlarray);

  // update hierarchy positions for categories
  cd_category::calculate_hierarchy_positions();
}

if( version_compare($oldversion,'1.22.1') < 0 ) {
  $query = 'UPDATE '.cms_db_prefix().'module_compdir_categories SET parent_id = -1 WHERE COALESCE(parent_id,-1) < 1';
  $db->Execute($query);
  cd_category::calculate_hierarchy_positions();
}
if( version_compare($oldversion,'1.22.5') < 0 ) {
  // this should silently fail if the table already exists.
  $flds = "
     search_id I KEY NOT NULL,
     name C(255) KEY NOT NULL,
     val  C(255) NOT NULL
   ";
  $sqlarray = $dict->CreateTableSQL(cms_db_prefix()."module_compdir_searchstats_vars", $flds, $taboptarray);
  $dict->ExecuteSQLArray($sqlarray);
}
if( version_compare($oldversion,'1.23') < 0 ) {
  # Setup default abc list template
  $fn = cms_join_path(__DIR__,'templates','orig_abclist_template.tpl');
  if( file_exists( $fn ) ) {
    $template = file_get_contents( $fn );
    $this->SetPreference(COMPANYDIR_PREF_NEWABCLIST_TEMPLATE,$template);
    $this->SetTemplate('abclist_Sample',$template);
    $this->SetPreference(COMPANYDIR_PREF_DFLTABCLIST_TEMPLATE,'Sample');
  }
}
