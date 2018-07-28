<?php
/* Smarty version 3.1.31, created on 2018-01-18 02:19:57
  from "5df3b8fc5518f0e79158033c699dd9427df294f8" */

/* @var Smarty_Internal_Template $_smarty_tpl */
if ($_smarty_tpl->_decodeProperties($_smarty_tpl, array (
  'version' => '3.1.31',
  'unifunc' => 'content_5a5f93cde08439_27288391',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
  ),
  'includes' => 
  array (
  ),
),false)) {
function content_5a5f93cde08439_27288391 (Smarty_Internal_Template $_smarty_tpl) {
?>
Hello, This is a template of Real Estate default.
<?php
$_from = $_smarty_tpl->smarty->ext->_foreach->init($_smarty_tpl, $_smarty_tpl->tpl_vars['real_items']->value, 'item');
if ($_from !== null) {
foreach ($_from as $_smarty_tpl->tpl_vars['item']->value) {
echo $_smarty_tpl->tpl_vars['item']->value->title;?>
<br/>
<?php
}
}
$_smarty_tpl->smarty->ext->_foreach->restore($_smarty_tpl, 1);
}
}
