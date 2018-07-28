<?php
/* Smarty version 3.1.31, created on 2018-01-18 02:51:33
  from "cms_template:139" */

/* @var Smarty_Internal_Template $_smarty_tpl */
if ($_smarty_tpl->_decodeProperties($_smarty_tpl, array (
  'version' => '3.1.31',
  'unifunc' => 'content_5a5f9b352f1277_88546095',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    '4989144952850403d622bfa1d647f235290f80e1' => 
    array (
      0 => 'cms_template:139',
      1 => '1516213759',
      2 => 'cms_template',
    ),
    '2937aa11b4f3eaf1373deabeee1790347faf0fdf' => 
    array (
      0 => 'cms_template:INC_Styles',
      1 => '1514742659',
      2 => 'cms_template',
    ),
    '3d33a904aa0fe709ea6bf8c282409460ecfdda40' => 
    array (
      0 => 'cms_template:INC_Scripts',
      1 => '1514998481',
      2 => 'cms_template',
    ),
  ),
  'includes' => 
  array (
    'cms_template:INC_Styles' => 1,
    'cms_template:INC_Scripts' => 1,
  ),
),false)) {
function content_5a5f9b352f1277_88546095 (Smarty_Internal_Template $_smarty_tpl) {
if (!is_callable('smarty_function_cms_get_language')) require_once 'E:\\xampp\\htdocs\\public_html\\cms_version2\\cms2231_houzez\\lib\\plugins\\function.cms_get_language.php';
if (!is_callable('smarty_function_metadata')) require_once 'E:\\xampp\\htdocs\\public_html\\cms_version2\\cms2231_houzez\\lib\\plugins\\function.metadata.php';
if (!is_callable('smarty_function_themes_url')) require_once 'E:\\xampp\\htdocs\\public_html\\cms_version2\\cms2231_houzez\\lib\\plugins\\function.themes_url.php';
$_smarty_tpl->smarty->ext->_capture->open($_smarty_tpl, 'default', null, null);
$_smarty_tpl->smarty->ext->_capture->close($_smarty_tpl);?><!DOCTYPE html>
<html lang="<?php echo smarty_function_cms_get_language(array(),$_smarty_tpl);?>
">
<head>
	<?php echo smarty_function_metadata(array(),$_smarty_tpl);?>

    
    <?php
$_smarty_tpl->_subTemplateRender('cms_template:INC_Styles', $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, $_smarty_tpl->cache_lifetime, array(), 0, false, '2937aa11b4f3eaf1373deabeee1790347faf0fdf', 'content_5a5f9b34e645d1_96111714');
?>

	
</head>
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
<?php
$_smarty_tpl->_subTemplateRender('cms_template:INC_Scripts', $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, $_smarty_tpl->cache_lifetime, array(), 0, false, '3d33a904aa0fe709ea6bf8c282409460ecfdda40', 'content_5a5f9b350a8503_85437698');
?>

</body>
</html><?php }
/* Start inline template "cms_template:139" =============================*/
function content_5a5f9b34e645d1_96111714 ($_smarty_tpl) {
?>


<?php echo '<script'; ?>
>
    /* You can add more configuration options to webfontloader by previously defining the WebFontConfig with your options */
    if ( typeof WebFontConfig === "undefined" ) {
        WebFontConfig = new Object();
    }
    WebFontConfig['google'] = {families: ['Roboto:400,500']};

    (function() {
        var wf = document.createElement( 'script' );
        wf.src = 'https://ajax.googleapis.com/ajax/libs/webfont/1.5.3/webfont.js';
        wf.type = 'text/javascript';
        wf.async = 'true';
        var s = document.getElementsByTagName( 'script' )[0];
        s.parentNode.insertBefore( wf, s );
    })();
<?php echo '</script'; ?>
>

<link rel='stylesheet' id='contact-form-7-css'  href='<?php echo smarty_function_themes_url(array(),$_smarty_tpl);?>
/houzez01/wp-content/plugins/contact-form-7/includes/css/styles.css?ver=4.9.1' type='text/css' media='all' />
<link rel='stylesheet' id='rs-plugin-settings-css'  href='<?php echo smarty_function_themes_url(array(),$_smarty_tpl);?>
/houzez01/wp-content/plugins/revslider/public/assets/css/settings.css?ver=5.4.5.2' type='text/css' media='all' />
<link rel='stylesheet' id='bootstrap.min-css'  href='<?php echo smarty_function_themes_url(array(),$_smarty_tpl);?>
/houzez01/wp-content/themes/houzez/css/bootstrap.min.css?ver=3.3.5' type='text/css' media='all' />
<link rel='stylesheet' id='font-awesome.min-css'  href='<?php echo smarty_function_themes_url(array(),$_smarty_tpl);?>
/houzez01/wp-content/themes/houzez/css/font-awesome.min.css?ver=4.7.0' type='text/css' media='all' />
<link rel='stylesheet' id='houzez-all-css'  href='<?php echo smarty_function_themes_url(array(),$_smarty_tpl);?>
/houzez01/wp-content/themes/houzez/css/all.min.css?ver=1.5.7' type='text/css' media='all' />
<link rel='stylesheet' id='houzez-main-css'  href='<?php echo smarty_function_themes_url(array(),$_smarty_tpl);?>
/houzez01/wp-content/themes/houzez/css/main.css?ver=1.5.7' type='text/css' media='all' />
<link rel='stylesheet' id='houzez-style-css'  href='<?php echo smarty_function_themes_url(array(),$_smarty_tpl);?>
/houzez01/wp-content/themes/houzez/style.css?ver=1.5.7' type='text/css' media='all' />

<style id='houzez-style-inline-css' type='text/css'>

        .advance-search-header, 
        .advanced-search-mobile, 
        .advanced-search-mobile .single-search .form-control,
        .search-expandable .advanced-search {
            background-color: #004274;
        }
        .search-expand-btn {
            background-color: #00aeef;
        }
        .search-expand-btn {
            color: #ffffff
        }
        .advance-search-header .houzez-theme-button,
        .advanced-search-mobile .houzez-theme-button,
        .splash-search .btn-secondary,
        .advanced-search .btn-secondary {
            color: #ffffff;
            background-color: #00aeef;
            border: 1px solid #00aeef;
        }
        .advance-search-header .houzez-theme-button:focus,
        .advanced-search-mobile .houzez-theme-button:focus,
        .advanced-search .btn-secondary:focus,
        .splash-search .btn-secondary:focus {
          color: #ffffff;
          background-color: #007baf;
          border: 1px solid #007baf;
        }
        .advance-search-header .houzez-theme-button:hover,
        .advanced-search .btn-secondary:hover,
        .advanced-search .btn-secondary:active,
        .advanced-search .btn-secondary:active:hover,
        .advanced-search .btn-secondary.active,
        .advanced-search-mobile .houzez-theme-button:hover,
        .splash-search .btn-secondary:hover {
          color: #ffffff;
          background-color: #007baf;
          border: 1px solid #007baf;
        }
        .advance-search-header .houzez-theme-button:active,
        .advanced-search .btn-secondary:active,
        .advanced-search-mobile .houzez-theme-button:active,
        .splash-search .btn-secondary:active {
          color: #ffffff;
          background-color: #004274;
          border: 1px solid #004274;
        }
        .advanced-search .form-control,
        .advance-search-header .bootstrap-select .btn,
        .advance-search-header .bootstrap-select .fave-load-more a,
        .fave-load-more .advance-search-header .bootstrap-select a,
        .advance-fields .form-control{
            border: 1px solid #cccccc;
        }
        .advanced-search .input-group .form-control,        
        .search-long .search input,
        .advanced-search .search-long .search,
        .advanced-search .search-long .btn-group,
        .advanced-search .search-long .advance-btn,
        .input-group-addon {
            border-color: #cccccc !important;
        }
        .advanced-search-mobile .advance-fields {
            border-top: 1px solid #cccccc;
        }
        .advanced-search-mobile .single-search-wrap button {
            color: #cccccc;
        }

        .advanced-search-mobile .advance-fields::after {
            border-bottom-color: #cccccc;
        }
        .advanced-search-mobile .single-search-inner .form-control::-moz-placeholder {
            color: #cccccc;
        }
        .advanced-search-mobile .single-search-inner .form-control:-ms-input-placeholder {
            color: #cccccc;
        }
        .advanced-search-mobile .single-search-inner .form-control::-webkit-input-placeholder {
            color: #cccccc;
        }
        .advance-btn.blue {
            color: #ffffff;
        }
        .advance-btn.blue:hover,
        .advance-btn.blue:focus {
            color: #007baf;
        }
        .advanced-search .advance-btn {
            color: #00AEEF;
        }
        .advanced-search .advance-btn:hover {
            color:#00AEEF;
        }
        .advanced-search .advance-btn:focus,
        .advanced-search .advance-btn.active {
            color:#00AEEF;
        }
        .advanced-search .advance-fields,
        .advanced-search .features-list label.title,
        .advanced-search .features-list .checkbox-inline,
        .advanced-search-mobile .advance-fields,
        .advanced-search-mobile .features-list label.title,
        .advanced-search-mobile .features-list .checkbox-inline,
        .range-title,
        .range-text,
        .range-text p,
        .min-price-range,
        .max-price-range,
        .advanced-search-mobile, 
        .advanced-search-mobile .single-search-inner .form-control {
            color: #ffffff;
        }
        .advanced-search-mobile .single-search-inner .form-control::-moz-placeholder {
          color: #ffffff !important;         
        }
        .advanced-search-mobile .single-search-inner .form-control:-ms-input-placeholder {
          color: #ffffff !important;
        }
        .advanced-search-mobile .single-search-inner .form-control::-webkit-input-placeholder {
          color: #ffffff !important;
        }
        .top-bar {
            background-color: #000000;
        }
        .top-bar .top-nav > ul > li > a:hover,
        .top-bar .top-nav > ul li.active > a,
        .top-bar .top-nav > ul ul a:hover,
        .top-contact a:hover,
        .top-bar .dropdown-menu > li:hover,
        .top-contact li .btn:hover {
            color: rgba(0,174,239,0.75);
        }
        .top-contact a,
        .top-contact li,
        .top-contact li .btn,
        .top-bar .top-nav > ul > li > a {
            color: #ffffff;
        }
        .top-bar .mobile-nav .nav-trigger {
            color: #FFFFFF;
        }
        
        body {
            background-color: #f8f8f8;
        }
        a,        
        .blue,
        .text-primary,
        .btn-link,
        .item-body h2,
        .detail h3,
        .breadcrumb li a,
        .fave-load-more a,
        .sort-tab .btn,
        .sort-tab .fave-load-more a,
        .fave-load-more .sort-tab a,
        .pagination-main .pagination a,
        .team-caption-after .team-name a:hover,
        .team-caption-after .team-designation a:hover,
        .agent-media .view,
        .my-property-menu a.active,
        .my-property-menu a:hover,
        .search-panel .advance-trigger{        
            color: #00aeef;
        }
        .banner-caption h1,
        .banner-caption h2  {
            color: #ffffff;
        }
        .property-item h2 a,
        .property-item .property-title a,
        .widget .media-heading a {
            color: #000000;
        }
        .property-item h2 a:hover,
        .property-item .property-title a:hover,
        .widget .media-heading a:hover {
            color: #00aeef;
        }
        .owl-theme .owl-nav [class*=owl-],        
        .testimonial-carousel .owl-nav [class*=owl-]:hover,
        .testimonial-carousel .owl-nav [class*=owl-]:focus,
        .gallery-thumb .icon{
            background-color: #00aeef;
        }
        #sidebar .widget_tag_cloud .tagcloud a,
        .article-footer .meta-tags a,
        .pagination-main .pagination li.active a,
        .other-features .btn.btn-secondary,
        .my-menu .active a,        
        .houzez-module .module-title-nav .module-nav .btn,
        .houzez-module .module-title-nav .module-nav .fave-load-more a,
        .fave-load-more .houzez-module .module-title-nav .module-nav a {
            color: #fff;
            background-color: #00aeef;
            border: 1px solid #00aeef;
        }
        .plan-tabs li.active {
            box-shadow: inset 0 4px 0 #00aeef;
            border-top-color: #00aeef;
            background-color: #fff;
            color: #00aeef;
        }
        .btn-primary,        
        .label-primary,
        .scrolltop-btn {
            color: #fff;
            background-color: #00aeef;
            border-color: #00aeef;
        }
        .btn-primary.btn-trans{
            color: #00aeef;
        }
        .header-section-2 .header-top-call {
            color: #ffffff;
            background-color: #00aeef;
        }
        .header-section-2 .avatar {
            color: #ffffff;
        }
        @media (max-width: 991px) {
            .header-section-2 .header-top {
                background-color: #00aeef;
            }
        }
        .modal-header,
        .ui-slider-horizontal .ui-slider-range,
        .ui-state-hover,
        .ui-widget-content .ui-state-hover,
        .ui-widget-header .ui-state-hover,
        .ui-state-focus,
        .ui-widget-content .ui-state-focus,
        .ui-widget-header .ui-state-focus,
        .list-loading-bar{
            background-color: #00aeef;
            border-color: transparent;
        }
        .houzez-module .module-title-nav .module-nav .btn {
            color: #00aeef;
            border: 1px solid #00aeef;
            background-color: transparent;
        }
        .fave-load-more a,
        .fave-load-more a:hover {
            border: 1px solid #00aeef;
        }
        #transportation,
        #supermarkets,
        #schools,
        #libraries,
        #pharmacies,
        #hospitals,
        .pay-step-block.active span,
        .loader-ripple div:nth-of-type(2){
            border-color: #00aeef;
        }
        .loader-ripple div:nth-of-type(1){
            border-color: #ff6e00;
        }
        .detail-block .alert-info {
            color: rgba(0,0,0,.85);
            background-color: rgba(0,174,239,0.1);
            border: 1px solid #00aeef;
        }
        .houzez-taber-wrap .houzez-tabs li.active::before,
        .houzez-taber-wrap .houzez-tabs li:hover::before,
        .houzez-taber-wrap .houzez-tabs li:active::before,
        .profile-tabs li:hover,
        .steps-nav, .steps-progress-main .steps-progress span {
            background-color: #00aeef;
        }
        .btn-secondary,
        .agent_contact_form.btn-secondary,
         .form-media .wpcf7-submit,
         .wpcf7-submit,
         .dsidx-resp-area-submit input[type='submit']{
            color: #fff;
            background-color: #ff6e00;
            border-color: #ff6e00;
        }
        .btn-secondary.btn-trans{
            color: #ff6e00;
        }
        .item-thumb .label-featured, figure .label-featured, .carousel-module .carousel .item figure .label-featured {
            background-color: #77c720;
            color: #ffffff;
        }
            a:hover,
            a:focus,
            a:active,
            .blue:hover,
            .btn-link:hover,
            .breadcrumb li a:hover,
            .pagination-main .pagination a:hover,
            .vc_toggle_title h4:hover ,
            .footer a:hover,
            .impress-address:hover,
            .agent-media .view:hover,
            .my-property .dropdown-menu a:hover,
            .article-detail .article-title a:hover,
            .comments-block .article-title a:hover{
                color: rgba(0,174,239,0.75);
                text-decoration: none;
            }
            
            .detail-top .media-tabs a:hover span,
            .header-section.slpash-header .header-right a.btn:hover,
            .slpash-header.header-section-4 .header-right a.btn:hover,
            .houzez-module .module-title-nav .module-nav .btn:hover,
            .houzez-module .module-title-nav .module-nav .fave-load-more a:hover,
            .fave-load-more .houzez-module .module-title-nav .module-nav a:hover,
            .houzez-module .module-title-nav .module-nav .btn:focus,
            .houzez-module .module-title-nav .module-nav .fave-load-more a:focus,
            .fave-load-more .houzez-module .module-title-nav .module-nav a:focus{
                color: #fff;
                background-color: rgba(0,174,239,0.75);
                border: 1px solid rgba(0,174,239,0.75);
            }
            .fave-load-more a:hover,
            #sidebar .widget_tag_cloud .tagcloud a:hover,
            .article-footer .meta-tags a:hover,
            .other-features .btn.btn-secondary:hover,
            .my-actions .action-btn:hover,
            .my-actions .action-btn:focus,
            .my-actions .action-btn:active,
            .my-actions .open .action-btn{
                background-color: rgba(0,174,239,0.75);
                border-color: rgba(0,174,239,0.75);
            }
            .owl-theme .owl-nav [class*=owl-]:hover,
            .owl-theme .owl-nav [class*=owl-]:focus,
            .owl-theme .owl-nav [class*=owl-]:active,
            .testimonial-carousel .owl-nav [class*=owl-]:hover,
            .testimonial-carousel .owl-nav [class*=owl-]:focus{
                border-color: rgba(0,174,239,0.75);
            }
            .owl-theme .owl-nav [class*=owl-]:hover,
            .owl-theme .owl-nav [class*=owl-]:focus,
            .owl-theme .owl-nav [class*=owl-]:active,{
                background-color: rgba(0,174,239,0.75);
            }
            .btn-primary:hover,
            .btn-primary:focus,
            .btn-primary:active,
            .btn-primary.active,
            .btn-primary:active:hover,
            .btn-primary.btn-trans:hover,
            .btn-primary.btn-trans:focus,
            .btn-primary.btn-trans:active,
            .btn-primary.btn-trans.active,
            .btn-primary.btn-trans:active:hover,
            .invoice-list .btn-invoice:hover,
            #houzez-gmap-main .map-btn:hover,
            .media-tabs-list li > a:hover,
            .media-tabs-list li.active a,
            .detail-bar .detail-tabs li:hover,
            .actions li > span:hover,
            .lightbox-arrow:hover,
            .scrolltop-btn:hover {
                background-color: rgba(0,174,239,0.75);
                border-color: rgba(0,174,239,0.75);
            }
            .btn-secondary:hover,
            .btn-secondary:focus,
            .btn-secondary:active,
            .btn-secondary.active,
            .btn-secondary:active:hover,
            .btn-secondary.btn-trans:hover,
            .btn-secondary.btn-trans:focus,
            .btn-secondary.btn-trans:active,
            .btn-secondary.btn-trans.active,
            .btn-secondary.btn-trans:active:hover,
            .agent_contact_form.btn-secondary:hover,
             .form-media .wpcf7-submit:hover,
             .wpcf7-submit:hover,
             .wpcf7-submit:focus,
             .wpcf7-submit:active,
             .dsidx-resp-area-submit input[type='submit']:hover,
             .dsidx-resp-area-submit input[type='submit']:focus,
             .dsidx-resp-area-submit input[type='submit']:active{
                color: #fff;
                background-color: rgba(255,110,0,1);
                border-color: rgba(255,110,0,1);
            }
        .header-section {
            background-color: ;
        }
        .header-section .navi > ul > li > a {
            color: ;
            background-color: transparent;
        }
        .header-section .header-right .user a,
        .header-section .header-right span {
            color: ;
        }
            .header-section .navi > ul > li > a:hover {
                color: rgba(255,255,255,1);
                background-color: rgba(255,255,255,0.2);
            }
            .header-section .header-right .user a:hover,
            .header-section .header-right span:hover {
                color: rgba(255,255,255,1);
            }
        .header-section-3 .header-top {
            background-color: ;
        }
        .header-section-3 .header-top-social a,
        .header-section-3 .header-contact .contact-block .fa,
        .header-section-3 .header-top .media-heading,
        .header-contact .contact-block p{
            color: ;
        }
        .header-contact .contact-block .fa {
            color: ;
        }
        .header-section-3 .header-bottom {
            background-color: ;
        }
        .header-section-3 .navi > ul > li > a,
        .header-section-3 .header-right .user a,
        .header-section-3 .header-right span {
            color: ;
        }        
        .header-section-3 .header-right .user {
            line-height: 60px;
        }
            .header-section-3 .navi > ul > li > a:hover,
            .header-section-3 .navi > ul > li.active > a{
                color: rgba(255,255,255,1);
                background-color: rgba(255,255,255,0.2);
            }
            .header-section-3 .header-right .user a:hover,
            .header-section-3 .header-right span:hover {
                color: rgba(255,255,255,1);
            }
            .header-section-3 .navi > ul > li {
                border-right: 1px solid rgba(255,255,255,0.2);
            }
            .header-section-3 .header-bottom {
                border-top: 1px solid rgba(255,255,255,0.2);
            }
            .header-section-3 .navi ul {
                border-left: 1px solid rgba(255,255,255,0.2);
            }
        .header-section-2 .header-top {
            background-color: ;
        }
        .header-section-2 .header-bottom {
            background-color: #004272;
            border-top: 1px solid #2a353d;
            border-bottom: 1px solid #2a353d;
        }
        .header-section-2 .header-bottom .navi > ul > li {
            border-right: 1px solid #2a353d;
        }
        .header-section-2 .header-right {
            border-left: 1px solid #2a353d;
        }
        .header-section-2 .navi > ul > li > a,
        .header-section-2 .header-right .user a,
         .header-section-2 .header-right span {
            color: ;
        }
            .header-section-2 .navi > ul > li > a:hover,
             .header-section-2 .navi > ul > li.active > a{
                color: rgba(255,255,255,1);
                background-color: rgba(255,255,255,0.2);
            }
            .header-section-2 .header-right .user a:hover,
             .header-section-2 .header-right span:hover {
                color: rgba(255,255,255,1);
            }
        .header-section .header-right a.btn,
        .header-section-2 .header-right a.btn,
        .header-section-3 .header-right a.btn {
            color: #ffffff;
            border: 1px solid #ffffff;
            background-color: rgba(255,255,255,0.2);
        }
        .header-section .header-right .user a.btn:hover,
        .header-section-2 .header-right .user a.btn:hover,
        .header-section-3 .header-right .user a.btn:hover {
            color: rgba(255,255,255,1);
            border-color: #ffffff;
            background-color: rgba(255,255,255,0.1);
        }
    
        .header-section-4,
        .header-section-4 .navi > ul ul,
        .sticky_nav.header-section-4 {
            background-color: ;
        }
        .header-section-4 .navi > ul > li > a,
        .header-section-4 .navi > ul ul a,
        .header-section-4 .header-right .user a,
        .header-section-4 .header-right span {
            color: #004274;
        }
        .header-section-4 .header-right .btn {
            color: #004274;
            border: 1px solid #004274;
            background-color: #ffffff;
        }
            .header-section-4 .navi > ul > li > a:hover,
            .header-section-4 .navi > ul ul a:hover,
            .header-section-4 .navi > ul > li.active > a,
            .header-section-4 .header-right .user a:hover,
            .header-section-4 .header-right .user a:focus,
            .header-section-4 .header-right span:hover,
            .header-section-4 .header-right span:focus {
                color: rgba(0,174,239,1);
            }
            .header-section-4 .header-right .user .btn:hover {
                color: rgba(255,255,255,1);
                border-color: rgba(0,174,239,1);
                background-color: rgba(0,174,239,1);
            }
      .houzez-header-transparent {
       background-color: transparent; position: absolute; width: 100%;
       border-bottom: 1px none;
       border-color: rgba(255,255,255,0.3);
      }
      .header-section-4.houzez-header-transparent .navi > ul > li > a,

      .header-section-4.houzez-header-transparent .header-right .account-action span,
      .header-section-4.houzez-header-transparent .header-right .user span {
         color: #ffffff;
      }
    .header-section-4.houzez-header-transparent .navi > ul > li > a:hover,
        .header-section-4.houzez-header-transparent .navi > ul ul a:hover,
        .header-section-4.houzez-header-transparent .account-action li:hover,

        .header-section-4.houzez-header-transparent .header-right .user a:hover,
        .header-section-4.houzez-header-transparent .header-right .account-action span:hover,
        .header-section-4.houzez-header-transparent .header-right .user span:hover,
        .header-section-4.houzez-header-transparent .header-right .user a:focus {
            color: #00aeef;
        }
    .header-section-4.houzez-header-transparent .header-right .btn {
        color: #ffffff;
        border: 1px solid #ffffff;
        background-color: rgba(255,255,255,0.2);
    }
            .header-section-4.houzez-header-transparent .header-right .user .btn:hover {
                color: rgba(255,255,255,1);
                border-color: rgba(0,174,239,1);
                background-color: rgba(0,174,239,1);
            }
        .navi.main-nav > ul ul {
            background-color: rgba(255,255,255,0.95);
        }
        .navi.main-nav > ul ul a {
            color: #2e3e49!important;
        }
        .navi.main-nav > ul ul a:hover {
            color: #00aeef!important;
        }
        .navi.main-nav > ul ul li {
            border-color: #e6e6e6;
        }
     
        .header-section .header-right a,
        .header-section .header-right span,
        .header-section .header-right .btn-default,
        .header-section .navi ul li,
        .header-section .account-dropdown > ul > li > a,

        .header-section-3 .header-right a,
        .header-section-3 .header-right span,
        .header-section-3 .navi ul li,
        .header-section-3 .account-dropdown > ul > li > a,

        .header-section-2 .header-right a,
        .header-section-2 .header-right span,
        .header-section-2 .navi ul li,
        .header-section-2 .account-dropdown > ul > li > a,

        .header-section-4 .header-right a,
        .header-section-4 .header-right span,
        .header-section-4 .navi ul li,
        .header-section-4 .header-right .btn-default,
        .header-section-4 .account-dropdown > ul > li > a {
            font-family: Roboto;
            font-size: 14px;
            font-weight: 500;
            line-height: 18px;
            text-transform: none;
            text-align: left;
        }
        .header-section.slpash-header .navi > ul > li > a:hover,
        .slpash-header.header-section-4 .navi > ul > li > a:hover,
        .header-section.slpash-header .header-right .user > a:hover,
        .slpash-header.header-section-4 .header-right .user > a:hover,
        .header-section.slpash-header .navi > ul > li > a:focus,
        .slpash-header.header-section-4 .navi > ul > li > a:focus,
        .header-section.slpash-header .header-right .user > a:focus,
        .slpash-header.header-section-4 .header-right .user > a:focus  {
            color: rgba(255,255,255,1);
        }
        .header-section.slpash-header .navi > ul > li.active > a{
            color: #00aeef;
        }
        .header-mobile {
            background-color: #ffffff;
        }
        .header-mobile .nav-dropdown > ul {
            background-color: rgba(255,255,255,0.95);
        }
        .mobile-nav .nav-trigger,
        .header-mobile .user a,
        .header-mobile .user-icon {
            color: #000000;
        }
        .splash-header .mobile-nav .nav-trigger,
        .splash-header .header-mobile .user a,
        .splash-header .header-mobile .user-icon {
            color: #FFFFFF;
        }
        .nav-dropdown a,
        .nav-dropdown li .expand-me {
            color: #000000;
        }
        .mobile-nav a {
            font-family: Roboto;
            font-size: 14px;
            font-weight: 500;
            line-height: 18px;
            text-transform: none;
            text-align: left;
        }
        .mobile-nav .nav-dropdown > ul ul a {
            color: #ffffff;
            background-color: #00aeef;
        }
        .mobile-nav .nav-dropdown li {
            border-top: 1px solid #e0e0e0;            
        }
            .mobile-nav .nav-dropdown > ul > li:hover {
                background-color: rgba(0,174,239,1);
            }
            .mobile-nav .nav-dropdown li.active > a {
                color: rgba(255,255,255,1);
                background-color: rgba(0,174,239,1);
            }
        .account-dropdown > ul {
            background-color: #FFFFFF;
        }
        .account-dropdown > ul:before {
            border-bottom-color: #FFFFFF;
        }
        .account-dropdown > ul > li > a {
            color: #2e3e49 !important;
        }
        .account-dropdown > ul > li > a:hover, .account-dropdown > ul > li.active > a, .account-dropdown > ul > li.active > a:hover {
            color: #2e3e49 !important;
            background-color: rgba(204,204,204,0.15);
        }
        .account-dropdown > ul > li {
            border-color: #e6e6e6;
        }
        .account-dropdown > ul .sub-menu {
            background-color: #00365e;
        }
        .account-dropdown > ul .sub-menu > li,
        .account-dropdown > ul .sub-menu > li a {
            color: #FFFFFF;
        }
        .account-dropdown > ul .sub-menu > li a:hover, .account-dropdown > ul .sub-menu > li.active > a {
            background-color: rgba(255,255,255,0.2) !important;
            color: inherit;
        }
        .account-dropdown > ul .sub-menu > li {
            border-color: rgba(255,255,255,0.3) !important;
        }
        
        .footer {
            background-color: #004274;
        }
        .footer-bottom {
            background-color: #00335A;
            border-top: 1px solid #00243f;
        }
        .footer,
        .footer-widget h4,
        .footer-bottom p,
        .footer-widget.widget_calendar caption  {
            color: ;
        }
        .footer a,
        .footer-bottom .navi a,
        .footer-bottom .foot-social p a {
            color: ;
        }
        .footer-widget .widget-title,
        .footer p, .footer p.wp-caption-text,
         .footer li,
          .footer li i {
            color: ;
        }
            .footer a:hover,
            .footer-bottom .navi a:hover,
            .footer-bottom .foot-social p a:hover  {
                color: rgba(0,174,239,1);
            }
            .footer-widget.widget_tag_cloud .tagcloud a {
                color: rgba(0,174,239,1);
                background-color: ;
                border: 1px solid ;
            }
        body {
            color: #000000;
            font-family: Roboto;
            font-size: 16px;
            font-weight: 400;
            line-height: 24px;
            text-transform: none;
        }
        .detail-bar p,
        .detail-bar ol li, 
        .detail-bar ul li {
            font-size: 16px;
        }
        input, button, select, textarea {
            font-family: Roboto;
        }
        h1,
        .page-title .title-head,
        .article-detail h1,
        h2,
        .article-detail h2,
        .houzez-module .module-title-nav h2,
        h3,
        .module-title h3,
        .article-detail h3,
        .detail h3,
        .caption-bottom .detail h3,
        .detail-bottom.detail h3,
        .add-title-tab h3,
        #sidebar .widget-title,
        .footer-widget .widget-title,
        .services-module .service-block h3,
        h4,
        .article-detail h4,
        h5,
        .article-detail h5,
        h6,
        .article-detail h6,
        .item-body h2,
        .item-body .property-title,
        .post-card-description h3,
        .post-card-description .post-card-title,
        .my-property .my-heading,
        .module-title h2,
        .houzez-module .module-title-nav h2 {
            font-family: Roboto;
            font-weight: 500;
            text-transform: inherit;
            text-align: inherit;
        }
        h1,
        .page-title .title-head,
        .article-detail h1 {
            font-size: 30px;
            line-height: 38px;
            margin: 0 0 28px 0;
        }
        h2,
        .article-detail h2,
        .houzez-module .module-title-nav h2 {
            font-size: 24px;
            line-height: 32px;
            margin: 0 0 10px 0;
        }
        .houzez-module .module-title-nav h2 {
            margin: 0;
        }
        h3,
        .module-title h3,
        .article-detail h3,
        .services-module .service-block h3 {
            font-size: 20px;
            line-height: 28px;
        }
        h4,
        .article-detail h4 {
            font-size: 18px;
            line-height: 26px;
            margin: 0 0 24px 0;
        }
        h5,
        .article-detail h5 {
            font-size: 16px;
            line-height: 24px;
            margin: 0 0 24px 0;
        }
        h6,
        .article-detail h6 {
            font-size: 14px;
            line-height: 20px;
            margin: 0 0 24px 0;
        }
        .item-body h2,
        .post-card-description h3,
        .my-property .my-heading {
            font-size: 16px;
            line-height: 20px;
            margin: 0 0 8px 0;
            font-weight: 500;
            text-transform: inherit;
            text-align: inherit;
        }
        .module-title h2 {
            font-size: 24px;
            line-height: 32px;
            margin: 0 0 10px 0;
            font-weight: 500;
            text-transform: inherit;
            text-align: inherit;
        }
        .module-title .sub-heading {
            font-size: 16px;
            line-height: 24px;
            font-weight: 300;
            text-transform: inherit;
            text-align: inherit;
        }
        .houzez-module .module-title-nav .sub-title {
            font-size: 16px;
            line-height: 18px;
            margin: 8px 0 0 0;
            font-weight: 300;
            text-transform: inherit;
            text-align: inherit;
        }
        .item-thumb .hover-effect:before,
        figure .hover-effect:before,
        .carousel-module .carousel .item figure .hover-effect:before,
        .item-thumb .slideshow .slideshow-nav-main .slick-slide:before,
        .slideshow .slideshow-nav-main .item-thumb .slick-slide:before,
        figure .slideshow .slideshow-nav-main .slick-slide:before,
        .slideshow .slideshow-nav-main figure .slick-slide:before {
        background: linear-gradient(to bottom, rgba(0,0,0,0) 0%, rgba(0,0,0,0) 0%, rgba(0,0,0,0) 65%, rgba(0,0,0,.75) 100%);
        }
        .slideshow .slide .slick-prev:hover,
        .slideshow .slideshow-nav .slick-prev:hover,
        .slideshow .slide .slick-next:hover,
        .slideshow .slideshow-nav .slick-next:hover,
        .slideshow .slide .slick-prev:focus,
        .slideshow .slideshow-nav .slick-prev:focus,
        .slideshow .slide .slick-next:focus,
        .slideshow .slideshow-nav .slick-next:focus
        .item-thumb:hover .hover-effect:before,
        figure:hover .hover-effect:before,
        .carousel-module .carousel .item figure:hover .hover-effect:before,
        .item-thumb:hover .slideshow .slideshow-nav-main .slick-slide:before,
        .slideshow .slideshow-nav-main .item-thumb:hover .slick-slide:before,
        figure:hover .slideshow .slideshow-nav-main .slick-slide:before,
        .slideshow .slideshow-nav-main figure:hover .slick-slide:before,
        .item-thumb:hover .hover-effect:before,
        figure:hover .hover-effect:before,
        .carousel-module .carousel .item figure:hover .hover-effect:before,
        .item-thumb:hover .slideshow .slideshow-nav-main .slick-slide:before,
        .slideshow .slideshow-nav-main .item-thumb:hover .slick-slide:before,
        figure:hover .slideshow .slideshow-nav-main .slick-slide:before,
        .slideshow .slideshow-nav-main figure:hover .slick-slide:before {
            color: #fff;
            background-color: rgba(255,255,255,.5);
        }
        .figure-grid .detail h3,
        .detail-above.detail h3 {
            color: #fff;
        }
        .detail-bottom.detail h3 {
            color: #000;
        }
        .agent-contact a {
            font-weight: 700;
        }
        label {
            font-weight: 400;
            font-size: 14px;
        }
        .label-status {
            background-color: #333;
            font-weight: 700;
        }
        .read .fa {
            top: 1px;
            position: relative;
        }            
        .label-primary,
        .fave-load-more a,
        .widget_tag_cloud .tagcloud a,
        .pagination-main .pagination li.active a,
        .other-features .btn.btn-secondary,
        .my-menu .active am {
            font-weight: 500;
        }       
        
        /*.features-list {
            padding-bottom: 15px;
        }*/
        .advanced-search .advance-btn i {
            float: inherit;
            font-size: 14px;
            position: relative;
            top: 0px;
            margin-right: 6px;
        }
        @media (min-width: 992px) {
            .advanced-search .features-list .checkbox-inline {
                width: 14%;
            }
        }
        .header-detail.table-cell .header-right {
            margin-top: 27px;
        }
        .header-detail h1 .actions span, .header-detail h4 .actions span {
            font-size: 18px;
            display: inline-block;
            vertical-align: middle;
            margin: 0 3px;
        }        
        .header-detail .property-address {
            color: #707070;
            margin-top: 12px;
        }        
        .white-block {
            padding: 40px;
        }
        .wpb_text_column ul,
        .wpb_text_column ol {
            margin-top: 20px;
            margin-bottom: 20px;
            padding-left: 20px;
        }
        #sidebar .widget_houzez_latest_posts img {
            max-width: 90px;
            margin-top: 0;
        }
        #sidebar .widget_houzez_latest_posts .media-heading,
        #sidebar .widget_houzez_latest_posts .read {
            font-size: 14px;
            line-height: 18px;
            font-weight: 500;
        }        
        #sidebar .widget-range .dropdown-toggle,
        .bootstrap-select.btn-group,        
        .search-long .search input,
        .advanced-search .search-long .advance-btn,        
        .splash-search .dropdown-toggle {
            font-weight: 400;
            color: #959595 !important;
            font-size: 15px;
        }

        .advanced-search .input-group .form-control {
            border-left-width: 0;
        }        
        .location-select {
            max-width: 170px;
        }             
        
            .vegas-overlay {
               opacity: 1;
               background-image: url(http://houzez01.favethemes.com/wp-content/uploads/2016/03/bg-video-1.png);
           }
                    .label-color-289 {
                        background-color: #dd3333;
                    }
                    
                    .label-color-288 {
                        background-color: #ea923a;
                    }
                    
        .user-dashboard-left,
        .board-header-4{
            background-color:#00365e;
        }
        .board-panel-menu > li a,
        .board-header-4 .board-title,
        .board-header-4 .breadcrumb > .active,
        .board-header-4 .breadcrumb li:after,
        .board-header-4 .steps-progress-main{ 
            color:#ffffff; 
         }
        .board-panel-menu > li.active {
            color: #4cc6f4;
        }
        .board-panel-menu .sub-menu {
            background-color: #002B4B;
        }
        .board-panel-menu .sub-menu > li.active > a, .board-panel-menu > li a:hover {
            color: #4cc6f4;
        }
     
        #ihf-main-container .btn-primary, 
        #ihf-main-container .ihf-map-search-refine-link,
        #ihf-main-container .ihf-map-search-refine-link {
            background-color: #ff6e00;
            border-color: #ff6e00;
            color: #fff;
        }
        #ihf-main-container .btn-primary:hover, 
        #ihf-main-container .btn-primary:focus, 
        #ihf-main-container .btn-primary:active, 
        #ihf-main-container .btn-primary.active {
            background-color: rgba(255,110,0,1);
        }
        #ihf-main-container a {
            color: #00aeef;       
        }
        .ihf-grid-result-basic-info-container,
        #ihf-main-container {
            color: #000000;
            font-family: Roboto;
            font-size: 16px;
            font-weight: 400;
            line-height: 24px;
            text-transform: none;
        }
        #ihf-main-container .fs-12,
        .ihf-tab-pane,
        #ihf-agent-sellers-rep,
        #ihf-board-detail-disclaimer,
        #ihf-board-detail-updatetext  {
            font-size: 16px;
        }
        #ihf-main-container .title-bar-1,
        .ihf-map-icon{
            background-color: #00aeef;
        }
        .ihf-map-icon{
            border-color: #00aeef;
        }
        .ihf-map-icon:after{
            border-top-color: #00aeef;
        }
        #ihf-main-container h1, 
        #ihf-main-container h2, 
        #ihf-main-container h3, 
        #ihf-main-container h4, 
        #ihf-main-container h5, 
        #ihf-main-container h6, 
        #ihf-main-container .h1, 
        #ihf-main-container .h2, 
        #ihf-main-container .h3, 
        #ihf-main-container .h4, 
        #ihf-main-container .h5, 
        #ihf-main-container .h6,
        #ihf-main-container h4.ihf-address,
        #ihf-main-container h4.ihf-price  {
            font-family: Roboto;
            font-weight: 500;
            text-transform: inherit;
            text-align: inherit;
        }
    /* .advanced-search .features-list .checkbox-inline { color:#ffffff; } */
