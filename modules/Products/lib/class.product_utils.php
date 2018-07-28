<?php
#BEGIN_LICENSE
#-------------------------------------------------------------------------
# Module: Products (c) 2008-2014 by Robert Campbell
#         (calguy1000@cmsmadesimple.org)
#  An addon module for CMS Made Simple to allow users to create, manage
#  and display products in a variety of ways.
#
#-------------------------------------------------------------------------
# CMS - CMS Made Simple is (c) 2005 by Ted Kulp (wishy@cmsmadesimple.org)
# Visit the CMSMS Homepage at: http://www.cmsmadesimple.org
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

final class product_utils
{
  protected function __construct() {}
  private static $_category_cache;
  static private $_flddef_cache;
  
  /*ImportSEO*/
  public static function get_importseo_status($alias) {
        $db = cmsms()->GetDb();
        $res = array();
        if ($alias) {
            $gSEO = $db->GetRow('SELECT item_id FROM ' . cms_db_prefix() . 'module_liseseo_item WHERE title="' . $alias . '"');
            $seo_id = ($gSEO) ? $gSEO["item_id"] : "";
            if (!$seo_id) {
                $res["status"] = 1;
            } else {
                $gTitle = $db->GetRow('SELECT value FROM ' . cms_db_prefix() . 'module_liseseo_fieldval WHERE fielddef_id in (1,2,3,4,5) and item_id =' . $seo_id);
                $seoValue = ($gTitle) ? $gTitle["value"] : "";
                if ($seoValue) {
                    $res["status"] = 2;
                } else {
                    $res["status"] = 0;
                }
            }
        }
        $res["item_id"] = $seo_id;
        return $res;
    }
    /*End ImportSEO*/
    static public function get_feu_ownerlist()
  {
      // list of users that can be owners to a product.
      $feu = \cms_utils::get_module('FrontEndUsers');
      if( !$feu ) return;

      $mod = \cms_utils::get_module(MOD_PRODUCTS);
      $gid = (int) $mod->GetPreference('feu_ownergroup');
      if( $gid < 1 ) return;

      $out = [ '' => $mod->Lang('none') ];
      $qry = new \feu_user_query();
      $qry->add_and_opt(feu_user_query_opt::MATCH_GROUPID,$gid);
      $qry->add_and_opt(\feu_user_query_OPT::MATCH_NOTEXPIRED);
      $qry->set_sortby(\feu_user_query::RESULT_SORTBY_USERNAME);
      $qry->set_sortorder(\feu_user_query::RESULT_SORTORDER_ASC);
      $rs = $qry->execute();
      while( !$rs->EOF ) {
          $row = $rs->fields;
          $out[$row['id']] = $row['username'];
          $rs->MoveNext();
      }
      return $out;
  }

  static public function get_field_types($selectone = false)
  {
      $mod = cge_utils::get_module(MOD_PRODUCTS);
      $items = array();
      if( $selectone ) $items[$mod->Lang('select_one')] = '';
      $items[$mod->Lang('textbox')] = 'textbox';
      $items[$mod->Lang('checkbox')] = 'checkbox';
      $items[$mod->Lang('textarea')] = 'textarea';
      $items[$mod->Lang('dropdown')] = 'dropdown';
      $items[$mod->Lang('image_upload')] = 'image';
      $items[$mod->Lang('file_upload')] = 'file';
      $items[$mod->Lang('file_link')] = 'filelink';
      $items[$mod->Lang('dimensions')] = 'dimensions';
      $items[$mod->Lang('subscription')] = 'subscription';
      $items[$mod->Lang('quantity_on_hand')] = 'quantity';
      $cdmod = cms_utils::get_module('CompanyDirectory','1.19');
      if( is_object($cdmod) ) $items[$mod->Lang('companydir_reference')] = 'companydir';
      return array_flip($items);
  }


