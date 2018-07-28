<?php
/* Smarty version 3.1.31, created on 2018-01-18 02:34:49
  from "module_file_tpl:RealEstate;detail.tpl" */

/* @var Smarty_Internal_Template $_smarty_tpl */
if ($_smarty_tpl->_decodeProperties($_smarty_tpl, array (
  'version' => '3.1.31',
  'unifunc' => 'content_5a5f97493005a0_52516724',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    '5876e36f4513c2bfecc65569e91b748b41b66f99' => 
    array (
      0 => 'module_file_tpl:RealEstate;detail.tpl',
      1 => 1515863599,
      2 => 'module_file_tpl',
    ),
  ),
  'includes' => 
  array (
  ),
),false)) {
function content_5a5f97493005a0_52516724 (Smarty_Internal_Template $_smarty_tpl) {
if ($_smarty_tpl->tpl_vars['realestate']->value) {?>
<fieldset>
  <legend><?php echo $_smarty_tpl->tpl_vars['mod']->value->Lang('realestate_detail');?>
</legend>
  <div class="row">
    <p class="col-sm-2 text-right"><?php echo $_smarty_tpl->tpl_vars['mod']->value->Lang('title');?>
:</p>
    <p class="col-sm-10"><?php echo $_smarty_tpl->tpl_vars['realestate']->value->title;?>
</p>
  </div>
</fieldset>
<?php } else { ?>
  <div class="alert alert-danger"><?php echo $_smarty_tpl->tpl_vars['mod']->value->Lang('error_notfound');?>
</div>
<?php }
}
}
