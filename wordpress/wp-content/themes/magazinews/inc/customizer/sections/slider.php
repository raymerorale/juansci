<?php
/**
 * Slider Section options
 *
 * @package Theme Palace
 * @subpackage Magazinews
 * @since Magazinews 1.0.0
 */

// Add Slider section
$wp_customize->add_section( 'magazinews_slider_section', array(
	'title'             => esc_html__( 'Main Slider','magazinews' ),
	'description'       => esc_html__( 'Slider Section options.', 'magazinews' ),
	'panel'             => 'magazinews_front_page_panel',
) );

// Slider content enable control and setting
$wp_customize->add_setting( 'magazinews_theme_options[slider_section_enable]', array(
	'default'			=> 	$options['slider_section_enable'],
	'sanitize_callback' => 'magazinews_sanitize_switch_control',
) );

$wp_customize->add_control( new Magazinews_Switch_Control( $wp_customize, 'magazinews_theme_options[slider_section_enable]', array(
	'label'             => esc_html__( 'Slider Section Enable', 'magazinews' ),
	'section'           => 'magazinews_slider_section',
	'on_off_label' 		=> magazinews_switch_options(),
) ) );

// Slider auto play enable control and setting
$wp_customize->add_setting( 'magazinews_theme_options[slider_auto_play]', array(
	'default'			=> 	$options['slider_auto_play'],
	'sanitize_callback' => 'magazinews_sanitize_switch_control',
) );

$wp_customize->add_control( new Magazinews_Switch_Control( $wp_customize, 'magazinews_theme_options[slider_auto_play]', array(
	'label'             => esc_html__( 'Auto Play Enable', 'magazinews' ),
	'section'           => 'magazinews_slider_section',
	'on_off_label' 		=> magazinews_switch_options(),
	'active_callback'	=> 'magazinews_is_slider_section_enable'
) ) );

//classic slider enable control and setting
$wp_customize->add_setting( 'magazinews_theme_options[slider_classic_slider]', array(
	'default'			=> 	$options['slider_classic_slider'],
	'sanitize_callback' => 'magazinews_sanitize_switch_control',
) );

$wp_customize->add_control( new Magazinews_Switch_Control( $wp_customize, 'magazinews_theme_options[slider_classic_slider]', array(
	'label'             => esc_html__( 'Classic Slider Enable', 'magazinews' ),
	'section'           => 'magazinews_slider_section',
	'on_off_label' 		=> magazinews_switch_options(),
	'active_callback'	=> 'magazinews_is_slider_section_enable'
) ) );

// Add dropdown category setting and control.
$wp_customize->add_setting(  'magazinews_theme_options[slider_content_category]', array(
	'sanitize_callback' => 'magazinews_sanitize_single_category',
) ) ;

$wp_customize->add_control( new Magazinews_Dropdown_Taxonomies_Control( $wp_customize,'magazinews_theme_options[slider_content_category]', array(
	'label'             => esc_html__( 'Select Category', 'magazinews' ),
	'description'      	=> esc_html__( 'Note: Latest five posts will be shown from selected category', 'magazinews' ),
	'section'           => 'magazinews_slider_section',
	'type'              => 'dropdown-taxonomies',
	'active_callback'	=> 'magazinews_is_slider_section_enable'
) ) );