  public static function get_displayable_fieldval($fieldname,$fieldval)
  {
      $mod = cge_utils::get_module(MOD_PRODUCTS);
      $fields = product_ops::get_fields();
      $fields = cge_array::to_hash($fields,'name');
      $fieldtype = $fields[$fieldname]['type'];
      $res = $fieldval;
      switch( $fieldtype ) {
      case 'checkbox':
          if( !is_null($res) ) $res = $mod->Lang('prompt_'.$res);
          break;
      case 'textarea':
          $res = '';
          break;
      case 'filelink':
      case 'dropdown':
      case 'image':
      case 'file':
          break;
      case 'dimensions':
      {
          if( is_string($res) ) $res = unserialize($res);
          if( is_array($res) && $res['length'] > 0 && $res['width'] > 0 && $res['height'] > 0 ) {
              $res = sprintf('%s: %d, %s: %d, %s: %d',
                             $mod->Lang('abbr_length'),$res['length'],
                             $mod->Lang('abbr_width'),$res['width'],
                             $mod->Lang('abbr_height'),$res['height']);
          }
          else {
              $res = $mod->Lang('none');
          }
      }
      break;
      case 'subscription':
      {
          if( is_array($res) && $res['payperiod'] != -1 && $res['delperiod'] != -1 ) {
              $subscribe_opts = array();
              $subscribe_opts[-1] = $mod->Lang('none');
              $subscribe_opts['monthly'] = $mod->Lang('subscr_monthly');
              $subscribe_opts['quarterly'] = $mod->Lang('subscr_quarterly');
              $subscribe_opts['semianually'] = $mod->Lang('subscr_semianually');
              $subscribe_opts['yearly'] = $mod->Lang('subscr_yearly');

              $expire_opts = array();
              $expire_opts[$mod->Lang('none')] = -1;
              $expire_opts[$mod->Lang('expire_six_month')] = '6';
              $expire_opts[$mod->Lang('expire_one_year')] = '12';
              $expire_opts[$mod->Lang('expire_two_year')] = '24';
              $expire_opts = array_flip($expire_opts);

              $expiry = 'none';
              if( $fieldval['expire'] != -1 ) $expiry = $fieldval['expire'];
              $res = sprintf('%s: %s, %s: %s, %s: %s',
                             $mod->Lang('subscr_payperiod2'),$fieldval['payperiod'],
                             $mod->Lang('subscr_delperiod2'),$fieldval['delperiod'],
                             $mod->Lang('subscr_expiry2'),$expiry);
          }
          else {
              $res = $mod->Lang('none');
          }
      }
      break;
      }

      return $res;
  }


  static public function hierarchy_isparentof( $a, $b )
  {
      // test if $a is a parent of $b (by id)
      $a = (int) $a;
      $b = (int) $b;
      if( $a == $b ) return true;

      function __find( $list, $id ) {
          foreach( $list as $rec ) {
              if( $rec['id'] == $id ) return $rec;
          }
      }

      $tmp = hierarchy_ops::get_flat_list(FALSE);
      // find node b, go up tree till either at top (false) or found $a (true)
      while( $b > 0 ) {
          $node = __find( $tmp, $a );
          if( !$node ) throw new \LogicException('Could not find hierarchy item with id '.$b);
          if( $node['parent_id'] == $b ) return TRUE;
          if( $node['parent_id'] < 1 ) return;
          $b = $node['parent_id'];
      }
  }

  static public function hierarchy_get_tree($parent_id = -1,$showall = 0,$callback_fn = '')
  {
      $hierarchy_map = hierarchy_ops::get_all_hierarchy_info(TRUE,$showall);
      if( !is_array($hierarchy_map) || count($hierarchy_map) == 0 ) return FALSE;

      $out = array();
      foreach( $hierarchy_map as $onehier ) {
          if( $onehier['parent_id'] != $parent_id ) continue;
          if( $callback_fn != '' && function_exists($callback_fn) ) $callback_fn($onehier);
          $tmp = self::hierarchy_get_tree($onehier['id'],$showall,$callback_fn);
          if( is_array($tmp) && count($tmp) ) $onehier['children'] = $tmp;
          $out[] = $onehier;
      }
      return $out;
  }


