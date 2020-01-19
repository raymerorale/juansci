<?php
/**
 * Demo Import.
 *
 * This is the template that includes all the other files for core featured of Theme Palace
 *
 * @package Theme Palace
 * @subpackage Magazinews
 * @since Magazinews 1.0.0
 */

function magazinews_intro_text( $default_text ) {
    $default_text .= sprintf( '<p class="about-description">%1$s <a href="%2$s">%3$s</a></p>', esc_html__( 'Demo content files for Magazinews Theme.', 'magazinews' ),
    esc_url( 'https://themepalace.com/instructions/themes/magazinews' ), esc_html__( 'Click here for Demo File download', 'magazinews' ) );

    return $default_text;
}
add_filter( 'pt-ocdi/plugin_intro_text', 'magazinews_intro_text' );