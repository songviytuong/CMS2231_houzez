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

if (!isset($gCms))
    exit;
$this->SetCurrentTab('products');

//
// A utility function
//
function get_field_def($fielddefs, $id) {
    foreach ($fielddefs as $onedef) {
        if ($onedef->id == $id)
            return $onedef;
    }
    return false;
}

function products_delete_uploaded_file($dir, $filename) {
    if (empty($filename))
        return;

    $filename = basename($filename);
    @unlink(cms_join_path($dir, $filename));
    @unlink(cms_join_path($dir, 'thumb_' . $filename));
    @unlink(cms_join_path($dir, 'preview_' . $filename));
}

if (!$this->CheckPermission('Modify Products')) {
    echo $this->ShowErrors($this->Lang('needpermission', array('Modify Products')));
    return;
}

if (isset($params['cancel']))
    $this->RedirectToTab($id);

$compid = \cge_param::get_int($params, 'compid');
$product = $this->GetProductStorage()->get_by_id($compid);

$fieldarray = array();
$userid = get_userid();
$fielddefs = product_utils::get_fielddefs(true);

if (isset($params['submit']) || isset($params['apply'])) {
    $errors = []; // outside of try/catch
    try {
        $product->set_name(\cge_param::get_string($params, 'product_name'));
        $product->set_price(\cge_param::get_float($params, 'price'));
        $product->set_weight(\cge_param::get_float($params, 'weight'));
        $product->set_sku(\cge_param::get_string($params, 'sku'));
        $product->set_alias(\cge_param::get_string($params, 'alias'));
        $product->set_details(\cge_param::get_html($params, 'details'));
        $product->set_status(\cge_param::get_string($params, 'status', $this->GetPreference('default_status', $product::STATUS_PUBLISHED)));
        $product->set_taxable(\cge_param::get_bool($params, 'taxable', $this->GetPreference('default_taxable', 1)));
        $product->set_extra('searchable', \cge_param::get_bool($params, 'searchable', 1));
        $product->set_extra('includes', \cge_param::get_html($params, 'includes'));
        $product->set_extra('excludes', \cge_param::get_html($params, 'excludes'));
        $product->set_extra('importantnote', \cge_param::get_html($params, 'importantnote'));
        $product->set_extra('pricedetails', \cge_param::get_html($params, 'pricedetails'));
        $product->set_digital(\cge_param::get_bool($params, 'digital'));
        $product->set_url(\cge_param::get_string($params, 'urlslug'));
        $product->set_owner(\cge_param::get_int($params, 'owner'));
        $product->set_service(\cge_param::get_bool($params, 'is_service'));
        $hier = \cge_param::get_int($params, 'hierarchy');
        if ($hier)
            $hier = [ $hier];
        $product->set_hierarchies($hier);
        $product->set_categories(\cge_utils::get_param($params, 'categories'));

        // process the album
        $album = null;
        if (\cge_param::exists($params, 'album')) {
            $tmp = \cge_utils::get_param($params, 'album');
            $album = null;
            // get rid of duplicates, and empty values.
            if (is_array($tmp) && count($tmp)) {
                foreach ($tmp as $one_image) {
                    $one_image = trim($one_image);
                    $one_image = str_replace("\\", "/", $one_image); //+Lee
                    if ($one_image && (!is_array($album) || !in_array($one_image, $album)))
                        $album[] = $one_image;
                }
            }
        }

        $product->set_extra('album', $album);

        if (\cge_param::exists($params, 'highlight')) {
            products_highlights::delete_by_product($compid);
            // we have some options.
            $highlights = [];
            $keys = ['highlight'];
            for ($i = 0; $i < count($params['highlight']); $i++) {
                $rec = [ 'product_id' => $compid];
                foreach ($keys as $key) {
                    $rec[$key] = $params[$key][$i];
                }
                $highlight = new \Products\ProductHighlights();
                $highlight->from_array($rec);
                $highlights[] = $highlight;
            }
            $product->set_highlights($highlights);
        }

        $destdir = product_utils::get_product_upload_path($product->id);

        if (isset($_REQUEST[$id . 'customfield'])) {
            foreach ($_REQUEST[$id . 'customfield'] as $k => $v) {
                // handle file deletions
                if (startswith($k, 'deletefield-')) {
                    // get the field index
                    $fid = (int) substr($k, strlen('deletefield-'));

                    // get the field type
                    $def = get_field_def($fielddefs, $fid);
                    if (!$def)
                        die('could not get field def for ' . $fid);
                    $cur_field_value = $product->get_field_value($fid);
                    if (!$cur_field_value)
                        continue;

                    switch ($def->type) {
                        case 'file':
                        case 'image':
                            // delete the file
                            products_delete_uploaded_file($destdir, $cur_field_value);
                            $product->set_field($fid, null);
                            break;
                    }
                }
            }

            foreach ($_REQUEST[$id . 'customfield'] as $k => $v) {
                // handle new values (or hidden values)
                if (startswith($k, 'field-')) { // else
                    // get the field index
                    $fid = (int) substr($k, 6);

                    // get the field type
                    $def = get_field_def($fielddefs, $fid);
                    if (!$def) {
                        die('could not get field def for ' . $fid);
                        continue;
                    }

                    // handle the upload (if any)
                    $cur_field_value = $product->get_field_value($fid);
                    switch ($def->type) {
                        case 'file':
                        case 'image':
                            $handler = new \cg_fileupload($id, $destdir);
                            $handler->set_accepted_filetypes($this->GetPreference('allowed_filetypes'));
                            if ($cur_field_value) {
                                $res = $handler->check_upload('customfield', 'field-' . $fid);
                                $err = $handler->get_error();
                                if ($res) {
                                    // have a valid replacement upload.
                                    products_delete_uploaded_file($destdir, $cur_field_value);
                                }
                            }
                            cge_dir::mkdirr($destdir);
                            if (!is_dir($destdir))
                                die('directory still does not exist');
                            $res = $handler->handle_upload('customfield', '', 'field-' . $fid);
                            $err = $handler->get_error();
                            if (!$res && $err != cg_fileupload::NOFILE) {
                                $errors[] = sprintf("%s %s: %s", $this->Lang('field'), $def->name, $this->GetUploadErrorMessage($err));
                            } else if ($res) {
                                // file uploaded.  $res is the new value.
                                $product->set_field($fid, $res);
                            }
                            break;

                        case 'quantity':
                            $v = (int) $v;
                            $v = max(0, $v);
                            $product->set_field($fid, $v);
                            break;

                        case 'subscription':
                        case 'dimensions':
                            //if( is_array($v) ) $v = serialize($v);
                            $product->set_field($fid, $v);
                            break;

                        case 'textbox':
                        case 'checkbox':
                        case 'textarea':
                        case 'dropdown':
                        case 'filelink':
                            $product->set_field($fid, $v);
                            break;

                        case 'companydir':
                            $v = (int) $v;
                            if ($v < 1)
                                $v = null;
                            $product->set_field($fid, $v);
                            break;

                        default:
                            die("unknown type: " . $def->type);
                            break;
                    }
                }
            }
        }

        $this->GetProductStorage()->save($product);

        // Update search index ??
        $module = cms_utils::get_search_module();
        if ($module != FALSE) {
            $module->DeleteWords($this->GetName(), $compid, 'product');
            if ($product->get_extra('searchable', 1) && $product->status == $product::STATUS_PUBLISHED) {
                $module->AddWords($this->GetName(), $compid, 'product', implode(' ', $this->GetSearchableText($product)));
            }
        }

        if (count($errors))
            throw new \RuntimeException($this->Lang('info_fieldproblems'));

        // all done.
        Events::SendEvent('Products', 'ProductSave', array('proid' => &$compid, 'module' => 'Products', 'modified_date' => trim($db->DBTimeStamp(time()), "'"), 'msg' => 'm?i du?c c?p nh?t'));
        if (!isset($params['apply'])) {
            $this->RedirectToTab($id);
        } else {
            $this->Redirect($id, 'editproduct', '', array('compid' => $compid));
        }
    } catch (\Exception $e) {
        // handle errors.
        if (count($errors))
            echo $this->ShowErrors($errors);
        echo $this->ShowErrors($e->GetMessage());
    }
}

