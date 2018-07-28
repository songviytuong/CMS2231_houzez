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

if (version_compare(phpversion(), '5.4.11') < 0) {
    return "Minimum PHP version of 5.4.11 required";
}

switch ($oldversion) {
    case '1.0':
    case '1.0.1': {
            $db = $this->GetDb();
            $dict = NewDataDictionary($db);
            $taboptarray = array('mysql' => 'TYPE=MyISAM');

            $flds = "
        attrib_set_id I KEY AUTO,
        product_id I KEY,
        attrib_set_name C(255)
      ";
            $taboptarray = array('mysql' => 'TYPE=MyISAM');
            $sqlarray = $dict->CreateTableSQL(cms_db_prefix() . "module_products_attribsets", $flds, $taboptarray);
            $dict->ExecuteSQLArray($sqlarray);

            $flds = "
        attrib_set_id I KEY,
        attrib_text   C(255) KEY,
        attrib_adjustment C(50)
      ";
            $taboptarray = array('mysql' => 'TYPE=MyISAM');
            $sqlarray = $dict->CreateTableSQL(cms_db_prefix() . "module_products_attributes", $flds, $taboptarray);
            $dict->ExecuteSQLArray($sqlarray);
        }


    case '2.0':
    case '2.0.1':
    case '2.0.2': {
            $db = $this->GetDb();
            $dict = NewDataDictionary($db);
            $taboptarray = array('mysql' => 'TYPE=MyISAM');

            $flds = "
          category_id I,
          field_type  C(20),
          field_name  C(255),
          field_prompt C(255),
          field_value  X
      ";
            $sqlarray = $dict->CreateTableSQL(cms_db_prefix() . "module_products_category_fields", $flds, $taboptarray);
            $dict->ExecuteSQLArray($sqlarray);
        }

    case '2.1': {
            $db = $this->GetDb();
            $query = 'SELECT * FROM ' . cms_db_prefix() . 'module_products_attributes';
            $dict = NewDataDictionary($db);
            $data = $db->GetArray($query);

            $sqlarray = $dict->DropTableSQL(cms_db_prefix() . 'module_products_attributes');
            $dict->ExecuteSQLArray($sqlarray);

            $flds = "
        attrib_id I KEY AUTO,
        attrib_set_id I,
        attrib_text   C(255),
        attrib_adjustment C(50)
      ";
            $sqlarray = $dict->CreateTableSQL(cms_db_prefix() . "module_products_attributes", $flds, $taboptarray);
            $dict->ExecuteSQLArray($sqlarray);

            $query = 'INSERT INTO ' . cms_db_prefix() . 'module_products_attributes
                (attrib_set_id, attrib_text, attrib_adjustment)
         	    VALUES (?,?,?)';
            foreach ($data as $one) {
                $db->Execute($query, array($one['attrib_set_id'], $one['attrib_text'], $one['attrib_adjustment']));
            }
        }

    case '2.1.2': {
            $newname = str_replace('.', '_', 'upgrade_to_' . $this->GetVersion());

            // setup a new default summary template.
            // but don't destroy any others.
            $fn = cms_join_path(dirname(__FILE__), 'templates', 'orig_summary_template.tpl');
            if (file_exists($fn)) {
                $template = file_get_contents($fn);
                $this->SetTemplate('summary_' . $newname, $template);
                $this->SetPreference(PRODUCTS_PREF_DFLTSUMMARY_TEMPLATE, $newname);
            }

            // setup a new default detail template.
            // but don't destroy any others.
            $fn = cms_join_path(dirname(__FILE__), 'templates', 'orig_detail_template.tpl');
            if (file_exists($fn)) {
                $template = file_get_contents($fn);
                $this->SetTemplate('detail_' . $newname, $template);
                $this->SetPreference(PRODUCTS_PREF_DFLTDETAIL_TEMPLATE, $newname);
            }

            // setup a new default byhierarchy template.
            // but don't destroy any others.
            $fn = cms_join_path(dirname(__FILE__), 'templates', 'orig_byhierarchy_template.tpl');
            if (file_exists($fn)) {
                $template = file_get_contents($fn);
                $this->SetTemplate('byhierarchy_' . $newname, $template);
                $this->SetPreference(PRODUCTS_PREF_DFLTBYHIERARCHY_TEMPLATE, $newname);
            }

            // setup a new default categorylist template.
            // but don't destroy any others.
            $fn = cms_join_path(dirname(__FILE__), 'templates', 'orig_categorylist_template.tpl');
            if (file_exists($fn)) {
                $template = file_get_contents($fn);
                $this->SetTemplate('categorylist_' . $newname, $template);
                $this->SetPreference(PRODUCTS_PREF_DFLTCATEGORYLIST_TEMPLATE, $newname);
            }
        } // 2.1.1

    case '2.2':
    case '2.2.1':
    case '2.2.2':
    case '2.2.3':
    case '2.2.4': {
            $db = $this->GetDb();
            $dict = NewDataDictionary($db);

            $sqlarray = $dict->CreateIndexSQL('products_name', cms_db_prefix() . 'module_products', 'product_name');
            $dict->ExecuteSQLArray($sqlarray);
            $sqlarray = $dict->CreateIndexSQL('products_status', cms_db_prefix() . 'module_products', 'product_status');
            $dict->ExecuteSQLArray($sqlarray);
            $sqlarray = $dict->CreateIndexSQL('products_price', cms_db_prefix() . 'module_products', 'product_price');
            $dict->ExecuteSQLArray($sqlarray);
            $sqlarray = $dict->CreateIndexSQL('products_dates', cms_db_prefix() . 'module_products', 'create_date,modified_date');
            $dict->ExecuteSQLArray($sqlarray);
            $sqlarray = $dict->CreateIndexSQL('products_cat_name', cms_db_prefix() . 'module_products_categories', 'name');
            $dict->ExecuteSQLArray($sqlarray);
            $sqlarray = $dict->CreateIndexSQL('products_prod_cat', cms_db_prefix() . 'module_products_product_categories', 'product_id,category_id');
            $dict->ExecuteSQLArray($sqlarray);
            $sqlarray = $dict->CreateIndexSQL('products_cat_prod', cms_db_prefix() . 'module_products_product_categories', 'category_id,product_id');
            $dict->ExecuteSQLArray($sqlarray);
            $sqlarray = $dict->CreateIndexSQL('products_cat_fld_name', cms_db_prefix() . 'module_products_category_fields', 'category_id,field_name');
            $dict->ExecuteSQLArray($sqlarray);
            $sqlarray = $dict->CreateIndexSQL('products_flddef_name', cms_db_prefix() . 'module_products_fielddefs', 'name');
            $dict->ExecuteSQLArray($sqlarray);
            $sqlarray = $dict->CreateIndexSQL('products_flddef_type', cms_db_prefix() . 'module_products_fielddefs', 'type');
            $dict->ExecuteSQLArray($sqlarray);
            $sqlarray = $dict->CreateIndexSQL('products_fldval_prod_def', cms_db_prefix() . 'module_products_fielvals', 'product_id,fielddef_id');
            $dict->ExecuteSQLArray($sqlarray);
            $sqlarray = $dict->CreateIndexSQL('products_fldval_def_prod', cms_db_prefix() . 'module_products_fielvals', 'fielddef_id,product_id');
            $dict->ExecuteSQLArray($sqlarray);
            $sqlarray = $dict->CreateIndexSQL('products_hier_name', cms_db_prefix() . 'module_products_hierarchy', 'name');
            $dict->ExecuteSQLArray($sqlarray);
            $sqlarray = $dict->CreateIndexSQL('products_hier_name', cms_db_prefix() . 'module_products_hierarchy', 'name');
            $dict->ExecuteSQLArray($sqlarray);
            $sqlarray = $dict->CreateIndexSQL('products_hier_parent', cms_db_prefix() . 'module_products_hierarchy', 'parent_id');
            $dict->ExecuteSQLArray($sqlarray);
            $sqlarray = $dict->CreateIndexSQL('products_hier_longname', cms_db_prefix() . 'module_products_hierarchy', 'long_name');
            $dict->ExecuteSQLArray($sqlarray);
            $sqlarray = $dict->CreateIndexSQL('products_hier_hierarchy', cms_db_prefix() . 'module_products_hierarchy', 'hierarchy');
            $dict->ExecuteSQLArray($sqlarray);

            $sqlarray = $dict->AddColumnSQL(cms_db_prefix() . "module_products_hierarchy", "extra1 C(255),extra2 C(255)");
            $dict->ExecuteSQLArray($sqlarray);
        }

    case '2.3':
    case '2.3.1': {
            $this->SetPreference('urlprefix', 'products');
        }

    case '2.4':
    case '2.4.1':
    case '2.4.2':
    case '2.4.3':
    case '2.4.4':
    case '2.4.5':
    case '2.4.6':
    case '2.4.7':
    case '2.4.8': {
            $db = $this->GetDb();
            $dict = NewDataDictionary($db);

            $sqlarray = $dict->AddColumnSQL(cms_db_prefix() . "module_products", "sku C(25)");
            $dict->ExecuteSQLArray($sqlarray);

            $sqlarray = $dict->AddColumnSQL(cms_db_prefix() . "module_products_attributes", "sku C(25)");
            $dict->ExecuteSQLArray($sqlarray);
        }

    case '2.5': {
            $db = $this->GetDb();
            $dict = NewDataDictionary($db);

            $sqlarray = $dict->AddColumnSQL(cms_db_prefix() . "module_products", "alias C(255)");
            $dict->ExecuteSQLArray($sqlarray);

            $sqlarray = $dict->CreateIndexSQL('products_name', cms_db_prefix() . 'module_products', 'product_alias');
            $dict->ExecuteSQLArray($sqlarray);
        }

    case '2.6':
    case '2.6.1':
    case '2.6.2':
    case '2.7': {
            // Setup default search template
            $this->RemovePreference(PRODUCTS_PREF_NEWSEARCH_TEMPLATE);
            $this->RemovePreference(PRODUCTS_PREF_DFLTSEARCH_TEMPLATE);
            $fn = cms_join_path(dirname(__FILE__), 'templates', 'orig_search_template.tpl');
            if (file_exists($fn)) {
                $template = file_get_contents($fn);
                $this->SetPreference(PRODUCTS_PREF_NEWSEARCH_TEMPLATE, $template);
                $this->SetTemplate('search_Sample', $template);
                $this->SetPreference(PRODUCTS_PREF_DFLTSEARCH_TEMPLATE, 'Sample');
            }
        }

    case '2.7.1':
    case '2.7.2':
    case '2.7.3':
    case '2.7.4': {
            // Setup default search template
            $this->RemovePreference(PRODUCTS_PREF_NEWSEARCH_TEMPLATE);
            $this->RemovePreference(PRODUCTS_PREF_DFLTSEARCH_TEMPLATE);
            $fn = cms_join_path(dirname(__FILE__), 'templates', 'orig_search_template.tpl');
            if (file_exists($fn)) {
                $template = file_get_contents($fn);
                $this->SetPreference(PRODUCTS_PREF_NEWSEARCH_TEMPLATE, $template);
                $this->SetTemplate('search_Sample', $template);
                $this->SetPreference(PRODUCTS_PREF_DFLTSEARCH_TEMPLATE, 'Sample');
            }
        }

        // add a new field to the category fields table.
        $db = $this->GetDb();
        $dict = NewDataDictionary($db);
        $sqlarray = $dict->AddColumnSQL(cms_db_prefix() . "module_products_category_fields", "field_order I");
        $dict->ExecuteSQLArray($sqlarray);

        // now update the category fields stuff.
        $query = 'SELECT * FROM ' . cms_db_prefix() . 'module_products_category_fields
               ORDER BY category_id,field_name';
        $data = $db->GetArray($query);
        $prev_category_id = -1;
        $order = 0;
        foreach ($data as $row) {
            if ($row['category_id'] != $prev_category_id) {
                $order = 0;
            }

            $row['field_order'] = $order;
            $query = 'UPDATE ' . cms_db_prefix() . 'module_products_category_fields
                     SET field_order = ? WHERE category_id = ? AND field_name = ?';
            $db->Execute($query, array($order, $row['category_id'], $row['field_name']));

            $order++;
            $prev_category_id = $row['category_id'];
        }

    case '2.7.5':
        // now re-order category field stuff again.
        $query = 'SELECT * FROM ' . cms_db_prefix() . 'module_products_category_fields
               ORDER BY category_id,field_name';
        $data = $db->GetArray($query);
        $prev_category_id = -1;
        $order = 0;
        foreach ($data as $row) {
            if ($row['category_id'] != $prev_category_id) {
                $order = 0;
            }

            $row['field_order'] = $order;
            $query = 'UPDATE ' . cms_db_prefix() . 'module_products_category_fields
                     SET field_order = ? WHERE category_id = ? AND field_name = ?';
            $db->Execute($query, array($order, $row['category_id'], $row['field_name']));

            $order++;
            $prev_category_id = $row['category_id'];
        }
}

