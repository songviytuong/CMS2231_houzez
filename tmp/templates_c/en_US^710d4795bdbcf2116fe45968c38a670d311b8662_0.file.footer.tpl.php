<?php
/* Smarty version 3.1.31, created on 2018-01-18 02:18:22
  from "E:\xampp\htdocs\public_html\cms_version2\cms2231_houzez\admin\themes\OneEleven\templates\footer.tpl" */

/* @var Smarty_Internal_Template $_smarty_tpl */
if ($_smarty_tpl->_decodeProperties($_smarty_tpl, array (
  'version' => '3.1.31',
  'unifunc' => 'content_5a5f936e018092_93034901',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    '710d4795bdbcf2116fe45968c38a670d311b8662' => 
    array (
      0 => 'E:\\xampp\\htdocs\\public_html\\cms_version2\\cms2231_houzez\\admin\\themes\\OneEleven\\templates\\footer.tpl',
      1 => 1514740692,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
  ),
),false)) {
function content_5a5f936e018092_93034901 (Smarty_Internal_Template $_smarty_tpl) {
if (!is_callable('smarty_function_root_url')) require_once 'E:\\xampp\\htdocs\\public_html\\cms_version2\\cms2231_houzez\\lib\\plugins\\function.root_url.php';
if (!is_callable('smarty_function_sitename')) require_once 'E:\\xampp\\htdocs\\public_html\\cms_version2\\cms2231_houzez\\lib\\plugins\\function.sitename.php';
if (!is_callable('smarty_function_admin_icon')) require_once 'E:\\xampp\\htdocs\\public_html\\cms_version2\\cms2231_houzez\\admin\\plugins\\function.admin_icon.php';
?>
<footer id="oe_footer" class="cf"><div class="footer-left"><small class="copyright">Copyright &copy; <a rel="external" href="<?php echo smarty_function_root_url(array(),$_smarty_tpl);?>
"><?php echo smarty_function_sitename(array(),$_smarty_tpl);?>
&trade;</a> - All right reserved.</small></div><div class="footer-right cf"><ul class="links"><li><a data-href="<?php echo $_smarty_tpl->tpl_vars['clear_link']->value;?>
" id="clear"><?php echo smarty_function_admin_icon(array('icon'=>"reload.png"),$_smarty_tpl);?>
</a></li></ul></div></footer>


    <?php echo '<script'; ?>
 type="text/javascript">
        $(document).keyup(function(e) {
            if(e.keyCode === 27) {
                $('#clear').click();
            }
        });
        (function($){
            $('#clear').click(function(ev) {
                cms_busy();
                $('.busy').attr('style', 'display:block;');
                var _hr = $(this).attr('data-href');
                $.ajax({
                    type: 'POST',
                    url: _hr,
                    cache: false,
                    async: false,
                    success: function(res) {
                        ev.preventDefault();
                        setTimeout(function() {
                            $('.busy').attr('style', 'display:none;');
                        }, 1000);
                    }
                });
            })
        })(jQuery);
    <?php echo '</script'; ?>
>
<?php }
}