//
// display smarty template
//

$fieldarray = array();
if (count($fielddefs) > 0) {
    $subscribe_opts = array();
    $subscribe_opts[-1] = $this->Lang('none');
    $subscribe_opts['monthly'] = $this->Lang('subscr_monthly');
    $subscribe_opts['quarterly'] = $this->Lang('subscr_quarterly');
    $subscribe_opts['semianually'] = $this->Lang('subscr_semianually');
    $subscribe_opts['yearly'] = $this->Lang('subscr_yearly');
    $subscribe_opts = array_flip($subscribe_opts);

    $expire_opts = array();
    $expire_opts[$this->Lang('none')] = -1;
    $expire_opts[$this->Lang('expire_six_months')] = '6';
    $expire_opts[$this->Lang('expire_one_year')] = '12';
    $expire_opts[$this->Lang('expire_two_year')] = '24';

    $wmopts = array();
    $wmopts[$this->Lang('none')] = 'none';
    $wmopts[$this->Lang('default')] = 'default';
    $wmopts[$this->Lang('align_ul')] = '0';
    $wmopts[$this->Lang('align_uc')] = '1';
    $wmopts[$this->Lang('align_ur')] = '2';
    $wmopts[$this->Lang('align_ml')] = '3';
    $wmopts[$this->Lang('align_mc')] = '4';
    $wmopts[$this->Lang('align_mr')] = '5';
    $wmopts[$this->Lang('align_ll')] = '6';
    $wmopts[$this->Lang('align_lc')] = '7';
    $wmopts[$this->Lang('align_lr')] = '8';

    foreach ($fielddefs as $fielddef) {
        $field = new stdClass();

        $value = $product->get_field_value($fielddef->id);

        if (isset($_REQUEST[$id . 'customfield']['field-' . $fielddef->id])) {
            $value = $_REQUEST[$id . 'customfield']['field-' . $fielddef->id];
        }

        $field->id = $fielddef->id;
        $field->name = $fielddef->name;
        $field->type = $fielddef->type;
        $field->value = $value;
        $field->prompt = $fielddef->prompt;
        $field->nameattr = $id . 'customfield[field-' . $field->id . ']';
        switch ($fielddef->type) {
            case 'dimensions':
                if (!is_array($value) && $value)
                    $value = unserialize($value);
                if (!is_array($value))
                    $value = array('length' => 0, 'width' => 0, 'height' => 0);
                $field->prompt .= '&nbsp;(' . product_ops::get_length_units() . ')';
                $field->input_box = $this->Lang('abbr_length') . ':&nbsp' . $this->CreateInputText($id, 'customfield[field-' . $fielddef->id . '][length]', $value['length'], 3, 3) . product_ops::get_length_units() . '&nbsp' .
                        $this->Lang('abbr_width') . ':&nbsp' . $this->CreateInputText($id, 'customfield[field-' . $fielddef->id . '][width]', $value['width'], 3, 3) . product_ops::get_length_units() . '&nbsp' .
                        $this->Lang('abbr_height') . ':&nbsp' . $this->CreateInputText($id, 'customfield[field-' . $fielddef->id . '][height]', $value['height'], 3, 3) . product_ops::get_length_units() . '&nbsp';
                break;

            case 'checkbox':
                $field->input_box = '<input type="hidden" name="' . $id . 'customfield[field-' . $fielddef->id . ']' . '" value="false" />' .
                        $this->CreateInputCheckbox($id, 'customfield[field-' . $fielddef->id . ']', 'true', $value);
                break;

            case 'textarea':
                $field->input_box = $this->CreateTextArea(true, $id, $value, 'customfield[field-' . $fielddef->id . ']');
                break;

            case 'dropdown':
                $field->input_box = $this->CreateInputDropdown($id, 'customfield[field-' . $fielddef->id . ']', $fielddef->options, -1, $value);
                $field->options = array_flip($fielddef->options);
                break;

            case 'filelink':
                break;

            case 'file':
                $field->delete = $this->CreateInputCheckbox($id, 'customfield[deletefield-' . $fielddef->id . ']', 1, 0);
                $field->input_box = $this->CreateFileUploadInput($id, 'customfield[field-' . $fielddef->id . ']', '', 50);
                $field->hidden = $this->CreateInputHidden($id, 'customfield[field-' . $fielddef->id . ']', $value);
                $field->url = null;
                if ($value) {
                    $field->url = product_utils::get_product_upload_url($compid) . "/$value";
                }
                break;

            case 'image':
                $field->url = null;
                if ($value) {
                    $field->url = product_utils::get_product_upload_url($compid) . "/$value";
                }
                $field->delete = $this->CreateInputCheckbox($id, 'customfield[deletefield-' . $fielddef->id . ']', 1, 0);
                $field->input_box = $this->CreateFileUploadInput($id, 'customfield[field-' . $fielddef->id . ']', '', 50);
                $field->hidden = $this->CreateInputHidden($id, 'customfield[field-' . $fielddef->id . ']', $value);
                break;

            case 'subscription':
                if (!is_array($value))
                    $value = array('payperiod' => -1, 'delperiod' => -1, 'expire' => 1);
                if (!isset($value['payperiod']))
                    $value['payperiod'] = -1;
                if (!isset($value['delperiod']))
                    $value['delperiod'] = -1;
                if (!isset($value['expire']))
                    $value['expire'] = -1;
                $field->input_box = $this->Lang('subscr_payperiod') . ':&nbsp;';
                $field->input_box .= $this->CreateInputDropdown($id, 'customfield[field-' . $fielddef->id . '][payperiod]', $subscribe_opts, -1, $value['payperiod']);
                $field->input_box .= '<br/>' . $this->Lang('subscr_delperiod') . ':&nbsp;';
                $field->input_box .= $this->CreateInputDropdown($id, 'customfield[field-' . $fielddef->id . '][delperiod]', $subscribe_opts, -1, $value['delperiod']);
                $field->input_box .= '<br/>' . $this->Lang('subscr_expiry') . ':&nbsp;';
                $field->input_box .= $this->CreateInputDropdown($id, 'customfield[field-' . $fielddef->id . '][expire]', $expire_opts, -1, $value['expire']);
                break;

            case 'quantity':
                $field->input_box = $this->CreateInputText($id, 'customfield[field-' . $fielddef->id . ']', $value, 4, 4);
                break;

            case 'companydir':
                $cdmod = cms_utils::get_module('CompanyDirectory', '1.19');
                if ($cdmod) {
                    $field->input_box = $this->CreateInputText($id, 'customfield[field-' . $fielddef->id . ']', $value, 10, 10, "placeholder=\"{$this->Lang('cd_autocomplete')}\" title=\"{$this->Lang('title_cdautocomplete')}\"");
                    $field->input_box = '<span class="cdautocomplete">' . $field->input_box . '</span>';
                }
                break;

            case 'textbox':
            default:
                $field->input_box = $this->CreateInputText($id, 'customfield[field-' . $fielddef->id . ']', $value, 80, 255);
                break;
        }

        $fieldarray[] = $field;
    }
}

