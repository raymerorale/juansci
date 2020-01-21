<?php 
if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

if ( ! class_exists( 'WPIIMP' ) ) {
	
	/**
	 * Class containing all the plugin functionality
	 * @package ImageImporter Wordpress
	 *
	 */
	class WPIIMP {
		
		/**
		 * The option name, used throughout to refer to the plugins option and option group.
		 * @var sting
		 */
		var $option_name = 'wpiimp_option';
		
		/**
		 * The plugins options, loaded on init containing all the plugin settings
		 * @var array
		 */
		var $options = array();
		
		/**
		 * Database version, used to allow for easy upgrades in plugin options between different versions.
		 * @var int
		 */
		var $db_version = 9;
		
		/**
		 * Contains notice messages.
		 * @var int
		 */
		var $notice_message = '';
		
		/**
		 * Contains notice classes.
		 * @var int
		 */
		var $notice_classes = '';
		
		/**
		 * Constructor
		 * 
		 * @since 1.0
		 */
		function __construct() {

			
			/**
			 * Register a setting Menu.
			 */
			add_action ( 'admin_menu', array( &$this, 'wpiimp_add_menu' ) );

			/**
			 * Create Wp Image Importer Tab in Add Media section.
			 */
			add_filter ( 'media_upload_tabs', array( &$this, 'wpiimp_media_upload_tabs_handler' ) );
			add_action ( 'media_upload_imgimportertab', array(	&$this, 'wpiimp_media_upload_imgimporter_handler' ) );

			add_action( 'admin_enqueue_scripts', array( &$this, 'wpiimp_enqueue_admin_scripts' ) );
			
			/**
			 * Save credentials.
			 */
			add_action( 'wp_ajax_save_flickr_settings', array( &$this, 'wpiimp_save_flickr_settings' ) );
			add_action( 'wp_ajax_save_pixabay_settings', array( &$this, 'wpiimp_save_pixabay_settings' ) );
			
			add_filter ( "plugin_action_links_" . plugin_basename ( __FILE__ ), array (	&$this,'wiimp_action_links_handler'	) );
			
			register_activation_hook ( plugin_basename( __FILE__ ), array( &$this, 'wiimp_set_default_on_activate' ) );

			add_action( 'wp_ajax_ced_iimp_save_image_to_post', array( &$this, 'ced_iimp_save_image_to_post' ) );
			add_action( 'wp_ajax_wpiimp_save_img_to_media_library', array( &$this, 'wpiimp_img_to_library' ) );
			
			add_action( 'wp_ajax_wpiimp_submit_suggestions', array( &$this, 'wpiimp_submit_suggestions' ) );

			add_action( 'wpiimp_set_admin_notices', array( &$this, 'wpiimp_set_admin_notices' ), 100, 2 );
			add_action( 'admin_notices', array( &$this, 'wpiimp_plugin_notices' ) );
			add_action('wp_ajax_ced_image_importer_send_mail',array(&$this,'ced_image_importer_send_mail'));
		}

		/**
		 * Send suggestions to us
		 */
		function wpiimp_submit_suggestions() {
			/**
			 * Check ajax request nonce field
			 */
			$check_ajax = check_ajax_referer( 'wpiimp_nonce', 'wpiim_nonce' );
			if ( ! $check_ajax ) {
				wp_die( 'failed' );
			}

			global $allowedposttags;

			$title 			= sanitize_text_field( $_POST[ 'title' ] );
			$description 	= wp_kses( stripslashes( $_POST[ 'description' ] ), $allowedposttags );
			$to 			= 'plugins@cedcommerce.com';
			$subject 		= 'Suggestions related to Wp Image Importer plugin.';
			$message 		= $description;
			$headers 		= array( 'Content-Type: text/html; charset=UTF-8' );
			$sent 			= wp_mail( $to, $subject, $message, $headers );
			if ( $sent ) {
				$notice = __( 'Mail sent succesfully.', 'wp-image-importer' );
				wp_send_json_success( $notice );
			} else {
				$notice = __( 'Something went worng, please send again!!', 'wp-image-importer' );
				wp_send_json_error( $notice );
			}
			wp_die();
		}


		function ced_image_importer_send_mail()
		{
			if(isset($_POST["flag"]) && $_POST["flag"]==true && !empty($_POST["emailid"]))
			{
				$to = "support@cedcommerce.com";
				$subject = "Wordpress Org Know More";
				$message = 'This user of our woocommerce extension "WP Image Importer" wants to know more about marketplace extensions.<br>';
				$message .= 'Email of user : '.$_POST["emailid"];
				$headers = array('Content-Type: text/html; charset=UTF-8');
				$flag = wp_mail( $to, $subject, $message);	
				if($flag == 1)
				{
					echo json_encode(array('status'=>true,'msg'=>__('Soon you will receive the more details of this extension on the given mail.',"wp-image-importer")));
				}
				else
				{
					echo json_encode(array('status'=>false,'msg'=>__('Sorry,an error occurred.Please try again.',"wp-image-importer")));
				}
			}
			else
			{
				echo json_encode(array('status'=>false,'msg'=>__('Sorry,an error occurred.Please try again.',"wp-image-importer")));
			}
			wp_die();
		}



		function wpiimp_set_admin_notices( $message, $error = false ) {
			if ( !$message or empty( $message ) or ! is_string( $message ) ) {
				return false;
			}

			$this->notice_classes = $error ? 'error notice is-dismissible' : 'updated notice notice-success is-dismissible';
			$this->notice_message = $message;
		}

		function wpiimp_plugin_notices() {
			if ( empty( $this->notice_message ) ) {
				return;
			}?>
			<div class="<?php echo $this->notice_classes;?>">
				<p><?php echo $this->notice_message; ?></p>
				<button type="button" class="notice-dismiss">
					<span class="screen-reader-text"><?php _e( 'Dismiss this notice.', 'wp-image-importer' );?></span>
				</button>
			</div>
		<?php
		}

		/**
		 * Save image to post and as an attachment.
		 */
		function ced_iimp_save_image_to_post() {
			if ( isset( $_POST['insert_img'] ) ) {
				$setting_options = get_option ( 'wpiimp_setting' );
				if (! function_exists ( 'wp_verify_nonce' )) {
					require_once ( ABSPATH . 'wp-includes/pluggable.php' );
				}
				
				$nonce = $_POST[ 'wpnonce' ];
				if ( ! wp_verify_nonce ( $nonce, 'wpiim_img_nonce' )) {
					die ( _e ( 'Error: Invalid request.', 'wp-image-importer' ) );
					exit ();
				}
				
				$postid = absint( $_REQUEST ['post_id'] );

				// validate imgurl
				$url = esc_url( str_replace ( 'https:', 'http:', $_POST ['img_url'] ) );
				$parsed_url = parse_url ( $url );

				/*----------  Download image from the given url.  ----------*/
				$args = array( 'timeout' => 1200000000, 'httpversion' => '1.1' );
				$img_file = wp_remote_get( $url, $args );
				if ( is_wp_error( $img_file ) ) {
					die ( _e ( 'Error:', 'wp-image-importer' ) . $img_file->get_error_message () );
				}

				$img_upload_dir = wp_upload_dir();
				$img_path = $img_upload_dir[ 'path' ];
				
				if (! is_dir( $img_path )) {
					if ( ! @mkdir( $img_path, 0755, true ) ) {
						die ( _e ( 'Error: Not Able to Create Upload Directory', 'wp-image-importer' ) . $img_path );
					}
				}

				$query_explode = explode( ' ', $_POST['query'] );
				array_splice ( $query_explode, 2 );
				foreach( $query_explode as $k => $v ) {
					$v = str_replace ( "..", "", $v );
					$v = str_replace ( "/", "", $v );
					$query_explode[$k] = trim( $v );
				}

				$img_path_info 			= pathinfo( $url );
				$source_img_file_name 	= sanitize_file_name ( implode( '_', $query_explode ) . '_' . time() . '.' . $img_path_info[ 'extension' ] );
				
				$target_imgfile_name 	= $img_path . '/' . $source_img_file_name;
				$result 				= @file_put_contents( $target_imgfile_name, $img_file['body'] );
				if ( $result === false ) {
					die( _e ( 'Error: Failed to write file ', 'wp-image-importer' ) . $target_imgfile_name );
				}
				
				require_once( ABSPATH . 'wp-admin/includes/image.php' );
				if ( ! wp_read_image_metadata( $target_imgfile_name ) ) {
					unlink ( $target_imgfile_name );
					die ( _e ( 'Error: File is not an image.', 'wp-image-importer' ) );
				}
				unset( $img_file ['body'] );
				
				$img_title = ucwords( implode ( ', ', $query_explode ) );
				$attachment_caps = '';
				if ( isset( $_POST[ 'img_from' ] ) ) {
					if ( $_POST[ 'img_from' ] == 'pixabay' ) {
						if ( $setting_options[ 'pixabay' ] ['options'] ['attribution'] ['value'] ) {
							if ( isset( $_POST[ 'img_user' ] ) ) {
								$attachment_caps = '<a href="https://pixabay.com/users/' . $_POST[ 'img_user' ] . '/">' . htmlentities ( $_POST[ 'img_user' ] ) . '</a> / Pixabay';
							}
						}
					} elseif ( $_POST[ 'img_from' ] == 'flickr' ) {
						if ( $setting_options[ 'flickr' ][ 'options' ][ 'attribution' ][ 'value' ] ) {
							if ( isset( $_POST [ 'img_user' ] ) ) {
								$attachment_caps = '/' . htmlentities( $_POST[ 'img_user' ] );
							}
						}
					}
				}
				
				/*----------  insert attachment  ----------*/
				$wp_filetype = wp_check_filetype( basename( $target_imgfile_name ), null );
				$attachment  = array(
					'guid' 				=> $img_upload_dir[ 'url' ] . '/' . basename( $target_imgfile_name ),
					'post_mime_type' 	=> $wp_filetype[ 'type' ],
					'post_title' 		=> preg_replace( '/\.[^.]+$/', '', $img_title ),
					'post_status' 		=> 'inherit' 
				);
				$attach_id = wp_insert_attachment( $attachment, $target_imgfile_name, $postid );
				if( $attach_id == 0 ) {
					die ( _e ( 'Error: File attachment error', 'wp-image-importer' ) );
				}
				
				$attach_data 	= wp_generate_attachment_metadata( $attach_id, $target_imgfile_name );
				$result 		= wp_update_attachment_metadata( $attach_id, $attach_data );
				if ( $result === false ) {
					die ( _e ( 'Error: File attachment metadata error', 'wp-image-importer' ) );
				}
				
				$image_data 		= array ();
				$image_data ['ID'] 	= $attach_id;
				$image_data ['post_excerpt'] = $attachment_caps;
				wp_update_post( $image_data );
				wp_die( $attach_id );
			}
		}

		/**
		 * Save flickr api credentials and settings
		 */
		function wpiimp_save_flickr_settings() {
			/**
			 * Check ajax request nonce field
			 */
			$check_ajax = check_ajax_referer( 'wpiimp_nonce', 'wpiim_nonce' );
			if ( ! $check_ajax ) {
				wp_die( 'failed' );
			}

			$setting_options = get_option ( 'wpiimp_setting' );
			$setting_options[ 'flickr' ][ 'options' ][ 'appid' ][ 'value' ] 		= $_POST[ 'app_id' ];
			$setting_options[ 'flickr' ][ 'options' ][ 'userid' ][ 'value' ] 		= $_POST[ 'userid' ];
			$setting_options[ 'flickr' ][ 'options' ][ 'license' ][ 'value' ] 		= $_POST[ 'license' ];
			$setting_options[ 'flickr' ][ 'options' ][ 'sort' ][ 'value' ] 			= $_POST[ 'order_by' ];
			$setting_options[ 'flickr' ][ 'options' ][ 'per_page' ][ 'value' ] 		= $_POST[ 'per_page' ];
			$setting_options[ 'flickr' ][ 'options' ][ 'attribution' ][ 'value' ] 	= $_POST[ 'attriution' ];
			
			$result = update_option( 'wpiimp_setting', $setting_options );
			if ( $result ) {
				$message = array(
					'status'	=> 'ok',
					'message'	=> __( 'Settings have been updated.', 'wp-image-importer' )
				);
				wp_die( json_encode( $message ) );
			} else {
				$message = array(
					'status'	=> 'failed',
					'message'	=> __( 'It seems you haven\'t done any changes, settings could not be Updated!!', 'wp-image-importer' )
				);
				wp_die( json_encode( $message ) );
			}
		}

		/**
		 * Save pixabay settings and credentials.
		 */
		function wpiimp_save_pixabay_settings() {
			/**
			 * Check ajax request nonce field
			 */
			$check_ajax = check_ajax_referer( 'wpiimp_nonce', 'wpiim_nonce' );
			if ( ! $check_ajax ) {
				wp_die( 'failed' );
			}

			$setting_options = get_option ( 'wpiimp_setting' );
			$setting_options[ 'pixabay' ][ 'options' ][ 'appid' ][ 'value' ] 		= sanitize_text_field( $_POST[ 'app_id' ] );
			$setting_options[ 'pixabay' ][ 'options' ][ 'image_type' ][ 'value' ] 	= $_POST[ 'image_type' ];
			$setting_options[ 'pixabay' ][ 'options' ][ 'language' ][ 'value' ] 	= $_POST[ 'language' ];
			$setting_options[ 'pixabay' ][ 'options' ][ 'per_page' ][ 'value' ] 	= $_POST[ 'per_page' ];
			$setting_options[ 'pixabay' ][ 'options' ][ 'orientation' ][ 'value' ] 	= $_POST[ 'orientation' ];
			$setting_options[ 'pixabay' ][ 'options' ][ 'attribution' ][ 'value' ] 	= $_POST[ 'attriution' ];
			
			$result = update_option( 'wpiimp_setting', $setting_options );
			if ( $result ) {
				$message = array(
					'status'	=> 'ok',
					'message'	=> __( 'Settings have been updated.', 'wp-image-importer' )
				);
				wp_die( json_encode( $message ) );
			} else {
				$message = array(
					'status'	=> 'failed',
					'message'	=> __( 'It seems you haven\'t done any changes, settings could not be Updated!!', 'wp-image-importer' )
				);
				wp_die( json_encode( $message ) );
			}
		}
		
		/**
		 * Set default setting on plugin activate
		 * 
		 */
		function wiimp_set_default_on_activate() {
			$default = array(
				'flickr' => array(
					'options' => array(
						'appid' => array(
							'value'  =>  '',
						),
						'license' => array(
							'value'  =>  '4,5,6,7',
						),
						'sort' => array(
							'value'  =>  'relevance',
						),
						'per_page' => array(
							'value'  =>  '30',
						),
						'attribution' => array(
							'value'  =>  '1',
						),
					),
				),
				'pixabay' => array(
					'options' => array(
						'appid' => array(
							'value'  =>  '',
						),
						'image_type' => array(
							'value'  =>  'photo',
						),
						'language' => array(
							'value'  =>  'en',
						),
						'per_page' => array(
							'value'  =>  '30',
						),
						'orientation' => array(
							'value'  =>  'all',
						),
						'attribution' => array(
							'value'  =>  '1',
						),
					),
				)
			);
			if (! get_option ( 'WPIIMP_VERSION_NO') || get_option ( 'WPIIMP_VERSION_NO' < '1.0.3' )) {
				update_option ( 'WPIIMP_VERSION_NO', '1.0.3' );
				update_option( 'wpiimp_setting', $default );
			}
		}
		
		/**
		 * enqueue style and script
		 */
		function wpiimp_enqueue_admin_scripts () {
			if ( !is_admin() ) {
				return false;
			}

			wp_enqueue_style( 'wpiimp-admin-css', IIMP_URL . '/assets/css/admin.min.css', array(), WPIIMP_VERSION_NO, 'all' );

			wp_enqueue_style( 'wpiimp-admin-style-css', IIMP_URL . '/assets/css/admin.css', array('wpiimp-admin-css'), WPIIMP_VERSION_NO, 'all' );

			wp_enqueue_style( 'wpiimp-custom-admin-style-css', IIMP_URL . '/assets/css/ced_wii_custom.css', array('wpiimp-admin-css'), WPIIMP_VERSION_NO, 'all' );
			
			wp_register_script( 'wpiimp-api-authentication', IIMP_URL . '/assets/js/wpiimp-api.min.js', array( 'jquery' ), WPIIMP_VERSION_NO, true );

			wp_register_script('wpiimp-admin-mailer', IIMP_URL . '/assets/js/admin-mailer.js', array('jquery'), WPIIMP_VERSION_NO, true );

			wp_enqueue_script('wpiimp-admin-mailer');

			wp_localize_script('wpiimp-admin-mailer','ajax_url',admin_url('admin-ajax.php'));

			wp_enqueue_script( 'wpiimp-api-authentication' );

			$fb_thckbox_query_arg = add_query_arg( 
				array(
					'TB_inline' => 'true',
					'width'     => 500,
					'height'    => 400,
					'inlineId'  => 'ced_iimp_thickbox-wrap',
				)
			);

			$translationsForApi = array(
				'ajaxUrl' 			=> admin_url( 'admin-ajax.php' ),
				'base_url' 			=> home_url(),
				'wpiimp_nonce'		=> wp_create_nonce( 'wpiimp_nonce' ),
				'fb_thckbox_arg'	=> $fb_thckbox_query_arg
			);
			wp_localize_script( 'wpiimp-api-authentication', 'globals', $translationsForApi );

			if ( isset( $_GET[ 'page' ] ) and $_GET[ 'page' ] == 'WPIIMP' and isset( $_GET[ 'tab' ] ) and $_GET[ 'tab' ] == 'suggestions' ) {
				wp_register_script( 'wpiimp-suggestions', IIMP_URL . '/assets/js/wpiimp-admin-suggestions.min.js', array( 'jquery' ), WPIIMP_VERSION_NO, true );
				wp_enqueue_script( 'wpiimp-suggestions' );

				$translations = array(
					'ajaxUrl' 		=> admin_url( 'admin-ajax.php' ),
					'base_url' 		=> home_url(),
					'wpiimp_nonce'	=> wp_create_nonce( 'wpiimp_nonce' )
				);
				wp_localize_script( 'wpiimp-suggestions', 'suggestions', $translations );
			}

			wp_enqueue_script( 'wpiimp_media_tab', IIMP_URL . '/assets/js/media_tab.min.js', array( 'jquery' ), WPIIMP_VERSION_NO, true );
			$thckbox_query_arg = add_query_arg( 
				array(
					'TB_inline' => 'true',
					'width'     => 500,
					'height'    => 400,
					'inlineId'  => 'ced_iimp_image-content',
				)
			);

			$setting_options = get_option( 'wpiimp_setting' );
			$translation_array = array(
				'ajax_url' 			=> admin_url( 'admin-ajax.php' ),
				'base_url' 			=> home_url(),
				'postid' 			=> isset( $_REQUEST['post_id'] ) ? absint( $_REQUEST['post_id'] ) : 0,
				'lang' 				=> $setting_options['pixabay']['options']['language']['value']? $setting_options['pixabay']['options']['language']['value']: substr(get_locale(), 0, 2),
				'page_size' 		=> $setting_options['pixabay']['options']['per_page']['value']? $setting_options['pixabay']['options']['per_page']['value'] : 30 ,
				'page_size_f' 		=> $setting_options['flickr']['options']['per_page']['value']? $setting_options['flickr']['options']['per_page']['value'] : 30,
				'sort' 				=> $setting_options['flickr']['options']['sort']['value'],
				'license' 			=> $setting_options['flickr']['options']['license']['value'],
				'wpiim_img_nonce'	=> wp_create_nonce( 'wpiim_img_nonce' ),
				'fappid' 			=> $setting_options['flickr']['options']['appid']['value'],
				'pappid' 			=> $setting_options['pixabay']['options']['appid']['value'],
				'thckbox_query_arg' => $thckbox_query_arg,
				'pixabay_search' 	=> __( 'Pixabay Search for ', 'wp-image-importer' ),
				'pixabay_default' 	=> __( 'Pixabay default search.', 'wp-image-importer' ),
				'total_record' 		=> __( 'Total record found ', 'wp-image-importer' ),
				'flickr_search' 	=> __( 'Flickr Search for ', 'wp-image-importer' ),
				'flickr_default' 	=> __( 'Flickr default search.', 'wp-image-importer' ),
				'next' 				=> __( 'Next', 'wp-image-importer' ),
				'prev' 				=> __( 'Prev', 'wp-image-importer' ),
				'no_hit' 			=> __( 'No hit found.', 'wp-image-importer' ),
				'img_unknown_error' => __( 'Something went wrong, please choose either another dimensions of this image or another image !!', 'wp-image-importer' ),
			);
			wp_localize_script( 'wpiimp_media_tab', 'setting_obj', $translation_array );
			add_thickbox();
		}

		/**
		 * Inserts api album images to wordpress media library.
		 */
		function wpiimp_img_to_library() {
			/**
			 * Check ajax request nonce field
			 */
			$check_ajax = check_ajax_referer( 'wpiimp_nonce', 'wpiim_nonce' );
			if ( ! $check_ajax ) {
				wp_die( 'failed' );
			}

			// validate imgurl
			$url 	= str_replace( 'https:', 'http:', $_POST['src'] );

			/**
			 *  Download image from the given url.
			 */
			$img_file = wp_remote_get( $url, array( 'timeout' => 10000 ) );
			if ( is_wp_error( $img_file ) ) {
				wp_die( _e ( 'Error:', 'wp-image-importer' ) . $img_file->get_error_message() );
			}
			
			/**
			 * fetch image upload directory.
			 */
			$imgUploadDir 	= wp_upload_dir();
			$img_path 		= $imgUploadDir[ 'path' ];
			
			if ( ! is_dir( $img_path )) {
				if ( ! @mkdir( $img_path, 0755, true ) ) {
					wp_die( _e ( 'Error: Not Able to Create Upload Directory', 'wp-image-importer' ) . $img_path );
				}
			}

			$img_path_info 	= pathinfo( $url );
			$image_file = pathinfo( $url, PATHINFO_BASENAME );
			$dirname 	= pathinfo( $url, PATHINFO_DIRNAME );
			$ext 		= pathinfo( $url, PATHINFO_EXTENSION );
			$fileName 	= sanitize_text_field( pathinfo( $url, PATHINFO_FILENAME ) );
			$imageMimes = array( 'jpg', 'jpeg', 'png', 'gif', 'ico' );
			if ( ! in_array( $ext, $imageMimes ) ) {
				$ext = explode( '?', $ext );
				if ( !empty( $ext ) ) {
					$ext 		= $ext[0];
					$filetype 	= wp_check_filetype( "{$fileName}.{$ext}" );
					if ( empty( $filetype ) or empty( $filetype[ 'ext' ] ) ) {
						wp_send_json_error( 'This is image is not allowed' );	
						wp_die();
					}
					$ext 		= $filetype[ 'ext' ];
				} else {
					wp_send_json_error( __( 'This type of images are not allowed !!', 'wp-image-importer' ) );
					wp_die();
				}
			}

			/**
			 * Manging file name and path to insert image to upload directory.
			 */
			$source_img_file_name 	= sanitize_file_name( time() . '.' . $ext );
			$target_imgfile_name 	= $img_path . '/' . $source_img_file_name;

			/**
			 * Insert image to directory.
			 */
			$result 	= @file_put_contents( $target_imgfile_name, $img_file['body'] );
			if ( $result === false ) {
				wp_send_json_error( _e ( 'Error: Failed to write file ', 'wp-image-importer' ) . $target_imgfile_name );
				wp_die();
			}
			
			require_once( ABSPATH . 'wp-admin/includes/image.php' );
			if ( ! wp_read_image_metadata( $target_imgfile_name ) ) {
				unlink ( $target_imgfile_name );
				wp_send_json_error( _e ( 'Error: File is not an image.', 'wp-image-importer' ) );
				wp_die();
			}

			unset( $img_file ['body'] );
			
			// insert attachment
			$wp_filetype = wp_check_filetype( basename( $target_imgfile_name ), null );
			$attachment  = array(
				'guid' 				=> $imgUploadDir[ 'url' ] . '/' . basename( $target_imgfile_name ),
				'post_mime_type' 	=> $wp_filetype[ 'type' ],
				'post_title' 		=> '',
				'post_status' 		=> 'inherit' 
			);

			/**
			 * Insert the uploaded attachment to media library.
			 */
			$attach_id = wp_insert_attachment( $attachment, $target_imgfile_name, $postid );
			if( $attach_id == 0 ) {
				wp_send_json_error( _e ( 'Error: File attachment error', 'wp-image-importer' ) );
				wp_die();
			}
			
			$attach_data 	= wp_generate_attachment_metadata( $attach_id, $target_imgfile_name );
			$result 		= wp_update_attachment_metadata( $attach_id, $attach_data );
			if ( $result === false ) {
				wp_send_json_error( _e ( 'Error: File attachment metadata error', 'wp-image-importer' ) );
				wp_die();
			}
			
			$image_data 		= array ();
			$image_data['ID'] 	= $attach_id;
			$updated = wp_update_post( $image_data );
			if ( $updated ) {
				wp_send_json_success( 
					array(
						'attachment' 	=> $attach_id,
						'message'		=> __( 'Image sucessfully inserted into media library.', 'wp-image-importer' )
					)
				);
				wp_die();
			}
		}

		/**
		 * Adds setting menu in admin setting area
		 */
		function wpiimp_add_menu() {
			add_menu_page( 'WP Image Importer', 'WP Image Importer', 'manage_options', SLUG, array( &$this, 'img_imp_add_menu' ), 'dashicons-camera' );
		}
				
		function wiimp_action_links_handler( $action_links ) {
			$settings_link = '<a href="admin.php?page=WPIIMP">'. __( 'Settings', 'wp-image-importer' ) .'</a>';
			array_unshift ( $action_links, $settings_link );
			return $action_links;
		}
		
		/**
		 * Add a tab after media screen
		 * @param array $tabs
		 * @return array
		 */
		function wpiimp_media_upload_tabs_handler( $tabs ) {
			$tabs[ 'imgimportertab' ] = __( 'WP Image Importer', 'wp-image-importer' );
			return $tabs;
		}
		
		/**
		 * media tab action
		 */
		function wpiimp_media_upload_imgimporter_handler() {
			wp_iframe( array( &$this, 'wpiimp_media_imgimporter_images_tab' ) );
		}
		
		/**
		 * media tab rendering function
		 */
		function wpiimp_media_imgimporter_images_tab() {
			$setting_options = get_option( 'wpiimp_setting' );
			$pixabayPhoto = '';
			$pixabayClipart = '';
			$pixabayHorizontal = '';
			$pixabayVertical = '';
			if ( !empty( $setting_options ) ) {

				if ( $setting_options[ 'pixabay' ][ 'options' ][ 'image_type' ][ 'value' ] == 'photo' ) {
					$pixabayPhoto = 'checked';
				}
				
				if ( $setting_options[ 'pixabay' ][ 'options' ][ 'image_type' ][ 'value' ] == 'clipart' ) {
					$pixabayClipart = 'checked';
				}

				if ( $setting_options[ 'pixabay' ][ 'options' ][ 'orientation' ][ 'value' ] == 'horizontal' ) {
					$pixabayHorizontal = 'checked';
				}

				if ( $setting_options['pixabay']['options']['orientation']['value'] == 'vertical' ) {
					$pixabayVertical = 'checked';
				}
			}
			?>
			<div class="ced-full-container-wrapper">
				<div class="<?php echo WPIIMP_PREFIX;?>loader_wrap <?php echo WPIIMP_PREFIX;?>hide">
					<div class="<?php echo WPIIMP_PREFIX;?>spinner"></div>
				</div>
				<div class="<?php echo WPIIMP_PREFIX;?>img_search_wrapper">
					<form id="<?php echo WPIIMP_PREFIX;?>img_search_form">
						<p>
							<input type="text" id="<?php echo WPIIMP_PREFIX;?>query" style="width: 100%; max-width: 500px;">
						</p>
						<p>
							<label>
								<input type="checkbox" id="<?php echo WPIIMP_PREFIX;?>fetch_photo" <?php echo $pixabayPhoto;?>>
								<?php _e( 'Photos', 'wp-image-importer' );?>
							</label>
							<label>
								<input type="checkbox" id="<?php echo WPIIMP_PREFIX;?>fetch_cliparts" <?=$pixabayClipart;?>>
								<?php _e( 'Cliparts', 'wp-image-importer' );?>
							</label>
							<label>
								<input type="checkbox" id="<?php echo WPIIMP_PREFIX;?>fetch_horizental" <?=$pixabayHorizontal;?>>
								<?php _e( 'Horizontal', 'wp-image-importer' );?>
							</label>
							<label>
								<input type="checkbox" id="<?php echo WPIIMP_PREFIX;?>fetch_vertical" <?=$pixabayVertical;?>>
								<?php _e( 'Vertical', 'wp-image-importer' );?>
							</label>
						</p>
						<input type="submit" name="search" class="button" value="<?php _e( 'Search', 'wp-image-importer' );?>">
						<p class="<?php echo WPIIMP_PREFIX;?>setting_navigation_link_wrap">
							<a class="<?php echo WPIIMP_PREFIX;?>setting_navigation_link" href="admin.php?page=WPIIMP" target='_blank'><?php _e( 'Setting', 'wp-image-importer' );?></a>
						</p>
					</form>
				</div>
				<div id="<?php echo WPIIMP_PREFIX;?>wpiimp_result" class="<?php echo WPIIMP_PREFIX;?>images_lists <?php echo WPIIMP_PREFIX;?>pixabay">
				</div>
				<div id="<?php echo WPIIMP_PREFIX;?>wpiimp_resultF"  class="<?php echo WPIIMP_PREFIX;?>images_lists <?php echo WPIIMP_PREFIX;?>flickr">
				</div>
				<div class="<?php echo WPIIMP_PREFIX;?>image-content" id="<?php echo WPIIMP_PREFIX;?>image-content" style="display:none;">
				     <div class="<?php echo WPIIMP_PREFIX;?>image-content-inner">
				     	<img class="<?php echo WPIIMP_PREFIX;?>image-tag" src="">
				     	<div class="<?php echo WPIIMP_PREFIX;?>image_resizer">
				     		<button class="<?php echo WPIIMP_PREFIX;?>insert_s <?php echo WPIIMP_PREFIX;?>choose_size_btn <?php echo WPIIMP_PREFIX;?>hide" data-src="" data-user="" data-img_from="">
				     			<?php _e( 'Small', 'wp-image-importer' );?>( <i class="ced_iimp_dims"></i> )
				     		</button>
				     		<button class="<?php echo WPIIMP_PREFIX;?>insert_m <?php echo WPIIMP_PREFIX;?>choose_size_btn <?php echo WPIIMP_PREFIX;?>hide" data-src="" data-user="" data-img_from="">
				     			<?php _e( 'Medium', 'wp-image-importer' );?>( <i class="ced_iimp_dims"></i> )
			     			</button>
				     		<button class="<?php echo WPIIMP_PREFIX;?>insert_l <?php echo WPIIMP_PREFIX;?>choose_size_btn <?php echo WPIIMP_PREFIX;?>hide" data-src="" data-user="" data-img_from="">
				     			<?php _e( 'Large', 'wp-image-importer' );?>( <i class="ced_iimp_dims"></i> )
			     			</button>
				     	</div>
				     </div>
				</div>
			</div>
			<?php 
		}
		
		/**
		 * The function to be called to output the content for menu page.
		 */
		function img_imp_add_menu() {
			require_once WPIIMP_PATH . '/includes/importer-option.php';
		}
	}
	
	$WPIIMP = new WPIIMP();
}
