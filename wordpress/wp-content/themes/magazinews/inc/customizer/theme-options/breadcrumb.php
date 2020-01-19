<?php
/**
 * Breadcrumb options
 *
 * @package Theme Palace
 * @subpackage Magazinews
 * @since Magazinews 1.0.0
 */

$wp_customize->add_section( 'magazinews_breadcrumb', array(
	'title'             => esc_html__( 'Breadcrumb','magazinews' ),
	'description'       => esc_html__( 'Breadcrumb section options.', 'magazinews' ),
	'panel'             => 'magazinews_theme_options_panel',
) );

// Breadcrumb enable setting and control.
$wp_customize->add_setting( 'magazinews_theme_options[breadcrumb_enable]', array(
	'sanitize_callback' => 'magazinews_sanitize_switch_control',
	'default'          	=> $options['breadcrumb_enable'],
) );

$wp_customize->add_control( new Magazinews_Switch_Control( $wp_customize, 'magazinews_theme_options[breadcrumb_enable]', array(
	'label'            	=> esc_html__( 'Enable Breadcrumb', 'magazinews' ),
	'section'          	=> 'magazinews_breadcrumb',
	'on_off_label' 		=> magazinews_switch_options(),
) ) );

// Breadcrumb separator setting and control.
$wp_customize->add_setting( 'magazinews_theme_options[breadcrumb_separator]', array(
	'sanitize_callback'	=> 'sanitize_text_field',
	'default'          	=> $options['breadcrumb_separator'],
) );

$wp_customize->add_control( 'magazinews_theme_options[breadcrumb_separator]', array(
	'label'            	=> esc_html__( 'Separator', 'magazinews' ),
	'active_callback' 	=> 'magazinews_is_breadcrumb_enable',
	'section'          	=> 'magazinews_breadcrumb',
) );
