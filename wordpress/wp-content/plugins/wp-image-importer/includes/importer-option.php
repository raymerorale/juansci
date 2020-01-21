<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

$wpiimp_active_tab = '';
if ( isset( $_GET[ 'page' ] ) and $_GET[ 'page' ] == 'WPIIMP' ) {
	$wpiimp_active_tab = isset( $_GET ['tab'] ) ? $_GET ['tab'] : 'settings';
}
if(isset($_GET["ced_wii_close"]) && $_GET["ced_wii_close"])
	{
		unset($_GET["ced_wii_close"]);
		if(!session_id())
			session_start();
		$_SESSION["ced_image_importer_hide_email"]=true;
	}
?>
<div class="ced_image_importer_main_wrapper">
	<div class="wrap <?php echo WPIIMP_PREFIX;?>welcome">
		<div class="<?php echo WPIIMP_PREFIX;?>loader_wrap <?php echo WPIIMP_PREFIX;?>hide">
			<div class="<?php echo WPIIMP_PREFIX;?>spinner <?php echo WPIIMP_PREFIX;?>hide"></div>
			<div class="<?php echo WPIIMP_PREFIX;?>bar_cloning_loader_wrapper <?php echo WPIIMP_PREFIX;?>hide">
				<div class="<?php echo WPIIMP_PREFIX;?>bar_cloning_loader">
					<div class="<?php echo WPIIMP_PREFIX;?>clone_loader">
						<img src="<?php echo plugins_url( "wp-image-importer/assets/images/picture.png" ); ?>" alt="">
					</div>
					<div class="<?php echo WPIIMP_PREFIX;?>clone_loader0">
						<img src="<?php echo plugins_url( "wp-image-importer/assets/images/picture.png" ); ?>" alt="">
					</div>
					<div class="<?php echo WPIIMP_PREFIX;?>clone_loader_box <?php echo WPIIMP_PREFIX;?>clone_loader1">
						<img src="<?php echo plugins_url( "wp-image-importer/assets/images/share.png" ); ?>" alt="">
					</div>
					<div class="<?php echo WPIIMP_PREFIX;?>clone_loader_box <?php echo WPIIMP_PREFIX;?>clone_loader2">
						<img src="<?php echo plugins_url( "wp-image-importer/assets/images/wordpress.png" ); ?>" alt="">
					</div>
				</div>
				<div class="<?php echo WPIIMP_PREFIX;?>circle_loader"></div>
			</div>
		</div>


		<div class="ced_iimp_fixed_wrapper">
			<div class="<?php echo WPIIMP_PREFIX;?>messages">	
			</div>
			<h1><?php _e( 'WP Image Importer', 'wp-image-importer' );?></h1>
			<div class="about-text">
				<?php _e( 'WP Image Importer plugin allows to easily import images into posts', 'wp-image-importer' );?>
			</div>
			<div class="nav-tab-wrapper <?php echo WPIIMP_PREFIX;?>tabs-wrapper">
				<a href="?page=<?php echo SLUG?>&amp;tab=settings" class="nav-tab <?php echo $wpiimp_active_tab == 'settings' ? 'nav-tab-active' : ''; ?>">
					<img src="<?php echo plugins_url( "wp-image-importer/assets/images/settings.png" ); ?>">
					<?php _e( 'Settings', 'wp-image-importer' ); ?>
				</a>

				<a href="?page=<?php echo SLUG?>&amp;tab=fb_albumns" class="nav-tab <?php echo $wpiimp_active_tab == 'fb_albumns' ? 'nav-tab-active' : ''; ?>">
					<img src="<?php echo plugins_url( "wp-image-importer/assets/images/album.png" ); ?>">
					<?php _e( 'FB Albums', 'wp-image-importer' ); ?>
				</a>
				
				<a href="?page=<?php echo SLUG?>&amp;tab=flickr_albumns" class="nav-tab <?php echo $wpiimp_active_tab == 'flickr_albumns' ? 'nav-tab-active' : ''; ?>">
					<img src="<?php echo plugins_url( "wp-image-importer/assets/images/album.png" ); ?>">
					<?php _e( 'Flickr Albums', 'wp-image-importer' ); ?>
				</a>

				<a href="?page=<?php echo SLUG?>&amp;tab=suggestions" class="nav-tab <?php echo $wpiimp_active_tab == 'suggestions' ? 'nav-tab-active' : ''; ?>">
					<img src="<?php echo plugins_url( "wp-image-importer/assets/images/ideas.png" ); ?>">
					<?php _e( 'Suggestions', 'wp-image-importer' ); ?>
				</a>
				
				<a href="?page=<?php echo SLUG?>&amp;tab=support" class="nav-tab <?php echo $wpiimp_active_tab == 'support' ? 'nav-tab-active' : ''; ?>">
					<img src="<?php echo plugins_url( "wp-image-importer/assets/images/technical-support.png" ); ?>">
					<?php _e( 'Support', 'wp-image-importer' ); ?>
				</a>
			</div>
		</div>
		<?php 
		if ( $wpiimp_active_tab == "settings" ) {
			require_once WPIIMP_PATH . '/includes/wpiimp-api-authentication.php';
		} elseif ( $wpiimp_active_tab == 'fb_albumns' ) {
			require_once WPIIMP_PATH . '/includes/wpiimp-fb-album.php';
		} elseif ( $wpiimp_active_tab == 'flickr_albumns' ) {
			require_once WPIIMP_PATH . '/includes/wpiimp-flickr-album.php';
		} elseif ( $wpiimp_active_tab == 'suggestions' ) {
			require_once WPIIMP_PATH . '/includes/wpiimp-suggestions.php';
		} elseif ( $wpiimp_active_tab == 'support' ) {?>
			<div class="section-body">
				<p>
					<?= _e( 'Thank you for choosing WP Image Importer - plugin', 'wp-image-importer' )?>
				</p>
				<p>
					<?= _e( 'Feel free to contact us via email: ', 'wp-image-importer' );?>
					<strong>plugins@cedcommerce.com</strong>
				</p>
	  			<p> 
	  				<?= _e( 'More infomation: ', 'wp-image-importer' );?>
	  				<a href="http://cedcommerce.com">http://cedcommerce.com</a>
	  			</p>
	  		</div>
		<?php }?>
	</div>
	<?php
	if(!session_id())
		session_start();
	if(!isset($_SESSION["ced_image_importer_hide_email"])):
		$actual_link = "http://".$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI'];
		$urlvars = parse_url($actual_link);
		$url_params = $urlvars["query"];
	?>
	<div class="ced_image_importer_email_image">
		<div class="ced_image_importer_email_main_content">
			<div class="ced_image_importer_cross_image">
			<a class="button-primary ced_image_importer_cross_image" href="?<?php echo $url_params?>&ced_wii_close=true"></a>
			</div>
			<input type="text" value="" class="ced_image_importer_email_field" placeholder="<?php _e("enter your e-mail address","wp-image-importer")?>"/> 
			<a id="ced_image_importer_send_email" href=""><?php _e("Know More","wp-image-importer")?></a>
			<p></p>
			<div class="hide"  id="ced_image_importer_loader">	
				<img id="ced-image-importer-loading-image" src="<?php echo plugins_url().'/wp-image-importer/assets/images/ajax-loader.gif'?>" >
			</div>
			<div class="ced_image_importer_banner">
			<a target="_blank" href="https://cedcommerce.com/offers#woocommerce-offers"><img src="<?php echo plugins_url().'/wp-image-importer/assets/images/ebay.jpg'?>"></a>
			</div>
		</div>
	</div>
	<?php endif;?>
</div>
