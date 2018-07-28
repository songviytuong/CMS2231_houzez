<?php
/* Smarty version 3.1.31, created on 2018-01-18 02:18:20
  from "module_file_tpl:RealEstate;admintemplates.tpl" */

/* @var Smarty_Internal_Template $_smarty_tpl */
if ($_smarty_tpl->_decodeProperties($_smarty_tpl, array (
  'version' => '3.1.31',
  'unifunc' => 'content_5a5f936c67e3a8_21283838',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    'd9964c7e8efa067b49f6f53bbba8ae263a6831df' => 
    array (
      0 => 'module_file_tpl:RealEstate;admintemplates.tpl',
      1 => 1516210306,
      2 => 'module_file_tpl',
    ),
  ),
  'includes' => 
  array (
  ),
),false)) {
function content_5a5f936c67e3a8_21283838 (Smarty_Internal_Template $_smarty_tpl) {
if (!is_callable('smarty_function_cycle')) require_once 'E:\\xampp\\htdocs\\public_html\\cms_version2\\cms2231_houzez\\lib\\smarty\\plugins\\function.cycle.php';
if ($_smarty_tpl->tpl_vars['itemcount']->value > 0) {?>
    <table class="pagetable">
        <thead>
            <tr>
                <th class="pageicon">#</th>
                <th><?php echo $_smarty_tpl->tpl_vars['templates']->value;?>
</th>
                <th class="pageicon"></th>
                <th class="pageicon"></th>
                <th class="pageicon"></th>
            </tr>
        </thead>
        <tbody>
            <?php
$_from = $_smarty_tpl->smarty->ext->_foreach->init($_smarty_tpl, $_smarty_tpl->tpl_vars['items']->value, 'entry');
if ($_from !== null) {
foreach ($_from as $_smarty_tpl->tpl_vars['entry']->value) {
?>
                <?php echo smarty_function_cycle(array('values'=>"row1,row2",'assign'=>'rowclass'),$_smarty_tpl);?>

                <tr class="<?php echo $_smarty_tpl->tpl_vars['rowclass']->value;?>
" onmouseover="this.className = '<?php echo $_smarty_tpl->tpl_vars['rowclass']->value;?>
hover';" onmouseout="this.className = '<?php echo $_smarty_tpl->tpl_vars['rowclass']->value;?>
';">
                    <td><?php echo $_smarty_tpl->tpl_vars['entry']->value->id;?>
</td>
                    <td><?php echo $_smarty_tpl->tpl_vars['entry']->value->name;?>
</td>
                    <td><?php echo $_smarty_tpl->tpl_vars['entry']->value->editlink;?>
</td>
                    <td><?php echo $_smarty_tpl->tpl_vars['entry']->value->copylink;?>
</td>
                    <td><?php if ($_smarty_tpl->tpl_vars['itemcount']->value > 1) {
echo $_smarty_tpl->tpl_vars['entry']->value->deletelink;
}?></td>
                </tr>
            <?php
}
}
$_smarty_tpl->smarty->ext->_foreach->restore($_smarty_tpl, 1);
?>

        </tbody>
    </table>
<?php } else { ?>
    <h4><?php echo $_smarty_tpl->tpl_vars['notemplatestext']->value;?>
</h4>
<?php }?>

<div class="pageoptions">
    <p class="pageoptions"><?php echo $_smarty_tpl->tpl_vars['addlink']->value;?>
</p>
</div><?php }
}
