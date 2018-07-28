<?php
# A
$lang['address'] = 'Address';
$lang['add_category'] = 'Add Category';
$lang['add_icon'] = 'Add Icon';
$lang['add_map'] = 'Add Map';
$lang['add_map_point'] = 'Add Map Point';
$lang['add_point_for_map'] = 'Add Point to Map &quot;%s&quot;';
$lang['aerial'] = 'Aerial';
$lang['anchor_x'] = 'Anchor X Pixel Location';
$lang['anchor_y'] = 'Anchor Y Pixel Location';
$lang['apply'] = 'Apply';
$lang['ask_delete_icon'] = 'Are you sure you want to remove this icon from the list (no files will be deleted)';
$lang['ask_reset_icons'] = 'Are you sure you want to remove all icons, and reset to factory defaults?';

# B
$lang['baloon_maptemplate'] = 'Balloon Template';

# C
$lang['cancel'] = 'Cancel';
$lang['category_template'] = 'Category View Template';
$lang['center_lat'] = 'Center Latitude';
$lang['center_lon'] = 'Center Longitude';
$lang['clearcache'] = 'Clear Geolocate Cache';
$lang['click'] = 'Click';
$lang['combine_points'] = 'Combine individual markers that are within range';
$lang['combined_points_icon'] = 'Icon to use for combined points';
$lang['controls'] = 'Controls';
$lang['confirm_edit_map_points'] = 'Are you sure you want to do this? any unsaved changes to the map will be lost.';
$lang['controls_size'] = 'Size of Controls';

# D
$lang['default'] = 'Default';
$lang['default_icon'] = 'Default Icon';
$lang['default_templates'] = 'Default Templates';
$lang['delete'] = 'Delete';
$lang['delete_icon'] = 'Delete this icon';
$lang['delete_map'] = 'Delete Map';
$lang['delete_map_point'] = 'Delete Map Point';
$lang['description'] = 'Description';
$lang['directions'] = 'Show Directions';
$lang['directions_dest'] = 'Where should directions be drawn';
$lang['directions_draw'] = 'Draw Directions on the Map';
$lang['directions_template'] = 'Directions Template';
$lang['directions_units'] = 'Directions Units';
$lang['dirform_maptemplate'] = 'Directions Form Template';
$lang['dropdown'] = 'Dropdown';

# E
$lang['edit'] = 'Edit';
$lang['edit_category'] = 'Edit Marker Category';
$lang['edit_icon'] = 'Edit this icon';
$lang['edit_map'] = 'Edit Map';
$lang['edit_map_point'] = 'Edit Map Point';
$lang['edit_map_points'] = 'Add/Edit Map Points';
$lang['edit_points_for_map'] = 'Edit Points for Map &quot;%s&quot;';
$lang['error_browser_incompatible'] = 'This browser is not capable of displaying maps from google';
$lang['error_cannotdelete'] = 'This item cannot be removed';
$lang['error_deletecategory'] = 'Problem deleting category';
$lang['error_invalidparams'] = 'One or more parameters is missing or invalid';
$lang['error_mapelem_notfound'] = 'Map Element Not Found';
$lang['error_nameexists'] = 'An item by that name already exists';
$lang['error_noapikey'] = 'The Google API Key is empty';
$lang['error_noapikey2'] = 'The Google API Key is empty.  This module will not function properly until it is set with a valid value as supplied by google.';
$lang['error_notfound'] = 'The requested item could not be found';
$lang['error_permissiondenied'] = 'You don\'t have the appropriate permission to perform this action';

# F
$lang['friendlyname'] = 'Calguys Google Maps 2';
$lang['from'] = 'From';

# G
$lang['get_directions'] = 'Get Directions';
$lang['google_api_key'] = 'Google API Key';

