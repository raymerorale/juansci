<?php 
if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

if ( ! isset( $_SESSION[ 'fb_access_token' ] ) ) {
	$message = __( 'Facebook Access Token has been expired, please do authenticate yourself again by visiting ', 'wp-image-importer' ) .'<b>'. __( 'WP Image Importer', 'wp-image-importer' ) .'</b> --> '. '<a href="'. admin_url( 'admin.php?page=WPIIMP&tab=settings' ) .'"><b>'. __( 'Settings', 'wp-image-importer' ) .'</b></a> --> <b>'. __( 'Facebook', 'wp-image-importer' ) .'</b> '. __( 'tab', 'wp-image-importer' );
	$message .= '<br>'.__( 'After visting the ', 'wp-image-importer' ) .'<b>'. __( 'Facebook tab', 'wp-image-importer' ) .'</b>,'. __( ' hit the ', 'wp-image-importer' ) .'<b>'. __( 'Authenticate', 'wp-image-importer' ). '</b> '. __( 'button.', 'wp-image-importer' );
	wp_die( $message );
}

$fbOpts 	= get_option( 'wpiimp_fb_credentials' );
$fb 		= new Facebook\Facebook([
	'app_id' 				=> $fbOpts[ 'appId' ],
	'app_secret' 			=> $fbOpts[ 'secretKey' ],
	'default_graph_version' => 'v2.8',
]);

