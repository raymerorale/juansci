<?php
/**
 * Plugin Name: WP Image Importer
 * Plugin URI: cedcommerce.com
 * Description: WP Image Importer Plugin allows to easily import Images into Posts
 * Version: 1.0.5
 * Text Domain: wp-image-importer
 * Author: CedCommerce
 * Author URI: http://cedcommerce.com
 * Domain Path: /languages
 * License: GPLv2 or later
 * License URI: http://www.gnu.org/licenses/gpl-2.0.html
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

/**
 * WP Image Importer Wordpress Plugin. Allows easy import of Images into posts
 * @package wp-image-importer Wordpress
 * @author cedcommerce
 */
define('WPIIMP_PREFIX', 'ced_iimp_');
define ( 'WPIIMP_SNAME', 'wpiimp' );
define ( 'IIMP_URL', WP_PLUGIN_URL . '/wp-image-importer' );
if (! defined ( 'WPIIMP_PATH' )) {
	define ( 'WPIIMP_PATH', WP_PLUGIN_DIR . '/wp-image-importer' );
}
define ( 'WPIIMP_URL', WP_PLUGIN_URL . '/wp-image-importer' );
define ( 'WPIIMP_BASENAME', plugin_basename ( __FILE__ ) );
define ('SLUG', 'WPIIMP');
if (! defined ( 'WPIIMP_VERSION_NO' ) ) {
	define ( 'WPIIMP_VERSION_NO', '1.0.4' );
}

/**
 *
 *  ON MAIN PLUGIN FILE define the constant
 *
 */
if ( function_exists( 'is_multisite' ) && is_multisite() ) {
	include_once( ABSPATH . 'wp-admin/includes/plugin.php' );
}

if ( !function_exists( 'wpiimp_load_textdomain' ) ) {
	/**
	 * Add custom plugin row meta
	 * @param array $links
	 * @param string $file
	 */
	function wiimp_custom_plugin_row_meta( $links, $file ) {
		if ( strpos( $file, 'wp-image-importer.php' ) !== false ) {
			$new_links = array(
				'demo' => '<a href=" http://demo.cedcommerce.com/wordpress/image-importer/wp-login.php" target="_blank">Demo</a>',
				'documentation' => '<a href="http://demo.cedcommerce.com/wordpress/image-importer/doc/index.html" target="_blank">Documentation</a>',
			);
			$links = array_merge( $links, $new_links );
		}
		return $links;
	}
}
add_filter ( 'plugin_row_meta', 'wiimp_custom_plugin_row_meta', 10, 2 );

if ( !function_exists( 'wpiimp_load_textdomain' ) ) {
	/**
	 * Load text domain
	 */
	function wpiimp_load_textdomain() {
		$domain = "wp-image-importer";
		$locale = apply_filters ( 'plugin_locale', get_locale (), $domain );
		load_textdomain ( $domain, WPIIMP_PATH . 'languages/' . $domain . '-' . $locale . '.mo' );
		load_plugin_textdomain ( 'wp-image-importer', false, plugin_basename( dirname ( __FILE__ ) ) . '/languages' );
	}
}
add_action ( 'plugins_loaded', 'wpiimp_load_textdomain' );

/**
 * Set Session if not set yet.
 */
if ( ! session_id() ) {
	session_start();
}

if ( ! class_exists( 'Facebook' ) ) {
	require( WPIIMP_PATH. '/Facebook/autoload.php' );
}
require_once 'includes/wp-image-importer-class.php';
require_once 'includes/wpiimp-facebook.php';
require_once 'includes/wpiimp-flickr.php';
if ( ! isset( $_SESSION[ 'fb_access_token' ] ) ) {
	$message = __( 'Facebook Access Token has been expired, please do authenticate yourself again by visiting ', 'wp-image-importer' ) .'<b>'. __( 'WP Image Importer', 'wp-image-importer' ) .'</b> --> '. '<a href="'. admin_url( 'admin.php?page=WPIIMP&tab=settings' ) .'"><b>'. __( 'Settings', 'wp-image-importer' ) .'</b></a> --> <b>'. __( 'Facebook', 'wp-image-importer' ) .'</b> '. __( 'tab', 'wp-image-importer' );
	do_action( 'wpiimp_set_admin_notices', $message, true  );
}
