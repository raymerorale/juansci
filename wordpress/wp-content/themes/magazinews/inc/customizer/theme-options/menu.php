<?php
/**
 * Menu options
 *
 * @package Theme Palace
 * @subpackage Magazinews
 * @since Magazinews 1.0.0
 */

// Add sidebar section
$wp_customize->add_section( 'magazinews_menu', array(
	'title'             => esc_html__('Header Menu','magazinews'),
	'description'       => esc_html__( 'Header Menu options.', 'magazinews' ),
	'panel'             => 'nav_menus',
) );

// search enable setting and control.
$wp_customize->add_setting( 'magazinews_theme_options[nav_search_enable]', array(
	'sanitize_callback' => 'magazinews_sanitize_switch_control',
	'default'           => $options['nav_search_enable'],
) );

$wp_customize->add_control( new Magazinews_Switch_Control( $wp_customize, 'magazinews_theme_options[nav_search_enable]', array(
	'label'             => esc_html__( 'Enable search', 'magazinews' ),
	'section'           => 'magazinews_menu',
	'on_off_label' 		=> magazinews_switch_options(),
) ) );