# H
$lang['height'] = 'Height';
$lang['help_anchor_location'] = '<strong>Note:</strong>&nbsp;Anchor locations specify the pixel location (relative to the top left corner of thie image) where the icon should be anchored to the marker.  If no value is specified, the center of the icon will be used';
$lang['help_icon_url'] = 'Specify the URL to the pre-uploaded PNG image.  This image should not be larger than 32x32, and should support transparency.  The URL can usually be specified relative to the root of your installation, but it is possible to use <a href="https://developers.google.com/chart/image/docs/gallery/dynamic_icons">dynamic icons</a> from the Google Graph API or other sources.';
$lang['help_param_defer'] = 'Specify that all javascript tags should have the defer attribute set.  This may be useful for problems with IE7 and IE8 where Internet explorer tries to execute javascript on an incompletely rendered page.';
$lang['help_param_key'] = 'Specify an alternate key from which to extract dynamic points. If not specified the map name/id will be used as the key.';
$lang['help_param_map'] = 'Specify the ID or map name to use for laying out the google map.  If this parameter is not specified, the default map (if any) is used.';
$lang['help_param_maptemplate'] = 'Specify the name of an existing, non default map template to use for this output.  If this parameter is not specified, the current default map template will be used';
$lang['help_param_zoomlevel'] = '(integer) Allows overriding the zoom level stored with the map.  Valid values are from 1 to 17';
$lang['help_param_zoomencompass'] = '(boolean) Allows overriding the zoom encompass setting that is stored with the map.';
$lang['hide_directions'] = 'Hide Directions';
$lang['horizontal_bar'] = 'Horizontal Bar';
$lang['hybrid'] = 'Hybrid';

# I
$lang['id'] = 'Id';
$lang['icon'] = 'Icon';
$lang['imperial'] = 'Imperial';
$lang['info'] = 'Info';
$lang['info_address'] = 'Specify a complete address that google can use to do geolocation.  This typically includes a number, street, town, province or state, and country.  i.e: <em>1600 Pennysilvania Ave, Washington, DC, USA</em>';
$lang['info_address_latlong'] = '<strong>Note:</strong> Enter <strong>either</strong> an address <strong>or</strong> a lattitude and longitude.  If both the address and latitude and longitude are specified, latitude and longitude will be given preference.';
$lang['info_anchor_x'] = 'Info Window Anchor X Pixel Location';
$lang['info_anchor_y'] = 'Info Window Anchor Y Pixel Location';
$lang['info_bounds_fudge'] = 'When zoom encompass is specified (and controlled by PHP) you can specify a percentage <em>(in decimal)</em> by which to expand the map bounds to provide a &quot;margin&quot; around the encompassed points';
$lang['info_category_panel'] = 'Should a panel be displayed that shows the categories of all of the map points, and allow toggling map markers on and off by category';
$lang['info_center_lat'] = 'The Center latitude is optional.  If specified it will be used for centering the map.  Specify a value in decimal degrees i.e: -123.45';
$lang['info_center_lon'] = 'The Center longitude is optional.  If specified it will be used for centering the map. Specify a value in decimal degrees i.e: -123.45';
$lang['info_combine_points'] = 'If selected, points that are within a specified radius of each other will be combined into one marker on the map.  This functionality is useful if multiple entries exist at the same (or almost the same) coordinates, to ease in selection.  This functionality is independant of the map zoom level.';
$lang['info_controls'] = 'Should zoom and pan controls be displayed?';
$lang['info_controls_size'] = 'Specify the size of the controls on the map';
$lang['info_default_icon'] = 'The default icon is used when no other icon is specified for a map point';
$lang['info_directions'] = 'Allow the user to request directions from, or to a map point';
$lang['info_directions_dest'] = 'Specify how directions should be handled.  Should they be displayed in a new window, or in the map panel';
$lang['info_directions_draw'] = 'If enabled, directions will be drawn on the map';
$lang['info_directions_units'] = 'Specify how the units should be displayed for directions.  Metric, or imperial.';
$lang['info_height'] = 'Specify a map height (in pixels)';
$lang['info_icon_selection'] = 'By default, which icon should be preferred for markers when the category panel is displayed';
$lang['info_info_trigger'] = 'Specify what should trigger the opening of the info window';
$lang['info_info_window'] = 'Should an information window be displayed for each map point?';
$lang['info_infowindow_height'] = 'Specify a height (in pixels) for the info window';
$lang['info_infowindow_width'] = 'Specify a width (in pixels) for the info window';
$lang['info_mapname'] = 'Specify a unique name for the map';
$lang['info_map_type'] = 'Specify the default map type (if type controls are enabled, the user can change the type after the map is displayed)';
$lang['info_nav_control_opt'] = 'Specify the type of navigation controls for the map';
$lang['info_point_combine_fudge'] = 'The smaller the radius means that fewer points will be combined into one map marker.  Negative values are invalid.';
$lang['info_point_combine_icon'] = 'Specify an icon to use to illustrate on the map that the marker consists of multiple points that are within a small area';
$lang['info_scalecontrols'] = 'A scale can optionally be displayed in the lower right corner of the map';
$lang['info_sensor'] = 'Some browsers (particularly mobile browsers) are capable of providing latitude and longitude information.  Do you want to enable this?';
$lang['info_sensor_center'] = 'If sensor information is provided to the map, this option allows centering the map at the users current location';
$lang['info_sensor_marker'] = 'If sensor information is provided to the map, do you want to place a marker at the users current location?';
$lang['info_sensor_icon'] = 'If sensor information is provided to the map, and you want a marker at the users location, chose the icon.';