.advanced-search-mobile {
 position: relative;
 z-index: 10;
}
.advanced-search-module {
   z-index: 10; 
}
.module-half .property-listing .item-wrap:nth-child(2n+1) {
    clear: both;
}
.module-half .save-btn { display:none; }
/* Advanced searches color adjustments
------------------------------------ */
.page-id-1626 .range-text p,
.page-id-1626 .range-title,
.page-id-1626 .min-price-range, 
.page-id-1626 .max-price-range,
.page-id-1063 .range-text p,
.page-id-1063 .range-title,
.page-id-1063 .min-price-range, 
.page-id-1063 .max-price-range,
.page-id-1063 .checkbox-inline,
.page-id-558 .range-text p,
.page-id-558 .range-title,
.page-id-558 .min-price-range, 
.page-id-558 .max-price-range,
.page-id-558 .checkbox-inline,
.module-half .features-list .checkbox-inline {
    color: #000 !important;
}
/* NEW label for menus
------------------------------------ */
.navi > ul ul li.new-feature a:after{
 content: 'NEW';
 color: #fff;
 border-radius: 3px;
 font-size: 10px;
 padding: 4px 6px 4px;
 text-transform: uppercase;
 margin-bottom: 0;
 display: inline-block;
 line-height: 11px;
 vertical-align: top;
 background-color: #77c720;
 margin-left: 10px;
}
#singlePropertyMap > div{
    position: absolute !important;
}
.packages-no-padding div[class^="col-"]{
   padding-right: 0;
   padding-left: 0;
}
.navi .houzez-megamenu > .sub-menu .sub-menu a {
    font-weight: inherit;
}
.profile-properties .property-listing.grid-view .item-wrap:nth-child(3n+1) { 
    clear:both; 
}
.qr-image,
span.user-name { 
    display:none !important; 
}
.banner-video-inner:before {
background-image: url(wp-content/uploads/2016/03/bg-video-1.png);    
}
.splash-inner-content .nav-trigger,
.splash-inner-content .header-mobile .user a {
    color: #fff;
}
.splash-inner-content .header-mobile .user a i {
    font-size: 16px;
    top: 5px;
    position: relative;
}
.team-block-mobile {
    position: absolute;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    z-index: 1;
}
@media (max-width: 768px) {
    .team-block:hover .team-caption-before,
    .team-block:hover .team-caption-after,
    .team-caption-before,
    .team-caption-after{
        transform: none;
    }
    .team-caption-after {
        display: none;
    }
}
</style>

