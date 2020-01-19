jQuery(document).ready(function($) {

/*------------------------------------------------
                POPULAR
------------------------------------------------*/

if( magazinews_popular_category ) {
    popular_cat = magazinews_popular_category.cat;
    if ( popular_cat.length !== 0 ) {
        $('#popular-posts .section-content-wrapper').slick('slickFilter', '.' + popular_cat);
    }
    
}


/*------------------------------------------------
                END JQUERY
------------------------------------------------*/

});