<?php 
if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

if ( ! class_exists( 'WPIIMP_Facebook' ) ) {
	exit();
}
/**
 * Class containing all the plugin functionality
 * @package ImageImporter Wordpress
 */
class WPIIMP_Facebook {

	/**
	 * Constructor
	 */
	function __construct() {
		$this->adminUrl = admin_url( "admin.php?page=WPIIMP" );
		$this->wpiimp_get_access_token();
		add_action( 'wp_ajax_save_fb_settings', array( &$this, 'wpiimp_save_fb_settings' ) );
		add_action( 'wp_ajax_wpiimp_get_fb_album_pics', array( &$this, 'wpiimp_get_fb_album_pics' ) );
		add_action( 'wp_ajax_wpiimp_save_fb_img_to_media_library', array( &$this, 'wpiimp_fb_img_to_library' ) );
	}

	/**
	 * Save facebook api creds and authenticate them.
	 */
	function wpiimp_save_fb_settings() {
		/**
		 * Check if valid ajax is called.
		 */
		$check_ajax = check_ajax_referer( 'wpiimp_nonce', 'wpiim_nonce' );
		if ( ! $check_ajax ) {
			exit( 'failed' );
		}

		$appId 		= sanitize_text_field( $_POST[ 'appId' ] );
		$secretKey 	= sanitize_text_field( $_POST[ 'secretKey' ] );
		
		$loginUrl 	= $this->wpiimp_fb_login( $appId, $secretKey );
		if ( $loginUrl ) {
			$updateFbOpts = array(
				'appId'			=>	$appId,
				'secretKey'		=>	$secretKey,
				'redirectUri'	=>	$this->adminUrl
			);
			$fbOpts = get_option( 'wpiimp_fb_credentials' );
			if ( !empty( $fbOpts ) ) {
				if ( ! in_array( $appId, $fbOpts ) ) {
					$saved 	= update_option( 'wpiimp_fb_credentials', $updateFbOpts );
					if ( $saved ) {
						wp_send_json_success( array(
							'success'	=> true,
							'loginUrl'	=> $loginUrl
						) );
					} else {
						wp_send_json_error( array(
							'success'	=> false,
							'message'	=> __( 'Something went wrong, couldn\'t saved the credentials. Please try again !!', 'wp-image-importer' )
						) );
					}
				} else {
					$saved 	= update_option( 'wpiimp_fb_credentials', $updateFbOpts );
					wp_send_json_success( array(
						'loginUrl'	=> $loginUrl
					) );
				}
			} else {
				$saved 	= update_option( 'wpiimp_fb_credentials', $updateFbOpts );
				if ( $saved ) {
					wp_send_json_success( array(
						'loginUrl'	=> $loginUrl
					) );
				} else {
					wp_send_json_error( array(
						'message'	=> __( 'Something went wrong, couldn\'t saved the credentials. Please try again !!', 'wp-image-importer' )
					) );
				}
			}
		} else {
			wp_send_json_error( array(
				'message'	=> __( 'Authentication failed !!', 'wp-image-importer' )
			) );
		}
		wp_die();
	}

	/**
	 * Creates login url and validates the api.
	 * @param  string $appId     Appid from facebook.
	 * @param  string $secretKey Secret key provided by facebook.
	 * @return string|void       Returns login url on success, empty/error on faliure.
	 */
	function wpiimp_fb_login( $appId, $secretKey ) {
		if ( !$appId || !$secretKey || $secretKey == '' || $appId == '' ) {
			return;
		}

		$redirectUri = $this->adminUrl;
		$fb = new Facebook\Facebook([
			'app_id' 				=> $appId,
			'app_secret' 			=> $secretKey,
			'default_graph_version' => 'v2.8',
		]);
		$helper 		= $fb->getRedirectLoginHelper();
		$permissions 	= [ 'email', 'user_likes' ]; // optional
		$loginUrl 		= $helper->getLoginUrl( $redirectUri, $permissions );
		$loginUrl_fb 	= add_query_arg( 'state', 'facebook', $loginUrl );
		return $loginUrl_fb;
	}

