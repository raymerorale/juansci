<?php
/**
 * Customizer active callbacks
 *
 * @package Theme Palace
 * @subpackage Magazinews
 * @since Magazinews 1.0.0
 */

if ( ! function_exists( 'magazinews_is_breadcrumb_enable' ) ) :
	/**
	 * Check if breadcrumb is enabled.
	 *
	 * @since Magazinews 1.0.0
	 * @param WP_Customize_Control $control WP_Customize_Control instance.
	 * @return bool Whether the control is active to the current preview.
	 */
	function magazinews_is_breadcrumb_enable( $control ) {
		return $control->manager->get_setting( 'magazinews_theme_options[breadcrumb_enable]' )->value();
	}
endif;

if ( ! function_exists( 'magazinews_is_pagination_enable' ) ) :
	/**
	 * Check if pagination is enabled.
	 *
	 * @since Magazinews 1.0.0
	 * @param WP_Customize_Control $control WP_Customize_Control instance.
	 * @return bool Whether the control is active to the current preview.
	 */
	function magazinews_is_pagination_enable( $control ) {
		return $control->manager->get_setting( 'magazinews_theme_options[pagination_enable]' )->value();
	}
endif;

/**
 * Front Page Active Callbacks
 */

/**
 * Check if headline section is enabled.
 *
 * @since Magazinews 1.0.0
 * @param WP_Customize_Control $control WP_Customize_Control instance.
 * @return bool Whether the control is active to the current preview.
 */
function magazinews_is_headline_section_enable( $control ) {
	return ( $control->manager->get_setting( 'magazinews_theme_options[headline_section_enable]' )->value() );
}

/**
 * Check if slider section is enabled.
 *
 * @since Magazinews 1.0.0
 * @param WP_Customize_Control $control WP_Customize_Control instance.
 * @return bool Whether the control is active to the current preview.
 */
function magazinews_is_slider_section_enable( $control ) {
	return ( $control->manager->get_setting( 'magazinews_theme_options[slider_section_enable]' )->value() );
}

/**
 * Check if featured section is enabled.
 *
 * @since Magazinews 1.0.0
 * @param WP_Customize_Control $control WP_Customize_Control instance.
 * @return bool Whether the control is active to the current preview.
 */
function magazinews_is_featured_section_enable( $control ) {
	return ( $control->manager->get_setting( 'magazinews_theme_options[featured_section_enable]' )->value() );
}

/**
 * Check if popular section is enabled.
 *
 * @since Magazinews 1.0.0
 * @param WP_Customize_Control $control WP_Customize_Control instance.
 * @return bool Whether the control is active to the current preview.
 */
function magazinews_is_popular_section_enable( $control ) {
	return ( $control->manager->get_setting( 'magazinews_theme_options[popular_section_enable]' )->value() );
}

/**
 * Check if blog section is enabled.
 *
 * @since Magazinews 1.0.0
 * @param WP_Customize_Control $control WP_Customize_Control instance.
 * @return bool Whether the control is active to the current preview.
 */
function magazinews_is_blog_section_enable( $control ) {
	return ( $control->manager->get_setting( 'magazinews_theme_options[blog_section_enable]' )->value() );
}

/**
 * Check if blog section content type is category.
 *
 * @since Magazinews 1.0.0
 * @param WP_Customize_Control $control WP_Customize_Control instance.
 * @return bool Whether the control is active to the current preview.
 */
function magazinews_is_blog_section_content_category_enable( $control ) {
	$content_type = $control->manager->get_setting( 'magazinews_theme_options[blog_content_type]' )->value();
	return magazinews_is_blog_section_enable( $control ) && ( 'category' == $content_type );
}

/**
 * Check if blog section content type is recent.
 *
 * @since Magazinews 1.0.0
 * @param WP_Customize_Control $control WP_Customize_Control instance.
 * @return bool Whether the control is active to the current preview.
 */
function magazinews_is_blog_section_content_recent_enable( $control ) {
	$content_type = $control->manager->get_setting( 'magazinews_theme_options[blog_content_type]' )->value();
	return magazinews_is_blog_section_enable( $control ) && ( 'recent' == $content_type );
}
