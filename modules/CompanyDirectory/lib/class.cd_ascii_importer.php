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

class cd_ascii_importer
{
  private $_errors;
  private $_delimiter;
  private $_enclosure;
  private $_mod;
  private $_do_fielddefs;
  private $_do_fieldvals;
  private $_do_categorydefs;
  private $_do_categoryvals;
  private $_do_latlong_lookup;
  private $_create_url = 0;
  private $_check_duplicate_companies;
  private $_max_records;
  private $_do_hierdefs;
  private $_do_hiervals;
  private $_the_user;

  private $_num_companies;
  private $_num_hier;
  private $_num_categories;
  private $_num_fielddefs;
  private $_num_lines;
  private $_linenum = 0;

  private $_hier_cache;
  private $_fielddef_cache;
  private $_category_cache;
  private $_rules = array();

  public function __construct(&$mod,$delimiter = '|',$enclosure = '"')
  {
    $this->_errors = array();

    $this->_do_fielddefs = 0;
    $this->_do_fieldvals = 0;
    $this->_the_user = -1;

    $this->_do_categorydefs = 0;
    $this->_do_categoryvals = 0;

    $this->_do_hierdefs = 0;
    $this->_do_hiervals = 0;

    $this->_do_latlong_lookup = 0;
    $this->_check_duplicate_companies = 'error';
    $this->_mod =& $mod;
    $this->_delimiter = $delimiter;
    $this->_enclosure = $enclosure;
    $this->_max_records = 0;

    $this->_num_companies = 0;
    $this->_num_categories = 0;
    $this->_num_fielddefs = 0;
    $this->_num_hier = 0;
    $this->_num_lines = 0;
  }

  public function get_results()
  {
    return array('num_companies'=>$this->_num_companies,
		 'num_categories'=>$this->_num_categories,
		 'num_fielddefs'=>$this->_num_fielddefs,
		 'num_hier'=>$this->_num_hier,
		 'num_lines'=>$this->_num_lines);
  }

  public function set_user($uid)
  {
    $this->_the_user = $uid;
  }

  public function set_delimiter($char)
  {
    $this->_delimiter = $char;
  }

  public function set_enclosure($char)
  {
    $this->_enclosure = $char;
  }

  public function set_max_companies($num)
  {
    $this->_max_records = $num;
  }

  public function do_fielddefs($flag = true)
  {
    $this->_do_fielddefs = $flag;
  }

  public function do_fieldvals($flag = true)
  {
    $this->_do_fieldvals = $flag;
  }

  public function do_categorydefs($flag = true)
  {
    $this->_do_categorydefs = $flag;
  }

  public function do_categoryvals($flag = true)
  {
    $this->_do_categoryvals = $flag;
  }

  public function do_latlong_lookup($flag = true )
  {
    $this->_do_latlong_lookup = $flag;
  }

  public function create_url($flag = true)
  {
	$this->_create_url = $flag;
  }

  public function check_duplicate_companies($flag = true)
  {
	$tmp = strtolower($flag);
	switch( $tmp ) {
	case 'error':
	  // generate an error on duplicate companies
	case 'insert':
      // insert it anyways
	case 'ignore':
	  // just ignore the whole record, silently
	case 'update':
	  // update the company.
	  $this->_check_duplicate_companies = $tmp;
	  break;
	}
  }

  public function do_hierarchyvals($flag = true)
  {
    $this->_do_hiervals = $flag;
  }

  public function do_hierarchydefs($flag = true)
  {
    $this->_do_hierdefs = $flag;
  }

  protected function set_error($msg)
  {
    $str = $this->_mod->Lang('error_prefix_msg',$this->_linenum,$msg);
    $this->_errors[] = $str;
  }

  public function get_errors()
  {
    return $this->_errors;
  }

  public function clear_errors()
  {
    $this->_errors = array();
  }

  protected function get_fielddef_id($name)
  {
    if( !is_array($this->_fielddef_cache) ) {
      $this->_fielddef_cache = array();
      $tmp = cd_utils::get_fielddefs(TRUE,TRUE);
	  if( is_array($tmp) ) $this->_fielddef_cache = cge_array::to_hash($tmp,'name');
	}

    if( isset($this->_fielddef_cache[$name]) ) return $this->_fielddef_cache[$name]['id'];
  }