$allcategories = \product_utils::get_categories();
$catarray = array();
if (is_array($allcategories) && count($allcategories)) {
    foreach ($allcategories as $one) {
        $catarray[$one->id] = $one->name;
    }
}
$selcatarray = $product->categories;

$tpl = $this->CreateSmartyTemplate('editproduct.tpl');
$tpl->assign('allowtravel', $this->GetPreference('allowtravel', 0));
$tpl->assign('product', $product);
$tpl->assign('highlights', $product->highlights);
$tpl->assign('product_name', $product->name);
$tpl->assign('price', $product->price);
$tpl->assign('weight', $product->weight);
$tpl->assign('sku', $product->sku);
$tpl->assign('urlslug', $product->url);
$tpl->assign('startform', $this->CreateFormStart($id, 'editproduct', $returnid, 'post', 'multipart/form-data'));
$tpl->assign('endform', $this->CreateFormEnd());
$tpl->assign('currency_symbol', product_ops::get_currency_symbol());
$tpl->assign('inputprice', $this->CreateInputText($id, 'price', sprintf("%.2f", $product->price), 10, 12));
$tpl->assign('weightunits', product_ops::get_weight_units());
$tpl->assign('lengthunits', product_ops::get_length_units());
$tpl->assign('inputalias', $this->CreateInputText($id, 'alias', $product->alias, 40, 255));
$tpl->assign('detailstext', $this->Lang('details'));
$tpl->assign('inputdetails', $this->CreateTextArea(true, $id, $product->details, 'details', '', '', '', '', '80', '10'));
$tpl->assign('input_includes', $this->CreateTextArea(true, $id, $product->get_extra('includes'), 'includes', '', '', '', '', '80', '5'));
$tpl->assign('input_excludes', $this->CreateTextArea(true, $id, $product->get_extra('excludes'), 'excludes', '', '', '', '', '80', '5'));
$tpl->assign('input_importantnote', $this->CreateTextArea(true, $id, $product->get_extra('importantnote'), 'importantnote', '', '', '', '', '80', '5'));
$tpl->assign('input_pricedetails', $this->CreateTextArea(true, $id, $product->get_extra('pricedetails'), 'pricedetails', '', '', '', '', '80', '5'));

