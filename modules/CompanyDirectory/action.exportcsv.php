<?php  /* -*- Mode: PHP; tab-width: 4; c-basic-offset: 2 -*- */
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

function process_field($txt,$delim = '|')
{
  $txt = trim($txt);
  //$txt = str_replace($delim,'-%%-',$txt);
  $txt = str_replace("\r\n","\n",$txt);
  $txt = str_replace("\r","\n",$txt);
  //$txt = str_replace("\n",'^^',$txt);
  if( strstr($txt,' ') !== FALSE || strstr($txt,"\n") != FALSE || strstr($txt,$delim) != FALSE ) $txt = '"'.$txt.'"';
  return $txt;
}

$delim = '|';
$all_cats = cd_utils::get_categories(TRUE);

$query = 'SELECT * FROM '.cms_db_prefix().'module_compdir_fielddefs ORDER BY item_order ASC';
$fielddefs = $db->GetArray($query);

// 1.1 Get the companies header.
$query = "SELECT * FROM ".cms_db_prefix()."module_compdir_companies ORDER BY company_name LIMIT 1";
$row = $db->GetRow($query);
unset($row['create_date']);
unset($row['modified_date']);
unset($row['id']);
unset($row['owner_id']);
unset($row['picture_location']);
unset($row['logo_location']);
unset($row['hier_id']);
$row['hierarchy'] = 1; // add a meta column
//$row['categories'] = 1; // add a meta column
$company_fields = array_keys($row);

$_make_fieldhdr = function($name) {
  $name = trim($name);
  $out = 'FIELD:';
  if( strpos($name,' ') !== FALSE ) {
    $out .= '"'.$name.'"';
  }
  else {
    $out .= $name;
  }
  return $out;
};

$_make_cathdr = function($catid) use( $all_cats, $delim ) {
  $catid = (int)$catid;
  if( !isset($all_cats[$catid]) ) return;

  $name = $all_cats[$catid]->long_name;
  $out = 'CAT:';
  $out .= $name;
  if( strpos($out,' ') !== FALSE || strpos($out,$delim) !== FALSE ) $out = '"'.$out.'"';
  return $out;
};

// 1.1.1 Get the field definition names
if( $fielddefs && is_array($fielddefs) ) {
  foreach( $fielddefs as $one ) {
    $company_fields[] = $_make_fieldhdr($one['name']);
  }
}

// 1.1.2 Get the category names
if( is_array($all_cats) && count($all_cats) ) {
  foreach( $all_cats as $catid => $row ) {
    $company_fields[] = $_make_cathdr($catid);
  }
}

// get the company header
// 1.0 Build the header line
$header = "#COMPANY=C".$delim;
$header .= implode($delim,$company_fields)."\n";

// 1.2 Get the field definition header
if( is_array($fielddefs) && count($fielddefs) ) {
  $row = $fielddefs[0];
  unset($row['id']);
  unset($row['item_order']);
  unset($row['create_date']);
  unset($row['modified_date']);
  $fielddef_fields = array_keys($row);
  $header .= "#FIELDDEF=F".$delim.implode($delim,$fielddef_fields);
}

// 2.0 Get the categories definition header
$category_map = array('name','description','long_name','extra1','extra2','extra3');
$header .= "\n#CATEGORY=T".$delim.implode($delim,$category_map)."\n";

// 3.0 Get the hierarchy definition header
$hierarchy_map = array('name','long_name');
$header .= "#HIERARCHY=H".$delim.implode($delim,$hierarchy_map)."\n";

// 4.0 begin output.
$csv_output = $header."\n";

// 4.1 output the field definitions
if( is_array($fielddefs) && count($fielddefs) ) {
  foreach( $fielddefs as $row ) {
    $tmp = array('F');
    foreach( $fielddef_fields as $fn ) {
      $data = process_field($row[$fn],$delim);
      $tmp[] = $data;
    }
    $line = implode($delim,$tmp)."\n";
    $csv_output .= $line;
  }
  $csv_output .= "\n";
}

// 4.2 output the categories
if( is_array($all_cats) && count($all_cats) ) {
  foreach( $all_cats as $row ) {
    $tmp = array('T');
    foreach( $category_map as $col ) {
      $tmp[] = process_field($row->$col,$delim);
    }
    $line = implode($delim,$tmp)."\n";
    $csv_output .= $line;
  }
  $csv_output .= "\n";
}

