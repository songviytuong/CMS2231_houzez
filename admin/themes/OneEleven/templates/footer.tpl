{strip}
    <footer id="oe_footer" class="cf">
        <div class="footer-left">
            <small class="copyright">Copyright &copy; <a rel="external" href="{root_url}">{sitename}&trade;</a> - All right reserved.</small>
        </div>
        <div class="footer-right cf">
            <ul class="links">
                <li><a data-href="{$clear_link}" id="clear">{admin_icon icon="reload.png"}</a></li>
            </ul>
        </div>
    </footer>
{/strip}

{literal}
    <script type="text/javascript">
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
    </script>
{/literal}