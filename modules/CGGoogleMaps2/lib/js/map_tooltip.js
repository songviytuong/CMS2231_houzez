// map tooltip class
// credits: http://medelbou.wordpress.com/2012/02/03/creating-a-tooltip-for-google-maps-javascript-api-v3/

// create a constructor
function Tooltip(options) {
  // Now initialize all properties.
  this.marker_ = options.marker;
  this.content_ = options.content;
  this.map_ = options.marker.get('map');
  this.cssClass_ = options.cssClass||null;
  this.div_ = null;
  this.setMap(this.map_);
  var me = this;

  google.maps.event.addListener(me.marker_, 'mouseover', function() { me.show(); });
  google.maps.event.addListener(me.marker_, 'mouseout', function() { me.hide(); });
}

Tooltip.prototype = new google.maps.OverlayView();

Tooltip.prototype.onAdd = function() {
  var div = document.createElement('DIV');
  div.style.position = "absolute";
  div.style.visibility = "hidden";
  if(this.cssClass_) div.className += " "+this.cssClass_;
  div.innerHTML = this.content_;
  this.div_ = div;
  var panes = this.getPanes();
  panes.floatPane.appendChild(this.div_);
}

Tooltip.prototype.draw = function() {
  var overlayProjection = this.getProjection();
  var ne = overlayProjection.fromLatLngToDivPixel(this.marker_.getPosition());
  var div = this.div_;
  div.style.left = ne.x + 'px';
  div.style.top = ne.y + 'px';
}

Tooltip.prototype.onRemove = function() {
  this.div_.parentNode.removeChild(this.div_);
}

// Note that the visibility property must be a string enclosed in quotes
Tooltip.prototype.hide = function() {
  if (this.div_) this.div_.style.visibility = "hidden";
}

Tooltip.prototype.show = function() {
  if (this.div_) this.div_.style.visibility = "visible";
}
;
