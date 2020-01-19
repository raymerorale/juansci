<?php
/**
 * Headline Section options
 *
 * @package Theme Palace
 * @subpackage Magazinews
 * @since Magazinews 1.0.0
 */

// Add Headline section
$wp_customize->add_section( 'magazinews_headline_section', array(
	'title'             => esc_html__( 'Headline','magazinews' ),
	'description'       => esc_html__( 'Headline Section options.', 'magazinews' ),
	'panel'             => 'magazinews_front_page_panel',
) );

// Headline content enable control and setting
$wp_customize->add_setting( 'magazinews_theme_options[headline_section_enable]', array(
	'default'			=> 	$options['headline_section_enable'],
	'sanitize_callback' => 'magazinews_sanitize_switch_control',
) );

$wp_customize->add_control( new Magazinews_Switch_Control( $wp_customize, 'magazinews_theme_options[headline_section_enable]', array(
	'label'             => esc_html__( 'Headline Section Enable', 'magazinews' ),
	'section'           => 'magazinews_headline_section',
	'on_off_label' 		=> magazinews_switch_options(),
) ) );

// Headline content show on top control and setting
$wp_customize->add_setting( 'magazinews_theme_options[headline_section_show_on_top]', array(
	'default'			=> 	$options['headline_section_show_on_top'],
	'sanitize_callback' => 'magazinews_sanitize_switch_control',
) );

$wp_customize->add_control( new Magazinews_Switch_Control( $wp_customize, 'magazinews_theme_options[headline_section_show_on_top]', array(
	'label'             => esc_html__( 'Headline Section Show On Top', 'magazinews' ),
	'section'           => 'magazinews_headline_section',
	'on_off_label' 		=> magazinews_switch_options(),
) ) );

// headline title setting and control
$wp_customize->add_setting( 'magazinews_theme_options[headline_title]', array(
	'sanitize_callback' => 'sanitize_text_field',
	'default'			=> $options['headline_title'],
	'transport'			=> 'postMessage',
) );

$wp_customize->add_control( 'magazinews_theme_options[headline_title]', array(
	'label'           	=> esc_html__( 'Readmore Label', 'magazinews' ),
	'section'        	=> 'magazinews_headline_section',
	'active_callback' 	=> 'magazinews_is_headline_section_enable',
	'type'				=> 'text',
) );

// Abort if selective refresh is not available.
if ( isset( $wp_customize->selective_refresh ) ) {
    $wp_customize->selective_refresh->add_partial( 'magazinews_theme_options[headline_title]', array(
		'selector'            => '#breaking-news .news-header span.news-title',
		'settings'            => 'magazinews_theme_options[headline_title]',
		'container_inclusive' => false,
		'fallback_refresh'    => true,
		'render_callback'     => 'magazinews_headline_title_partial',
    ) );
}

// Add dropdown category setting and control.
$wp_customize->add_setting(  'magazinews_theme_options[headline_content_category]', array(
	'sanitize_callback' => 'magazinews_sanitize_single_category',
) ) ;

$wp_customize->add_control( new Magazinews_Dropdown_Taxonomies_Control( $wp_customize,'magazinews_theme_options[headline_content_category]', array(
	'label'             => esc_html__( 'Select Category', 'magazinews' ),
	'description'      	=> esc_html__( 'Note: Latest five posts will be shown from selected category', 'magazinews' ),
	'section'           => 'magazinews_headline_section',
	'type'              => 'dropdown-taxonomies',
	'active_callback'	=> 'magazinews_is_headline_section_enable'
) ) );

