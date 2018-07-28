(function($){
  $.fn.parse_serialized = function(data)  {
    var parms=data.replace(/amp;/g,'');
    if( data.match(/\?(.+)$/) ) {
      parms = RegExp.$1;
    }
    var pArr = parms.split('&');
    var pHash = {};
    for( var i = 0; i < pArr.length; i++ ) {
      var tmp = pArr[i].split('=');
      pHash[tmp[0]] = unescape(tmp[1]);
    }
    return pHash;
  }


  $.fn.form_populate = function(data) {
    var container = $(this);
    $.each(data, function(name,value) {
      var expr = ":input[name='"+name+"']:not(:button,:reset,:submit,:image)";
      var input = container.find(expr);
      input.val( (!$.isArray(value) && (input.is(':checkbox:') || input.is(':radio'))) ? [value] : value );
    });
  };


  $.fn.form_populate_serialized = function(data) {
    var tmp = $(this).parse_serialized(data);
    $(this).form_populate(tmp);
  };

  $.fn.serializeObject = function() {
    var o = {};
    var a = this.serializeArray();
    $.each(a, function() {
        if (o[this.name] !== undefined) {
            if (!o[this.name].push) {
                o[this.name] = [o[this.name]];
            }
            o[this.name].push(this.value || '');
        } else {
            o[this.name] = this.value || '';
        }
    });
    return o;
  };

  $.fn.serializeAnything = function() {
    var toReturn    = [];
    var els         = $(this).find(':input').get();
    $.each(els, function() {
      if (this.name && !this.disabled && (this.checked || /select|textarea/i.test(this.nodeName) || /text|hidden|password/i.test(this.type))) {
        var val = $(this).val();
        toReturn.push( encodeURIComponent(this.name) + "=" + encodeURIComponent( val ) );
      }
    });
    return toReturn.join("&").replace(/%20/g, " ");
  };


  $.fn.form_get_datetime = function(prefix,do_time) {
    do_time = typeof(do_time) != 'undefined' ? do_time : 0;

    var key = ":input[name='"+prefix+"Year']";
    var year = this.find(key).val();
    var month = this.find(":input[name='"+prefix+"Month']").val();
    var day = this.find(":input[name='"+prefix+"Day']").val();
    var str = month+'/'+day+'/'+year;
    var hour = 0;
    var minute = 0;

    if( do_time )
      {
	var hour = this.find(":input[name='"+prefix+"Hour']").val();
	var minute = this.find(":input[name='"+prefix+"Minute']").val();
        str += ' '+hour+':'+minute+':00';
      }
    return str;
  };


  $.fn.form_set_datetime = function(in_date,prefix,do_time) {
    do_time = typeof(do_time) != 'undefined' ? do_time : 0;

    var zeropad = function(num,len)
    {
      var res = num.toString();
      while( res.length < len )
	{
	  res = '0'+res;
	}
      return res;
    }

    var date = '';
    var tmp = parseInt(in_date);
    if( tmp > 0 )
      {
        date = new Date(tmp * 1000);
      }
    else
      {
        date = new Date(in_date);
      }

    this.find(":input[name='"+prefix+"Year']").val(date.getFullYear());
    this.find(":input[name='"+prefix+"Month']").val(zeropad(date.getMonth()+1,2));
    this.find(":input[name='"+prefix+"Day']").val(date.getDate());
    if( do_time )
    {
      this.find(":input[name='"+prefix+"Hour']").val(date.getHours());
      this.find(":input[name='"+prefix+"Minute']").val(date.getMinutes());
    }

  };
})(jQuery)
