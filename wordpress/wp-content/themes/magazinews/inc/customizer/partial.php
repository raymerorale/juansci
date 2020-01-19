<?php
/**
* Partial functions
*
* @package Theme Palace
* @subpackage Magazinews
* @since Magazinews 1.0.0
*/

if ( ! function_exists( 'magazinews_headline_title_partial' ) ) :
    // headline title
    function magazinews_headline_title_partial() {
        $options = magazinews_get_theme_options();
        return esc_html( $options['headline_title'] );
    }
endif;

if ( ! function_exists( 'magazinews_featured_title_partial' ) ) :
    // featured title
    function magazinews_featured_title_partial() {
        $options = magazinews_get_theme_options();
        return esc_html( $options['featured_title'] );
    }
endif;

if ( ! function_exists( 'magazinews_popular_title_partial' ) ) :
    // popular title
    function magazinews_popular_title_partial() {
        $options = magazinews_get_theme_options();
        return esc_html( $options['popular_title'] );
    }
endif;

if ( ! function_exists( 'magazinews_blog_title_partial' ) ) :
    // blog title
    function magazinews_blog_title_partial() {
        $options = magazinews_get_theme_options();
        return esc_html( $options['blog_title'] );
    }
endif;

if ( ! function_exists( 'magazinews_copyright_text_partial' ) ) :
    // copyright text
    function magazinews_copyright_text_partial() {
        $options = magazinews_get_theme_options();
        return esc_html( $options['copyright_text'] );
    }
endif;
