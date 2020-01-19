<?php
/**
 * Topbar Section options
 *
 * @package Theme Palace
 * @subpackage Magazinews
 * @since Magazinews 1.0.0
 */

// Add Topbar section
$wp_customize->add_section( 'magazinews_topbar_section', array(
	'title'             => esc_html__( 'Topbar','magazinews' ),
	'description'       => esc_html__( 'Topbar Section options.', 'magazinews' ),
	'panel'             => 'magazinews_front_page_panel',
) );

// ads image setting and control.
$wp_customize->add_setting( 'magazinews_theme_options[ads_image]', array(
	'sanitize_callback' => 'magazinews_sanitize_image'
) );

$wp_customize->add_control( new WP_Customize_Image_Control( $wp_customize, 'magazinews_theme_options[ads_image]',
		array(
		'label'       		=> esc_html__( 'Ads Image', 'magazinews' ),
		'description' 		=> sprintf( esc_html__( 'Recommended size: %1$dpx x %2$dpx ', 'magazinews' ), 900, 100 ),
		'section'     		=> 'magazinews_topbar_section',
) ) );

// ads link setting and control
$wp_customize->add_setting( 'magazinews_theme_options[ads_url]', array(
	'sanitize_callback' => 'esc_url_raw',
) );

$wp_customize->add_control( 'magazinews_theme_options[ads_url]', array(
	'label'           	=> esc_html__( 'Ads Url', 'magazinews' ),
	'section'        	=> 'magazinews_topbar_section',
	'type'				=> 'url',
) );