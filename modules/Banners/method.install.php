<?php
#BEGIN_LICENSE
#-------------------------------------------------------------------------
# Module: Banners (c) 2008 by Robert Campbell
#         (calguy1000@cmsmadesimple.org)
#  An addon module for CMS Made Simple to allow management, display,
#  and tracking of banner images.
#
#-------------------------------------------------------------------------
# CMS - CMS Made Simple is (c) 2005 by Ted Kulp (wishy@cmsmadesimple.org)
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

    // mysql-specific, but ignored by other database
    $taboptarray = array('mysql' => 'TYPE=MyISAM');
    $dict = NewDataDictionary($db);

    // table schema description
    // if url and image are NULL, text cannot be.
    $flds = "
	   banner_id I KEY,
	   category_id I NOTNULL,
	   name C(80) NOTNULL,
	   description C(255),
	   image  C(255),
	   url    C(255),
	   text   X,
	   created ".CMS_ADODB_DT." NOTNULL,
	   expires ".CMS_ADODB_DT.",
	   max_impressions I4,
	   num_impressions I4 DEFAULT 0 NOTNULL,
	   href_text C(255),
       start_date ".CMS_ADODB_DT.",
       last_impression ".CMS_ADODB_DT."
	";

    // create it. This should do error checking, but I'm a lazy sod.
    $sqlarray = $dict->CreateTableSQL(cms_db_prefix()."module_banners", $flds, $taboptarray);
    $dict->ExecuteSQLArray($sqlarray);

    // create a sequence for this table
    $db->CreateSequence(cms_db_prefix()."module_banners_seq");

    // create a table for the categories
    $flds = "
     category_id  I KEY,
     name         C(80) NOTNULL,
     description  C(255),
     uploads_category_id I,
     template     X,
     dflt_image   C(255),
     dflt_url     C(255)
    ";
    $sqlarray = $dict->CreateTableSQL(cms_db_prefix()."module_banners_categories",
				      $flds, $taboptarray);
    $dict->ExecuteSQLArray($sqlarray);

    // and a sequence for this one too
    $db->CreateSequence(cms_db_prefix()."module_banners_categories_seq");

    // and a table so we can keep track of hits/clickthrus
    $flds = "
	   banner_id  I KEY,
	   time       ".CMS_ADODB_DT." KEY,
	   ip_address C(16) NOTNULL KEY
	  ";
    $sqlarray = $dict->CreateTableSQL(cms_db_prefix()."module_banners_hits",
				      $flds, $taboptarray);
    $dict->ExecuteSQLArray($sqlarray);

    // create a permission
    $this->CreatePermission('Banners Manager', 'Banners Manager');

    // and some preferences
    $this->SetPreference("subnet_exclusions", "");

    // default category template
    $fn = dirname(__FILE__).'/templates/orig_category_template.tpl';
    $data = @file_get_contents($fn);
    $this->SetPreference('default_template',$data);

$fn = dirname(__FILE__).'/templates/orig_bannerlist_template.tpl';
$data = @file_get_contents($fn);
$this->SetTemplate('bannerlist_template',$data);

    // put mention into the admin log
    $this->Audit( 0, $this->Lang('friendlyname'), $this->Lang('installed',$this->GetVersion()));

$fn = dirname(__FILE__).'/templates/orig_report_template.tpl';
$data = @file_get_contents($fn);
$this->SetTemplate('statreport_template',$data);

?>
