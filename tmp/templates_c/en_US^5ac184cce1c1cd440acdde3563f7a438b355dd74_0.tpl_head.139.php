<?php
/* Smarty version 3.1.31, created on 2018-01-18 02:29:21
  from "tpl_head:139" */

/* @var Smarty_Internal_Template $_smarty_tpl */
if ($_smarty_tpl->_decodeProperties($_smarty_tpl, array (
  'version' => '3.1.31',
  'unifunc' => 'content_5a5f9601c2f625_84231267',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    '5ac184cce1c1cd440acdde3563f7a438b355dd74' => 
    array (
      0 => 'tpl_head:139',
      1 => '1516213759',
      2 => 'tpl_head',
    ),
  ),
  'includes' => 
  array (
    'cms_template:INC_Styles' => 1,
  ),
),false)) {
function content_5a5f9601c2f625_84231267 (Smarty_Internal_Template $_smarty_tpl) {
if (!is_callable('smarty_function_metadata')) require_once 'E:\\xampp\\htdocs\\public_html\\cms_version2\\cms2231_houzez\\lib\\plugins\\function.metadata.php';
if (!is_callable('smarty_cms_function_cms_stylesheet')) require_once 'E:\\xampp\\htdocs\\public_html\\cms_version2\\cms2231_houzez\\lib\\plugins\\function.cms_stylesheet.php';
?>
<head>
	<?php echo smarty_function_metadata(array(),$_smarty_tpl);?>

    
    <?php $_smarty_tpl->_subTemplateRender('cms_template:INC_Styles', $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, $_smarty_tpl->cache_lifetime, array(), 0, false);
?>

	<?php echo smarty_cms_function_cms_stylesheet(array(),$_smarty_tpl);?>

</head><?php }
}