  private function _insert_fielddef($fields)
  {
    $db = cmsms()->GetDb();

    // insert that record
    if( !isset($fields['name']) ) return;
    if( !isset($fields['type']) ) $fields['type'] = 'textbox';
    if( !isset($fields['max_length']) ) $fields['max_length'] = 255;
    if( !isset($fields['admin_only']) ) $fields['admin_only'] = 0;
    if( !isset($fields['public']) ) $fields['public'] = 1;
    if( !isset($fields['dropdown_data']) ) $fields['dropdown_data'] = null;
    if( !isset($fields['data']) ) $fields['data'] = null;

    $db = cmsms()->GetDb();
    $item_order = $db->GetOne('SELECT COALESCE(max(item_order),0) + 1 FROM ' . cms_db_prefix() . 'module_compdir_fielddefs');
    $query = "INSERT INTO ".cms_db_prefix()."module_compdir_fielddefs
              (name, type, max_length, admin_only, public, item_order, dropdown_data, data, create_date, modified_date)
              VALUES (?,?,?,?,?,?,?,?,NOW(),NOW())";
    $dbr = $db->Execute($query,array(
                          $fields['name'],$fields['type'],$fields['max_length'],$fields['admin_only'],$fields['public'],$item_order,$fields['dropdown_data'],$fields['data']));
    if( !$dbr ) throw new CmsException('SQL Error '.$db->sql.' -- '.$db->ErrorMsg());
    $fd_id = $db->Insert_ID();

    $this->_fielddef_cache[$fields['name']]['id'] = $fd_id;
    $this->_num_fielddefs++;
    return $fd_id;
  }

  protected function get_hier_id($long_name)
  {
    if( !$long_name ) return FALSE;
    $db = cmsms()->GetDb();

    if( !is_array($this->_hier_cache) ) {
      $this->_hier_cache = array();
      $tmp = cd_utils::get_hierarchy();
      if( is_array($tmp) ) $this->_hier_cache = cge_array::to_hash($tmp,'long_name');
    }

    if( isset($this->_hier_cache[$long_name]) ) return $this->_hier_cache[$long_name]['id'];
  }


  private function _insert_hier($record)
  {
    if( !isset($record['long_name']) ) return;
    $long_name = $record['long_name'];
    if( empty($long_name) ) return;

    $parts = explode(' | ',$long_name);
    $shorter = implode(' | ',array_slice($parts,0,count($parts)-1));
    $name = $parts[count($parts)-1];
    $parent_id = -1;
    if( $shorter ) {
      $parent_id = $this->get_hier_id($shorter);
      if( !$parent_id ) {
        // parent not found... gotta insert that too.
        // means recursion.
        $rec = array();
        $rec['long_name'] = $shorter;
        $this->_insert_hier($rec);
      }
    }

    // we have a parent id, and a long name... and maybe some extra data
    // we are clear to insert
    $record['parent_id'] = $parent_id;
    $record['name'] = $name;
    $db = cmsms()->GetDb();
    $query = 'SELECT COALESCE(MAX(iorder),0) + 1 FROM '.cms_db_prefix().'module_compdir_hier WHERE parent_id = ?';
    $iorder = $db->GetOne($query,array($parent_id));
    $record['iorder'] = $iorder;

    $query = 'INSERT INTO '.cms_db_prefix().'module_compdir_hier (name,parent_id,iorder,long_name) VALUES (?,?,?,?)';
    $dbr = $db->Execute($query,array($record['name'],$record['parent_id'],$iorder,$record['long_name']));
    $new_id = $db->Insert_ID();
    $record['id'] = $new_id;
    $this->_num_hier++;

    // add it to the cache
    $this->_hier_cache[$long_name] = $record;

    // return nothing
  }


  protected function get_category_id($long_name)
  {
    $db = cmsms()->GetDb();

    if( !is_array($this->_category_cache) ) {
      $tmp = cd_utils::get_categories(TRUE);
      $this->_category_cache = array();
      if( is_array($tmp) && count($tmp) ) {
        foreach( $tmp as $rec ) {
          $this->_category_cache[$rec->long_name] = $rec;
        }
      }
	}

    if( isset($this->_category_cache[$long_name]) ) {
      if( is_array($this->_category_cache[$long_name]) ) return $this->_category_cache[$long_name]['id'];
      return $this->_category_cache[$long_name]->id;
    }
  }

