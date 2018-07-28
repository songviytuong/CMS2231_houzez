(function($){
  $.widget('calguy1000.cggm2', {
    // possible options: zoom, (mapTypeID || type), center, infowindow, infowindow_trigger, infowindow_cb,
    // infowindow_content_cb, zoomcontrol, zoomControlOptions, type_controls, icons, nav_controls, scale_controls, sv_controls
    // infowindow_boxClass, tooltip, tooltip_Class, marker_click_cb, marker_mouseover_cb, marker_mouseout_cb, directions
    // type_control_options, directions_dest, directions_units, sensor, sensor_center, sensor_marker, sensor_icon, zoom_encompass,
    // combine_points, point_combine_fudge, combined_icon, default_icon, idle_cb
    // directions_panel

      options: {
	  zoom: 5,
	  mapTypeId: 'roadmap'
      },

      _create: function() {
	  if( typeof this.options.infowindow == 'undefined' ) this.options.infowindow = 1;
	  if( typeof this.options.infowindow_cb == 'undefined' ) this.options.infowindow_cb = this._popupInfoWindow;
	  if( typeof this.options.infowindow_boxClass == 'undefined' ) this.options.infowindow_boxClass = 'infoBox';
	  if( typeof this.options.infowindow_trigger == 'undefined' ) this.options.infowindow_trigger = 'click';
	  if( typeof this.options.tooltip == 'undefined' ) this.options.tooltip = 1;
	  if( typeof this.options.tooltip_Class == 'undefined' ) this.options.tooltip_Class = 'tooltip';

	  var mapOptions = this._getMapOptions();

	  this.data = {
              map: null,
              icons: {},
              markers: [],
              kml: [],
              bounds: null,
              directionsService: null,
              directionsDisplay: null
	  };

	  this.data.map = new google.maps.Map(this.element[0],mapOptions);
	  this.data.map.cggm = this;
	  this.data.bounds = new google.maps.LatLngBounds();
	  google.maps.event.addListener(this.data.map,'idle',this._doIdle);
	  if( this.options.directions ) this.data.directionsService = new google.maps.DirectionsService();
	  if( this.options.directions && this.options.directions_draw ) {
              this.data.directionsDisplay = new google.maps.DirectionsRenderer();
              this.data.directionsDisplay.setMap(this.data.map);
	      if( typeof this.options.directions_panel != 'undefined' ) {
		  node = this.options.directions_panel;
		  if( typeof node == 'string' ) node = $(node).get(0);
		  if( typeof node == 'object' && node.nodeName ) {
		      this.data.directionsDisplay.setPanel(node);
		  }
	      }
	  }
	  this._getInfoWindow();
	  this._createIcons();
	  this._addStaticMarkers();
          this._addMyLocationMarker();
          this._addKmlLayers();
	  this._calcCenter(true);

	  if( this.options.sensor ) {
	      var self = this;
	      if( navigator.geolocation ) {
		  navigator.geolocation.getCurrentPosition(function(pos) {
		      self.options.mylocation = new google.maps.LatLng(pos.coords.latitude,pos.coords.longitude);
		      if( self.options.sensor_marker ) self._addMyLocationMarker();
		      self._calcCenter(true);
		  });
	      }
	  }
	  this._trigger('ready', null, { value: 'foo' });
      },

      _setOption: function( key, value ) {
	  if( key == 'icons' || key == 'icon' ) return;
	  this.options[key] = value;
	  if( this.data.directions && this.data.directionsService == null ) {
              this.data.directionsService = new google.maps.DirectionsService();
	  }
	  if( this.options.directions && this.options.directions_draw && this.data.directionsDisplay == null ) {
	      this.data.directionsDisplay = new google.maps.DirectionsRenderer();
	  }
	  this._calcCenter();
      },

      getMap: function() {
	  return this.data.map;
      },

      addMarker: function( markerOptions ) {
	  if( typeof(markerOptions) != 'object' ) {
              console.debug('addMarker - invalid marker options');
	      return;
	  }
	  if( typeof(markerOptions.position) == 'undefined' || typeof(markerOptions.name) == 'undefined' ) {
	      console.debug('addMarker - invalid marker options object');
	      return;
	  }
	  if( typeof markerOptions.icon == 'undefined' ) {
	      markerOptions.icon = this._getIcon('__default__');
	  }
	  markerOptions.map = this.data.map;
	  if( markerOptions.position ) markerOptions.position = this._latLng(markerOptions.position);
	  var marker = new google.maps.Marker(markerOptions);
	  marker.name = markerOptions.name;
	  if( markerOptions.container ) marker.container = markerOptions.container;
	  marker.cggm = this;
	  this.data.markers[marker.name] = marker;

	  if( this.options.infowindow && this.options.infowindow_trigger ) {
	      google.maps.event.addListener(marker,this.options.infowindow_trigger,this.options.infowindow_cb);
	  }

	  if( this.options.tooltip ) {
              var opts = {
		  marker: marker,
  		  cssClass: this.options.tooltip_Class
              };
	      if( typeof markerOptions.title != 'undefined' ) opts.content = markerOptions.title;
	      if( typeof markerOptions.tooltip != 'undefined' ) opts.content = markerOptions.tooltip;
	      if( typeof opts.content != 'undefined' ) {
                marker.tooltip = new Tooltip(opts);
  	        delete marker.title;
	      }
	  }

	  if( typeof this.options.marker_click_cb === 'function' ) google.maps.event.addListener(marker,'click',this.options.marker_click_cb);
	  if( typeof this.options.marker_mouseover_cb === 'function' ) {
	      google.maps.event.addListener(marker,'mouseover',this.options.marker_mouseover_cb);
	  }
	  if( typeof this.options.marker_mouseout_cb === 'function' ) {
	      google.maps.event.addListener(marker,'mouseover',this.options.marker_mouseout_cb);
	  }

          this.data.bounds.extend(marker.position);
	  this._calcCenter();
	  this._trigger('markerAdded',marker);
      },

      removeAllMarkers: function() {
	  for( var p in this.data.markers) {
	      this.data.markers[p].setMap(null);
	  }
	  this.data.markers = Array();
	  this._trigger('clearAllMarkers',null);
      },

      refresh: function() {
	  google.maps.event.trigger(this.data.map,'resize');
	  this.data.map.fitBounds(this.data.bounds);
      },

      removeMarker: function(id) {
	  if( this.data.markers[id] ) {
              this.data.markers[id].setMap(null);
              delete this.data.markers[id];
	      this._trigger('markerRemoved',id);
	  }
      },

      removeAllKmlLayers: function() {
	  for( var p in this.data.kml ) {
	      this.data.kml[p].setMap(null);
	  }
	  this.data.kml = Array();
	  this._trigger('layersRemoved');
      },

      addKmlLayer: function(href) {
	  var obj = new google.maps.KmlLayer({ url: href, map: this.data.map });
	  this.data.kml.push(obj);
	  this._trigger('layerAdded',obj);
      },

      _addKmlLayers: function() {
	  self = this;
	  if( this.options.kml ) {
              $.each(this.options.kml,function(idx,href){
   		  self.addKmlLayer(href);
              });
	  }
      },

      addIcon: function(opts) {
	  if( typeof opts.name == 'undefined' || typeof opts.href == 'undefined' ) return;
	  this.data.icons[opts.name] = opts;
      },

      getMarkerList: function() {
	  var out = [];
	  if( typeof this.options.mylocation != 'undefined' ) {
              var str = 'My Location';
              if( typeof this.options.mylocationstr != 'undefined' ) str = this.options.mylocationstr;
              out.push({ 'value': '__MYLOCATION__', 'text': str });
	  }
	  for( key in this.data.markers ) {
	      if( key != 'undefined' ) {
                  out.push({ value: key, text: key });
	      }
	  }
	  return out;
      },

      getMarker: function(name) {
	  if( typeof this.data.markers[name] != 'undefined' ) {
	      return this.data.markers[name];
	  }
	  return false;
      },

      getDirections: function(list,callback) {
	  if( typeof this.options.directions == 'undefined' || !this.options.directions ) return;
	  self = this;

	  function _getLocPosition(key) {
	      if( key == '__MYLOCATION__' && self.options.mylocation ) return self.options.mylocation;
              if( typeof self.data.markers[key] == 'undefined' ) return;
              return self.data.markers[key].position;
	  };

	  if( list.length < 2 ) return;
	  if( list[0] == list[list.length-1] ) return;

	  var opts = {
              origin: _getLocPosition(list[0]),
              destination: _getLocPosition(list[list.length-1]),
              travelMode: google.maps.DirectionsTravelMode.DRIVING,
              unitSystem: google.maps.DirectionsUnitSystem[this.options.directions_units]
	  };
	  if( list.length > 2 ) {
              var waypoints = [];
              for( var i = 1; i < list.length - 1; i++ ) {
		  waypoints.push({ location: _getLocPosition(list[i]) });
	      }
              opts.waypoints = waypoints;
	  }

          self.data.directionsService.route(opts,function(result,status) {
            if( self.options.directions_draw ) self.data.directionsDisplay.setDirections(result);
  	    if( typeof callback === 'function' ) callback({ map: self.data.map, directions: result });
          });
      },

      panToMarker: function(name) {
	  var marker = this.getMarker(name);
	  if( typeof marker == 'undefined' ) return; // throw error?
	  this.data.map.panTo(marker.getPosition());
      },

      showInfoWindow: function(name) {
	  var marker = this.getMarker(name);
	  if( typeof marker == 'undefined' ) return; // throw error?
	  var content = this._getInfoWindowContents(marker);
	  if( content ) {
              infowindow = self._getInfoWindow();
              infowindow.setContent(content);
              infowindow.setPosition(marker.getPosition());
              infowindow.open(self.data.map,marker);
	  }
      },

      /*** helper methods ***/

      _popupInfoWindow: function() {
	  // "this"" is the marker.
	  var self = this.cggm;
	  var content = self._getInfoWindowContents(this);
	  if( content ) {
              infowindow = self._getInfoWindow();
              infowindow.setContent(content);
              infowindow.setPosition(this.getPosition());
              infowindow.open(self.data.map,this);
	  }
      },

      _doIdle: function(e) {
	  var timer;
	  var map = this;
	  clearTimeout(timer);
	  timer = setTimeout(function() {
	      if( typeof map.cggm.options.idle_cb === 'function' ) map.cggm.options.idle_cb(self);
	      map.cggm._trigger('idle');
	  }, 500);
      },

      _getInfoWindowContents: function(marker) {
	  var self = marker.cggm;
	  var ntabs = 0;
	  var tabcontent = null;
	  if( typeof self.options.infowindow_content_cb == 'function' ) {
              tabcontent = self.options.infowindow_content_cb(self,marker);
	  }
	  else if( marker.description ) {
	      tabcontent = marker.description;
	  }
	  else if( marker.bubbletext ) {
              tabcontent = marker.bubbletext;
	  }
	  else if( marker.container ) {
              tabcontent = $('.cggm2_marker_desc',marker.container).html();
	  }
	  return tabcontent;
      },

      _getInfoWindow: function() {
	  if( typeof this.data.infowindow == 'undefined' ) {
              var opts = {};
              opts.boxClass = this.data.infowindow_boxClass;
              this.data.infowindow = new InfoBox(opts);
	  }
	  return this.data.infowindow;
      },

      /**
       * Helper method for google.maps.Latlng
       * @param latLng:string/google.maps.LatLng
       */
      _latLng: function(latLng) {
	  if ( !latLng ) return new google.maps.LatLng(0.0, 0.0);
	  if ( latLng instanceof google.maps.LatLng ) {
	      return latLng;
	  } if( latLng instanceof Array && latLng.length == 2 ) {
              return new google.maps.LatLng(latLng[0],latLng[1]);
	  } else {
	      latLng = latLng.replace(/ /g,'').split(',');
	      return new google.maps.LatLng(latLng[0], latLng[1]);
	  }
      },

      _getMapOptions: function() {
	  var opts = {};
	  var iopts = this.options;
	  opts.mapTypeId = 'roadmap';
	  // todo: support multiple types (comma separated)
	  if( typeof iopts.type != 'undefined' ) {
	      if( iopts.type == 'map' ) iopts.type = 'roadmap';
	      opts.mapTypeId = iopts.type;
	  }

	  /*
	  opts.tooltip: 1,
	  opts.infowindow: 1,
	  opts.infowindow_trigger: 'click',
	  opts.infowindow_boxClass: 'infoBox',
	  opts.tooltip_Class: 'tooltip',
          */

	  opts.zoom = iopts.zoom;
	  opts.center = this._latLng("0, 0");
	  opts.zoomControl = true;
	  opts.zoomControlOptions = { style: 'default' };
	  if( typeof iopts.zoomControl != 'undefined' ) opts.zoomControl = Boolean(iopts.zoomControl);
	  if( typeof iopts.zoomControlStyle != 'undefined ') {
	      opts.zoomControlOptions.style = iopts.zoomControlStyle;
	  }
	  if( typeof iopts.center != 'undefined' ) opts.center = this._latLng(iopts.center);
	  if( typeof iopts.type_controls != 'undefined' ) opts.mapTypeControl = Boolean(iopts.type_controls);
	  if( typeof iopts.type_control_option != 'undefined' ) opts.mapTypeControlOptions = { style: iopts.type_control_option };
	  if( typeof iopts.nav_controls != 'undefined' ) opts.panControl = Boolean(iopts.nav_controls);
	  if( typeof iopts.scale_controls != 'undefined' ) opts.scaleControl = Boolean(iopts.scale_controls);
	  if( typeof iopts.sv_controls != 'undefined' ) opts.streetViewControl = Boolean(iopts.sv_controls);
	  return opts;
      },

      _createIcons: function() {
	  // create a default icon (with a hardcoded URL)

	  if( typeof this.options.icons != undefined ) {
              this.data.icons = this.options.icons;
              delete this.options.icons;
	  }
      },

      _getIcon: function(preferred) {
	  if( typeof this.data.icons != 'undefined' ) {
	      if( typeof this.data.icons[preferred] != 'undefined' ) {
		  return this.data.icons[preferred];
	      }
              if( typeof this.data.icons[this.options.default_icon] != 'undefined' ) {
		  return this.data.icons[this.options.default_icon];
	      }
	      // return the first icon...
              for( var tmp in this.data.icons ) {
		  return this.data.icons[tmp];
	      }
	  }
      },

      _addMyLocationMarker: function() {
	  if( this.options.sensor && this.options.sensor_marker && typeof this.options.mylocation != 'undefined' && this.options.mylocation != null ) {
	      var opts = {
		  position: this.options.mylocation,
		  name: '** My Location **',
		  icon: this._getIcon(this.options.sensor_icon),
		  title: (typeof this.options.mylocationstr != 'undefined') ? this.options.mylocationstr : 'You are here'
	      };
	      this.addMarker(opts);
	  }
      },

      _addStaticMarkers: function() {
	  var self = this;
	  if( this.options.markers ) {
              $.each(this.options.markers,function(idx,markerOpts){
		  if( typeof(markerOpts) == 'object' ) {
		      if( markerOpts.icon && typeof self.data.icons[markerOpts.icon] != 'undefined' ) markerOpts.icon = self._getIcon(markerOpts.icon);
		      self.addMarker(markerOpts);
		  }
              });
	  }
	  var cont = $(this.element).next('div.cggm2_markers');
	  if( typeof cont == 'undefined' ) return;
	  $('div.cggm2_marker',cont).each(function(){
	      var opts = {};
              opts.container = this;
	      opts.name = $(":input[class='cggm2_marker_name']",this).val();
	      if( opts.name.length == 0 ) return;
	      opts.title = $(":input[class='cggm2_marker_title']",this).val();
	      opts.description = $(":input[class='cggm2_marker_description']",this).val();
	      var x = $(":input[class='cggm2_marker_latitude']",this).val();
	      var lat = parseFloat($(":input[class='cggm2_marker_latitude']",this).val());
	      var lon = parseFloat($(":input[class='cggm2_marker_longitude']",this).val());
	      if( isNaN(lat) || isNaN(lon ) ) return;
	      opts.position = lat+", "+lon;
	      var tooltip = $(":input[class='cggm2_marker_tooltip']",this).val();
	      if( typeof tooltip != 'undefined' && tooltip.length > 0 ) opts.tooltip = tooltip;
	      var icon = $(":input[class='cggm2_marker_icon']",this).val();
	      if( typeof icon != 'undefined' && typeof self.data.icons[icon] != 'undefined' ) opts.icon = self._getIcon(icon);
	      self.addMarker(opts);
	  });
      },

      _calcCenter: function(first_time) {
	  var self = this;
	  if( self.options.zoom_encompass > 0 ) {
	      self.data.map.fitBounds(self.data.bounds);
	  }
	  if( first_time ) {
              if( self.options.sensor &self.options.sensor_center && typeof self.options.mylocation != 'undefined' ) {
  	          self.data.map.setCenter(self.options.mylocation);
	      }
	      else if( typeof self.options.center == 'undefined' ) {
		  // no center specified... so set the center to the center of the bounds
		  self.data.map.setCenter(self.data.bounds.getCenter());
	      }
	  }
          // self._addKMLFiles(); // todo
          // self._addLayers(); // todo
	  self._trigger('update', null, { value: 'foo' });
      },

      __nothing: function() {}
  });
})(jQuery);
