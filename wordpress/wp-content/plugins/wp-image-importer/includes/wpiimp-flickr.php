<?php 
if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

if ( ! class_exists( 'WPIIMP_Flickr' ) ) {
	exit();
}
/**
 * Class containing all the plugin functionality
 * @package ImageImporter Wordpress
 */
class WPIIMP_Flickr {

	/**
	 * Constructor
	 */
	function __construct() {
		add_action( 'wp_ajax_wpiimp_get_flickr_album_pics', array( $this, 'wpiimp_get_flickr_album_pics' ) );
	}

	function wpiimp_get_flickr_album_pics() {
		$check_ajax = check_ajax_referer( 'wpiimp_nonce', 'wpiim_nonce' );
		if ( ! $check_ajax ) {
			exit( 'failed' );
		}

		$albumId 	= sanitize_text_field( $_POST[ 'albumId' ] );
		$settings 	= get_option( 'wpiimp_setting' );
		$appId 		= $settings[ 'flickr' ][ 'options' ][ 'appid' ][ 'value' ];
		$userId 	= $settings[ 'flickr' ][ 'options' ][ 'userid' ][ 'value' ];
		$url 		= add_query_arg( 
			array(
			    'method' 			=> 'flickr.photosets.getPhotos',
			    'api_key' 			=> $appId,
			    'user_id' 			=> $userId,
			    'photoset_id' 		=> $albumId,
			    'extras' 			=> 'owner_name,original_format,media,o_dims,url_sq,url_t,url_s,url_m,url_o',
			    'format' 			=> 'json',
			    'nojsoncallback' 	=> 1
			), 
			'https://api.flickr.com/services/rest/' 
		);
		$args 		= array(
			'headers' => array( "Content-type" => "application/json" ),
			'timeout' => 1000
		);

		$response 	= wp_remote_get( $url, $args );
		if ( is_wp_error( $response ) ) {
			wp_send_json_error( __( 'Error:', 'wp-image-importer' ) . $response->get_error_message () );
			wp_die();
		}

		$photosets 		= wp_remote_retrieve_body( $response );
		if ( $photosets == '' ) {
			wp_send_json_error( __( 'Error:', 'wp-image-importer' ) . $response->get_error_message() );
			wp_die();
		}
		
		if ( empty( $photosets ) ) {
			wp_send_json_error( __( 'No image found in this album.', 'wp-image-importer' ) );
			wp_die();
		}

		try {
			$photosets = json_decode( $photosets, true );
		} catch (Exception $e) {
			wp_send_json_error( __( 'Error :', 'wp-image-importer' ) . $e->getMessage() );
			wp_die();
		}

		wp_send_json_success( $photosets );
		wp_die();
	}

}

$WPIIMP_Flickr = new WPIIMP_Flickr();
