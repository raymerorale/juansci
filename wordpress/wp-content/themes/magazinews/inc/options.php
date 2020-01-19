<?php
/**
 * Theme Palace options
 *
 * @package Theme Palace
 * @subpackage Magazinews
 * @since Magazinews 1.0.0
 */

/**
 * List of pages for page choices.
 * @return Array Array of page ids and name.
 */
function magazinews_page_choices() {
    $pages = get_pages();
    $choices = array();
    $choices[0] = esc_html__( '--Select--', 'magazinews' );
    foreach ( $pages as $page ) {
        $choices[ $page->ID ] = $page->post_title;
    }
    return  $choices;
}

/**
 * List of posts for post choices.
 * @return Array Array of post ids and name.
 */
function magazinews_post_choices() {
    $posts = get_posts( array( 'numberposts' => -1 ) );
    $choices = array();
    $choices[0] = esc_html__( '--Select--', 'magazinews' );
    foreach ( $posts as $post ) {
        $choices[ $post->ID ] = $post->post_title;
    }
    return  $choices;
}

if ( ! function_exists( 'magazinews_site_layout' ) ) :
    /**
     * Site Layout
     * @return array site layout options
     */
    function magazinews_site_layout() {
        $magazinews_site_layout = array(
            'wide'  => get_template_directory_uri() . '/assets/images/full.png',
            'boxed-layout' => get_template_directory_uri() . '/assets/images/boxed.png',
            'frame-layout' => get_template_directory_uri() . '/assets/images/framed.png',
        );

        $output = apply_filters( 'magazinews_site_layout', $magazinews_site_layout );
        return $output;
    }
endif;

if ( ! function_exists( 'magazinews_selected_sidebar' ) ) :
    /**
     * Sidebars options
     * @return array Sidbar positions
     */
    function magazinews_selected_sidebar() {
        $magazinews_selected_sidebar = array(
            'sidebar-1'             => esc_html__( 'Default Sidebar', 'magazinews' ),
            'optional-sidebar'      => esc_html__( 'Optional Sidebar', 'magazinews' ),
        );

        $output = apply_filters( 'magazinews_selected_sidebar', $magazinews_selected_sidebar );

        return $output;
    }
endif;


if ( ! function_exists( 'magazinews_global_sidebar_position' ) ) :
    /**
     * Global Sidebar position
     * @return array Global Sidebar positions
     */
    function magazinews_global_sidebar_position() {
        $magazinews_global_sidebar_position = array(
            'right-sidebar' => get_template_directory_uri() . '/assets/images/right.png',
            'no-sidebar'    => get_template_directory_uri() . '/assets/images/full.png',
        );

        $output = apply_filters( 'magazinews_global_sidebar_position', $magazinews_global_sidebar_position );

        return $output;
    }
endif;


if ( ! function_exists( 'magazinews_sidebar_position' ) ) :
    /**
     * Sidebar position
     * @return array Sidbar positions
     */
    function magazinews_sidebar_position() {
        $magazinews_sidebar_position = array(
            'right-sidebar' => get_template_directory_uri() . '/assets/images/right.png',
            'no-sidebar'    => get_template_directory_uri() . '/assets/images/full.png',
        );

        $output = apply_filters( 'magazinews_sidebar_position', $magazinews_sidebar_position );

        return $output;
    }
endif;


if ( ! function_exists( 'magazinews_pagination_options' ) ) :
    /**
     * Pagination
     * @return array site pagination options
     */
    function magazinews_pagination_options() {
        $magazinews_pagination_options = array(
            'numeric'   => esc_html__( 'Numeric', 'magazinews' ),
            'default'   => esc_html__( 'Default(Older/Newer)', 'magazinews' ),
        );

        $output = apply_filters( 'magazinews_pagination_options', $magazinews_pagination_options );

        return $output;
    }
endif;

if ( ! function_exists( 'magazinews_switch_options' ) ) :
    /**
     * List of custom Switch Control options
     * @return array List of switch control options.
     */
    function magazinews_switch_options() {
        $arr = array(
            'on'        => esc_html__( 'Enable', 'magazinews' ),
            'off'       => esc_html__( 'Disable', 'magazinews' )
        );
        return apply_filters( 'magazinews_switch_options', $arr );
    }
endif;

if ( ! function_exists( 'magazinews_hide_options' ) ) :
    /**
     * List of custom Switch Control options
     * @return array List of switch control options.
     */
    function magazinews_hide_options() {
        $arr = array(
            'on'        => esc_html__( 'Yes', 'magazinews' ),
            'off'       => esc_html__( 'No', 'magazinews' )
        );
        return apply_filters( 'magazinews_hide_options', $arr );
    }
endif;

if ( ! function_exists( 'magazinews_sortable_sections' ) ) :
    /**
     * List of sections Control options
     * @return array List of Sections control options.
     */
    function magazinews_sortable_sections() {
        $sections = array(
            'headline'  => esc_html__( 'Headline', 'magazinews' ),
            'slider'    => esc_html__( 'Main Slider', 'magazinews' ),
            'featured'  => esc_html__( 'Featured', 'magazinews' ),
            'popular'   => esc_html__( 'Popular', 'magazinews' ),
            'blog'      => esc_html__( 'Blog', 'magazinews' ),
        );
        return apply_filters( 'magazinews_sortable_sections', $sections );
    }
endif;