<link rel='stylesheet' id='js_composer_front-css'  href='<?php echo smarty_function_themes_url(array(),$_smarty_tpl);?>
/houzez01/wp-content/plugins/js_composer/assets/css/js_composer.min.css?ver=5.4.2' type='text/css' media='all' />
<?php echo '<script'; ?>
 type='text/javascript' src='<?php echo smarty_function_themes_url(array(),$_smarty_tpl);?>
/houzez01/wp-includes/js/jquery/jquery.js?ver=1.12.4'><?php echo '</script'; ?>
>
<?php echo '<script'; ?>
 type='text/javascript' src='<?php echo smarty_function_themes_url(array(),$_smarty_tpl);?>
/houzez01/wp-includes/js/jquery/jquery-migrate.min.js?ver=1.4.1'><?php echo '</script'; ?>
>
<?php echo '<script'; ?>
 type='text/javascript' src='<?php echo smarty_function_themes_url(array(),$_smarty_tpl);?>
/houzez01/wp-content/plugins/revslider/public/assets/js/jquery.themepunch.tools.min.js?ver=5.4.5.2'><?php echo '</script'; ?>
>
<?php echo '<script'; ?>
 type='text/javascript' src='<?php echo smarty_function_themes_url(array(),$_smarty_tpl);?>
