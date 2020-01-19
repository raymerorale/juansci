<?php
/**
 * Customizer default options
 *
 * @package Theme Palace
 * @subpackage Magazinews
 * @since Magazinews 1.0.0
 * @return array An array of default values
 */

function magazinews_get_default_theme_options() {
	$magazinews_default_options = array(
		// Color Options
		'header_title_color'			=> '#fff',
		'header_tagline_color'			=> '#fff',
		'header_txt_logo_extra'			=> 'show-all',
		
		// breadcrumb
		'breadcrumb_enable'				=> true,
		'breadcrumb_separator'			=> '/',
		
		// layout 
		'site_layout'         			=> 'frame-layout',
		'sidebar_position'         		=> 'right-sidebar',
		'post_sidebar_position' 		=> 'right-sidebar',
		'page_sidebar_position' 		=> 'right-sidebar',
		'nav_search_enable'				=> true,

		// excerpt options
		'long_excerpt_length'           => 25,
		'read_more_text'           		=> esc_html__( 'Read More', 'magazinews' ),
		
		// pagination options
		'pagination_enable'         	=> true,
		'pagination_type'         		=> 'default',

		// footer options
		'copyright_text'           		=> sprintf( esc_html_x( 'Copyright &copy; %1$s %2$s. ', '1: Year, 2: Site Title with home URL', 'magazinews' ), '[the-year]', '[site-link]' ) . esc_html__( 'All Rights Reserved | ', 'magazinews' ),
		'scroll_top_visible'        	=> true,

		// reset options
		'reset_options'      			=> false,
		
		// homepage options
		'enable_frontpage_content' 		=> false,

		// homepage sections sortable
		'sortable' 						=> 'headline,slider,featured,popular,blog',

		// blog/archive options
		'your_latest_posts_title' 		=> esc_html__( 'Blogs', 'magazinews' ),
		'hide_category'					=> false,
		'hide_author'					=> false,
		'hide_date'						=> false,

		// single post theme options
		'single_post_hide_date' 		=> false,
		'single_post_hide_author'		=> false,
		'single_post_hide_category'		=> false,
		'single_post_hide_tags'			=> false,

		/* Front Page */

		// Headline
		'headline_section_enable'		=> true,
		'headline_title'				=> esc_html__( 'Breaking News', 'magazinews' ),
		'headline_section_show_on_top'	=> false,

		// Slider
		'slider_section_enable'			=> true,
		'slider_auto_play'				=> false,
		'slider_classic_slider'			=> false,

		// Featured
		'featured_section_enable'		=> true,
		'featured_title'				=> esc_html__( 'Today&#39;s Featured', 'magazinews' ),

		// Popular
		'popular_section_enable'		=> true,
		'popular_title'					=> esc_html__( 'Most Popular', 'magazinews' ),

		// blog
		'blog_section_enable'			=> true,
		'blog_content_type'				=> 'recent',
		'blog_title'					=> esc_html__( 'Recently Viewed', 'magazinews' ),
		'blog_readmore_title'			=> esc_html__( 'Read More', 'magazinews' ),

	);

	$output = apply_filters( 'magazinews_default_theme_options', $magazinews_default_options );

	// Sort array in ascending order, according to the key:
	if ( ! empty( $output ) ) {
		ksort( $output );
	}

	return $output;
}