  private function _insert_category($record)
  {
    if( !isset($record['long_name']) ) return;
    $long_name = $record['long_name'];
    if( empty($long_name) ) return;

    // get this records parent id
    $parts = explode(' | ',$long_name);
    $shorter = implode(' | ',array_slice($parts,0,count($parts)-1));
    $name = $parts[count($parts)-1];
    $parent_id = -1;
    if( $shorter ) {
      $parent_id = $this->get_category_id($shorter);
      if( !$parent_id ) {
        // parent not found... gotta insert that too.
        // means recursion.
        $rec = array();
        $rec['long_name'] = $shorter;
        $this->_insert_category($rec);
      }
    }

    // we have a parent id, and a long name... and maybe some extra data
    // we are clear to insert
    if( !isset($record['extra1']) ) $record['extra1'] = null;
    if( !isset($record['extra2']) ) $record['extra2'] = null;
    if( !isset($record['extra3']) ) $record['extra3'] = null;
    $record['parent_id'] = $parent_id;
    $record['name'] = $name;
    // we have an id we can use it as a parent id
    $db = cmsms()->GetDb();
    $query = 'SELECT COALESCE(MAX(item_order),0) + 1 FROM '.cms_db_prefix().'module_compdir_categories WHERE parent_id = ?';
    $item_order = $db->GetOne($query,array($parent_id));

    $query = 'INSERT INTO '.cms_db_prefix().'module_compdir_categories (name,parent_id,item_order,long_name,extra1,extra2,extra3) VALUES (?,?,?,?,?,?,?)';
    $dbr = $db->Execute($query,array($record['name'],$record['parent_id'],$item_order,$record['long_name'],$record['extra1'],$record['extra2'],$record['extra3']));
    $new_id = $db->Insert_ID();
    $this->_num_categories++;

    // now insert it into the cache
    $this->_category_cache[$long_name] = array('id'=>$new_id,'name'=>$name,'parent_id'=>$parent_id,'item_order'=>$item_order,'long_name'=>$long_name);

    // return nothing,
  }

  private function unprocess_data($data)
  {
    // strip quotes
    $data = trim($data,'"');

    // newlines
    $data = str_replace("^^","\n",$data);
    $data = str_replace("-%%-",$this->_delimiter,$data);

    return $data;
  }


  private function process_fielddef($fields,$rule)
  {
    $db = cmsms()->GetDb();

    // build a new record
    $record = array();
    $record['dropdown_data'] = '';
    for( $fld = 1; $fld < count($rule['flds']); $fld++ ) {
	  if( !isset($fields[$fld]) ) continue;
	  $fname = $rule['flds'][$fld];
	  $record[$fname] = $this->unprocess_data($fields[$fld]);
	}

    // get the fielddef id, or try to create it
    $tmp = $this->get_fielddef_id($record['name']);
    if( !$tmp ) $this->_insert_fielddef($record);
    return TRUE;
  }


  private function process_hierarchy($fields,$rule)
  {
    $db = cmsms()->GetDb();

    $record = array();
    for( $fld = 1; $fld < count($rule['flds']); $fld++ ) {
	  if( !isset($fields[$fld]) ) continue;
	  $fname = $rule['flds'][$fld];
	  $record[$fname] = $this->unprocess_data($fields[$fld]);
	}

    // if the hierarchy record (by long name) exists, we are golden
    // if it does not.... depending on settings, try to create it.
    $tmp = $this->get_hier_id($record['long_name']);
    if( !$tmp ) $this->_insert_hier($record);
    return TRUE;
  }


  private function process_category($fields,$rule)
  {
    $db = cmsms()->GetDb();

    // build a new record
    $record = array();
    for( $fld = 1; $fld < count($rule['flds']); $fld++ ) {
	  if( !isset($fields[$fld]) ) continue;
	  $fname = $rule['flds'][$fld];
	  $record[$fname] = $this->unprocess_data($fields[$fld]);
	}

    $tmp = $this->get_category_id($record['long_name'],TRUE);
    if( !$tmp ) $this->_insert_category($record);
    return TRUE;
  }