/houzez01/wp-content/plugins/revslider/public/assets/js/jquery.themepunch.revolution.min.js?ver=5.4.5.2'><?php echo '</script'; ?>
>
<?php echo '<script'; ?>
 type='text/javascript' src='http://maps.googleapis.com/maps/api/js?libraries=places&#038;language=en_US&#038;key=AIzaSyCBnyL9MhOZlec1Mz1_qImukxi-VFqQKJw&#038;ver=1.0'><?php echo '</script'; ?>
>
<?php echo '<script'; ?>
 type='text/javascript' src='<?php echo smarty_function_themes_url(array(),$_smarty_tpl);?>
/houzez01/wp-content/themes/houzez/js/infobox.js?ver=1.1.9'><?php echo '</script'; ?>
>
<?php echo '<script'; ?>
 type='text/javascript' src='<?php echo smarty_function_themes_url(array(),$_smarty_tpl);?>
/houzez01/wp-content/themes/houzez/js/markerclusterer.js?ver=2.1.1'><?php echo '</script'; ?>
>
<link rel="shortcut icon" href="<?php echo smarty_function_themes_url(array(),$_smarty_tpl);?>
/houzez01/wp-content/uploads/2016/03/favicon.png">

<?php echo '<script'; ?>
 type="text/javascript">
    function setREVStartSize(e){
				try{ var i=jQuery(window).width(),t=9999,r=0,n=0,l=0,f=0,s=0,h=0;					
					if(e.responsiveLevels&&(jQuery.each(e.responsiveLevels,function(e,f){f>i&&(t=r=f,l=e),i>f&&f>r&&(r=f,n=e)}),t>r&&(l=n)),f=e.gridheight[l]||e.gridheight[0]||e.gridheight,s=e.gridwidth[l]||e.gridwidth[0]||e.gridwidth,h=i/s,h=h>1?1:h,f=Math.round(h*f),"fullscreen"==e.sliderLayout){var u=(e.c.width(),jQuery(window).height());if(void 0!=e.fullScreenOffsetContainer){var c=e.fullScreenOffsetContainer.split(",");if (c) jQuery.each(c,function(e,i){u=jQuery(i).length>0?u-jQuery(i).outerHeight(!0):u}),e.fullScreenOffset.split("%").length>1&&void 0!=e.fullScreenOffset&&e.fullScreenOffset.length>0?u-=jQuery(window).height()*parseInt(e.fullScreenOffset,0)/100:void 0!=e.fullScreenOffset&&e.fullScreenOffset.length>0&&(u-=parseInt(e.fullScreenOffset,0))}f=u}else void 0!=e.minHeight&&f<e.minHeight&&(f=e.minHeight);e.c.closest(".rev_slider_wrapper").css({height:f})					
				}catch(d){console.log("Failure at Presize of Slider:"+d)}
			};
                    <?php echo '</script'; ?>