  public static function update_hierarchy_positions()
  {
      $db = cmsms()->GetDb();

      $query = "SELECT id, item_order, name FROM ".cms_db_prefix()."module_products_hierarchy";
      $dbresult = $db->Execute($query);
      if( !$dbresult ) { echo $db->sql.'<br/>'; die( $db->ErrorMsg() ); }
      while ($dbresult && $row = $dbresult->FetchRow()) {
          $current_hierarchy_position = "";
          $current_long_name = "";
          $content_id = $row['id'];
          $current_parent_id = $row['id'];
          $count = 0;

          while ($current_parent_id > -1) {
              $query = "SELECT id, item_order, name, parent_id FROM ".cms_db_prefix()."module_products_hierarchy WHERE id = ?";
              $row2 = $db->GetRow($query, array($current_parent_id));
              if ($row2) {
                  $current_hierarchy_position = str_pad($row2['item_order'], 5, '0', STR_PAD_LEFT) . "." . $current_hierarchy_position;
                  $current_long_name = $row2['name'] . ' | ' . $current_long_name;
                  $current_parent_id = $row2['parent_id'];
                  $count++;
              }
              else {
                  $current_parent_id = 0;
              }
          }

          if (strlen($current_hierarchy_position) > 0) {
              $current_hierarchy_position = substr($current_hierarchy_position, 0, strlen($current_hierarchy_position) - 1);
          }

          if (strlen($current_long_name) > 0) $current_long_name = substr($current_long_name, 0, strlen($current_long_name) - 3);

          $query = "UPDATE ".cms_db_prefix()."module_products_hierarchy SET hierarchy = ?, long_name = ? WHERE id = ?";
          $db->Execute($query, array($current_hierarchy_position, $current_long_name, $content_id));
      }
  }


  public static function hierarchy_save_tree($tree,$depth = 0,$update_hierarchy = TRUE)
  {
      $query = 'UPDATE '.cms_db_prefix().'module_products_hierarchy SET parent_id = ?, item_order = ? WHERE id = ?';
      $db = cmsms()->GetDb();
      foreach( $tree as &$node ) {
          $dbr = $db->Execute($query,array($node['parent_id'],$node['item_order'],$node['id']));
          if( isset($node['children']) ) self::hierarchy_save_tree($node['children'],$depth+1);
      }

      if( $depth == 0 && $update_hierarchy ) self::update_hierarchy_positions();
  }


  public static function get_categories($by_name = FALSE)
  {
      // topdo: replace this with CategoryStorage class method returning array of category objects.
      if( is_null(self::$_category_cache) ) {
          $db = cmsms()->GetDb();
          $query = 'SELECT * FROM '.cms_db_prefix().'module_products_categories ORDER BY name ASC';
          $tmp = $db->GetArray($query);
          self::$_category_cache = FALSE;
          if( is_array($tmp) && count($tmp) ) {
              self::$_category_cache = array();
              foreach( $tmp as $row ) {
                  $row = cge_array::to_object($row);
                  self::$_category_cache[$row->id] = $row;
              }
          }
      }

      if( !$by_name ) return self::$_category_cache;

      if( is_array(self::$_category_cache) ) {
          $out = array();
          foreach( self::$_category_cache as $row ) {
              $out[$row->name] = $row;
          }
          return $out;
      }
  }

  public static function get_category_list()
  {
      $all = self::get_categories();
      if( !$all ) return;

      $out = [];
      foreach( $all as $one ) {
          $out[$one->id] = $one->name;
      }
      return $out;
  }

