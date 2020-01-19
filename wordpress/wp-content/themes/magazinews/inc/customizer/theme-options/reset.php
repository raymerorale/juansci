<?php
/**
 * Reset options
 *
 * @package Theme Palace
 * @subpackage Magazinews
 * @since Magazinews 1.0.0
 */

/**
* Reset section
*/
// Add reset enable section
$wp_customize->add_section( 'magazinews_reset_section', array(
	'title'             => esc_html__('Reset all settings','magazinews'),
	'description'       => esc_html__( 'Caution: All settings will be reset to default. Refresh the page after clicking Save & Publish.', 'magazinews' ),
) );

// Add reset enable setting and control.
$wp_customize->add_setting( 'magazinews_theme_options[reset_options]', array(
	'default'           => $options['reset_options'],
	'sanitize_callback' => 'magazinews_sanitize_checkbox',
	'transport'			  => 'postMessage',
) );

$wp_customize->add_control( 'magazinews_theme_options[reset_options]', array(
	'label'             => esc_html__( 'Check to reset all settings', 'magazinews' ),
	'section'           => 'magazinews_reset_section',
	'type'              => 'checkbox',
) );
