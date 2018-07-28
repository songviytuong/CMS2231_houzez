<?php
/* Smarty version 3.1.31, created on 2018-01-18 02:53:15
  from "06014adec73f1b5620a831d5ae0174e5e0b8434a" */

/* @var Smarty_Internal_Template $_smarty_tpl */
if ($_smarty_tpl->_decodeProperties($_smarty_tpl, array (
  'version' => '3.1.31',
  'unifunc' => 'content_5a5f9b9b905fe5_43339074',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
  ),
  'includes' => 
  array (
  ),
),false)) {
function content_5a5f9b9b905fe5_43339074 (Smarty_Internal_Template $_smarty_tpl) {
if (!is_callable('smarty_cms_function_cms_action_url')) require_once 'E:\\xampp\\htdocs\\public_html\\cms_version2\\cms2231_houzez\\lib\\plugins\\function.cms_action_url.php';
?>
Hello, This is a template of Real Estate default.
<?php
$_from = $_smarty_tpl->smarty->ext->_foreach->init($_smarty_tpl, $_smarty_tpl->tpl_vars['real_items']->value, 'item');
if ($_from !== null) {
foreach ($_from as $_smarty_tpl->tpl_vars['item']->value) {
?>
<a href="<?php echo smarty_cms_function_cms_action_url(array('action'=>'detail','rid'=>$_smarty_tpl->tpl_vars['item']->value->real_id),$_smarty_tpl);?>
"><?php echo $_smarty_tpl->tpl_vars['item']->value->real_name;?>
</a><br/>
<?php
}
}
$_smarty_tpl->smarty->ext->_foreach->restore($_smarty_tpl, 1);
}
}
