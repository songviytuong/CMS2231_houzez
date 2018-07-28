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

final class product_ops
{
    static private $_fielddefs;
    static private $_prodhier;

    private function __construct() {}

    static public function get_product($product_id,$anystatus = FALSE)
    {
        $mod = \cms_utils::get_module(MOD_PRODUCTS);
        $product = $mod->GetProductStorage()->get_by_id( $product_id, true );
        if( !$product ) return;
        if( !$anystatus && $product->status != $product::STATUS_PUBLISHED ) return;
        return $product;
    }

    static public function is_valid_category($name)
    {
        $db = cmsms()->GetDb();
        $query = 'SELECT id FROM '.cms_db_prefix().'module_products_categories WHERE name = ?';
        $tmp = $db->GetOne($query,array($name));
        if( $tmp ) return TRUE;
        return FALSE;
    }


    public static function is_valid_product_id($pid)
    {
        $db = cmsms()->GetDb();
        $query = 'SELECT id FROM '.cms_db_prefix().'module_products WHERE id = ?';
        $tmp = $db->Execute($query,array($pid));
        if( $tmp ) return TRUE;
        return FALSE;
    }


    public static function is_valid_hierarchy($str)
    {
        // accept string of "name.name.name.name" and
        // convert into "name | name | name | name";
        $tmp = explode('.',$str);
        $tmp2 = array();
        foreach( $tmp as $one ) {
            $tmp2[] = trim(trim($one,'"'));
        }
        $tmp3 = implode(' | ',$tmp2);

        $db = cmsms()->GetDb();
        $query = 'SELECT id FROM '.cms_db_prefix().'module_products_hierarchy WHERE long_name = ?';
        $tmp = $db->GetOne($query,array($tmp3));
        if( !$tmp ) return FALSE;
        return TRUE;
    }


    public static function check_sku_used($sku,$productid = '',$productonly = false)
    {
        $db = cmsms()->GetDb();
        $query = 'SELECT id FROM '.cms_db_prefix().'module_products WHERE sku = ?';
        $parms = array($sku);
        if( !empty($productid) ) {
            $query .= ' AND id != ?';
            $parms[] = $productid;
        }
        $tmp = $db->GetOne($query,$parms);
        if( $tmp ) return TRUE;

        if( !$productonly ) {
            $query = 'SELECT id FROM '.cms_db_prefix().'module_products_attribs WHERE sku = ?';
            $parms = [ $sku ];
            if( !empty($productid) ) {
                $query .= ' AND product_id != ?';
                $parms[] = $productid;
            }
            $tmp = $db->GetOne($query,$parms);
            if( $tmp ) return TRUE;
        }

        return FALSE;
    }


    static public function check_alias_used($alias,$productid = '')
    {
        $db = cmsms()->GetDb();

        $parms = array();
        $parms[] = $alias;
        $query = 'SELECT id FROM '.cms_db_prefix().'module_products WHERE alias = ?';
        if( !empty($productid) ) {
            $query .= 'AND id != ?';
            $parms[] = (int)$productid;
        }
        $tmp = $db->GetOne($query,$parms);
        if( !$tmp ) return FALSE;
        return TRUE;
    }


    static public function generate_alias($product_name)
    {
        $str = munge_string_to_url($product_name);
        $postfix = '';

        while( $postfix < 1000 ) {
            $alias = $str.$postfix;
            if( !self::check_alias_used($alias) ) return $alias;
            if( $postfix == '' ) $postfix = 1;
            $postfix++;
        }

        return FALSE;
    }

    public static function get_product_hierarchy_id($productid)
    {
        if( !is_array(self::$_prodhier) || !isset(self::$_prodhier[$productid]) ) {
            $db = cmsms()->GetDb();
            $query = 'SELECT hierarchy_id FROM '.cms_db_prefix().'module_products_prodtohier
                WHERE product_id = ? LIMIT 1';
            $hier_id = $db->GetOne($query,array($productid));
            if( $hier_id <= 0 ) return FALSE;
            if( !is_array(self::$_prodhier) ) self::$_prodhier = array();
            self::$_prodhier[$productid] = $hier_id;
        }
        return self::$_prodhier[$productid];
    }


