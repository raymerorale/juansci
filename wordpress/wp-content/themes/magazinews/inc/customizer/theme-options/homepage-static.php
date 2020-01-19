<?php
/**
* Homepage (Static ) options
*
* @package Theme Palace
* @subpackage Magazinews
* @since Magazinews 1.0.0
*/

// Homepage (Static ) setting and control.
$wp_customize->add_setting( 'magazinews_theme_options[enable_frontpage_content]', array(
	'sanitize_callback'   => 'magazinews_sanitize_checkbox',
	'default'             => $options['enable_frontpage_content'],
) );

$wp_customize->add_control( 'magazinews_theme_options[enable_frontpage_content]', array(
	'label'       	=> esc_html__( 'Enable Content', 'magazinews' ),
	'description' 	=> esc_html__( 'Check to enable content on static front page only.', 'magazinews' ),
	'section'     	=> 'static_front_page',
	'type'        	=> 'checkbox',
) );