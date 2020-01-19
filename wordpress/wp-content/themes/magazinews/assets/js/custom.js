jQuery(document).ready(function($) {

/*------------------------------------------------
            DECLARATIONS
------------------------------------------------*/

    var loader                  = $('#loader');
    var loader_container        = $('#preloader');
    var scroll                  = $(window).scrollTop();  
    var scrollup                = $('.backtotop');
    var primary_menu_toggle     = $('#masthead .menu-toggle');
    var top_menu_toggle         = $('#top-navigation .menu-toggle');
    var dropdown_toggle         = $('button.dropdown-toggle');
    var primary_nav_menu        = $('#masthead .main-navigation');
    var top_nav_menu            = $('#top-navigation .main-navigation');
    var featured_slider         = $('#featured-slider');
    var popular_post_slider     = $('#popular-posts .section-content-wrapper');
    var recent_post_slider      = $('.recent-post-slider');
    var featured_collection     = $('#featured-collection .section-content-wrapper');

/*------------------------------------------------
            PRELOADER
------------------------------------------------*/

    loader_container.delay(1000).fadeOut();
    loader.delay(1000).fadeOut("slow");
    
/*------------------------------------------------
            BACK TO TOP
------------------------------------------------*/

    $(window).scroll(function() {
        if ($(this).scrollTop() > 1) {
            scrollup.css({bottom:"25px"});
        } 
        else {
            scrollup.css({bottom:"-100px"});
        }
    });

    scrollup.click(function() {
        $('html, body').animate({scrollTop: '0px'}, 800);
        return false;
    });

/*------------------------------------------------
            MAIN NAVIGATION
------------------------------------------------*/

    primary_menu_toggle.click(function(){
        primary_nav_menu.slideToggle();
        $(this).toggleClass('active');
        $('.menu-overlay').toggleClass('active');
        $('#masthead .main-navigation').toggleClass('menu-open');
    });

    top_menu_toggle.click(function(){
        top_nav_menu.slideToggle();
        $(this).toggleClass('active');
        $('.menu-overlay').toggleClass('active');
        $('#top-navigation .main-navigation').toggleClass('menu-open');
        $('#top-navigation').css({ 'z-index' : '30000' });

        if( $('#masthead .menu-toggle').hasClass('active') ) {
            primary_nav_menu.slideUp();
            $('#masthead .main-navigation').removeClass('menu-open');
            $('#masthead .menu-toggle').removeClass('active');
            $('.menu-overlay').toggleClass('active');
        }
    });

    dropdown_toggle.click(function() {
        $(this).toggleClass('active');
       $(this).parent().find('.sub-menu').first().slideToggle();
    });

    $(window).scroll(function() {
        if ($(this).scrollTop() > 210) {
            $('#masthead').addClass('nav-shrink');
        } 
        else {
            $('#masthead').removeClass('nav-shrink');
        }
    });

    $(document).click(function (e) {
        var container = $("#masthead, #top-navigation");
        if (!container.is(e.target) && container.has(e.target).length === 0) {
            primary_nav_menu.slideUp();
            $(this).removeClass('active');
            $('.menu-overlay').removeClass('active');
            $('#masthead .main-navigation').removeClass('menu-open');
            $('.menu-toggle').removeClass('active');

            top_nav_menu.slideUp();
            $(this).removeClass('active');
            $('.menu-overlay').removeClass('active');
            $('#top-navigation .main-navigation').removeClass('menu-open');
        }
    });

    $('.headline-on-top #breaking-news').insertBefore('#masthead');

/*------------------------------------------------
            Sliders
------------------------------------------------*/

featured_slider.slick({
    responsive: [
    {
        breakpoint: 992,
        settings: {
            slidesToShow: 2
        }
    },
    {
        breakpoint: 767,
        settings: {
            slidesToShow: 1,
            arrows: false
        }
    }
    ]
});

popular_post_slider.slick({
    responsive: [
    {
        breakpoint: 992,
        settings: {
            slidesToShow: 2
        }
    },
    {
        breakpoint: 767,
        settings: {
            slidesToShow: 1,
            arrows: false,
            dots: false
        }
    }
    ]
});

featured_collection.slick({
    responsive: [
    {
        breakpoint: 992,
        settings: {
            slidesToShow: 2
        }
    },
    {
        breakpoint: 767,
        settings: {
            slidesToShow: 1,
            arrows: false,
            dots: false
        }
    }
    ]
});

recent_post_slider.slick({
    responsive: [
    {
        breakpoint: 767,
        settings: {
            slidesToShow: 1,
            arrows: false,
            dots: false
        }
    }
    ]
});

var recent_post_image = $('.recent-post-slider article .featured-image');
var recent_post_dots = $('.recent-post-slider .slick-dots');

recent_post_image.append(recent_post_dots);

/*------------------------------------------------
                TABS
------------------------------------------------*/

$('ul.tabs li').on('click', function(event) {
    event.preventDefault();

    if(!$(this).hasClass('active')) {
        $(this).parent().find('.active').removeClass('active');
    }

    $(this).addClass('active');

    if(!$(this).parent().next().find('.tab-content').eq($(this).index()).hasClass('active')) {
        $(this).parent().next().find('.active').removeClass('active');
    }  

    $(this).parent().next().find('.tab-content').eq($(this).index()).addClass('active');
});

/*------------------------------------------------
                AJAX FILTER
------------------------------------------------*/

$('#ajax-filter li').click(function() {

   var ajax_tab_id = $(this).attr('data-tab');

   var data_url = $(this).attr('data-url');
   var data_name = $(this).attr('data-name');

   $(this).parent().find('li').removeClass('active');
   $(this).parent().parent().parent().find('.tab-content' ).removeClass('active');

   $(this).addClass('active');
   $(this).parent().parent().parent().find('.tab-content#' + ajax_tab_id ).addClass('active');

   $(this).parent().parent().find('.view-all .more-link').attr('href', data_url);
   $(this).parent().parent().find('.view-all .more-link span').replaceWith('<span>' + data_name + '</span>');
});

$('#popular-posts #ajax-filter li a').click( function(e) {
    e.preventDefault();
    
    var currentCategory = '.' + $(this).data('slug');
    $('#popular-posts .section-content-wrapper').slick('slickUnfilter');
    $('#popular-posts .section-content-wrapper').slick('slickFilter', currentCategory);
    $('#popular-posts .popular-post-wrapper').matchHeight();
});

/*------------------------------------------------
                MATCH HEIGHT
------------------------------------------------*/

$('#popular-posts .popular-post-wrapper').matchHeight();
$('#featured-posts .featured-post-wrapper').matchHeight();
$('#featured-slider article').matchHeight();

/*------------------------------------------------
                END JQUERY
------------------------------------------------*/

});