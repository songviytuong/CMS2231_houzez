// an extension on the jquery ui datepicker, for localization purposes
(function($) {
    $.datepicker.setDefaults({
	currentText: '{$mod->Lang('dp_today')}',
	closeText: '{$mod->Lang('dp_close')}',
	buttonText: '{$mod->Lang('db_choose')}',
	nextText: '{$mod->Lang('db_next')}',
	prevText: '{$mod->Lang('db_prev')}',
	dateFormat: '{$dateformat}',
	dayNames: {json_encode($localeInfo.dayNames)},
	dayNamesShort: {json_encode($localeInfo.dayNamesShort)},
	monthNames: {json_encode($localeInfo.monthNames)},
	monthNamesShort: {json_encode($localeInfo.monthNamesShort)},
	numberOfMonths: 3,
	showCurrentAtPos: 1,
	showButtonPanel: true,
	changeYear: true,
	yearRange: 'c-10:c+10'
    });
}) (jQuery);
