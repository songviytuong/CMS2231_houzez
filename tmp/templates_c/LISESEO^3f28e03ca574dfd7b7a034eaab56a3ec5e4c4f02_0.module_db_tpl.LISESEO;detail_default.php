<?php
/* Smarty version 3.1.31, created on 2018-01-18 02:06:22
  from "module_db_tpl:LISESEO;detail_default" */

/* @var Smarty_Internal_Template $_smarty_tpl */
if ($_smarty_tpl->_decodeProperties($_smarty_tpl, array (
  'version' => '3.1.31',
  'unifunc' => 'content_5a5f909ee225c8_87818001',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    '3f28e03ca574dfd7b7a034eaab56a3ec5e4c4f02' => 
    array (
      0 => 'module_db_tpl:LISESEO;detail_default',
      1 => 1498633787,
      2 => 'module_db_tpl',
    ),
  ),
  'includes' => 
  array (
  ),
),false)) {
function content_5a5f909ee225c8_87818001 (Smarty_Internal_Template $_smarty_tpl) {
if (!is_callable('smarty_function_root_url')) require_once 'E:\\xampp\\htdocs\\public_html\\cms_version2\\cms2231_houzez\\lib\\plugins\\function.root_url.php';
if (!is_callable('smarty_modifier_truncate')) require_once 'E:\\xampp\\htdocs\\public_html\\cms_version2\\cms2231_houzez\\lib\\smarty\\plugins\\modifier.truncate.php';
if ($_smarty_tpl->tpl_vars['item']->value->active == 1) {
$_from = $_smarty_tpl->smarty->ext->_foreach->init($_smarty_tpl, $_smarty_tpl->tpl_vars['item']->value->fielddefs, 'fielddef');
if ($_from !== null) {
foreach ($_from as $_smarty_tpl->tpl_vars['fielddef']->value) {
?>
    <?php if ($_smarty_tpl->tpl_vars['fielddef']->value['value'] && $_smarty_tpl->tpl_vars['fielddef']->value['type'] != 'Categories') {?>
        <?php if ($_smarty_tpl->tpl_vars['fielddef']->value['type'] == 'SelectFile' || $_smarty_tpl->tpl_vars['fielddef']->value['type'] == 'FileUpload') {?>
                <?php $_smarty_tpl->_assignInScope('img', ((string)$_smarty_tpl->tpl_vars['fielddef']->value->GetImagePath(true))."/".((string)$_smarty_tpl->tpl_vars['fielddef']->value['value']));
?>
        <?php }?>
    <?php }
}
}
$_smarty_tpl->smarty->ext->_foreach->restore($_smarty_tpl, 1);
?>

<?php if (isset($_smarty_tpl->tpl_vars['img']->value)) {
ob_start();
echo CGSmartImage::function_plugin(array('src'=>$_smarty_tpl->tpl_vars['img']->value,'filter_resize'=>'h,400','notag'=>1,'noembed'=>1),$_smarty_tpl);
$_prefixVariable1=ob_get_clean();
$_smarty_tpl->_assignInScope('seo_image', $_prefixVariable1 ,true);
ob_start();
echo smarty_function_root_url(array(),$_smarty_tpl);
$_prefixVariable2=ob_get_clean();
$_smarty_tpl->_assignInScope('meta_image', $_prefixVariable2."/".((string)$_smarty_tpl->tpl_vars['seo_image']->value) ,true ,32);
}
ob_start();
echo strip_tags($_smarty_tpl->tpl_vars['item']->value->fielddefs['meta_title']->value);
$_prefixVariable3=ob_get_clean();
$_smarty_tpl->_assignInScope('meta_title', $_prefixVariable3 ,false ,32);
ob_start();
echo strip_tags($_smarty_tpl->tpl_vars['item']->value->fielddefs['meta_keywords']->value);
$_prefixVariable4=ob_get_clean();
$_smarty_tpl->_assignInScope('meta_keywords', $_prefixVariable4 ,false ,32);
ob_start();
echo smarty_modifier_truncate(strip_tags($_smarty_tpl->tpl_vars['item']->value->fielddefs['meta_description']->value),'200','',false);
$_prefixVariable5=ob_get_clean();
$_smarty_tpl->_assignInScope('meta_description', $_prefixVariable5 ,false ,32);
}?>

<?php }
}
