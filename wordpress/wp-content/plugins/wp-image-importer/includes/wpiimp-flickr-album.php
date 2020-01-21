<?php 
if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

$settings 	= get_option( 'wpiimp_setting' );
$appId 		= $settings[ 'flickr' ][ 'options' ][ 'appid' ][ 'value' ];
$userId 	= $settings[ 'flickr' ][ 'options' ][ 'userid' ][ 'value' ];
$url 		= add_query_arg( 
	array(
	    'method' 			=> 'flickr.photosets.getList',
	    'api_key' 			=> $appId,
	    'user_id' 			=> $userId,
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
	wp_die ( _e ( 'Error:', 'wp-image-importer' ) . $response->get_error_message () );
}

$albums 		= wp_remote_retrieve_body( $response );
if ( $albums == '' ) {
	wp_die ( _e ( 'Error:', 'wp-image-importer' ) . $response->get_error_message () );
}

try {
	$albums = json_decode( $albums, true );
} catch ( Exception $e ) {
	wp_die( 'Parse Error: ', 'wp-image-importer' . $e->getMessage() );
}

if ( !is_array( $albums ) or empty( $albums ) ) {
	wp_die( 'Nothing found !!' );
}
$photoSet = !empty( $albums[ 'photosets' ][ 'photoset' ] ) ? $albums[ 'photosets' ][ 'photoset' ] : array();
if ( empty( $photoSet ) ) {
	wp_die( _e( 'No albums found !!', 'wp-image-importer' ) );
}

?>
<div class="<?php echo WPIIMP_PREFIX; ?>flickr-albums-wrap <?php echo WPIIMP_PREFIX; ?>albums-wrap">
	<div class="<?php echo WPIIMP_PREFIX; ?>flickr-albums-list-wrap <?php echo WPIIMP_PREFIX; ?>albums-list-wrap">
		<div class="<?php echo WPIIMP_PREFIX; ?>flickr-albums-search <?php echo WPIIMP_PREFIX; ?>albums-search">
			<input id="<?php echo WPIIMP_PREFIX; ?>album-search-input" class="<?php echo WPIIMP_PREFIX; ?>flickr-album-search-input <?php echo WPIIMP_PREFIX; ?>album-search-input" placeholder="Search albums..." type="search">
			<span class="<?php echo WPIIMP_PREFIX; ?>flickr-album-search-wrap <?php echo WPIIMP_PREFIX; ?>album-search-wrap">
				<img src="http://192.168.0.226/wordpress_4.5/wp-content/plugins/wp-image-importer/assets/images/search.png" alt="">
			</span>
		</div>
		<ul class="<?php echo WPIIMP_PREFIX; ?>flickr-album-nodes <?php echo WPIIMP_PREFIX; ?>album-nodes">
			<?php 
			foreach( $photoSet as $albumNum => $album ) {
				if ( empty( $album ) ) {
					continue;
				}

				$countText = ( $album[ 'photos' ] == '0' or $album[ 'photos' ] == '1' ) ? $album[ 'photos' ] . __( ' Image', 'wp-image-importer' ) : $album[ 'photos' ] . __( ' Images', 'wp-image-importer' );

				?>
				<li class="<?php echo WPIIMP_PREFIX; ?>flickr-album-node <?php echo WPIIMP_PREFIX; ?>album-node" data-id="<?php echo $album[ 'id' ]; ?>" data-name="<?php echo $album[ 'title' ][ '_content' ];?>" data-created="<?php echo $album[ 'date_create' ]; ?>" title="<?php echo $album[ 'title' ][ '_content' ];?>">
					<div class="<?php echo WPIIMP_PREFIX; ?>flickr-album-edge-wrap <?php echo WPIIMP_PREFIX; ?>album-edge-wrap">
						<div class="<?php echo WPIIMP_PREFIX; ?>flickr-album-design <?php echo WPIIMP_PREFIX; ?>album-design">
							<img src="<?php echo plugins_url( 'wp-image-importer/assets/images/pictures.png' );?>">
							<p title="<?php echo $album[ 'title' ][ '_content' ];?>"><?php echo $album[ 'title' ][ '_content' ];?></p>
							<span class="<?php echo WPIIMP_PREFIX; ?>album_img_count <?php echo WPIIMP_PREFIX; ?>flickr_album_img_count"><?php echo $countText;?></span>
						</div>
					</div>
				</li>
			<?php 
			}
			?>
		</ul>
	</div>
	<div class="<?php echo WPIIMP_PREFIX; ?>flickr-albums-content-wrap <?php echo WPIIMP_PREFIX; ?>albums-content-wrap <?php echo WPIIMP_PREFIX; ?>hide">
	</div>
</div>
<div class="<?php echo WPIIMP_PREFIX;?>flickr-thickbox-wrap <?php echo WPIIMP_PREFIX;?>thickbox-wrap" id="<?php echo WPIIMP_PREFIX;?>thickbox-wrap" style="display:none;">
	<div class="<?php echo WPIIMP_PREFIX;?>flickr-thickbox-content <?php echo WPIIMP_PREFIX;?>thickbox-content" id="<?php echo WPIIMP_PREFIX;?>thickbox-content">
		<div class="">
			<img src="" class="<?php echo WPIIMP_PREFIX;?>flickr-thickbox-img <?php echo WPIIMP_PREFIX;?>thickbox-img">
		</div>
		<div class="<?php echo WPIIMP_PREFIX;?>flickr_media_wrap <?php echo WPIIMP_PREFIX;?>media_wrap">
			<button class="button <?php echo WPIIMP_PREFIX;?>flickr_insert_into_media <?php echo WPIIMP_PREFIX;?>insert_into_media" data-src="">
				<?php _e( 'Insert into media library', 'wp-image-importer' ); ?>
			</button>
		</div>
	</div>
</div>