if (version_compare($oldversion, '2.14') < 0) {

    function products_hiertree_update_order(&$tree) {
        $order = 1;
        foreach ($tree as &$node) {
            $node['item_order'] = $order++;
            if (isset($node['children'])) {
                products_hiertree_update_order($node['children']);
            }
        }
    }

    $db = $this->GetDb();
    $dict = NewDataDictionary($db);
    $sqlarray = $dict->AddColumnSQL(cms_db_prefix() . "module_products_hierarchy", "item_order I");
    $dict->ExecuteSQLArray($sqlarray);

    $tree = product_utils::hierarchy_get_tree();
    products_hiertree_update_order($tree);
    product_utils::hierarchy_save_tree($tree);
}


if (version_compare($oldversion, '2.14') < 0) {
    $this->AddEventHandler('CGEcommerceBase', 'OrderUpdated', FALSE);
}

if (version_compare($oldversion, '2.19') < 0) {
    $dict = NewDataDictionary($db);
    $taboptarray = array('mysql' => 'TYPE=MyISAM');

    $flds = "id I KEY AUTO,
             product_id I KEY NOT NULL,
             text C(255) KEY NOT NULL,
             adjustment C(50),
             sku  C(25),
             qoh I,
             notes X";
    $sqlarray = $dict->CreateTableSQL(cms_db_prefix() . 'module_products_attribs', $flds, $taboptarray);
    $dict->ExecuteSQLArray($sqlarray);

    set_time_limit(9999);

    // load all existing skus
    $query = 'SELECT sku FROM ' . cms_db_prefix() . 'module_products ORDER BY sku';
    $skus = $db->GetCol($query);
    if (is_array($skus)) {
        $tmp = array_unique($skus);
        if (count($tmp) < count($skus)) {
            audit('', $this->GetName(), 'WARNING: Products module upgrade detected duplicate sku values in the database');
            $skus = $tmp;
        }
    }

    // convert attribsets and attributes to "attribs"
    // text_format = set_name : attrib_text'
    $query = 'SELECT S.*,A.* FROM ' . cms_db_prefix() . 'module_products_attribsets S
              LEFT JOIN ' . cms_db_prefix() . 'module_products_attributes A
              ON S.attrib_set_id = A.attrib_set_id';

    $iquery = 'INSERT INTO ' . cms_db_prefix() . 'module_products_attribs
               (product_id,text,adjustment,sku,qoh,notes)
               VALUES (?,?,?,?,?,?)';
    $dbr = $db->Execute($query);
    $notes = 'Upgraded from Products ' . $oldversion . ' at ' . strftime('%x %X') . "\nNote, attribute combinations were not imported.";
    while (!$dbr->EOF) {
        $row = $dbr->fields;

        $text = sprintf('%s : %s', substr($row['attrib_set_name'], 0, 30), substr($row['attrib_text'], 0, 255 - 30 - 3));
        $sku = $row['sku'];
        if (in_array($sku, $skus)) {
            $sku = '';
            audit('', $this->GetName(), 'WARNING: Products module upgrade detected duplicate sku values in attributes for product ' . $row['product_id']);
            ;
        } else {
            $skus[] = $sku;
        }
        $dbr2 = $db->Execute($iquery, $row['product_id'], $text, $row['attrib_adjustment'], $sku, 0, $notes);
        $dbr->MoveNext();
    }

    $sqlarray = $dict->DropTableSQL(cms_db_prefix() . 'module_products_attribsets');
    $dict->ExecuteSQLArray($sqlarray);

    $sqlarray = $dict->DropTableSQL(cms_db_prefix() . 'module_products_attributes');
    $dict->ExecuteSQLArray($sqlarray);
}