  public static function get_full_categories($by_name = FALSE)
  {
      $categories = self::get_categories();
      if( !is_array($categories) || count($categories) == 0 ) return;

      $keys = array_keys($categories);
      $fid = $keys[0]; // first field.
      if( !isset(self::$_category_cache[$fid]->data) ) {
          // we're gonna use the same cache again...
          $db = cmsms()->GetDb();
          $mod = cms_utils::get_module(MOD_PRODUCTS);
          $config = cmsms()->GetConfig();
          $query = 'SELECT * FROM '.cms_db_prefix().'module_products_category_fields ORDER BY category_id,field_order';
          $dbr = $db->GetArray($query);
          foreach( $keys as $one ) {
              $cat =& self::$_category_cache[$one];
              if( !isset($cat->data) ) $cat->data = array();
              $cat->file_location = self::get_category_upload_url($cat->id);
              for( $i = 0; $i < count($dbr); $i++ ) {
                  //$catid = $dbr[$i]['category_id'];
                  if( $cat->id == $dbr[$i]['category_id'] )  $cat->data[] = $dbr[$i];
              }
          }
      }

      if( !$by_name ) return self::$_category_cache;

      if( is_array(self::$_category_cache) ) {
          $out = array();
          foreach( self::$_category_cache as $row ) {
              $out[$row->name] = $row;
          }
          return $out;
      }
  }

  static public function get_fielddefs($admin = false,$public = true,$as_hash = FALSE)
  {
      if( !is_array(self::$_flddef_cache) ) {
          $entryarray = array();
          $db = cmsms()->GetDB();

          if( $admin == true && $public == true ) {
              $query = 'SELECT * FROM '.cms_db_prefix().'module_products_fielddefs ORDER BY item_order';
          }
          else if( $public == true ) {
              $query = 'SELECT * FROM '.cms_db_prefix().'module_products_fielddefs WHERE public > 0 ORDER BY item_order';
          }
          else {
              $query = 'SELECT * FROM '.cms_db_prefix().'module_products_fielddefs WHERE admin_only <= 0 ORDER BY item_order';
          }
          $dbresult = $db->GetArray($query);

          if( is_array($dbresult) ) {
              foreach( $dbresult as $row ) {
                  $onerow = new stdClass();

                  $onerow->public = (bool) $row['public'];
                  $onerow->id = $row['id'];
                  $onerow->name = $row['name'];
                  $onerow->prompt = $row['prompt'];
                  $onerow->type = $row['type'];
                  $tmp = explode("\n",$row['options']);
                  $tmp2 = array();
                  foreach( $tmp as $one ) {
                      $key = $value = $one = trim($one);
                      if( !$one ) continue;
                      if( strpos($one,'|') !== FALSE ) {
                          list($key,$value) = explode('|',$one);
                          $key = trim($key);
                          $value = trim($value);
                      }
                      $tmp2[$key] = $value;
                  }
                  $onerow->options = array_flip($tmp2);
                  $onerow->max_length = $row['max_length'];

                  $entryarray[$onerow->id] = $onerow;
              }
          }
          self::$_flddef_cache = $entryarray;
      }

      if( !$as_hash ) return self::$_flddef_cache;

      $out = array();
      foreach( self::$_flddef_cache as $one ) {
          $out[$one->name] = $one;
      }
      return $out;
  }

  public static function get_quantity_field()
  {
      $defs = self::get_fielddefs(TRUE,TRUE);
      if( !count($defs) ) return;
      foreach( $defs as $def ) {
          if( $def->type == 'quantity' ) return $def;
      }
  }

  public static function have_quantity_field()
  {
      $out = self::get_quantity_field();
      if( $out ) return TRUE;
      return FALSE;
  }

  public static function can_do_pretty($action,$params) {
      if( !isset($params['notpretty']) ) return TRUE;
      if( strpos($params['notpretty'],'all') !== FALSE || strpos($params['notpretty'],$action) !== FALSE ) return FALSE;
      return TRUE;
  }

  public static function get_base_upload_path()
  {
      $mod = \cms_utils::get_module(MOD_PRODUCTS);
      $prefix = $mod->GetPreference('upload_dir','_products');
      $config = cmsms()->GetConfig();
      $path = cms_join_path($config['uploads_path'],$prefix);
      return $path;
  }