	/**
	 * Fetchingn access token by api credentials.
	 */
	function wpiimp_get_access_token() {
		if( ( isset( $_GET[ 'page' ] ) and $_GET[ 'page' ] == 'WPIIMP' ) and isset( $_GET[ 'code' ] ) and isset( $_GET[ 'state' ] ) ) {
			$responseCode 	= sanitize_text_field( $_GET[ 'code' ] );
			$fbState 		= sanitize_text_field( $_GET[ 'state' ] );
			if( $responseCode && $fbState == 'facebook' ) {
				$appId 		= '';
				$secretKey 	= '';
				$redirectUri= '';
				$fbOpts 	= get_option( 'wpiimp_fb_credentials' );
				if ( !empty( $fbOpts ) ) {
					$appId 		= $fbOpts[ 'appId' ];;
					$secretKey 	= $fbOpts[ 'secretKey' ];
					$redirectUri= $fbOpts[ 'redirectUri' ];
				}

				$fb 	= new Facebook\Facebook([
					'app_id' 				=> $fbOpts[ 'appId' ],
					'app_secret' 			=> $fbOpts[ 'secretKey' ],
					'default_graph_version' => 'v2.8',
				]);

				if( $redirectUri != '' ) {
					$redirectUri = $this->adminUrl;
				}
				$token_url 		= "https://graph.facebook.com/v2.8/oauth/access_token?client_id={$appId}&redirect_uri={$redirectUri}&client_secret={$secretKey}&code={$responseCode}";
				$params 		= null;
				$access_token 	= "";
				$response 		= wp_remote_get( $token_url, array( 'timeout' => 1000000 ) );
	            if( is_object( $response ) or is_wp_error( $response ) ) {
	            	$error = '<p>';
		            	$error .= '<strong>'. __( 'Error', 'wp-image-importer' ) .':</strong> ';
		            	$error .= __( 'Request time out, Please try again !!', 'wp-image-importer' );
		            $error .='</p>';
	            	$error .= '<p>';
	            		$error .='<a href="'. home_url() .'">« '. __( 'Back', 'wp-image-importer' ) .'</a>';
	            	$error .='</p>';
	            	wp_die( $error );
	            } else {
					if( isset( $response[ 'body' ] ) ) {
						$params = json_decode( $response[ 'body' ], true );
						if( isset( $params[ 'access_token' ] ) ) {
							$access_token = $params['access_token'];
						}
					}
				}
				if( isset( $access_token ) ) {
					$_SESSION[ 'fb_access_token' ] = (string) sanitize_text_field( $access_token );
				}
			}
	    }
	}

	/**
	 * fetch facebook albums.
	 */
	function wpiimp_get_fb_album_pics() {
		$check_ajax = check_ajax_referer( 'wpiimp_nonce', 'wpiim_nonce' );
		if ( ! $check_ajax ) {
			exit( 'failed' );
		}

		$albumId = sanitize_text_field( $_POST[ 'albumId' ] );
		$fbOpts 	= get_option( 'wpiimp_fb_credentials' );
		$fb 		= new Facebook\Facebook([
			'app_id' 				=> $fbOpts[ 'appId' ],
			'app_secret' 			=> $fbOpts[ 'secretKey' ],
			'default_graph_version' => 'v2.8',
		]);

		$request 	= $fb->request( 
			'GET', 
			"/{$albumId}/photos", 
			array(
				'fields' => 'album,link,icon,height,width,name,id,images'
			), 
			$_SESSION[ 'fb_access_token' ] 
		);

		/**
		 * Send the request to Graph.
		 */
		try {
			$response = $fb->getClient()->sendRequest( $request );
		} catch( Facebook\Exceptions\FacebookResponseException $e ) {

			/**
			 * When Graph returns an error
			 */
			wp_send_json_error( __( 'Graph returned an error: ', 'wp-image-importer' ) . $e->getMessage() );
			wp_die();
		} catch( Facebook\Exceptions\FacebookSDKException $e ) {
			
			/**
			 * When validation fails or other local issues
			 */
			wp_send_json_error( __( 'Facebook SDK returned an error: ', 'wp-image-importer' ) . $e->getMessage() );
			wp_die();
		}

		$albums = array();
		try {
			$albums = $response->getDecodedBody();
		} catch ( Exception $e ) {
			wp_send_json_error( __( 'Error occured: '. $e->getMessage(), 'wp-image-importer' ) );
			wp_die();
		}

		if ( empty( $albums ) or ! is_array( $albums ) ) {
			wp_send_json_error( __( 'No albums found !!', 'wp-image-importer' ) );
			wp_die();
		} 

		if ( empty( $albums[ 'data' ] ) or !is_array( $albums[ 'data' ] ) ) {
			wp_send_json_error( __( 'No albums found !!', 'wp-image-importer' ) );
			wp_die();
		}
		
		wp_send_json_success( $albums[ 'data' ] );
		wp_die();
	}
}

$WPIIMP_Facebook = new WPIIMP_Facebook();