  private function process_company($fields,$rule)
  {
    $db = cmsms()->GetDb();
    $userid = $this->_the_user;

    $record = array();
    for( $fld = 1; $fld < count($rule['flds']); $fld++ ) {
	  if( !isset($fields[$fld]) ) continue;
	  $fname = $rule['flds'][$fld];
	  $record[$fname] = $this->unprocess_data($fields[$fld]);
	}

    // convert the 'hierarchy' field to a 'hier_id' field
    if( !$this->_do_hiervals ) $record['hier_id'] = null;
    if( !isset($record['hier_id']) && isset($record['hierarchy']) && $record['hierarchy'] ) {
      $hier_id = $this->get_hier_id($record['hierarchy']);
      if( !$hier_id && $this->_do_hierdefs ) {
        $rec = array('long_name'=>$record['hierarchy']);
      }
      $hier_id = $this->get_hier_id($record['hierarchy']);
      $record['hier_id'] = $hier_id;
      unset($record['hierarchy']);
    }
    if( !isset($record['hier_id']) ) $record['hier_id'] = null;

    // convert the 'CAT:' members with strings containing long_names to cat_## members with integers
    // if ignoring category values do nothing
    // also creates categories if needed (so that we can get the integer id)
    if( !$this->_do_categoryvals ) {
      // ignoring category stuff all-together
      foreach( $record as $key => $value ) {
        if( startswith($key,'CAT:') ) unset($record[$key]);
      }
    }
    if( $this->_do_categorydefs ) {
      // we are inserting missing category definitions
      foreach( $record as $okey => $value ) {
        if( startswith($okey,'CAT:') ) {
          $key = trim(substr($okey,4));
          $cat_id = $this->get_category_id($key);
          if( !$cat_id ) {
            $rec['long_name'] = $key;
            $this->_insert_category($rec);
          }
          $cat_id = $this->get_category_id($key);
          if( $cat_id ) $record['cat_'.$cat_id] = $value;
          unset($record[$okey]);
        }
      }
    }

    // data validation
    if( !isset($record['company_name']) || empty($record['company_name']) ) {
	  $this->set_error($this->_mod->Lang('error_import_badvalue','company_name'));
	  return FALSE;
	}

    // do optional lat/long lookup
    if( $this->_do_latlong_lookup ) {
	  if( empty($record['latitude']) || empty($record['longitude']) &&
		  !empty($record['address']) ) {
		$data = cd_utils::geolocate($record['address']);
		if( $data && $data['lat'] != 0 && $data['lon'] != 0 ) {
		  $record['latitude'] = $data['lat'];
		  $record['longitude'] = $data['lon'];
		}
	  }
	}

	// handle url
	if( $record['url'] == '' && $this->_create_url ) {
	  $record['url'] = cd_utils::generate_url($record['company_name']);
	}
	if( $record['url'] != '' ) {
	  while( !cd_utils::validate_url($record['url'],TRUE) ) {
		$record['url'] = cd_utils::generate_url($record['company_name']);
	  }
	}

    // check for duplicate?
	$query = 'SELECT id FROM '.cms_db_prefix().'module_compdir_companies WHERE company_name = ?';
	$eid = $db->GetOne($query,array($record['company_name']));
	if( $eid ) {
	  switch( $this->_check_duplicate_companies ) {
	  case 'error':
		$this->set_error($this->_mod->Lang('error_duplicate_company',$record['company_name']));
		return FALSE;
	  case 'ignore':
		return FALSE;
      case 'insert':
        // we're inserting anyways.
        $eid = null;
	  case 'update':
		// overwriting... keep going.
		break;
	  }
	}

    // insert that record
    $now = $db->DbTimeStamp(time());
	$dbr = TRUE;
	if( $eid ) {
	  $query = 'UPDATE '.cms_db_prefix()."module_compdir_companies
                SET url = ?, address = ?, telephone = ?, fax = ?, contact_email = ?,
                    website = ?, details = ?, status = ?, latitude = ?,
                    longitude = ?, owner_id = ?, hier_id = ?, modified_date = ? WHERE id = ?";
	  $dbr = $db->Execute($query,
						  array($record['url'],$record['address'],$record['telephone'],
								$record['fax'],$record['contact_email'],$record['website'],
								$record['details'],$record['status'],
								$record['latitude'],$record['longitude'],
								$userid,$record['hier_id'],$now,$eid));

	  if( !$dbr ) {
		$this->set_error($this->_mod->Lang('error_update_company'));
		return FALSE;
	  }

	  $query = 'DELETE FROM '.cms_db_prefix().'module_compdir_fieldvals WHERE company_id = ?';
	  $dbr = $db->Execute($query,array($eid));

	  $query = 'DELETE FROM '.cms_db_prefix().'module_compdir_company_categories WHERE company_id = ?';
	  $dbr = $db->Execute($query,array($eid));

	  $company_id = $eid;
      $this->_num_companies++;
	}
	else {
	  $query =  "INSERT INTO ".cms_db_prefix()."module_compdir_companies
                 (company_name,url,address,telephone,fax,contact_email,website,details,status,
                  latitude,longitude,owner_id, hier_id,create_date, modified_date)
                 VALUES (?,?,?,?,?,?,?,?,?,?,?,?,?,$now,$now)";
	  $dbr = $db->Execute($query,array($record['company_name'],$record['url'],$record['address'],
									   $record['telephone'],$record['fax'],
									   $record['contact_email'],$record['website'],
									   $record['details'],$record['status'],
									   $record['latitude'],$record['longitude'],
									   $userid,$record['hier_id']));
	  if( !$dbr ) {
		$this->set_error($this->_mod->Lang('error_insert_company'));
		return FALSE;
	  }
	  $company_id = $db->Insert_ID();
      $this->_num_companies++;
	}

	// insert fieldvals
    if( $this->_do_fieldvals ) {
      foreach( $record as $okey => $value ) {
        $prefix = 'FIELD:';
        if( !startswith($okey,$prefix) ) continue;
        $fld_name = trim(substr($okey,strlen($prefix)));
        if( !$fld_name || empty($value) ) continue;
        $fld_id = $this->get_fielddef_id($fld_name);
        if( !$fld_id && $this->_do_fielddefs ) {
          $rec = array('name'=>$fld_name);
          $this->_insert_fielddef($rec);
        }
        $fld_id = $this->get_fielddef_id($fld_name);
        if( !$fld_id ) continue;

        // insert the field value.
        $query = 'INSERT INTO '.cms_db_prefix()."module_compdir_fieldvals
                  (company_id, fielddef_id, value, create_date, modified_date)
                  VALUES (?,?,?,$now,$now)";
        $dbr = $db->Execute($query,array($company_id,$fld_id,$value));
      }
    }

	// insert categories
    if( $this->_do_categoryvals ) {
      $prefix = 'cat_';
      foreach( $record as $key => $value ) {
        if( !startswith($key,$prefix) ) continue;
        if( !$value ) continue;
        $cat_id = (int)substr($key,strlen($prefix));
        if( $cat_id < 1 ) continue;

		$query = 'INSERT INTO '.cms_db_prefix()."module_compdir_company_categories
                  (company_id,category_id,create_date,modified_date)
                  VALUES (?,?,NOW(),NOW())";
		$db->Execute($query,array($company_id,$cat_id));
      }
	}

    return TRUE;
  }