if (count($catarray) > 0) {
    $n = count($catarray) / 4;
    $n = min($n, 20);
    $n = max($n, 5);
    $tpl->assign('all_categories', $catarray);
    $tpl->assign('sel_categories', $selcatarray);
}
$tpl->assign('taxabletext', $this->Lang('taxable'));
$tpl->assign('inputtaxable', $this->CreateInputCheckbox($id, 'taxable', 1, $product->taxable));

$hierarchy_items = $this->BuildHierarchyList();
$tpl->assign('hierarchy_items', $hierarchy_items);
$tpl->assign('hierarchy_pos', $product->first_hierarchy);

$statuses = array($this->Lang('published') => 'published',
    $this->Lang('draft') => 'draft',
    $this->Lang('disabled') => 'disabled');
$tpl->assign('statustext', $this->Lang('status'));
$tpl->assign('inputstatus', $this->CreateInputDropdown($id, 'status', $statuses, -1, $product->status));

$tpl->assign('idtext', $this->Lang('id'));
$tpl->assign('compid', $product->id);
$tpl->assign('hidden', null); // remove me.
$tpl->assign('submit', $this->CreateInputSubmit($id, 'submit', lang('submit')));
$tpl->assign('cancel', $this->CreateInputSubmit($id, 'cancel', lang('cancel')));
$tpl->assign('customfields', $fieldarray);
$tpl->assign('customfieldscount', count($fieldarray));
$tpl->assign('starttabheaders', $this->StartTabHeaders());
$tpl->assign('tabheader_main', $this->SetTabHeader('main', $this->Lang('product_info')));
$tpl->assign('tabheader_fields', $this->SetTabHeader('fields', $this->Lang('fields')));
$tpl->assign('tabheader_advanced', $this->SetTabHeader('advanced', $this->Lang('advanced')));
$tpl->assign('endtabheaders', $this->EndTabHeaders());
$tpl->assign('starttabcontent', $this->StartTabContent());
$tpl->assign('tab_main', $this->StartTab('main'));
$tpl->assign('tab_fields', $this->StartTab('fields'));
$tpl->assign('tab_advanced', $this->StartTab('advanced'));
$tpl->assign('endtab', $this->EndTab());
$tpl->assign('endtabcontent', $this->EndTabContent());

$feu_ownerlist = product_utils::get_feu_ownerlist();
$tpl->assign('feu_ownerlist', $feu_ownerlist);
$tpl->display();
