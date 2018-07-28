jQuery(document).ready(function($) {

	$(".sort_table").tableDnD({
	
		onDragClass: "row1hover",
		onDrop: function(table, row) {
			var totalrows = jQuery(".sort_table").find("tbody tr").size();

			jQuery(".sort_table").find("tbody tr").removeClass();
			jQuery(".sort_table").find("tbody tr:nth-child(2n+1)").addClass("row1");
			jQuery(".sort_table").find("tbody tr:nth-child(2n)").addClass("row2");

			var rows = table.tBodies[0].rows;
			var sortstr = rows[0].id;
			for (var i=1; i<rows.length; i++) {
				sortstr += ","+rows[i].id;
			}

			$('.sortseq').val(sortstr);
			$('.sort_save').effect('pulsate',{times:3},200);
		}
	});
	jQuery(".updown").hide();
});