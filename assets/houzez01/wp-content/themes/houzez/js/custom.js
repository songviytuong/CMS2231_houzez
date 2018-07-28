/*
 Theme Name: Houzez
 Description: Houzez
 Author: Houzez
 Author: Houzez
 Version: 1.0
 */

var nice = false;
(function($){
"use strict";

    var houzez_rtl = HOUZEZ_ajaxcalls_vars.houzez_rtl;
    var houzez_date_language = HOUZEZ_ajaxcalls_vars.houzez_date_language;
    var currency_position = HOUZEZ_ajaxcalls_vars.currency_position;
    var stripe_page = HOUZEZ_ajaxcalls_vars.stripe_page;
    var twocheckout_page = HOUZEZ_ajaxcalls_vars.twocheckout_page;


    if( houzez_rtl == 'yes' ) {
        houzez_rtl = true;
    } else {
        houzez_rtl = false;
    }


    var detail_slider = $('#detail-slider');
    if(detail_slider.length) {
        detail_slider.owlCarousel({
            loop:true,
            autoWidth:true,
            dots: false,
            items: 1,
            smartSpeed: 700,
            slideBy: 1,
            nav: true,
            navText : ["<i class='fa fa-angle-left'></i>","<i class='fa fa-angle-right'></i>"]

        });
    }

    /* ------------------------------------------------------------------------ */
    /*  Click to show phone number
     /* ------------------------------------------------------------------------ */
    var strMobile = $(".clickToShow").text();
    var shortNum = strMobile.substring(0, 6);

    $(".clickToShow").hide().after('<span class="clickToShowButton">' + shortNum + '........');
    $(".clickToShowButton").click(function(e) {
        e.preventDefault();
        $(".clickToShow").show();
        $(".clickToShowButton").hide();
    });

    var strPhone = $(".clickToShowPhone").text();
    var shortNumPH = strPhone.substring(0, 6);

    $(".clickToShowPhone").hide().after('<span class="clickToShowButtonPhone">' + shortNumPH + '........');
    $(".clickToShowButtonPhone").click(function(e) {
        e.preventDefault();
        $(".clickToShowPhone").show();
        $(".clickToShowButtonPhone").hide();
    });
    

    /* ------------------------------------------------------------------------ */
    /*  NICE SCROLL
     /* ------------------------------------------------------------------------ */
    /*var nice = $(".account-dropdown,.dashboard-bar").niceScroll({
     cursorcolor: "#666",
     scrollspeed: 50,
     mousescrollstep: 30,
        hwacceleration:'true',
     boxzoom: false,
     autohidemode: false,
     cursorborder: "0 solid #666",
     cursorborderradius: "0",
     cursorwidth: 6,
     background: "#666",
     horizrailenabled: false
     });*/

    /* ------------------------------------------------------------------------ */
    /*  CHECK USER AGENTS
     /* ------------------------------------------------------------------------ */
    var isChrome = /Chrome/.test(navigator.userAgent) && /Google Inc/.test(navigator.vendor);
    var isSafari = /Safari/.test(navigator.userAgent) && /Apple Computer/.test(navigator.vendor);

    /* ------------------------------------------------------------------------ */
    /*  BODY LOAD
     /* ------------------------------------------------------------------------ */
    $(window).on('load',function(){
        if($('.body-splash').length > 0 ){
            $('.body-splash').addClass('loaded');
        }
    });

    /* ------------------------------------------------------------------------ */
    /*  MAP ZOOM
    /* ------------------------------------------------------------------------ */
    $('.map-zoom-actions #houzez-gmap-full').on('click',function () {
        if($(this).hasClass('active')== true){
            $(this).removeClass('active').children('span').text('Fullscreen');
            $(this).children('i').removeClass('fa-square-o').addClass('fa-arrows-alt');
            $('#houzez-gmap-main').removeClass('mapfull');
            $('.header-media').delay(1000).queue(function(next){
                $('.header-media').css('height','auto');
                next();
            });

        }else{
            $('.header-media').height($('#houzez-gmap-main').height());
            $(this).addClass('active').children('span').text('Default');
            $(this).children('i').removeClass('fa-arrows-alt').addClass('fa fa-square-o');
            $('#houzez-gmap-main').addClass('mapfull');
        }
    });

    /* ------------------------------------------------------------------------ */
    /*  COMPARE PANEL
     /* ------------------------------------------------------------------------ */
    $('.panel-btn, .panel-btn-close').on('click',function () {
        if($('.compare-panel').hasClass('panel-open')){
            $('.compare-panel').removeClass('panel-open');
        }else{
            $('.compare-panel').addClass('panel-open');
        }
    });


    /* ------------------------------------------------------------------------ */
    /*  PAYPAL & Stripe OPTIONS
     /* ------------------------------------------------------------------------ */

    $('.method-select input').on('change',function () {
        if($(this).is(':checked')) {
            $('.method-option').slideUp();
            $(this).parents('.method-row').next('.method-option').slideDown();
        }else{
            $('.method-option').slideUp();
        }
    });
    function paypal_option(ele){
        if($(ele).attr('checked')) {
            $(ele).parents('.method-row').next('.method-option').slideDown();
        }else{
            $(ele).parents('.method-row').next('.method-option').slideUp();
        }
    }

    paypal_option('.payment-paypal');
    paypal_option('.payment-stripe');

    $('button.stripe-button-el span').prepend('<i class="fa fa-credit-card"></i>');
    $('#stripe_package_recurring').click(function () {
        if( $(this).attr('checked') ) {
            $('.houzez_payment_form').append('<input type="hidden" name="houzez_stripe_recurring" id="houzez_stripe_recurring" value="1">');
        }else{
            $('#houzez_stripe_recurring').remove();
        }
    });

    //Add form checkout id
    var houzez_payment_type = $("input[name='houzez_payment_type']");
    houzez_payment_type.click(function(){
        var form = $(this).parents('form');
        if( $(this).val() === '2checkout' ) {
            form.attr('action', twocheckout_page);
            $('#houzez_complete_membership, #houzez_complete_order').addClass('hidden');
            $('#houzez_complete_membership_2checkout, #houzez_complete_order_2checkout').removeClass('hidden');
        } else {
            form.attr('action', stripe_page);
            $('#houzez_complete_membership, #houzez_complete_order').removeClass('hidden');
            $('#houzez_complete_membership_2checkout, #houzez_complete_order_2checkout').addClass('hidden');
        }
    });

    /* ------------------------------------------------------------------------ */
    /*  INPUT PLUS MINUS
     /* ------------------------------------------------------------------------ */
    $('.btn-number').click(function(e){
        e.preventDefault();

        var fieldName = $(this).attr('data-field');
        var type      = $(this).attr('data-type');
        var input = $("input[name='"+fieldName+"']");
        var currentVal = parseInt(input.val());
        if (!isNaN(currentVal)) {
            if(type == 'minus') {

                if(currentVal > input.attr('min')) {
                    input.val(currentVal - 1).change();
                }
                if(parseInt(input.val()) == input.attr('min')) {
                    $(this).attr('disabled', true);
                }

            } else if(type == 'plus') {

                if(currentVal < input.attr('max')) {
                    input.val(currentVal + 1).change();
                }
                if(parseInt(input.val()) == input.attr('max')) {
                    $(this).attr('disabled', true);
                }

            }
        } else {
            input.val(0);
        }
    });
    $('.input-number').focusin(function(){
        $(this).data('oldValue', $(this).val());
    });
    $('.input-number').change(function() {

        var minValue =  parseInt($(this).attr('min'));
        var maxValue =  parseInt($(this).attr('max'));
        var valueCurrent = parseInt($(this).val());

        var name = $(this).attr('name');
        if(valueCurrent >= minValue) {
            $(".btn-number[data-type='minus'][data-field='"+name+"']").removeAttr('disabled')
        } else {
            alert('Sorry, the minimum value was reached');
            $(this).val($(this).data('oldValue'));
        }
        if(valueCurrent <= maxValue) {
            $(".btn-number[data-type='plus'][data-field='"+name+"']").removeAttr('disabled')
        } else {
            alert('Sorry, the maximum value was reached');
            $(this).val($(this).data('oldValue'));
        }

    });
    $(".input-number").keydown(function (e) {
        // Allow: backspace, delete, tab, escape, enter and .
        if ($.inArray(e.keyCode, [46, 8, 9, 27, 13, 190]) !== -1 ||
            // Allow: Ctrl+A
            (e.keyCode == 65 && e.ctrlKey === true) ||
            // Allow: home, end, left, right
            (e.keyCode >= 35 && e.keyCode <= 39)) {
            // let it happen, don't do anything
            return;
        }
        // Ensure that it is a number and stop the keypress
        if ((e.shiftKey || (e.keyCode < 48 || e.keyCode > 57)) && (e.keyCode < 96 || e.keyCode > 105)) {
            e.preventDefault();
        }
    });

    /* ------------------------------------------------------------------------ */
    /*  FUNCTION FOR TOUCH DEVICES
    /* ------------------------------------------------------------------------ */
    function isTouchDevice(){
        return true == ("ontouchstart" in window || window.DocumentTouch && document instanceof DocumentTouch);
    }

    /* ------------------------------------------------------------------------ */
    /*  IF HEADER OR SEARCH STICKY
     /* ------------------------------------------------------------------------ */
    var ifHeaderSticky = $('#header-section').data('sticky');
    var ifHeaderBottomSticky = $('#header-section .header-bottom').data('sticky');
    var ifAdvanceSearchSticky = $('.advance-search-header').data('sticky');
    var topBarLenght = $('.top-bar').length;

    var stickyHeaderH = $('#header-section').innerHeight();
    var stickyAdvanceSearchH = $('.advance-search-header').innerHeight();
    var stickyHeaderBottomH = $('#header-section .header-bottom').innerHeight();
    var topMargin = 0;

    if(ifHeaderSticky == 1){
        topMargin = stickyHeaderH;
    }
    if(ifAdvanceSearchSticky == 1){
        topMargin = stickyAdvanceSearchH;
    }
    if(ifHeaderBottomSticky == 1){
        topMargin = stickyHeaderBottomH;
    }
    if($('#header-section').hasClass('header-section-3')){
        topMargin = stickyHeaderBottomH;
    }
    if($('#header-section').hasClass('header-section-2')){
        topMargin = stickyHeaderBottomH;
    }

    $(document).ready(function() {
        var $wpAdminBar = $('#wpadminbar');
        if ($wpAdminBar.length) {
           topMargin = topMargin + ($wpAdminBar.outerHeight());
        }
    });

    /* ------------------------------------------------------------------------ */
    /*  SCROLL TO TOP
     /* ------------------------------------------------------------------------ */
    //Check to see if the window is top if not then display button
    var scroll_top = $('.scrolltop-btn');
    $(window).on("scroll",function(){
        if ($(this).scrollTop() > 100) {
            scroll_top.fadeIn(1000);
        } else {
            scroll_top.fadeOut(1000);
        }
    });

    $(".back-top").on('click',function() {
        $("html, body").animate({ scrollTop: 0 }, "slow");
        return false;
    });

    /* ------------------------------------------------------------------------ */
    /*  PROPERTY MENU TARGET NAV
     /* ------------------------------------------------------------------------ */
    var propertyMenuH = $('.property-menu-wrap').innerHeight();
    if($('.property-menu-wrap').length) {
        $(".target").each(function () {
            $(this).on('click', function (e) {
                var jump = $(this).attr("href");
                var scrollto = ($(jump).offset().top);
                scrollto = scrollto - (topMargin) - (propertyMenuH-2);
                $("html, body").animate({scrollTop: scrollto}, {duration: 1000, easing: 'easeInOutExpo', queue: false});
                e.preventDefault();
            });

        });

        $(window).on('scroll', function () {
            $('.target-block').each(function () {
                if ($(window).scrollTop() >= $(this).offset().top - (topMargin) - (propertyMenuH)) {
                    var id = $(this).attr('id');
                    $('.target').removeClass('active');
                    $('.target[href=#' + id + ']').addClass('active');
                } else if ($(window).scrollTop() <= 0) {
                    $('.target').removeClass('active');
                }
            });
        });

        //Target nav sticky
        $(window).on('scroll', function() {
            if($(window).scrollTop() >= $('.detail-media').offset().top + (200)) {
                $('.property-menu-wrap').css({top:topMargin}).fadeIn();
            }else if($(window).scrollTop() <= $('.detail-media').offset().top + (200)) {
                $('.property-menu-wrap').css({top:topMargin}).fadeOut();
            }
        });
    }
    /* ------------------------------------------------------------------------ */
    /*  One page smooth scroll
     /* ------------------------------------------------------------------------ */
    $(function() {
        $('#header-section a[href*="#"]:not([href="#"])').click(function() {
            if (location.pathname.replace(/^\//,'') == this.pathname.replace(/^\//,'') && location.hostname == this.hostname) {
                var target = $(this.hash);
                target = target.length ? target : $('[name=' + this.hash.slice(1) +']');
                if (target.length) {
                    $('html, body').animate({
                        scrollTop: target.offset().top
                    }, 1000);
                    return false;
                }
            }
        });
    });

    $('#commentform input.submit').addClass('btn btn-primary');
    $('.widget_nav_menu, .widget_pages').addClass('widget-pages');
    $('.footer-widget.widget_mc4wp_form_widget').addClass('widget-newsletter');

    $('.blog-article .pagination-main ul.pagination a').wrap('<li></li>');


    /* ------------------------------------------------------------------------ */
    /*  STICKY SIDEBAR
    /* ------------------------------------------------------------------------ */

   function property_menu_h(ele){
        var StickySidebarTop = topMargin;
        if($('.property-menu-wrap').length) {
            StickySidebarTop = ele + ($('.property-menu-wrap').innerHeight())
        }
        return StickySidebarTop;
    }

    $('.houzez_sticky').theiaStickySidebar({
        additionalMarginTop: property_menu_h(topMargin),
        minWidth: 768,
        updateSidebarHeight: false
    });


    if( $('#houzez_mortgage_calculate').length > 0 ) {
        $('#houzez_mortgage_calculate').click(function(e) {
            e.preventDefault();

            var monthly_payment = HOUZEZ_ajaxcalls_vars.monthly_payment;
            var weekly_payment = HOUZEZ_ajaxcalls_vars.weekly_payment;
            var bi_weekly_payment = HOUZEZ_ajaxcalls_vars.bi_weekly_payment;
            var currency_symb = HOUZEZ_ajaxcalls_vars.currency_symbol;

            var totalPrice  = 0;
            var down_payment = 0;
            var term_years  = 0;
            var interest_rate = 0;
            var amount_financed  = 0;
            var monthInterest = 0;
            var intVal = 0;
            var mortgage_pay = 0;
            var annualCost = 0;
            var payment_period;
            var mortgage_pay_text;


            payment_period = $('#mc_payment_period').val();

            totalPrice = $('#mc_total_amount').val().replace(/,/g, '');
            down_payment = $('#mc_down_payment').val().replace(/,/g, '');
            amount_financed = totalPrice - down_payment;
            term_years =  parseInt ($('#mc_term_years').val(),10) * payment_period;
            interest_rate = parseFloat ($('#mc_interest_rate').val(),10);
            monthInterest = interest_rate / (payment_period * 100);
            intVal = Math.pow( 1 + monthInterest, -term_years );
            mortgage_pay = amount_financed * (monthInterest / (1 - intVal));
            annualCost = mortgage_pay * payment_period;

            if( payment_period == '12' ) {
                mortgage_pay_text = monthly_payment;

            } else if ( payment_period == '26' ) {
                mortgage_pay_text = bi_weekly_payment;

            } else if ( payment_period == '52' ) {
                mortgage_pay_text = weekly_payment;

            }

            if(currency_position == 'after') {
                $('#mortgage_mwbi').html("<h3>"+mortgage_pay_text+ ":<span> "+(Math.round(mortgage_pay * 100)) / 100 + currency_symb + "</span></h3>");
                $('#amount_financed').html(((Math.round(amount_financed * 100)) / 100)+currency_symb);
                $('#mortgage_pay').html(((Math.round(mortgage_pay * 100)) / 100)+currency_symb);
                $('#annual_cost').html(( (Math.round(annualCost * 100)) / 100)+currency_symb);
            } else {
                $('#mortgage_mwbi').html("<h3>"+mortgage_pay_text+ ":<span> " +currency_symb+ (Math.round(mortgage_pay * 100)) / 100 + "</span></h3>");
                $('#amount_financed').html(currency_symb+(Math.round(amount_financed * 100)) / 100);
                $('#mortgage_pay').html(currency_symb+(Math.round(mortgage_pay * 100)) / 100);
                $('#annual_cost').html(currency_symb+(Math.round(annualCost * 100)) / 100);
            }

            $('#total_mortgage_with_interest').html();
            $('.morg-detail').show();
        });
    }

    /* ------------------------------------------------------------------------ */
    /*  Date picker
     /* ------------------------------------------------------------------------ */
    if($('.input_date').length > 0) {
        $( ".input_date" ).datepicker(jQuery.datepicker.regional[houzez_date_language]);
    }
    if($('.search-date').length > 0) {
        $( ".search-date" ).datepicker(jQuery.datepicker.regional[houzez_date_language]);
    }

    /* ------------------------------------------------------------------------
     /*  parallax
     ------------------------------------------------------------------------- */
    function parallax(){

        if($('.header-media .banner-parallax').length){
            var banner_distance = $('.header-media').offset().top;
            var start_scroll = banner_distance + 15;
            var scrolled = $(window).scrollTop() - start_scroll;
            if($(window).scrollTop() >= start_scroll){

                //$('.banner-inner').css('background-position-y', (scrolled*-0.9)+'px');
                $('.banner-bg-wrap').css("transform","translate3d(0,"+-scrolled*-0.3+"px,0)");
            }else if($(window).scrollTop() < start_scroll){
                $('.banner-bg-wrap').css("transform","translate3d(0,0px,0)");
            }
        }

    }
    parallax();
    $(window).scroll(function(e){
        parallax();
    });
    /* ------------------------------------------------------------------------ */
    /*  DETAIL LIGHT BOX SLIDE SHOW
     /* ------------------------------------------------------------------------ */
    if($("a[data-fancy^='property_video']").length > 0) {
        $("a[data-fancy^='property_video']").prettyPhoto({
            allow_resize: true,
            default_width: 1900,
            default_height: 1000,
            animation_speed: 'normal',
            theme: 'default',
            slideshow: 3000,
            autoplay_slideshow: false
        });
    }

    if($("a[data-fancy^='property_gallery']").length > 0) {
        $("a[data-fancy^='property_gallery']").prettyPhoto({
            allow_resize: true,
            default_width: 1900,
            default_height: 1000,
            animation_speed: 'normal',
            theme: 'facebook',
            slideshow: 3000,
            autoplay_slideshow: false
        });
    }

    /* ------------------------------------------------------------------------ */
    /*  Properties filter on My properties dashboard
     /* ------------------------------------------------------------------------ */
    $("#property_name").keyup(function(){

        // Retrieve the input field text and reset the count to zero
        var filter = $(this).val(), count = 0;

        // Loop through the comment list
        $(".my-property-listing .item-wrap").each(function(){

            // If the list item does not contain the text phrase fade it out
            if ($(this).text().search(new RegExp(filter, "i")) < 0) {
                $(this).fadeOut();

                // Show the list item if the phrase matches and increase the count by 1
            } else {
                $(this).show();
                count++;
            }
        });

        // Update the count
        var numberItems = count;
        $(".my-property-search button").text(count);
    });

    /* ------------------------------------------------------------------------ */
    /*	SEARCH TABER
    /* ------------------------------------------------------------------------ */
    $('.banner-search-tabs .search-tab').on('click',function(){
        if($(this).hasClass('active')!=true){
            $('.banner-search-tabs .search-tab').removeClass('active');
            $(this).addClass('active');
            $('.banner-search-taber .tab-pane').removeClass('active in');
            $('.banner-search-taber .tab-pane').eq($(this).index()).addClass('active').delay(5).queue(function(next){
                $(this).addClass('in');
                next();
            });
        }
    });

    /* ------------------------------------------------------------------------ */
    /* DETAIL TABBER
    /* ------------------------------------------------------------------------ */
    $('.detail-tabs > li').on('click',function(){

        if($(this).hasClass('active')!=true){
            $('.detail-tabs > li').removeClass('active');
            $(this).addClass('active');
            $('.detail-content-tabber .tab-pane').removeClass('active in');
            $('.detail-content-tabber .tab-pane').eq($(this).index()).addClass('active in');
        }
    });

    /* ------------------------------------------------------------------------ */
    /* FLOOR PLAN TABBER
    /* ------------------------------------------------------------------------ */
    $('.plan-tabs > li').on('click',function(){

        if($(this).hasClass('active')!=true){
            $('.plan-tabs > li').removeClass('active');
            $(this).addClass('active');
            $('.plan-tabber .tab-pane').removeClass('active in');
            $('.plan-tabber .tab-pane').eq($(this).index()).addClass('active in');
        }
    });

    /* ------------------------------------------------------------------------ */
    /* MODULE TABER
     /* ------------------------------------------------------------------------ */
    $('.houzez-tabs > li').on('click',function(){
        if($(this).hasClass('active')!=true){
            $('.houzez-tabs > li').removeClass('active');
            $(this).addClass('active');
            $('.houzez-taber-body .tab-pane').removeClass('active in');
            $('.houzez-taber-body .tab-pane').eq($(this).index()).addClass('active').delay(50).queue(function(next){
                $(this).addClass('in');
                next();
            });
        }
    });

    /* ------------------------------------------------------------------------ */
    /* PROFILE DETAIL TABBER
    /* ------------------------------------------------------------------------ */
    $('.profile-tabs > li').on('click',function(){
        if($(this).hasClass('active')!=true){
            $('.profile-tabs > li').removeClass('active');
            $(this).addClass('active');
            $('.profile-tab-pane').removeClass('active in');
            $('.profile-tab-pane').eq($(this).index()).addClass('active in');
        }
    });

    /* ------------------------------------------------------------------------ */
    /*	LOGIN TABBER
    /* ------------------------------------------------------------------------ */
    function houzez_tabber(target){
        $(""+target+""+' .login-tabs > li').on('click',function(){
            if($(this).hasClass('active')!=true){
                $('.login-tabs > li').removeClass('active');
                $(this).addClass('active');
                //alert('ok');
                $(""+target+""+' .login-block .tab-pane').removeClass('in active');
                $(""+target+""+' .login-block .tab-pane').eq($(this).index()).addClass('in active');
            }
        });
    }
    houzez_tabber('.widget');
    houzez_tabber('.footer-widget');
    houzez_tabber('.modal');

    /* ------------------------------------------------------------------------ */
    /*  ACCORDIAN ADD PROPERTY
     /* ------------------------------------------------------------------------ */

    $('.add-title-tab > .add-expand').click(function() {
        $(this).toggleClass('active');
        $(this).parent().next('.add-tab-content').slideToggle();
    });


    /* ------------------------------------------------------------------------ */
    /*  ACCORDIAN
     /* ------------------------------------------------------------------------ */

    $('.accord-tab').click(function() {
        $('.accord-tab').not(this).removeClass('active');
        $(this).toggleClass('active');

        $('.accord-tab').not(this).next('.accord-content').slideUp();
        $(this).next('.accord-content').slideToggle();
    });

    /* ------------------------------------------------------------------------ */
    /*  MAP VIEW TABBER
     /* ------------------------------------------------------------------------ */
    $('a[data-toggle="tab"]').on('shown.bs.tab', function (e) {
        e.target // newly activated tab
        e.relatedTarget // previous active tab
    });

    /* ------------------------------------------------------------------------ */
    /*  Houzez simple map
     /* ------------------------------------------------------------------------ */
    var simple_map = $( '#houzez-simple-map' );
    if (simple_map.length) {
        var styles = simple_map.data( 'styles' );


        $('#mapTab').click(function() {
            document.getElementById('houzez-simple-map').style.display="block";
            initialize();
        });


        var map = null;
        var fenway = new google.maps.LatLng(simple_map.data( 'latitude' ), simple_map.data( 'longitude' ));
        var mapOptions = {
            center: fenway,
            zoom: simple_map.data( 'zoom' )
        };

        var initialize = function() {
            map = new google.maps.Map(document.getElementById('houzez-simple-map'), mapOptions);
            var myLatLng = {lat: simple_map.data( 'latitude' ), lng: simple_map.data( 'longitude' )};
            var marker = new google.maps.Marker({
                position: myLatLng,
                map: map
            });
        }

    }

    /* ------------------------------------------------------------------------ */
    /*  BOOTSTRAP SELECT PICKER
     /* ------------------------------------------------------------------------ */
    if($('.selectpicker').length > 0){
        $('.selectpicker').selectpicker({
            dropupAuto: false
        });
    }

    /* ------------------------------------------------------------------------ */
    /*  POST CARDS MASONRY
     /* ------------------------------------------------------------------------ */
    $(window).on('load',function(){
        if($('.grid-block').length > 0){
            $('.grid-block').isotope({
                // options
                itemSelector: '.grid-item'
                //layoutMode: 'fitRows'
            });
        }
    });

    /* ------------------------------------------------------------------------ */
    /*  TOOLTIP
     /* ------------------------------------------------------------------------ */
    if(isTouchDevice()===false) {
        $('[data-toggle="tooltip"]').tooltip();
    }

    /* ------------------------------------------------------------------------ */
    /*  SHARE TOOLTIP
     /* ------------------------------------------------------------------------ */
    $('.actions li').on('click',function(){

        if($(this).children('.share_tooltip').hasClass('in')){
            $(this).children('.share_tooltip').removeClass('in');
        }else{
            $('.actions li').children('.share_tooltip').removeClass('in');
            $(this).children('.share_tooltip').addClass('in');
        }

    });
    $(document).mouseup(function (e)
    {
        var tip = $(".share-btn");

        if (!tip.is(e.target) // if the target of the click isn't the container...
            && tip.has(e.target).length === 0) // ... nor a descendant of the container
        {
            $('.share_tooltip').removeClass('in');
        }
    });

    /* ------------------------------------------------------------------------ */
    /*  SET COLUMNS HEIGHT
     /* ------------------------------------------------------------------------ */
    /*if($('.footer-widget').length > 0){
        $('.footer-widget').matchHeight();
    }*/

    if($('.grid').length > 0) {
        $('.grid').each(function () {
            $(this).children().find('img').matchHeight({
                byRow: true,
                property: 'height',
                target: null,
                remove: false
            });
        });
    }
    //if($('.grid-view').length > 0) {
    /*$(window).load(function(){
     $('.post-card-description').matchHeight();
     });*/
    //}

    /* ------------------------------------------------------------------------ */
    /*  NAVIGATION
     /* ------------------------------------------------------------------------ */
    function houzez_nav_menu() {
        $('.navi ul li').each(function () {
            $(this).has('ul').not('.houzez-megamenu li').addClass('has-child');
        });

        $('.navi ul .has-child').hover(
            function () {
                $(this).addClass("active");
            },
            function () {
                $(this).removeClass("active");
            }
        );
    }
    houzez_nav_menu();

    function houzez_megamenu(){
        if($(window).width() > 991){
            var container = $('.container');
            var header = $('.header-section,#header-section');

            var containWidth = container.innerWidth();
            var windowWidth = $(window).width();
            var containOffset = container.offset();

            if($('.navi ul li').hasClass('houzez-megamenu')){

                $('.navi ul .houzez-megamenu').each(function () {
                    $("> .sub-menu",this).wrap("<div class='houzez-megamenu-inner'></div>");
                    var thisOffset = $(this).offset();
                    if(header.children('.container').length > 0){
                        $("> .houzez-megamenu-inner",this).css({width:containWidth,left:-(thisOffset.left-containOffset.left)});
                    }else{
                        $("> .houzez-megamenu-inner",this).css({width:windowWidth,left: -thisOffset.left});
                        //alert(thisOffset);
                    }
                });

            }
        }
    }
    houzez_megamenu();
    $(window).on('resize',function () {
        houzez_megamenu();
    });
    $(window).bind('load',function () {
        houzez_megamenu();
    });


    /* ------------------------------------------------------------------------ */
    /*  CHANGE GRID LIST
     /* ------------------------------------------------------------------------ */
    $('.view-btn').on("click",function(){
        $('.view-btn').removeClass('active');
        $(this).addClass('active');
        if($(this).hasClass('btn-list')) {
            $('.property-listing').removeClass('grid-view grid-view-3-col').addClass('list-view');
        }
        else if($(this).hasClass('btn-grid')) {
            $('.property-listing').removeClass('list-view grid-view-3-col').addClass('grid-view');
        }
        else if($(this).hasClass('btn-grid-3-col')) {
            $('.property-listing').removeClass('list-view grid-view').addClass('grid-view grid-view-3-col');

        }
    });

    var top_bar = $('.top-bar');
    var header = $('#header-section');
    var header_bottom = header.find('.header-bottom');
    var header_search = $('.advance-search-header');
    var mobile_header = $('.header-mobile');
    var mobile_search = $('.advanced-search-mobile');


    var innerHeaderH = $('.header-section').outerHeight();
    var header_height = header.outerHeight();
    var splashFootH = $('.splash-footer').outerHeight();
    var advancedSearchH = header_search.outerHeight();
    var top_bar_height = top_bar.outerHeight();

    var mobile_header_height = mobile_header.outerHeight();
    var mobile_search_height = mobile_search.outerHeight();

    /* ------------------------------------------------------------------------ */
    /*  HEADER STICKY
     /* ------------------------------------------------------------------------ */

    var header_sticky = header.data('sticky');
    var header_bottom_sticky = header_bottom.data('sticky');
    var header_mobile_sticky = mobile_header.data('sticky');
    //var get_header_class = $('#header-section').attr('class');



    if(header_bottom_sticky === 1){
        this_sticky(header_bottom);
    }
    if(header_sticky === 1){
        this_sticky(header);
    }
    if(header_mobile_sticky === 1){
        this_sticky(mobile_header);

        //get_header_class = $('.header-mobile').attr('class');
    }

    function this_sticky(ele){
        var header_position = ele.outerHeight() * 2;
        var sticky_nav = ele.clone().removeAttr('style').removeClass('houzez-header-transparent nav-left');
        var get_header_class = sticky_nav.attr('class');

        if($(sticky_nav).hasClass('header-bottom')){
            get_header_class = $('.header-bottom').parent('#header-section').attr('class');
        }
        //alert(get_header_class);
        //sticky_nav.removeClass('houzez-header-transparent');

        var sticky_wrap = $(sticky_nav).wrap("<div class='sticky_nav'></div>").parent().addClass(get_header_class);
        //sticky_wrap = sticky_wrap.removeClass('houzez-header-transparent nav-left');

        $('body').append( sticky_wrap );

        if($(sticky_wrap).hasClass('header-section-4')) {
            $('.sticky_nav .logo-desktop img').attr('src',HOUZEZ_ajaxcalls_vars.simple_logo);
        }

        function fix_header(){
            if($('#wpadminbar').length > 0 && getWindowWidth() > 600) {
                var admin_bar_height = $('#wpadminbar').outerHeight();
                sticky_wrap.css( 'top', admin_bar_height );
            }else{
                sticky_wrap.css( 'top', '0' );
            }
        }

        $(window).on('scroll', function(){
            if($('#wpadminbar').length > 0 && getWindowWidth() > 600) {
                var admin_bar_height = $('#wpadminbar').outerHeight();
                sticky_wrap.css( 'top', admin_bar_height );
            }
            //if( $(window).scrollTop() >= ele.position().top + header_position ){
            if( $(window).scrollTop() >= 600 ){
                sticky_wrap.addClass('sticky-on');
            }
            else{
                sticky_wrap.removeClass('sticky-on');
            }
        });

        fix_header();
        $(window).resize(function(){
            fix_header();
        });
        houzez_megamenu();
        houzez_nav_menu();
    }

    /* ------------------------------------------------------------------------ */
    /*  ADVANCE SEARCH STICKY
     /* ------------------------------------------------------------------------ */
    function advancedSearchSticky() {
        var search = null;
        var thisHeight = null;
        var sr_sticky_top = null;

        if(getWindowWidth() > 991){
            search = $('.advance-search-header');
            thisHeight = $('.advance-search-header').outerHeight();
        }else{
            search = $('.advanced-search-mobile');
            thisHeight = $('.advanced-search-mobile').outerHeight();
        }
        if (!search.data('sticky')) {
            return;
        }

        if( $(".splash-search")[0] ) {
            sr_sticky_top = $('.splash-search').offset().top;
            sr_sticky_top = sr_sticky_top + 200;
        } else {
            if(getWindowWidth() > 991){
                sr_sticky_top = $('.advance-search-header').offset().top + 65;
            }else{
                sr_sticky_top = $('.advanced-search-mobile').offset().top;
            }
        }

        if( sr_sticky_top == 0 ) {
            sr_sticky_top = $('#header-section').height();
        }

        $(window).scroll(function() {
            var scroll = $(window).scrollTop();
            var admin_nav = $('#wpadminbar').height() + 'px';

            if( admin_nav == 'nullpx' ) { admin_nav = '0px'; }

            if (scroll >= sr_sticky_top ) {
                search.addClass("advanced-search-sticky");
                search.css('top', admin_nav);
                $('#section-body').css('padding-top',thisHeight);
            } else {
                search.removeClass("advanced-search-sticky");
                search.removeAttr("style");
                $('#section-body').css('padding-top',0);
            }
        });
    }
    advancedSearchSticky();

    /* ------------------------------------------------------------------------ */
    /*  SEARCH PANEL HEIGHT FIX
    /* ------------------------------------------------------------------------ */
    $('.search-panel-btn').on('click',function () {
        if($('.search-panel').hasClass('panel-open')){
            $('.search-panel').removeClass('panel-open');
        }else{
            $('.search-panel').addClass('panel-open');
        }
    });
    function search_panel_height_fix(){
        var panel_bottom_height = $('.search-panel .search-bottom').outerHeight();
        $('.search-scroll').css('padding-bottom', panel_bottom_height);

        if($(window).width() < 991){
            $('.search-panel').removeClass('panel-open');
        }
    }
    search_panel_height_fix();
    $(window).on('resize',function () {
        search_panel_height_fix()
    });

    /* ------------------------------------------------------------------------ */
    /*  SECTION HEIGHT
    /* ------------------------------------------------------------------------ */
    function bg_image_size(size,url){
        var get_url = url,image;
        if(get_url) {
            // Remove url() or in case of Chrome url("")
            get_url = get_url.match(/^url\("?(.+?)"?\)$/);

            if (get_url[1]) {
                get_url = get_url[1];
                image = new Image();
                image.src = get_url;
                if (size == 'height') {
                    return image.height;
                } else {
                    return image.width;
                }
            }
        }
    }


    var totalTopBarsHeight = 0;
    var searchH = 0;

    function setSectionHeight() {
        var window_height = $(window).innerHeight();
        var admin_bar = $('#wpadminbar');
        var admin_bar_height = admin_bar.outerHeight();
        searchH = (window_height-innerHeaderH)-splashFootH;

        if (isChrome){
            $('.fave-screen-fix-inner').css( 'height', searchH-1 );
        }else{
            $('.fave-screen-fix-inner').css( 'height', searchH );
        }

        if(getWindowWidth() >= 992){
            if(header.length){
                totalTopBarsHeight = header_height;
            }
            if(header.length
                && header_search.length
                && !header_search.hasClass('search-hidden')) {
                totalTopBarsHeight = parseInt(advancedSearchH) + parseInt(header_height);
            }
            if(header.is('*')
                && header_search.hasClass('search-hidden')) {
                totalTopBarsHeight = header_height;
            }

            if(header.length
                && top_bar.length){
                totalTopBarsHeight = parseInt(header_height) + parseInt(top_bar_height);
            }
            if(header.length
                && header_search.length
                && !header_search.hasClass('search-hidden')
                && top_bar.length){
                totalTopBarsHeight = parseInt(header_height) + parseInt(top_bar_height) + parseInt(advancedSearchH);
            }
            if(header.length
                && admin_bar.length){
                totalTopBarsHeight = parseInt(header_height) + parseInt(admin_bar_height);
            }

            if(header.length
                && admin_bar.length
                && top_bar.length){
                totalTopBarsHeight = parseInt(header_height) + parseInt(admin_bar_height) + parseInt(top_bar_height);
            }
            if(header.length
                && admin_bar.length
                && header_search.length
                && !header_search.hasClass('search-hidden')){
                totalTopBarsHeight = parseInt(header_height) + parseInt(admin_bar_height) + parseInt(advancedSearchH);
            }
            if(header.length
                && admin_bar.length
                && header_search.length
                && !header_search.hasClass('search-hidden')
                && top_bar.length){
                totalTopBarsHeight = parseInt(header_height) + parseInt(admin_bar_height) + parseInt(advancedSearchH) + parseInt(top_bar_height);
            }
            if(header.length
                && admin_bar.length
                && header_search.length
                && header_search.hasClass('search-hidden')
                && top_bar.length){
                totalTopBarsHeight = parseInt(header_height) + parseInt(admin_bar_height) + parseInt(top_bar_height);
            }

        }else{
            if(mobile_search.length
                && !mobile_search.hasClass('search-hidden')
                && mobile_header.length) {
                totalTopBarsHeight = parseInt(mobile_search_height) + parseInt(mobile_header_height);
            }
            if(mobile_search.hasClass('search-hidden')
                && mobile_header.is('*')) {
                totalTopBarsHeight = mobile_header_height;
            }
            if(mobile_header.length){
                totalTopBarsHeight = mobile_header_height;
            }
            if(mobile_header.length
                && top_bar.length){
                totalTopBarsHeight = parseInt(mobile_header_height) + parseInt(top_bar_height);
            }
            if(mobile_header.length
                && mobile_search.length
                && !mobile_search.hasClass('search-hidden')
                && top_bar.length){
                totalTopBarsHeight = parseInt(mobile_header_height) + parseInt(top_bar_height) + parseInt(mobile_search_height);
            }
            if(mobile_header.length
                && admin_bar.length){
                totalTopBarsHeight = parseInt(mobile_header_height) + parseInt(admin_bar_height);
            }
            if(mobile_header.length
                && admin_bar.length
                && mobile_search.length
                && !mobile_search.hasClass('search-hidden')){
                totalTopBarsHeight = parseInt(mobile_header_height) + parseInt(admin_bar_height) + parseInt(mobile_search_height);
            }
            if(mobile_header.length
                && admin_bar.length
                && mobile_search.length
                && !mobile_search.hasClass('search-hidden')
                && top_bar.length){
                totalTopBarsHeight = parseInt(mobile_header_height) + parseInt(admin_bar_height) + parseInt(mobile_search_height) + parseInt(top_bar_height);
            }
            if(mobile_header.length
                && admin_bar.length
                && mobile_search.length
                && mobile_search.hasClass('search-hidden')
                && top_bar.length){
                totalTopBarsHeight = parseInt(mobile_header_height) + parseInt(admin_bar_height) + parseInt(top_bar_height);
            }
            if(mobile_header.length
                && admin_bar.length
                && top_bar.length){
                totalTopBarsHeight = parseInt(mobile_header_height) + parseInt(admin_bar_height) + parseInt(top_bar_height);
            }
        }

        var topBarsHeight = 0;

        if(header.hasClass('houzez-header-transparent')){
            topBarsHeight =  (getWindowHeight() - totalTopBarsHeight) + header_height;
        }else{
            topBarsHeight =  getWindowHeight() - totalTopBarsHeight;
        }

        if (isChrome){
            $('.fave-screen-fix').css( 'height', topBarsHeight-1 );
        }else{
            $('.fave-screen-fix').css( 'height', topBarsHeight );
        }

        $('.banner-parallax-fix').css( 'height', topBarsHeight );

        if(getWindowWidth() > 768){
            var image_url = $('.banner-parallax-auto .banner-inner').css('background-image');

            if(image_url != 'none'){
                var bg_height = $('.banner-parallax-auto').width() * bg_image_size('height',image_url) / bg_image_size('width',image_url);
                if(bg_height > getWindowHeight()){
                    $('.banner-parallax-auto').css( 'height', topBarsHeight );
                }else{
                    $('.banner-parallax-auto').css( 'height', bg_height-totalTopBarsHeight );
                }
            }else{
                $('.banner-parallax-auto').css( 'height', topBarsHeight );
            }
        }else{
            $('.banner-parallax-auto').css( 'height', 300 );

        }
    }

    setSectionHeight();

    function dashboard_fix(){

        var admin_bar_dashboard = $('#wpadminbar');
        var dashboard_head = $('.board-header');
        var nav_step = $(".steps-nav");
        var nav_step_height = nav_step.outerHeight();
        var admin_bar_dashboard_height = admin_bar_dashboard.outerHeight();
        var window_height = $(window).outerHeight();
        var dashboadr_head_height = dashboard_head.outerHeight();

        var dashboardFix = 0;

        dashboardFix = (window_height - header_height);

        if(dashboard_head.length){
            if(dashboard_head.is(':hidden')){
                dashboardFix = dashboardFix;
            }else{
                dashboardFix = dashboardFix - dashboadr_head_height;
            }
        }
        if(top_bar.length){
            dashboardFix = dashboardFix - top_bar_height;
        }
        if(admin_bar_dashboard.length){
            dashboardFix = dashboardFix - admin_bar_dashboard_height;
        }
        if(nav_step.length){
            dashboardFix = dashboardFix - nav_step_height;
        }
        if($(window).width() > 991){
            if (isChrome) {
                $('.dashboard-fix').css('height', dashboardFix - 1);

            }else{
                $('.dashboard-fix').css('height', dashboardFix);
            }
        }else{
            $('.dashboard-fix').css('height', "100%");
        }

    }

    dashboard_fix();

    $(window).on('resize', function () {
        setSectionHeight();
        advancedSearchSticky();
        dashboard_fix();
    });
    $(window).bind('load',function () {
        setSectionHeight();
        dashboard_fix();
    });

    /* ------------------------------------------------------------------------ */
    /*  GET WINDOWS WIDTH HEIGHT
     /* ------------------------------------------------------------------------ */
    function getWindowWidth() {
        return Math.max( $(window).width(), window.innerWidth);
    }

    function getWindowHeight() {
        return Math.max( $(window).height(), window.innerHeight);
    }

    /* ------------------------------------------------------------------------ */
    /*  ADVANCE DROPDOWN
     /* ------------------------------------------------------------------------ */
    $('.search-expand-btn').on('click',function(){
        $(this).toggleClass('active');
        if($(this).hasClass('active')==true)
        {
            $('.search-expandable .advanced-search').slideDown();
        }else
        {
            $('.search-expandable .advanced-search').add('.search-expandable .advance-fields').slideUp();
            $('.advance-btn').removeClass('active');

        }
    });
    $('.advanced-search .advance-btn').on('click',function(){
        $(this).toggleClass('active');
        if($(this).hasClass('active')==true)
        {
            $(this).closest('.advanced-search').find('.advance-fields').slideDown();
        }else
        {
            $(this).closest('.advanced-search').find('.advance-fields').slideUp();
        }
    });

    $('.advanced-search-mobile .advance-btn').on('click',function(){
         $(this).toggleClass('active');
         if($(this).hasClass('active')==true)
         {
             $(this).closest('.advanced-search-mobile').find('.advance-fields').slideDown();
         }else
         {
             $(this).closest('.advanced-search-mobile').find('.advance-fields').slideUp();
         }
    });

    $('.advance-trigger').on('click',function(){
        $(this).toggleClass('active');
        if($(this).hasClass('active')==true)
        {
            $(this).children('i').removeClass('fa-plus-square').addClass('fa-minus-square');
            $('.field-expand').slideDown();
        }else
        {
            $(this).children('i').removeClass('fa-minus-square').addClass('fa-plus-square');
            $('.field-expand').slideUp();
        }
    });

    /* ------------------------------------------------------------------------ */
    /*  SLIDER initialized
    /* ------------------------------------------------------------------------ */
    //var all_slider = $('#banner-slider, .carousel, .lightbox-slide, .property-widget-slider, .houzez-impress-listing-carousel, #carousel-post-card, #carousel-post-card-block');
    var all_slider = $('.owl-carousel');
    all_slider.on('initialized.owl.carousel', function() {
        setTimeout(function(){
            all_slider.animate({opacity: 1}, 800);
            $('.gallery-area .slider-placeholder').remove();
        },800);
    });

    /* ------------------------------------------------------------------------ */
    /*  BANNER SLIDER
     /* ------------------------------------------------------------------------ */
    if($("#banner-slider").length > 0){
        var owl_main_slider = $('#banner-slider');

        owl_main_slider.owlCarousel({
            rtl: houzez_rtl,
            loop: true,
            dots: false,
            slideBy: 1,
            autoplay: true,
            autoplaySpeed: 700,
            items:1,
            smartSpeed: 1000,
            nav: true,
            navText : ["<i class='fa fa-angle-left'></i>","<i class='fa fa-angle-right'></i>"],
            addClassActive: true,
            callbacks: true,
            responsive:{
                0:{
                    nav: false,
                    dots: true
                },
                768:{
                    nav: true,
                    dots: false
                }

            }
        });
    }

    /* ------------------------------------------------------------------------ */
    /*  OWL CAROUSEL
     /* ------------------------------------------------------------------------ */
    if($("#carousel-post-card").length > 0) {

        var owl_post_card = $('#carousel-post-card');

        owl_post_card.owlCarousel({
            rtl: houzez_rtl,
            loop: false,
            dots: true,
            autoplay: true,
            autoplaySpeed: 700,
            slideBy: 1,
            nav: false,
            responsive:{
                0: {
                    items: 1
                },
                320: {
                    items: 1
                },
                480: {
                    items: 1
                },
                768: {
                    items: 2
                },
                1000: {
                    items: 3
                },
                1280: {
                    items: 4
                }
            }
        });

        $('.btn-prev-post-card').on('click',function() {
            owl_post_card.trigger('prev.owl.carousel',[700])
        });
        $('.btn-next-post-card').on('click',function() {
            owl_post_card.trigger('next.owl.carousel',[700])
        });

    }
    if($("#carousel-post-card-block").length > 0) {

        var owl_post_block = $('#carousel-post-card-block');

        owl_post_block.owlCarousel({
            rtl: houzez_rtl,
            loop: true,
            dots: true,
            autoplay: true,
            autoplaySpeed: 700,
            slideBy: 1,
            nav: false,
            responsive:{
                0: {
                    items: 1
                },
                320: {
                    items: 1
                },
                480: {
                    items: 1
                },
                768: {
                    items: 2
                },
                1000: {
                    items: 3
                },
                1280: {
                    items: 4
                }
            }
        });

        $('.btn-prev-card-block').on('click',function() {
            owl_post_block.trigger('prev.owl.carousel',[700])
        });
        $('.btn-next-card-block').on('click',function() {
            owl_post_block.trigger('next.owl.carousel',[700])
        });

    }

    if($("#agents-carousel").length > 0){

        var owlAgents = $('#agents-carousel');
        owlAgents.owlCarousel({
            rtl: houzez_rtl,
            loop: true,
            dots: false,
            slideBy: 1,
            autoplay: true,
            autoplaySpeed: 700,
            nav: false,
            responsive:{
                0: {
                    items: 1
                },
                320: {
                    items: 1
                },
                480: {
                    items: 1
                },
                768: {
                    items: 2
                },
                1000: {
                    items: 3
                },
                1280: {
                    items: 4
                }
            }
        });

        $('.btn-prev-agents').on('click',function() {
            owlAgents.trigger('prev.owl.carousel',[700])
        });
        $('.btn-next-agents').on('click',function() {
            owlAgents.trigger('next.owl.carousel',[700])
        });

    }
    if($("#partner-carousel").length > 0) {

        $("#partner-carousel").owlCarousel({
            rtl: houzez_rtl,
            loop: false,
            dots: true,
            slideBy: 2,
            autoplay: true,
            autoplaySpeed: 700,
            nav:false,
            responsive:{
                0: {
                    items: 1
                },
                320: {
                    items: 1
                },
                480: {
                    items: 3
                },
                768: {
                    items: 4
                },
                992: {
                    items: 4
                }
            }
        });

        $('.btn-prev-partners').on('click',function() {
            $("#partner-carousel").trigger('prev.owl.carousel',[700])
        });
        $('.btn-next-partners').on('click',function() {
            $("#partner-carousel").trigger('next.owl.carousel', [700])
        });

    }

    if($("#agency-carousel").length > 0) {

        var houzez_crl_agency = $('#agency-carousel');

        houzez_crl_agency.owlCarousel({
            rtl: houzez_rtl,
            loop: true,
            dots: true,
            items:4,
            slideBy: 4,
            nav: false,
            smartSpeed:400
        });

        $('.btn-crl-agency-prev').on('click',function() {
            houzez_crl_agency.trigger('prev.owl.carousel',[400])
        });
        $('.btn-crl-agency-next').on('click',function() {
            houzez_crl_agency.trigger('next.owl.carousel',[400])
        });
    }

    if($(".property-widget-slider").length > 0) {
        $('.property-widget-slider').owlCarousel({
            rtl: houzez_rtl,
            dots: true,
            items: 1,
            smartSpeed: 700,
            slideBy: 1,
            nav: true,
            navText : ["<i class='fa fa-angle-left'></i>","<i class='fa fa-angle-right'></i>"],
        });
    }

    /* ------------------------------------------------------------------------ */
    /*  Change listing fee for featured
     /* ------------------------------------------------------------------------ */

    $('.prop_featured').change( function() {

        var currency_symbol = HOUZEZ_ajaxcalls_vars.currency_symbol;
        var currency_position = HOUZEZ_ajaxcalls_vars.currency_position;
        var total_price, total_price_with_currency, price_regular_with_currency;

        var parent = $(this).parents('.payment-side-block');
        var buttons_main_parent = $(this).parents('.houzez-per-listing-buttons-main');
        var price_regular  = parseFloat( parent.find('.submission_price').text() );
        var price_featured = parseFloat( parent.find('.submission_featured_price').text() );

        total_price = price_regular+price_featured;

        if ( currency_position === 'after'){
            price_regular_with_currency = price_regular +' '+currency_symbol;
            total_price_with_currency = total_price +' '+currency_symbol;
        }else{
            price_regular_with_currency = currency_symbol +' '+price_regular;
            total_price_with_currency = currency_symbol+' '+total_price;
        }

        if( $(this).is(':checked') ) {
            parent.find('.submission_total_price').text(total_price_with_currency);
            $('#featured_pay').val(1);
            $('input[name="pay_ammout"]').val(total_price * 100);
            $('#houzez_listing_price').val(total_price);
            buttons_main_parent.find('#stripe_form_simple_listing').hide();
            buttons_main_parent.find('#stripe_form_featured_listing').show();
        } else {
            parent.find('.submission_total_price').text(price_regular_with_currency);
            $('#featured_pay').val(0);
            $('input[name="pay_ammout"]').val(price_regular * 100);
            $('#houzez_listing_price').val(price_regular);
            buttons_main_parent.find('#stripe_form_featured_listing').hide();
            buttons_main_parent.find('#stripe_form_simple_listing').show();
        }
        return false;
    });

    /* ------------------------------------------------------------------------ /
     /* PAY DROPDOWN
     / ------------------------------------------------------------------------ */
    $('.my-actions .pay-btn').on('click', function (event) {
        if($(this).parent().hasClass("open")!=true) {
            $('.my-actions .pay-btn').parent().removeClass("open");
            $(this).parent().addClass("open");
        } else {
            $(this).parent().removeClass("open");
        }
    });
    $('body').on('click', function (e) {
        if (!$('.my-actions .pay-btn').is(e.target) && $('.my-actions .pay-btn').has(e.target).length === 0 && $('.open').has(e.target).length === 0) {
            $('.my-actions .pay-btn').parent().removeClass('open');
        }
    });

    /*-----------------------------------------------------------------------------------*/
    /* PROPERTIES SORTING
    /*-----------------------------------------------------------------------------------*/
    function insertParam(key, value) {
        key = encodeURI(key);
        value = encodeURI(value);

        // get querystring , remove (?) and covernt into array
        var qrp = document.location.search.substr(1).split('&');

        // get qrp array length
        var i = qrp.length;
        var j;
        while (i--) {
            //covert query strings into array for check key and value
            j = qrp[i].split('=');

            // if find key and value then join
            if (j[0] == key) {
                j[1] = value;
                qrp[i] = j.join('=');
                break;
            }
        }

        if (i < 0) {
            qrp[qrp.length] = [key, value].join('=');
        }
        // reload the page
        document.location.search = qrp.join('&');

    }

    $('#sort_properties').on('change', function() {
        var key = 'sortby';
        var value = $(this).val();
        insertParam( key, value );
    });

    /* ------------------------------------------------------------------------ */
    /*  ACCOUNT DROPDOWN
    /* ------------------------------------------------------------------------ */

    function accountDropdown(){
        $('.header-user .account-action > li').on('click',function(e){
            if($(this).hasClass('active')){
                $(this).removeClass('active');
            }else{
                $(this).addClass('active');
            }
        });
        $(".header-right .account-action > li").on({
            mouseenter: function (e) {
                $(this).addClass('active');
            },
            mouseleave: function (e) {
                $(this).removeClass('active');
            }
        });
    }

    accountDropdown();

    /* ------------------------------------------------------------------------ */
    /*  MOBILE MENU
    /* ------------------------------------------------------------------------ */
    function mobileMenu(menu_html,menu_place){
        var siteMenu = $(menu_html).html();
        $(menu_place).html(siteMenu);

        $(menu_place+' ul li').each(function(){
            if($(this).children('.houzez-megamenu-inner').length){
                $(menu_place+' .houzez-megamenu-inner > ul').unwrap();
            }
            $(this).has('ul').addClass('has-child');
        });

        $(menu_place+' ul .has-child').append('<span class="expand-me"></span>');

        $(menu_place+' .expand-me').on('click',function(){
            var parent = $(this).parent('li');
            if(parent.hasClass('active')==true){
                parent.removeClass('active');
                parent.children('ul').slideUp();
            }else{
                parent.addClass('active');
                parent.children('ul').slideDown();
            }
        });
    }
    mobileMenu('.main-nav','.main-nav-dropdown');
    mobileMenu('.top-nav','.top-nav-dropdown');
    //mobileMenu('.top-nav','.top-nav-dropdown');

    // Dropdown open and hide when click on mobile menu Icon.
    $('.nav-trigger').on('click',function(){
        if($(this).hasClass('mobile-open')){
            $(this).removeClass('mobile-open');
        }else{
            $(this).addClass('mobile-open');
        }
    });

    // if single page mobile menu. dropdown will hide on click the tab.
    if($('.header-single-page').length > 0){
        $('.header-single-page .main-nav-dropdown li a').on('click',function(e){
            $('.nav-trigger').removeClass('mobile-open');
            //e.preventDefault();
        });
    }

    // Hide dropdowns when click on body area.
    function element_dropdown_hide(ele,ele_class){
        var nav_dropdown = $('.nav-dropdown');
        var account_dropdown = $('.account-dropdown');

        $(document).mouseup(function (e)
        {
            var nav_trigger = $(ele);
            if (!nav_trigger.is(e.target) // if the target of the click isn't the container...
                && nav_trigger.has(e.target).length === 0 // ... nor a descendant of the container
                && !nav_dropdown.is(e.target)
                && nav_dropdown.has(e.target).length === 0
                && !account_dropdown.is(e.target)
                && account_dropdown.has(e.target).length === 0)
            {
                $(ele).removeClass(ele_class);
            }
        });
    }

    element_dropdown_hide('.header-mobile .nav-trigger','mobile-open');
    element_dropdown_hide('.top-bar .nav-trigger','mobile-open');
    element_dropdown_hide('.account-action > li','active');

    function click_doc_hide(ele){
        $(document).mouseup(function (e)
        {
            if (!$(ele).is(e.target) // if the target of the click isn't the container...
                && $(ele).has(e.target).length === 0 // ... nor a descendant of the container
                )
            {
                $(ele).fadeOut();
            }
        });
    }

    click_doc_hide('.auto-complete');

    /* ------------------------------------------------------------------------ */
    /*  MORTGAGE CALCULATOR SHOW RESULTS
    /* ------------------------------------------------------------------------ */
    $('.show-morg').on('click',function () {
        if($(this).hasClass('active')){
            $('.morg-summery').slideUp();
            $(this).removeClass('active');
        }else{
            $('.morg-summery').slideDown();
            $(this).addClass('active');
        }
    });

    /* ------------------------------------------------------------------------ */
    /*  DETAIL LIGHT BOX SLIDE SHOW
     /* ------------------------------------------------------------------------ */
    var popup_slider = $('.lightbox-slide');
    function lightBoxSlide() {
        popup_slider.show(function(){
            popup_slider.owlCarousel({
                rtl: houzez_rtl,
                dots: false,
                items: 1,
                autoPlay : 1200,
                smartSpeed: 1200,
                autoplay: true,
                slideBy: 1,
                nav: false,
                stopOnHover : true,
                autoHeight : true,
                navText : ["<i class='fa fa-angle-left'></i>","<i class='fa fa-angle-right'></i>"],
                //rewindNav : true,
                //rewindSpeed: 100,
                responsive : {
                    // breakpoint from 768 up
                    768 : {
                        nav: true
                    }
                }
            });
        });
        // Custom Navigation Events
        $('.lightbox-arrow-left').on('click',function() {
            popup_slider.trigger('prev.owl.carousel',[1200])
        });
        $('.lightbox-arrow-right').on('click',function() {
            popup_slider.trigger('next.owl.carousel',[1200])
        });

        $(document).keydown(function(e){
            // handle cursor keys
            if (e.keyCode == 37) {
                popup_slider.trigger('prev.owl.carousel',[1200])
            } else if (e.keyCode == 39) {
                popup_slider.trigger('next.owl.carousel',[1200])
            }
        });
    }
    popup_slider.on('resized.owl.carousel', function () {
        var $this = $(this);
        $this.find('.owl-height').css('height', $this.find('.owl-item.active').height());
    });

    /* ------------------------------------------------------------------------ */
    /*  LIGHT BOX
     /* ------------------------------------------------------------------------ */

    var popupRightWidth = $('.lightbox-right').innerWidth();

    function lightBox(){
        $('.popup-trigger').on('click',function(){
            $('#lightbox-popup-main').addClass('active').addClass('in');
            lightBoxSlide()
        });
        $('.lightbox-close').on('click',function(){
            popup_slider.trigger('destroy.owl.carousel');
            popup_slider.html(popup_slider.find('.owl-stage-outer').html()).removeClass('owl-loaded');
            $('#lightbox-popup-main').removeClass('active').removeClass('in');
        });
        $(document).keydown(function(e){
            if (e.keyCode == 27) {
                $('#lightbox-popup-main').removeClass('active').removeClass('in');
            }
        });
    }
    lightBox();

    function popupResize(){
        var popupWidth = getPopupWidth()-60;
        $('.lightbox-popup').css('width',popupWidth);

        if($('.lightbox-right').length > 0){

            var popupRightWidth = $('.lightbox-right').innerWidth();

            $('.lightbox-left').css('width', (popupWidth - popupRightWidth));
            $('.gallery-inner').css('width', (popupWidth - popupRightWidth)-40);
            $('.lightbox-right').addClass('in');
            $('.lightbox-left .lightbox-close').removeClass('show');
            //$('.lightbox-left .expand-icon').hide('show');

            if (Modernizr.mq('(max-width: 1199px)')) {
                $('.expand-icon').removeClass('compress');
                $('.popup-inner').removeClass('pop-expand');
            }
            if (Modernizr.mq('(max-width: 1024px)')) {
                $('.lightbox-left').css('width', '100%');
                $('.lightbox-right').removeClass('in');
                $('.gallery-inner').css('width', '100%');
                $('.expand-icon').addClass('compress');
                $('.lightbox-left .lightbox-close').addClass('show');
            }
        }else{
            $('.lightbox-left').css('width', '100%');
            $('.gallery-inner').css('width', '100%');
            $('.lightbox-left .lightbox-close').addClass('show');
            //$('.lightbox-expand').hide('show');
        }
    }
    popupResize();
    function popForm_hide_show(){
        $('.lightbox-expand').on('click',function(){
            $('.lightbox-left .lightbox-close').toggleClass('show');
            var popupWidth = getPopupWidth();
            var popWidthTotal = (getPopupWidth()-60) - popupRightWidth;

            if(popupWidth >= 1024){
                if($(this).hasClass('compress')){
                    $('.lightbox-right').addClass('in');
                    $('.lightbox-left').css('width', popWidthTotal);
                    $(this).removeClass('compress');
                    $('.popup-inner').removeClass('pop-expand');
                }else{
                    $('.lightbox-left').css('width', '100%');
                    $('.lightbox-right').removeClass('in');
                    $(this).addClass('compress');
                    $('.popup-inner').addClass('pop-expand');
                }
            }
            if(popupWidth <= 1024/* && popupWidth >= 768*/){
                //$('.lightbox-left').css('width', '100%');

                if ($(this).hasClass('compress')) {
                    $('.lightbox-right').addClass('in');
                    $('.lightbox-left').css('width', popWidthTotal);
                    $(this).removeClass('compress');

                } else {
                    $('.lightbox-left').css('width', '100%');
                    $('.lightbox-right').removeClass('in');
                    $(this).addClass('compress');
                }
            }
            if(popupWidth < 768){
                $('.lightbox-left').css('width', '100%');
                //alert('ok');
            }
        });
    }
    popForm_hide_show();

    var login_here = $('.login-here');
    var register_here = $('.register-here');
    var step_login = $('.step-tab-login');
    var step_register = $('.step-tab-register');
    $('.step-login-btn a').on('click',function (e) {
        var this_login = $(this);
       if(this_login.hasClass('login-here')){
           this_login.hide();
           register_here.show();
           step_login.addClass('in active');
           step_register.removeClass('in active');
           $('#submit_property_form').append('<input type="hidden" name="login_while_submission" id="login_while_submission" value="1">');
       }else{
           this_login.hide();
           login_here.show();
           step_login.removeClass('in active');
           step_register.addClass('in active');
           $('#login_while_submission').remove();
       }
       e.preventDefault();
    });


    /* ------------------------------------------------------------------------ */
    /*  GET lightbox WIDTH HEIGHT
    /* ------------------------------------------------------------------------ */
    function getPopupWidth() {
        return Math.max( $(window).width(), $(window).innerWidth());
    }
    function getPopupInnerWidth() {
        return Math.max( $('.popup-inner').width(), $('.popup-inner').innerWidth());
    }

    /* ------------------------------------------------------------------------ */
    /*  IDX LIST THUMB CLASSES
    /* ------------------------------------------------------------------------ */
    if($('.dsidx-prop-summary').length){
        $('.dsidx-prop-summary .dsidx-prop-title').next('div').addClass('item-thumb');
        $('.item-thumb a').addClass('hover-effect');
    }
    if($('.impress-showcase-photo').length) {
        $('.impress-showcase-photo').addClass('hover-effect');
    }

    $(window).on('load',function(){
        //lightBoxSlide();
        popupResize();
    });

    $(window).on('resize', function () {
        popupResize();
    });

    $( document ).ready(function() {
        $('.tagcloud a').removeAttr('style');
    });


    $('[data-toggle="popover"]').popover({
        trigger: "hover",
        html: true
    });

    $('.dropdown-toggle').dropdown();

})(jQuery);