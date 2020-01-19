<?php
/**
 * Featured Section options
 *
 * @package Theme Palace
 * @subpackage Magazinews
 * @since Magazinews 1.0.0
 */

// Add Featured section
$wp_customize->add_section( 'magazinews_featured_section', array(
	'title'             => esc_html__( 'Featured','magazinews' ),
	'description'       => esc_html__( 'Featured Section options.', 'magazinews' ),
	'panel'             => 'magazinews_front_page_panel',
) );

// Featured content enable control and setting
$wp_customize->add_setting( 'magazinews_theme_options[featured_section_enable]', array(
	'default'			=> 	$options['featured_section_enable'],
	'sanitize_callback' => 'magazinews_sanitize_switch_control',
) );

$wp_customize->add_control( new Magazinews_Switch_Control( $wp_customize, 'magazinews_theme_options[featured_section_enable]', array(
	'label'             => esc_html__( 'Featured Section Enable', 'magazinews' ),
	'section'           => 'magazinews_featured_section',
	'on_off_label' 		=> magazinews_switch_options(),
) ) );

// featured title setting and control
$wp_customize->add_setting( 'magazinews_theme_options[featured_title]', array(
	'sanitize_callback' => 'sanitize_text_field',
	'default'			=> $options['featured_title'],
	'transport'			=> 'postMessage',
) );

$wp_customize->add_control( 'magazinews_theme_options[featured_title]', array(
	'label'           	=> esc_html__( 'Title', 'magazinews' ),
	'section'        	=> 'magazinews_featured_section',
	'active_callback' 	=> 'magazinews_is_featured_section_enable',
	'type'				=> 'text',
) );

// Abort if selective refresh is not available.
if ( isset( $wp_customize->selective_refresh ) ) {
    $wp_customize->selective_refresh->add_partial( 'magazinews_theme_options[featured_title]', array(
		'selector'            => '#featured-posts .section-header-wrapper .section-header h2.section-title',
		'settings'            => 'magazinews_theme_options[featured_title]',
		'container_inclusive' => false,
		'fallback_refresh'    => true,
		'render_callback'     => 'magazinews_featured_title_partial',
    ) );
}

// Add dropdown category setting and control.
$wp_customize->add_setting(  'magazinews_theme_options[featured_content_category]', array(
	'sanitize_callback' => 'magazinews_sanitize_category_list',
) ) ;

$wp_customize->add_control( new Magazinews_Dropdown_Category_Control( $wp_customize,'magazinews_theme_options[featured_content_category]', array(
	'label'             => esc_html__( 'Select Categories', 'magazinews' ),
	'description'      	=> esc_html__( 'Note: Press CTRL and select multiple category. Latest four posts will be shown from each selected category', 'magazinews' ),
	'section'           => 'magazinews_featured_section',
	'type'              => 'dropdown-categories',
	'active_callback'	=> 'magazinews_is_featured_section_enable',
) ) );
