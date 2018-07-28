<?php
/* Smarty version 3.1.31, created on 2018-01-18 02:52:02
  from "module_file_tpl:CMSContentManager;admin_bulk_setdesign.tpl" */

/* @var Smarty_Internal_Template $_smarty_tpl */
if ($_smarty_tpl->_decodeProperties($_smarty_tpl, array (
  'version' => '3.1.31',
  'unifunc' => 'content_5a5f9b5259c804_36534653',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    '844043d673dc4eca06a4d750d681a47b9864cf9b' => 
    array (
      0 => 'module_file_tpl:CMSContentManager;admin_bulk_setdesign.tpl',
      1 => 1514740891,
      2 => 'module_file_tpl',
    ),
  ),
  'includes' => 
  array (
  ),
),false)) {
function content_5a5f9b5259c804_36534653 (Smarty_Internal_Template $_smarty_tpl) {
if (!is_callable('smarty_function_form_start')) require_once 'E:\\xampp\\htdocs\\public_html\\cms_version2\\cms2231_houzez\\lib\\plugins\\function.form_start.php';
if (!is_callable('smarty_function_html_options')) require_once 'E:\\xampp\\htdocs\\public_html\\cms_version2\\cms2231_houzez\\lib\\smarty\\plugins\\function.html_options.php';
if (!is_callable('smarty_function_form_end')) require_once 'E:\\xampp\\htdocs\\public_html\\cms_version2\\cms2231_houzez\\lib\\plugins\\function.form_end.php';
echo '<script'; ?>
 type="text/javascript">
$(document).ready(function(){
   $('#showmore_ctl').click(function(){
      $(this).closest('form').submit();
   });
});
<?php echo '</script'; ?>
>
<h3><?php echo $_smarty_tpl->tpl_vars['mod']->value->Lang('prompt_bulk_setdesign');?>
:</h3>

<?php echo smarty_function_form_start(array('multicontent'=>$_smarty_tpl->tpl_vars['multicontent']->value),$_smarty_tpl);?>

<div class="pageoverflow">
	<ul>
		<?php
$_from = $_smarty_tpl->smarty->ext->_foreach->init($_smarty_tpl, $_smarty_tpl->tpl_vars['displaydata']->value, 'rec');
if ($_from !== null) {
foreach ($_from as $_smarty_tpl->tpl_vars['rec']->value) {
?>
		<li>(<?php echo $_smarty_tpl->tpl_vars['rec']->value['id'];?>
) : <?php echo $_smarty_tpl->tpl_vars['rec']->value['name'];?>
 <em>(<?php echo $_smarty_tpl->tpl_vars['rec']->value['alias'];?>
)</em></li>
		<?php
}
}
$_smarty_tpl->smarty->ext->_foreach->restore($_smarty_tpl, 1);
?>

	</ul>
</div>

<div class="warning"><?php echo $_smarty_tpl->tpl_vars['mod']->value->Lang('warn_destructive');?>
</div>

<div class="pageoverflow">
	<p class="pagetext"><label for="design_ctl"><?php echo $_smarty_tpl->tpl_vars['mod']->value->Lang('prompt_design');?>
:</label></p>
	<p class="pageinput">
		<select id="design_ctl" name="<?php echo $_smarty_tpl->tpl_vars['actionid']->value;?>
design">
			<?php echo smarty_function_html_options(array('options'=>$_smarty_tpl->tpl_vars['alldesigns']->value,'selected'=>$_smarty_tpl->tpl_vars['dflt_design_id']->value),$_smarty_tpl);?>

		</select></p>
</div>

<div class="pageoverflow">
	<p class="pagetext"><label for="template_ctl"><?php echo $_smarty_tpl->tpl_vars['mod']->value->Lang('prompt_template');?>
:</label></p>
	<p class="pageinput">
		<select id="template_ctl" name="<?php echo $_smarty_tpl->tpl_vars['actionid']->value;?>
template">
			<?php echo smarty_function_html_options(array('options'=>$_smarty_tpl->tpl_vars['alltemplates']->value,'selected'=>$_smarty_tpl->tpl_vars['dflt_tpl_id']->value),$_smarty_tpl);?>

		</select>
	</p>
</div>

<div class="pageoverflow">
	<p class="pageinput">
	        <label>
		   <input type="hidden" name="<?php echo $_smarty_tpl->tpl_vars['actionid']->value;?>
showmore" value="0"/>
		   <input type="checkbox" id="showmore_ctl" name="<?php echo $_smarty_tpl->tpl_vars['actionid']->value;?>
showmore" value="1" <?php if ($_smarty_tpl->tpl_vars['showmore']->value) {?>checked<?php }?>/>
		   <?php echo $_smarty_tpl->tpl_vars['mod']->value->Lang('prompt_showmore');?>
</label>
	</p>
</div>

<div class="pageoverflow">
	<p class="pagetext"><?php echo $_smarty_tpl->tpl_vars['mod']->value->Lang('prompt_confirm_operation');?>
:</p>
	<p class="pageinput">
		<input type="checkbox" id="confirm1" value="1" name="<?php echo $_smarty_tpl->tpl_vars['actionid']->value;?>
confirm1">
		&nbsp; <label for="confirm1"><?php echo $_smarty_tpl->tpl_vars['mod']->value->Lang('prompt_confirm1');?>
</label>
		<br/>
		<input type="checkbox" id="confirm2" value="1" name="<?php echo $_smarty_tpl->tpl_vars['actionid']->value;?>
confirm2">
		&nbsp; <label for="confirm2"><?php echo $_smarty_tpl->tpl_vars['mod']->value->Lang('prompt_confirm2');?>
</label></p>
</div>

<div class="pageoverflow">
	<p class="pageinput">
		<input type="submit" name="<?php echo $_smarty_tpl->tpl_vars['actionid']->value;?>
submit" value="<?php echo $_smarty_tpl->tpl_vars['mod']->value->Lang('submit');?>
"/>
		<input type="submit" name="<?php echo $_smarty_tpl->tpl_vars['actionid']->value;?>
cancel" value="<?php echo $_smarty_tpl->tpl_vars['mod']->value->Lang('cancel');?>
"/>
	</p>
</div>
<?php echo smarty_function_form_end(array(),$_smarty_tpl);
}
}
