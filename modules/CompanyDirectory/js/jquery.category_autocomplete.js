/* this is a utility class to allow autocompleting categories using the jquery-ui autocomplete plugin */
var category_autocomplete = new function() {
    var elem, cont, elem_name;
    this.add_child = function(helper,id,label) {
	var _btn = $('<button/>').addClass('autocat-child-remove').text(opts.str_delete);
	var _hdn = $('<input/>').prop('type','hidden').prop('name',elem_name).val(id);
	var _lbl = $('<label/>').addClass('autocal-child-label').text(label);
	var _child = $('<div/>').addClass('autocat-child');
	_child.append(_hdn).append(_lbl).append(_btn);
	cont.append(_child);
    }

    this.init = function(in_opts) {
	opts = $.extend({}, opts, in_opts);
	elem = opts.element;
	elem_name = elem.attr('name');
	elem.removeAttr('name').addClass('autocat-inp');
	cont = $('<div/>').addClass('autocat-cont');
	elem.after(cont);

	if( opts.categories ) {
	    var _categories = [];
	    $.getJSON(opts.url,{
		all: 1,
	    }, function(all_cats) {
  	        for( var _id in opts.categories ) {
		    opts.onAddChild(self,_id,all_cats[_id].long_name);
		}
	    })
	}

	cont.on('click','.autocat-child-remove',function(ev){
            ev.preventDefault();
            var _child = $(this).closest('.autocat-child');
	    _child.remove();
	});

	elem.autocomplete({
            minLength: 2,
            source: function(request,response) {
		$.getJSON(opts.url,{
	            term: request.term
		}, function(data) {
		    response(data);
		});
            },
	    change: function( event, ui ) {
		// prevent free text in the text area
		if( ui.item == null ) elem.val('').focus();
	    },
	    select: function( event, ui ) {
		opts.onAddChild(self,ui.item.value,ui.item.label);
		elem.val('');
		return false;
	    }
	});
    }

    // constructor.
    var self = this;
    var opts = { element: null,
	         str_delete: 'Delete',
		 url: null,
	         onAddChild: this['add_child'] };
};
