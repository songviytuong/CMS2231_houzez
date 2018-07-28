<?php
/* Smarty version 3.1.31, created on 2018-01-18 02:29:21
  from "tpl_body:139" */

/* @var Smarty_Internal_Template $_smarty_tpl */
if ($_smarty_tpl->_decodeProperties($_smarty_tpl, array (
  'version' => '3.1.31',
  'unifunc' => 'content_5a5f9601a26997_55396353',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    'bd9e937365dbd59b87b95bf070b26abcc40299e7' => 
    array (
      0 => 'tpl_body:139',
      1 => '1516213759',
      2 => 'tpl_body',
    ),
  ),
  'includes' => 
  array (
    'cms_template:INC_Scripts' => 1,
  ),
),false)) {
function content_5a5f9601a26997_55396353 (Smarty_Internal_Template $_smarty_tpl) {
if (!is_callable('smarty_function_themes_url')) require_once 'E:\\xampp\\htdocs\\public_html\\cms_version2\\cms2231_houzez\\lib\\plugins\\function.themes_url.php';
?>
<body>
<body class="page-template page-template-template page-template-property-listings-map page-template-templateproperty-listings-map-php page page-id-1626  transparent-no wpb-js-composer js-comp-ver-5.4.2 vc_responsive">
<div id="fb-root"></div>

<div class="modal fade" id="pop-login" tabindex="-1" role="dialog">
    <div class="modal-dialog modal-sm">
        <div class="modal-content">
            <div class="modal-header">
                <ul class="login-tabs">
                    <li class="active">Login</li>
                    <li>Register</li>

                </ul>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><i class="fa fa-close"></i></button>

            </div>
            <div class="modal-body login-block class-for-register-msg">
                <div class="tab-content">
    <div class="tab-pane fade in active">
        <div id="houzez_messages" class="houzez_messages message"></div>
        <form>
            <div class="form-group field-group">
                <div class="input-user input-icon">
                    <input id="login_username" name="username" placeholder="Username" type="text" />
                </div>
                <div class="input-pass input-icon">
                    <input id="password" name="password" placeholder="Password" type="password" />
                </div>
            </div>

            
            <div class="forget-block clearfix">
                <div class="form-group pull-left">
                    <div class="checkbox">
                        <label>
                            <input name="remember" id="remember" type="checkbox">
                            Remember me                        </label>
                    </div>
                </div>
                <div class="form-group pull-right">
                    <a href="#" data-dismiss="modal" data-toggle="modal" data-target="#pop-reset-pass">Lost your password?</a>
                </div>
            </div>

            <input type="hidden" id="houzez_login_security" name="houzez_login_security" value="457ea959de" /><input type="hidden" name="_wp_http_referer" value="/half-map/" />            <input type="hidden" name="action" id="login_action" value="houzez_login">
            <button type="submit" class="fave-login-button btn btn-primary btn-block">Login</button>
        </form>
                    <hr>
                            <button class="facebook-login btn btn-social btn-bg-facebook btn-block"><i class="fa fa-facebook"></i> login with facebook</button>
                                        <button class="yahoo-login btn btn-social btn-bg-yahoo btn-block"><i class="fa fa-yahoo"></i> login with yahoo</button>
                                        <button class="google-login btn btn-social btn-bg-google-plus btn-block"><i class="fa fa-google-plus"></i> login with google</button>
                        </div>

    <div class="tab-pane fade">
        User registration is disabled in this demo.    </div>

</div>
            </div>
        </div>
    </div>
</div>
<div class="modal fade" id="pop-reset-pass" tabindex="-1" role="dialog">
    <div class="modal-dialog modal-sm">
        <div class="modal-content">
            <div class="modal-header">
                <ul class="login-tabs">
                    <li class="active">Reset Password</li>
                </ul>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><i class="fa fa-close"></i></button>

            </div>
            <div class="modal-body login-block">
                <p>Please enter your username or email address. You will receive a link to create a new password via email.</p>
                <div id="houzez_msg_reset" class="message"></div>
                <form>
                    <div class="form-group">
                        <div class="input-user input-icon">
                            <input name="user_login_forgot" id="user_login_forgot" placeholder="Enter your username or email" class="form-control">
                        </div>
                    </div>
                    <input type="hidden" id="fave_resetpassword_security" name="fave_resetpassword_security" value="dd007090fd" /><input type="hidden" name="_wp_http_referer" value="/half-map/" />                    <button type="button" id="houzez_forgetpass" class="btn btn-primary btn-block">Get new password</button>
                </form>
            </div>
        </div>
    </div>
</div>

<!--start section header-->
<header id="header-section" class="houzez-header-main header-section-4 nav-left   houzez-user-logout" data-sticky="0">
    <div class="container">
        <div class="header-left">

            <div class="logo logo-desktop">
                

	<a href="/">
					<img src="<?php echo smarty_function_themes_url(array(),$_smarty_tpl);?>
/houzez01/wp-content/uploads/2016/03/logo-houzez-color.png" alt="logo">
			</a>
            </div>

            <nav class="navi main-nav">
                <ul id="main-nav" class=""><li id="menu-item-955" class="menu-item menu-item-type-custom menu-item-object-custom menu-item-has-children menu-item-955"><a href="#">Home</a>
<ul  class="sub-menu">
	<li id="menu-item-1333" class="menu-item menu-item-type-custom menu-item-object-custom menu-item-has-children menu-item-1333"><a href="#">Map</a>
	<ul  class="sub-menu">
		<li id="menu-item-954" class="menu-item menu-item-type-post_type menu-item-object-page menu-item-home menu-item-954"><a href="/">Map Standard</a></li>
		<li id="menu-item-1260" class="menu-item menu-item-type-custom menu-item-object-custom menu-item-1260"><a href="/?fullscreen=yes">Map Fullscreen</a></li>
	</ul>
</li>
	<li id="menu-item-1334" class="menu-item menu-item-type-custom menu-item-object-custom menu-item-has-children menu-item-1334"><a href="#">Parallax</a>
	<ul  class="sub-menu">
		<li id="menu-item-1013" class="menu-item menu-item-type-post_type menu-item-object-page menu-item-1013"><a href="/homepage-with-image-2/">Parallax Standard</a></li>
		<li id="menu-item-2988" class="menu-item menu-item-type-post_type menu-item-object-page menu-item-2988"><a href="/homepage-with-image-fullscreen/">Parallax Fullscreen</a></li>
	</ul>
</li>
	<li id="menu-item-1335" class="menu-item menu-item-type-custom menu-item-object-custom menu-item-has-children menu-item-1335"><a href="#">Video</a>
	<ul  class="sub-menu">
		<li id="menu-item-953" class="menu-item menu-item-type-post_type menu-item-object-page menu-item-953"><a href="/homepage-with-video-2/">Video Standard</a></li>
		<li id="menu-item-1261" class="menu-item menu-item-type-custom menu-item-object-custom menu-item-1261"><a href="/homepage-with-video-2/?fullscreen=yes">Video Fullscreen</a></li>
	</ul>
</li>
	<li id="menu-item-1336" class="menu-item menu-item-type-custom menu-item-object-custom menu-item-has-children menu-item-1336"><a href="#">Sliders</a>
	<ul  class="sub-menu">
		<li id="menu-item-1065" class="menu-item menu-item-type-post_type menu-item-object-page menu-item-1065"><a href="/homepage-with-revolution-slider/">Slider Revolution</a></li>
		<li id="menu-item-1017" class="menu-item menu-item-type-post_type menu-item-object-page menu-item-1017"><a href="/homepage-with-properties-slider/">Properties Slider</a></li>
	</ul>
</li>
	<li id="menu-item-1338" class="menu-item menu-item-type-custom menu-item-object-custom menu-item-has-children menu-item-1338"><a href="#">Splash</a>
	<ul  class="sub-menu">
		<li id="menu-item-1274" class="menu-item menu-item-type-custom menu-item-object-custom menu-item-1274"><a href="/splash-page/?splash_type=video">Video Fullscreen</a></li>
		<li id="menu-item-1273" class="menu-item menu-item-type-custom menu-item-object-custom menu-item-1273"><a href="/splash-page/?splash_type=slider">Slider Fullscreen</a></li>
		<li id="menu-item-1275" class="menu-item menu-item-type-custom menu-item-object-custom menu-item-1275"><a href="/splash-page/?splash_type=image">Image Fullscreen</a></li>
	</ul>
</li>
</ul>
</li>
<li id="menu-item-352" class="menu-item menu-item-type-custom menu-item-object-custom current-menu-ancestor menu-item-has-children menu-item-352"><a href="#">Listing</a>
<ul  class="sub-menu">
	<li id="menu-item-1340" class="menu-item menu-item-type-custom menu-item-object-custom menu-item-has-children menu-item-1340"><a href="#">List View</a>
	<ul  class="sub-menu">
		<li id="menu-item-339" class="menu-item menu-item-type-post_type menu-item-object-page menu-item-339"><a href="/simple-listing-list-view/">List View Standard</a></li>
		<li id="menu-item-340" class="menu-item menu-item-type-post_type menu-item-object-page menu-item-340"><a href="/listing-full-width/">List View Fullwidth</a></li>
	</ul>
</li>
	<li id="menu-item-1341" class="menu-item menu-item-type-custom menu-item-object-custom menu-item-has-children menu-item-1341"><a href="#">Grid View</a>
	<ul  class="sub-menu">
		<li id="menu-item-465" class="menu-item menu-item-type-post_type menu-item-object-page menu-item-465"><a href="/simple-listing-grid-view/">Grid View Standard</a></li>
		<li id="menu-item-337" class="menu-item menu-item-type-post_type menu-item-object-page menu-item-337"><a href="/properties-grid-view-3-cols/">Grid View Fullwidth</a></li>
	</ul>
</li>
	<li id="menu-item-1342" class="menu-item menu-item-type-custom menu-item-object-custom current-menu-ancestor current-menu-parent menu-item-has-children menu-item-1342"><a href="#">Map</a>
	<ul  class="sub-menu">
		<li id="menu-item-388" class="menu-item menu-item-type-post_type menu-item-object-page menu-item-388"><a href="/listing-with-google-map/">Map Standard</a></li>
		<li id="menu-item-1264" class="menu-item menu-item-type-custom menu-item-object-custom menu-item-1264"><a href="/listing-with-google-map/?fullscreen=yes">Map Fullscreen</a></li>
		<li id="menu-item-1628" class="new-feature menu-item menu-item-type-post_type menu-item-object-page current-menu-item page_item page-item-1626 current_page_item menu-item-1628"><a href="/half-map/">Half Map</a></li>
	</ul>
</li>
	<li id="menu-item-1343" class="menu-item menu-item-type-custom menu-item-object-custom menu-item-has-children menu-item-1343"><a href="#">Parallax</a>
	<ul  class="sub-menu">
		<li id="menu-item-470" class="menu-item menu-item-type-post_type menu-item-object-page menu-item-470"><a href="/listing-with-image/">Parallax Standard</a></li>
		<li id="menu-item-2989" class="menu-item menu-item-type-post_type menu-item-object-page menu-item-2989"><a href="/listing-with-image-fullscreen/">Parallax Fullscreen</a></li>
	</ul>
</li>
	<li id="menu-item-1344" class="menu-item menu-item-type-custom menu-item-object-custom menu-item-has-children menu-item-1344"><a href="#">Video</a>
	<ul  class="sub-menu">
		<li id="menu-item-462" class="menu-item menu-item-type-post_type menu-item-object-page menu-item-462"><a href="/listing-with-video/">Video Standard</a></li>
		<li id="menu-item-1265" class="menu-item menu-item-type-custom menu-item-object-custom menu-item-1265"><a href="/listing-with-video/?fullscreen=yes">Video Fullscreen</a></li>
	</ul>
</li>
	<li id="menu-item-1346" class="menu-item menu-item-type-custom menu-item-object-custom menu-item-has-children menu-item-1346"><a href="#">Sliders</a>
	<ul  class="sub-menu">
		<li id="menu-item-1468" class="menu-item menu-item-type-post_type menu-item-object-page menu-item-1468"><a href="/listing-with-slider-revoluiton-2/">Slider Revolution</a></li>
		<li id="menu-item-410" class="menu-item menu-item-type-post_type menu-item-object-page menu-item-410"><a href="/listing-with-properties-slider/">Properties Slider</a></li>
	</ul>
</li>
</ul>
</li>
<li id="menu-item-314" class="menu-item menu-item-type-custom menu-item-object-custom menu-item-has-children menu-item-314"><a href="#">Property</a>
<ul  class="sub-menu">
	<li id="menu-item-346" class="menu-item menu-item-type-custom menu-item-object-custom menu-item-346"><a href="/property/luxury-apartment-bay-view/?s_top=v1">Single Property v1</a></li>
	<li id="menu-item-347" class="menu-item menu-item-type-custom menu-item-object-custom menu-item-347"><a href="/property/luxury-apartment-bay-view/?s_top=v2&#038;agent_form=yes">Single Property v2</a></li>
	<li id="menu-item-349" class="menu-item menu-item-type-custom menu-item-object-custom menu-item-349"><a href="/property/luxury-apartment-bay-view/?s_top=v3&#038;agent_form=yes">Single Property v3</a></li>
	<li id="menu-item-3038" class="new-feature menu-item menu-item-type-custom menu-item-object-custom menu-item-3038"><a href="/property/relaxing-apartment-bay-view/">Property Landing Page</a></li>
	<li id="menu-item-2317" class="new-feature menu-item menu-item-type-custom menu-item-object-custom menu-item-2317"><a href="/property/luxury-apartment-bay-view/?s_top=v4">Property Full Width Gallery</a></li>
	<li id="menu-item-370" class="menu-item menu-item-type-custom menu-item-object-custom menu-item-370"><a href="/property/luxury-apartment-bay-view/?s_layout=tabs">Single Property Tabs v1</a></li>
	<li id="menu-item-371" class="menu-item menu-item-type-custom menu-item-object-custom menu-item-371"><a href="/property/luxury-apartment-bay-view/?s_layout=tabs-vertical">Single Property Tabs v2</a></li>
	<li id="menu-item-2022" class="new-feature menu-item menu-item-type-custom menu-item-object-custom menu-item-2022"><a href="/property/luxury-apartment-with-pool/">Multi Units / Sub Lisitng</a></li>
	<li id="menu-item-2318" class="new-feature menu-item menu-item-type-custom menu-item-object-custom menu-item-2318"><a href="/property/luxury-apartment-bay-view/?s_top=v1&#038;prop_nav=yes">Property Nav on Scroll</a></li>
	<li id="menu-item-2322" class="new-feature menu-item menu-item-type-custom menu-item-object-custom menu-item-2322"><a href="/property/luxury-apartment-bay-view/?s_top=v1&#038;graph_type=line#stats">Property Stats Line Chart</a></li>
	<li id="menu-item-2323" class="new-feature menu-item menu-item-type-custom menu-item-object-custom menu-item-2323"><a href="/property/luxury-family-home-4/#stats">Property Stats Bar Chart</a></li>
</ul>
</li>
<li id="menu-item-471" class="menu-item menu-item-type-custom menu-item-object-custom menu-item-has-children menu-item-471"><a href="#">Pages</a>
<ul  class="sub-menu">
	<li id="menu-item-488" class="menu-item menu-item-type-custom menu-item-object-custom menu-item-has-children menu-item-488"><a href="#">Agent</a>
	<ul  class="sub-menu">
		<li id="menu-item-197" class="menu-item menu-item-type-post_type menu-item-object-page menu-item-197"><a href="/all-agents/">All Agents</a></li>
		<li id="menu-item-473" class="menu-item menu-item-type-post_type menu-item-object-houzez_agent menu-item-473"><a href="/agent/brittany-watkins/">Agent Profile</a></li>
	</ul>
</li>
	<li id="menu-item-3034" class="menu-item menu-item-type-custom menu-item-object-custom menu-item-has-children menu-item-3034"><a href="#">Agencies</a>
	<ul  class="sub-menu">
		<li id="menu-item-3033" class="new-feature menu-item menu-item-type-post_type menu-item-object-page menu-item-3033"><a href="/our-agencies/">Our Agencies</a></li>
		<li id="menu-item-2815" class="new-feature menu-item menu-item-type-post_type menu-item-object-houzez_agency menu-item-2815"><a href="/agencies/country-house-real-estate/">Agency Profile</a></li>
	</ul>
</li>
	<li id="menu-item-489" class="menu-item menu-item-type-custom menu-item-object-custom menu-item-has-children menu-item-489"><a href="#">Property Status</a>
	<ul  class="sub-menu">
		<li id="menu-item-476" class="menu-item menu-item-type-taxonomy menu-item-object-property_status menu-item-476"><a href="/status/for-rent/">For Rent</a></li>
		<li id="menu-item-477" class="menu-item menu-item-type-taxonomy menu-item-object-property_status menu-item-477"><a href="/status/for-sale/">For Sale</a></li>
	</ul>
</li>
	<li id="menu-item-490" class="menu-item menu-item-type-custom menu-item-object-custom menu-item-has-children menu-item-490"><a href="#">Property Type</a>
	<ul  class="sub-menu">
		<li id="menu-item-491" class="menu-item menu-item-type-taxonomy menu-item-object-property_type menu-item-491"><a href="/property-type/apartment/">Apartment</a></li>
		<li id="menu-item-492" class="menu-item menu-item-type-taxonomy menu-item-object-property_type menu-item-492"><a href="/property-type/single-family-home/">Single Family Home</a></li>
		<li id="menu-item-493" class="menu-item menu-item-type-taxonomy menu-item-object-property_type menu-item-493"><a href="/property-type/villa/">Villa</a></li>
	</ul>
</li>
	<li id="menu-item-494" class="menu-item menu-item-type-custom menu-item-object-custom menu-item-has-children menu-item-494"><a href="#">Property City</a>
	<ul  class="sub-menu">
		<li id="menu-item-495" class="menu-item menu-item-type-taxonomy menu-item-object-property_city menu-item-495"><a href="/city/miami/">Miami</a></li>
		<li id="menu-item-496" class="menu-item menu-item-type-taxonomy menu-item-object-property_city menu-item-496"><a href="/city/los-angeles/">Los Angeles</a></li>
		<li id="menu-item-498" class="menu-item menu-item-type-taxonomy menu-item-object-property_city menu-item-498"><a href="/city/new-york/">New York</a></li>
	</ul>
</li>
	<li id="menu-item-499" class="menu-item menu-item-type-custom menu-item-object-custom menu-item-has-children menu-item-499"><a href="#">Property County or State</a>
	<ul  class="sub-menu">
		<li id="menu-item-501" class="menu-item menu-item-type-taxonomy menu-item-object-property_state menu-item-501"><a href="/state/los-angeles/">Los Angeles</a></li>
		<li id="menu-item-503" class="menu-item menu-item-type-taxonomy menu-item-object-property_state menu-item-503"><a href="/state/new-york/">New York</a></li>
	</ul>
</li>
	<li id="menu-item-504" class="menu-item menu-item-type-custom menu-item-object-custom menu-item-has-children menu-item-504"><a href="#">Property Features</a>
	<ul  class="sub-menu">
		<li id="menu-item-505" class="menu-item menu-item-type-taxonomy menu-item-object-property_feature menu-item-505"><a href="/feature/swimming-pool/">Swimming Pool</a></li>
		<li id="menu-item-506" class="menu-item menu-item-type-taxonomy menu-item-object-property_feature menu-item-506"><a href="/feature/wifi/">WiFi</a></li>
		<li id="menu-item-507" class="menu-item menu-item-type-taxonomy menu-item-object-property_feature menu-item-507"><a href="/feature/lawn/">Lawn</a></li>
		<li id="menu-item-508" class="menu-item menu-item-type-taxonomy menu-item-object-property_feature menu-item-508"><a href="/feature/gym/">Gym</a></li>
		<li id="menu-item-509" class="menu-item menu-item-type-taxonomy menu-item-object-property_feature menu-item-509"><a href="/feature/laundry/">Laundry</a></li>
	</ul>
</li>
	<li id="menu-item-642" class="menu-item menu-item-type-custom menu-item-object-custom menu-item-has-children menu-item-642"><a href="#">Blog</a>
	<ul  class="sub-menu">
		<li id="menu-item-198" class="menu-item menu-item-type-post_type menu-item-object-page menu-item-198"><a href="/blog/">Simple Blog</a></li>
		<li id="menu-item-641" class="menu-item menu-item-type-post_type menu-item-object-page menu-item-641"><a href="/masonry-blog/">Masonry Blog</a></li>
	</ul>
</li>
	<li id="menu-item-720" class="menu-item menu-item-type-post_type menu-item-object-page menu-item-720"><a href="/about-houzez/">About Houzez</a></li>
	<li id="menu-item-694" class="menu-item menu-item-type-post_type menu-item-object-page menu-item-694"><a href="/typography/">Typography</a></li>
	<li id="menu-item-670" class="menu-item menu-item-type-post_type menu-item-object-page menu-item-670"><a href="/faq/">FAQs</a></li>
	<li id="menu-item-549" class="menu-item menu-item-type-custom menu-item-object-custom menu-item-549"><a href="/unknow">404 Page</a></li>
	<li id="menu-item-1103" class="menu-item menu-item-type-post_type menu-item-object-page menu-item-1103"><a href="/contact/">Contact</a></li>
</ul>
</li>
<li id="menu-item-533" class="houzez-megamenu menu-item menu-item-type-custom menu-item-object-custom menu-item-has-children menu-item-533"><a href="#">Modules</a>
<ul  class="sub-menu">
	<li id="menu-item-3026" class="menu-item menu-item-type-custom menu-item-object-custom menu-item-has-children menu-item-3026"><a href="#">Column 1</a>
	<ul  class="sub-menu">
		<li id="menu-item-561" class="menu-item menu-item-type-post_type menu-item-object-page menu-item-561"><a href="/advanced-search-2/">Advanced Search</a></li>
		<li id="menu-item-548" class="menu-item menu-item-type-post_type menu-item-object-page menu-item-548"><a href="/property-grids/">Property Grids</a></li>
		<li id="menu-item-557" class="menu-item menu-item-type-post_type menu-item-object-page menu-item-557"><a href="/property-carousels/">Property Carousels v1</a></li>
		<li id="menu-item-564" class="menu-item menu-item-type-post_type menu-item-object-page menu-item-564"><a href="/property-carousel-v2/">Property Carousel v2</a></li>
	</ul>
</li>
	<li id="menu-item-3027" class="menu-item menu-item-type-custom menu-item-object-custom menu-item-has-children menu-item-3027"><a href="#">Column 2</a>
	<ul  class="sub-menu">
		<li id="menu-item-570" class="menu-item menu-item-type-post_type menu-item-object-page menu-item-570"><a href="/property-cards-module/">Property Cards Module</a></li>
		<li id="menu-item-575" class="menu-item menu-item-type-post_type menu-item-object-page menu-item-575"><a href="/property-by-id/">Property by ID</a></li>
		<li id="menu-item-586" class="menu-item menu-item-type-post_type menu-item-object-page menu-item-586"><a href="/property-by-ids/">Property by IDs</a></li>
		<li id="menu-item-596" class="menu-item menu-item-type-post_type menu-item-object-page menu-item-596"><a href="/taxonomy-grids/">Taxonomy Grids</a></li>
	</ul>
</li>
	<li id="menu-item-3028" class="menu-item menu-item-type-custom menu-item-object-custom menu-item-has-children menu-item-3028"><a href="#">Column 3</a>
	<ul  class="sub-menu">
		<li id="menu-item-604" class="menu-item menu-item-type-post_type menu-item-object-page menu-item-604"><a href="/testimonials/">Testimonials</a></li>
		<li id="menu-item-2774" class="new-feature menu-item menu-item-type-post_type menu-item-object-page menu-item-2774"><a href="/membership-packages/">Membership Packages</a></li>
		<li id="menu-item-609" class="menu-item menu-item-type-post_type menu-item-object-page menu-item-609"><a href="/agents/">Agents</a></li>
		<li id="menu-item-1640" class="new-feature menu-item menu-item-type-post_type menu-item-object-page menu-item-1640"><a href="/team/">Team</a></li>
	</ul>
</li>
	<li id="menu-item-3029" class="menu-item menu-item-type-custom menu-item-object-custom menu-item-has-children menu-item-3029"><a href="#">Column 4</a>
	<ul  class="sub-menu">
		<li id="menu-item-612" class="menu-item menu-item-type-post_type menu-item-object-page menu-item-612"><a href="/partners/">Partners</a></li>
		<li id="menu-item-615" class="menu-item menu-item-type-post_type menu-item-object-page menu-item-615"><a href="/text-with-icons/">Text with icons</a></li>
		<li id="menu-item-650" class="menu-item menu-item-type-post_type menu-item-object-page menu-item-650"><a href="/blog-post-carousels/">Blog Post Carousels</a></li>
		<li id="menu-item-651" class="menu-item menu-item-type-post_type menu-item-object-page menu-item-651"><a href="/blog-post-grids/">Blog Post Grids</a></li>
	</ul>
</li>
</ul>
</li>
<li id="menu-item-2031" class="houzez-megamenu menu-item menu-item-type-custom menu-item-object-custom menu-item-has-children menu-item-2031"><a href="#">Search Styles</a>
<ul  class="sub-menu">
	<li id="menu-item-3030" class="menu-item menu-item-type-custom menu-item-object-custom menu-item-has-children menu-item-3030"><a href="#">Style 1</a>
	<ul  class="sub-menu">
		<li id="menu-item-2033" class="menu-item menu-item-type-custom menu-item-object-custom menu-item-2033"><a href="/?search_style=min1">Default Style 1 Above Banner</a></li>
		<li id="menu-item-2034" class="menu-item menu-item-type-custom menu-item-object-custom menu-item-2034"><a href="/?search_style=min1&#038;search_pos=under_banner">Default Style 1 Under Banner</a></li>
		<li id="menu-item-2032" class="menu-item menu-item-type-custom menu-item-object-custom menu-item-2032"><a href="/?search_style=v1">Advanced Style 1 Above Banner</a></li>
		<li id="menu-item-2035" class="menu-item menu-item-type-custom menu-item-object-custom menu-item-2035"><a href="/?search_style=v1&#038;search_pos=under_banner">Advanced Style 1 Under Banner</a></li>
	</ul>
</li>
	<li id="menu-item-3031" class="menu-item menu-item-type-custom menu-item-object-custom menu-item-has-children menu-item-3031"><a href="#">Style 2</a>
	<ul  class="sub-menu">
		<li id="menu-item-2038" class="menu-item menu-item-type-custom menu-item-object-custom menu-item-2038"><a href="/?search_style=min2">Default Style 2 Above Banner</a></li>
		<li id="menu-item-2039" class="menu-item menu-item-type-custom menu-item-object-custom menu-item-2039"><a href="/?search_style=min2&#038;search_pos=under_banner">Default Style 2 Under Banner</a></li>
		<li id="menu-item-2036" class="menu-item menu-item-type-custom menu-item-object-custom menu-item-2036"><a href="/?search_style=v2">Advanced Style 2 Above Banner</a></li>
		<li id="menu-item-2037" class="menu-item menu-item-type-custom menu-item-object-custom menu-item-2037"><a href="/?search_style=v2&#038;search_pos=under_banner">Advanced Style 2 Under Banner</a></li>
	</ul>
</li>
	<li id="menu-item-3032" class="menu-item menu-item-type-custom menu-item-object-custom menu-item-has-children menu-item-3032"><a href="#">Style 3 / 4 / 5</a>
	<ul  class="sub-menu">
		<li id="menu-item-2040" class="menu-item menu-item-type-custom menu-item-object-custom menu-item-2040"><a href="/homepage-with-revolution-slider/">Advanced Style 3</a></li>
		<li id="menu-item-2041" class="new-feature menu-item menu-item-type-custom menu-item-object-custom menu-item-2041"><a href="/advanced-search-4/">Advanced Style 4</a></li>
		<li id="menu-item-2042" class="menu-item menu-item-type-custom menu-item-object-custom menu-item-2042"><a href="/homepage-with-image-2/">Simple Style 5</a></li>
	</ul>
</li>
</ul>
</li>
</ul>            </nav>
        </div>

                                    <div class="header-right">
                    
    <div class="user">

            <a href="#" data-toggle="modal" data-target="#pop-login"><i class="fa fa-user hidden-md hidden-lg"></i> <span class="hidden-sm hidden-xs">Sign In / Register</span></a><a href="/add-new-property/" class="btn btn-default hidden-xs hidden-sm">Create Listing</a>    </div>
                </div>
                        </div>

</header>
<!--end section header-->


<div class="header-mobile houzez-header-mobile "  data-sticky="0">
	<div class="container">
		<!--start mobile nav-->
		<div class="mobile-nav">
			<span class="nav-trigger"><i class="fa fa-navicon"></i></span>
			<div class="nav-dropdown main-nav-dropdown"></div>
		</div>
		<!--end mobile nav-->
		<div class="header-logo logo-mobile">
			<a href="/">
           <img src="<?php echo smarty_function_themes_url(array(),$_smarty_tpl);?>
/houzez01/wp-content/uploads/2016/03/logo-houzez-color.png" alt="Mobile logo">
    </a>		</div>
									<div class="header-user">
					 
    <ul class="account-action">
        <li>
            <span class="user-icon"><i class="fa fa-user"></i></span>
            <div class="account-dropdown">
                <ul>
                    <li><a href="/add-new-property/"> <i class="fa fa-plus-circle"></i>Create Listing</a></li><li> <a href="#" data-toggle="modal" data-target="#pop-login"> <i class="fa fa-user"></i>Sign In / Register</a></li>                </ul>
            </div>
        </li>
    </ul>
				</div>
						</div>
</div>

<div id="section-body" class="houzez-body-half landing-page">

	
	

<!--start compare panel-->
<div id="compare-controller" class="compare-panel">
    <div class="compare-panel-header">
        <h4 class="title"> Compare Listings <span class="panel-btn-close pull-right"><i class="fa fa-times"></i></span></h4>
    </div>
    
        <div id="compare-properties-basket">
                </div>
</div>
<!--end compare panel-->
<div class="container-fluid">
    <div class="row">

        <div class="col-md-6 col-sm-6 col-xs-12 no-padding">
            <div id="houzez-gmap-main" class="fave-screen-fix">
                <div id="mapViewHalfListings" class="map-half">
                </div>
                <div id="houzez-map-loading">
                    <div class="mapPlaceholder">
                        <div class="loader-ripple">
                            <div></div>
                            <div></div>
                        </div>
                    </div>
                </div>
                <input type="hidden" id="securityHouzezHeaderMap" name="securityHouzezHeaderMap" value="d96dfe76db" /><input type="hidden" name="_wp_http_referer" value="/half-map/" />
                <div  class="map-arrows-actions">
                    <button id="listing-mapzoomin" class="map-btn"><i class="fa fa-plus"></i> </button>
                    <button id="listing-mapzoomout" class="map-btn"><i class="fa fa-minus"></i></button>
                    <input type="text" id="google-map-search" placeholder="Google Map Search" class="map-search">
                </div>
                <div class="map-next-prev-actions">
                    <ul class="dropdown-menu" aria-labelledby="houzez-gmap-view">
                        <li><a href="#" class="houzezMapType" data-maptype="roadmap"><span>Roadmap</span></a></li>
                        <li><a href="#" class="houzezMapType" data-maptype="satellite"><span>Satelite</span></a></li>
                        <li><a href="#" class="houzezMapType" data-maptype="hybrid"><span>Hybrid</span></a></li>
                        <li><a href="#" class="houzezMapType" data-maptype="terrain"><span>Terrain</span></a></li>
                    </ul>
                    <button id="houzez-gmap-view" class="map-btn dropdown-toggle" type="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="true"><i class="fa fa-globe"></i> <span>View</span></button>

                    <button id="houzez-gmap-prev" class="map-btn"><i class="fa fa-chevron-left"></i> <span>Prev</span></button>
                    <button id="houzez-gmap-next" class="map-btn"><span>Next</span> <i class="fa fa-chevron-right"></i></button>
                </div>
                <div  class="map-zoom-actions">
                                                                <span id="houzez-gmap-full"  class="map-btn"><i class="fa fa-arrows-alt"></i> <span>Fullscreen</span></span>
                                    </div>

            </div>
        </div>

        <div class="col-md-6 col-sm-6 col-xs-12 no-padding">
            <div class="module-half map-module-half fave-screen-fix">
                <div class="advanced-search houzez-adv-price-range">

    <form autocomplete="off" method="get" class="save_search_form" action="#">

                    <input type="hidden" name="search_radius" id="radius-range-value">
            <input type="hidden" name="lat" value="" id="latitude">
            <input type="hidden" name="lng" value="" id="longitude">
        <div class="row">
            
            <div class="col-md-12 col-sm-12 col-xs-12">
                <div class="form-group">
                    <div class="search-location">
                        <input type="text" class="form-control search_location" value="" name="search_location" placeholder="Location">
                        <i class="location-trigger fa fa-dot-circle-o"></i>
                    </div>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-sm-3 col-xs-3">
                <div class="form-group">
                    <div class="radius-text-wrap">
                        <label class="checkbox-inline">
                            <input type="checkbox" name="use_radius" id="use_radius"  checked='checked'> Radius: <strong><span id="radius-range-text">0</span> km</strong>
                        </label>
                    </div>
                </div>
            </div>
            <div class="col-sm-9 col-xs-9">
                <div class="radius-range-wrap">
                    <div id="radius-range-slider"></div>
                </div>
            </div>
        </div>
        
        <div class="row">

            
            
            
            

            

                        <div class="col-md-3 col-sm-6 col-xs-6">
                <div class="form-group">
                    <select class="selectpicker" name="status" data-live-search="false" data-live-search-style="begins">
                        <option value="">All Status</option><option value="for-rent"> For Rent</option><option value="for-sale"> For Sale</option><option value="foreclosures"> Foreclosures</option><option value="new-costruction"> New Costruction</option><option value="new-listing"> New Listing</option><option value="open-house"> Open House</option><option value="reduced-price"> Reduced Price</option><option value="resale"> Resale</option>                    </select>
                </div>
            </div>
            

                        <div class="col-md-3 col-sm-6 col-xs-6">
                <div class="form-group">
                    <select class="selectpicker" name="type" data-live-search="false" data-live-search-style="begins">
                        <option value="">All Types</option><option value="apartment"> Apartment</option><option value="condo"> Condo</option><option value="farm"> Farm</option><option value="loft"> Loft</option><option value="lot"> Lot</option><option value="multi-family-home"> Multi Family Home</option><option value="single-family-home"> Single Family Home</option><option value="townhouse"> Townhouse</option><option value="villa"> Villa</option>                    </select>
                </div>
            </div>
            
            
            
                        <div class="col-md-3 col-sm-6 col-xs-6">
                <div class="form-group">
                    <select name="bedrooms" class="selectpicker" data-live-search="false" data-live-search-style="begins" title="">
                        <option value="">Bedrooms</option>
                        <option value="1">1</option><option value="2">2</option><option value="3">3</option><option value="4">4</option><option value="5">5</option><option value="6">6</option><option value="7">7</option><option value="8">8</option><option value="9">9</option><option value="10">10</option><option value="any">Any</option>                    </select>
                </div>
            </div>
            
                        <div class="col-md-3 col-sm-6 col-xs-6">
                <div class="form-group">
                    <select name="bathrooms" class="selectpicker" data-live-search="false" data-live-search-style="begins" title="">
                        <option value="">Bathrooms</option>
                        <option value="1">1</option><option value="2">2</option><option value="3">3</option><option value="4">4</option><option value="5">5</option><option value="6">6</option><option value="7">7</option><option value="8">8</option><option value="9">9</option><option value="10">10</option><option value="any">Any</option>                    </select>
                </div>
            </div>
            

                        <div class="col-md-3 col-sm-6 col-xs-6">
                <div class="form-group">
                    <input type="text" class="form-control" value="" name="min-area" placeholder="Min Area">
                </div>
            </div>
            
                        <div class="col-md-3 col-sm-6 col-xs-6">
                <div class="form-group">
                    <input type="text" class="form-control" value="" name="max-area" placeholder="Max Area">
                </div>
            </div>
            
            
                                                <div class="col-sm-12 col-xs-12">
                        <div class="range-advanced-main">
                            <div class="range-text">
                                <input type="hidden" name="min-price" class="min-price-range-hidden range-input" readonly >
                                <input type="hidden" name="max-price" class="max-price-range-hidden range-input" readonly >
                                <p><span class="range-title">Price Range:</span> From <span class="min-price-range"></span> to <span class="max-price-range"></span></p>
                            </div>
                            <div class="range-wrap">
                                <div class="price-range-advanced"></div>
                            </div>
                        </div>
                    </div>
                
            
        </div>

        <div class="row">
            <div class="col-sm-12 col-xs-12 advance-trigger-wrap">
                                <label class="advance-trigger"><i class="fa fa-plus-square"></i> Other Features </label>
                                                <span  id="save_search_click" class="save-btn">Save</span>
                <input type="hidden" name="search_args" value="">
                <input type="hidden" name="search_URI" value="/half-map/">
                <input type="hidden" name="action" value='houzez_save_search'>
                <input type="hidden" name="houzez_save_search_ajax" value="47824db9b0">
                            </div>
            <div class="col-sm-12 col-xs-12">
                <div class="features-list field-expand">
                    <div class="clearfix"></div>
                    <label class="checkbox-inline"><input name="feature[]" id="feature-air-conditioning" type="checkbox"  value="air-conditioning">Air Conditioning</label><label class="checkbox-inline"><input name="feature[]" id="feature-barbeque" type="checkbox"  value="barbeque">Barbeque</label><label class="checkbox-inline"><input name="feature[]" id="feature-dryer" type="checkbox"  value="dryer">Dryer</label><label class="checkbox-inline"><input name="feature[]" id="feature-gym" type="checkbox"  value="gym">Gym</label><label class="checkbox-inline"><input name="feature[]" id="feature-laundry" type="checkbox"  value="laundry">Laundry</label><label class="checkbox-inline"><input name="feature[]" id="feature-lawn" type="checkbox"  value="lawn">Lawn</label><label class="checkbox-inline"><input name="feature[]" id="feature-microwave" type="checkbox"  value="microwave">Microwave</label><label class="checkbox-inline"><input name="feature[]" id="feature-outdoor-shower" type="checkbox"  value="outdoor-shower">Outdoor Shower</label><label class="checkbox-inline"><input name="feature[]" id="feature-refrigerator" type="checkbox"  value="refrigerator">Refrigerator</label><label class="checkbox-inline"><input name="feature[]" id="feature-sauna" type="checkbox"  value="sauna">Sauna</label><label class="checkbox-inline"><input name="feature[]" id="feature-swimming-pool" type="checkbox"  value="swimming-pool">Swimming Pool</label><label class="checkbox-inline"><input name="feature[]" id="feature-tv-cable" type="checkbox"  value="tv-cable">TV Cable</label><label class="checkbox-inline"><input name="feature[]" id="feature-washer" type="checkbox"  value="washer">Washer</label><label class="checkbox-inline"><input name="feature[]" id="feature-wifi" type="checkbox"  value="wifi">WiFi</label><label class="checkbox-inline"><input name="feature[]" id="feature-window-coverings" type="checkbox"  value="window-coverings">Window Coverings</label>                </div>
            </div>
        </div>


        <div class="row">
            <div class="col-sm-12 col-xs-12">
                <button type="submit" id="half_map_update" class="btn btn-primary btn-block">Update</button>
            </div>
        </div>

    </form>
</div>                <!--start latest listing module-->
                <div class="houzez-module">
                    <!--start list tabs-->
                    <div class="list-tabs table-list full-width">
                        <div class="tabs table-cell">
                            <h2 class="tabs-title">Half Map</h2>
                            <?php echo RealEstate::function_plugin(array('template'=>"fx"),$_smarty_tpl);?>

                        </div>
                                                <div class="sort-tab table-cell text-right">
                            <span class="view-btn btn-list active"><i class="fa fa-th-list"></i></span>
                            <span class="view-btn btn-grid "><i class="fa fa-th-large"></i></span>
                        </div>
                                            </div>
                    <!--end list tabs-->
                    <div class="property-listing list-view">
                        <div class="row">
                            <div id="houzez_ajax_container">

                            </div>
                        </div>

                    </div>
                </div>
                <!--end latest listing module-->

            </div>
        </div>
    </div>
</div>

</div><!-- #section Body -->
<?php $_smarty_tpl->_subTemplateRender('cms_template:INC_Scripts', $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, $_smarty_tpl->cache_lifetime, array(), 0, false);
?>

</body>
</html><?php }
}