    /* deprecated */
    public static function get_product_hierarchy_path($productid)
    {
        $hier_id = self::get_product_hierarchy_id($productid);
        if( $hier_id ) return hierarchy_ops::get_hierarchy_path($hier_id);
    }


    /* deprecated */
    public static function create_hierarchy_breadcrumb($id,$product_id, $hierpage, $delim = ' &gt; ')
    {
        $hier_id = self::get_product_hierarchy_id($product_id);
        if( $hier_id <= 0 ) return FALSE;
        return hierarchy_ops::get_breadcrumb($id,$hier_id,$hierpage,$delim);
    }


    public static function get_search_result($returnid, $productid, $attr = '')
    {
        $result = array();
        $mod = cms_utils::get_module(MOD_PRODUCTS);

        if( $attr != 'product' ) return $result;
        if( $mod->GetPreference('use_detailpage_for_search',0) ) {
            $tmp = (int) $mod->GetPreference('detailpage');
            if( $tmp > 0 ) $returnid = $tmp;
        }

        $query = new products_query;
        $query['productid'] = (int) $productid;
        $rs = $query->execute();
        $rs->curpage = $returnid;
        if( $rs->totalrows == 1 ) {
            $onerow = $rs->get_product_for_display();

            //0 position is the prefix displayed in the list results.
            $result[0] = $mod->GetFriendlyName();

            //1 position is the title
            $result[1] = $onerow->name;

            //2 position is the URL to the title.
            $result[2] = $onerow->canonical;
        }

        return $result;
    }


    public static function get_currency_symbol()
    {
        $cgecb = \cms_utils::get_module('CGEcommerceBase');
        if( class_exists('cg_ecomm') ) return cg_ecomm::get_currency_symbol();
        $mod = cms_utils::get_module(MOD_PRODUCTS);
        return $mod->GetPreference('products_currencysymbol','$');
    }

    public static function get_currency_code()
    {
        $cgecb = \cms_utils::get_module('CGEcommerceBase');
        if( class_exists('cg_ecomm') ) return cg_ecomm::get_currency_code();
        $mod = cms_utils::get_module(MOD_PRODUCTS);
        return $mod->GetPreference('products_currencysymbol','USD');
    }

    public static function get_weight_units()
    {
        $cgecb = \cms_utils::get_module('CGEcommerceBase');
        if( class_exists('cg_ecomm') ) return cg_ecomm::get_weight_units();
        $mod = cms_utils::get_module(MOD_PRODUCTS);
        return $mod->GetPreference('products_weightunits','kg');
    }


    public static function get_length_units()
    {
        $cgecb = \cms_utils::get_module('CGEcommerceBase');
        if( class_exists('cg_ecomm') ) return cg_ecomm::get_length_units();
        $mod = cms_utils::get_module(MOD_PRODUCTS);
        return $mod->GetPreference('products_lengthunits','cm');
    }


    public static function get_fields()
    {
        if( !is_array(self::$_fielddefs) ) {
            $db = cmsms()->GetDb();

            $query = 'SELECT * FROM '.cms_db_prefix().'module_products_fielddefs ORDER BY item_order';
            self::$_fielddefs = $db->GetArray($query);
        }
        return self::$_fielddefs;
    }


    public static function get_field_options($type = '')
    {
        $tmp = self::get_fields();
        if( !is_array($tmp) ) return;

        $result = array();
        for( $i = 0; $i < count($tmp); $i++ ) {
            if( $type == '' || $tmp[$i]['type'] == $type ) $result[$tmp[$i]['id']] = $tmp[$i]['prompt'];
        }
        return $result;
    }


    public static function get_product_attributes_full($product_id)
    {
        $data = products_attrib::load_by_product($product_id);
        if( !count($data) ) return false;
        return $data;
    }

    public static function create_new_product()
    {
        // creates a new product filled with defaults.
        $mod = cms_utils::get_module(MOD_PRODUCTS);
        $product = new \Products\Product;
        $product->set_status($mod->GetPreference('default_status',$product::STATUS_PUBLISHED));
        $product->set_taxable($mod->GetPreference('default_taxable',1));
        return $product;
    }
} // class


#
# EOF
#
