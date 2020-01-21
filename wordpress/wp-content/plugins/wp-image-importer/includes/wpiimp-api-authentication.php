<?php 
if ( ! defined( 'ABSPATH' ) ) {
	// Exit if accessed directly
	exit (); 
}

require_once WPIIMP_PATH . '/lib/origin-info.php';
$settings 	= get_option( 'wpiimp_setting' );
$attribution = '';
$pixabayAttribution = '';
if ( ! empty( $settings ) ) {
	$settings[ 'flickr' ][ 'options' ][ 'per_page' ][ 'value' ] ? $settings[ 'flickr' ][ 'options' ][ 'per_page' ][ 'value' ] : 10;
	if ( $settings[ 'flickr' ][ 'options' ][ 'attribution' ][ 'value' ] ) {
		$attribution = 'checked';
	}

	if ( $settings[ 'pixabay' ][ 'options' ][ 'attribution' ][ 'value' ] ) {
		$pixabayAttribution = 'checked';
	}
}

$fbAppId = '';
$fbSecretKey = '';
$fbOpts = get_option( 'wpiimp_fb_credentials' );
if ( !empty( $fbOpts ) ) {
	$fbAppId = $fbOpts[ 'appId' ];
	$fbSecretKey = $fbOpts[ 'secretKey' ];
}