  private function _handle_header($fields)
  {
    if( !startswith( $fields[0], '#') ) continue;

    $parts = explode('=',$fields[0]);
    $type = trim(substr($parts[0],1));
    $identifier = trim($parts[1]);
    if( !isset($this->_rules[$identifier]) ) {
      $this->_rules[$identifier] = array('type'=>$type,'identifier'=>$identifier,'flds'=>$fields);
    }
    return;
  }

  private function _process_record($fields)
  {
    $identifier = trim($fields[0]);
    if( !isset($this->_rules[$identifier]) ) {
      $this->set_error($this->_mod->Lang('error_import_unknownrow',$this->_linenum,$fields[0]));
      return;
    }

    $handler = strtolower('process_'.$this->_rules[$identifier]['type']);
    if( !method_exists($this,$handler) ) {
      $this->set_error($this->_mod->Lang('error_import_nohandler',$this->_linenum,$fields[0]));
    }

    return $this->$handler($fields,$this->_rules[$identifier]);
  }

  public function import_file($filename)
  {
    $this->_linenum = 0;
    $orig_line_endings = ini_get('auto_detect_line_endings');
    ini_set('auto_detect_line_endings',TRUE);

    $fh = fopen($filename,'r');
    if( !$fh ) {
	  $this->set_error($this->_mod->Lang('error_badupload'));
	  return FALSE;
	}

    try {
      while( !feof($fh) ) {
          $fields = fgetcsv($fh,0,$this->_delimiter,$this->_enclosure);
        $this->_linenum++;

        // skip empty lines
        if( !is_array($fields) || count($fields) == 0 || $fields[0] == '' ) continue;

        if( startswith($fields[0],'#') ) {
          $this->_handle_header($fields);
          continue;
        }

        // find the row type
        $this->_process_record($fields);
      }

      $this->_num_lines = $this->_linenum;
      fclose($fh);

      if( $this->_num_hier ) cd_utils::update_hierarchy_positions();
      if( $this->_num_categories ) cd_category::calculate_hierarchy_positions();
    }
    catch( Exception $e ) {
      ini_set('auto_detect_line_endings',$orig_line_endings);
      fclose($fh);
      return FALSE;
    }

    ini_set('auto_detect_line_endings',$orig_line_endings);
    return TRUE;
  }

}

#
# EOF
#
?>