$request 	= $fb->request( 
	'GET', 
	'/me/albums', 
	array(
		'fields' => 'count,name,created_time,link'
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
	wp_die( __( 'Graph returned an error: ', 'wp-image-importer' ) . $e->getMessage() );
} catch( Facebook\Exceptions\FacebookSDKException $e ) {
	if ( preg_match( "/You must provide an access token/", $e->getMessage() ) ) {
		unset( $_SESSION[ 'fb_access_token' ] );
		$message = __( 'Facebook Access Token has been expired, please do authenticate yourself again by visiting ', 'wp-image-importer' ) .'<b>'. __( 'WP Image Importer', 'wp-image-importer' ) .'</b> --> '. '<a href="'. admin_url( 'admin.php?page=WPIIMP&tab=settings' ) .'"><b>'. __( 'Settings', 'wp-image-importer' ) .'</b></a> --> <b>'. __( 'Facebook', 'wp-image-importer' ) .'</b> '. __( 'tab', 'wp-image-importer' );
	$message .= '<br>'.__( 'After visting the ', 'wp-image-importer' ) .'<b>'. __( 'Facebook tab', 'wp-image-importer' ) .'</b>,'. __( ' hit the ', 'wp-image-importer' ) .'<b>'. __( 'Authenticate', 'wp-image-importer' ). '</b> '. __( 'button.', 'wp-image-importer' );
		wp_die( $message );
	}

	/**
	 * When validation fails or other local issues
	 */
	wp_die( __( 'Facebook SDK returned an error: ', 'wp-image-importer' ) . $e->getMessage() );
}

$albums = array();
try {
	$albums = $response->getDecodedBody();
} catch ( Exception $e ) {
	wp_die( __( 'Error occured: '. $e->getMessage() ) );
}

if ( empty( $albums ) or ! is_array( $albums ) ) {
	wp_die( 'No albums found !!', 'wp-image-importer' );
} 

if ( empty( $albums[ 'data' ] ) or !is_array( $albums[ 'data' ] ) ) {
	wp_die( 'No albums found !!', 'wp-image-importer' );
}
$albumsData = $albums[ 'data' ];
?>
<div class="<?php echo WPIIMP_PREFIX;?>fb-albums-wrap <?php echo WPIIMP_PREFIX;?>albums-wrap">
	<div class="<?php echo WPIIMP_PREFIX;?>fb-albums-list-wrap <?php echo WPIIMP_PREFIX;?>albums-list-wrap">
		<div class="<?php echo WPIIMP_PREFIX;?>fb-albums-search <?php echo WPIIMP_PREFIX;?>albums-search">
			<input id="<?php echo WPIIMP_PREFIX;?>album-search-input" class="<?php echo WPIIMP_PREFIX;?>fb-album-search-input <?php echo WPIIMP_PREFIX;?>album-search-input" type="search" placeholder="<?php _e( 'Search albums...' );?>">
			<span class="<?php echo WPIIMP_PREFIX;?>fb-album-search-wrap <?php echo WPIIMP_PREFIX;?>album-search-wrap">
				<img src="<?php echo plugins_url( 'wp-image-importer/assets/images/search.png' );?>" alt="">
			</span>
		</div>
		<ul class="<?php echo WPIIMP_PREFIX;?>fb-album-nodes <?php echo WPIIMP_PREFIX;?>album-nodes">
			<?php 
			foreach( $albumsData as $albumNum => $album ) {
				if ( empty( $album ) ) {
					continue;
				}

				$count 			= (int) sanitize_text_field( $album[ 'count' ] );
				$created_time 	= sanitize_text_field( $album[ 'created_time' ] );
				$link 			= esc_url( $album[ 'link' ] );
				$countText 		= ( $count == '0' or $count == '1' ) ? $count . __( " Image", 'wp-image-importer' ) : $count . __( " Images", 'wp-image-importer' );
				?>
				<li class="<?php echo WPIIMP_PREFIX;?>fb-album-node <?php echo WPIIMP_PREFIX;?>album-node" data-id="<?php echo $album[ 'id' ];?>" data-name="<?php echo strtolower( $album[ 'name' ] );?>" data-created="<?php echo $created_time;?>" title="<?php echo $album[ 'name' ];?>">
					<div class="<?php echo WPIIMP_PREFIX;?>fb-album-edge-wrap <?php echo WPIIMP_PREFIX;?>album-edge-wrap">
						<div class="<?php echo WPIIMP_PREFIX;?>fb-album-design <?php echo WPIIMP_PREFIX;?>album-design">
							<img src="<?php echo plugins_url( 'wp-image-importer/assets/images/pictures.png' );?>">
							<p title="<?php echo $album[ 'name' ];?>"><?php echo $album[ 'name' ];?></p>
							<span class="<?php echo WPIIMP_PREFIX;?>fb_album_img_count <?php echo WPIIMP_PREFIX;?>album_img_count"><?php echo $countText;?></span>
						</div>
					</div>
					<input class="<?php echo WPIIMP_PREFIX;?>fb_album_edit_link <?php echo WPIIMP_PREFIX;?>album_edit_link" type="hidden" value="<?php echo $link;?>">
				</li>
			<?php 
			}
			?>
		</ul>
	</div>
	<div class="<?php echo WPIIMP_PREFIX;?>fb-albums-content-wrap <?php echo WPIIMP_PREFIX;?>albums-content-wrap <?php echo WPIIMP_PREFIX;?>hide">
	</div>
</div>
<div class="<?php echo WPIIMP_PREFIX;?>fb-thickbox-wrap <?php echo WPIIMP_PREFIX;?>thickbox-wrap" id="<?php echo WPIIMP_PREFIX;?>thickbox-wrap" style="display:none;">
	<div class="<?php echo WPIIMP_PREFIX;?>fb-thickbox-content <?php echo WPIIMP_PREFIX;?>thickbox-content" id="<?php echo WPIIMP_PREFIX;?>thickbox-content">
		<div class="">
			<img src="" class="<?php echo WPIIMP_PREFIX;?>fb-thickbox-img <?php echo WPIIMP_PREFIX;?>thickbox-img">
		</div>
		<div class="<?php echo WPIIMP_PREFIX;?>fb_media_wrap <?php echo WPIIMP_PREFIX;?>media_wrap">
			<button class="button <?php echo WPIIMP_PREFIX;?>fb_insert_into_media <?php echo WPIIMP_PREFIX;?>insert_into_media" data-src="">
				<?php _e( 'Insert into media library', 'wp-image-importer' ); ?>
			</button>
		</div>
	</div>
</div>