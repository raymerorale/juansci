<?php
/**
 * Blog Section options
 *
 * @package Theme Palace
 * @subpackage Magazinews
 * @since Magazinews 1.0.0
 */

// Add Blog section
$wp_customize->add_section( 'magazinews_blog_section', array(
	'title'             => esc_html__( 'Blog','magazinews' ),
	'description'       => esc_html__( 'Blog Section options.', 'magazinews' ),
	'panel'             => 'magazinews_front_page_panel',
) );

// Blog content enable control and setting
$wp_customize->add_setting( 'magazinews_theme_options[blog_section_enable]', array(
	'default'			=> 	$options['blog_section_enable'],
	'sanitize_callback' => 'magazinews_sanitize_switch_control',
) );

$wp_customize->add_control( new Magazinews_Switch_Control( $wp_customize, 'magazinews_theme_options[blog_section_enable]', array(
	'label'             => esc_html__( 'Blog Section Enable', 'magazinews' ),
	'section'           => 'magazinews_blog_section',
	'on_off_label' 		=> magazinews_switch_options(),
) ) );

// blog title setting and control
$wp_customize->add_setting( 'magazinews_theme_options[blog_title]', array(
	'sanitize_callback' => 'sanitize_text_field',
	'default'			=> $options['blog_title'],
	'transport'			=> 'postMessage',
) );

$wp_customize->add_control( 'magazinews_theme_options[blog_title]', array(
	'label'           	=> esc_html__( 'Title', 'magazinews' ),
	'section'        	=> 'magazinews_blog_section',
	'active_callback' 	=> 'magazinews_is_blog_section_enable',
	'type'				=> 'text',
) );

// Abort if selective refresh is not available.
if ( isset( $wp_customize->selective_refresh ) ) {
    $wp_customize->selective_refresh->add_partial( 'magazinews_theme_options[blog_title]', array(
		'selector'            => '#latest-posts .section-header-wrapper .section-header h2.section-title',
		'settings'            => 'magazinews_theme_options[blog_title]',
		'container_inclusive' => false,
		'fallback_refresh'    => true,
		'render_callback'     => 'magazinews_blog_title_partial',
    ) );
}

// Blog content type control and setting
$wp_customize->add_setting( 'magazinews_theme_options[blog_content_type]', array(
	'default'          	=> $options['blog_content_type'],
	'sanitize_callback' => 'magazinews_sanitize_select',
) );

$wp_customize->add_control( 'magazinews_theme_options[blog_content_type]', array(
	'label'             => esc_html__( 'Content Type', 'magazinews' ),
	'section'           => 'magazinews_blog_section',
	'type'				=> 'select',
	'active_callback' 	=> 'magazinews_is_blog_section_enable',
	'choices'			=> array( 
		'category' 	=> esc_html__( 'Category', 'magazinews' ),
		'recent' 	=> esc_html__( 'Recent', 'magazinews' ),
	),
) );

// Add dropdown category setting and control.
$wp_customize->add_setting(  'magazinews_theme_options[blog_content_category]', array(
	'sanitize_callback' => 'magazinews_sanitize_single_category',
) ) ;

$wp_customize->add_control( new Magazinews_Dropdown_Taxonomies_Control( $wp_customize,'magazinews_theme_options[blog_content_category]', array(
	'label'             => esc_html__( 'Select Category', 'magazinews' ),
	'description'      	=> esc_html__( 'Note: Latest three posts will be shown from selected category', 'magazinews' ),
	'section'           => 'magazinews_blog_section',
	'type'              => 'dropdown-taxonomies',
	'active_callback'	=> 'magazinews_is_blog_section_content_category_enable'
) ) );

// Add dropdown categories setting and control.
$wp_customize->add_setting( 'magazinews_theme_options[blog_category_exclude]', array(
	'sanitize_callback' => 'magazinews_sanitize_category_list',
) ) ;

$wp_customize->add_control( new Magazinews_Dropdown_Category_Control( $wp_customize,'magazinews_theme_options[blog_category_exclude]', array(
	'label'             => esc_html__( 'Select Excluding Categories', 'magazinews' ),
	'description'      	=> esc_html__( 'Note: Select categories to exclude. Press CTRL key select multilple categories.', 'magazinews' ),
	'section'           => 'magazinews_blog_section',
	'type'              => 'dropdown-categories',
	'active_callback'	=> 'magazinews_is_blog_section_content_recent_enable'
) ) );

// blog readmore title setting and control
$wp_customize->add_setting( 'magazinews_theme_options[blog_readmore_title]', array(
	'sanitize_callback' => 'sanitize_text_field',
	'default'			=> $options['blog_readmore_title'],
) );

$wp_customize->add_control( 'magazinews_theme_options[blog_readmore_title]', array(
	'label'           	=> esc_html__( 'ReadMore Label', 'magazinews' ),
	'section'        	=> 'magazinews_blog_section',
	'active_callback' 	=> 'magazinews_is_blog_section_enable',
	'type'				=> 'text',
) );