$lang['info_sidebar'] = 'Should a sidebar containing all map points be displayed?';
$lang['info_sv_controls'] = 'Should StreetView Controls be displayed on the map?';
$lang['info_sv_radius'] = 'When Streetview is enabled for a marker, how far (in meters) should it search for a valid streetview location.  This is important in rural areas where StreetView has not necessarily gone through every street.';
$lang['info_sysdflt_baloon_template'] = 'System Default &quot;Balloon&quot; Template';
$lang['info_sysdflt_category_template'] = 'System Default &quot;Category List&quot; Template';
$lang['info_sysdflt_dirform_template'] = 'System Default &quot;Directions Form&quot; Template';
$lang['info_sysdflt_js_template'] = 'System Default Javascript Template';
$lang['info_sysdflt_map_template'] = 'System Default Map template';
$lang['info_sysdflt_sidebar_template'] = 'System Default Sidebar Template';
$lang['info_sysdflt_template'] = 'This form provides the ability to specify the content that will be displayed when you create a new template of this type.  Editing the content in this form will have no immediate effect on your website';
$lang['info_tooltip'] = 'If tooltips are specified for a marker, they can be displayed on hover on the map';
$lang['info_type_control_opt'] = 'Specify how the map type controls should be displayed';
$lang['info_width'] = 'Specify a map width (in pixels)';
$lang['infowindow_width'] = 'Width of InfoWidnow';
$lang['infowindow_height'] = 'Height of InfoWindow';
$lang['info_type_controls'] = 'Allow the user to change the map type?';
$lang['info_zoom'] = 'Specify an initial zoom level (note, that this parameter is ineffective if &quot;zoom encompass&quot; is used';
$lang['info_zoom_encompass'] = 'Should the zoom level of the map encompass all of the points?  If so, should the initial map zoom be calculated by the map, or from logic in the PHP source';

# J
$lang['js_template'] = 'Javascript Template';

# L
$lang['large'] = 'Large';
$lang['latitude'] = 'Latitude';
$lang['latlong'] = 'Latitude / Longitude';
$lang['location'] = 'Location';
$lang['longitude'] = 'Longitude';

# M
$lang['make_default'] = 'Make this icon the default icon';
$lang['marker_categories'] = 'Marker Categories';
$lang['marker_icons'] = 'Marker Icons';
$lang['marker_skipped'] = 'Geolocation (address to lat/long) failed.. marker &quot;%s&quot; skipped';
$lang['map'] = 'Map';
$lang['maps'] = 'Maps';
$lang['maptemplate_addedit'] = 'Add/Edit Map Template';
$lang['map_name'] = 'Map Name';
$lang['map_template'] = 'Map Template';
$lang['map_templates'] = 'Map Templates';
$lang['map_type'] = 'Map Type';
$lang['metric'] = 'Metric';
$lang['moddescription'] = 'A simple module for creating google maps';
$lang['mouseover'] = 'MouseOver';
$lang['msg_prefs_saved'] = 'Settings updated';
$lang['msg_addresscache_cleared'] = 'Geolocation cache cleared';
$lang['msg_categoryadded'] = 'Category Added';
$lang['msg_categorydeleted'] = 'Category Deleted';
$lang['msg_categoryupdated'] = 'Category Updated';
$lang['msg_default_icon_uchanged'] = 'The default icon has been changed';
$lang['msg_icons_reset'] = 'Icons have been reset to factory default settings';
$lang['msg_icon_removed'] = 'Icon removed from the database.  No files were deleted';
$lang['msg_icon_updated'] = 'Icon information changed';