// 4.3 output the hierarchies
$hierarchies = cd_utils::get_hierarchy();
foreach( $hierarchies as $row ) {
  $tmp = array('H');
  foreach( $hierarchy_map as $col ) {
    $tmp[] = process_field($row[$col],$delim);
  }
  $line = implode($delim,$tmp)."\n";
  $csv_output .= $line;
}
$csv_output .= "\n";

// 4.4 output the companies.
$csv_output .= "\n";
$query = "SELECT SQL_CALC_FOUND_ROWS c.*,h.long_name as hierarchy
            FROM ".cms_db_prefix()."module_compdir_companies c
            LEFT JOIN ".cms_db_prefix()."module_compdir_hier h
              ON c.hier_id = h.id ORDER BY c.company_name";
$fquery = 'SELECT B.company_id,A.name,B.value
             FROM '.cms_db_prefix().'module_compdir_fielddefs A
             LEFT JOIN '.cms_db_prefix().'module_compdir_fieldvals B
               ON A.id = B.fielddef_id
            WHERE B.company_id IN (%idlist%) ORDER BY B.company_id, A.name';
$cquery = 'SELECT CC.company_id,CC.category_id FROM '.cms_db_prefix().'module_compdir_company_categories CC
            WHERE CC.company_id IN (%idlist%) ORDER BY CC.company_id, CC.category_id';


$batchsize = 5; // debug
$offset = 0;
$total_matches = (int)$db->GetOne('SELECT COUNT(id) FROM '.cms_db_prefix().'module_compdir_companies');

while( $offset < $total_matches ) {
  //
  // output this batch of companies
  //

  // 4.4.1 - extract the list of company ids
  $dbr = $db->SelectLimit($query, $batchsize, $offset);
  if( !$dbr ) break;
  $company_ids = array();
  while( !$dbr->EOF() ) {
    if( !in_array($dbr->fields['id'], $company_ids) ) $company_ids[] = $dbr->fields['id'];
    $dbr->MoveNext();
  }
  $dbr->MoveFirst();
  if( !count($company_ids) ) break;

  // 4.4.2 - get the fieldvals for these companies
  $fieldvals = $db->GetArray(str_replace('%idlist%',implode(',',$company_ids),$fquery));

  // 4.4.3 - get the affected categories for these companies
  $catvalues = $db->GetArray(str_replace('%idlist%',implode(',',$company_ids),$cquery));

  while( !$dbr->EOF() ) {
    $row = $dbr->fields;
    $company_id = $row['id'];

    // get the fieldvals (if any) for this company, from the fieldvals array
    $c_fieldvals = array();
    if( is_array($fieldvals) && count($fieldvals) ) {
      foreach( $fieldvals as $frow ) {
        if( $frow['company_id'] == $company_id ) $row[$_make_fieldhdr($frow['name'])] = $frow['value'];
      }
    }

    // get the categories (if any) for this company, from the catvalues array
    $c_catvals = array();
    if( is_array($catvalues) && count($catvalues) ) {
      foreach( $catvalues as $crow ) {
        if( !isset($all_cats[$crow['category_id']]) ) continue;
        $cat = $all_cats[$crow['category_id']];
        if( $crow['company_id'] == $company_id ) $row[$_make_cathdr($crow['category_id'])] = 1;
      }
    }

    // now output the company record.
    $tmp = array('C');
    foreach( $company_fields as $fn ) {
      $str = '';
      if( isset($row[$fn]) ) $str = process_field($row[$fn],$delim);
      $tmp[] = $str;
    }
    $line = implode($delim,$tmp)."\n";
    $csv_output .= $line;

    $dbr->MoveNext();
  }

  // 4.4.4 - now get the next batch
  $offset += $dbr->RecordCount();
}


//Hack to make sure all of the CMS buffers are off
audit('',$this->GetName(),'Exported company data to csv');
$handlers = ob_list_handlers();
for ($cnt = 0; $cnt < sizeof($handlers); $cnt++) { ob_end_clean(); }
//Then force the output normally and exit so we don't get a footer
header("Content-disposition: attachment; filename=company_directory." . date("Y-m-d") . ".csv");
header("Content-type: text/csv");
print $csv_output;

exit;

?>