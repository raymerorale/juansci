<?php
/**
 * Footer options
 *
 * @package Theme Palace
 * @subpackage Magazinews
 * @since Magazinews 1.0.0
 */

// Footer Section
$wp_customize->add_section( 'magazinews_section_footer',
	array(
		'title'      			=> esc_html__( 'Footer Options', 'magazinews' ),
		'priority'   			=> 900,
		'panel'      			=> 'magazinews_theme_options_panel',
	)
);

// footer image setting and control.
$wp_customize->add_setting( 'magazinews_theme_options[footer_image]', array(
	'sanitize_callback' => 'magazinews_sanitize_image'
) );

$wp_customize->add_control( new WP_Customize_Image_Control( $wp_customize, 'magazinews_theme_options[footer_image]',
		array(
		'label'       		=> esc_html__( 'Site Info Logo', 'magazinews' ),
		'description' 		=> sprintf( esc_html__( 'Recommended size: %1$dpx x %2$dpx ', 'magazinews' ), 188, 23 ),
		'section'     		=> 'magazinews_section_footer',
) ) );

// footer text
$wp_customize->add_setting( 'magazinews_theme_options[copyright_text]',
	array(
		'default'       		=> $options['copyright_text'],
		'sanitize_callback'		=> 'magazinews_santize_allow_tag',
		'transport'				=> 'postMessage',
	)
);
$wp_customize->add_control( 'magazinews_theme_options[copyright_text]',
    array(
		'label'      			=> esc_html__( 'Copyright Text', 'magazinews' ),
		'section'    			=> 'magazinews_section_footer',
		'type'		 			=> 'textarea',
    )
);

// Abort if selective refresh is not available.
if ( isset( $wp_customize->selective_refresh ) ) {
    $wp_customize->selective_refresh->add_partial( 'magazinews_theme_options[copyright_text]', array(
		'selector'            => '.site-info .copyright span',
		'settings'            => 'magazinews_theme_options[copyright_text]',
		'container_inclusive' => false,
		'fallback_refresh'    => true,
		'render_callback'     => 'magazinews_copyright_text_partial',
    ) );
}

// scroll top visible
$wp_customize->add_setting( 'magazinews_theme_options[scroll_top_visible]',
	array(
		'default'       	=> $options['scroll_top_visible'],
		'sanitize_callback' => 'magazinews_sanitize_switch_control',
	)
);
$wp_customize->add_control( new Magazinews_Switch_Control( $wp_customize, 'magazinews_theme_options[scroll_top_visible]',
    array(
		'label'      		=> esc_html__( 'Display Scroll Top Button', 'magazinews' ),
		'section'    		=> 'magazinews_section_footer',
		'on_off_label' 		=> magazinews_switch_options(),
    )
) );