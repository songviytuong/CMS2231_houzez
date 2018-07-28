{literal}
<script type="text/javascript" src="../modules/CustomGS/lib/jquery/jquery.cookie.js"></script>
<script type="text/javascript" src="../modules/CustomGS/lib/jquery/jquery.collapsible.js"></script>
<script type="text/javascript" src="../modules/CustomGS/lib/jquery/jquery-ui-timepicker-addon.js"></script>
<script type="text/javascript" src="../modules/CustomGS/lib/jquery/colorpicker.min.js"></script>
<script type="text/javascript">
		$(function() {
			$('.cgs_collapsible').collapsible({
				cookieName: 'collapsible'
			});
{/literal}{$DP_locale}{literal}
			$('.datepicker input').datepicker({
				dateFormat: 'yy-mm-dd',
				showOtherMonths: true,
				selectOtherMonths: true
			});
			$('.datetimepicker input').datetimepicker({
				dateFormat: 'yy-mm-dd',
				showOtherMonths: true,
				selectOtherMonths: true
			});
			$('.timepicker input').timepicker({});
			$('.inputcolorpicker input').ColorPicker({
				onSubmit: function(hsb, hex, rgb, el, parent) {
					$(el).val(hex);
					$(el).ColorPickerHide();
				},
				onBeforeShow: function () {
					$(this).ColorPickerSetColor(this.value);
				}
			})
			.on('keyup', function(){
		$(this).ColorPickerSetColor(this.value);
			});
		});
</script>
{/literal}
