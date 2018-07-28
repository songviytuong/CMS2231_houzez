<?php
/* Smarty version 3.1.31, created on 2018-01-18 02:18:20
  from "module_file_tpl:RealEstate;items.tpl" */

/* @var Smarty_Internal_Template $_smarty_tpl */
if ($_smarty_tpl->_decodeProperties($_smarty_tpl, array (
  'version' => '3.1.31',
  'unifunc' => 'content_5a5f936c2e6ef6_45171594',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    '50c3e257c229ffb5c6cbbe64d90ab7144d8ab75d' => 
    array (
      0 => 'module_file_tpl:RealEstate;items.tpl',
      1 => 1516207274,
      2 => 'module_file_tpl',
    ),
  ),
  'includes' => 
  array (
  ),
),false)) {
function content_5a5f936c2e6ef6_45171594 (Smarty_Internal_Template $_smarty_tpl) {
if (!is_callable('smarty_cms_function_cms_action_url')) require_once 'E:\\xampp\\htdocs\\public_html\\cms_version2\\cms2231_houzez\\lib\\plugins\\function.cms_action_url.php';
if (!is_callable('smarty_function_admin_icon')) require_once 'E:\\xampp\\htdocs\\public_html\\cms_version2\\cms2231_houzez\\admin\\plugins\\function.admin_icon.php';
echo '<script'; ?>
 type="text/javascript">
    $(document).ready(function () {
        $('a.del_realestate').click(function () {
            return confirm('<?php echo $_smarty_tpl->tpl_vars['mod']->value->Lang('confirm_delete');?>
');
        })
    });
<?php echo '</script'; ?>
>
<div class="pageoptions">
    <a href="<?php echo smarty_cms_function_cms_action_url(array('action'=>'edit_realestate'),$_smarty_tpl);?>
"><?php echo smarty_function_admin_icon(array('icon'=>'newobject.gif'),$_smarty_tpl);?>

        <?php echo $_smarty_tpl->tpl_vars['mod']->value->Lang('add_realestate');?>

    </a>
</div>
<?php if (!empty($_smarty_tpl->tpl_vars['real_items']->value)) {?>
    <table class="pagetable">
        <thead>
            <tr>
                <th><?php echo $_smarty_tpl->tpl_vars['mod']->value->Lang('title');?>
</th>
                <th class="pageicon"></th>
                <th class="pageicon"></th>
            </tr>
        </thead>
        <tbody>
            <?php
$_from = $_smarty_tpl->smarty->ext->_foreach->init($_smarty_tpl, $_smarty_tpl->tpl_vars['real_items']->value, 'item');
if ($_from !== null) {
foreach ($_from as $_smarty_tpl->tpl_vars['item']->value) {
?>
                <?php echo smarty_cms_function_cms_action_url(array('action'=>'edit_realestate','rid'=>$_smarty_tpl->tpl_vars['item']->value->real_id,'assign'=>'edit_url'),$_smarty_tpl);?>

                <tr>
                    <td><a href="<?php echo $_smarty_tpl->tpl_vars['edit_url']->value;?>
" title="<?php echo $_smarty_tpl->tpl_vars['mod']->value->Lang('edit');?>
"><?php echo $_smarty_tpl->tpl_vars['item']->value->title;?>
</a></td>
                    <td><a href="<?php echo $_smarty_tpl->tpl_vars['edit_url']->value;?>
" title="<?php echo $_smarty_tpl->tpl_vars['mod']->value->Lang('edit');?>
">
                            <?php echo smarty_function_admin_icon(array('icon'=>'edit.gif'),$_smarty_tpl);?>
</a>
                    </td>
                    <td><a class="del_realestate" href="<?php echo smarty_cms_function_cms_action_url(array('action'=>'delete_realestate','rid'=>$_smarty_tpl->tpl_vars['item']->value->real_id),$_smarty_tpl);?>
"
                           title="<?php echo $_smarty_tpl->tpl_vars['mod']->value->Lang('delete');?>
"><?php echo smarty_function_admin_icon(array('icon'=>'delete.gif'),$_smarty_tpl);?>
</a></td>
                </tr>
            <?php
}
}
$_smarty_tpl->smarty->ext->_foreach->restore($_smarty_tpl, 1);
?>

        </tbody>
    </table>
<?php }
}
}
