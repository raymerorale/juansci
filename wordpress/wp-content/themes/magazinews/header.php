<?php
	/**
	 * The header for our theme.
	 *
	 * This is the template that displays all of the <head> section and everything up until <div id="content">
	 *
	 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
	 *
	 * @package Theme Palace
	 * @subpackage Magazinews
	 * @since Magazinews 1.0.0
	 */

	/**
	 * magazinews_doctype hook
	 *
	 * @hooked magazinews_doctype -  10
	 *
	 */
	do_action( 'magazinews_doctype' );

?>
<head>
<?php
	/**
	 * magazinews_before_wp_head hook
	 *
	 * @hooked magazinews_head -  10
	 *
	 */
	do_action( 'magazinews_before_wp_head' );

	wp_head(); 
?>
</head>
<body <?php body_class(); ?>>

<?php do_action( 'wp_body_open' ); ?>

<?php
	/**
	 * magazinews_page_start_action hook
	 *
	 * @hooked magazinews_page_start -  10
	 *
	 */
	do_action( 'magazinews_page_start_action' ); 

	/**
	 * magazinews_header_action hook
	 *
	 * @hooked magazinews_header_start -  10
	 * @hooked magazinews_site_branding -  20
	 * @hooked magazinews_site_navigation -  30
	 * @hooked magazinews_header_end -  50
	 *
	 */
	do_action( 'magazinews_header_action' );

	/**
	 * magazinews_content_start_action hook
	 *
	 * @hooked magazinews_content_start -  10
	 *
	 */
	do_action( 'magazinews_content_start_action' );

	/**
	 * magazinews_header_image_action hook
	 *
	 * @hooked magazinews_header_image -  10
	 *
	 */
	do_action( 'magazinews_header_image_action' );

    if ( magazinews_is_frontpage() ) {
    	$options = magazinews_get_theme_options();
    	$sorted = array();
    	if ( ! empty( $options['sortable'] ) ) {
			$sorted = explode( ',' , $options['sortable'] );
		}

		foreach ( $sorted as $section ) {
			add_action( 'magazinews_primary_content', 'magazinews_add_'. $section .'_section' );
		}
		do_action( 'magazinews_primary_content' );
	}