<?php
/* Smarty version 3.1.31, created on 2018-01-18 02:10:51
  from "module_file_tpl:RealEstate;default.tpl" */

/* @var Smarty_Internal_Template $_smarty_tpl */
if ($_smarty_tpl->_decodeProperties($_smarty_tpl, array (
  'version' => '3.1.31',
  'unifunc' => 'content_5a5f91abb1a120_49131559',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    '33296cfa7064fc80dda047994002343fdf536968' => 
    array (
      0 => 'module_file_tpl:RealEstate;default.tpl',
      1 => 1515862055,
      2 => 'module_file_tpl',
    ),
  ),
  'includes' => 
  array (
  ),
),false)) {
function content_5a5f91abb1a120_49131559 (Smarty_Internal_Template $_smarty_tpl) {
if (!is_callable('smarty_cms_function_cms_action_url')) require_once 'E:\\xampp\\htdocs\\public_html\\cms_version2\\cms2231_houzez\\lib\\plugins\\function.cms_action_url.php';
?>
<div class="holidayWrapper">
    <?php
$_from = $_smarty_tpl->smarty->ext->_foreach->init($_smarty_tpl, $_smarty_tpl->tpl_vars['realestates']->value, 'realestate');
if ($_from !== null) {
foreach ($_from as $_smarty_tpl->tpl_vars['realestate']->value) {
?>
        <div class="realestate">
            <div class="row">
                <div class="col-sm-6">
                    <a href="<?php echo smarty_cms_function_cms_action_url(array('action'=>'detail','rid'=>$_smarty_tpl->tpl_vars['realestate']->value->real_id),$_smarty_tpl);?>
"><?php echo $_smarty_tpl->tpl_vars['realestate']->value->title;?>
</a>
                </div>
            </div>
        </div>
    <?php
}
} else {
?>

        <div class="alert alert-danger"><?php echo $_smarty_tpl->tpl_vars['mod']->value->Lang('sorry_norealestates');?>
</div>
    <?php
}
$_smarty_tpl->smarty->ext->_foreach->restore($_smarty_tpl, 1);
?>

</div><?php }
}
