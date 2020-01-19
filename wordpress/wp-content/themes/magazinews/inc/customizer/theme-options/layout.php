<?php
/**
 * Layout options
 *
 * @package Theme Palace
 * @subpackage Magazinews
 * @since Magazinews 1.0.0
 */

// Add sidebar section
$wp_customize->add_section( 'magazinews_layout', array(
	'title'               => esc_html__('Layout','magazinews'),
	'description'         => esc_html__( 'Layout section options.', 'magazinews' ),
	'panel'               => 'magazinews_theme_options_panel',
) );

// Site layout setting and control.
$wp_customize->add_setting( 'magazinews_theme_options[site_layout]', array(
	'sanitize_callback'   => 'magazinews_sanitize_select',
	'default'             => $options['site_layout'],
) );

$wp_customize->add_control(  new Magazinews_Custom_Radio_Image_Control ( $wp_customize, 'magazinews_theme_options[site_layout]', array(
	'label'               => esc_html__( 'Site Layout', 'magazinews' ),
	'section'             => 'magazinews_layout',
	'choices'			  => magazinews_site_layout(),
) ) );

// Sidebar position setting and control.
$wp_customize->add_setting( 'magazinews_theme_options[sidebar_position]', array(
	'sanitize_callback'   => 'magazinews_sanitize_select',
	'default'             => $options['sidebar_position'],
) );

$wp_customize->add_control(  new Magazinews_Custom_Radio_Image_Control ( $wp_customize, 'magazinews_theme_options[sidebar_position]', array(
	'label'               => esc_html__( 'Global Sidebar Position', 'magazinews' ),
	'section'             => 'magazinews_layout',
	'choices'			  => magazinews_global_sidebar_position(),
) ) );

// Post sidebar position setting and control.
$wp_customize->add_setting( 'magazinews_theme_options[post_sidebar_position]', array(
	'sanitize_callback'   => 'magazinews_sanitize_select',
	'default'             => $options['post_sidebar_position'],
) );

$wp_customize->add_control(  new Magazinews_Custom_Radio_Image_Control ( $wp_customize, 'magazinews_theme_options[post_sidebar_position]', array(
	'label'               => esc_html__( 'Posts Sidebar Position', 'magazinews' ),
	'section'             => 'magazinews_layout',
	'choices'			  => magazinews_sidebar_position(),
) ) );

// Post sidebar position setting and control.
$wp_customize->add_setting( 'magazinews_theme_options[page_sidebar_position]', array(
	'sanitize_callback'   => 'magazinews_sanitize_select',
	'default'             => $options['page_sidebar_position'],
) );

$wp_customize->add_control( new Magazinews_Custom_Radio_Image_Control( $wp_customize, 'magazinews_theme_options[page_sidebar_position]', array(
	'label'               => esc_html__( 'Pages Sidebar Position', 'magazinews' ),
	'section'             => 'magazinews_layout',
	'choices'			  => magazinews_sidebar_position(),
) ) );