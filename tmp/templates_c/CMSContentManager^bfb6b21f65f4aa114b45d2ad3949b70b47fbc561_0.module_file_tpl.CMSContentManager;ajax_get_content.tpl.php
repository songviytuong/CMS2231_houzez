<?php
/* Smarty version 3.1.31, created on 2018-01-18 02:34:04
  from "module_file_tpl:CMSContentManager;ajax_get_content.tpl" */

/* @var Smarty_Internal_Template $_smarty_tpl */
if ($_smarty_tpl->_decodeProperties($_smarty_tpl, array (
  'version' => '3.1.31',
  'unifunc' => 'content_5a5f971c2b1e59_88873389',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    'bfb6b21f65f4aa114b45d2ad3949b70b47fbc561' => 
    array (
      0 => 'module_file_tpl:CMSContentManager;ajax_get_content.tpl',
      1 => 1514740891,
      2 => 'module_file_tpl',
    ),
  ),
  'includes' => 
  array (
  ),
),false)) {
function content_5a5f971c2b1e59_88873389 (Smarty_Internal_Template $_smarty_tpl) {
$_smarty_tpl->smarty->ext->_tplFunction->registerTplFunctions($_smarty_tpl, array (
  'do_content_row' => 
  array (
    'compiled_filepath' => 'E:\\xampp\\htdocs\\public_html\\cms_version2\\cms2231_houzez\\tmp\\templates_c\\CMSContentManager^bfb6b21f65f4aa114b45d2ad3949b70b47fbc561_0.module_file_tpl.CMSContentManager;ajax_get_content.tpl.php',
    'uid' => 'bfb6b21f65f4aa114b45d2ad3949b70b47fbc561',
    'call_name' => 'smarty_template_function_do_content_row_298485a5f971b6b68e6_77257285',
  ),
));
if (!is_callable('smarty_cms_function_cms_action_url')) require_once 'E:\\xampp\\htdocs\\public_html\\cms_version2\\cms2231_houzez\\lib\\plugins\\function.cms_action_url.php';
if (!is_callable('smarty_function_admin_icon')) require_once 'E:\\xampp\\htdocs\\public_html\\cms_version2\\cms2231_houzez\\admin\\plugins\\function.admin_icon.php';
if (!is_callable('smarty_function_form_start')) require_once 'E:\\xampp\\htdocs\\public_html\\cms_version2\\cms2231_houzez\\lib\\plugins\\function.form_start.php';
if (!is_callable('smarty_function_html_options')) require_once 'E:\\xampp\\htdocs\\public_html\\cms_version2\\cms2231_houzez\\lib\\smarty\\plugins\\function.html_options.php';
if (!is_callable('smarty_function_form_end')) require_once 'E:\\xampp\\htdocs\\public_html\\cms_version2\\cms2231_houzez\\lib\\plugins\\function.form_end.php';
if (!is_callable('smarty_function_repeat')) require_once 'E:\\xampp\\htdocs\\public_html\\cms_version2\\cms2231_houzez\\lib\\plugins\\function.repeat.php';
if (!is_callable('smarty_modifier_date_format')) require_once 'E:\\xampp\\htdocs\\public_html\\cms_version2\\cms2231_houzez\\lib\\smarty\\plugins\\modifier.date_format.php';
if (!is_callable('smarty_modifier_relative_time')) require_once 'E:\\xampp\\htdocs\\public_html\\cms_version2\\cms2231_houzez\\lib\\plugins\\modifier.relative_time.php';
if (!is_callable('smarty_modifier_cms_date_format')) require_once 'E:\\xampp\\htdocs\\public_html\\cms_version2\\cms2231_houzez\\lib\\plugins\\modifier.cms_date_format.php';
if (!is_callable('smarty_function_cycle')) require_once 'E:\\xampp\\htdocs\\public_html\\cms_version2\\cms2231_houzez\\lib\\smarty\\plugins\\function.cycle.php';
?>
<div class="row c_full cf">
  <div class="pageoptions grid_8" style="margin-top: 8px;">
      <?php if ($_smarty_tpl->tpl_vars['can_add_content']->value) {?>
        <a href="<?php echo smarty_cms_function_cms_action_url(array('action'=>'admin_editcontent'),$_smarty_tpl);?>
" accesskey="n" title="<?php echo $_smarty_tpl->tpl_vars['mod']->value->Lang('addcontent');?>
" class="pageoptions"><?php echo smarty_function_admin_icon(array('icon'=>'newobject.gif','alt'=>$_smarty_tpl->tpl_vars['mod']->value->Lang('addcontent')),$_smarty_tpl);?>
&nbsp;<?php echo $_smarty_tpl->tpl_vars['mod']->value->Lang('addcontent');?>
</a>
      <?php }?>

      <?php if (!$_smarty_tpl->tpl_vars['have_filter']->value && isset($_smarty_tpl->tpl_vars['content_list']->value)) {?>
        <a class="expandall" href="<?php echo smarty_cms_function_cms_action_url(array('action'=>'defaultadmin','expandall'=>1),$_smarty_tpl);?>
" accesskey="e" title="<?php echo $_smarty_tpl->tpl_vars['mod']->value->Lang('prompt_expandall');?>
"><?php echo smarty_function_admin_icon(array('icon'=>'expandall.gif','alt'=>$_smarty_tpl->tpl_vars['mod']->value->Lang('expandall')),$_smarty_tpl);?>
&nbsp;<?php echo $_smarty_tpl->tpl_vars['mod']->value->Lang('expandall');?>
</a>
	<a class="collapseall" href="<?php echo smarty_cms_function_cms_action_url(array('action'=>'defaultadmin','collapseall'=>1),$_smarty_tpl);?>
" accesskey="c" title="<?php echo $_smarty_tpl->tpl_vars['mod']->value->Lang('prompt_collapseall');?>
"><?php echo smarty_function_admin_icon(array('icon'=>'contractall.gif','alt'=>$_smarty_tpl->tpl_vars['mod']->value->Lang('contractall')),$_smarty_tpl);?>
&nbsp;<?php echo $_smarty_tpl->tpl_vars['mod']->value->Lang('contractall');?>
</a>
	<?php if ($_smarty_tpl->tpl_vars['can_reorder_content']->value) {?>
	  <a id="ordercontent" href="<?php echo smarty_cms_function_cms_action_url(array('action'=>'admin_ordercontent'),$_smarty_tpl);?>
" accesskey="r" title="<?php echo $_smarty_tpl->tpl_vars['mod']->value->Lang('prompt_ordercontent');?>
"><?php echo smarty_function_admin_icon(array('icon'=>'reorder.gif','alt'=>$_smarty_tpl->tpl_vars['mod']->value->Lang('reorderpages')),$_smarty_tpl);?>
&nbsp;<?php echo $_smarty_tpl->tpl_vars['mod']->value->Lang('reorderpages');?>
</a>
	<?php }?>
	<?php if ($_smarty_tpl->tpl_vars['have_locks']->value) {?>
	  <a id="clearlocks" href="<?php echo smarty_cms_function_cms_action_url(array('action'=>'admin_clearlocks'),$_smarty_tpl);?>
" accesskey="l" title="<?php echo $_smarty_tpl->tpl_vars['mod']->value->Lang('title_clearlocks');?>
"><?php echo smarty_function_admin_icon(array('icon'=>'run.gif','alt'=>''),$_smarty_tpl);?>
&nbsp;<?php echo $_smarty_tpl->tpl_vars['mod']->value->Lang('prompt_clearlocks');?>
</a>
	<?php }?>
      <?php }?>
      <a id="myoptions" accesskey="o" title="<?php echo $_smarty_tpl->tpl_vars['mod']->value->Lang('prompt_settings');?>
"><?php echo smarty_function_admin_icon(array('icon'=>'edit.gif','alt'=>$_smarty_tpl->tpl_vars['mod']->value->Lang('prompt_settings')),$_smarty_tpl);?>
&nbsp;<?php echo $_smarty_tpl->tpl_vars['mod']->value->lang('prompt_settings');?>
</a>
      <?php if (!empty($_smarty_tpl->tpl_vars['have_filter']->value)) {?><span style="color: red;"><em>(<?php echo $_smarty_tpl->tpl_vars['mod']->value->Lang('filter_applied');?>
)</em></span><?php }?>
  </div>

  <div class="pageoptions options-form grid_4" style="float: right;">
    <?php if (isset($_smarty_tpl->tpl_vars['content_list']->value)) {?>
    <span><label for="ajax_find"><?php echo $_smarty_tpl->tpl_vars['mod']->value->Lang('find');?>
:</label>&nbsp;<input type="text" id="ajax_find" name="ajax_find" title="<?php echo $_smarty_tpl->tpl_vars['mod']->value->Lang('title_listcontent_find');?>
" value="" size="25"/></span>
    <?php }?>

    <?php if (isset($_smarty_tpl->tpl_vars['content_list']->value) && $_smarty_tpl->tpl_vars['npages']->value > 1) {?>
      <?php echo smarty_function_form_start(array('action'=>'defaultadmin'),$_smarty_tpl);?>

        <span><?php echo $_smarty_tpl->tpl_vars['mod']->value->Lang('page');?>
:&nbsp;
        <select name="<?php echo $_smarty_tpl->tpl_vars['actionid']->value;?>
curpage" id="<?php echo $_smarty_tpl->tpl_vars['actionid']->value;?>
curpage">
          <?php echo smarty_function_html_options(array('options'=>$_smarty_tpl->tpl_vars['pagelist']->value,'selected'=>$_smarty_tpl->tpl_vars['curpage']->value),$_smarty_tpl);?>

        </select>
        <button name="<?php echo $_smarty_tpl->tpl_vars['actionid']->value;?>
submitpage" class="invisible ui-button ui-widget ui-corner-all ui-state-default ui-button-text-icon-primary">
          <span class="ui-button-icon-primary ui-icon ui-icon-circle-check"></span>
          <span class="ui-button-text"><?php echo $_smarty_tpl->tpl_vars['mod']->value->Lang('go');?>
</span>
        </button>
        </span>
      <?php echo smarty_function_form_end(array(),$_smarty_tpl);?>

    <?php }?>
  </div>
</div>

<?php echo smarty_function_form_start(array('action'=>'defaultadmin','id'=>'listform'),$_smarty_tpl);?>

  <div id="contentlist">
  
  <?php if (isset($_smarty_tpl->tpl_vars['error']->value)) {?>
  <div id="error_cont" class="red" style="color: red; width: 80%; margin-left: 2%; margin-right: 10%; text-align: center; vertical-align: middle;"><?php echo $_smarty_tpl->tpl_vars['error']->value;?>
</div>
  <?php }?>

  <?php if (isset($_smarty_tpl->tpl_vars['content_list']->value)) {?>
    

  <table id="contenttable" class="pagetable" width="100%"><thead><tr><?php
$_from = $_smarty_tpl->smarty->ext->_foreach->init($_smarty_tpl, $_smarty_tpl->tpl_vars['columns']->value, 'flag', false, 'column');
if ($_from !== null) {
foreach ($_from as $_smarty_tpl->tpl_vars['column']->value => $_smarty_tpl->tpl_vars['flag']->value) {
if ($_smarty_tpl->tpl_vars['flag']->value) {?><th class=" <?php if ($_smarty_tpl->tpl_vars['flag']->value == 'icon') {?>pageicon<?php }?>"><!-- <?php echo $_smarty_tpl->tpl_vars['column']->value;?>
 --><?php if ($_smarty_tpl->tpl_vars['column']->value == 'expand' || $_smarty_tpl->tpl_vars['column']->value == 'hier' || $_smarty_tpl->tpl_vars['column']->value == 'icon1' || $_smarty_tpl->tpl_vars['column']->value == 'view' || $_smarty_tpl->tpl_vars['column']->value == 'copy' || $_smarty_tpl->tpl_vars['column']->value == 'edit' || $_smarty_tpl->tpl_vars['column']->value == 'delete') {?><span title="<?php echo $_smarty_tpl->tpl_vars['mod']->value->Lang("coltitle_".((string)$_smarty_tpl->tpl_vars['column']->value));?>
">&nbsp;</span><?php } elseif ($_smarty_tpl->tpl_vars['column']->value == 'multiselect') {?><input type="checkbox" id="selectall" value="1" title="<?php echo $_smarty_tpl->tpl_vars['mod']->value->Lang('select_all');?>
"/><?php } elseif ($_smarty_tpl->tpl_vars['column']->value == 'page') {?><span title="<?php echo $_smarty_tpl->tpl_vars['coltitle_page']->value;?>
"><?php echo $_smarty_tpl->tpl_vars['colhdr_page']->value;?>
</span><?php } else {
if (($_smarty_tpl->tpl_vars['have_locks']->value == '1') && ($_smarty_tpl->tpl_vars['column']->value == 'default' || $_smarty_tpl->tpl_vars['column']->value == 'move')) {?><span title="<?php echo $_smarty_tpl->tpl_vars['mod']->value->Lang('error_action_contentlocked');?>
">(<?php echo $_smarty_tpl->tpl_vars['mod']->value->Lang("colhdr_".((string)$_smarty_tpl->tpl_vars['column']->value));?>
)</span><?php } else { ?><span title="<?php echo $_smarty_tpl->tpl_vars['mod']->value->Lang("coltitle_".((string)$_smarty_tpl->tpl_vars['column']->value));?>
"><?php echo $_smarty_tpl->tpl_vars['mod']->value->Lang("colhdr_".((string)$_smarty_tpl->tpl_vars['column']->value));?>
</span><?php }
}?></th><?php }
}
}
$_smarty_tpl->smarty->ext->_foreach->restore($_smarty_tpl, 1);
?>
</tr></thead><tbody class="contentrows"><?php
$_from = $_smarty_tpl->smarty->ext->_foreach->init($_smarty_tpl, $_smarty_tpl->tpl_vars['content_list']->value, 'row');
if ($_from !== null) {
foreach ($_from as $_smarty_tpl->tpl_vars['row']->value) {
echo smarty_function_cycle(array('values'=>"row1,row2",'assign'=>'rowclass'),$_smarty_tpl);?>
<tr id="row_<?php echo $_smarty_tpl->tpl_vars['row']->value['id'];?>
" class="<?php echo $_smarty_tpl->tpl_vars['rowclass']->value;?>
 <?php if (isset($_smarty_tpl->tpl_vars['row']->value['selected'])) {?>selected<?php }?>"><?php $_smarty_tpl->smarty->ext->_tplFunction->callTemplateFunction($_smarty_tpl, 'do_content_row', array('row'=>$_smarty_tpl->tpl_vars['row']->value,'columns'=>$_smarty_tpl->tpl_vars['columns']->value), true);?>
</tr><?php
}
}
$_smarty_tpl->smarty->ext->_foreach->restore($_smarty_tpl, 1);
?>
</tbody></table>
  <?php } else { ?>

  <?php }?>
  </div>

<?php if (isset($_smarty_tpl->tpl_vars['content_list']->value)) {?>
  <div class="row c_full cf">
    <?php if ($_smarty_tpl->tpl_vars['can_add_content']->value) {?>
      <div class="pageoptions grid_6" style="margin-top: 8px;">
        <a  href="<?php echo smarty_cms_function_cms_action_url(array('action'=>'admin_editcontent'),$_smarty_tpl);?>
" accesskey="n" title="<?php echo $_smarty_tpl->tpl_vars['mod']->value->Lang('addcontent');?>
" class="pageoptions"><?php echo smarty_function_admin_icon(array('icon'=>'newobject.gif','alt'=>$_smarty_tpl->tpl_vars['mod']->value->Lang('addcontent')),$_smarty_tpl);?>
&nbsp;<?php echo $_smarty_tpl->tpl_vars['mod']->value->Lang('addcontent');?>
</a>
      </div>
    <?php }?>
    <?php if ($_smarty_tpl->tpl_vars['multiselect']->value && isset($_smarty_tpl->tpl_vars['bulk_options']->value)) {?>
      <div class="pageoptions grid_6" style="text-align: right;">
        <label for="multiaction"><?php echo $_smarty_tpl->tpl_vars['mod']->value->Lang('prompt_withselected');?>
:</label>&nbsp;&nbsp;
        <select name="<?php echo $_smarty_tpl->tpl_vars['actionid']->value;?>
multiaction" id="multiaction">
          <?php echo smarty_function_html_options(array('options'=>$_smarty_tpl->tpl_vars['bulk_options']->value),$_smarty_tpl);?>

        </select>
        <input type="submit" id="multisubmit" name="<?php echo $_smarty_tpl->tpl_vars['actionid']->value;?>
multisubmit" accesskey="s" value="<?php echo $_smarty_tpl->tpl_vars['mod']->value->Lang('submit');?>
"/>
      </div>
    <?php }?>
  </div>
<?php }
echo smarty_function_form_end(array(),$_smarty_tpl);?>

<div class="clearb"></div><?php }
/* smarty_template_function_do_content_row_298485a5f971b6b68e6_77257285 */
if (!function_exists('smarty_template_function_do_content_row_298485a5f971b6b68e6_77257285')) {
function smarty_template_function_do_content_row_298485a5f971b6b68e6_77257285($_smarty_tpl,$params) {
foreach ($params as $key => $value) {
$_smarty_tpl->tpl_vars[$key] = new Smarty_Variable($value, $_smarty_tpl->isRenderingCache);
}?>
      <?php
$_from = $_smarty_tpl->smarty->ext->_foreach->init($_smarty_tpl, $_smarty_tpl->tpl_vars['columns']->value, 'flag', false, 'column');
if ($_from !== null) {
foreach ($_from as $_smarty_tpl->tpl_vars['column']->value => $_smarty_tpl->tpl_vars['flag']->value) {
?>
        <?php if (!$_smarty_tpl->tpl_vars['flag']->value) {
continue 1;
}?>
	<td <?php if ($_smarty_tpl->tpl_vars['column']->value == 'importseo' && $_smarty_tpl->tpl_vars['row']->value['importseo'] == 'Empty') {?>class="init-ajax-toggle"<?php }?>>
	  <?php if ($_smarty_tpl->tpl_vars['column']->value == 'expand') {?>
	    <?php if ($_smarty_tpl->tpl_vars['row']->value['expand'] == 'open') {?>
	    <a href="<?php echo smarty_cms_function_cms_action_url(array('action'=>'defaultadmin','collapse'=>$_smarty_tpl->tpl_vars['row']->value['id']),$_smarty_tpl);?>
" class="page_collapse" accesskey="C" title="<?php echo $_smarty_tpl->tpl_vars['mod']->value->Lang('prompt_page_collapse');?>
">
	      <?php echo smarty_function_admin_icon(array('icon'=>'contract.gif','class'=>"hier_contract"),$_smarty_tpl);?>

	    </a>
	    <?php } elseif ($_smarty_tpl->tpl_vars['row']->value['expand'] == 'closed') {?>
	      <a href="<?php echo smarty_cms_function_cms_action_url(array('action'=>'defaultadmin','expand'=>$_smarty_tpl->tpl_vars['row']->value['id']),$_smarty_tpl);?>
" class="page_expand" accesskey="c" title="<?php echo $_smarty_tpl->tpl_vars['mod']->value->Lang('prompt_page_expand');?>
"><?php echo smarty_function_admin_icon(array('icon'=>'expand.gif','class'=>"hier_expand"),$_smarty_tpl);?>
</a>
	    <?php }?>
	  <?php } elseif ($_smarty_tpl->tpl_vars['column']->value == 'icon1') {?>
	    <?php if (isset($_smarty_tpl->tpl_vars['row']->value['lock'])) {?>
	      <?php echo smarty_function_admin_icon(array('icon'=>'warning.gif','title'=>$_smarty_tpl->tpl_vars['mod']->value->Lang('title_locked')),$_smarty_tpl);?>

	    <?php }?>
	  <?php } elseif ($_smarty_tpl->tpl_vars['column']->value == 'hier') {?>
	    <?php echo $_smarty_tpl->tpl_vars['row']->value['hier'];?>

	  <?php } elseif ($_smarty_tpl->tpl_vars['column']->value == 'page') {?>
	    <?php if ($_smarty_tpl->tpl_vars['row']->value['can_edit']) {?>
	      <?php if ($_smarty_tpl->tpl_vars['indent']->value) {
echo smarty_function_repeat(array('string'=>'-&nbsp;&nbsp;','times'=>$_smarty_tpl->tpl_vars['row']->value['depth']-2),$_smarty_tpl);
}?>
	      
	      <?php $_smarty_tpl->smarty->ext->_capture->open($_smarty_tpl, 'default', 'tooltip_pageinfo', null);?><strong><?php echo $_smarty_tpl->tpl_vars['mod']->value->Lang('prompt_content_id');?>
:</strong> <?php echo $_smarty_tpl->tpl_vars['row']->value['id'];?>
<br/><strong><?php echo $_smarty_tpl->tpl_vars['mod']->value->Lang('prompt_title');?>
:</strong> <?php echo htmlspecialchars($_smarty_tpl->tpl_vars['row']->value['title'], ENT_QUOTES, 'UTF-8', true);?>
<br/><strong><?php echo $_smarty_tpl->tpl_vars['mod']->value->Lang('prompt_name');?>
: </strong> <?php echo htmlspecialchars($_smarty_tpl->tpl_vars['row']->value['menutext'], ENT_QUOTES, 'UTF-8', true);?>
<br/><?php if (isset($_smarty_tpl->tpl_vars['row']->value['alias'])) {?><strong><?php echo $_smarty_tpl->tpl_vars['mod']->value->Lang('prompt_alias');?>
:</strong> <?php echo $_smarty_tpl->tpl_vars['row']->value['alias'];?>
<br/><?php }
if ($_smarty_tpl->tpl_vars['row']->value['secure']) {?><strong><?php echo $_smarty_tpl->tpl_vars['mod']->value->Lang('prompt_secure');?>
:</strong> <?php echo $_smarty_tpl->tpl_vars['mod']->value->Lang('yes');?>
<br/><?php }?><strong><?php echo $_smarty_tpl->tpl_vars['mod']->value->Lang('prompt_cachable');?>
:</strong> <?php if ($_smarty_tpl->tpl_vars['row']->value['cachable']) {
echo $_smarty_tpl->tpl_vars['mod']->value->Lang('yes');
} else {
echo $_smarty_tpl->tpl_vars['mod']->value->Lang('no');
}?><br/><strong><?php echo $_smarty_tpl->tpl_vars['mod']->value->Lang('prompt_showinmenu');?>
:</strong> <?php if ($_smarty_tpl->tpl_vars['row']->value['showinmenu']) {
echo $_smarty_tpl->tpl_vars['mod']->value->Lang('yes');
} else {
echo $_smarty_tpl->tpl_vars['mod']->value->Lang('no');
}?><br/><strong><?php echo lang('wantschildren');?>
:</strong> <?php if ((($tmp = @$_smarty_tpl->tpl_vars['row']->value['wantschildren'])===null||$tmp==='' ? 1 : $tmp)) {
echo $_smarty_tpl->tpl_vars['mod']->value->Lang('yes');
} else {
echo $_smarty_tpl->tpl_vars['mod']->value->Lang('no');
}
$_smarty_tpl->smarty->ext->_capture->close($_smarty_tpl);?>

	      <a href="<?php echo smarty_cms_function_cms_action_url(array('action'=>'admin_editcontent','content_id'=>$_smarty_tpl->tpl_vars['row']->value['id']),$_smarty_tpl);?>
" class="page_edit tooltip" accesskey="e" data-cms-content='<?php echo $_smarty_tpl->tpl_vars['row']->value['id'];?>
' data-cms-description='<?php echo cms_htmlentities($_smarty_tpl->tpl_vars['tooltip_pageinfo']->value);?>
'><?php echo (($tmp = @$_smarty_tpl->tpl_vars['row']->value['page'])===null||$tmp==='' ? '' : $tmp);?>
</a>
	    <?php } else { ?>
	      <?php if (isset($_smarty_tpl->tpl_vars['row']->value['lock'])) {?>
	        <?php $_smarty_tpl->smarty->ext->_capture->open($_smarty_tpl, 'default', 'tooltip_lockinfo', null);
if ($_smarty_tpl->tpl_vars['row']->value['can_steal']) {?><strong><?php echo $_smarty_tpl->tpl_vars['mod']->value->Lang('locked_steal');?>
:</strong><br/><?php }?><strong><?php echo $_smarty_tpl->tpl_vars['mod']->value->Lang('locked_by');?>
:</strong> <?php echo $_smarty_tpl->tpl_vars['row']->value['lockuser'];?>
<br/><strong><?php echo $_smarty_tpl->tpl_vars['mod']->value->Lang('locked_since');?>
:</strong> <?php echo smarty_modifier_date_format($_smarty_tpl->tpl_vars['row']->value['lock']['created'],'%x %H:%M');?>
<br/><?php if ($_smarty_tpl->tpl_vars['row']->value['lock']['expires'] < time()) {?><span style="color: red;"><strong><?php echo $_smarty_tpl->tpl_vars['mod']->value->Lang('lock_expired');?>
:</strong> <?php echo smarty_modifier_relative_time($_smarty_tpl->tpl_vars['row']->value['lock']['expires']);?>
</span><?php } else { ?><strong><?php echo $_smarty_tpl->tpl_vars['mod']->value->Lang('lock_expires');?>
:</strong> <?php echo smarty_modifier_relative_time($_smarty_tpl->tpl_vars['row']->value['lock']['expires']);
}?><br/><?php $_smarty_tpl->smarty->ext->_capture->close($_smarty_tpl);?>
	        <?php if (!$_smarty_tpl->tpl_vars['row']->value['can_steal']) {?>
	          <span class="tooltip" data-cms-description='<?php echo htmlentities($_smarty_tpl->tpl_vars['tooltip_lockinfo']->value);?>
'><?php echo $_smarty_tpl->tpl_vars['row']->value['page'];?>
</span>
	        <?php } else { ?>
	          <a href="<?php echo smarty_cms_function_cms_action_url(array('action'=>'admin_editcontent','content_id'=>$_smarty_tpl->tpl_vars['row']->value['id']),$_smarty_tpl);?>
" class="page_edit tooltip steal_lock" accesskey="e" data-cms-content='<?php echo $_smarty_tpl->tpl_vars['row']->value['id'];?>
' data-cms-description='<?php echo htmlentities($_smarty_tpl->tpl_vars['tooltip_lockinfo']->value);?>
'><?php echo $_smarty_tpl->tpl_vars['row']->value['page'];?>
</a>
	        <?php }?>
	      <?php } else { ?>
	        <?php echo $_smarty_tpl->tpl_vars['row']->value['page'];?>

	      <?php }?>
	    <?php }?>
	  <?php } elseif ($_smarty_tpl->tpl_vars['column']->value == 'alias') {?>
	    <?php echo (($tmp = @$_smarty_tpl->tpl_vars['row']->value['alias'])===null||$tmp==='' ? '' : $tmp);?>

	  <?php } elseif ($_smarty_tpl->tpl_vars['column']->value == 'url') {?>
	    <?php if ($_smarty_tpl->tpl_vars['prettyurls_ok']->value) {?>
	      <?php echo $_smarty_tpl->tpl_vars['row']->value['url'];?>

	    <?php } else { ?>
	      <span class="text-red"><?php echo $_smarty_tpl->tpl_vars['row']->value['url'];?>
</span>
	    <?php }?>
	  <?php } elseif ($_smarty_tpl->tpl_vars['column']->value == 'template') {?>
	    <?php if (isset($_smarty_tpl->tpl_vars['row']->value['template']) && $_smarty_tpl->tpl_vars['row']->value['template'] != '') {?>
	      <?php if ($_smarty_tpl->tpl_vars['row']->value['can_edit_tpl']) {?>
	        <a href="<?php echo smarty_cms_function_cms_action_url(array('module'=>'DesignManager','action'=>'admin_edit_template','tpl'=>$_smarty_tpl->tpl_vars['row']->value['template_id']),$_smarty_tpl);?>
" class="page_template" title="<?php echo $_smarty_tpl->tpl_vars['mod']->value->Lang('prompt_page_template');?>
">
		  <?php echo $_smarty_tpl->tpl_vars['row']->value['template'];?>

		</a>
	      <?php } else { ?>
	        <?php echo $_smarty_tpl->tpl_vars['row']->value['template'];?>

	      <?php }?>
	    <?php } elseif ($_smarty_tpl->tpl_vars['row']->value['viewable']) {?>
	      <span class="text-red" title="<?php echo $_smarty_tpl->tpl_vars['mod']->value->Lang('error_template_notavailable');?>
"><?php echo $_smarty_tpl->tpl_vars['mod']->value->Lang('critical_error');?>
</span>
	    <?php }?>
	  <?php } elseif ($_smarty_tpl->tpl_vars['column']->value == 'friendlyname') {?>
	    <?php echo $_smarty_tpl->tpl_vars['row']->value['friendlyname'];?>

	  <?php } elseif ($_smarty_tpl->tpl_vars['column']->value == 'owner') {?>
            <?php $_smarty_tpl->smarty->ext->_capture->open($_smarty_tpl, 'default', 'tooltip_ownerinfo', null);?><strong><?php echo $_smarty_tpl->tpl_vars['mod']->value->Lang('prompt_created');?>
:</strong> <?php echo smarty_modifier_cms_date_format($_smarty_tpl->tpl_vars['row']->value['created']);?>
<br/><strong><?php echo $_smarty_tpl->tpl_vars['mod']->value->Lang('prompt_lastmodified');?>
:</strong> <?php echo smarty_modifier_cms_date_format($_smarty_tpl->tpl_vars['row']->value['lastmodified']);?>
<br/><?php if (isset($_smarty_tpl->tpl_vars['row']->value['lastmodifiedby'])) {?><strong><?php echo $_smarty_tpl->tpl_vars['mod']->value->Lang('prompt_lastmodifiedby');?>
:</strong> <?php echo $_smarty_tpl->tpl_vars['row']->value['lastmodifiedby'];?>
<br/><?php }
$_smarty_tpl->smarty->ext->_capture->close($_smarty_tpl);?>
	    <span class="tooltip" data-cms-description='<?php echo htmlentities($_smarty_tpl->tpl_vars['tooltip_ownerinfo']->value);?>
'><?php echo $_smarty_tpl->tpl_vars['row']->value['owner'];?>
</span>
	  <?php } elseif ($_smarty_tpl->tpl_vars['column']->value == 'active') {?>
	    <?php if ($_smarty_tpl->tpl_vars['row']->value['active'] == 'inactive') {?>
	      <a href="<?php echo smarty_cms_function_cms_action_url(array('action'=>'defaultadmin','setactive'=>$_smarty_tpl->tpl_vars['row']->value['id']),$_smarty_tpl);?>
" class="page_setactive" accesskey="a">
	        <?php echo smarty_function_admin_icon(array('icon'=>'false.gif','title'=>$_smarty_tpl->tpl_vars['mod']->value->Lang('prompt_page_setactive')),$_smarty_tpl);?>

	      </a>
	    <?php } elseif ($_smarty_tpl->tpl_vars['row']->value['active'] != 'default' && $_smarty_tpl->tpl_vars['row']->value['active'] != '') {?>
	      <a href="<?php echo smarty_cms_function_cms_action_url(array('action'=>'defaultadmin','setinactive'=>$_smarty_tpl->tpl_vars['row']->value['id']),$_smarty_tpl);?>
" class="page_setinactive" accesskey="a">
	  	<?php echo smarty_function_admin_icon(array('icon'=>'true.gif','title'=>$_smarty_tpl->tpl_vars['mod']->value->Lang('prompt_page_setinactive')),$_smarty_tpl);?>

	      </a>
	    <?php }?>
	  <?php } elseif ($_smarty_tpl->tpl_vars['column']->value == 'default') {?>
	    <?php if ($_smarty_tpl->tpl_vars['row']->value['default'] == 'yes') {?>
	      <?php echo smarty_function_admin_icon(array('icon'=>'true.gif','class'=>'page_default','title'=>$_smarty_tpl->tpl_vars['mod']->value->Lang('prompt_page_default')),$_smarty_tpl);?>

	    <?php } elseif ($_smarty_tpl->tpl_vars['row']->value['default'] == 'no' && $_smarty_tpl->tpl_vars['row']->value['can_edit']) {?>
	      <a href="<?php echo smarty_cms_function_cms_action_url(array('action'=>'defaultadmin','setdefault'=>$_smarty_tpl->tpl_vars['row']->value['id']),$_smarty_tpl);?>
" class="page_setdefault" accesskey="d">
	   	<?php echo smarty_function_admin_icon(array('icon'=>'false.gif','class'=>'page_setdefault','title'=>$_smarty_tpl->tpl_vars['mod']->value->Lang('prompt_page_setdefault')),$_smarty_tpl);?>

	      </a>
	    <?php }?>
          <?php } elseif ($_smarty_tpl->tpl_vars['column']->value == 'importseo') {?>
                <?php $_smarty_tpl->_assignInScope('foo', explode("|",$_smarty_tpl->tpl_vars['row']->value['importseo']));
?>
                <?php if ($_smarty_tpl->tpl_vars['row']->value['importseo'] == 'Empty') {?>
                <a href="<?php echo smarty_cms_function_cms_action_url(array('action'=>'admin_ajax_importseo','alias'=>$_smarty_tpl->tpl_vars['row']->value['alias']),$_smarty_tpl);?>
" accesskey="s">
                    <?php echo smarty_function_admin_icon(array('icon'=>'back.gif'),$_smarty_tpl);?>

                </a>
                <?php } elseif ($_smarty_tpl->tpl_vars['foo']->value[0] == 'Exist') {?>
                <a href="<?php echo smarty_cms_function_cms_action_url(array('module'=>'LISESEO','action'=>'admin_edititem','item_id'=>$_smarty_tpl->tpl_vars['foo']->value[1]),$_smarty_tpl);?>
" accesskey="s" target="_blank">
                    <?php echo smarty_function_admin_icon(array('icon'=>'run.gif'),$_smarty_tpl);?>

                </a>
                <?php } elseif ($_smarty_tpl->tpl_vars['foo']->value[0] == 'Done') {?>
                <a href="<?php echo smarty_cms_function_cms_action_url(array('module'=>'LISESEO','action'=>'admin_edititem','item_id'=>$_smarty_tpl->tpl_vars['foo']->value[1]),$_smarty_tpl);?>
" accesskey="s" target="_blank">
                    <?php echo smarty_function_admin_icon(array('icon'=>'accept.gif'),$_smarty_tpl);?>

                </a>
                <?php }?>
	  <?php } elseif ($_smarty_tpl->tpl_vars['column']->value == 'move') {?>
	    <?php if (isset($_smarty_tpl->tpl_vars['row']->value['move'])) {?>
	      <?php if ($_smarty_tpl->tpl_vars['row']->value['move'] == 'up') {?>
		<a href="<?php echo smarty_cms_function_cms_action_url(array('action'=>'defaultadmin','moveup'=>$_smarty_tpl->tpl_vars['row']->value['id']),$_smarty_tpl);?>
" class="page_sortup" accesskey="m">
	  	  <?php echo smarty_function_admin_icon(array('icon'=>'sort_up.gif','title'=>$_smarty_tpl->tpl_vars['mod']->value->Lang('prompt_page_sortup')),$_smarty_tpl);?>

		</a>
	      <?php } elseif ($_smarty_tpl->tpl_vars['row']->value['move'] == 'down') {?>
	    	<a href="<?php echo smarty_cms_function_cms_action_url(array('action'=>'defaultadmin','movedown'=>$_smarty_tpl->tpl_vars['row']->value['id']),$_smarty_tpl);?>
" class="page_sortdown" accesskey="m">
		  <?php echo smarty_function_admin_icon(array('icon'=>'sort_down.gif','title'=>$_smarty_tpl->tpl_vars['mod']->value->Lang('prompt_page_sortdown')),$_smarty_tpl);?>

		</a>
	      <?php } elseif ($_smarty_tpl->tpl_vars['row']->value['move'] == 'both') {?>
		<a href="<?php echo smarty_cms_function_cms_action_url(array('action'=>'defaultadmin','moveup'=>$_smarty_tpl->tpl_vars['row']->value['id']),$_smarty_tpl);?>
" class="page_sortup" accesskey="m"><?php echo smarty_function_admin_icon(array('icon'=>'sort_up.gif','title'=>$_smarty_tpl->tpl_vars['mod']->value->Lang('prompt_page_sortup')),$_smarty_tpl);?>
</a>
		<a href="<?php echo smarty_cms_function_cms_action_url(array('action'=>'defaultadmin','movedown'=>$_smarty_tpl->tpl_vars['row']->value['id']),$_smarty_tpl);?>
" class="page_sortdown" accesskey="m"><?php echo smarty_function_admin_icon(array('icon'=>'sort_down.gif','title'=>$_smarty_tpl->tpl_vars['mod']->value->Lang('prompt_page_sortdown')),$_smarty_tpl);?>
</a>
	      <?php }?>
	    <?php }?>
	  <?php } elseif ($_smarty_tpl->tpl_vars['column']->value == 'view') {?>
	    <?php if ($_smarty_tpl->tpl_vars['row']->value['view'] != '') {?>
	      <a class="page_view" target="_blank" href="<?php echo $_smarty_tpl->tpl_vars['row']->value['view'];?>
" accesskey="v">
		<?php echo smarty_function_admin_icon(array('icon'=>'view.gif','title'=>$_smarty_tpl->tpl_vars['mod']->value->Lang('prompt_page_view')),$_smarty_tpl);?>

	      </a>
	    <?php }?>
	  <?php } elseif ($_smarty_tpl->tpl_vars['column']->value == 'copy') {?>
	    <?php if ($_smarty_tpl->tpl_vars['row']->value['copy'] != '') {?>
	      <a href="<?php echo smarty_cms_function_cms_action_url(array('action'=>'admin_copycontent','page'=>$_smarty_tpl->tpl_vars['row']->value['id']),$_smarty_tpl);?>
" accesskey="o">
		<?php echo smarty_function_admin_icon(array('icon'=>'copy.gif','class'=>'page_copy','title'=>$_smarty_tpl->tpl_vars['mod']->value->Lang('prompt_page_copy')),$_smarty_tpl);?>

	      </a>
	     <?php }?>
	  <?php } elseif ($_smarty_tpl->tpl_vars['column']->value == 'edit') {?>
	    <?php if ($_smarty_tpl->tpl_vars['row']->value['can_edit']) {?>
	      <a href="<?php echo smarty_cms_function_cms_action_url(array('action'=>'admin_editcontent','content_id'=>$_smarty_tpl->tpl_vars['row']->value['id']),$_smarty_tpl);?>
" accesskey="e" class="page_edit" title="<?php echo $_smarty_tpl->tpl_vars['mod']->value->Lang('addcontent');?>
" data-cms-content="<?php echo $_smarty_tpl->tpl_vars['row']->value['id'];?>
">
		<?php echo smarty_function_admin_icon(array('icon'=>'edit.gif','class'=>'page_edit','title'=>$_smarty_tpl->tpl_vars['mod']->value->Lang('prompt_page_edit')),$_smarty_tpl);?>

	      </a>
	    <?php } else { ?>
	      <?php if (isset($_smarty_tpl->tpl_vars['row']->value['lock']) && $_smarty_tpl->tpl_vars['row']->value['can_steal']) {?>
		<a href="<?php echo smarty_cms_function_cms_action_url(array('action'=>'admin_editcontent','content_id'=>$_smarty_tpl->tpl_vars['row']->value['id']),$_smarty_tpl);?>
" accesskey="e" class="page_edit" title="<?php echo $_smarty_tpl->tpl_vars['mod']->value->Lang('addcontent');?>
" data-cms-content="<?php echo $_smarty_tpl->tpl_vars['row']->value['id'];?>
" class="steal_lock">
		  <?php echo smarty_function_admin_icon(array('icon'=>'permissions.gif','class'=>'page_edit steal_lock','title'=>$_smarty_tpl->tpl_vars['mod']->value->Lang('prompt_steal_lock_edit')),$_smarty_tpl);?>

		</a>
	      <?php }?>
	    <?php }?>
	  <?php } elseif ($_smarty_tpl->tpl_vars['column']->value == 'delete') {?>
	    <?php if ($_smarty_tpl->tpl_vars['row']->value['can_delete'] && $_smarty_tpl->tpl_vars['row']->value['delete'] != '') {?>
	      <a href="<?php echo smarty_cms_function_cms_action_url(array('action'=>'defaultadmin','delete'=>$_smarty_tpl->tpl_vars['row']->value['id']),$_smarty_tpl);?>
" class="page_delete" accesskey="r">
		<?php echo smarty_function_admin_icon(array('icon'=>'delete.gif','class'=>'page_delete','title'=>$_smarty_tpl->tpl_vars['mod']->value->Lang('prompt_page_delete')),$_smarty_tpl);?>

	       </a>
	    <?php }?>
	  <?php } elseif ($_smarty_tpl->tpl_vars['column']->value == 'multiselect') {?>
	    <?php if ($_smarty_tpl->tpl_vars['row']->value['multiselect'] != '') {?>
	      <label class="invisible" for="multicontent-<?php echo $_smarty_tpl->tpl_vars['row']->value['id'];?>
"><?php echo $_smarty_tpl->tpl_vars['mod']->value->Lang('prompt_multiselect_toggle');?>
</label>
	      <input type="checkbox" id="multicontent-<?php echo $_smarty_tpl->tpl_vars['row']->value['id'];?>
" class="multicontent" name="<?php echo $_smarty_tpl->tpl_vars['actionid']->value;?>
multicontent[]" value="<?php echo $_smarty_tpl->tpl_vars['row']->value['id'];?>
" title="<?php echo $_smarty_tpl->tpl_vars['mod']->value->Lang('prompt_multiselect_toggle');?>
"/>
	    <?php }?>
	  <?php } else { ?>
	    
	  <?php }?>
	</td>
      <?php
}
}
$_smarty_tpl->smarty->ext->_foreach->restore($_smarty_tpl, 1);
?>

    <?php
}}
/*/ smarty_template_function_do_content_row_298485a5f971b6b68e6_77257285 */
}
