<?php
/* Smarty version 3.1.31, created on 2018-01-18 02:34:00
  from "module_file_tpl:CMSContentManager;defaultadmin.tpl" */

/* @var Smarty_Internal_Template $_smarty_tpl */
if ($_smarty_tpl->_decodeProperties($_smarty_tpl, array (
  'version' => '3.1.31',
  'unifunc' => 'content_5a5f971884a3a7_34231198',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    'f4633eae2310bc9506d585f8254b901e37136a75' => 
    array (
      0 => 'module_file_tpl:CMSContentManager;defaultadmin.tpl',
      1 => 1514740891,
      2 => 'module_file_tpl',
    ),
  ),
  'includes' => 
  array (
  ),
),false)) {
function content_5a5f971884a3a7_34231198 (Smarty_Internal_Template $_smarty_tpl) {
if (!is_callable('smarty_cms_function_cms_action_url')) require_once 'E:\\xampp\\htdocs\\public_html\\cms_version2\\cms2231_houzez\\lib\\plugins\\function.cms_action_url.php';
if (!is_callable('smarty_function_form_start')) require_once 'E:\\xampp\\htdocs\\public_html\\cms_version2\\cms2231_houzez\\lib\\plugins\\function.form_start.php';
if (!is_callable('smarty_function_html_options')) require_once 'E:\\xampp\\htdocs\\public_html\\cms_version2\\cms2231_houzez\\lib\\smarty\\plugins\\function.html_options.php';
if (!is_callable('smarty_function_form_end')) require_once 'E:\\xampp\\htdocs\\public_html\\cms_version2\\cms2231_houzez\\lib\\plugins\\function.form_end.php';
if (isset($_smarty_tpl->tpl_vars['activelang']->value)) {
echo $_smarty_tpl->tpl_vars['langList']->value;
}?>

<?php if ($_smarty_tpl->tpl_vars['ajax']->value == 0) {?>
  <?php echo '<script'; ?>
 type="text/javascript">
  //<![CDATA[
  function cms_CMloadUrl(link, lang) {
      $(document).on('click', link, function (e) {
          var url = $(this).attr('href') + '&showtemplate=false&<?php echo $_smarty_tpl->tpl_vars['actionid']->value;?>
ajax=1';

          var _do_ajax = function() {
	     $.ajax({
	        url: url,
	     }).done(function(){
 	        $('#content_area').autoRefresh('refresh').done(function(){
		    console.debug('after refresh');
		});
	     })
	  }

	  e.preventDefault();
	  $('#ajax_find').val('');

          if (typeof lang == 'string' && lang.length > 0) {
	      cms_confirm(lang).done(_do_ajax);
	  } else {
	     _do_ajax();
	  }
      });
  }


  function cms_CMtoggleState(el) {
      $(el).attr('disabled', true);
      $('button' + el).button({ 'disabled' : true });

      $(document).on('click', 'input:checkbox', function () {
          if ($('input:checkbox').is(':checked')) {
              $(el).attr('disabled', false);
              $('button' + el).button({ 'disabled' : false });
          } else {
              $(el).attr('disabled', true);
              $('button' + el).button({ 'disabled' : true });
          }
     });
  }

  $(document).ready(function () {
      cms_busy();
      $('#content_area').autoRefresh({
          url: '<?php echo $_smarty_tpl->tpl_vars['ajax_get_content']->value;?>
',
	  done_handler: function() {
	        $('#ajax_find').autocomplete({
			source: '<?php echo smarty_cms_function_cms_action_url(array('action'=>'admin_ajax_pagelookup','forjs'=>1),$_smarty_tpl);?>
&showtemplate=false',
			minLength: 2,
			position: {
              			  my: "right top",
				  at: "right bottom"
                        },
			change: function (event, ui)  {
			    // goes back to the full list, no options
			    $('#ajax_find').val('');
    		            $('#content_area').autoRefresh('option','url','<?php echo $_smarty_tpl->tpl_vars['ajax_get_content']->value;?>
');
			},
                        select: function (event, ui) {
                            event.preventDefault();
                            $(this).val(ui.item.label);
                            var url = '<?php echo smarty_cms_function_cms_action_url(array('action'=>'ajax_get_content','forjs'=>1),$_smarty_tpl);?>
&showtemplate=false&<?php echo $_smarty_tpl->tpl_vars['actionid']->value;?>
seek=' + ui.item.value;
			    $('#content_area').autoRefresh('option','url',url).autoRefresh('refresh').done(function(){
			       $('html,body').animate({
			          scrollTop: $('#row_'+ui.item.value).offset().top
			       });
			    })
                        }
                });
	  }
      });

      $('#selectall').cmsms_checkall({
          target: '#contenttable'
      });

      cms_CMtoggleState('#multiaction'),
      cms_CMtoggleState('#multisubmit'),

      // these links can't use ajax as they effect pagination.
      //cms_CMloadUrl('a.expandall'),
      //cms_CMloadUrl('a.collapseall'),
      //cms_CMloadUrl('a.page_collapse'),
      //cms_CMloadUrl('a.page_expand'),

      cms_CMloadUrl('a.page_sortup'),
      cms_CMloadUrl('a.page_sortdown'),
      cms_CMloadUrl('a.page_setinactive', '<?php echo strtr($_smarty_tpl->tpl_vars['mod']->value->Lang('confirm_setinactive'), array("\\" => "\\\\", "'" => "\\'", "\"" => "\\\"", "\r" => "\\r", "\n" => "\\n", "</" => "<\/" ));?>
'),
      cms_CMloadUrl('a.page_setactive'),
      cms_CMloadUrl('a.page_setdefault', '<?php echo strtr($_smarty_tpl->tpl_vars['mod']->value->Lang('confirm_setdefault'), array("\\" => "\\\\", "'" => "\\'", "\"" => "\\\"", "\r" => "\\r", "\n" => "\\n", "</" => "<\/" ));?>
'),
      cms_CMloadUrl('a.page_delete', '<?php echo strtr($_smarty_tpl->tpl_vars['mod']->value->Lang('confirm_delete_page'), array("\\" => "\\\\", "'" => "\\'", "\"" => "\\\"", "\r" => "\\r", "\n" => "\\n", "</" => "<\/" ));?>
');

      $('a.steal_lock').on('click',function(e) {
          // we're gonna confirm stealing this lock.
	  e.preventDefault();
	  var self = $(this);
	  var url = $(this).attr('href')+'<?php echo $_smarty_tpl->tpl_vars['actionid']->value;?>
steal=1';
          cms_confirm('<?php echo strtr($_smarty_tpl->tpl_vars['mod']->value->Lang('confirm_steal_lock'), array("\\" => "\\\\", "'" => "\\'", "\"" => "\\\"", "\r" => "\\r", "\n" => "\\n", "</" => "<\/" ));?>
').done(function(){
	      window.location.href = url;
	  });
      });

      $('a.page_edit').on('click',function(event) {
          var v = $(this).data('steal_lock');
          $(this).removeData('steal_lock');
          if( typeof(v) != 'undefined' && v != null && !v ) return false;
          if( typeof(v) == 'undefined' || v != null ) return true;

          // do a double check to see if this page is locked or not.
          var content_id = $(this).attr('data-cms-content');
          var url = '<?php echo $_smarty_tpl->tpl_vars['admin_url']->value;?>
/ajax_lock.php?showtemplate=false';
          var opts = { opt: 'check', type: 'content', oid: content_id };
          var ok = false;
          opts[cms_data.secure_param_name] = cms_data.user_key;
          $.ajax({
              url: url,
              data: opts,
              success: function(data,textStatus,jqXHR) {
             }
          }).done(data,function(){
              if( data.status == 'success' ) {
                  if( data.locked ) {
                      // gotta display a message.
		      event.preventDefault();
	              cms_alert('<?php echo strtr($_smarty_tpl->tpl_vars['mod']->value->Lang('error_contentlocked'), array("\\" => "\\\\", "'" => "\\'", "\"" => "\\\"", "\r" => "\\r", "\n" => "\\n", "</" => "<\/" ));?>
');
                  }
              }
	  });
      });

      // filter dialog
      $('#filter_type').change(function(){
         var map = {
	    'DESIGN_ID': '#filter_design',
	    'TEMPLATE_ID': '#filter_template',
	    'OWNER_UID': '#filter_owner',
	    'EDITOR_UID': '#filter_editor'
	 }
         var v = $(this).val();
	 $('.filter_fld').hide();
	 $(map[v]).show();
      })
      $('#filter_type').trigger('change');
      $(document).on('click', '#myoptions', function () {
          $('#useroptions').dialog({
	      minWidth: '600',
	      minHeight: 225,
              resizable: false,
              buttons: {
                  '<?php echo strtr($_smarty_tpl->tpl_vars['mod']->value->Lang('submit'), array("\\" => "\\\\", "'" => "\\'", "\"" => "\\\"", "\r" => "\\r", "\n" => "\\n", "</" => "<\/" ));?>
': function () {
                      $(this).dialog('close');
                      $('#myoptions_form').submit();
                  },
                  '<?php echo strtr($_smarty_tpl->tpl_vars['mod']->value->Lang('cancel'), array("\\" => "\\\\", "'" => "\\'", "\"" => "\\\"", "\r" => "\\r", "\n" => "\\n", "</" => "<\/" ));?>
': function () {
                      $(this).dialog('close');
                  },
              }
          });
      });

      // other events
      $(document).on('change','#selectall,input.multicontent',function() {
          $('#content_area').autoRefresh('reset');
      });

      $(document).on('keypress','#ajax_find',function (e) {
          $('#content_area').autoRefresh('reset');
          if (e.which == 13) e.preventDefault();
      });

      // go to page on option change
      $(document).on('change', '#<?php echo $_smarty_tpl->tpl_vars['actionid']->value;?>
curpage', function () {
          $(this).closest('form').submit();
      })

      $(document).ajaxComplete(function () {
            $('#selectall').cmsms_checkall();
            $('tr.selected').css('background', 'yellow');
            initAjax();
            initAjaxEvents();
      });

      $(document).on('click','a#clearlocks',function(ev){
         var self = $(this);
	 ev.preventDefault();
         cms_confirm('<?php echo strtr($_smarty_tpl->tpl_vars['mod']->value->Lang('confirm_clearlocks'), array("\\" => "\\\\", "'" => "\\'", "\"" => "\\\"", "\r" => "\\r", "\n" => "\\n", "</" => "<\/" ));?>
').done(function(){
	    window.location = self.attr('href');
	 });
      });

      $(document).on('click','a#ordercontent',function(e){
          var have_locks = <?php echo $_smarty_tpl->tpl_vars['have_locks']->value;?>
;
          if( !have_locks ) {
              // double check to see if anything is locked
              var content_id = $(this).attr('data-cms-content');
   	      var url = '<?php echo $_smarty_tpl->tpl_vars['admin_url']->value;?>
/ajax_lock.php?showtemplate=false';
              var opts = { opt: 'check', type: 'content' };
              var ok = false;
              opts[cms_data.secure_param_name] = cms_data.user_key;
              $.ajax({
                  url: url,
                  async: false,
                  data: opts,
                  success: function(data,textStatus,jqXHR) {
	              if( data.status != 'success' ) return;
	              if( data.locked ) have_locks = true;
	          }
              });
          }
          if( have_locks ) {
	      e.preventDefault();
              cms_alert('<?php echo strtr($_smarty_tpl->tpl_vars['mod']->value->Lang('error_action_contentlocked'), array("\\" => "\\\\", "'" => "\\'", "\"" => "\\\"", "\r" => "\\r", "\n" => "\\n", "</" => "<\/" ));?>
');
          }
      })
  });
  //]]>
  <?php echo '</script'; ?>
>

	<div id="useroptions" style="display: none;" title="<?php echo $_smarty_tpl->tpl_vars['mod']->value->Lang('title_userpageoptions');?>
">
    <?php echo smarty_function_form_start(array('action'=>'defaultadmin','id'=>'myoptions_form'),$_smarty_tpl);?>

		<div class="c_full cf">
			<input type="hidden" name="<?php echo $_smarty_tpl->tpl_vars['actionid']->value;?>
setoptions" value="1"/>
			<label class="grid_4"><?php echo $_smarty_tpl->tpl_vars['mod']->value->Lang('prompt_pagelimit');?>
:</label>
			<select name="<?php echo $_smarty_tpl->tpl_vars['actionid']->value;?>
pagelimit" class="grid_7">
				<?php echo smarty_function_html_options(array('options'=>$_smarty_tpl->tpl_vars['pagelimits']->value,'selected'=>$_smarty_tpl->tpl_vars['pagelimit']->value),$_smarty_tpl);?>

			</select>
		</div>
		<?php if ($_smarty_tpl->tpl_vars['can_manage_content']->value) {?>
			<?php $_smarty_tpl->_assignInScope('type', '');
$_smarty_tpl->_assignInScope('expr', '');
?>
			<?php $_smarty_tpl->_assignInScope('opts', array());
?>
			<?php $_tmp_array = isset($_smarty_tpl->tpl_vars['opts']) ? $_smarty_tpl->tpl_vars['opts']->value : array();
if (!is_array($_tmp_array) || $_tmp_array instanceof ArrayAccess) {
settype($_tmp_array, 'array');
}
$_tmp_array[''] = $_smarty_tpl->tpl_vars['mod']->value->Lang('none');
$_smarty_tpl->_assignInScope('opts', $_tmp_array);
?>
			<?php $_tmp_array = isset($_smarty_tpl->tpl_vars['opts']) ? $_smarty_tpl->tpl_vars['opts']->value : array();
if (!is_array($_tmp_array) || $_tmp_array instanceof ArrayAccess) {
settype($_tmp_array, 'array');
}
$_tmp_array['DESIGN_ID'] = $_smarty_tpl->tpl_vars['mod']->value->Lang('prompt_design');
$_smarty_tpl->_assignInScope('opts', $_tmp_array);
?>
			<?php $_tmp_array = isset($_smarty_tpl->tpl_vars['opts']) ? $_smarty_tpl->tpl_vars['opts']->value : array();
if (!is_array($_tmp_array) || $_tmp_array instanceof ArrayAccess) {
settype($_tmp_array, 'array');
}
$_tmp_array['TEMPLATE_ID'] = $_smarty_tpl->tpl_vars['mod']->value->Lang('prompt_template');
$_smarty_tpl->_assignInScope('opts', $_tmp_array);
?>
			<?php $_tmp_array = isset($_smarty_tpl->tpl_vars['opts']) ? $_smarty_tpl->tpl_vars['opts']->value : array();
if (!is_array($_tmp_array) || $_tmp_array instanceof ArrayAccess) {
settype($_tmp_array, 'array');
}
$_tmp_array['OWNER_UID'] = $_smarty_tpl->tpl_vars['mod']->value->Lang('prompt_owner');
$_smarty_tpl->_assignInScope('opts', $_tmp_array);
?>
			<?php $_tmp_array = isset($_smarty_tpl->tpl_vars['opts']) ? $_smarty_tpl->tpl_vars['opts']->value : array();
if (!is_array($_tmp_array) || $_tmp_array instanceof ArrayAccess) {
settype($_tmp_array, 'array');
}
$_tmp_array['EDITOR_UID'] = $_smarty_tpl->tpl_vars['mod']->value->Lang('prompt_editor');
$_smarty_tpl->_assignInScope('opts', $_tmp_array);
?>
			<?php if ($_smarty_tpl->tpl_vars['filter']->value) {
$_smarty_tpl->_assignInScope('type', $_smarty_tpl->tpl_vars['filter']->value->type);
$_smarty_tpl->_assignInScope('expr', $_smarty_tpl->tpl_vars['filter']->value->expr);
}?>
			<div class="c_full cf">
				<label class="grid_4"><?php echo $_smarty_tpl->tpl_vars['mod']->value->Lang('prompt_filter_type');?>
:</label>
				<select name="<?php echo $_smarty_tpl->tpl_vars['actionid']->value;?>
filter_type" class="grid_7" id="filter_type">
					<?php echo smarty_function_html_options(array('options'=>$_smarty_tpl->tpl_vars['opts']->value,'selected'=>$_smarty_tpl->tpl_vars['type']->value),$_smarty_tpl);?>

				</select>
			</div>
			<div class="c_full cf filter_fld" id="filter_design">
				<label class="grid_4"><?php echo $_smarty_tpl->tpl_vars['mod']->value->Lang('prompt_design');?>
:</label>
				<select name="<?php echo $_smarty_tpl->tpl_vars['actionid']->value;?>
filter_design" class="grid_7">
					<?php echo smarty_function_html_options(array('options'=>$_smarty_tpl->tpl_vars['design_list']->value,'selected'=>$_smarty_tpl->tpl_vars['expr']->value),$_smarty_tpl);?>

				</select>
			</div>
			<div class="c_full cf filter_fld" id="filter_template">
				<label class="grid_4"><?php echo $_smarty_tpl->tpl_vars['mod']->value->Lang('prompt_template');?>
:</label>
				<select name="<?php echo $_smarty_tpl->tpl_vars['actionid']->value;?>
filter_template" class="grid_7">
					<?php echo smarty_function_html_options(array('options'=>$_smarty_tpl->tpl_vars['template_list']->value,'selected'=>$_smarty_tpl->tpl_vars['expr']->value),$_smarty_tpl);?>

				</select>
			</div>
			<div class="c_full cf filter_fld" id="filter_owner">
				<label class="grid_4"><?php echo $_smarty_tpl->tpl_vars['mod']->value->Lang('prompt_owner');?>
:</label>
				<select name="<?php echo $_smarty_tpl->tpl_vars['actionid']->value;?>
filter_owner" class="grid_7">
					<?php echo smarty_function_html_options(array('options'=>$_smarty_tpl->tpl_vars['user_list']->value,'selected'=>$_smarty_tpl->tpl_vars['expr']->value),$_smarty_tpl);?>

				</select>
			</div>
			<div class="c_full cf filter_fld" id="filter_editor">
				<label class="grid_4"><?php echo $_smarty_tpl->tpl_vars['mod']->value->Lang('prompt_editor');?>
:</label>
				<select name="<?php echo $_smarty_tpl->tpl_vars['actionid']->value;?>
filter_editor" class="grid_7">
					<?php echo smarty_function_html_options(array('options'=>$_smarty_tpl->tpl_vars['user_list']->value,'selected'=>$_smarty_tpl->tpl_vars['expr']->value),$_smarty_tpl);?>

				</select>
			</div>
		<?php }?>
    <?php echo smarty_function_form_end(array(),$_smarty_tpl);?>

	</div>
	<div class="clearb"></div>

<?php }?>


<div id="content_area"></div>
<?php }
}
