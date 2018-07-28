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

$db = $this->GetDb();
$dict = NewDataDictionary($db);

    $current_version = $oldversion;
    switch($current_version)
      {
      case "1.0":
	// don't do anything... we can't upgrade this
	break;
      case "2.0":
	// we need to add a column to the banners table
	$sqlarray = $dict->AddColumnSQL(cms_db_prefix()."module_banners", "href_text C(255)");
	$dict->ExecuteSQLArray($sqlarray);
	$current_version = "2.0.1";
      case "2.0.1":
	// we need to add a column to the categories table
	$sqlarray = $dict->AddColumnSQL(cms_db_prefix()."module_banners_categories", "uploads_category_id I");
	$dict->ExecuteSQLArray($sqlarray);
      case '2.2':
      case '2.2.1':
	// we need to add a start_date column to the banners table
	$sqlarray = $dict->AddColumnSQL(cms_db_prefix().'module_banners', 'start_date '.CMS_ADODB_DT);
	$dict->ExecuteSQLArray($sqlarray);
	// we need to drop columns from the categories table
	$sqlarray = $dict->DropColumnSQL(cms_db_prefix().'module_banners_categories','image_width,image_height');
	$dict->ExecuteSQLArray($sqlarray);
	// we need to add a template column to the categories table
	$sqlarray = $dict->AddColumnSQL(cms_db_prefix()."module_banners_categories", "template X");
	$dict->ExecuteSQLArray($sqlarray);

	// default category template
	$fn = dirname(__FILE__).'/templates/orig_category_template.tpl';
	$data = @file_get_contents($fn);
	$this->SetPreference('default_template',$data);

	$query = 'UPDATE '.cms_db_prefix().'module_banners_categories SET template = ?';
	$db->Execute($query,array($data));

	$fn = dirname(__FILE__).'/templates/orig_bannerlist_template.tpl';
	$data = @file_get_contents($fn);
	$this->SetTemplate('bannerlist_template',$data);


      case '2.3.5':
	$sqlarray = $dict->AddColumnSQL(cms_db_prefix().'module_banners', 'last_impression '.CMS_ADODB_DT);
	$dict->ExecuteSQLArray($sqlarray);

	$query = 'SELECT banner_id,category_id,num_impressions 
                    FROM '.cms_db_prefix().'module_banners
                   ORDER BY num_impressions DESC';
	$res = $db->GetArray($query);
	if( is_array($res) )
	  {
	    $query = 'UPDATE '.cms_db_prefix().'module_banners 
                         SET last_impression = ? WHERE banner_id = ?';
	    $the_time = time();
	    for( $i = count($res) - 1; $i >= 0; $i-- )
	      {
		$the_time -= 10; // offset by 10 seconds.
		$tmp = trim($db->DbTimeStamp($the_time),"'");
		$db->Execute($query,$tmp,$res[$i]['banner_id']);
	      }
	  }

      case '2.3.6':
      case '2.3.7':
      case '2.3.8':
      case '2.3.9':
	$sqlarray = $dict->AddColumnSQL(cms_db_prefix().'module_banners_categories', 'dflt_image C(255),dflt_url C(255)');
	$dict->ExecuteSQLArray($sqlarray);

      case '2.3.4':
      case '2.4':
	$fn = dirname(__FILE__).'/templates/orig_report_template.tpl';
	$data = @file_get_contents($fn);
	$this->SetTemplate('statreport_template',$data);
	
      }

    // put mention into the admin log
    $this->Audit( 0, $this->Lang('friendlyname'), 
		  $this->Lang('upgraded',$this->GetVersion()));

?>
