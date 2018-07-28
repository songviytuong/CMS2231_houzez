<?php
/* Smarty version 3.1.31, created on 2018-01-18 02:10:52
  from "cms_template:INC_Styles" */

/* @var Smarty_Internal_Template $_smarty_tpl */
if ($_smarty_tpl->_decodeProperties($_smarty_tpl, array (
  'version' => '3.1.31',
  'unifunc' => 'content_5a5f91ac99e2e0_20069133',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    '2937aa11b4f3eaf1373deabeee1790347faf0fdf' => 
    array (
      0 => 'cms_template:INC_Styles',
      1 => '1514742659',
      2 => 'cms_template',
    ),
  ),
  'includes' => 
  array (
  ),
),false)) {
function content_5a5f91ac99e2e0_20069133 (Smarty_Internal_Template $_smarty_tpl) {
if (!is_callable('smarty_function_themes_url')) require_once 'E:\\xampp\\htdocs\\public_html\\cms_version2\\cms2231_houzez\\lib\\plugins\\function.themes_url.php';
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
                    <?php }
}