>
                    <style type="text/css" data-type="vc_shortcodes-custom-css">.vc_custom_1494355113610{padding-top: 40px !important;background-color: #0f2f4e !important;}.vc_custom_1459833943673{background-color: #ffffff !important;}.vc_custom_1459776413799{background-color: #ededed !important;}</style>
                    <?php
}
/* End inline template "cms_template:139" =============================*/
/* Start inline template "cms_template:139" =============================*/
function content_5a5f9b350a8503_85437698 ($_smarty_tpl) {
?>

<?php echo '<script'; ?>
 type='text/javascript'>
/* <![CDATA[ */
var wpcf7 = {"apiSettings":{"root":"http:\/\/houzez01.favethemes.com\/wp-json\/contact-form-7\/v1","namespace":"contact-form-7\/v1"},"recaptcha":{"messages":{"empty":"Please verify that you are not a robot."}},"cached":"1"};
/* ]]> */
<?php echo '</script'; ?>
>
<?php echo '<script'; ?>
 type='text/javascript' src='<?php echo smarty_function_themes_url(array(),$_smarty_tpl);?>
/houzez01/wp-content/plugins/contact-form-7/includes/js/scripts.js'><?php echo '</script'; ?>
>
<?php echo '<script'; ?>
 type='text/javascript' src='<?php echo smarty_function_themes_url(array(),$_smarty_tpl);?>
/houzez01/wp-content/themes/houzez/js/bootstrap.min.js'><?php echo '</script'; ?>
>
<?php echo '<script'; ?>
 type='text/javascript'>
/* <![CDATA[ */
var hz_plugin = {"rating_terrible":"Terrible","rating_poor":"Poor","rating_average":"Average","rating_vgood":"Very Good","rating_exceptional":"Exceptional"};
/* ]]> */
<?php echo '</script'; ?>
>
<?php echo '<script'; ?>
 type='text/javascript' src='<?php echo smarty_function_themes_url(array(),$_smarty_tpl);?>
/houzez01/wp-content/themes/houzez/js/plugins.js'><?php echo '</script'; ?>
>
<?php echo '<script'; ?>
 type='text/javascript' src='<?php echo smarty_function_themes_url(array(),$_smarty_tpl);?>
/houzez01/wp-includes/js/jquery/ui/core.min.js'><?php echo '</script'; ?>
>
<?php echo '<script'; ?>
 type='text/javascript' src='<?php echo smarty_function_themes_url(array(),$_smarty_tpl);?>
/houzez01/wp-includes/js/jquery/ui/datepicker.min.js'><?php echo '</script'; ?>
>
<?php echo '<script'; ?>
 type='text/javascript'>
jQuery(document).ready(function(jQuery){jQuery.datepicker.setDefaults({"closeText":"Close","currentText":"Today","monthNames":["January","February","March","April","May","June","July","August","September","October","November","December"],"monthNamesShort":["Jan","Feb","Mar","Apr","May","Jun","Jul","Aug","Sep","Oct","Nov","Dec"],"nextText":"Next","prevText":"Previous","dayNames":["Sunday","Monday","Tuesday","Wednesday","Thursday","Friday","Saturday"],"dayNamesShort":["Sun","Mon","Tue","Wed","Thu","Fri","Sat"],"dayNamesMin":["S","M","T","W","T","F","S"],"dateFormat":"MM d, yy","firstDay":1,"isRTL":false});});
<?php echo '</script'; ?>
>
<?php echo '<script'; ?>
 type='text/javascript' src='<?php echo smarty_function_themes_url(array(),$_smarty_tpl);?>
/houzez01/wp-includes/js/jquery/ui/widget.min.js'><?php echo '</script'; ?>
>
<?php echo '<script'; ?>
 type='text/javascript' src='<?php echo smarty_function_themes_url(array(),$_smarty_tpl);?>
/houzez01/wp-includes/js/jquery/ui/position.min.js'><?php echo '</script'; ?>
>
<?php echo '<script'; ?>
 type='text/javascript' src='<?php echo smarty_function_themes_url(array(),$_smarty_tpl);?>
/houzez01/wp-includes/js/jquery/ui/menu.min.js'><?php echo '</script'; ?>
>
<?php echo '<script'; ?>
 type='text/javascript' src='<?php echo smarty_function_themes_url(array(),$_smarty_tpl);?>
/houzez01/wp-includes/js/wp-a11y.min.js'><?php echo '</script'; ?>
>
<?php echo '<script'; ?>
 type='text/javascript'>
/* <![CDATA[ */
var uiAutocompleteL10n = {"noResults":"No results found.","oneResult":"1 result found. Use up and down arrow keys to navigate.","manyResults":"%d results found. Use up and down arrow keys to navigate.","itemSelected":"Item selected."};
/* ]]> */
<?php echo '</script'; ?>
>
<?php echo '<script'; ?>
 type='text/javascript' src='<?php echo smarty_function_themes_url(array(),$_smarty_tpl);?>
/houzez01/wp-includes/js/jquery/ui/autocomplete.min.js'><?php echo '</script'; ?>
>
<?php echo '<script'; ?>
 type='text/javascript' src='<?php echo smarty_function_themes_url(array(),$_smarty_tpl);?>
/houzez01/wp-includes/js/jquery/ui/mouse.min.js'><?php echo '</script'; ?>
>
<?php echo '<script'; ?>
 type='text/javascript' src='<?php echo smarty_function_themes_url(array(),$_smarty_tpl);?>
/houzez01/wp-includes/js/jquery/jquery.ui.touch-punch.js'><?php echo '</script'; ?>
>


<?php echo '<script'; ?>
 type='text/javascript'>
/* <![CDATA[ */
var HOUZEZ_ajaxcalls_vars = {"admin_url":"&showtemplate=false","houzez_rtl":"no","redirect_type":"same_page","login_redirect":"http:\/\/houzez01.favethemes.com\/half-map\/","login_loading":"Sending user info, please wait...","direct_pay_text":"Processing, Please wait...","user_id":"0","transparent_menu":"no","simple_logo":"http:\/\/houzez01.favethemes.com\/wp-content\/uploads\/2016\/03\/logo-houzez-color.png","retina_logo":"http:\/\/houzez01.favethemes.com\/wp-content\/uploads\/2016\/03\/logo-houzez-color@2x.png","retina_logo_mobile":"http:\/\/houzez01.favethemes.com\/wp-content\/uploads\/2016\/03\/logo-houzez-color@2x.png","retina_logo_mobile_splash":"http:\/\/houzez01.favethemes.com\/wp-content\/uploads\/2016\/03\/logo-houzez-white@2x.png","retina_logo_splash":"http:\/\/houzez01.favethemes.com\/wp-content\/uploads\/2016\/03\/logo-houzez-white@2x.png","retina_logo_height":"24","retina_logo_width":"140","property_lat":"","property_lng":"","property_map":"","property_map_street":"","is_singular_property":"","process_loader_refresh":"fa fa-spin fa-refresh","process_loader_spinner":"fa fa-spin fa-spinner","process_loader_circle":"fa fa-spin fa-circle-o-notch","process_loader_cog":"fa fa-spin fa-cog","success_icon":"fa fa-check","prop_featured":"Featured","featured_listings_none":"You have used all the \"Featured\" listings in your package.","prop_sent_for_approval":"Sent for Approval","paypal_connecting":"Connecting to paypal, Please wait... ","mollie_connecting":"Connecting to mollie, Please wait... ","confirm":"Are you sure you want to delete?","confirm_featured":"Are you sure you want to make this a featured listing?","confirm_featured_remove":"Are you sure you want to remove from featured listing?","confirm_relist":"Are you sure you want to relist this property?","delete_property":"Processing, please wait...","delete_confirmation":"Are you sure you want to delete?","not_found":"We didn't find any results","for_rent":"for-rent","for_rent_price_range":"for-rent","currency_symbol":"$","advanced_search_widget_min_price":"1200","advanced_search_widget_max_price":"1600","advanced_search_min_price_range_for_rent":"50","advanced_search_max_price_range_for_rent":"26000","advanced_search_widget_min_area":"50","advanced_search_widget_max_area":"13000","advanced_search_price_slide":"1","fave_page_template":"property-listings-map.php","google_map_style":"[{\"featureType\":\"administrative\",\"elementType\":\"labels.text.fill\",\"stylers\":[{\"color\":\"#444444\"}]},{\"featureType\":\"landscape\",\"elementType\":\"all\",\"stylers\":[{\"color\":\"#f2f2f2\"}]},{\"featureType\":\"poi\",\"elementType\":\"all\",\"stylers\":[{\"visibility\":\"off\"}]},{\"featureType\":\"road\",\"elementType\":\"all\",\"stylers\":[{\"saturation\":-100},{\"lightness\":45}]},{\"featureType\":\"road.highway\",\"elementType\":\"all\",\"stylers\":[{\"visibility\":\"simplified\"}]},{\"featureType\":\"road.arterial\",\"elementType\":\"labels.icon\",\"stylers\":[{\"visibility\":\"off\"}]},{\"featureType\":\"transit\",\"elementType\":\"all\",\"stylers\":[{\"visibility\":\"off\"}]},{\"featureType\":\"water\",\"elementType\":\"all\",\"stylers\":[{\"color\":\"#46bcec\"},{\"visibility\":\"on\"}]}]","googlemap_default_zoom":"1","googlemap_pin_cluster":"yes","googlemap_zoom_cluster":"5","map_icons_path":"http:\/\/houzez01.favethemes.com\/wp-content\/themes\/houzez\/images\/map\/","infoboxClose":"http:\/\/houzez01.favethemes.com\/wp-content\/themes\/houzez\/images\/map\/close.png","clusterIcon":"http:\/\/houzez01.favethemes.com\/wp-content\/themes\/houzez\/images\/map\/cluster-icon.png","google_map_needed":"yes","paged":"0","search_result_page":"normal_page","search_keyword":"","search_country":"","search_state":[],"search_city":[],"search_feature":[],"search_area":[],"search_status":[],"search_label":[],"search_type":[],"search_bedrooms":"","search_bathrooms":"","search_min_price":"","search_max_price":"","search_min_area":"","search_max_area":"","search_publish_date":"","search_no_posts":"","search_location":"","use_radius":"on","search_lat":"","search_long":"","search_radius":"","transportation":"Transportation","supermarket":"Supermarket","schools":"Schools","libraries":"Libraries","pharmacies":"Pharmacies","hospitals":"Hospitals","sort_by":"","measurement_updating_msg":"Updating, Please wait...","autosearch_text":"Searching...","currency_updating_msg":"Updating Currency, Please wait...","currency_position":"before","submission_currency":"USD","wire_transfer_text":"To be paid","direct_pay_thanks":"Thank you. Please check your email for payment instructions.","direct_payment_title":"Direct Payment Instructions","direct_payment_button":"SEND ME THE INVOICE","direct_payment_details":"Please send payment to\u00a0<strong>Houzez Inc<\/strong>. <br\/>\r\n\r\nBank Account -\u00a0<strong>BWA7849843FAVE007<\/strong>\u00a0\u00a0<br\/>\r\n\r\nPlease include the invoice number in payment details Thank you for your business with us! <br\/>","measurement_unit":"sqft","header_map_selected_city":[],"thousands_separator":",","current_tempalte":"property-listings-map","monthly_payment":"Monthly Payment","weekly_payment":"Weekly Payment","bi_weekly_payment":"Bi-Weekly Payment","compare_button_url":"http:\/\/houzez01.favethemes.com\/compare-properties\/","template_thankyou":"http:\/\/houzez01.favethemes.com\/thank-you\/","compare_page_not_found":"Please create page using compare properties template","property_detail_top":"v1","keyword_search_field":"prop_title","keyword_autocomplete":"1","houzez_date_language":"","houzez_default_radius":"30","enable_radius_search":"0","enable_radius_search_halfmap":"1","houzez_primary_color":"#00aeef","geocomplete_country":"","houzez_logged_in":"no","ipinfo_location":"0","gallery_autoplay":"1","stripe_page":"http:\/\/houzez01.favethemes.com\/stripe\/","twocheckout_page":"http:\/\/houzez01.favethemes.com\/"};
/* ]]> */
<?php echo '</script'; ?>
>
<?php echo '<script'; ?>
 type='text/javascript' src='<?php echo smarty_function_themes_url(array(),$_smarty_tpl);?>
/houzez01/wp-content/themes/houzez/js/houzez_ajax_calls.js'><?php echo '</script'; ?>
>
<?php echo '<script'; ?>
 type='text/javascript' src='<?php echo smarty_function_themes_url(array(),$_smarty_tpl);?>
/houzez01/wp-content/themes/houzez/js/custom.js'><?php echo '</script'; ?>
>
<?php echo '<script'; ?>
 type='text/javascript' src='<?php echo smarty_function_themes_url(array(),$_smarty_tpl);?>
/houzez01/wp-includes/js/wp-embed.min.js'><?php echo '</script'; ?>
><?php
}
/* End inline template "cms_template:139" =============================*/
}