# N
$lang['name'] = 'Name';
$lang['nav_control_opt'] = 'Navigation Control Size';
$lang['none'] = 'None';

$lang['off'] = 'Off';
$lang['on'] = 'On';

# P
$lang['panel'] = 'Panel';
$lang['ph_address'] = 'Enter a valid address';
$lang['points'] = 'Points';
$lang['point_combine_fudge'] = 'Specify a radius that specifies which points should be combined.';
$lang['point_combine_icon'] = 'Combined Points Icon';
$lang['point_name'] = 'Point Name';
$lang['point_type'] = 'Point Type';
$lang['policy_cachefirst'] = 'Read cache first then lookup address online';
$lang['policy_cacheonly'] = 'Always use the cache';
$lang['policy_nocache'] = 'Never use the cache (online lookup only)';
$lang['postinstall'] = 'The CGGoogleMaps module has been installed';;
$lang['postuninstall'] = 'The CGGoogleMaps module and all relevant data has been removed';
$lang['preferences'] = 'Preferences';
$lang['prompt_address'] = 'Address';
$lang['prompt_bounds_fudge'] = 'Zoom Encompass Bounds Fudge';
$lang['prompt_categories'] = 'Categories';
$lang['prompt_directions'] = 'Directions';
$lang['prompt_from_here'] = 'From Here';
$lang['prompt_icon_selection'] = 'Icon Selection';
$lang['prompt_info_window'] = 'Show Info Window';
$lang['prompt_info_trigger'] = 'Info Window Trigger';
$lang['prompt_lookup_policy'] = 'Lookup Policy';
$lang['prompt_lookup_service'] = 'Lookup Service';
$lang['prompt_mapname'] = 'Map Name';
$lang['prompt_tooltip'] = 'Enable Tooltips';
$lang['prompt_to_here'] = 'To Here';
$lang['prompt_sensor'] = 'Supply Geographic location information to the map';
$lang['prompt_sensor_center'] = 'Center the map at the users location?';
$lang['prompt_sensor_marker'] = 'Create a marker at the users location?';
$lang['prompt_sensor_icon'] = 'Marker to use at the users location?';
$lang['prompt_zoom'] = 'Zoom Level';

# R
$lang['really_uninstall'] = 'Are you sure you really want to remove this module?';
$lang['reset'] = 'Reset';
$lang['reset_icons'] = 'Reset Icons';

# S
$lang['satellite'] = 'Satellite';
$lang['scalecontrols'] = 'Show Scale';
$lang['set_dflt_map'] = 'Set Map As Default';
$lang['show_category_panel'] = 'Show Category Panel';
$lang['sidebar'] = 'Show Sidebar';
$lang['sidebar_template'] = 'Sidebar Template';
$lang['small'] = 'Small';
$lang['submit'] = 'Submit';
$lang['sv_controls'] = 'Show Streetview Controls';
$lang['sv_radius'] = 'Streetview Search Radius';

# T
$lang['tab_advanced'] = 'Advanced';
$lang['tab_directions'] = 'Directions';
$lang['tab_jstemplate'] = 'Javascript Template';
$lang['tab_settings'] = 'Settings';
$lang['tab_maptemplate'] = 'Map Template';
$lang['text'] = 'Text';
$lang['title_combined_marker'] = 'Multiple results at this location';
$lang['to'] = 'To';
$lang['tooltip'] = 'Tooltip';
$lang['type'] = 'Type';
$lang['type_controls'] = 'Show Type Controls';
$lang['type_control_opt'] = 'Type Control Options';

# U
$lang['url'] = 'URL';
$lang['use_category_icon'] = 'Prefer the Category Icon';
$lang['use_marker_icon'] = 'Prefer the Marker Icon';

# W
$lang['width'] = 'Width';
$lang['window'] = 'Window';

# Y
$lang['youarehere'] = 'You are here';

# Z
$lang['zoom_encompass'] = 'Zoom Encompass';
$lang['zoomencompass_auto'] = 'Map Controlled';
$lang['zoomencompass_php'] = 'PHP Controlled';
?>