  public static function get_base_upload_url()
  {
      $mod = \cms_utils::get_module(MOD_PRODUCTS);
      $prefix = $mod->GetPreference('upload_dir',$mod->GetName());
      $config = cmsms()->GetConfig();
      $url = $config['uploads_url']."/$prefix";
      return $url;
  }

  public static function get_product_upload_path($product_id = null)
  {
      $product_id = (int) $product_id;
      $path = self::get_base_upload_path();
      if( $product_id > 0 ) $path = cms_join_path($path,'product_'.$product_id);
      return $path;
  }

  public static function get_product_upload_url($product_id = null)
  {
      $product_id = (int) $product_id;
      $url = self::get_base_upload_url();
      if( $product_id > 0 ) $url .= '/product_'.$product_id;
      return $url;
  }

  public static function get_hierarchy_upload_path()
  {
      $path = self::get_base_upload_path();
      return cms_join_path($path,'hierarchy');
  }

  public static function get_hierarchy_upload_url()
  {
      $path = self::get_base_upload_url();
      return "$path/hierarchy";
  }

  public static function get_category_upload_path($category_id = null)
  {
      $category_id = (int) $category_id;
      $path = self::get_base_upload_path();
      $path = cms_join_path($path,'categories');
      if( $category_id > 0 ) $path = cms_join_path($path,$category_id);
      return $path;
  }

  public static function get_category_upload_url($category_id = null)
  {
      $category_id = (int) $category_id;
      $path = self::get_base_upload_url();
      $path = "$path/categories";
      if( $category_id > 0 ) $path = "$path/$category_id";
      return $path;
  }

  public static function product_to_ecomm_productinfo( \Products\DisplayableProduct $product )
  {
      $out = new \cg_ecomm_productinfo();
      $out->set_source('Products');
      $out->set_type($out::TYPE_PRODUCT);
      if( $product->is_service ) $out->set_type($out::TYPE_SERVICE);
      $out->set_product_id($product->id);
      $out->set_name($product->name);
      $out->set_sku($product->sku);
      $out->set_price($product->price); // will use derived class' method and take into account any adjuster.
      $out->set_taxable($product->taxable);
      $out->set_digital($product->digital);
      $out->set_weight($product->weight);
      if( count($product->attribs) ) {
          foreach( $product->attribs as $attrib ) {
              $opt = new \cg_ecomm_productinfo_option();
              $opt->id = $attrib->id;
              $opt->text = $attrib->text;
              $opt->sku = $attrib->sku;
              $opt->adjustment = $attrib->adjustment;
              $opt->qoh = $attrib->qoh;
              $out->add_option( $opt );
          }
      }
      if( count($product->field_vals) ) {
          $alldefs = \product_utils::get_fielddefs(TRUE);
          if( count($alldefs && count($product->field_vals)) ) {
              foreach( $product->field_vals as $fid => $val ) {
                  if( !isset($alldefs[$fid]) ) continue;
                  $def = $alldefs[$fid];

                  switch( $def->type ) {
                  case 'quantity':
                      $out->set_qoh( (int) $val );
                      break;

                  case 'dimensions':
                      if( !is_array($val) ) $val = unserialize($val);
                      $out->set_dimensions($val['length'],$val['width'],$val['height']);
                      break;

                  case 'subscription':
                      $subscr = new \cg_ecomm_productinfo_subscription();
                      $subscr->set_payperiod( $val['payperiod'] );
                      $subscr->set_deliveryperiod( $val['delperiod'] );
                      $subscr->set_expiry( $val['expire'] );
                      $out->set_subscription( $subscr );
                      break;
                  }
              }
          }
      }
      return $out;
  }

  static public function make_alias( $string )
  {
      $string = munge_string_to_url($string);
      $string = trim($string, '_');
      return strtolower($string);
  }

} // product utils

#
# EOF
#
