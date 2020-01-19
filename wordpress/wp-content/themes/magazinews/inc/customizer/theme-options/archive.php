<?php
/**
 * Archive options
 *
 * @package Theme Palace
 * @subpackage Magazinews
 * @since Magazinews 1.0.0
 */

// Add archive section
$wp_customize->add_section( 'magazinews_archive_section', array(
	'title'             => esc_html__( 'Blog/Archive','magazinews' ),
	'description'       => esc_html__( 'Archive section options.', 'magazinews' ),
	'panel'             => 'magazinews_theme_options_panel',
) );

// Your latest posts title setting and control.
$wp_customize->add_setting( 'magazinews_theme_options[your_latest_posts_title]', array(
	'default'           => $options['your_latest_posts_title'],
	'sanitize_callback' => 'sanitize_text_field',
) );

$wp_customize->add_control( 'magazinews_theme_options[your_latest_posts_title]', array(
	'label'             => esc_html__( 'Your Latest Posts Title', 'magazinews' ),
	'description'       => esc_html__( 'This option only works if Static Front Page is set to "Your latest posts."', 'magazinews' ),
	'section'           => 'magazinews_archive_section',
	'type'				=> 'text',
	'active_callback'   => 'magazinews_is_latest_posts'
) );

// Archive category setting and control.
$wp_customize->add_setting( 'magazinews_theme_options[hide_category]', array(
	'default'           => $options['hide_category'],
	'sanitize_callback' => 'magazinews_sanitize_switch_control',
) );

$wp_customize->add_control( new Magazinews_Switch_Control( $wp_customize, 'magazinews_theme_options[hide_category]', array(
	'label'             => esc_html__( 'Hide Category', 'magazinews' ),
	'section'           => 'magazinews_archive_section',
	'on_off_label' 		=> magazinews_hide_options(),
) ) );

// Archive date setting and control.
$wp_customize->add_setting( 'magazinews_theme_options[hide_date]', array(
	'default'           => $options['hide_date'],
	'sanitize_callback' => 'magazinews_sanitize_switch_control',
) );

$wp_customize->add_control( new Magazinews_Switch_Control( $wp_customize, 'magazinews_theme_options[hide_date]', array(
	'label'             => esc_html__( 'Hide Date', 'magazinews' ),
	'section'           => 'magazinews_archive_section',
	'on_off_label' 		=> magazinews_hide_options(),
) ) );

// Archive author setting and control.
$wp_customize->add_setting( 'magazinews_theme_options[hide_author]', array(
	'default'           => $options['hide_author'],
	'sanitize_callback' => 'magazinews_sanitize_switch_control',
) );

$wp_customize->add_control( new Magazinews_Switch_Control( $wp_customize, 'magazinews_theme_options[hide_author]', array(
	'label'             => esc_html__( 'Hide Author', 'magazinews' ),
	'section'           => 'magazinews_archive_section',
	'on_off_label' 		=> magazinews_hide_options(),
) ) );