?>
<div class="<?php echo WPIIMP_PREFIX;?>api_authentication_wrapper">
	<!--=========================================
	=            Api section header.            =
	==========================================-->
	<div class="<?php echo WPIIMP_PREFIX;?>tab-header">
		<a data-name="flickr" class="<?php echo WPIIMP_PREFIX;?>tab-flickr <?php echo WPIIMP_PREFIX;?>tab_active <?php echo WPIIMP_PREFIX;?>tab">
			<?php _e( 'FLICKR', 'wp-image-importer' ); ?>
		</a>
		<a data-name="pixabay" class="<?php echo WPIIMP_PREFIX;?>tab-pixabay <?php echo WPIIMP_PREFIX;?>tab">
			<?php _e( 'PIXABAY', 'wp-image-importer' ); ?>
		</a>
		<a data-name="facebook" class="<?php echo WPIIMP_PREFIX;?>tab-facebook <?php echo WPIIMP_PREFIX;?>tab">
			<?php _e( 'FACEBOOK', 'wp-image-importer' ); ?>
		</a>
	</div>
	<!--====  End of Api section header.  ====-->
	


	<!--=========================================
	=            Api section content            =
	==========================================-->
	<div class="<?php echo WPIIMP_PREFIX;?>tab-content-wrapper">

		<!--==========================================
		=            Flickr Section start            =
		===========================================-->
		<div class="<?php echo WPIIMP_PREFIX;?>tab-content-flickr <?php echo WPIIMP_PREFIX;?>tab-content">
			<span class="tooltip <?php echo WPIIMP_PREFIX;?>api_help"> 
				<?php _e( 'Get Flikr API key from', 'wp-image-importer' ); ?>
				<a target="_blank" href="https://www.flickr.com/services/apps/create/apply">
					<?php _e( 'here', 'wp-image-importer' ); ?>
				</a>.
			</span>
			<table class="<?php echo WPIIMP_PREFIX;?>form-table form-table">
				<tbody>	
					<tr>
						<th scope="row">
							<label for="<?php echo WPIIMP_PREFIX;?>flickr_appid">
								<?php _e( 'API Key' ) ?>
							</label>
						</th>
						<td>
							<input class="regular-text" id="<?php echo WPIIMP_PREFIX;?>flickr_appid" value="<?php echo $settings[ 'flickr' ][ 'options' ][ 'appid' ][ 'value' ]; ?>" type="text">
						</td>
					</tr>
					<tr>
						<th scope="row">
							<label for="<?php echo WPIIMP_PREFIX;?>flickr_userid">
								<?php _e( 'User Id', 'wp-image-importer' );?>
							</label>
						</th>
						<td>
							<input class="regular-text" id="<?php echo WPIIMP_PREFIX;?>flickr_userid" value="<?php echo $settings[ 'flickr' ][ 'options' ][ 'userid' ][ 'value' ]; ?>" type="text">
						</td>
					</tr>
					<tr>
						<th scope="row">
							<label for="<?php echo WPIIMP_PREFIX;?>flickr_license">
								<?php _e( 'License', 'wp-image-importer' ); ?>
							</label>
						</th>
						<td>
							<select id="<?php echo WPIIMP_PREFIX;?>flickr_license">
								<?php 
								if ( ! empty( $flickrLicense ) and is_array( $flickrLicense ) ) {
									foreach ( $flickrLicense as $key => $value ) {
										if ( empty( $value ) ) {
											continue;
										}

										$selected = '';
										if ( $key == $settings[ 'flickr' ][ 'options' ][ 'license' ][ 'value' ] ) {
											$selected = 'selected';
										}
										?>
										<option value="<?php echo $key; ?>" <?php echo $selected;?>><?php echo $value; ?></option>
									<?php
									}
								}
								?>
							</select>
						</td>
					</tr>
					<tr>
						<th scope="row">
							<label for="<?php echo WPIIMP_PREFIX;?>flickr_sort">
								<?php _e( 'Order Images By', 'wp-image-importer' ); ?>
							</label>
						</th>
						<td>
							<select id="<?php echo WPIIMP_PREFIX;?>flickr_sort">
								<?php 
								if ( !empty( $flickrSort ) and is_array( $flickrSort ) ) {
									foreach ( $flickrSort as $s_key => $s_value ) {
										if ( empty( $s_value ) ) {
											continue;
										}
										$selected = '';
										if ( $s_key == $settings[ 'flickr' ][ 'options' ][ 'sort' ][ 'value' ] ) {
											$selected = 'selected';
										}?>
										<option value="<?php echo $s_key;?>" <?php echo $selected; ?>><?php echo $s_value; ?></option>
									<?php 
									}
								}?>
							</select>
						</td>
					</tr>
					<tr>
						<th scope="row">
							<label for="flickr_per_page">
								<?php _e( 'Images Per Page', 'wp-image-importer' ); ?>
							</label>
						</th>
						<td>
							<input step="1" min="1" max="" id="<?php echo WPIIMP_PREFIX;?>flickr_per_page" value="<?php echo $settings[ 'flickr' ][ 'options' ][ 'per_page' ][ 'value' ]; ?>" title="<?php _e( 'Images per page', 'wp-image-importer' ) ?>" class="input-text qty text" size="4" onkeydown="return false" pattern="[0-9]*" inputmode="numeric" type="number">
						</td>
					</tr>
					<tr>
						<th scope="row">
							<label for="<?php echo WPIIMP_PREFIX;?>flickr_attribution">
								<?php _e( 'Attribution', 'wp-image-importer' ); ?>
							</label>
						</th>
						<td>
							<input class="button" id="<?php echo WPIIMP_PREFIX;?>flickr_attribution_s" value="<?php echo $settings[ 'flickr' ][ 'options' ][ 'attribution' ][ 'value' ];?>" <?php echo $attribution;?> type="checkbox"> 
							<label for="<?php echo WPIIMP_PREFIX;?>flickr_attribution_s" class="tooltip">
								<?php _e( 'Check to insert image source info with image while inserting into post', 'wp-image-importer' ); ?>
							</label>
						</td>
					</tr>
				</tbody>
			</table>
			<p class="submit">
				<input class="button-primary" id="<?php echo WPIIMP_PREFIX;?>save_flickr" type="button" value="<?php _e( "Save Settings", 'wp-image-importer' );?>">
			</p>
		</div>
		<!--====  End of Flickr Section  ====-->
		
		
		<!--============================================
		=            Pixabay Section starts            =
		=============================================-->
		<div class="<?php echo WPIIMP_PREFIX;?>tab-content-pixabay <?php echo WPIIMP_PREFIX;?>tab-content <?php echo WPIIMP_PREFIX;?>hide">
			<span class="tooltip"> 
				<?php _e( 'Get Pixabay API key from', 'wp-image-importer' ); ?> 
				<a target="_blank" href="https://pixabay.com/en/accounts/login/?next=/api/docs/">
					<?php _e( 'here', 'wp-image-importer' ); ?>
				</a> 
			</span>
			<table class="form-table">
				<tbody>	
					<tr>
						<th scope="row">
							<label for="<?php echo WPIIMP_PREFIX;?>pixabay_appid">
								<?php _e( 'API Key', 'wp-image-importer' ); ?>
							</label>
						</th>
						<td>
							<input class="regular-text" id="<?php echo WPIIMP_PREFIX;?>pixabay_appid" value="<?php echo $settings[ 'pixabay' ][ 'options' ][ 'appid' ][ 'value' ];?>" type="text">
						</td>
					</tr>
					<tr>
						<th scope="row">
							<label for="<?php echo WPIIMP_PREFIX;?>pixabay_image_type">
								<?php _e( 'Image Types', 'wp-image-importer' ); ?>
							</label>
						</th>
						<td>
							<select id="<?php echo WPIIMP_PREFIX;?>pixabay_image_type">
								<?php 
								if ( !empty( $pixabay_image_type ) and is_array( $pixabay_image_type ) ) {
									foreach ( $pixabay_image_type as $key => $value ) {
										if ( empty( $value ) ) {
											continue;
										}

										$selectedImgType = '';
										if ( $key == $settings[ 'pixabay' ][ 'options' ][ 'image_type' ][ 'value' ] ) {
											$selectedImgType = 'selected';
										}
										?>
										<option value="<?php _e( $key ); ?>" <?php echo $selectedImgType;?>><?php echo $value; ?></option>		
									<?php 
									}
								}
								?>
							</select>
						</td>
					</tr>
					<tr>
						<th scope="row">
							<label for="<?php echo WPIIMP_PREFIX;?>pixabay_language">
								<?php _e( 'Language', 'wp-image-importer' ); ?>
							</label>
						</th>
						<td>
							<select id="<?php echo WPIIMP_PREFIX;?>pixabay_language">
								<?php 
								if ( !empty( $pixabay_languages ) ) {
									foreach( $pixabay_languages as $shortName => $language ) {
										if ( empty( $language ) ) {
											continue;
										}

										$selected = '';
										if ( $shortName == $settings[ 'pixabay' ][ 'options' ][ 'language' ][ 'value' ] ) {
											$selected = 'selected';
										}
										?>
										<option value="<?php echo $shortName;?>" <?php echo $selected;?>><?php echo $language;?></option>
									<?php 
									}
								}
								?>
							</select>
						</td>
					</tr>
					<tr>
						<th scope="row">
							<label for="<?php echo WPIIMP_PREFIX;?>pixabay_per_page">
								<?php _e( 'Images Per Page', 'wp-image-importer' );?>
							</label>
						</th>
						<td>
							<input step="1" min="1" max="" id="<?php echo WPIIMP_PREFIX;?>pixabay_per_page" value="<?php echo $settings[ 'pixabay' ][ 'options' ][ 'per_page' ][ 'value' ]; ?>" title="<?php _e( 'Images per page', 'wp-image-importer' ) ?>" class="input-text qty text" size="4" onkeydown="return false" pattern="[0-9]*" inputmode="numeric" type="number">
						</td>
					</tr>
					<tr>
						<th scope="row">
							<label for="pixabay_orientation">
								<?php _e( 'Orientation', 'wp-image-importer' );?>
							</label>
						</th>
						<td>
							<select id="<?php echo WPIIMP_PREFIX;?>pixabay_orientation">
								<?php 
								if ( !empty( $pixabay_orientation ) and is_array( $pixabay_orientation ) ) {
									foreach ( $pixabay_orientation as $o_name => $orientation ) {
										if ( empty( $orientation ) ) {
											continue;
										}

										$orientationSelected = '';
										if ( $o_name == $settings[ 'pixabay' ][ 'options' ][ 'orientation' ][ 'value' ] ) {
											$orientationSelected = 'selected';
										}?>
										<option value="<?php echo $o_name;?>" <?php echo $orientationSelected;?>><?php echo $orientation;?></option>
									<?php 
									}
								}
								?>
							</select>
						</td>
					</tr>
					<tr>
						<th scope="row">
							<label for="pixabay_attribution">
								<?php _e( 'Attribution', 'wp-image-importer' ); ?>
							</label>
						</th>
						<td>
							<input class="button" id="pixabay_attribution_s" value="<?php echo $settings[ 'pixabay' ][ 'options' ][ 'attribution' ][ 'value' ];?>" <?php echo $pixabayAttribution; ?> type="checkbox"> 
							<label for="pixabay_attribution_s" class="tooltip">
								<?php _e( 'Check to insert image source info with image while inserting into post', 'wp-image-importer' ); ?>
							</label>
						</td>
					</tr>
				</tbody>
			</table>
			<p class="submit">
				<input class="button-primary" id="<?php echo WPIIMP_PREFIX;?>save_pixabay" type="button" value="<?php _e( 'Save Settings', 'wp-image-importer' );?>">
			</p>
		</div>
		<!--====  End of Pixabay Section  ====-->
		
		<!--============================================
		=            Facebook section start            =
		=============================================-->
		<div class="<?php echo WPIIMP_PREFIX;?>tab-content-facebook <?php echo WPIIMP_PREFIX;?>tab-content <?php echo WPIIMP_PREFIX;?>hide">
			<h4><?php _e( 'Facebook Credentials', 'wp-image-importer' ); ?></h4>
			<span class="<?php echo WPIIMP_PREFIX;?>api_help"> 
				<?php _e( 'Get your credentials from ', 'wp-image-importer' ); ?> 
				<a href="https://developers.facebook.com/">
					<?php _e( 'here', 'wp-image-importer' );?>
				</a>
			</span>
			<table class="<?php echo WPIIMP_PREFIX;?>form-table form-table">
				<tbody>
					<tr>
						<th scope="row">
							<label for="<?php echo WPIIMP_PREFIX;?>fb_app_id">
								<?php _e( 'App-ID', 'wp-image-importer' ); ?>
							</label>
						</th>
						<td>
							<input type="text" size="30" name="<?php echo WPIIMP_PREFIX;?>fb_app_id" id="<?php echo WPIIMP_PREFIX;?>fb_app_id" value="<?php echo $fbAppId;?>">
						</td>
					</tr>
					<tr>
						<th scope="row">
							<label for="<?php echo WPIIMP_PREFIX;?>fb_secret_key">
								<?php _e( 'Secret Key', 'wp-image-importer' ); ?>
							</label>
						</th>
						<td>
							<input type="text" size="30" name="<?php echo WPIIMP_PREFIX;?>fb_secret_key" id="<?php echo WPIIMP_PREFIX;?>fb_secret_key" value="<?php echo $fbSecretKey;?>">
						</td>
					</tr>
					<tr>
						<td>
							<?php if ( ! isset( $_SESSION[ 'fb_access_token' ] ) ) {?>
								<input class="button button-primary button-large" type="button" id="<?php echo WPIIMP_PREFIX;?>fb_credential_saving" value="<?php _e( 'Authenticate', 'wp-image-importer' ); ?>">
							<?php } else { ?>
								<input class="button button-primary button-large" type="button" value="<?php _e( 'Authenticated', 'wp-image-importer' ); ?>">
							<?php } ?>
						</td>
					</tr>
				</tbody>
			</table>
		</div>
		<!--====  End of facebook section  ====-->
	</div>
	<!--====  End of Api section content.  ====-->
</div>