if (version_compare($oldversion, '2.19.2') < 0) {
    $query = 'ALTER TABLE ' . cms_db_prefix() . 'module_products_fieldvals ADD PRIMARY KEY (product_id,fielddef_id)';
    $db->Execute($query);
}

if (version_compare($oldversion, '2.19.10') < 0) {
    $dict = NewDataDictionary($db);
    $sqlarray = $dict->CreateIndexSQL('products_product_cats', cms_db_prefix() . 'module_products_product_categories', 'product_id,category_id', array('UNIQUE' => 1));
    $dict->ExecuteSQLArray($sqlarray);
}

if (version_compare($oldversion, '2.20.4') < 0) {
    $dict = NewDataDictionary($db);
    $sqlarray = $dict->AddColumnSQL(cms_db_prefix() . 'module_products_attribs', 'iorder I');
    $dict->ExecuteSQLArray($sqlarray);

    $query = 'SELECT id,product_id FROM ' . cms_db_prefix() . 'module_products_attribs ORDER BY product_id,sku,id';
    $res = $db->GetArray($query);
    if (is_array($res) && count($res)) {
        $product_id = -1;
        $iorder = 1;
        $query = 'UPDATE ' . cms_db_prefix() . 'module_products_attribs SET iorder = ? WHERE id = ?';
        foreach ($res as $row) {
            if ($row['product_id'] != $product_id) {
                // a new product id was encountered.
                $product_id = $row['product_id'];
                $iorder = 1;
            }

            $dbr = $db->Execute($query, array($iorder, $row['id']));
            $iorder++;
        }
    }
}
if (version_compare($oldversion, '2.22.1') < 0) {
    $this->SetPreference('upload_dir', '_products');
}
if (version_compare($oldversion, '2.23.9') < 0) {
    $dict = NewDataDictionary($db);
    $sqlarray = $dict->AddColumnSQL(cms_db_prefix() . "module_products", "url C(255)");
    $dict->ExecuteSQLArray($sqlarray);

    $sqlarray = $dict->CreateIndexSQL(cms_db_prefix() . 'products_idxurl', cms_db_prefix() . 'module_products', 'id,url,status');
    $dict->ExecuteSQLArray($sqlarray);
}
if (version_compare($oldversion, '2.26') < 0) {
    $dict = NewDataDictionary($db);
    $sqlarray = $dict->AddColumnSQL(cms_db_prefix() . "module_products", "owner I");
    $dict->ExecuteSQLArray($sqlarray);
}
if (version_compare($oldversion, '2.26.2') < 0) {
    // convert templates to use DesignManager.
    $handle_template_conversion = function($type_name, $tpl_prefix, $mod, $cur_dflt_name) {
        try {
            $tpl_type = new \CmsLayoutTemplateType();
            $tpl_type->set_originator('Products');
            $tpl_type->set_dflt_flag();
            $tpl_type->set_name($type_name);
            $tpl_type->set_lang_callback('Products::tpl_type_lang_cb');
            $tpl_type->set_content_callback('Products::tpl_type_reset_cb');
            $tpl_type->reset_content_to_factory();
            $tpl_type->save();
        } catch (\CmsException $e) {
            \cge_utils::log_exception($e);
            audit('', 'Products', 'Upgrade error: ' . $e->GetMessage());
        }

        try {
            $tpl_type = \CmsLayoutTemplateType::load('Products::' . $type_name);

            $templates = $mod->ListTemplatesWithPrefix($tpl_prefix);
            if (count($templates)) {
                $dflt = true;
                foreach ($templates as $tpl_name) {
                    $content = $mod->GetTemplate($tpl_name);
                    if (!$content)
                        continue;

                    $ob = new \CmsLayoutTemplate();
                    $tpl_suffix = $adj_tpl_name1 = substr($tpl_name, strlen($tpl_prefix));
                    $adj_tpl_name1 = 'Products ' . $type_name . ' ' . $adj_tpl_name1;
                    $adj_tpl_name2 = $ob->generate_unique_name($adj_tpl_name1);
                    $ob->set_type($tpl_type);
                    $ob->set_content($content);
                    $ob->set_owner(get_userid());
                    $ob->set_type_dflt($dflt);
                    $ob->set_name($adj_tpl_name2);
                    $ob->save();

                    $mod->RemoveTemplate($tpl_name);
                    $dflt = false;
                }
            }
        } catch (\CmsException $e) {
            \cge_utils::log_exception($e);
            audit('', 'Products', 'Upgrade error: ' . $e->GetMessage());
        }
    };

    $handle_template_conversion('List View', 'summary_', $this, $this->GetPreference('products_pref_dfltsummary_template'));
    $this->RemovePreference('products_pref_dfltsummary_template');
    $this->RemovePreference('products_pref_newsummary_template');
    $handle_template_conversion('Detail View', 'detail_', $this, $this->GetPreference('products_pref_dfltdetail_template'));
    $this->RemovePreference('products_pref_dfltdetail_template');
    $this->RemovePreference('products_pref_newdetail_template');
    $handle_template_conversion('Hierarchy View', 'byhierarchy_', $this, $this->GetPreference('products_pref_dfltbyhierarchy_template'));
    $this->RemovePreference('products_pref_dfltbyhierarchy_template');
    $this->RemovePreference('products_pref_newbyhierarchy_template');
    $handle_template_conversion('Category View', 'categorylist_', $this, $this->GetPreference('products_pref_dfltcategorylist_template'));
    $this->RemovePreference('products_pref_dfltcategorylist_template');
    $this->RemovePreference('products_pref_newcategorylist_template');
    $handle_template_conversion('Search', 'search_', $this, $this->GetPreference('products_pref_dfltsearch_template'));
    $this->RemovePreference('products_pref_dfltsearch_template');
    $this->RemovePreference('products_pref_newsearch_template');
}
if (version_compare($oldversion, '2.27') < 0) {
    $dict = NewDataDictionary($db);
    $sqlarray = $dict->AddColumnSQL(cms_db_prefix() . "module_products", "digital I DEFAULT 0");
    $dict->ExecuteSQLArray($sqlarray);
}
if (version_compare($oldversion, '2.27.1') < 0) {
    $dict = NewDataDictionary($db);
    $sqlarray = $dict->AddColumnSQL(cms_db_prefix() . "module_products", "extra X2");
    $dict->ExecuteSQLArray($sqlarray);
}
if (version_compare($oldversion, '2.28.3.1') < 0) {
    $db = $this->GetDb();
    $dict = NewDataDictionary($db);
    $taboptarray = array('mysql' => 'TYPE=MyISAM');

    $flds = "id I KEY AUTO NOTNULL,
         product_id I KEY NOTNULL,
         title C(255) KEY NOTNULL,
         description C(255),
         iorder I NOTNULL";
    $sqlarray = $dict->CreateTableSQL(cms_db_prefix() . 'module_products_timelines', $flds, $taboptarray);
    $dict->ExecuteSQLArray($sqlarray);

    $flds = "id I KEY AUTO NOTNULL,
         product_id I KEY NOTNULL,
         highlight C(255) KEY NOTNULL,
         iorder I NOTNULL";
    $sqlarray = $dict->CreateTableSQL(cms_db_prefix() . 'module_products_highlights', $flds, $taboptarray);
    $dict->ExecuteSQLArray($sqlarray);
}

