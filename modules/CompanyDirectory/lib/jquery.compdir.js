// encapsulate the jquery ui autocomplete stuff.
(function($) {
  $.fn.compdir_choosecompany = function(options) {
    var opts = $.extend({}, $.fn.compdir_choosecompany.defaults, options);

    var cnt = 1;
    return this.each(function() {
      $this = $(this);

      if( $this.is('input') && $this.attr('type') == 'text' ) {
        // create a hidden dom element...
        // moves the name from the selected element
        // uses the value from the selected element.
        var name = $this.attr('name');
        id = 'cd_selcompany'+cnt;
        cnt++;
        var val = $this.val();
	var str = '<input type="hidden" value="'+val+'"';
	if( name.length > 0 ) str += ' name="'+name+'"';
	if( id.length > 0 ) str += ' id="'+id+'"';
        str += '/>';

	var $bef = $this.before(str);
	$this.removeAttr('name');
      
	// do an ajax request to get the company 'name' given the id
	if( val.length > 0 ) {
  	  $.ajax({
            type: 'POST',
            dataType: 'json',
            url: opts.ajax_url,
            data: {
	      compid: val
            },
            success: function(data) {
              $this.val(data);
            }
          });
        } // there is a value.

	// enable jquery ui autocomplete
        $this.autocomplete({
          select: function(event,ui) {
              $('#'+id).val(ui.item.value);
              $this.val(ui.item.label);
              return false;
          },
	  source: function(req,response) {
            $.ajax({
	      type: 'POST',
              dataType: 'json',
              url: opts.ajax_url,
              data: {
                term: req.term,
                mode: opts.mode
              },
              success: function(data) {
                response(data);
	      },
            });
	  },
          response: function(event,ui) {
            if( ui.content == null || ui.content.length == 0 ) {
              $('#'+id).val('');
            }
	  }
        }); // autocomplete

      } // for only text input fields.
    }); // each
  }

  // plugin defaults
  $.fn.compdir_choosecompany.defaults = {
    ajax_url: compdir_choosecompany_ajax_url,
    mode:     'any'
  };

})(jQuery);
