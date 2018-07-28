<?php
/* Smarty version 3.1.31, created on 2018-01-18 02:29:21
  from "tpl_top:139" */

/* @var Smarty_Internal_Template $_smarty_tpl */
if ($_smarty_tpl->_decodeProperties($_smarty_tpl, array (
  'version' => '3.1.31',
  'unifunc' => 'content_5a5f96017984d1_69591216',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    '1836935afda431209f00fb1f9f6123f3ae7ca3d8' => 
    array (
      0 => 'tpl_top:139',
      1 => '1516213759',
      2 => 'tpl_top',
    ),
  ),
  'includes' => 
  array (
  ),
),false)) {
function content_5a5f96017984d1_69591216 (Smarty_Internal_Template $_smarty_tpl) {
if (!is_callable('smarty_function_cms_get_language')) require_once 'E:\\xampp\\htdocs\\public_html\\cms_version2\\cms2231_houzez\\lib\\plugins\\function.cms_get_language.php';
echo LISESEO::function_plugin(array('item'=>((string)$_smarty_tpl->tpl_vars['page_alias']->value),'category'=>"page",'action'=>"detail"),$_smarty_tpl);
$_smarty_tpl->smarty->ext->_capture->open($_smarty_tpl, 'default', null, null);
CMS_Content_Block::smarty_internal_fetch_contentblock(array(),$_smarty_tpl);
$_smarty_tpl->smarty->ext->_capture->close($_smarty_tpl);?><!DOCTYPE html>
<html lang="<?php echo smarty_function_cms_get_language(array(),$_smarty_tpl);?>
"><?php }
}
